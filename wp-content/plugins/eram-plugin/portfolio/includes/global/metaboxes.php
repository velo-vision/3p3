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

class Eram_Folio_Metabox
{

    /**
     * Holds the class object.
     *
     * @since 1.0.0
     *
     * @var object
     */
    public static $instance;

    public $metas;

    public function __construct()
    {

        // initialize metaboxes
        add_action( 'init', array( $this, 'add_settings' ) );

        // initialize metaboxes
        add_action( 'init', array( $this, 'add_side_settings' ) );

    }


    public function add_settings()
    {
        /**
         * Create a custom meta boxes array that we pass to
         * the OptionTree Meta Box API Class.
         */
        $settings_meta_box = array(
            'id'       => 'eram_folio_meta_box',
            'title'    => __( 'Settings', 'eram' ),
            'desc'     => '',
            'pages'    => array( ERAM_FOLIO_CPT_NAME ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields'   => array(

                // _epf_layout
                array(
                    'id'           => '_epf_layout',
                    'label'        => __( 'Portfolio Layout', 'eram' ),
                    'desc'         => __( 'Choose desired layout for this item.', 'eram' ),
                    'std'          => 'top-header',
                    'type'         => 'radio-image',
                    'section'      => '',
                    'rows'         => '',
                    'post_type'    => '',
                    'taxonomy'     => '',
                    'min_max_step' => '',
                    'class'        => '',
                    'condition'    => '',
                    'operator'     => 'and',
                    'choices'      => array(
                        array(
                            'value' => 'top-header',
                            'label' => __( 'Header at the top', 'eram' ),
                            'src'   => ERAM_FOLIO_IMG_DIR . '/top-header.jpg'
                        ),
                        array(
                            'value' => 'side-header',
                            'label' => __( 'Header at the side', 'eram' ),
                            'src'   => ERAM_FOLIO_IMG_DIR . '/side-header.jpg'
                        ),
                        array(
                            'value' => 'blank',
                            'label' => __( 'blank', 'eram' ),
                            'src'   => ERAM_FOLIO_IMG_DIR . '/blank.jpg'
                        ),
                    )
                ),
                array(
                    'label'     => __( 'Content Type', 'eram' ),
                    'id'        => '_epf_content_type',
                    'type'      => 'radio',
                    'desc'      => __( 'How you want to contain the content?', 'eram' ),
                    'condition' => '_epf_layout:is(top-header)',
                    'operator'  => 'or',
                    'std'       => 'container',
                    'choices'   => array(
                        array(
                            'value' => 'container',
                            'label' => __( 'Container', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'slim-container',
                            'label' => __( 'Slim Container', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'full-width',
                            'label' => __( 'Fullwidth (no container)', 'eram' ),
                            'src'   => ''
                        ),
                    )
                ),
                array(
                    'label'   => __( 'Cover Type', 'eram' ),
                    'id'      => '_epf_cover_type',
                    'type'    => 'radio',
                    'desc'    => __( 'Choose type of cover.', 'eram' ),
                    'std'     => 'image',
                    'class'   => '',
                    'condition' => '_epf_layout:not(blank)',
                    'choices' => array(
                        array(
                            'value' => 'image',
                            'label' => __( 'Image', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'video',
                            'label' => __( 'Video', 'eram' ),
                            'src'   => ''
                        ),
                    )
                ),
                array(
                    'label'     => __( 'Video MP4', 'eram' ),
                    'id'        => '_epf_cover_video',
                    'type'      => 'upload',
                    'desc'      => __( 'Upload and use a short video as cover.', 'eram' ),
                    'std'       => '',
                    'class'     => 'ot-upload-attachment-id',
                    'condition' => '_epf_cover_type:is(video),_epf_layout:not(blank)',
                    'operator'  => 'and',
                ),
                array(
                    'label' => __( 'Cover Image', 'eram' ),
                    'id'    => '_epf_cover_image',
                    'type'  => 'upload',
                    'desc'  => __( 'Background image of the header or the cover for video.', 'eram' ),
                    'std'   => '',
                    'class' => 'ot-upload-attachment-id',
                    'condition' => '_epf_layout:not(blank)',
                ),

                array(
                    'label' => __( 'Short Description', 'eram' ),
                    'id'    => '_epf_short_desc',
                    'type'  => 'textarea-simple',
                    'rows'  => '5',
                    'desc'  => __( 'This text will appear below the title. Keep it short!', 'eram' ),
                    'std'   => '',
                    'class' => '',
                    'condition' => '_epf_layout:not(blank)',
                ),

                array(
                    'label' => __( 'Show Portfolio Metadata', 'eram' ),
                    'id'    => '_epf_show_meta',
                    'type'  => 'on-off',
                    'std'   => 'on',
                    'class' => '',
                ),
            )
        );


        if ( ERAM_Kirki::get_option( 'eram_theme_options', 'epf_enable_client', TRUE ) ) {
            $settings_meta_box['fields'][] = array(
                'id'    => '_epf_meta_client',
                'label' => __( 'Client', 'eram' ),
                'desc'  => __( 'Name of the client.', 'eram' ),
                'std'   => '',
                'type'  => 'text',
            );
        }

        if ( ERAM_Kirki::get_option( 'eram_theme_options', 'epf_enable_url', TRUE ) ) {
            $settings_meta_box['fields'][] = array(
                'id'    => '_epf_meta_link_url',
                'label' => __( 'Url', 'eram' ),
                'desc'  => __( 'External or internal url', 'eram' ),
                'std'   => '',
                'type'  => 'text',
            );
            $settings_meta_box['fields'][] = array(
                'id'    => '_epf_meta_link_label',
                'label' => __( 'Url Label', 'eram' ),
                'desc'  => __( 'Clickable text with anchored url', 'eram' ),
                'std'   => __( 'View Website', 'eram' ),
                'type'  => 'text',
            );
        }

        if ( ERAM_Kirki::get_option( 'eram_theme_options', 'epf_enable_date', TRUE ) ) {
            $settings_meta_box['fields'][] = array(
                'id'    => '_epf_meta_date',
                'label' => __( 'Date', 'eram' ),
                'desc'  => __( 'Date of Project', 'eram' ),
                'std'   => date( 'Y-m-d' ),
                'type'  => 'date-picker',
            );
        }


        $dynamic_portfolio_fields = ERAM_Kirki::get_option( 'eram_theme_options', 'epf_custom_fields', array() );

        foreach ( $dynamic_portfolio_fields as $field ) {
            if ( $field['name'] != '' ) {
                $settings_meta_box['fields'][] = array(
                    'id'    => '_epf_meta_dynamic_' . sanitize_title_with_dashes( $field['name'] ),
                    'desc'  => $field['desc'],
                    'label' => $field['name'],
                    'type'  => 'text',
                );
            }
        }

        $this->metas = $settings_meta_box;
        /**
         * Register our meta boxes using the
         * ot_register_meta_box() function.
         */
        if ( function_exists( 'ot_register_meta_box' ) )
            ot_register_meta_box( $this->metas );


    }

    public function add_side_settings()
    {
        /**
         * Create a custom meta boxes array that we pass to
         * the OptionTree Meta Box API Class.
         */
        $settings_meta_box = array(
            'id'       => 'eram_portfolio_side_meta_box',
            'title'    => __( 'Portfolio Options', 'eram' ),
            'desc'     => '',
            'pages'    => array( ERAM_FOLIO_CPT_NAME ),
            'context'  => 'side',
            'priority' => 'high',
            'fields'   => array(

                // _eg_redirect
                array(
                    'id'   => '_epf_redirect_text',
                    'desc' => __( 'Specify the URL which you want to open when a visitor clicks on the portfolio thumbnail in the lists. Leave blank to ignore. ', 'eram' ),
                    'std'  => '',
                    'type' => 'textblock',
                ),
                array(
                    'id'   => '_epf_redirect',
                    'std'  => '',
                    'type' => 'text',
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
global $eram_folio_metabox;
$eram_folio_metabox = Eram_Folio_Metabox::get_instance();
