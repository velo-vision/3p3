<?php
/**
 * EramGallery_Metabox class.
 *
 * @since 1.0.0
 *
 * @package Eram Gallery
 * @author  owwwlab
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class EramProofGallery_Metabox
{

    /**
     * Holds the class object.
     *
     * @since 1.0.0
     *
     * @var object
     */
    public static $instance;

    public function __construct()
    {
        // initialize metaboxes
        add_action( 'admin_init', array( $this, 'add_gallery_meta_boxes' ) );


    }



    public function add_gallery_meta_boxes()
    {
        $email_default = 'This is a notification from #{website}
----
A customer updated accepted photos for #{gallery} gallery.
Please take necessary actions needed.

Regards
#{website} Administrator';
        /**
         * Create a custom meta boxes array that we pass to
         * the OptionTree Meta Box API Class.
         */
        $settings_meta_box = array(
            'id'       => 'eram_proof_gallery_meta_box',
            'title'    => __( 'Gallery Settings', 'eram' ),
            'desc'     => '',
            'pages'    => array( ERAM_PROOF_GALLERY_CPT_NAME ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields'   => array(

                /*
                 * Gallery Photos
                 * _epg_photos
                */
                array(
                    'label' => __( 'Manage Photos', 'eram' ),
                    'id'    => '_epg_photos',
                    'type'  => 'gallery',
                    'desc'  => '',
                    'std'   => '',
                    'class' => '',
                ),

                /*
                 * Accepted image ids
                 * _epg_proof_accepted_imgs
                */
                array(
                    'label'     => __( 'Accepted Photo IDs', 'eram' ),
                    'id'        => '_epg_proof_accepted_imgs',
                    'type'      => 'text',
                    'desc'      => __( "Comma separated IDs of accepted photos, This field will be populated when a client accepts some photos.", 'eram' ),
                    'std'       => '',
                    'class'     => 'em-hidden-field',
                    'condition' => '',
                    'operator'  => 'and',
                ),

                /*
                 * Event date
                 * _epg_proof_accepted_imgs
                */
                array(
                    'label'     => __( 'Event Date', 'eram' ),
                    'id'        => '_epg_event_date',
                    'type'      => 'date-picker',
                    'desc'      => __( "Pick the date of the event or leave blank if you don't want to show date.", 'eram' ),
                    'std'       => '',
                    'class'     => '',
                    'condition' => '',
                    'operator'  => 'and',
                ),

                /*
                 * Event date
                 * _epg_proof_accepted_imgs
                */
                array(
                    'label'     => __( 'Downloadable File', 'eram' ),
                    'id'        => '_epg_download_file',
                    'type'      => 'upload',
                    'desc'      => __( "You can upload a zip file containing photos that you want the client to download all gallery photos. Leave blank if you don't need this", 'eram' ),
                    'std'       => '',
                    'class'     => '',
                    'condition' => '',
                    'operator'  => 'and',
                ),




                /*
                 * Notify
                 * _epg_gallery_proof_mode
                */
                array(
                    'label'     => __( 'Notify Upon Submission', 'eram' ),
                    'id'        => '_epg_gallery_proof_notify',
                    'type'      => 'on-off',
                    'desc'      => __( "In case you want to be notified when a client submits accepted photos of this gallery, turn this on.", 'eram' ),
                    'std'       => 'off',
                    'class'     => '',
                    'condition' => '',
                ),

                /*
                 * Notify email
                 * _epg_gallery_proof_email
                */
                array(
                    'label'     => __( 'Contact Email', 'eram' ),
                    'id'        => '_epg_gallery_proof_email',
                    'type'      => 'text',
                    'desc'      => __( 'Email of the person who gets notified when a customer submits accepted photos of this gallery.', 'eram' ),
                    'std'       => get_option( 'admin_email' ),
                    'class'     => '',
                    'condition' => '_epg_gallery_proof_notify:is(on),',
                ),

                /*
                 * Notify subject
                 * _epg_gallery_proof_email
                */
                array(
                    'label'     => __( 'Email Subject', 'eram' ),
                    'id'        => '_epg_gallery_proof_notify_subject',
                    'type'      => 'text',
                    'desc'      => __("The Subject line of notificatoin email.",'eram'),
                    'std'       => __( 'Gallery Approval Update Notification', 'eram' ),
                    'class'     => '',
                    'condition' => '_epg_gallery_proof_notify:is(on),',
                ),

                /*
                 * Notify content
                 * _epg_gallery_proof_notify_mail
                */
                array(
                    'label'     => __( 'Email Content', 'eram' ),
                    'id'        => '_epg_gallery_proof_notify_mail',
                    'type'      => 'textarea',
                    'desc'      => __( 'The content of notification email.<br> <code>#{website}</code> and <code>#{gallery}</code> will be replaced by your site name and gallery name automatically.', 'eram' ),
                    'std'       => $email_default,
                    'class'     => '',
                    'condition' => '_epg_gallery_proof_notify:is(on),',
                ),

                /*
                * columns
                * _epg_masonry_cols
                */
                array(
                    'label'        => __( 'Number of Columns', 'eram' ),
                    'id'           => '_epg_masonry_cols',
                    'type'         => 'numeric-slider',
                    'desc'         => __( 'Specify the number of columns for masonry layout of gallery.', 'eram' ),
                    'std'          => '3',
                    'class'        => '',
                    'condition'    => '',
                    'operator'     => 'and',
                    'min_max_step' => '2,4,1',
                ),



            )
        );

        /**
         * Register our meta boxes using the
         * ot_register_meta_box() function.
         */
        if ( function_exists( 'ot_register_meta_box' ) )
            ot_register_meta_box( $settings_meta_box );


    }


    

    /**
     * Returns the singleton instance of the class.
     *
     * @since 1.0.0
     *
     * @return object The EramGallery_Metabox object.
     */
    public static function get_instance()
    {

        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;

    }
}

// Load the metaboxes class.
$eramProofGallery_metabox = EramProofGallery_Metabox::get_instance();
