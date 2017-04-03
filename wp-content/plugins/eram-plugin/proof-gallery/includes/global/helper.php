<?php
/**
 * Eram Proof Gallery Helper Functions
 *
 * @since 1.0.0
 *
 * @package Eram Gallery
 * @author  owwwlab
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if ( ! function_exists('proof_gallery_helper'))
{
    function proof_gallery_helper($object_id = NULL )
    {

        //require_once( dirname( __FILE__ ) . '/galleries/loader.php' );

        // get images from metabox
        if ( is_singular( ERAM_PROOF_GALLERY_CPT_NAME )) {
            $imgIDs_array = eg_get_proof_gallery_images( $object_id );
            $gallery_layout = 'proofing';
        }
        elseif ( is_tax( ERAM_PROOF_GALLERY_CATEGORY_TAX )) {

            $imgIDs_array = eg_get_proof_archive_images( $object_id );
            $gallery_layout = 'v_masonry';
        }
        elseif ( is_post_type_archive( ERAM_PROOF_GALLERY_CPT_NAME ) ) {
            $imgIDs_array = eg_get_proof_archive_images();
            $gallery_layout = 'v_masonry';
        }
        else {
            $imgIDs_array = '';
            $gallery_layout = '';
        }
        
        $class_to_load = 'eg_' . $gallery_layout . '_class';
        if ( ! class_exists( $class_to_load ) ) {
            $class_to_load = 'eg_class';
        }
        
        $return = '' != $imgIDs_array ? $class_to_load::get_instance( $object_id, $imgIDs_array ) : FALSE;

        return $return;
    }
}

function eg_get_proof_gallery_images( $post_id )
{
    // get images from metabox
    $imgIDs_string = get_post_meta( $post_id, '_epg_photos', TRUE );

    $imgIDs_array = explode( ',', $imgIDs_string );

    return $imgIDs_array;
}

function eg_get_proof_archive_images( $term_slug = '' )
{
    $imgs = array();
    $conf = array(
        'post_type'   => ERAM_PROOF_GALLERY_CPT_NAME,
        'numberposts' => -1
    );

    if ( is_tax() ) {

        $conf['tax_query'] = array(
            array(
                'taxonomy'         => ERAM_PROOF_GALLERY_CATEGORY_TAX,
                'field'            => 'slug',
                'terms'            => $term_slug,
                'include_children' => TRUE
            )
        );
    }

    $posts = get_posts( $conf );

    foreach ( $posts as $post ) {
        $imgs[ $post->ID ] = get_post_thumbnail_id( $post->ID );
    }

    return $imgs;
}


/**
 * Get a single meta value of a post
 */
if ( ! function_exists( 'eg_get_proof_gallery_option' ) ) {
    /**
     * @param $key : setting key
     * @param $default : default value of the setting
     * @param null $object_id : is the post id or the tax slug
     * @return mixed|string
     */
    function eg_get_proof_gallery_option( $key, $default = '', $object_id = NULL )
    {

        $option = get_post_meta( $object_id, $key, TRUE );


        if ( is_null( $option ) || $option == '' ) {
            $option = $default;
        }

        // convert on-off at option tree to true/false as customizer dose
        if ( $option == 'on' ) {
            $option = TRUE;
        }
        elseif ( $option == 'off' ) {
            $option = FALSE;
        }

        return $option;
    }
}


/**
 * gallery proofing hook
 */

if ( ! function_exists( 'eram_gallery_proofing_update' ) ) {
    function eram_gallery_proofing_update()
    {
        global $eram_gallery_page_is;
        $eram_gallery_page_is = 'is_singular';

        $object_id = '';
        if ( ! empty( $_POST['post_id'] ) ) {
            $object_id = sanitize_text_field( wp_unslash( $_POST['post_id'] ) );
        }

        $img_ids = '';
        if ( ! empty( $_POST['img_ids'] ) ) {
            $img_ids = sanitize_text_field( wp_unslash( $_POST['img_ids'] ) );
        }


        if ( empty ( $object_id ) )
            return FALSE;


        update_post_meta( $object_id, '_epg_proof_accepted_imgs', $img_ids );

        $status = TRUE;
        $msg = __( 'Submission was successful!', 'eram' );
        if ( eg_get_proof_gallery_option( '_epg_gallery_proof_notify', FALSE, $object_id ) ) {
            $to = eg_get_proof_gallery_option( '_epg_gallery_proof_email', get_option( 'admin_email' ), $object_id );
            if ( ! is_email( $to ) ) {
                $to = get_option( 'admin_email' );
            }
            $subject = eg_get_proof_gallery_option( '_epg_gallery_proof_notify_subject', __( 'Gallery Approval Update Notification', 'eramgallery' ), $object_id );
            $message = eg_get_proof_gallery_option( '_epg_gallery_proof_notify_mail', sprintf( __( 'This is a notification from %s. A customer updated accepted photos for %s gallery.', 'eramgallery' ), '#{website}<br>', '#{gallery}' ), $object_id );
            $message = str_replace( "#{website}", get_option( 'blogname' ), $message );
            $message = str_replace( "#{gallery}", get_the_title( $object_id ), $message );

            $status = FALSE;
            $msg = __( 'Saved, but could not send notification email.', 'eram' );
            if ( wp_mail( $to, $subject, $message ) ) {
                $status = TRUE;
                $msg = __( 'Submission was successful!', 'eram' );
            }
        }

        echo json_encode( array(
            'status' => $status,
            'msg'    => $msg
        ) );

        die();
    }
}

// for logged in user
add_action( 'wp_ajax_eram_gallery_proofing_update', 'eram_gallery_proofing_update' );
// if user not logged in
add_action( 'wp_ajax_nopriv_eram_gallery_proofing_update', 'eram_gallery_proofing_update' );

