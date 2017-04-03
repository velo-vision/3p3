<?php
/**
 * Eram_Client_Metabox class.
 *
 * @since 1.0.0
 *
 * @package Eram Plugin
 * @author  owwwlab
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Eram_Client_Metabox
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
        add_action( 'admin_init', array( $this, 'add_client_galleries' ) );
        
        // initialize metaboxes
        add_action( 'admin_init', array( $this, 'add_about_client' ) );

        // initialize metaboxes
        add_action( 'admin_init', array( $this, 'add_side_meta' ) );

    }

    public function add_client_galleries()
    {
        /**
         * Create a custom meta boxes array that we pass to
         * the OptionTree Meta Box API Class.
         */
        $settings_meta_box = array(
            'id'       => 'eram_client_galleries_meta_box',
            'title'    => __( 'Proof Galleries', 'eram' ),
            'desc'     => '',
            'pages'    => array( ERAM_CLIENT_CPT_NAME ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields'   => array(
                array(
                    'id'          => '_ec_galleries',
                    'label'       => __( 'Assign Proof Galleries', 'eram' ),
                    'desc'        => __( 'Here you can assign one/multiple proof galleries to a client. Selected Galleries will be listed at the clients page. Search by typing the title of a Proof Gallery.', 'eram' ),
                    'std'         => '',
                    'type'        => 'proof-gallery-select',
                    'section'     => '',
                    'rows'        => '6',
                    'post_type'   => '',
                    'taxonomy'    => '',
                    'min_max_step'=> '',
                    'class'       => '',
                    'condition'   => '',
                    'operator'    => 'and'
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

    public function add_about_client()
    {
        /**
         * Create a custom meta boxes array that we pass to
         * the OptionTree Meta Box API Class.
         */
        $settings_meta_box = array(
            'id'       => 'eram_client_meta_box',
            'title'    => __( 'About Client', 'eram' ),
            'desc'     => '',
            'pages'    => array( ERAM_CLIENT_CPT_NAME ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields'   => array(
                array(
                    'id'          => '_ec_photo',
                    'label'       => __( 'Client Photo', 'eram' ),
                    'desc'        => __( 'Usually photo of a person or a logo maybe, a familiar image to your client.', 'eram' ),
                    'std'         => '',
                    'type'        => 'upload',
                    'section'     => '',
                    'rows'        => '',
                    'post_type'   => '',
                    'taxonomy'    => '',
                    'min_max_step'=> '',
                    'class'       => 'ot-upload-attachment-id',
                    'condition'   => '',
                    'operator'    => 'and'
                ),
                array(
                    'id'          => '_ec_about',
                    'label'       => __( 'About Client', 'eram' ),
                    'desc'        => __( 'Write something nice about your client.', 'eram' ),
                    'std'         => '',
                    'type'        => 'textarea-simple',
                    'section'     => '',
                    'rows'        => '6',
                    'post_type'   => '',
                    'taxonomy'    => '',
                    'min_max_step'=> '',
                    'class'       => '',
                    'condition'   => '',
                    'operator'    => 'and'
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
     * Adds Extra setting
     *
     * @since 1.0.0
     *
     * @var object
     */
    public function add_side_meta()
    {
        /**
         * Create a custom meta boxes array that we pass to
         * the OptionTree Meta Box API Class.
         */
        $settings_meta_box = array(
            'id'       => 'eram_client_side',
            'title'    => __( 'Hide from lists', 'eram' ),
            'desc'     => '',
            'pages'    => array( ERAM_CLIENT_CPT_NAME ),
            'context'  => 'side',
            'priority' => 'high',
            'fields'   => array(

                array(
                    'id'          => '_ec_exclude_from_loop_text',
                    'label'       => '',
                    'desc'      => __( "Hide this Client from lists, If turned on, this client will be hidden at list of your clients but can be accessed directly by it's URL.", 'eram' ),
                    'std'         => '',
                    'type'        => 'textblock',
                ),
               
                /*
                 * Exclude
                 * _epg_gallery_proof_mode
                */
                array(
                    'label'     => '',
                    'id'        => '_ec_exclude_from_loop',
                    'type'      => 'on-off',
                    'std'       => 'off',
                    'class'     => '',
                    'condition' => '',
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
$eram_client_metabox = Eram_Client_Metabox::get_instance();
