<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class Eram_Theme_Customizer
{


    protected $config_id = 'eram_theme_options';
    protected $sidebars;

    protected function set_sidebars()
    {
        // sidebars select
        $registered_sidebars = $GLOBALS['wp_registered_sidebars'];
        $sidebars['no-sidebar'] = esc_html__( 'None', 'eram' );
        foreach ( $registered_sidebars as $sidebar ) {
            $sidebars[ $sidebar['id'] ] = $sidebar['name'];
        }
        $this->sidebars = $sidebars;
    }

    public function __construct()
    {
        if ( ! class_exists( 'Eram_Kirki' ) ) return;

        //remove_theme_mods();


        $this->set_sidebars();

        // configure kirki
        $this->config_kirki();

        // add styles and scripts
        add_action( 'customize_controls_print_footer_scripts', array(
            $this,
            'enqueue_scripts',
        ) );
        add_action( 'customize_controls_print_styles', array(
            $this,
            'enqueue_styles',
        ) );

        //add panels
        $this->add_panels();

        // add sections
        $this->add_sections();

        // add controls
        $this->add_controls();

    }

    public function enqueue_styles()
    {
        wp_enqueue_style(
            'eram_css_customizer_preview',
            ERAM_CSS . '/eram_customizer_preview.css',
            array(),
            ERAM_THEME_VERSION
        );
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script(
            'eram_js_customizer_preview',
            ERAM_SCRIPTS . '/eram_customizer_preview.js',
            array( 'jquery' ),
            ERAM_THEME_VERSION,
            TRUE
        );
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

        Eram_Kirki::add_panel( 'eram_panel', array(
            'priority'    => 500,
            'title'       => esc_html__( 'Theme Settings', 'eram' ),
            'description' => esc_html__( 'Theme Settings', 'eram' ),
        ) );

        Eram_Kirki::add_panel( 'eram_blog_panel', array(
            'priority'    => 501,
            'title'       => esc_html__( 'Blog Settings', 'eram' ),
            'description' => esc_html__( 'Blog Settings', 'eram' ),
        ) );

        if ( class_exists( 'Woocommerce' ) ) {
            Eram_Kirki::add_panel( 'eram_shop_panel', array(
                'priority'    => 502,
                'title'       => esc_html__( 'Shop Settings', 'eram' ),
                'description' => esc_html__( 'Shop Settings', 'eram' ),
            ) );
        }

    }

    public function add_sections()
    {

        /**
         * Add a Section for General Setting
         */
        Eram_Kirki::add_section( 'eram_general_section', array(
            'title'       => esc_html__( 'General Settings', 'eram' ),
            'priority'    => 10,
            'panel'       => 'eram_panel',
            'description' => esc_html__( 'From this panel you control the general theme settings of your site.', 'eram' ),
        ) );

        /**
         * Add a Section for Layout
         */
        Eram_Kirki::add_section( 'eram_layout_section', array(
            'title'       => esc_html__( 'Site Layout', 'eram' ),
            'priority'    => 10,
            'panel'       => 'eram_panel',
            'description' => esc_html__( 'From this panel you control the layout settings.', 'eram' ),
        ) );

        /**
         * Add a Section for General pages
         */
        Eram_Kirki::add_section( 'eram_page_headers_section', array(
            'title'       => esc_html__( 'Pages Headers', 'eram' ),
            'priority'    => 10,
            'panel'       => 'eram_panel',
            'description' => esc_html__( 'From this panel you control the page headers settings.', 'eram' ),
        ) );

        /**
         * Add a Section for footer
         */
        Eram_Kirki::add_section( 'eram_footer_section', array(
            'title'       => esc_html__( 'Footer', 'eram' ),
            'priority'    => 10,
            'panel'       => 'eram_panel',
            'description' => esc_html__( 'From this panel you can set pages footer section', 'eram' ),
        ) );

        /**
         * Add a Section for Color
         */
        Eram_Kirki::add_section( 'eram_color_section', array(
            'title'       => esc_html__( 'Site Color', 'eram' ),
            'priority'    => 10,
            'panel'       => 'eram_panel',
            'description' => esc_html__( 'From this panel you control the color settings.', 'eram' ),
        ) );

        /**
         * Add a Section for Typography
         */
        Eram_Kirki::add_section( 'eram_typography_section', array(
            'title'       => esc_html__( 'Typography', 'eram' ),
            'priority'    => 10,
            'panel'       => 'eram_panel',
            'description' => esc_html__( 'From this panel you can edit Typography.', 'eram' ),
        ) );

        /**
         * Add a Section for Front page
         */
        Eram_Kirki::add_section( 'eram_front_page_section', array(
            'title'       => esc_html__( 'Custom Front Page', 'eram' ),
            'priority'    => 10,
            'panel'       => 'eram_panel',
            'description' => esc_html__( 'From this panel you control Front Page.', 'eram' ),
        ) );


        /**
         * Add a Section for Password Protected page
         */
        Eram_Kirki::add_section( 'eram_password_protected_section', array(
            'title'       => esc_html__( 'Password Protected Page', 'eram' ),
            'priority'    => 10,
            'panel'       => 'eram_panel',
            'description' => esc_html__( 'From this panel you control the password protected pages.', 'eram' ),
        ) );

        /**
         * Add a Section for 404 page
         */
        Eram_Kirki::add_section( 'eram_404_section', array(
            'title'       => esc_html__( '404 Page', 'eram' ),
            'priority'    => 10,
            'panel'       => 'eram_panel',
            'description' => esc_html__( 'From this panel you control the 404 page.', 'eram' ),
        ) );

        /**
         * Add a Section for social icons
         */
        Eram_Kirki::add_section( 'eram_social_section', array(
            'title'       => esc_html__( 'Social Networks', 'eram' ),
            'priority'    => 10,
            'panel'       => 'eram_panel',
            'description' => esc_html__( 'From this panel you set social networks', 'eram' ),
        ) );



        /**
         * Add a Section for social sharings
         */
        Eram_Kirki::add_section( 'eram_social_sharing_section', array(
            'title'       => esc_html__( 'Social Sharings', 'eram' ),
            'priority'    => 10,
            'panel'       => 'eram_panel',
            'description' => esc_html__( 'From this panel you set social sharing icons', 'eram' ),
        ) );

        /**
         * Add a Section for Dynamic Sidebars
         */
        Eram_Kirki::add_section( 'eram_sidebars_section', array(
            'title'       => esc_html__( 'Sidebars', 'eram' ),
            'priority'    => 10,
            'panel'       => 'eram_panel',
            'description' => esc_html__( 'From this panel you can add Dynamic sidebars.', 'eram' ),
        ) );


        /**
         * Add a Section for protection
         */
        Eram_Kirki::add_section( 'eram_protect_section', array(
            'title'       => esc_html__( 'Protection', 'eram' ),
            'priority'    => 10,
            'panel'       => 'eram_panel',
            'description' => esc_html__( 'From this panel you can edit protection settings.', 'eram' ),
        ) );

        /**
         * Add a Section for Custom CSS
         */
        Eram_Kirki::add_section( 'eram_custom_css_section', array(
            'title'       => esc_html__( 'Custom CSS', 'eram' ),
            'priority'    => 10,
            'panel'       => 'eram_panel',
            'description' => esc_html__( 'From this panel you can add/edit custom CSS.', 'eram' ),
        ) );

        /**
         * Add a Section for Custom JS
         */
        Eram_Kirki::add_section( 'eram_custom_js_section', array(
            'title'       => esc_html__( 'Custom Javascript', 'eram' ),
            'priority'    => 10,
            'panel'       => 'eram_panel',
            'description' => esc_html__( 'From this panel you can add/edit custom JavaScript.', 'eram' ),
        ) );

        /**
         * Add a Section for Blog Archives
         */
        Eram_Kirki::add_section( 'eram_blog_archive_section', array(
            'title'       => esc_html__( 'Blog Archives', 'eram' ),
            'priority'    => 10,
            'panel'       => 'eram_blog_panel',
            'description' => esc_html__( 'From this panel you can configure blog archives, main list, taxonomy archives , etc.', 'eram' ),
        ) );


        /**
         * Add a Section for Blog Single Post
         */
        Eram_Kirki::add_section( 'eram_blog_post_section', array(
            'title'       => esc_html__( 'Blog Posts', 'eram' ),
            'priority'    => 10,
            'panel'       => 'eram_blog_panel',
            'description' => esc_html__( 'From this panel you can configure blog posts', 'eram' ),
        ) );

        if ( class_exists( 'Woocommerce' ) ) {

            /**
             * Add a Section for Woocommerce general
             */
            Eram_Kirki::add_section( 'eram_shop_general_section', array(
                'title'    => esc_html__( 'General', 'eram' ),
                'priority' => 10,
                'panel'    => 'eram_shop_panel',
            ) );

            /**
             * Add a Section for Woocommerce list
             */
            Eram_Kirki::add_section( 'eram_shop_list_section', array(
                'title'    => esc_html__( 'Products Archive', 'eram' ),
                'priority' => 10,
                'panel'    => 'eram_shop_panel',
            ) );



            /**
             * Add a Section for Woocommerce product
             */
            Eram_Kirki::add_section( 'eram_shop_single_section', array(
                'title'    => esc_html__( 'Single Product', 'eram' ),
                'priority' => 10,
                'panel'    => 'eram_shop_panel',
            ) );
        }


    }

    public function add_controls()
    {
        $this->add_eram_general_section_fields();
        $this->add_eram_layout_section_fields();
        $this->add_eram_color_section_fields();
        $this->add_eram_front_page_section_fields();
        $this->add_eram_page_headers_section_fields();
        $this->add_earm_password_protected_section_fields();
        $this->add_eram_404_section_fields();
        $this->add_eram_social_section_fields();
        $this->add_eram_social_sharing_section_fields();
        $this->add_eram_blog_archive_section_fields();
        $this->add_eram_blog_post_section_fields();
        $this->add_eram_sidebars_section_fields();
        $this->add_eram_typography_section_fields();
        $this->add_eram_protect_section_fields();
        $this->add_eram_custom_css_section_fields();
        $this->add_eram_custom_js_section_fields();
        $this->add_eram_site_identity_fields();
        $this->add_eram_footer_section_fields();
        if ( class_exists( 'Woocommerce' ) ) {
            $this->add_eram_shop_general_section_fields();
            $this->add_eram_shop_list_section_fields();
            $this->add_eram_shop_single_section_fields();
        }

    }

    private function add_eram_site_identity_fields()
    {
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'image',
            'settings'    => 'eram_retina_logo',
            'label'       => esc_html__( 'Retina Logo', 'eram' ),
            'description' => esc_html__( '2x version of your logo', 'eram' ),
            'section'     => 'title_tagline',
            'default'     => '',
            'priority'    => 8,
        ) );


    }

    private function add_eram_general_section_fields()
    {
        $section = 'eram_general_section';

        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'select',
            'settings'    => 'eg_thumb_size',
            'label'       => esc_html__( 'Default Image Sizes', 'eram' ),
            'description' => __( 'Considering page load time, theme tries to use a 1000px variation of your uploaded images where possible in gallery and portfolio. If you want to load a higher/lower qualities, change it here. <br> <strong>Extra Large is added at v2.0, so you need to regenerate thumbnails to use it.</strong>', 'eram' ),
            'section'     => $section,
            'default'     => 'eram-normal',
            'priority'    => 10,
            'choices'     => array(
                'eram-normal'  => esc_html__( 'Default (1000 x infinite height)', 'eram' ),
                'eram-large'   => esc_html__( 'Large (1500 x infinite height)', 'eram' ),
                'medium_large' => esc_html__( 'Medium (768 x infinite height)', 'eram' ),
                'full'         => esc_html__( 'Full (original size uploaded)', 'eram' ),
            ),
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'toggle',
            'settings'    => 'eram_show_breadcrumbs',
            'label'       => esc_html__( 'Breadcrumbs', 'eram' ),
            'description' => esc_html__( 'Enable/Disable Breadcrumbs', 'eram' ),
            'section'     => $section,
            'default'     => 1,
            'priority'    => 10,
        ) );



        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'text',
            'settings'    => 'eram_gmap_api_key',
            'label'       => esc_html__( 'Google Map API key', 'eram' ),
            'section'     => $section,
            'default'     => '',
            'priority'    => 10,
            // 'help'        => esc_html__( 'This is some extra help text.', 'eram' ),
            'description' => esc_html__( 'Go to https://console.developers.google.com/<br/>Under Google Map\'s Api\'s choose Google Maps JavaScript API<br/>Enable the Api.<br/>Go to credentials section.Choose create Credentials.<br/>choose API Key from the popup,and then choose browser key from the proceeding popup.', 'eram' ),
        ) );


    }

    private function add_eram_layout_section_fields()
    {
        // eg_page_layout
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'radio-image',
            'settings' => 'eram_site_layout',
            'label'    => esc_html__( 'Site Layout', 'eram' ),
            'section'  => 'eram_layout_section',
            'default'  => 'bordered',
            'priority' => 1,
            'choices'  => array(
                'side'     => ERAM_IMAGES . '/site-layout-sidebar.jpg',
                'bordered' => ERAM_IMAGES . '/site-layout-bordered.jpg',
                'classic'  => ERAM_IMAGES . '/site-layout-classic.jpg',
                'top'      => ERAM_IMAGES . '/site-layout-top.jpg',
            ),
        ) );

        // eram_classic_header_type
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'select',
            'settings'        => 'eram_classic_header_type',
            'label'           => esc_html__( 'Header Type', 'eram' ),
            'section'         => 'eram_layout_section',
            'default'         => 'wide',
            'priority'        => 10,
            'choices'         => array(
                'wide'      => esc_html__( 'Wide', 'eram' ),
                'contained' => esc_html__( 'Contained', 'eram' ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'classic'
                ),
            ),
        ) );

        // eram_classic_header_type
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'toggle',
            'settings'        => 'eram_classic_header_transparent_scroll_bg',
            'label'           => esc_html__( 'Add background color to transparent header on scroll', 'eram' ),
            'section'         => 'eram_layout_section',
            'default'         => 1,
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'classic'
                ),
            ),
        ) );

        // eram_show_sidebar_socialicons
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'toggle',
            'settings'        => 'eram_side_layout_show_sidebar',
            'label'           => esc_html__( 'Always show sidebar', 'eram' ),
            'description'     => esc_html__( 'Show/Hide Sidebar when page loads', 'eram' ),
            'section'         => 'eram_layout_section',
            'default'         => 0,
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'side',
                ),
            ),
        ) );

        // eram_show_sidebar_socialicons
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'toggle',
            'settings'        => 'eram_show_sidebar_socialicons',
            'label'           => esc_html__( 'Sidebar Social Icons', 'eram' ),
            'description'     => esc_html__( 'Social networks can be added/edited in theme-settings->social networks', 'eram' ),
            'section'         => 'eram_layout_section',
            'default'         => 1,
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'side',
                ),
            ),
        ) );

        // eram_show_sidebar_cprtext
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'toggle',
            'settings'        => 'eram_show_sidebar_cprtext',
            'label'           => esc_html__( 'Show Copyright text at Sidebar', 'eram' ),
            'description'     => esc_html__( 'Copyright text option is global and available in theme-settings->footer section', 'eram' ),
            'section'         => 'eram_layout_section',
            'default'         => 1,
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'side',
                ),
            ),
        ) );


