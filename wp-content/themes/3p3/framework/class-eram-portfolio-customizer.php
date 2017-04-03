<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Class Eram_Portfolio_Customizer
 */
class Eram_Portfolio_Customizer
{


    /**
     * @var string
     */
    protected $panel = 'epf_panel';

    /**
     * @var string
     */
    protected $general_section = 'epf_general';

    /**
     * @var string
     */
    protected $archive_section = 'epf_archive';
    /**
     * @var string
     */
    protected $single_section = 'epf_single';
    /**
     * @var string
     */
    protected $category_section = 'epf_categories';

    /**
     * @var string
     */
    protected $filtering_section = 'epf_filtering';

    /**
     * @var string
     */
    protected $config_id = 'epf_settings';

    /**
     * Eram_Portfolio_Customizer constructor.
     */
    public function __construct()
    {
        if ( ! class_exists( 'EramFolio' ) )
            return;


        add_action( 'init', array( $this, 'run' ), 100 );

    }


    /**
     * run the class
     */
    public function run()
    {
        // add styles and scripts
        add_action( 'customize_controls_print_footer_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'customize_controls_print_styles', array( $this, 'enqueue_styles' ) );


        // configure kirki
        $this->config_kirki();

        //add gallery customizer panel
        $this->add_panels();

        // add gallery archive section
        $this->add_sections();

        // add controls
        $this->add_controls();
    }


    /**
     * add styles
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(
            'eg_customizer_css',
            ERAM_CSS . '/eram_customizer_preview.css',
            array(),
            ''
        );
    }

    /**
     * Add Scripts
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            'eg_customizer_js',
            ERAM_SCRIPTS . '/eg-customizer.js',
            array( 'jquery' ),
            ERAM_GALLERY_VERSION,
            TRUE
        );

        wp_localize_script( 'eg_customizer_js', 'egPortfolio', array(
            'btnTitle' => esc_html__( 'Load Portfolio', 'eram' )
        ) );
    }

    /**
     * Kirki configuration
     */
    public function config_kirki()
    {

        Eram_Kirki::add_config( $this->config_id, array(
            'capability'  => 'edit_theme_options',
            'option_type' => 'theme_mod',
        ) );

    }

    /**
     * Adds Panels
     */
    public function add_panels()
    {
        Eram_Kirki::add_panel( $this->panel, array(
            'priority' => 503,
            'title'    => esc_html__( 'Portfolio Settings', 'eram' ),
        ) );
    }

    /**
     * Adds Sections
     */
    public function add_sections()
    {

        Eram_Kirki::add_section( $this->general_section, array(
            'title'          => esc_html__( 'General Settings', 'eram' ),
            'description'    => esc_html__( 'Here you can edit general setting for portfolio', 'eram' ),
            'panel'          => $this->panel,
            'priority'       => 10,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
        ) );

        Eram_Kirki::add_section( $this->archive_section, array(
            'title'          => esc_html__( 'Archive Page', 'eram' ),
            'description'    => esc_html__( 'Here you can edit archive page of Portfolio', 'eram' ),
            'panel'          => $this->panel,
            'priority'       => 10,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
        ) );

        Eram_Kirki::add_section( $this->category_section, array(
            'title'          => esc_html__( 'Categories', 'eram' ),
            'description'    => esc_html__( 'Here you can edit archive page of Portfolio Categories', 'eram' ),
            'panel'          => $this->panel,
            'priority'       => 10,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
        ) );

        Eram_Kirki::add_section( $this->single_section, array(
            'title'          => esc_html__( 'Single Page', 'eram' ),
            'description'    => esc_html__( 'Here you can edit Single Portfolio settings', 'eram' ),
            'panel'          => $this->panel,
            'priority'       => 10,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
        ) );


    }

    /**
     * Adds Controls
     */
    public function add_controls()
    {
        // add archive controls
        $this->add_general_controls();

        // add archive controls
        $this->add_archive_controls();

        // add categories controls
        $this->add_single_controls();

        // add categories controls
        $this->add_category_controls();


    }

    /**
     * Adds general Controls
     */
    private function add_general_controls()
    {
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'toggle',
            'settings'    => 'epf_has_custom_slug',
            'label'       => esc_html__( 'Change Portfolio URL?', 'eram' ),
            'description' => get_post_type_archive_link( ERAM_FOLIO_CPT_NAME ),
            'section'     => $this->general_section,
            'priority'    => 10,
            'default'     => 0,

        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'text',
            'settings'        => 'epf_custom_slug',
            'label'           => esc_html__( 'URL segment', 'eram' ),
            'description'     => sprintf( __( '<code>IMPORTANT:</code> After changing this, go to <a href="%s">Permalink Settings</a> and just hit Save.', 'eram' ), admin_url( 'options-permalink.php' ) ),
            'section'         => $this->general_section,
            'default'         => 'projects',
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'epf_has_custom_slug',
                    'operator' => '==',
                    'value'    => TRUE,
                ),
            )

        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'toggle',
            'settings'    => 'epf_cat_has_custom_slug',
            'label'       => esc_html__( 'Change Category URL?', 'eram' ),
            'description' => esc_html__( 'Currently is:', 'eram' ) . ' ' . ERAM_FOLIO_TAX_SLUG,
            'section'     => $this->general_section,
            'priority'    => 10,
            'default'     => 0,

        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'text',
            'settings'        => 'epf_cat_custom_slug',
            'label'           => esc_html__( 'Category URL segment', 'eram' ),
            'description'     => sprintf( __( '<code>IMPORTANT:</code> After changing this, go to <a href="%s">Permalink Settings</a> and just hit Save.<br> Dont use <strong>category</strong> it is already used for blog.', 'eram' ), admin_url( 'options-permalink.php' ) ),
            'section'         => $this->general_section,
            'default'         => 'portfolio-cat',
            'priority'        => 10,
            'active_callback' => array(
                array(
                    'setting'  => 'epf_cat_has_custom_slug',
                    'operator' => '==',
                    'value'    => TRUE,
                ),
            )

        ) );

        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'radio-image',
            'settings' => 'epf_hover',
            'label'    => esc_html__( 'Portfolio Hover Style', 'eram' ),
            'section'  => $this->general_section,
            'default'  => 'hover-1',
            'priority' => 10,
            'choices'  => array(
                'hover-1' => ERAM_FOLIO_IMG_DIR . '/hover-1.jpg',
                'hover-2' => ERAM_FOLIO_IMG_DIR . '/hover-2.jpg',
            ),
        ) );
    }

    /**
     * Adds archive page Controls
     */
    private function add_archive_controls()
    {


        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'text',
            'settings'        => 'epf_page_title',
            'label'           => esc_html__( 'Page Title', 'eram' ),
            'section'         => $this->archive_section,
            'default'         => esc_html__( 'Awesome Portfolio', 'eram' ),
            'priority'        => 22,
            'active_callback' => array(
                array(
                    'setting'  => 'epf_has_details',
                    'operator' => '==',
                    'value'    => TRUE
                ),
            )
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'textarea',
            'settings'        => 'epf_page_description',
            'label'           => esc_html__( 'Short Description', 'eram' ),
            'section'         => $this->archive_section,
            'default'         => '',
            'priority'        => 23,
            'active_callback' => array(
                array(
                    'setting'  => 'epf_has_details',
                    'operator' => '==',
                    'value'    => TRUE
                ),
            )
        ) );

        //epf_filter_by
        $filterables = array(
            'none'             => esc_html__( 'none', 'eram' ),
            'efcategory'       => esc_html__( 'Portfolio Category', 'eram' ),
            '_epf_meta_client' => esc_html__( 'Client Name', 'eram' ),
            '_epf_meta_date'   => esc_html__( 'Year', 'eram' )
        );
        $dynamic_portfolio_fields = ERAM_Kirki::get_option( 'eram_theme_options', 'epf_custom_fields', array() );
        foreach ( $dynamic_portfolio_fields as $field ) {
            if ( $field['name'] != '' ) {
                $filterables[ '_epf_meta_dynamic_' . sanitize_title_with_dashes( $field['name'] ) ] = $field['name'];
            }
        }
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'radio',
            'settings'        => 'epf_filter_by',
            'label'           => esc_html__( 'Filter By:', 'eram' ),
            'section'         => $this->archive_section,
            'default'         => 'efcategory',
            'choices'         => $filterables,
            'priority'        => 35,
            'active_callback' => array(
                array(
                    'setting'  => 'epf_archive_layout',
                    'operator' => 'in',
                    'value'    => array( 'v_grid', 'v_masonry' )
                ),
            )
        ) );

        $this->get_controls( $this->archive_section, '' );

    }

    /**
     * Adds single page Controls
     */
    private function add_single_controls()
    {
        //epf_enable_date
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'switch',
            'settings' => 'epf_enable_nav',
            'label'    => esc_html__( 'Show next/prev links', 'eram' ),
            'section'  => $this->single_section,
            'priority' => 10,
            'default'  => TRUE,
        ) );
        //epf_enable_sharing
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'switch',
            'settings'    => 'epf_enable_sharing',
            'label'       => esc_html__( 'Enable Sharing Icons', 'eram' ),
            'section'     => $this->single_section,
            'priority'    => 10,
            'default'     => TRUE,
            'description' => esc_html__( 'Enable/Disable Sharing Icons at portfolio single page', 'eram' ),
        ) );
        //epf_enable_client
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'switch',
            'settings' => 'epf_enable_client',
            'label'    => esc_html__( 'Enable Client Field', 'eram' ),
            'section'  => $this->single_section,
            'priority' => 10,
            'default'  => TRUE,
        ) );
        //epf_enable_url
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'switch',
            'settings' => 'epf_enable_url',
            'label'    => esc_html__( 'Enable URL Field', 'eram' ),
            'section'  => $this->single_section,
            'priority' => 10,
            'default'  => TRUE,
        ) );
        //epf_enable_date
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'switch',
            'settings' => 'epf_enable_date',
            'label'    => esc_html__( 'Enable Date Field', 'eram' ),
            'section'  => $this->single_section,
            'priority' => 10,
            'default'  => TRUE,
        ) );
        //epf_custom_fields
        Kirki::add_field( $this->config_id, array(
            'type'        => 'repeater',
            'label'       => esc_html__( 'Portfolio Custom Fields', 'eram' ),
            'section'     => $this->single_section,
            'priority'    => 10,
            'row_label'   => array(
                'type'  => 'text',
                'value' => esc_html__( 'field', 'eram' )
            ),
            'description' => esc_html__( 'You can add custom fields for portfolio items.', 'eram' ),
            'settings'    => 'epf_custom_fields',
            'default'     => array(),
            'fields'      => array(
                'name' => array(
                    'type'        => 'text',
                    'label'       => esc_html__( 'Unique Name', 'eram' ),
                    'description' => esc_html__( 'Give it a unique familiar name to use later.', 'eram' ),
                    'default'     => '',
                ),
                'desc' => array(
                    'type'        => 'text',
                    'label'       => esc_html__( 'Description', 'eram' ),
                    'description' => esc_html__( 'A quick description about this field', 'eram' ),
                    'default'     => esc_html__( 'A quick description about this field', 'eram' ),
                ),
            )
        ) );

    }

    /**
     * Adds category page Controls
     */
    private function add_category_controls()
    {
        // drop down of gallery categories
        remove_theme_mod( 'epf_categories' );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'      => 'select',
            'settings'  => 'epf_categories',
            'label'     => esc_html__( 'Select Category', 'eram' ),
            'section'   => $this->category_section,
            'default'   => '',
            'priority'  => 10,
            'transport' => 'postMessage',
            'multiple'  => 1,
            'choices'   => $this::get_terms_by_slug( array( 'taxonomy' => ERAM_FOLIO_TAX_NAME ), TRUE ),
        ) );

        foreach ( $this::get_terms_by_slug( array( 'taxonomy' => ERAM_FOLIO_TAX_NAME ) ) as $term_slug => $term_name ) {
            $this->get_controls( $this->category_section, $term_slug . '_epf_cat' );
        }

    }


    /**
     * @param array $taxonomies
     * @param bool $default
     * @return array
     */
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

    /**
     * @param $section
     * @param string $suffix
     */
    private function get_controls( $section, $suffix = '' )
    {
        if ( '' != $suffix ) {
            $suffix = '__' . $suffix;
        }

        // ef_has_details
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'epf_has_details' . $suffix,
            'label'    => esc_html__( 'Include Title and Description', 'eram' ),
            'section'  => $section,
            'priority' => 20,
            'default'  => 0,
        ) );

        // ef_details_position
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'image',
            'settings'        => 'epf_archive_cover' . $suffix,
            'label'           => esc_html__( 'Cover Image', 'eram' ),
            'section'         => $section,
            'default'         => '',
            'priority'        => 24,
            'active_callback' => array(
                array(
                    'setting'  => 'epf_has_details' . $suffix,
                    'operator' => '==',
                    'value'    => TRUE
                ),
            )
        ) );


        // ef_archive_layout
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'radio-image',
            'settings' => 'epf_archive_layout' . $suffix,
            'label'    => esc_html__( 'Layout of Thumbnails', 'eram' ),
            'section'  => $section,
            'default'  => 'v_grid',
            'priority' => 30,
            'choices'  => array(
                'v_grid'    => ERAM_FOLIO_IMG_DIR . '/v_grid.jpg',
                'v_masonry' => ERAM_FOLIO_IMG_DIR . '/v_masonry.jpg',
                'justified' => ERAM_FOLIO_IMG_DIR . '/justified.jpg',
                'minimal'   => ERAM_FOLIO_IMG_DIR . '/archive-minimal.jpg',
            ),
        ) );

        // minimal height
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'slider',
            'settings'        => 'epf_minimal_height' . $suffix,
            'label'           => esc_html__( 'Item Height (in pxs)', 'eram' ),
            'description'     => esc_html__( 'Define the height of each portfolio item thumbnail.', 'eram' ),
            'section'         => $section,
            'default'         => 280,
            'priority'        => 30,
            'choices'         => array(
                'min'  => 200,
                'max'  => 500,
                'step' => 10,
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'epf_archive_layout' . $suffix,
                    'operator' => '==',
                    'value'    => 'minimal',
                ),
            )
        ) );

        // ef_masonry_cols
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'slider',
            'settings'        => 'epf_masonry_cols' . $suffix,
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
                    'setting'  => 'epf_archive_layout' . $suffix,
                    'operator' => '==',
                    'value'    => 'v_masonry',
                ),
            )
        ) );


        //ef_grid_cols
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'slider',
            'settings'        => 'epf_grid_cols' . $suffix,
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
                    'setting'  => 'epf_archive_layout' . $suffix,
                    'operator' => '==',
                    'value'    => 'v_grid',
                ),
            )
        ) );

        // ef_grid_thumb_ratio
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'radio-image',
            'settings'        => 'epf_grid_thumb_ratio' . $suffix,
            'label'           => esc_html__( 'Thumbnail Aspect Ratio', 'eram' ),
            'section'         => $section,
            'default'         => 'square',
            'priority'        => 30,
            'choices'         => array(
                'square'    => ERAM_FOLIO_IMG_DIR . '/grid-square.jpg',
                'landscape' => ERAM_FOLIO_IMG_DIR . '/grid-landscape.jpg',
                'portrait'  => ERAM_FOLIO_IMG_DIR . '/grid-portrait.jpg'
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'epf_archive_layout' . $suffix,
                    'operator' => 'contains',
                    'value'    => array( 'v_grid' ),
                ),
            )
        ) );

        // ef_jg_rowheight
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'slider',
            'settings'        => 'epf_jg_rowheight' . $suffix,
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
                    'setting'  => 'epf_archive_layout' . $suffix,
                    'operator' => '==',
                    'value'    => 'justified',
                ),
            )
        ) );

        // ef_items_spacing
        Eram_Kirki::add_field( $this->config_id, array(
            'type'        => 'slider',
            'settings'    => 'epf_items_spacing' . $suffix,
            'label'       => esc_html__( 'Items Spacing', 'eram' ),
            'section'     => $section,
            'priority'    => 30,
            'default'     => 15,
            'choices'     => array(
                'min'  => 0,
                'max'  => 70,
                'step' => 1,
            ),
            'description' => esc_html__( 'Define the desired gutter width (spacing between items in the list). Value is in pixels and default is 15px', 'eram' ),

        ) );

        // ef_scroll_animation
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'radio',
            'settings' => 'epf_scroll_animation' . $suffix,
            'label'    => esc_html__( 'Animation', 'eram' ),
            'section'  => $section,
            'priority' => 30,
            'default'  => 'none',
            'choices'  => array(
                'none'      => esc_html__( 'none', 'eram' ),
                'fadein'    => esc_html__( 'Fade In', 'eram' ),
                'slidefade' => esc_html__( 'Slide Fade In', 'eram' ),
            ),
        ) );

        // ef_social_share
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'toggle',
            'settings' => 'epf_social_share' . $suffix,
            'label'    => esc_html__( 'Enable Social Sharing', 'eram' ),
            'section'  => $section,
            'priority' => 30,
            'default'  => 1,
        ) );

        // ef_load_type
        Eram_Kirki::add_field( $this->config_id, array(
            'type'     => 'radio',
            'settings' => 'epf_load_type' . $suffix,
            'label'    => esc_html__( 'Page Load Enhancement', 'eram' ),
            'section'  => $section,
            'default'  => 'lazy',
            'priority' => 30,
            'tooltip'  => esc_html__( 'Notice: Infinite Scroll option wont preview while viewing in customizer!', 'eram' ),
            'choices'  => array(
                'lazy'     => esc_html__( 'Lazy load Images', 'eram' ),
                'infinite' => esc_html__( 'Infinite Scroll', 'eram' ),
                'none'     => esc_html__( 'None', 'eram' ),
            ),
        ) );

        // ef_infinite_chunk_count
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'slider',
            'settings'        => 'epf_infinite_chunk_count' . $suffix,
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
                    'setting'  => 'epf_load_type' . $suffix,
                    'operator' => '==',
                    'value'    => 'infinite',
                ),
            )
        ) );


    }


}

new Eram_Portfolio_Customizer();