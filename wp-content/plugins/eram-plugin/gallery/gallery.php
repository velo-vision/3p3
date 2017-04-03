<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Class EramGallery
 */
class EramGallery
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
    protected $category_tax;
    protected $category_slug;


    /**
     * Primary class constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {

        $this->CPTName = 'eramgallery';
        $this->CPTSlug = apply_filters( 'eramGallery_cpt_slug_filter', 'gallery' );
        $this->category_tax = 'egcategory';
        $this->category_slug = apply_filters( 'eramGallery_cpt_tax_filter', 'egcategory' );

        $this->define_constants();


        if ( $this->isLiveEditPage() ) {
            add_action( 'current_screen', array( $this, 'initLiveEditor' ) );
        }

        // add admin menu
        add_action( 'admin_menu', array( $this, 'add_dashboard_menu' ) );

        // prepend admin titles
        add_filter('the_title', array( $this, 'append_hidden_to_title'), 10, 2);

        // exclude selected galleries from list
        add_action( 'pre_get_posts', array( $this, 'remove_galleries_from_loop' ) );

        add_action ( 'admin_print_styles' , array($this, 'admin_styles') );
        
        // Load the gallery
        $this->init();

    }

    public function admin_styles()
    {
        global $post_type;
        if ( $post_type == ERAM_GALLERY_CPT_NAME ){
            wp_enqueue_style(
                'eram-admin-gallery',
                ERAM_GALLERY_CSS_DIR . '/admin.css',
                array(),
                ERAM_GALLERY_VERSION
            );
        }
    }
    
    /**
     *
     */
    public function define_constants()
    {
        define( 'ERAM_GALLERY_CATEGORY_TAX', $this->category_tax );
        define( 'ERAM_GALLERY_CATEGORY_SLUG', $this->category_slug );
        define( 'ERAM_GALLERY_CPT_NAME', $this->CPTName );
        define( 'ERAM_GALLERY_CPT_SLUG', $this->CPTSlug );
        define( 'ERAM_GALLERY_VERSION', ERAM_PLUGIN_VERSION );
        define( 'ERAM_GALLERY_DIR', plugin_dir_url( $this->file ) );
        define( 'ERAM_GALLERY_CSS_DIR', ERAM_GALLERY_DIR . '/assets/css' );
        define( 'ERAM_GALLERY_JS_DIR', ERAM_GALLERY_DIR . '/assets/js' );
        define( 'ERAM_GALLERY_IMG_DIR', ERAM_GALLERY_DIR . '/assets/img' );
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

        require plugin_dir_path( $this->file ) . 'includes/admin/class-add-customizer.php';
        require plugin_dir_path( $this->file ) . 'includes/admin/metaboxes.php';
        require plugin_dir_path( $this->file ) . 'includes/admin/class-add-media-fields.php';

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

    /**
     *
     */
    public function initLiveEditor()
    {
        require plugin_dir_path( $this->file ) . 'includes/admin/class-ol-live-editor.php';
    }

    /**
     * @return bool
     */
    private function isLiveEditPage()
    {

        return ( is_admin() && $GLOBALS['pagenow'] == 'post.php' && $this->getEditMode() == 'ol_live_edit' );
    }

    /**
     * @return string
     */
    private function getEditMode()
    {
        $editMode = 'default';

        if ( isset( $_GET['ol_edit_mode'] ) ) {
            $editMode = $_GET['ol_edit_mode'];
        }

        return $editMode;
    }

    public function add_dashboard_menu()
    {

        $page_title = __( 'Customize Gallery', 'eram' );
        $menu_title = __( 'Customize Gallery', 'eram' );
        $capability = 'edit_theme_options';
        $menu_slug = 'customize.php?url=' . urlencode( site_url() . '?post_type=eramgallery' ) . '&autofocus[panel]=eg_panel';
        $function = '';
        add_submenu_page( 'edit.php?post_type=eramgallery', $page_title, $menu_title, $capability, $menu_slug, $function );
    }


    public function remove_galleries_from_loop( $query )
    {
        if (is_singular() )
            return;
        
        $should_interfere = FALSE;
        $queried = $query->query;
        if ( is_array( $queried ) ) {
            if ( isset( $queried[ERAM_GALLERY_CATEGORY_TAX] ) )
                $should_interfere = TRUE;

            if ( isset( $queried['post_type'] ) ) {
                if ( $queried['post_type'] == ERAM_GALLERY_CPT_NAME ){
                    $should_interfere = TRUE;
                }
            }
             // also hide from search
            if ( is_search() )
                $should_interfere = TRUE;
        }

        $go = false;
        if ( $should_interfere)
        {
            if ( defined( 'DOING_AJAX' ) ){
                if ( isset( $_POST['tag']) ){
                    if ($_POST['tag']=='eram_single_gallery')
                        $go = false;
                }else{
                    $go = true;
                }
            }
            elseif( is_admin() ){
                $go = false;
            }else{
                $go = true;
            }
        }

        if ( $go ) {
            $query->set( 'meta_query',  array(
                'relation' => 'OR',
                array(
                    'key'   => '_eg_exclude_from_loop',
                    'compare' => 'NOT EXISTS',
                    'value' => ''
                ),
                array(
                    'key'   => '_eg_exclude_from_loop',
                    'compare' => '=',
                    'value' => 'off'
                ),
            ));
        }
    }

    public function append_hidden_to_title( $title, $id = NULL ) {
        
        if ( ! is_admin() )
            return $title;

        if ( $id ) 
        {
            if ( get_post_type( $id ) == ERAM_GALLERY_CPT_NAME )
            {
                // check if is hidden
                $meta = get_post_meta( $id, '_eg_exclude_from_loop', true);

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
}

// Load the main plugin class.
$eram_gallery = EramGallery::get_instance();

