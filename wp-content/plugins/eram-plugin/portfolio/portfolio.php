<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Class EramFolio
 */
class EramFolio
{

    /**
     * Holds the class object.
     *
     * @since 1.0.0
     *
     * @var object
     */
    public static $instance;

    /**
     * Plugin file.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $file = __FILE__;

    /**
     * Custom Post Type's Name
     *
     * @var string
     */
    protected $CPTName;
    protected $CPTSlug;
    protected $tax_name;
    protected $tax_slug;

    /**
     * Primary class constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {

        $this->CPTName = 'eramfolio';
        $this->CPTSlug = apply_filters( 'eram_folio_cpt_slug_filter', 'projects' );

        $this->tax_name = 'efcategory';
        $this->tax_slug = apply_filters( 'eram_folio_cpt_tax_slug_filter', 'portfolio-cat' );

        $this->define_constants();
        
        // add admin menu
        add_action( 'admin_menu', array($this, 'add_dashboard_menu' ) );


        // admin script
        //add_action( 'admin_print_scripts-post-new.php', array($this, 'admin_script'), 11 );
        //add_action( 'admin_print_scripts-post.php', array($this, 'admin_script'), 11 );
        add_action ( 'admin_print_styles' , array($this, 'admin_styles') );
        
        // Load the gallery
        $this->init();

    }

    /**
     *
     */
    public function define_constants()
    {
        define( 'ERAM_FOLIO_CPT_NAME', $this->CPTName );
        define( 'ERAM_FOLIO_CPT_SLUG', $this->CPTSlug );
        define( 'ERAM_FOLIO_TAX_NAME', $this->tax_name );
        define( 'ERAM_FOLIO_TAX_SLUG', $this->tax_slug );
        define( 'ERAM_FOLIO_VERSION', ERAM_PLUGIN_VERSION );
        define( 'ERAM_FOLIO_DIR', plugin_dir_url( $this->file ) );
        define( 'ERAM_FOLIO_CSS_DIR', ERAM_FOLIO_DIR . '/assets/css' );
        define( 'ERAM_FOLIO_JS_DIR', ERAM_FOLIO_DIR . '/assets/js' );
        define( 'ERAM_FOLIO_IMG_DIR', ERAM_FOLIO_DIR . '/assets/img' );
    }

    public function admin_script()
    {
        global $post_type;
        if ( $post_type == ERAM_FOLIO_CPT_NAME ){
            
            // wp_register_script(
            //     'eram-selectize',
            //     ERAM_FOLIO_JS_DIR . '/selectize.min.js',
            //     [],
            //     '0.12.4',
            //     false
            // );
            // wp_enqueue_script( 'eram-selectize' );

           

        }   
    }

    public function admin_styles()
    {
        global $post_type;
        if ( $post_type == ERAM_FOLIO_CPT_NAME ){
            wp_enqueue_style( 
                'eram-admin-portfolio', 
                ERAM_FOLIO_CSS_DIR . '/portfolio-admin.css',
                array(), 
                ERAM_FOLIO_VERSION 
            );
        }
    }
    /**
     * Loads the plugin into WordPress.
     *
     * @since 1.0.0
     */
    public function init()
    {

        // Load admin only components.
        if ( is_admin() ) {
            $this->require_admin();
        }

        // Load global components.
        $this->require_global();

    }

    /**
     * Loads all admin related files into scope.
     *
     * @since 1.0.0
     */
    public function require_admin()
    {

        

    }

    /**
     * Loads all global files into scope.
     *
     * @since 1.0.0
     */
    public function require_global()
    {
        require plugin_dir_path( $this->file ) . 'includes/global/helper.php';
        require plugin_dir_path( $this->file ) . 'includes/global/metaboxes.php';
        require plugin_dir_path( $this->file ) . 'includes/global/posttype.php';
        
    }

    public function add_dashboard_menu()
    {

        $page_title = __( 'Customize Portfolio', 'eram' );
        $menu_title = __( 'Customize Portfolio', 'eram' );
        $capability = 'edit_theme_options';
        $menu_slug = 'customize.php?url=' . urlencode( site_url() . '?post_type='.ERAM_FOLIO_CPT_NAME ) . '&autofocus[panel]=epf_panel';
        $function = '';
        add_submenu_page( 'edit.php?post_type='.ERAM_FOLIO_CPT_NAME, $page_title, $menu_title, $capability, $menu_slug, $function );
    }

    /**
     * Returns the instance of the class.
     *
     * @since 1.0.0
     *
     * @return object
     */
    public static function get_instance()
    {

        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;

    }

}

// Load the main plugin class.
$eram_folio = EramFolio::get_instance();

