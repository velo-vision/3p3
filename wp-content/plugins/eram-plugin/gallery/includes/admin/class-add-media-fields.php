<?php
/**
 * Eg_Add_Customizer class.
 *
 * @since 1.0.0
 *
 * @package Eram Gallery
 * @author  owwwlab
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Eg_Add_Media_Fields
 */
class Eg_Add_Media_Fields
{

    public function __construct()
    {
        add_filter( "attachment_fields_to_edit", array( $this, "add_image_attachment_fields_to_edit" ), 10000, 2 );
        add_filter( "attachment_fields_to_save", array( $this, "add_image_attachment_fields_to_save" ), 100, 2 );
    }

    /**
     * Add custom media metadata fields
     *
     * Be sure to sanitize your data before saving it
     * http://codex.wordpress.org/Data_Validation
     *
     * @param $form_fields An array of fields included in the attachment form
     * @param $post The attachment record in the database
     * @return An $form_fields The final array of form fields to use
     */
    public function add_image_attachment_fields_to_edit( $form_fields, $post )
    {


        if ( substr( $post->post_mime_type, 0, 5 ) == 'image' ) {


            // Add a video field
            $form_fields["eg_video_url"]["label"] = __( "External Video Url", 'eramgallery' );
            $form_fields["eg_video_url"]["input"] = "text";
            $form_fields["eg_video_url"]["value"] = esc_url( get_post_meta( $post->ID, "_eg_video_url", TRUE ) );
            $form_fields["eg_video_url"]["helps"] = __( "Url from YouTube or Vimeo", 'eramgallery' );

            // Add a purchase URL field
            $form_fields["eg_purchase_url"]["label"] = __( "Purchase Url", 'eramgallery' );
            $form_fields["eg_purchase_url"]["input"] = "text";
            $form_fields["eg_purchase_url"]["value"] = esc_url( get_post_meta( $post->ID, "_eg_purchase_url", TRUE ) );
            $form_fields["eg_purchase_url"]["helps"] = __( "Input the purchase url for this image. This can be the URL from your WooCommerce or any external market like 500px URL.", 'eramgallery' );

        }

        return $form_fields;

    }

    /**
     * Save custom media metadata fields
     *
     * Be sure to validate your data before saving it
     * http://codex.wordpress.org/Data_Validation
     *
     * @param $post : The $post data for the attachment
     * @param $attachment : The $attachment part of the form $_POST ($_POST[attachments][postID])
     * @return mixed $post
     */
    public function add_image_attachment_fields_to_save( $post, $attachment )
    {
        // has video url to be saved
        if ( isset( $attachment['eg_video_url'] ) ) {
            update_post_meta( $post['ID'], '_eg_video_url', esc_url_raw( $attachment['eg_video_url'] ) );
        }

        // has purchase url to be saved
        if ( isset( $attachment['eg_purchase_url'] ) ) {
            update_post_meta( $post['ID'], '_eg_purchase_url', esc_url_raw( $attachment['eg_purchase_url'] ) );
        }

        return $post;
    }

}

$eg_add_media_fields = new Eg_Add_Media_Fields();