//        // eram_show_bordered_socialicons
//        Eram_Kirki::add_field( $this->config_id, array(
//            'type'            => 'toggle',
//            'settings'        => 'eram_show_bordered_socialicons',
//            'label'           => esc_html__( 'Show Social Icons', 'eram' ),
//            'description'     => esc_html__( 'Enable/Disable social icons at the bottom', 'eram' ),
//            'section'         => 'eram_layout_section',
//            'default'         => 1,
//            'priority'        => 10,
//            'active_callback' => array(
//                array(
//                    'setting'  => 'eram_site_layout',
//                    'operator' => '==',
//                    'value'    => 'bordered',
//                ),
//            ),
//        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'select',
            'settings'        => 'eram_bordered_bottom_left',
            'label'           => esc_html__( 'Bottom left content', 'eram' ),
            'description'     => esc_html__( 'Copyright text option is global and available in theme-settings->footer section', 'eram' ),
            'section'         => 'eram_layout_section',
            'default'         => 'copyright-text',
            'priority'        => 10,
            'choices'         => array(
                'copyright-text'   => esc_html__( 'Copyright text', 'eram' ),
                'social-icons'     => esc_html__( 'Social Networks', 'eram' ),
                'custom'           => esc_html__( 'Custom HTML', 'eram' ),
                'none'             => esc_html__( 'None', 'eram' ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'bordered',
                ),
            ),
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'textarea',
            'settings'        => 'eram_bordered_bottom_left_text',
            'label'           => esc_html__( 'Bottom left text', 'eram' ),
            'description'     => esc_html__( "Supports HTML codes too.", 'eram' ),
            'section'         => 'eram_layout_section',
            'default'         => '',
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'bordered',
                ),
                array(
                    'setting'  => 'eram_bordered_bottom_left',
                    'operator' => '==',
                    'value'    => 'custom',
                )
            ),
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'select',
            'settings'        => 'eram_bordered_bottom_right',
            'label'           => esc_html__( 'Bottom right content', 'eram' ),
            'description'     => esc_html__( 'Social networks can be added/edited in theme-settings->social networks', 'eram' ),
            'section'         => 'eram_layout_section',
            'default'         => 'social-icons',
            'priority'        => 10,
            'choices'         => array(
                'copyright-text'   => esc_html__( 'Copyright text', 'eram' ),
                'social-icons'     => esc_html__( 'Social Networks', 'eram' ),
                'custom'           => esc_html__( 'Custom HTML', 'eram' ),
                'none'             => esc_html__( 'None', 'eram' ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'bordered',
                ),
            ),
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'textarea',
            'settings'        => 'eram_bordered_bottom_right_text',
            'label'           => esc_html__( 'Bottom right text', 'eram' ),
            'description'     => esc_html__( "Supports HTML codes too.", 'eram' ),
            'section'         => 'eram_layout_section',
            'default'         => '',
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'bordered',
                ),
                array(
                    'setting'  => 'eram_bordered_bottom_right',
                    'operator' => '==',
                    'value'    => 'custom',
                )
            ),
        ) );

