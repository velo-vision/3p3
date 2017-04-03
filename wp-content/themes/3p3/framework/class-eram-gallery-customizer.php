<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class Eram_Gallery_Customizer
{

    protected $eg_panel = 'eg_panel';
    protected $eg_archive_section = 'eg_archive';
    protected $eg_categories_section = 'eg_categories';
    protected $eg_general_section = 'eg_general';
    protected $eg_lightbox_section = 'eg_lightbox';
    protected $config_id = 'eg_settings';

    public function __construct()
    {
        if ( ! class_exists( 'EramGallery' ) )
            return;

        if ( ! class_exists( 'Eram_Kirki' ) )
            return;


        add_action( 'init', array( $this, 'run' ), 100 );

    }


    public function run()
    {
        // configure kirki
        $this->config_kirki();

        // add styles and scripts
        add_action( 'customize_controls_print_footer_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'customize_controls_print_styles', array( $this, 'enqueue_styles' ) );

        //add gallery customizer panel
        $this->add_panels();

        // add gallery archive section
        $this->add_sections();

        // add controls
        $this->add_controls();
    }


    public function enqueue_styles()
    {
        wp_enqueue_style(
            'eg_customizer_css',
            ERAM_CSS . '/eram_customizer_preview.css',
            array(),
            ''
        );
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script(
            'eg_customizer_js',
            ERAM_SCRIPTS . '/eg-customizer.js',
            array(),
            ERAM_GALLERY_VERSION,
            TRUE
        );

        wp_localize_script( 'eg_customizer_js', 'egGal', array(
            'btnTitle' => esc_html__( 'Load Gallery', 'eram' )
        ) );
    }

    public function config_kirki()
    {

        Eram_Kirki::add_config( $this->config_id, array(
            'capability'  => 'edit_theme_options',
            'option_type' => 'theme_mod',
        ) );

    }

    public function add_panels()
    {
        Eram_Kirki::add_panel( $this->eg_panel, array(
            'priority' => 502,
            'title'    => esc_html__( 'Gallery Settings', 'eram' ),
        ) );
    }

    public function add_sections()
    {
        Eram_Kirki::add_section( $this->eg_general_section, array(
            'title'          => esc_html__( 'General Settings', 'eram' ),
            'description'    => esc_html__( 'Here you can edit General settings of Gallery', 'eram' ),
            'panel'          => $this->eg_panel,
            'priority'       => 10,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
        ) );

        Eram_Kirki::add_section( $this->eg_archive_section, array(
            'title'          => esc_html__( 'Archive Page', 'eram' ),
            'description'    => esc_html__( 'Here you can edit archive page of Eram Gallery', 'eram' ),
            'panel'          => $this->eg_panel,
            'priority'       => 10,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
        ) );

        Eram_Kirki::add_section( $this->eg_categories_section, array(
            'title'          => esc_html__( 'Categories', 'eram' ),
            'description'    => esc_html__( 'Here you can edit gallery categories', 'eram' ),
            'panel'          => $this->eg_panel,
            'priority'       => 20,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
        ) );

        Eram_Kirki::add_section( $this->eg_lightbox_section, array(
            'title'          => esc_html__( 'Lightbox', 'eram' ),
            'description'    => esc_html__( 'Here you can edit gallery lightbox', 'eram' ),
            'panel'          => $this->eg_panel,
            'priority'       => 20,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
        ) );
    }

    public function add_controls()
    {
        // add general controls
        $this->add_general_controls();

        // add archive controls
        $this->add_archive_controls();

        // add categories controls
        $this->add_categories_controls();

        // add lightbox controls
        $this->add_lightbox_controls();

    }

    /**
     * Adds general Controls
     */
    private function add_general_controls()
    {
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'toggle',
            'settings'    => 'eg_has_custom_slug',
            'label'       => esc_html__( 'Change Gallery URL?', 'eram' ),
            'description' => get_post_type_archive_link( ERAM_GALLERY_CPT_NAME ),
            'section'     => $this->eg_general_section,
            'priority'    => 10,
            'default'     => 0,

        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'text',
            'settings'        => 'eg_custom_slug',
            'label'           => esc_html__( 'URL segment', 'eram' ),
            'description'     => sprintf( __( '<code>IMPORTANT:</code> After changing this, go to <a href="%s">Permalink Settings</a> and just hit Save.', 'eram' ), admin_url( 'options-permalink.php' ) ),
            'section'         => $this->eg_general_section,
            'default'         => 'gallery',
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eg_has_custom_slug',
                    'operator' => '==',
                    'value'    => TRUE,
                ),
            )

        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'toggle',
            'settings'    => 'eg_cat_has_custom_slug',
            'label'       => esc_html__( 'Change Category URL?', 'eram' ),
            'description' => esc_html__( 'Currently is:', 'eram' ) . ' ' . ERAM_GALLERY_CATEGORY_SLUG,
            'section'     => $this->eg_general_section,
            'priority'    => 10,
            'default'     => 0,

        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'text',
            'settings'        => 'eg_cat_custom_slug',
            'label'           => esc_html__( 'Category URL segment', 'eram' ),
            'description'     => sprintf( __( '<code>IMPORTANT:</code> After changing this, go to <a href="%s">Permalink Settings</a> and just hit Save.<br> Dont use <strong>category</strong> it is already used for blog.', 'eram' ), admin_url( 'options-permalink.php' ) ),
            'section'         => $this->eg_general_section,
            'default'         => 'egcategory',
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eg_cat_has_custom_slug',
                    'operator' => '==',
                    'value'    => TRUE,
                ),
            )

        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'radio-image',
            'settings' => 'eg_hover',
            'label'    => esc_html__( 'Gallery Hover Style', 'eram' ),
            'section'  => $this->eg_general_section,
            'default'  => 'hover-1',
            'priority' => 10,
            'choices'  => array(
                'hover-1' => ERAM_GALLERY_IMG_DIR . '/hover-1.jpg',
                'hover-2' => ERAM_GALLERY_IMG_DIR . '/hover-2.jpg',
            ),
        ) );
        
        
    }

    private function get_controls( $section, $suffix = '' )
    {
        if ( '' != $suffix ) {
            $suffix = '__' . $suffix;
        }

        // eg_has_details
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'toggle',
            'settings'        => 'eg_has_details' . $suffix,
            'label'           => esc_html__( 'Include Title and Description', 'eram' ),
            'section'         => $section,
            'priority'        => 20,
            'default'         => 0,
            'active_callback' => array(
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '!=',
                    'value'    => 'dcarousel',
                ),
            )
        ) );

        // eg_details_position
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'radio',
            'settings'        => 'eg_details_position' . $suffix,
            'label'           => esc_html__( 'Position of Title and Description', 'eram' ),
            'section'         => $section,
            'default'         => 'side',
            'priority'        => 20,
            'choices'         => array(
                'side' => esc_html__( 'Side of the page', 'eram' ),
                'top'  => esc_html__( 'Top of the Page', 'eram' ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eg_has_details' . $suffix,
                    'operator' => '==',
                    'value'    => TRUE,
                ),
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '!=',
                    'value'    => 'dcarousel',
                ),
            )
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'image',
            'settings'        => 'eg_archive_cover' . $suffix,
            'label'           => esc_html__( 'Cover Image', 'eram' ),
            'section'         => $section,
            'default'         => '',
            'priority'        => 24,
            'active_callback' => array(
                array(
                    'setting'  => 'eg_has_details' . $suffix,
                    'operator' => '==',
                    'value'    => TRUE
                ),
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '!=',
                    'value'    => 'dcarousel',
                ),
            )
        ) );

        // eg_archive_layout
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'radio-image',
            'settings' => 'eg_archive_layout' . $suffix,
            'label'    => esc_html__( 'Layout of Thumbnails', 'eram' ),
            'section'  => $section,
            'default'  => 'v_grid',
            'priority' => 30,
            'choices'  => array(
                'simple_horizontal' => ERAM_GALLERY_IMG_DIR . '/simple_horizontal.jpg',
                'simple_vertical'   => ERAM_GALLERY_IMG_DIR . '/simple_vertical.jpg',
                'h_grid'            => ERAM_GALLERY_IMG_DIR . '/h_grid.jpg',
                'v_grid'            => ERAM_GALLERY_IMG_DIR . '/v_grid.jpg',
                'h_masonry'         => ERAM_GALLERY_IMG_DIR . '/h_masonry.jpg',
                'v_masonry'         => ERAM_GALLERY_IMG_DIR . '/v_masonry.jpg',
                'justified'         => ERAM_GALLERY_IMG_DIR . '/justified.jpg',
                'dcarousel'         => ERAM_GALLERY_IMG_DIR . '/dcarousel.jpg',
            ),
        ) );


        // eg_vs_height
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'select',
            'settings'        => 'eg_vs_height' . $suffix,
            'label'           => esc_html__( 'Image Height', 'eram' ),
            'section'         => $section,
            'priority'        => 30,
            'default'         => 'fixed',
            'choices'         => array(
                'auto'  => esc_html__( 'Auto', 'eram' ),
                'fixed' => esc_html__( 'Fixed size', 'eram' ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '==',
                    'value'    => 'simple_vertical',
                ),
            )
        ) );

        // eg_masonry_rows
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'slider',
            'settings'        => 'eg_vs_image_height' . $suffix,
            'label'           => esc_html__( 'Height of images (px)', 'eram' ),
            'section'         => $section,
            'default'         => 300,
            'priority'        => 30,
            'choices'         => array(
                'min'  => 200,
                'max'  => 800,
                'step' => 50,
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '==',
                    'value'    => 'simple_vertical',
                ),
                array(
                    'setting'  => 'eg_vs_height' . $suffix,
                    'operator' => '==',
                    'value'    => 'fixed',
                ),
            )
        ) );


        // eg_masonry_rows
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'slider',
            'settings'        => 'eg_masonry_rows' . $suffix,
            'label'           => esc_html__( 'Number of Rows', 'eram' ),
            'section'         => $section,
            'default'         => 3,
            'priority'        => 30,
            'choices'         => array(
                'min'  => 2,
                'max'  => 4,
                'step' => 1,
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '==',
                    'value'    => 'h_masonry',
                ),
            )
        ) );

        // eg_masonry_cols
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'slider',
            'settings'        => 'eg_masonry_cols' . $suffix,
            'label'           => esc_html__( 'Number of Columns', 'eram' ),
            'section'         => $section,
            'default'         => 3,
            'priority'        => 30,
            'choices'         => array(
                'min'  => 2,
                'max'  => 4,
                'step' => 1,
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '==',
                    'value'    => 'v_masonry',
                ),
            )
        ) );

        //eg_grid_rows
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'slider',
            'settings'        => 'eg_grid_rows' . $suffix,
            'label'           => esc_html__( 'Number of Rows', 'eram' ),
            'section'         => $section,
            'priority'        => 30,
            'default'         => 3,
            'choices'         => array(
                'min'  => 2,
                'max'  => 4,
                'step' => 1,
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '==',
                    'value'    => 'h_grid',
                ),
            )
        ) );

        //eg_grid_cols
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'slider',
            'settings'        => 'eg_grid_cols' . $suffix,
            'label'           => esc_html__( 'Number of Columns', 'eram' ),
            'section'         => $section,
            'priority'        => 30,
            'default'         => 3,
            'choices'         => array(
                'min'  => 2,
                'max'  => 4,
                'step' => 1,
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '==',
                    'value'    => 'v_grid',
                ),
            )
        ) );

        // eg_grid_thumb_ratio
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'radio-image',
            'settings'        => 'eg_grid_thumb_ratio' . $suffix,
            'label'           => esc_html__( 'Thumbnail Aspect Ratio', 'eram' ),
            'section'         => $section,
            'default'         => 'square',
            'priority'        => 30,
            'choices'         => array(
                'square'    => ERAM_GALLERY_IMG_DIR . '/grid-square.jpg',
                'landscape' => ERAM_GALLERY_IMG_DIR . '/grid-landscape.jpg',
                'portrait'  => ERAM_GALLERY_IMG_DIR . '/grid-portrait.jpg'
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => 'contains',
                    'value'    => array( 'v_grid', 'h_grid' ),
                ),
            )
        ) );

        // eg_jg_rowheight
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'slider',
            'settings'        => 'eg_jg_rowheight' . $suffix,
            'label'           => esc_html__( 'Height of each row', 'eram' ),
            'section'         => $section,
            'priority'        => 30,
            'default'         => 250,
            'description'     => esc_html__( 'in pixels', 'eram' ),
            'choices'         => array(
                'min'  => 150,
                'max'  => 400,
                'step' => 50,
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '==',
                    'value'    => 'justified',
                ),
            )
        ) );

        // eg_hs_width
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'radio',
            'settings'        => 'eg_hs_width' . $suffix,
            'label'           => esc_html__( 'Thumbnail Width', 'eram' ),
            'section'         => $section,
            'default'         => 'auto',
            'priority'        => 30,
            'description'     => '',
            'choices'         => array(
                'auto'  => esc_html__( 'Auto', 'eram' ),
                'fixed' => esc_html__( 'Fixed', 'eram' ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '==',
                    'value'    => 'simple_horizontal',
                )
            )
        ) );

        // eg_hs_image_width
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'slider',
            'settings'        => 'eg_hs_image_width' . $suffix,
            'label'           => esc_html__( 'Define Width', 'eram' ),
            'section'         => $section,
            'priority'        => 30,
            'default'         => 400,
            'choices'         => array(
                'min'  => 200,
                'max'  => 800,
                'step' => 50,
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '==',
                    'value'    => 'simple_horizontal',
                ),

                array(
                    'setting'  => 'eg_hs_width' . $suffix,
                    'operator' => '==',
                    'value'    => 'fixed',
                )
            )
        ) );

        // eg_dc_duration
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'slider',
            'settings'        => 'eg_dc_duration' . $suffix,
            'label'           => esc_html__( 'Transition Duration (seconds)', 'eram' ),
            'section'         => $section,
            'priority'        => 30,
            'default'         => 1,
            'choices'         => array(
                'min'  => 0.5,
                'max'  => 3,
                'step' => 0.1,
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '==',
                    'value'    => 'dcarousel',
                ),
            )
        ) );

        // eg_dc_autoplay
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'toggle',
            'settings'        => 'eg_dc_autoplay' . $suffix,
            'label'           => esc_html__( 'Auto Play', 'eram' ),
            'section'         => $section,
            'priority'        => 30,
            'default'         => 0,
            'active_callback' => array(
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '==',
                    'value'    => 'dcarousel',
                ),
            )
        ) );

        // eg_dc_show_bullets
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'toggle',
            'settings'        => 'eg_dc_show_bullets' . $suffix,
            'label'           => esc_html__( 'Pagination Links', 'eram' ),
            'section'         => $section,
            'priority'        => 30,
            'default'         => 1,
            'active_callback' => array(
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '==',
                    'value'    => 'dcarousel',
                ),
            )
        ) );
        // eg_dc_show_bullets
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'toggle',
            'settings'        => 'eg_dc_show_next_prev' . $suffix,
            'label'           => esc_html__( 'Next/Previous Links', 'eram' ),
            'section'         => $section,
            'priority'        => 30,
            'default'         => 1,
            'active_callback' => array(
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '==',
                    'value'    => 'dcarousel',
                ),
            )
        ) );

        // eg_items_spacing
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'slider',
            'settings'        => 'eg_items_spacing' . $suffix,
            'label'           => esc_html__( 'Items Spacing', 'eram' ),
            'section'         => $section,
            'priority'        => 30,
            'default'         => 15,
            'choices'         => array(
                'min'  => 0,
                'max'  => 40,
                'step' => 1,
            ),
            'description'     => esc_html__( 'Define the desired gutter width (spacing between items in the gallery). Value is in pixels and default is 15px', 'eram' ),
            'active_callback' => array(
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '!=',
                    'value'    => 'dcarousel',
                ),
            )
        ) );

        // eg_scroll_animation
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'radio',
            'settings'        => 'eg_scroll_animation' . $suffix,
            'label'           => esc_html__( 'Animation', 'eram' ),
            'section'         => $section,
            'priority'        => 30,
            'default'         => 'none',
            'choices'         => array(
                'none'      => esc_html__( 'none', 'eram' ),
                'fadein'    => esc_html__( 'Fade In', 'eram' ),
                'slidefade' => esc_html__( 'Slide Fade In', 'eram' ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '!=',
                    'value'    => 'dcarousel',
                ),
            )
        ) );

        // eg_social_share
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eg_social_share' . $suffix,
            'label'    => esc_html__( 'Enable Social Sharing', 'eram' ),
            'section'  => $section,
            'priority' => 30,
            'default'  => 1,
        ) );

        // eg_load_type
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'radio',
            'settings'        => 'eg_load_type' . $suffix,
            'label'           => esc_html__( 'Page Load Enhancement', 'eram' ),
            'section'         => $section,
            'default'         => 'lazy',
            'priority'        => 30,
            'tooltip'         => esc_html__( 'Notice: Infinite Scroll option wont preview while viewing in customizer!', 'eram' ),
            'choices'         => array(
                'lazy'     => esc_html__( 'Lazy load Images', 'eram' ),
                'infinite' => esc_html__( 'Infinite Scroll', 'eram' ),
                'none'     => esc_html__( 'None', 'eram' ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '!=',
                    'value'    => 'dcarousel',
                ),
            )
        ) );

        // eg_infinite_chunk_count
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'slider',
            'settings'        => 'eg_infinite_chunk_count' . $suffix,
            'label'           => esc_html__( 'Image Chunk Count', 'eram' ),
            'section'         => $section,
            'priority'        => 30,
            'default'         => 15,
            'choices'         => array(
                'min'  => 5,
                'max'  => 50,
                'step' => 2,
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eg_load_type' . $suffix,
                    'operator' => '==',
                    'value'    => 'infinite',
                ),
                array(
                    'setting'  => 'eg_archive_layout' . $suffix,
                    'operator' => '!=',
                    'value'    => 'dcarousel',
                ),
            )
        ) );

    }

    private function add_archive_controls()
    {
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'text',
            'settings'        => 'eg_page_title',
            'label'           => esc_html__( 'Archive Title', 'eram' ),
            'section'         => $this->eg_archive_section,
            'default'         => esc_html__( 'Archive Title', 'eram' ),
            'priority'        => 22,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'h1.gallery-title',
                    'function' => 'html',
                    'property' => '',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eg_has_details',
                    'operator' => '==',
                    'value'    => TRUE
                ),
                array(
                    'setting'  => 'eg_archive_layout',
                    'operator' => '!=',
                    'value'    => 'dcarousel',
                ),
            )
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'textarea',
            'settings'        => 'eg_page_description',
            'label'           => esc_html__( 'Short Description', 'eram' ),
            'section'         => $this->eg_archive_section,
            'default'         => '',
            'priority'        => 23,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '.gallery-description',
                    'function' => 'html',
                    'property' => '',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eg_has_details',
                    'operator' => '==',
                    'value'    => TRUE
                ),
                array(
                    'setting'  => 'eg_archive_layout',
                    'operator' => '!=',
                    'value'    => 'dcarousel',
                ),
            )
        ) );


        $this->get_controls( $this->eg_archive_section );

    }

    private function add_categories_controls()
    {
        // drop down of gallery categories
        remove_theme_mod( 'eg_categories' );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'      => 'select',
            'settings'  => 'eg_categories',
            'label'     => esc_html__( 'Select Category', 'eram' ),
            'section'   => $this->eg_categories_section,
            'default'   => '',
            'priority'  => 10,
            'transport' => 'postMessage',
            'multiple'  => 1,
            'choices'   => $this::get_terms_by_slug( array( 'taxonomy' => ERAM_GALLERY_CATEGORY_TAX ), TRUE ),
        ) );
        foreach ( $this::get_terms_by_slug( array( 'taxonomy' => ERAM_GALLERY_CATEGORY_TAX ) ) as $term_slug => $term_name ) {
            $this->get_controls( $this->eg_categories_section, $term_slug . '_eg_cat' );
        }

    }

    public static function get_terms_by_slug( array $taxonomies, $default = FALSE )
    {

        $items = array();

        // Get the post types.
        $terms = self::get_terms( $taxonomies );

        if ( $default )
            $items[0] = esc_html__( '-- Select --', 'eram' );

        foreach ( $terms as $term ) {
            $items[ $term->slug ] = $term->name;
        }

        return $items;
    }

    /**
     * @param array $taxonomies
     * @return array|int|WP_Error
     */
    private static function get_terms( array $taxonomies )
    {
        $terms = get_terms( $taxonomies['taxonomy'], array( 'hide_empty' => FALSE ) );

        return $terms;
    }

    private function add_lightbox_controls()
    {
        // theme -
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'select',
            'settings' => 'eg_lg_theme',
            'label'    => esc_html__( 'Lightbox Theme', 'eram' ),
            'section'  => $this->eg_lightbox_section,
            'default'  => 'none',
            'priority' => 10,
            'multiple' => 1,
            'choices'  => array(
                'none'  => __( 'Theme Default', 'eram' ),
                'light' => __( 'Light', 'eram' ),
                'dark'  => __( 'Dark', 'eram' ),
            )
        ) );

        // mode -
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'select',
            'settings' => 'eg_lg_mode',
            'label'    => esc_html__( 'Image Transition', 'eram' ),
            'section'  => $this->eg_lightbox_section,
            'default'  => 'lg-fade',
            'priority' => 10,
            'multiple' => 1,
            'choices'  => array(
                'lg-slide'                    => __( 'slide', 'eram' ),
                'lg-fade'                     => __( 'fade', 'eram' ),
                'lg-zoom-in'                  => __( 'zoom-in', 'eram' ),
                'lg-zoom-in-big'              => __( 'zoom-in-big', 'eram' ),
                'lg-zoom-out'                 => __( 'zoom-out', 'eram' ),
                'lg-zoom-out-big'             => __( 'zoom-out-big', 'eram' ),
                'lg-zoom-out-in'              => __( 'zoom-out-in', 'eram' ),
                'lg-zoom-in-out'              => __( 'zoom-in-out', 'eram' ),
                'lg-soft-zoom'                => __( 'soft-zoom', 'eram' ),
                'lg-scale-up'                 => __( 'scale-up', 'eram' ),
                'lg-slide-circular'           => __( 'slide-circular', 'eram' ),
                'lg-slide-circular-vertical'  => __( 'slide-circular-vertical', 'eram' ),
                'lg-slide-vertical'           => __( 'slide-vertical', 'eram' ),
                'lg-slide-vertical-growth'    => __( 'slide-vertical-growth', 'eram' ),
                'lg-slide-skew-only'          => __( 'slide-skew-only', 'eram' ),
                'lg-slide-skew-only-rev'      => __( 'slide-skew-only-rev', 'eram' ),
                'lg-slide-skew-only-y'        => __( 'slide-skew-only-y', 'eram' ),
                'lg-slide-skew-only-y-rev'    => __( 'slide-skew-only-y-rev', 'eram' ),
                'lg-slide-skew'               => __( 'slide-skew', 'eram' ),
                'lg-slide-skew-rev'           => __( 'slide-skew-rev', 'eram' ),
                'lg-slide-skew-cross'         => __( 'slide-skew-cross', 'eram' ),
                'lg-slide-skew-cross-rev'     => __( 'slide-skew-cross-rev', 'eram' ),
                'lg-slide-skew-ver'           => __( 'slide-skew-ver', 'eram' ),
                'lg-slide-skew-ver-rev'       => __( 'slide-skew-ver-rev', 'eram' ),
                'lg-slide-skew-ver-cross'     => __( 'slide-skew-ver-cross', 'eram' ),
                'lg-slide-skew-ver-cross-rev' => __( 'slide-skew-ver-cross-rev', 'eram' ),
                'lg-lollipop'                 => __( 'lollipop', 'eram' ),
                'lg-lollipop-rev'             => __( 'lollipop-rev', 'eram' ),
                'lg-rotate'                   => __( 'rotate', 'eram' ),
                'lg-rotate-rev'               => __( 'rotate-rev', 'eram' ),
                'lg-tube'                     => __( 'tube', 'eram' ),
            )
        ) );

        // show caption
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'slider',
            'settings' => 'eg_lg_padding',
            'label'    => esc_html__( 'Space Around Photo', 'eram' ),
            'section'  => $this->eg_lightbox_section,
            'default'  => 0,
            'choices'         => array(
                'min'  => 0,
                'max'  => 200,
                'step' => 10,
            ),
        ) );

        // show caption
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eg_lg_caption',
            'label'    => esc_html__( 'Show Caption', 'eram' ),
            'section'  => $this->eg_lightbox_section,
            'default'  => 1,
        ) );

        // show caption
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eg_lg_caption_with_title',
            'label'    => esc_html__( 'Include Image Title in Caption', 'eram' ),
            'section'  => $this->eg_lightbox_section,
            'default'  => 1,
        ) );

        // show download
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eg_lg_download',
            'label'    => esc_html__( 'Allow Download', 'eram' ),
            'section'  => $this->eg_lightbox_section,
            'default'  => 1,
        ) );

        // show counter
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eg_lg_counter',
            'label'    => esc_html__( 'Show Counter', 'eram' ),
            'section'  => $this->eg_lightbox_section,
            'default'  => 1,
        ) );

        // show controls - prev/next
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eg_lg_controls',
            'label'    => esc_html__( 'Show Prev/Next Buttons', 'eram' ),
            'section'  => $this->eg_lightbox_section,
            'default'  => 1,
        ) );

        // keyPress - keyboard navigation
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eg_lg_keypress',
            'label'    => esc_html__( 'keyboard navigation', 'eram' ),
            'section'  => $this->eg_lightbox_section,
            'default'  => 1,
        ) );

        // escKey - Whether the LightGallery could be closed by pressing the "Esc" key.
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eg_lg_esckey',
            'label'    => esc_html__( 'Enable Esc key', 'eram' ),
            'section'  => $this->eg_lightbox_section,
            'default'  => 1,
        ) );

        // loop -
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eg_lg_loop',
            'label'    => esc_html__( 'Loop', 'eram' ),
            'section'  => $this->eg_lightbox_section,
            'default'  => 1,
        ) );

        // thumbnail - Enable thumbnails for the gallery
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eg_lg_thumbnail',
            'label'    => esc_html__( 'Enable thumbnails', 'eram' ),
            'section'  => $this->eg_lightbox_section,
            'default'  => 1,
        ) );

        // showThumbByDefault
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eg_lg_thumbnaildefault',
            'label'    => esc_html__( 'Show thumbnails by default', 'eram' ),
            'section'  => $this->eg_lightbox_section,
            'default'  => 0,
        ) );

        // autoplay - Enable gallery autoplay
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eg_lg_autoplay',
            'label'    => esc_html__( 'Enable autoplay', 'eram' ),
            'section'  => $this->eg_lightbox_section,
            'default'  => 0,
        ) );

        // progressBar - Enable autoplay progress bar
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eg_lg_progressbar',
            'label'    => esc_html__( 'Enable autoplay progress bar', 'eram' ),
            'section'  => $this->eg_lightbox_section,
            'default'  => 1,
        ) );

        // zoom - Enable/Disable zoom option
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eg_lg_zoom',
            'label'    => esc_html__( 'Enable zoom', 'eram' ),
            'section'  => $this->eg_lightbox_section,
            'default'  => 1,
        ) );

        // Sidebar
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'group-title',
            'settings'    => 'eg_lg_side_group_title',
            'label'       => esc_html__( 'Sidebar Settings', 'eram' ),
            'description' => esc_html__( 'You can enable/disable Sidebar within each gallery live builder.', 'eram' ),
            'section'     => $this->eg_lightbox_section,

        ) );

        // Sidebar title
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eg_lg_side_title',
            'label'    => esc_html__( 'Sidebar - Image Title', 'eram' ),
            'section'  => $this->eg_lightbox_section,
            'default'  => 1,
        ) );

        // Sidebar description
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eg_lg_side_description',
            'label'    => esc_html__( 'Sidebar - Description', 'eram' ),
            'section'  => $this->eg_lightbox_section,
            'default'  => 1,
        ) );

        // Sidebar exif
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'toggle',
            'settings'    => 'eg_lg_side_exif',
            'label'       => esc_html__( 'Sidebar - EXIF', 'eram' ),
            'description' => esc_html__( 'To show EXIF data, you need to install and activate the Exifography Plugin.', 'eram' ),
            'section'     => $this->eg_lightbox_section,
            'default'     => 1,
        ) );

        // Sidebar sharing
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eg_lg_side_sharing',
            'label'    => esc_html__( 'Sidebar - Sharing Button', 'eram' ),
            'section'  => $this->eg_lightbox_section,
            'default'  => 1,
        ) );


    }

}

new Eram_Gallery_Customizer();