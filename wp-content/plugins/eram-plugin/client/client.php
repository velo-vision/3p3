<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Class EramGallery
 */
class EramClient
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


    /**
     * Primary class constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {

        $this->CPTName = 'eram_client';
        $this->CPTSlug = apply_filters( 'eram_client_cpt_slug_filter', 'clients' );

        $this->define_constants();

        // exclude selected galleries from list
        add_action( 'pre_get_posts', array( $this, 'remove_clients_from_loop' ) );

        // add admin menu
        add_action( 'admin_menu', array( $this, 'add_dashboard_menu' ) );

        // prepend admin titles
        add_filter('the_title', array( $this, 'append_hidden_to_title'), 10, 2);

        // admin script
        add_action( 'admin_print_scripts-post-new.php', array( $this, 'admin_script'), 11 );
        add_action( 'admin_print_scripts-post.php', array( $this, 'admin_script'), 11 );
        add_action ( 'admin_print_styles' , array( $this, 'admin_styles') );
        
        // Load the gallery
        $this->init();

    }

    /**
     *
     */
    public function define_constants()
    {
        define( 'ERAM_CLIENT_CPT_NAME', $this->CPTName );
        define( 'ERAM_CLIENT_CPT_SLUG', $this->CPTSlug );
        define( 'ERAM_CLIENT_VERSION', ERAM_PLUGIN_VERSION );
        define( 'ERAM_CLIENT_DIR', plugin_dir_url( $this->file ) );
        define( 'ERAM_CLIENT_CSS_DIR', ERAM_CLIENT_DIR . '/assets/css' );
        define( 'ERAM_CLIENT_JS_DIR', ERAM_CLIENT_DIR . '/assets/js' );
        define( 'ERAM_CLIENT_IMG_DIR', ERAM_CLIENT_DIR . '/assets/img' );
    }

    public function admin_script()
    {
        global $post_type;
        if ( $post_type == ERAM_CLIENT_CPT_NAME ){
            
            wp_register_script(
                'eram-selectize',
                ERAM_CLIENT_JS_DIR . '/selectize.min.js',
                array(),
                '0.12.4',
                false
            );
            wp_enqueue_script( 'eram-selectize' );

            wp_register_script(
                'eram-client-admin',
                ERAM_CLIENT_JS_DIR . '/client-admin.js',
                array(
                    'jquery',
                ),
                ERAM_GALLERY_VERSION,
                true
            );
            wp_enqueue_script( 'eram-client-admin' );

        }   
    }

    public function admin_styles()
    {
        global $post_type;
        if ( $post_type == ERAM_CLIENT_CPT_NAME ){
            wp_enqueue_style( 
                'eram-selectize', 
                ERAM_CLIENT_CSS_DIR . '/selectize.css',
                array(), 
                '0.12.4' 
            );
            wp_enqueue_style( 
                'eram-selectize-theme', 
                ERAM_CLIENT_CSS_DIR . '/selectize.default.css',
                array(), 
                '0.12.4' 
            );
            wp_enqueue_style( 
                'eram-client-admin', 
                ERAM_CLIENT_CSS_DIR . '/client-admin.css',
                array(), 
                ERAM_GALLERY_VERSION 
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

        require plugin_dir_path( $this->file ) . 'includes/admin/metaboxes.php';

    }

    /**
     * Loads all global files into scope.
     *
     * @since 1.0.0
     */
    public function require_global()
    {

        require plugin_dir_path( $this->file ) . 'includes/global/posttype.php';
        require plugin_dir_path( $this->file ) . 'includes/global/helper.php';


    }

    public function remove_clients_from_loop( $query )
    {
        $should_interfere = FALSE;
        $queried = $query->query;
        if ( is_array( $queried ) ) {

            if ( isset( $queried['post_type'] ) ) {
                if ( $queried['post_type'] == ERAM_CLIENT_CPT_NAME )
                    $should_interfere = TRUE;
            }
            // also hide from search
            if ( is_search() )
                $should_interfere = TRUE;
        }

        if ( ! is_admin() && $should_interfere && !is_singular() ) {

            $query->set( 'meta_query',  array(
                'relation' => 'OR',
                array(
                    'key'   => '_ec_exclude_from_loop',
                    'compare' => 'NOT EXISTS',
                    'value' => ''
                ),
                array(
                    'key'   => '_ec_exclude_from_loop',
                    'compare' => '=',
                    'value' => 'off'
                ),
            ));
        }
    }

    public function add_dashboard_menu()
    {

        $page_title = __( 'Customize Clients', 'eram' );
        $menu_title = __( 'Customize Clients', 'eram' );
        $capability = 'edit_theme_options';
        $menu_slug = 'customize.php?url=' . urlencode( site_url() . '?post_type='.ERAM_CLIENT_CPT_NAME ) . '&autofocus[panel]=ec_panel';
        $function = '';
        add_submenu_page( 'edit.php?post_type='.ERAM_CLIENT_CPT_NAME, $page_title, $menu_title, $capability, $menu_slug, $function );
    }

    public function append_hidden_to_title( $title, $id = NULL ) {
        
        if ( ! is_admin() )
            return $title;

        if ( $id ) 
        {
            if ( get_post_type( $id ) == ERAM_CLIENT_CPT_NAME )
            {
                // check if is hidden
                $meta = get_post_meta( $id, '_ec_exclude_from_loop', true);

                if ( $meta )
                    $is_hidden = $meta=='on' ? TRUE : FALSE;
                else
                    $is_hidden = FALSE;

                if ( $is_hidden )
                    $title =  __('[Hidden]','eram') . ' ' . $title;
            }
        }

        return $title;
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
$eram_client = EramClient::get_instance();

