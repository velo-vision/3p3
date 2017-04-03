<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Class EramGallery
 */
class EramProofGallery
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

        $this->CPTName = 'proofgallery';
        $this->CPTSlug = apply_filters( 'eramProofGallery_cpt_slug_filter', 'proof-gallery' );

        $this->define_constants();

        add_action ( 'admin_print_styles' , array($this, 'admin_styles') );

        // Load the gallery
        $this->init();

    }

    /**
     *
     */
    public function define_constants()
    {
        define( 'ERAM_PROOF_GALLERY_CPT_NAME', $this->CPTName );
        define( 'ERAM_PROOF_GALLERY_CPT_SLUG', $this->CPTSlug );
        define( 'ERAM_PROOF_GALLERY_VERSION', ERAM_PLUGIN_VERSION );
        define( 'ERAM_PROOF_GALLERY_DIR', plugin_dir_url( $this->file ) );
        define( 'ERAM_PROOF_GALLERY_CSS_DIR', ERAM_PROOF_GALLERY_DIR . '/assets/css' );
        define( 'ERAM_PROOF_GALLERY_JS_DIR', ERAM_PROOF_GALLERY_DIR . '/assets/js' );
        define( 'ERAM_PROOF_GALLERY_IMG_DIR', ERAM_PROOF_GALLERY_DIR . '/assets/img' );
    }

    public function admin_styles()
    {
        global $post_type;
        if ( $post_type == ERAM_PROOF_GALLERY_CPT_NAME ){
            wp_enqueue_style(
                'eram-admin-portfolio',
                ERAM_PROOF_GALLERY_CSS_DIR . '/proof-gallery-admin.css',
                array(),
                ERAM_PROOF_GALLERY_VERSION
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
$eram_proof_gallery = EramProofGallery::get_instance();