//        // eram_show_bordered_cpt
//        Eram_Kirki::add_field( $this->config_id, array(
//            'type'            => 'toggle',
//            'settings'        => 'eram_show_bordered_cpt',
//            'label'           => esc_html__( 'Show Copyright text', 'eram' ),
//            'description'     => esc_html__( 'Enable/Disable the Copyright text at the bottom', 'eram' ),
//            'section'         => 'eram_layout_section',
//            'default'         => 1,
//            'priority'        => 10,
//            'active_callback' => array(
//                array(
//                    'setting'  => 'eram_site_layout',
//                    'operator' => '==',
//                    'value'    => 'bordered',
//                ),
//            ),
//        ) );

        // eram_show_topbar_socialicons
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'toggle',
            'settings'        => 'eram_show_topbar_socialicons',
            'label'           => esc_html__( 'Top Social Icons', 'eram' ),
            'description'     => esc_html__( 'Social networks can be added/edited in theme-settings->social networks', 'eram' ),
            'section'         => 'eram_layout_section',
            'default'         => 1,
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'top',
                ),
            ),
        ) );

        // eram_top_text
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'textarea',
            'settings'        => 'eram_top_text',
            'label'           => esc_html__( 'Text', 'eram' ),
            'description'     => esc_html__( "Some text below social icons. leave blank if you don't want it.", 'eram' ),
            'section'         => 'eram_layout_section',
            'default'         => '',
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'top',
                ),
            ),
        ) );

        // eram_top_padding
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'slider',
            'settings'        => 'eram_top_padding',
            'label'           => esc_html__( 'Header Padding', 'eram' ),
            'description'     => esc_html__( "space the contents of the header from edges of the page.", 'eram' ),
            'section'         => 'eram_layout_section',
            'default'         => 70,
            'priority'        => 10,
            'choices'         => array(
                'min'  => 10,
                'max'  => 200,
                'step' => 5,
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'top',
                ),
            ),
        ) );

        // eram_side_menu_bg
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'image',
            'settings'        => 'eram_side_menu_bg',
            'label'           => esc_html__( 'Side Menu Background Image', 'eram' ),
            'section'         => 'eram_layout_section',
            'default'         => '',
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => 'in',
                    'value'    => array(
                        'bordered',
                        'classic',
                        'side',
                    ),
                ),
            ),
        ) );

        // eram_keep_menu_at_mobile
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'select',
            'settings'        => 'eram_keep_menu_at_mobile',
            'label'           => esc_html__( 'Mobile Menu', 'eram' ),
            'section'         => 'eram_layout_section',
            'default'         => 'primary-menu',
            'priority'        => 10,
            'choices'         => array(
                'primary-menu'   => esc_html__( 'Primary Menu', 'eram' ),
                'secondary-menu' => esc_html__( 'Secondary Menu', 'eram' ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => 'in',
                    'value'    => array(
                        'bordered',
                        'classic',
                    ),
                ),
            ),
        ) );


    }

    private function add_eram_color_section_fields()
    {
        // eg_color_theme
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'select',
            'settings' => 'eram_color_theme',
            'label'    => esc_html__( 'Color Scheme', 'eram' ),
            'section'  => 'eram_color_section',
            'default'  => 'light',
            'priority' => 10,
            'choices'  => array(
                'light' => esc_html__( 'Light', 'eram' ),
                'dark'  => esc_html__( 'Dark', 'eram' ),
            ),
        ) );

        //eram_use_custom_colors
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'switch',
            'settings' => 'eram_use_custom_colors',
            'label'    => esc_html__( 'More Color Customizations', 'eram' ),
            'section'  => 'eram_color_section',
            'default'  => 0,
            'priority' => 10,
        ) );

        // Headings Color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_headings',
            'label'           => esc_html__( 'Headings Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#444444',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6,.em-blog-post.layout-masonry .post-contents .title a,.gallery-page-title-top .gallery-top.page-head .gallery-title,.em-blog-wrapper.layout-classic .em-blog-posts a,.em-blog-post.layout-classic .post-date,.author-bio .author-bio-content h4 a,.em-blog-post.layout-classic .title a,.em-client-box .client-name h3 a',
                    'function' => 'css',
                    'property' => 'color',
                ),
                array(
                    'element'  => '.em-blog-post.layout-masonry .post-contents .title a:hover,.em-blog-wrapper.layout-classic .em-blog-posts a:hover,.author-bio .author-bio-content h4 a:hover,.em-blog-post.layout-classic .title a:hover,.em-client-box .client-name h3 a:hover',
                    'function' => 'css',
                    'property' => 'color',
                ),
                array(
                    'element'  => '.simple-page-head .title-wrapper .page-title:after,.widget .widget-title:after,#comments .comments-title:after',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );
        // texts color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_text',
            'label'           => esc_html__( 'Paragraph Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#777777',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'body,.icon-box.ib-v1 >i,.ol-price-table .body ul li,.er-cprtext,.er-breadcrumbs li, .er-breadcrumbs li a',
                    'function' => 'css',
                    'property' => 'color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );
        // background color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_bg',
            'label'           => esc_html__( 'Background Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#ffffff',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'body,.gallery-wrapper,.gallery-page-title-side .gallery-main,.gallery-page-title-side .gallery-main,.em-blog-wrapper.layout-masonry,.em-single-post .post-comments,.post-type-archive-eram_client,body.er-side-layout .navigation-trigger .hamburger-wrapper, .portfolio-minimal .page-main',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
                array(
                    'element'  => '.em-single-post nav.navigation .prev a, .em-single-post nav.navigation .next a, .single-eramfolio nav.navigation .prev a, .single-eramfolio nav.navigation .next a,.em-blog-wrapper .post-header.has-bg:before, .em-single-post .post-header.has-bg:before',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );
        // boxed background color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_boxed_bg',
            'label'           => esc_html__( 'Boxed Elements Background Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#f5f5f5',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '.vc-card.boxed,.vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-panel-body,.vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active,.vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active >a:hover, .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active >a:focus,.vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab >a:hover, .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab >a:focus,.vc_tta.vc_tta-style-theme-eram .vc_tta-panel .vc_tta-panel-heading .vc_tta-panel-title >a,.ol-price-table.skin-dark,.em-client-box .inner,.tagcloud a,.em-blog-post.layout-masonry .post-contents,.em-blog-wrapper .format-embed, .em-single-post .format-embed',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
                array(
                    'element'  => '.vc_tta.vc_tta-style-theme-eram .vc_tta-panel .vc_tta-panel-heading .vc_tta-panel-title >a:hover, .vc_tta.vc_tta-style-theme-eram .vc_tta-panel .vc_tta-panel-heading .vc_tta-panel-title >a:focus,.vc_tta.vc_tta-style-theme-eram .vc_tta-panel.vc_active .vc_tta-panel-heading .vc_tta-panel-title >a,.tagcloud a:hover',
                    'function' => 'css',
                    'property' => 'background-color',
                ),

            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );
        // border color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_border',
            'label'           => esc_html__( 'Border Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#dddddd',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '.single-eramfolio .page-contents .the-meta,.em-single-post nav.navigation, .single-eramfolio nav.navigation,.em-blog-post.layout-minimal,.widget .widget-title,.simple-page-head .title-wrapper .page-title:before,.vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-panels,.vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active,.ol-price-table.skin-dark,.page-footer,.em-blog-post.layout-classic .post-date,.vc-card .links, .vc-card.boxed',
                    'function' => 'css',
                    'property' => 'border-color',
                ),
                array(
                    'element'  => '.em-blog-wrapper.layout-minimal.with-sidebar .blog-contents:before, .em-blog-wrapper.layout-masonry.with-sidebar .blog-contents:before,.vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active:after',
                    'function' => 'css',
                    'property' => 'background-color',
                ),

            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );
        // Link color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_link',
            'label'           => esc_html__( 'Link Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#555555',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'a',
                    'function' => 'css',
                    'property' => 'color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // footer bg color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_footer_bg',
            'label'           => esc_html__( 'Footer Background Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#f5f5f5',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '.em-footer-section',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'output'         => array(
                array(
                    'element'  => '.em-footer-section',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );
        
        // footer border color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_footer_border_color',
            'label'           => esc_html__( 'Footer Border Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#e2e2e2',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '.em-footer-section .footer-main',
                    'function' => 'css',
                    'property' => 'border-color',
                ),
            ),
            'output'         => array(
                array(
                    'element'  => '.em-footer-section .footer-main',
                    'function' => 'css',
                    'property' => 'border-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );
        
        // footer bottom background color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_footer_bottom_bg',
            'label'           => esc_html__( 'Footer Bottom Background Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#f5f5f5',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '.em-footer-section .footer-bottom',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'output'         => array(
                array(
                    'element'  => '.em-footer-section .footer-bottom',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // footer bottom border color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_footer_bottom_border_color',
            'label'           => esc_html__( 'Footer Bottom - Border Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#e2e2e2',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '.em-footer-section .footer-bottom .footer-bottom-wrapper:after',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'output'         => array(
                array(
                    'element'  => '.em-footer-section .footer-bottom .footer-bottom-wrapper:after',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );
        
        // Sidebar background color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_side_bg',
            'label'           => esc_html__( 'Sidebar Background', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#F9F9F9',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '#side-header .side-inner',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'side',
                ),
            )
        ) );

        // Sidebar menu color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_side_menu_item',
            'label'           => esc_html__( 'Menu Item Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#888888',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '.slide-menu-wrapper a,.hamburger-wrapper .ham-label',
                    'function' => 'css',
                    'property' => 'color',
                ),
                array(
                    'element'  => '.slide-menu-wrapper a span:before,.hamburger-inner, .hamburger-inner::before, .hamburger-inner::after',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'side',
                ),
            )
        ) );
        // Sidebar menu hover and active
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_side_menu_item_hover',
            'label'           => esc_html__( 'Active Menu Item Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#444444',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '.slide-menu-wrapper li.current-menu-item > a, .slide-menu-wrapper li.current-menu-parent > a, .slide-menu-wrapper li.current-menu-ancestor > a, .slide-menu-wrapper li.active > a,.slide-menu-wrapper a:hover',
                    'function' => 'css',
                    'property' => 'color',
                ),
                array(
                    'element'  => '.slide-menu-wrapper a:hover span:before',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'side',
                ),
            )
        ) );
        // frame color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_frame',
            'label'           => esc_html__( 'Frame color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#f1f1f1',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '.er-bordered-layout .er-top-bar, .er-bordered-layout .er-bottom-bar, .er-bordered-layout .er-left-bar, .er-bordered-layout .er-right-bar, .er-full-layout .er-top-bar, .er-full-layout .er-bottom-bar, .er-full-layout .er-left-bar, .er-full-layout .er-right-bar',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'bordered',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );
        // Header bg color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_header_bg',
            'label'           => esc_html__( 'Header Background', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#ffffff',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '#classic-header,#top-header',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => 'in',
                    'value'    => array( 'classic', 'top' )
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );
        // Top menu item color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_top_menu_item',
            'label'           => esc_html__( 'Menu item color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#444444',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '#top-header .menu-wrapper li a',
                    'function' => 'css',
                    'property' => 'color',
                ),
                array(
                    'element'  => '#top-header .menu-wrapper li a >span:after',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'top'
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );
        // classic menu item color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_classic_menu',
            'label'           => esc_html__( 'Menu item color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#2b2b2b',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '#classic-menu >li > a,#classic-menu li a',
                    'function' => 'css',
                    'property' => 'color',
                ),
                array(
                    'element'  => '.hamburger-inner, .hamburger-inner::before, .hamburger-inner::after',
                    'function' => 'css',
                    'property' => 'background-color',
                ),

            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => 'in',
                    'value'    => array( 'bordered', 'classic' )
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );
        // classic menu item color hover
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_classic_menu_hover',
            'label'           => esc_html__( 'Active Menu item color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#000000',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '#classic-menu >li > a:hover,#classic-menu .current-menu-parent > a, #classic-menu .current-menu-item > a, #classic-menu .current-menu-ancestor > a,#classic-menu li a:hover, #classic-menu li a:focus',
                    'function' => 'css',
                    'property' => 'color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => 'in',
                    'value'    => array( 'bordered', 'classic' )
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );
        // classic menu item bg
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_classic_menu_bg',
            'label'           => esc_html__( 'Sub-Menu background color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#1e1e1e',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '#classic-menu ul.sub-menu',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
                array(
                    'element'  => '#classic-menu >li>ul.sub-menu>li ul.sub-menu',
                    'function' => 'css',
                    'property' => 'border-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => 'in',
                    'value'    => array( 'bordered', 'classic' )
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // classic menu item color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_c_classic_menu_item',
            'label'           => esc_html__( 'Sub-Menu link color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#b1b1b1',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '#classic-menu .sub-menu li a, #classic-menu .sub-menu li a:hover',
                    'function' => 'css',
                    'property' => 'color',
                ),
            ),
            'output'         => array(
                array(
                    'element'  => '#classic-menu .sub-menu li a, #classic-menu .sub-menu li a:hover',
                    'function' => 'css',
                    'property' => 'color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'light',
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => 'in',
                    'value'    => array( 'bordered', 'classic' )
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // ----------------------------------------------   Dark
        // Headings Color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_headings',
            'label'           => esc_html__( 'Headings Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#f5f5f5',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'body.eram-theme-dark h1, body.eram-theme-dark .h1, body.eram-theme-dark h2, body.eram-theme-dark .h2, body.eram-theme-dark h3, body.eram-theme-dark .h3, body.eram-theme-dark h4, body.eram-theme-dark .h4, body.eram-theme-dark h5, body.eram-theme-dark .h5, body.eram-theme-dark h6, body.eram-theme-dark .h6,body.eram-theme-dark .em-blog-post.layout-masonry .post-contents .title a,body.eram-theme-dark .gallery-page-title-top .gallery-top.page-head .gallery-title,body.eram-theme-dark .em-blog-wrapper.layout-classic .em-blog-posts a,body.eram-theme-dark .em-blog-post.layout-classic .post-date,body.eram-theme-dark .author-bio .author-bio-content h4 a,body.eram-theme-dark .em-blog-post.layout-classic .title a,body.eram-theme-dark .em-client-box .client-name h3 a',
                    'function' => 'css',
                    'property' => 'color',
                ),
                array(
                    'element'  => 'body.eram-theme-dark .em-blog-post.layout-masonry .post-contents .title a:hover,body.eram-theme-dark .em-blog-wrapper.layout-classic .em-blog-posts a:hover,body.eram-theme-dark .author-bio .author-bio-content h4 a:hover,body.eram-theme-dark .em-blog-post.layout-classic .title a:hover,body.eram-theme-dark .em-client-box .client-name h3 a:hover',
                    'function' => 'css',
                    'property' => 'color',
                ),
                array(
                    'element'  => 'body.eram-theme-dark .simple-page-head .title-wrapper .page-title:after,body.eram-theme-dark .widget .widget-title:after,#comments .comments-title:after',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // texts color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_text',
            'label'           => esc_html__( 'Paragraph Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#808080',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'body.eram-theme-dark ,body.eram-theme-dark .icon-box.ib-v1 >i,body.eram-theme-dark .ol-price-table .body ul li,body.eram-theme-dark .er-cprtext,body.eram-theme-dark .er-breadcrumbs li, .er-breadcrumbs li a',
                    'function' => 'css',
                    'property' => 'color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // background color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_bg',
            'label'           => esc_html__( 'Background Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#222222',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'body.eram-theme-dark,body.eram-theme-dark .gallery-wrapper,body.eram-theme-dark .gallery-page-title-side .gallery-main,body.eram-theme-dark .gallery-page-title-side .gallery-main,body.eram-theme-dark .em-blog-wrapper.layout-masonry,body.eram-theme-dark .em-single-post .post-comments,body.eram-theme-dark .post-type-archive-eram_client, .portfolio-minimal .page-main',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
                array(
                    'element'  => 'body.eram-theme-dark .em-single-post nav.navigation .prev a,body.eram-theme-dark  .em-single-post nav.navigation .next a,body.eram-theme-dark  .single-eramfolio nav.navigation .prev a,body.eram-theme-dark  .single-eramfolio nav.navigation .next a,body.eram-theme-dark .em-blog-wrapper .post-header.has-bg:before,body.eram-theme-dark  .em-single-post .post-header.has-bg:before',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // boxed background color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_boxed_bg',
            'label'           => esc_html__( 'Boxed Elements Background Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#303030',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'body.eram-theme-dark .vc-card.boxed,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-panel-body,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active >a:hover,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active >a:focus,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab >a:hover,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab >a:focus,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram .vc_tta-panel .vc_tta-panel-heading .vc_tta-panel-title >a,body.eram-theme-dark .ol-price-table.skin-dark,body.eram-theme-dark .em-client-box .inner,body.eram-theme-dark .tagcloud a,body.eram-theme-dark .em-blog-post.layout-masonry .post-contents,body.eram-theme-dark .em-blog-wrapper .format-embed,body.eram-theme-dark .em-single-post .format-embed',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
                array(
                    'element'  => 'body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram .vc_tta-panel .vc_tta-panel-heading .vc_tta-panel-title >a:hover,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram .vc_tta-panel .vc_tta-panel-heading .vc_tta-panel-title >a:focus,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram .vc_tta-panel.vc_active .vc_tta-panel-heading .vc_tta-panel-title >a,body.eram-theme-dark .tagcloud a:hover',
                    'function' => 'css',
                    'property' => 'background-color',
                ),

            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // border color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_border',
            'label'           => esc_html__( 'Border Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#363636',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'body.eram-theme-dark .single-eramfolio .page-contents .the-meta,.em-single-post nav.navigation,body.eram-theme-dark  .single-eramfolio nav.navigation,body.eram-theme-dark .em-blog-post.layout-minimal,body.eram-theme-dark .widget .widget-title,body.eram-theme-dark .simple-page-head .title-wrapper .page-title:before,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-panels,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active,body.eram-theme-dark .ol-price-table.skin-dark,body.eram-theme-dark .page-footer,body.eram-theme-dark .em-blog-post.layout-classic .post-date,body.eram-theme-dark .vc-card .links, body.eram-theme-dark .vc-card.boxed',
                    'function' => 'css',
                    'property' => 'border-color',
                ),
                array(
                    'element'  => 'body.eram-theme-dark .em-blog-wrapper.layout-minimal.with-sidebar .blog-contents:before,body.eram-theme-dark .em-blog-wrapper.layout-masonry.with-sidebar .blog-contents:before,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active:after',
                    'function' => 'css',
                    'property' => 'background-color',
                ),

            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // Link color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_link',
            'label'           => esc_html__( 'Link Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#cccccc',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'body.eram-theme-dark a',
                    'function' => 'css',
                    'property' => 'color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // footer bg color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_footer_bg',
            'label'           => esc_html__( 'Footer Background Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#1b1b1b',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '.eram-theme-dark .em-footer-section',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'output'         => array(
                array(
                    'element'  => '.eram-theme-dark .em-footer-section',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // footer border color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_footer_border_color',
            'label'           => esc_html__( 'Footer Border Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#303030',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '.eram-theme-dark .em-footer-section .footer-main',
                    'function' => 'css',
                    'property' => 'border-color',
                ),
            ),
            'output'         => array(
                array(
                    'element'  => '.eram-theme-dark .em-footer-section .footer-main',
                    'function' => 'css',
                    'property' => 'border-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // footer bottom background color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_footer_bottom_bg',
            'label'           => esc_html__( 'Footer Bottom Background Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#1b1b1b',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '.eram-theme-dark .em-footer-section .footer-bottom',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'output'         => array(
                array(
                    'element'  => '.eram-theme-dark .em-footer-section .footer-bottom',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // footer bottom border color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_footer_bottom_border_color',
            'label'           => esc_html__( 'Footer Bottom - Border Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#303030',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => '.eram-theme-dark .em-footer-section .footer-bottom .footer-bottom-wrapper:after',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'output'         => array(
                array(
                    'element'  => '.eram-theme-dark .em-footer-section .footer-bottom .footer-bottom-wrapper:after',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // Sidebar background color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_side_bg',
            'label'           => esc_html__( 'Sidebar Background', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#2c2c2c',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'body.eram-theme-dark #side-header .side-inner',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'side',
                ),
            )
        ) );

        // Sidebar menu color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_side_menu_item',
            'label'           => esc_html__( 'Menu Item Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#888888',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'body.eram-theme-dark .slide-menu-wrapper a,body.eram-theme-dark .hamburger-wrapper .ham-label',
                    'function' => 'css',
                    'property' => 'color',
                ),
                array(
                    'element'  => 'body.eram-theme-dark .slide-menu-wrapper a span:before,body.eram-theme-dark .hamburger-inner, body.eram-theme-dark .hamburger-inner::before, body.eram-theme-dark .hamburger-inner::after',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'side',
                ),
            )
        ) );

        // Sidebar menu hover and active
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_side_menu_item_hover',
            'label'           => esc_html__( 'Active Menu Item Color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#f5f5f5',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'body.eram-theme-dark .slide-menu-wrapper li.current-menu-item > a,body.eram-theme-dark .slide-menu-wrapper li.current-menu-parent > a,body.eram-theme-dark .slide-menu-wrapper li.current-menu-ancestor > a,body.eram-theme-dark .slide-menu-wrapper li.active > a,body.eram-theme-dark .slide-menu-wrapper a:hover',
                    'function' => 'css',
                    'property' => 'color',
                ),
                array(
                    'element'  => 'body.eram-theme-dark .slide-menu-wrapper a:hover span:before',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'side',
                ),
            )
        ) );

        // frame color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_frame',
            'label'           => esc_html__( 'Frame color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#2c2c2c',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'body.eram-theme-dark.er-bordered-layout .er-top-bar,body.eram-theme-dark.er-bordered-layout .er-bottom-bar,body.eram-theme-dark.er-bordered-layout .er-left-bar,body.eram-theme-dark.er-bordered-layout .er-right-bar,body.eram-theme-dark.er-full-layout .er-top-bar,body.eram-theme-dark.er-full-layout .er-bottom-bar,body.eram-theme-dark.er-full-layout .er-left-bar,body.eram-theme-dark.er-full-layout .er-right-bar',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'bordered',
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // Header bg color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_header_bg',
            'label'           => esc_html__( 'Header Background', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#2c2c2c',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'body.eram-theme-dark #classic-header,body.eram-theme-dark #top-header',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => 'in',
                    'value'    => array( 'classic', 'top' )
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // Top menu item color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_top_menu_item',
            'label'           => esc_html__( 'Menu item color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#c0c0c0',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'body.eram-theme-dark #top-header .menu-wrapper li a',
                    'function' => 'css',
                    'property' => 'color',
                ),
                array(
                    'element'  => 'body.eram-theme-dark #top-header .menu-wrapper li a >span:after',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => '==',
                    'value'    => 'top'
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // classic menu item color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_classic_menu',
            'label'           => esc_html__( 'Menu item color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#c0c0c0',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'body.eram-theme-dark #classic-menu >li > a,body.eram-theme-dark #classic-menu li a',
                    'function' => 'css',
                    'property' => 'color',
                ),
                array(
                    'element'  => 'body.eram-theme-dark .hamburger-inner, body.eram-theme-dark .hamburger-inner::before, body.eram-theme-dark .hamburger-inner::after',
                    'function' => 'css',
                    'property' => 'background-color',
                ),

            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => 'in',
                    'value'    => array( 'bordered', 'classic' )
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // classic menu item color hover
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_classic_menu_hover',
            'label'           => esc_html__( 'Active Menu item color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#ffffff',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'body.eram-theme-dark #classic-menu >li > a:hover,body.eram-theme-dark #classic-menu .current-menu-parent > a,body.eram-theme-dark  #classic-menu .current-menu-item > a,body.eram-theme-dark  #classic-menu .current-menu-ancestor > a,body.eram-theme-dark #classic-menu li a:hover,body.eram-theme-dark  #classic-menu li a:focus',
                    'function' => 'css',
                    'property' => 'color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => 'in',
                    'value'    => array( 'bordered', 'classic' )
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // classic menu item bg
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_classic_menu_bg',
            'label'           => esc_html__( 'Sub-Menu background color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#1e1e1e',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'body.eram-theme-dark #classic-menu ul.sub-menu',
                    'function' => 'css',
                    'property' => 'background-color',
                ),
                array(
                    'element'  => 'body.eram-theme-dark #classic-menu >li>ul.sub-menu>li ul.sub-menu',
                    'function' => 'css',
                    'property' => 'border-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => 'in',
                    'value'    => array( 'bordered', 'classic' )
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        // classic menu item color
        Kirki::add_field( $this->config_id, array(
            'type'            => 'color',
            'settings'        => 'eram_cd_classic_menu_item',
            'label'           => esc_html__( 'Sub-Menu link color', 'eram' ),
            'section'         => 'eram_color_section',
            'default'         => '#b1b1b1',
            'priority'        => 10,
            'alpha'           => FALSE,
            'transport'       => 'postMessage',
            'js_vars'         => array(
                array(
                    'element'  => 'body.eram-theme-dark #classic-menu .sub-menu li a, body.eram-theme-dark #classic-menu .sub-menu li a:hover',
                    'function' => 'css',
                    'property' => 'color',
                ),
            ),
            'output'         => array(
                array(
                    'element'  => 'body.eram-theme-dark #classic-menu .sub-menu li a, body.eram-theme-dark #classic-menu .sub-menu li a:hover',
                    'function' => 'css',
                    'property' => 'color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_color_theme',
                    'operator' => '==',
                    'value'    => 'dark',
                ),
                array(
                    'setting'  => 'eram_site_layout',
                    'operator' => 'in',
                    'value'    => array( 'bordered', 'classic' )
                ),
                array(
                    'setting'  => 'eram_use_custom_colors',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

    }

    private function add_earm_password_protected_section_fields()
    {
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'text',
            'settings' => 'eram_ppp_title',
            'label'    => esc_html__( 'Title', 'eram' ),
            'section'  => 'eram_password_protected_section',
            'default'  => esc_html__( 'Password Protected Area', 'eram' ),
            'priority' => 10,
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'textarea',
            'settings' => 'eram_ppp_text',
            'label'    => esc_html__( 'Description Text', 'eram' ),
            'section'  => 'eram_password_protected_section',
            'default'  => esc_html__( 'This area is restricted and you need a password to access it.', 'eram' ),
            'priority' => 10,
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'image',
            'settings'    => 'eram_ppp_bg',
            'label'       => esc_html__( 'Background Image', 'eram' ),
            'description' => esc_html__( 'Page Background Image', 'eram' ),
            'section'     => 'eram_password_protected_section',
            'default'     => '',
            'priority'    => 10,
        ) );
    }

    private function add_eram_page_headers_section_fields()
    {
        $section = 'eram_page_headers_section';
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eram_has_parallax',
            'label'    => esc_html__( 'Use Parallax for Page Headers', 'eram' ),
            'section'  => $section,
            'default'  => 1,
            'priority' => 10,
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'slider',
            'settings'    => 'eram_top_header_height',
            'label'       => esc_html__( 'Page Top Headers Height', 'eram' ),
            'description' => esc_html__( 'Some pages will use top header with cover image. This sets how much of the page will be covered by the header, in percent of page height', 'eram' ),
            'section'     => $section,
            'default'     => 60,
            'priority'    => 10,
            'choices'     => array(
                'min'  => 40,
                'max'  => 100,
                'step' => 10,
            ),
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eram_page_header_overlay',
            'label'    => esc_html__( 'Add Overlay to Page Headers', 'eram' ),
            'section'  => $section,
            'default'  => 1,
            'priority' => 10,
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eram_page_header_custom_colors',
            'label'    => esc_html__( 'Custom Colors', 'eram' ),
            'section'  => $section,
            'default'  => 0,
            'priority' => 10,
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'color',
            'settings' => 'eram_page_header_overlay_color',
            'label'    => esc_html__( 'Page Header Overlay Color', 'eram' ),
            'section'  => $section,
            'default'  => 'rgba(0,0,0,0.5)',
            'priority' => 10,
            'choices'     => array(
                'alpha' => true,
            ),
            'active_callback'    => array(
                array(
                    'setting'  => 'eram_page_header_overlay',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'eram_page_header_custom_colors',
                    'operator' => '==',
                    'value'    => true,
                ),
            ),
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'color',
            'settings' => 'eram_page_header_contents_color',
            'label'    => esc_html__( 'Page Header Contents Color', 'eram' ),
            'section'  => $section,
            'default'  => '#ffffff',
            'priority' => 10,
            'active_callback'    => array(
                array(
                    'setting'  => 'eram_page_header_overlay',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'eram_page_header_custom_colors',
                    'operator' => '==',
                    'value'    => true,
                ),
            ),
        ) );
    }

    private function add_eram_404_section_fields()
    {
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'text',
            'settings' => 'eram_404_title',
            'label'    => esc_html__( 'Title', 'eram' ),
            'section'  => 'eram_404_section',
            'default'  => esc_html__( '[ 404 ]', 'eram' ),
            'priority' => 10,
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'textarea',
            'settings' => 'eram_404_text',
            'label'    => esc_html__( 'Description Text', 'eram' ),
            'section'  => 'eram_404_section',
            'default'  => esc_html__( 'We were unable to find that page!', 'eram' ),
            'priority' => 10,
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'image',
            'settings'    => 'eram_404_bg',
            'label'       => esc_html__( 'Background Image', 'eram' ),
            'description' => esc_html__( 'Page Background Image', 'eram' ),
            // 'help'        => esc_html__( 'This is some extra help text.', 'eram' ),
            'section'     => 'eram_404_section',
            'default'     => '',
            'priority'    => 10,
        ) );
    }

    private function add_eram_social_section_fields()
    {


        $social_icons = eram_social_networks_list();

        Kirki::add_field( $this->config_id, array(
            'type'      => 'repeater',
            'label'     => esc_html__( 'Social Networks', 'eram' ),
            'section'   => 'eram_social_section',
            'priority'  => 10,
            'row_label' => array(
                'type'  => 'text',
                'value' => esc_html__( 'Social', 'eram' ),
            ),
            'settings'  => 'eram_social_icons',
            'default'   => array(),
            'fields'    => array(
                'media'    => array(
                    'type'    => 'select',
                    'label'   => esc_html__( 'Media', 'eram' ),
                    'default' => 'facebook',
                    'choices' => $social_icons,
                ),
                'link_url' => array(
                    'type'    => 'text',
                    'label'   => esc_html__( 'Link URL', 'eram' ),
                    'default' => '#',
                ),
            ),
        ) );

    }

    private function add_eram_social_sharing_section_fields()
    {
        $social_sharings = array(
            'none'        => esc_html__( 'choone one', 'eram' ),
            'facebook'    => esc_html__( 'Facebook', 'eram' ),
            'twitter'     => esc_html__( 'Twitter', 'eram' ),
            'digg'        => esc_html__( 'Digg', 'eram' ),
            'linkedin'    => esc_html__( 'LinkedIn', 'eram' ),
            'google-plus' => esc_html__( 'Google Plus', 'eram' ),
            'pinterest'   => esc_html__( 'Pinterest', 'eram' ),
            'tumblr'      => esc_html__( 'Tumblr', 'eram' ),
            'reddit'      => esc_html__( 'Reddit', 'eram' ),
            'delicious'   => esc_html__( 'Delicious', 'eram' ),
        );

        Kirki::add_field( $this->config_id, array(
            'type'      => 'repeater',
            'label'     => esc_html__( 'Social Websites', 'eram' ),
            'section'   => 'eram_social_sharing_section',
            'priority'  => 10,
            'row_label' => array(
                'type'  => 'text',
                'value' => esc_html__( 'website', 'eram' ),
            ),
            'settings'  => 'eram_social_sharings',
            'default'   => array(),
            'fields'    => array(
                'icon' => array(
                    'type'    => 'select',
                    'label'   => esc_html__( 'Website', 'eram' ),
                    'default' => 'facebook',
                    'choices' => $social_sharings,
                ),
            ),
        ) );
    }

    private function add_eram_blog_archive_section_fields()
    {
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'radio-image',
            'settings' => 'eram_blog_archive_layout',
            'label'    => esc_html__( 'Archive Layout', 'eram' ),
            'section'  => 'eram_blog_archive_section',
            'default'  => 'masonry',
            'priority' => 10,
            'choices'  => array(
                'minimal' => ERAM_IMAGES . '/archive-layout-minimal.jpg',
                'masonry' => ERAM_IMAGES . '/archive-layout-masonry.jpg',
                'classic' => ERAM_IMAGES . '/archive-layout-classic.jpg',
            ),
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'toggle',
            'settings'    => 'eram_blog_show_title',
            'label'       => esc_html__( 'Show Title', 'eram' ),
            'description' => esc_html__( 'Show Title ( and description) at top of the page.', 'eram' ),
            'section'     => 'eram_blog_archive_section',
            'default'     => 1,
            'priority'    => 10,
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'text',
            'settings'        => 'eram_blog_archive_title',
            'label'           => esc_html__( 'Blog Title', 'eram' ),
            'section'         => 'eram_blog_archive_section',
            'default'         => esc_html__( 'Our Journal', 'eram' ),
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_blog_show_title',
                    'operator' => '==',
                    'value'    => 1,
                ),
            ),
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'textarea',
            'settings'        => 'eram_blog_archive_description',
            'label'           => esc_html__( 'Blog Description', 'eram' ),
            'section'         => 'eram_blog_archive_section',
            'default'         => '',
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_blog_show_title',
                    'operator' => '==',
                    'value'    => 1,
                ),
            ),
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'image',
            'settings'        => 'eram_blog_archive_cover',
            'label'           => esc_html__( 'Cover Image', 'eram' ),
            'section'         => 'eram_blog_archive_section',
            'default'         => '',
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_blog_show_title',
                    'operator' => '==',
                    'value'    => 1,
                ),
            ),
        ) );


        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'select',
            'settings' => 'eram_blog_show_sidebar',
            'label'    => esc_html__( 'Select Sidebar', 'eram' ),
            'section'  => 'eram_blog_archive_section',
            'default'  => 'no-sidebar',
            'priority' => 10,
            'choices'  => $this->sidebars,
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'toggle',
            'settings'    => 'eram_blog_show_author',
            'label'       => esc_html__( 'Show Author', 'eram' ),
            'description' => esc_html__( 'Show post author linked name', 'eram' ),
            'section'     => 'eram_blog_archive_section',
            'default'     => 1,
            'priority'    => 10,
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'toggle',
            'settings'    => 'eram_blog_show_date',
            'label'       => esc_html__( 'Show Date', 'eram' ),
            'description' => esc_html__( 'Show post dates', 'eram' ),
            'section'     => 'eram_blog_archive_section',
            'default'     => 1,
            'priority'    => 10,
        ) );


        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'toggle',
            'settings'    => 'eram_blog_show_categories',
            'label'       => esc_html__( 'Show Categories', 'eram' ),
            'description' => esc_html__( 'Show post linked categories', 'eram' ),
            'section'     => 'eram_blog_archive_section',
            'default'     => 1,
            'priority'    => 10,
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'toggle',
            'settings'        => 'eram_blog_show_excerpt',
            'label'           => esc_html__( 'Show Post Excerpt', 'eram' ),
            'description'     => esc_html__( 'Show post excerpt', 'eram' ),
            'section'         => 'eram_blog_archive_section',
            'default'         => 1,
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_blog_archive_layout',
                    'operator' => '==',
                    'value'    => 'classic',
                ),
            ),
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'toggle',
            'settings'        => 'eram_blog_show_read_more',
            'label'           => esc_html__( 'Show Read More Link', 'eram' ),
            'description'     => esc_html__( 'Show a read more link for each post', 'eram' ),
            'section'         => 'eram_blog_archive_section',
            'default'         => 1,
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_blog_archive_layout',
                    'operator' => 'in',
                    'value'    => array( 'classic', 'masonry' ),
                ),
            ),
        ) );

    }

    private function add_eram_blog_post_section_fields()
    {
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'radio-image',
            'settings' => 'eram_post_layout',
            'label'    => esc_html__( 'Post Page Layout', 'eram' ),
            'section'  => 'eram_blog_post_section',
            'default'  => 'modern',
            'priority' => 10,
            'choices'  => array(
                'modern'  => ERAM_IMAGES . '/post-layout-modern.jpg',
                'side'    => ERAM_IMAGES . '/post-layout-side.jpg',
                'classic' => ERAM_IMAGES . '/post-layout-classic.jpg',
            ),
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'select',
            'settings'        => 'eram_post_show_sidebar',
            'label'           => esc_html__( 'Select Sidebar', 'eram' ),
            'section'         => 'eram_blog_post_section',
            'default'         => 'no-sidebar',
            'priority'        => 10,
            'choices'         => $this->sidebars,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_post_layout',
                    'operator' => '==',
                    'value'    => 'classic',
                ),
            ),
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'toggle',
            'settings'    => 'eram_post_show_author',
            'label'       => esc_html__( 'Show Author', 'eram' ),
            'description' => esc_html__( 'Show post author name?', 'eram' ),
            'section'     => 'eram_blog_post_section',
            'default'     => 1,
            'priority'    => 10,
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'toggle',
            'settings'    => 'eram_post_show_author_bio',
            'label'       => esc_html__( 'Show Author Bio and Contacts', 'eram' ),
            'description' => esc_html__( 'Show post author biography?', 'eram' ),
            'section'     => 'eram_blog_post_section',
            'tooltip'     => esc_html__( 'Each author can set contacts at their profile.', 'eram' ),
            'default'     => 1,
            'priority'    => 10,
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'toggle',
            'settings'    => 'eram_post_show_date',
            'label'       => esc_html__( 'Show Date', 'eram' ),
            'description' => esc_html__( 'Show post date?', 'eram' ),
            'section'     => 'eram_blog_post_section',
            'default'     => 1,
            'priority'    => 10,
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'toggle',
            'settings'    => 'eram_post_show_categories',
            'label'       => esc_html__( 'Show Post Categories', 'eram' ),
            'description' => esc_html__( 'Show post linked categories?', 'eram' ),
            'section'     => 'eram_blog_post_section',
            'default'     => 1,
            'priority'    => 10,
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'toggle',
            'settings'    => 'eram_post_show_tags',
            'label'       => esc_html__( 'Show Post Tags', 'eram' ),
            'description' => esc_html__( 'Show post linked tags?', 'eram' ),
            'section'     => 'eram_blog_post_section',
            'default'     => 1,
            'priority'    => 10,
        ) );

    }

    // eram_sidebars_section
    private function add_eram_sidebars_section_fields()
    {
        Kirki::add_field( $this->config_id, array(
            'type'      => 'repeater',
            'label'     => esc_html__( 'Sidebars', 'eram' ),
            'section'   => 'eram_sidebars_section',
            'priority'  => 10,
            'row_label' => array(
                'type'  => 'text',
                'value' => esc_html__( 'sidebar', 'eram' ),
            ),
            'settings'  => 'eram_dynamic_sidebars',
            'default'   => array(),
            'fields'    => array(
                'sidebar' => array(
                    'type'        => 'text',
                    'label'       => esc_html__( 'Unique Name', 'eram' ),
                    'description' => esc_html__( 'Give it a unique familiar name to use later.', 'eram' ),
                    'default'     => '',
                ),
            ),
        ) );
    }

    private function add_eram_front_page_section_fields()
    {
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'radio',
            'settings' => 'eram_front_page_is',
            'label'    => esc_html__( 'Front Page', 'eram' ),
            'section'  => 'eram_front_page_section',
            'default'  => 'none',
            'priority' => 10,
            'choices'  => array(
                'none'              => esc_html__( 'Inherit from WordPress Settings', 'eram' ),
                'gallery-archive'   => esc_html__( 'Galleries Archive', 'eram' ),
                //                    'gallery-category'  => esc_html__('A Gallery Category', 'eram'),
                //                    'gallery-single'  => esc_html__('A Single Gallery', 'eram'),
                'portfolio-archive' => esc_html__( 'Portfolio Archive', 'eram' ),
            ),
        ) );
    }

    private function add_eram_typography_section_fields()
    {
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'typography',
            'settings' => 'eram_headeings_typo',
            'label'    => esc_html__( 'Headings', 'eram' ),
            'section'  => 'eram_typography_section',
            'default'  => array(
                'font-family'    => 'Kanit',
                'variant'        => '700',
                'letter-spacing' => '0',
                'subsets'        => array( 'latin-ext' ),
            ),
            'priority' => 10,
            'output'   => array(
                array(
                    'element' => 'h1,h2,h3,h4,h5,h6',
                ),
                array(
                    'element' => 'nav.navigation.next-prev .prev, 
                                      nav.navigation.next-prev .next,
                                      .avatar-wrapper .author',
                ),
            ),
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'typography',
            'settings' => 'eram_body_typo',
            'label'    => esc_html__( 'Body Texts', 'eram' ),
            'section'  => 'eram_typography_section',
            'default'  => array(
                'font-family'    => 'Inconsolata',
                'variant'        => 'regular',
                'line-height'    => '1.4',
                'font-size'      => '16px',
                'letter-spacing' => '0',
                'subsets'        => array( 'latin-ext' ),
            ),
            'priority' => 10,
            'output'   => array(
                array(
                    'element' => 'body',
                ),
            ),
        ) );
    }

    private function add_eram_protect_section_fields()
    {
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'switch',
            'settings'    => 'eram_show_copyright_note',
            'label'       => esc_html__( 'Right-click protect', 'eram' ),
            'description' => esc_html__( 'Disables right click context menu and shows a copyright notification instead, when user right clicks.', 'eram' ),
            'section'     => 'eram_protect_section',
            'default'     => 0,
            'priority'    => 10,
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'text',
            'settings'    => 'eram_copyright_notice',
            'label'       => esc_html__( 'Copyright Notice text', 'eram' ),
            'description' => esc_html__( 'Small note that will be shown upon right click. Leave empty to hide the message.', 'eram' ),
            'section'     => 'eram_protect_section',
            'default'     => 'Copyrighted to ' . get_bloginfo( 'name' ),
            'priority'    => 10,
        ) );

    }

    private function add_eram_custom_css_section_fields()
    {
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'code',
            'settings' => 'eram_custom_css',
            'label'    => esc_html__( 'Custom CSS', 'eram' ),
            'section'  => 'eram_custom_css_section',
            'default'  => 'body{
    margin: 0;
}',
            'priority' => 10,
            'choices'  => array(
                'language' => 'css',
                'theme'    => 'monokai',
                'height'   => 250,
            ),
        ) );
    }

    private function add_eram_custom_js_section_fields()
    {
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'code',
            'settings'    => 'eram_footer_js',
            'label'       => esc_html__( 'Footer Javascript', 'eram' ),
            'description' => esc_html__( '<code>&#x3C;script&#x3E;&#x3C;/script&#x3E;</code> tags are optional.<br>It is recommended to add your custom JavaScript in footer unless you are required to add it in the header.', 'eram' ),
            'section'     => 'eram_custom_js_section',
            'default'     => '',
            'priority'    => 10,
            'choices'     => array(
                'language' => 'javascript',
                'theme'    => 'monokai',
                'height'   => 250,
            ),
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'code',
            'settings'    => 'eram_header_js',
            'label'       => esc_html__( 'Header Javascript', 'eram' ),
            'description' => esc_html__( '<code>&#x3C;script&#x3E;&#x3C;/script&#x3E;</code>tags are optional.', 'eram' ),
            'section'     => 'eram_custom_js_section',
            'default'     => '',
            'priority'    => 10,
            'choices'     => array(
                'language' => 'javascript',
                'theme'    => 'monokai',
                'height'   => 250,
            ),
        ) );
    }

    private function add_eram_shop_list_section_fields()
    {
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'select',
            'settings' => 'eram_shop_layout',
            'label'    => esc_html__( 'Shop Layout', 'eram' ),
            'section'  => 'eram_shop_list_section',
            'default'  => 'full',
            'priority' => 10,
            'choices'  => array(
                'full'          => esc_html__( 'Full', 'eram' ),
                'sidebar-right' => esc_html__( 'Sidebar Right', 'eram' ),
                'sidebar-left'  => esc_html__( 'Sidebar Left', 'eram' )
            )
        ) );

        // shop header
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'select',
            'settings' => 'eram_shop_header',
            'label'    => esc_html__( 'Shop Header', 'eram' ),
            'section'  => 'eram_shop_list_section',
            'default'  => 'simple',
            'priority' => 10,
            'choices'  => array(
                'simple'     => esc_html__( 'Simple', 'eram' ),
                'with-image' => esc_html__( 'With Background', 'eram' ),
                'none'       => esc_html__( "Hide Header", 'eram' ),
            )
        ) );

        //eram_shop_sorting
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'eram_shop_sorting',
            'label'    => esc_html__( 'Show Sorting', 'eram' ),
            'section'  => 'eram_shop_list_section',
            'default'  => 1,
            'priority' => 10,
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'slider',
            'settings' => 'eram_shop_cols',
            'label'    => esc_html__( 'Number of Columns', 'eram' ),
            'section'  => 'eram_shop_list_section',
            'default'  => 4,
            'priority' => 10,
            'choices'  => array(
                'min'  => 2,
                'max'  => 4,
                'step' => 1,
            ),
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'slider',
            'settings'    => 'eram_shop_items',
            'label'       => esc_html__( 'Per Page Products', 'eram' ),
            'description' => esc_html__( "Select the number of products to be shown at each page", 'eram' ),
            'section'     => 'eram_shop_list_section',
            'default'     => 12,
            'priority'    => 10,
            'choices'     => array(
                'min'  => 4,
                'max'  => 40,
                'step' => 1,
            ),
        ) );



    }

    private function add_eram_shop_single_section_fields()
    {
    }

    private function add_eram_shop_general_section_fields()
    {
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'color',
            'settings'    => 'eram_shop_accent_color',
            'label'       => esc_html__( 'Accent Color', 'eram' ),
            'section'     => 'eram_shop_general_section',
            'default'     => '#da7878',
            'priority'    => 10,
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'color',
            'settings'    => 'eram_shop_photo_bg',
            'label'       => esc_html__( 'Photo Gallery Background', 'eram' ),
            'section'     => 'eram_shop_general_section',
            'default'     => '#ededed',
            'priority'    => 10,
        ) );
    }

    private function add_eram_footer_section_fields(){
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'textarea',
            'settings' => 'eram_page_footer_cprtext',
            'label'    => esc_html__( 'Footer Copyright Text', 'eram' ),
            'description' => esc_html__( 'Global copyright text which is also used in site layouts', 'eram' ),
            'section'  => 'eram_footer_section',
            'default'  => esc_html__( '&#169; All Rights Reserved.', 'eram' ),
            'priority' => 10,

        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'toggle',
            'settings'    => 'eram_footer_display',
            'label'       => esc_html__( 'Show Footer', 'eram' ),
            'description' => esc_html__( 'Show/Hide footer globally', 'eram' ),
            'section'     => 'eram_footer_section',
            'default'     => 1,
            'priority'    => 10,
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'select',
            'settings'    => 'eram_footer_layout_width',
            'label'       => esc_html__( 'Footer layout width', 'eram' ),
            'description' => esc_html__( 'Available width for footer contents', 'eram' ),
            'section'     => 'eram_footer_section',
            'choices'     => array(
                'full'      => esc_html__( 'Full width', 'eram' ),
                'contained' => esc_html__( 'Contained', 'eram' ),
            ),
            'default'     => 'contained',
            'priority'    => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_footer_display',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'select',
            'settings'    => 'eg_footer_theme',
            'label'       => esc_html__( 'Footer color theme', 'eram' ),
            'section'     => 'eram_footer_section',
            'default'     => 'default',
            'priority'    => 10,
            'choices'     => array(
                'default'      => esc_html__( 'Default - follow theme main color', 'eram' ),
                'dark'         => esc_html__( 'Dark', 'eram' ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_footer_display',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'toggle',
            'settings'    => 'eram_footer_widgetize',
            'label'       => esc_html__( 'Footer widgets', 'eram' ),
            'description' => esc_html__( 'Enable/Disable Widgetizing footer', 'eram' ),
            'section'     => 'eram_footer_section',
            'default'     => 0,
            'priority'    => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_footer_display',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'select',
            'settings'    => 'eram_footer_widgetize_columns',
            'label'       => esc_html__( 'Widget columns', 'eram' ),
            'description' => esc_html__( 'Number of widget columns', 'eram' ),
            'section'     => 'eram_footer_section',
            'default'     => 3,
            'priority'    => 10,
            'choices'         => array(
                '1'  => esc_html__('One Column', 'eram'),
                '2'  => esc_html__('Two Columns', 'eram'),
                '3'  => esc_html__('Three Columns', 'eram'),
                '4'  => esc_html__('Four Columns', 'eram'),
                '6'  => esc_html__('Six Columns', 'eram'),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_footer_display',
                    'operator' => '==',
                    'value'    => 1,
                ),
                array(
                    'setting'  => 'eram_footer_widgetize',
                    'operator' => '==',
                    'value'    => 1,
                ),
            ),
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'toggle',
            'settings'    => 'eram_footer_bottom_bar',
            'label'       => esc_html__( 'Bottom bar display', 'eram' ),
            'description' => esc_html__( 'Show/Hide bottom bar', 'eram' ),
            'section'     => 'eram_footer_section',
            'default'     => 1,
            'priority'    => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_footer_display',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'select',
            'settings'    => 'eram_footer_bottom_bar_layout',
            'label'       => esc_html__( 'Bottom bar layout ', 'eram' ),
            'description' => esc_html__( 'In side mode, first element would be on left and second element on right side of the bottom bar', 'eram' ),
            'section'     => 'eram_footer_section',
            'default'     => 'centered',
            'priority'    => 10,
            'choices'         => array(
                'centered'  => 'Centered',
                'side'  => 'Side',
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_footer_display',
                    'operator' => '==',
                    'value'    => 1,
                ),
                array(
                    'setting'  => 'eram_footer_bottom_bar',
                    'operator' => '==',
                    'value'    => 1,
                )
            )
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'select',
            'settings'        => 'eram_footer_bottom_first',
            'label'           => esc_html__( 'Bottom First element', 'eram' ),
            'description'     => esc_html__( 'Copyright text option is global and available in theme-settings->footer section', 'eram' ),
            'section'         => 'eram_footer_section',
            'default'         => 'social-icons',
            'priority'        => 10,
            'choices'         => array(
                'copyright-text'   => esc_html__( 'Copyright text', 'eram' ),
                'social-icons'     => esc_html__( 'Social Networks', 'eram' ),
                'custom'           => esc_html__( 'Custom HTML', 'eram' ),
                'none'             => esc_html__( 'None', 'eram' ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_footer_display',
                    'operator' => '==',
                    'value'    => 1,
                ),
                array(
                    'setting'  => 'eram_footer_bottom_bar',
                    'operator' => '==',
                    'value'    => 1,
                )
            ),
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'textarea',
            'settings'        => 'eram_footer_bottom_first_text',
            'label'           => esc_html__( 'Bottom First element text', 'eram' ),
            'description'     => esc_html__( "Supports HTML codes too.", 'eram' ),
            'section'         => 'eram_footer_section',
            'default'         => '',
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_footer_display',
                    'operator' => '==',
                    'value'    => 1,
                ),
                array(
                    'setting'  => 'eram_footer_bottom_bar',
                    'operator' => '==',
                    'value'    => 1,
                ),
                array(
                    'setting'  => 'eram_footer_bottom_first',
                    'operator' => '==',
                    'value'    => 'custom',
                )
            ),
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'select',
            'settings'        => 'eram_footer_bottom_second',
            'label'           => esc_html__( 'Bottom second element', 'eram' ),
            'description'     => esc_html__( 'Social networks can be added/edited in theme-settings->social networks', 'eram' ),
            'section'         => 'eram_footer_section',
            'default'         => 'copyright-text',
            'priority'        => 10,
            'choices'         => array(
                'copyright-text'   => esc_html__( 'Copyright text', 'eram' ),
                'social-icons'     => esc_html__( 'Social Networks', 'eram' ),
                'custom'           => esc_html__( 'Custom HTML', 'eram' ),
                'none'             => esc_html__( 'None', 'eram' ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'eram_footer_display',
                    'operator' => '==',
                    'value'    => 1,
                ),
                array(
                    'setting'  => 'eram_footer_bottom_bar',
                    'operator' => '==',
                    'value'    => 1,
                ),
            ),
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'textarea',
            'settings'        => 'eram_footer_bottom_second_text',
            'label'           => esc_html__( 'Bottom second element text', 'eram' ),
            'description'     => esc_html__( "Supports HTML codes too.", 'eram' ),
            'section'         => 'eram_footer_section',
            'default'         => '',
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_footer_display',
                    'operator' => '==',
                    'value'    => 1,
                ),
                array(
                    'setting'  => 'eram_footer_bottom_bar',
                    'operator' => '==',
                    'value'    => 1,
                ),
                array(
                    'setting'  => 'eram_footer_bottom_second',
                    'operator' => '==',
                    'value'    => 'custom',
                )
            ),
        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'toggle',
            'settings'        => 'eram_footer_for_blog',
            'label'           => esc_html__( 'Show footer on Blog', 'eram' ),
            'description'     => esc_html__( 'If turned ON, it will show footer at Blog whenever possible layout-wise.', 'eram' ),
            'section'         => 'eram_footer_section',
            'default'         => 0,
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'eram_footer_display',
                    'operator' => '==',
                    'value'    => 1,
                ),
            )
        ) );

        if ( class_exists('EramGallery') ) {
            Eram_Kirki::add_field( $this->config_id, array(
                'type'            => 'toggle',
                'settings'        => 'eram_footer_for_galleries',
                'label'           => esc_html__( 'Show footer on Galleries', 'eram' ),
                'description'     => esc_html__( 'If turned ON, it will show footer at galleries whenever possible layout-wise.', 'eram' ),
                'section'         => 'eram_footer_section',
                'default'         => 0,
                'priority'        => 10,
                'active_callback' => array(
                    array(
                        'setting'  => 'eram_footer_display',
                        'operator' => '==',
                        'value'    => 1,
                    ),
                )
            ) );
        }

        if ( class_exists('EramFolio') ) {
            Eram_Kirki::add_field( $this->config_id, array(
                'type'            => 'toggle',
                'settings'        => 'eram_footer_for_portfolios',
                'label'           => esc_html__( 'Show footer on Portfolios', 'eram' ),
                'description'     => esc_html__( 'If turned ON, it will show footer at portfolios whenever possible layout-wise.', 'eram' ),
                'section'         => 'eram_footer_section',
                'default'         => 0,
                'priority'        => 10,
                'active_callback' => array(
                    array(
                        'setting'  => 'eram_footer_display',
                        'operator' => '==',
                        'value'    => 1,
                    ),
                )
            ) );
        }
        if ( class_exists('EramClient') ) {
            Eram_Kirki::add_field( $this->config_id, array(
                'type'            => 'toggle',
                'settings'        => 'eram_footer_for_clients',
                'label'           => esc_html__( 'Show footer on Clients', 'eram' ),
                'description'     => esc_html__( 'If turned ON, it will show footer at Clients pages whenever possible layout-wise.', 'eram' ),
                'section'         => 'eram_footer_section',
                'default'         => 0,
                'priority'        => 10,
                'active_callback' => array(
                    array(
                        'setting'  => 'eram_footer_display',
                        'operator' => '==',
                        'value'    => 1,
                    ),
                )
            ) );
        }
        if ( class_exists('EramProofGallery') ) {
            Eram_Kirki::add_field( $this->config_id, array(
                'type'            => 'toggle',
                'settings'        => 'eram_footer_for_proof_galleries',
                'label'           => esc_html__( 'Show footer on Proof Galleries', 'eram' ),
                'description'     => esc_html__( 'If turned ON, it will show footer at Proof Galleries whenever possible layout-wise.', 'eram' ),
                'section'         => 'eram_footer_section',
                'default'         => 0,
                'priority'        => 10,
                'active_callback' => array(
                    array(
                        'setting'  => 'eram_footer_display',
                        'operator' => '==',
                        'value'    => 1,
                    ),
                )
            ) );
        }
        

    }

}

new Eram_Theme_Customizer();

