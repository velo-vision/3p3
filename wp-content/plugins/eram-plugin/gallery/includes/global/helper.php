<?php
/**
 * Eram Gallery Helper Functions
 *
 * @since 1.0.0
 *
 * @package Eram Gallery
 * @author  owwwlab
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * This is used to make page type available via ajax
 * eram_gallery_infinite_scroll function sets this
 *
 * @var string $eram_gallery_page_is
 */
global $eram_gallery_page_is;

/**
 * This is used to make queried options available via ajax
 * eram_gallery_infinite_scroll function sets this
 *
 * @var string $eram_gallery_page_is
 */
global $eram_queried_options;


/**
 * load gallery helper
 */
if ( ! function_exists( 'gallery_helper' ) ) {

    /**
     * @param null $object_id : post id or term slug or "gallery_archive"
     * @return bool
     */
    function gallery_helper( $object_id = NULL )
    {
        global $eram_gallery_page_is;
        $page_is = $eram_gallery_page_is;

        // get images from metabox
        if ( is_singular( ERAM_GALLERY_CPT_NAME ) || $page_is == 'is_singular' ) {
            $imgIDs_array = eg_get_gallery_images( $object_id );
            $gallery_layout = eg_get_gallery_option( 'eg_gallery_layout', 'simple-horizontal', $object_id );
        }
        elseif ( is_tax( ERAM_GALLERY_CATEGORY_TAX ) || $page_is == 'is_tax' ) {

            $imgIDs_array = eg_get_archive_images( $object_id );
            $gallery_layout = eg_get_gallery_option( 'eg_archive_layout', 'simple-horizontal', $object_id );
        }
        elseif ( is_post_type_archive( ERAM_GALLERY_CPT_NAME ) || $page_is == 'is_archive' ) {
            $imgIDs_array = eg_get_archive_images();
            $gallery_layout = eg_get_gallery_option( 'eg_archive_layout', 'simple-horizontal', $object_id );
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


/**
 * Get All Image ids associated to a single gallery post
 *
 * @param $post_id
 * @return array
 */
function eg_get_gallery_images( $post_id )
{
    // get images from metabox
    $imgIDs_string = eg_get_gallery_option( 'eg_photos', '', $post_id );

    $imgIDs_array = explode( ',', $imgIDs_string );

    return $imgIDs_array;
}


/**
 * Get all Featured Images of posts in a tax or archive
 *
 * @param string $term_slug : is used when the wp_query is not available i.e. AJAX
 * @return array
 */
function eg_get_archive_images( $term_slug = '' )
{
    $imgs = array();
    $conf = array(
        'post_type'   => ERAM_GALLERY_CPT_NAME,
        'numberposts' => -1
    );

    global $eram_gallery_page_is;
    $page_is = $eram_gallery_page_is;

    if ( is_tax() || $page_is == 'is_tax' ) {

        $conf['tax_query'] = array(
            array(
                'taxonomy'         => ERAM_GALLERY_CATEGORY_TAX,
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
if ( ! function_exists( 'eg_get_gallery_option' ) ) {
    /**
     * @param $key : setting key
     * @param $default : default value of the setting
     * @param null $object_id : is the post id or the tax slug
     * @param false $global : this flag tells the function that this option is global
     * @return mixed|string
     */
    function eg_get_gallery_option( $key, $default = '', $object_id = NULL, $is_general = FALSE)
    {
        global $eram_gallery_page_is;
        global $eram_queried_options;

        // try to use Global $page_is
        $page_is = $eram_gallery_page_is;

        $use_get = FALSE;
        $use_queried_options = FALSE;
        $option = $default;

        // check if we have url parameter for this
        if ( isset( $_GET[ $key ] ) ) {
            $use_get = TRUE;
        }
        elseif ( isset( $eram_queried_options[ $key ] ) ) {
            $use_queried_options = TRUE;
        }

        if ( $use_get ) {
            $option = sanitize_text_field( wp_unslash( $_GET[ $key ] ) );
        }
        elseif ( $use_queried_options ) {
            $option = sanitize_text_field( wp_unslash( $eram_queried_options[ $key ] ) );
        }
        else {
            if( $is_general )
            {
                // this is a general option and not specific for archive or a category
                $option = Eram_Kirki::get_option( 'eg_settings', $key , $default );
            }
            elseif ( is_singular( ERAM_GALLERY_CPT_NAME ) || $page_is == 'is_singular' ) {
                $option = get_post_meta( $object_id, $key, TRUE );
            }
            elseif ( is_tax( ERAM_GALLERY_CATEGORY_TAX ) || $page_is == 'is_tax' ) 
            {
                $option = Eram_Kirki::get_option( 'eg_settings', $key . '__' . $object_id . '_eg_cat', $default );
            }
            else{
                $option = Eram_Kirki::get_option( 'eg_settings', $key, $default );
            }
        }


        if ( is_null( $option ) || $option == '' ) {
            $option = $default;
        }

        // convert on-off at option tree to true/false as customizer doese
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
 * gallery infinite scroll hook
 */
if ( ! function_exists( 'eram_gallery_infinite_scroll' ) ) {
    function eram_gallery_infinite_scroll()
    {
        global $eram_gallery_page_is;
        global $eram_queried_options;

        if ( ! empty( $_POST['options'] ) ) {
            parse_str( sanitize_text_field( wp_unslash( $_POST['options'] ) ), $eram_queried_options );
        }

        $object_id = '';
        if ( ! empty( $_POST['post_id'] ) ) {
            $object_id = sanitize_text_field( wp_unslash( $_POST['post_id'] ) );
        }

        $page_is = sanitize_text_field( wp_unslash( $_POST['page_is'] ) );

        if ( empty ( $object_id ) && empty ( $page_is ) ){
            echo 0;
            die();
        }

        $eram_gallery_page_is = $page_is;

        $eram_gallery = gallery_helper( $object_id );


        $out = '';
        foreach ( $eram_gallery->get_gallery_image_ids() as $ref_id => $imgID ) {
            $out .= $eram_gallery->get_image_markup( $imgID, $ref_id );
        }
        echo $out;

        die();
    }
}

// for logged in user
add_action( 'wp_ajax_eram_gallery_infinite_scroll', 'eram_gallery_infinite_scroll' );
// if user not logged in
add_action( 'wp_ajax_nopriv_eram_gallery_infinite_scroll', 'eram_gallery_infinite_scroll' );



/**
 * Save Metabox Ajax for Eram gallery Customizer
 */
if ( ! function_exists( 'eg_ajax_save_metabox' ) ) {
    function eg_ajax_save_metabox()
    {
        if ( ! is_admin() )
            die ( 'Busted!' );


        $nonce = $_POST['save_nounce'];
        if ( ! wp_verify_nonce( $nonce, 'eg_ajax-save-nonce' ) )
            die ( 'Busted!' );

        if ( ! current_user_can( 'edit_others_pages' ) )
            die ( 'Busted!' );

        // we need to somehow scape passed data
        $post_id = sanitize_text_field( wp_unslash( $_POST['post_id'] ) );

        // prepare $_POST['meta_data']
        $data = sanitize_text_field( wp_unslash( urldecode( $_POST['meta_data'] ) ) );
        $separate_data = explode( '&', $data );

        $separated_metas = array();
        // foreach meta_data
        foreach ( $separate_data as $metadata ) {
            $meta = explode( '=', $metadata );
            $separated_metas[ $meta[0] ] = $meta[1];
        }

        // what if a already accepted photo is removed from gallery
        $separated_metas['eg_proof_accepted_imgs'] = eram_correct_accepted_images( $separated_metas['eg_proof_accepted_imgs'], $separated_metas['eg_photos'] );


        // save
        $meta_array=array();
        foreach ( $separated_metas as $key => $value ) {

            if ( substr( $key, 0, 18 ) === "ep_gallery_clients" ){
                $meta_array['ep_gallery_clients'][$value]=(string)$value;
            }else{
                update_post_meta( $post_id, $key, $value );
            }

        }
        // update meta_array too
        update_post_meta( $post_id, 'ep_gallery_clients', $meta_array['ep_gallery_clients'] );

        die( 'saved!' );
    }
}

add_action( 'wp_ajax_eram_gallery_save_customizer', 'eg_ajax_save_metabox' );
add_action( 'wp_ajax_eram_gallery_save_customizer', 'eg_ajax_save_metabox' );


function eram_correct_accepted_images( $all, $accepted )
{
    $all = explode( ',', $all );
    $accepted = explode( ',', $accepted );

    return implode( ',', array_intersect( $all, $accepted ) );
}


// add featured thumbnail to admin post columns
function eram_gallery_add_columns( $columns )
{
    $columns['gallery_cover'] = __( 'Cover', 'eram' ) ;

    return $columns;
}

function eram_gallery_add_columns_data( $column, $post_id )
{
    switch ( $column ) {
        case 'gallery_cover':
            $url = get_the_post_thumbnail_url($post_id,'thumbnail');
            if ( ! $url )
                $url = ERAM_IMAGES . '/no-image.jpg';
            echo '<a href="' . get_edit_post_link() . '">';
            echo '<img src="' . $url . '" width="40" height="40" />';
            echo '</a>';
            break;
    }
}

if ( function_exists( 'add_theme_support' ) ) {
    add_filter( 'manage_' . ERAM_GALLERY_CPT_NAME . '_posts_columns', 'eram_gallery_add_columns' );
    add_action( 'manage_' . ERAM_GALLERY_CPT_NAME . '_posts_custom_column', 'eram_gallery_add_columns_data', 10, 2 );
}


/**
 * Display a custom taxonomy dropdown in admin
 */
add_action('restrict_manage_posts', 'eram_filter_post_type_by_taxonomy');
function eram_filter_post_type_by_taxonomy() {
    global $typenow;
    $post_type = ERAM_GALLERY_CPT_NAME;
    $taxonomy  = ERAM_GALLERY_CATEGORY_TAX;
    if ($typenow == $post_type) {
        $selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
        $info_taxonomy = get_taxonomy($taxonomy);
        wp_dropdown_categories(array(
            'show_option_all' => __("Show All {$info_taxonomy->label}"),
            'taxonomy'        => $taxonomy,
            'name'            => $taxonomy,
            'orderby'         => 'name',
            'selected'        => $selected,
            'show_count'      => true,
            'hide_empty'      => true,
        ));
    };
}

/**
 * Filter posts by taxonomy in admin
 */
add_filter('parse_query', 'eram_convert_id_to_term_in_query');
function eram_convert_id_to_term_in_query($query) {
    global $pagenow;
    $post_type = ERAM_GALLERY_CPT_NAME;
    $taxonomy  = ERAM_GALLERY_CATEGORY_TAX;
    $q_vars    = &$query->query_vars;
    if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
        $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
        $q_vars[$taxonomy] = $term->slug;
    }
}

/**
 * Gallery lightbox theme body class
 */
add_filter('body_class', 'eram_gallery_add_body_class');
if ( ! function_exists('eram_gallery_add_body_class'))
{
    function eram_gallery_add_body_class($class)
    {
        // get theme 
        $lg_theme = Eram_Kirki::get_option('eg_settings','eg_lg_theme','none');
        switch ($lg_theme){
            case 'light':
                $class[] = 'eram-lightbox-light';
                break;
            case 'dark':
                $class[] = 'eram-lightbox-dark';
                break;
            default:
                // get theme color
                $theme_color = Eram_Kirki::get_option('eram_theme_options','eram_color_theme','light');
                $class[] = 'eram-lightbox-'.$theme_color;
        }

        return $class;
    }
}

