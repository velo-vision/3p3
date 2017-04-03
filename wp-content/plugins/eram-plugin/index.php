<?php
/**
 * Plugin Name: Eram Theme Plugin
 * Plugin URI:  
 * Description: Plugin that is required by Eram theme.
 * Author:      owwwlab Web Design Agency
 * Author URI:  http://owwwlab.com
 * Version:     1.2.1
 * Text Domain: erampluign
 * Domain Path: languages
 *
 * This is not a free software and you can only use it with Eram theme.
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Class EramGallery
 */
class EramPlugin {

 	/**
 	 * Holds the class object.
 	 *
 	 * @since 1.0.0
 	 *
 	 * @var object
 	 */
 	public static $instance;

 	/**
 	 * Plugin version used for caching of styles and scripts
 	 *
 	 * @since 1.0.0
 	 *
 	 * @var string
 	 */
 	public $version = "1.0.0";

 	/**
     * The name of the plugin.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $plugin_name = 'Eram Theme Plugin';


    /**
     * Unique plugin slug identifier.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $plugin_slug = 'eram-plugin';

    /**
     * Plugin file.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $file = __FILE__;


    /**
     * Primary class constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        // check if Eram theme is active
        $theme = wp_get_theme();
        if ('3p3' != $theme->name && '3p3' != $theme->parent_theme)
            return false;

        $this->define_constants();


         //upon activation plugin do this
        register_activation_hook( $this->file, array( $this,'my_plugin_activation') );

        //upon deactivation plugin do this
        register_deactivation_hook( $this->file, array ( $this, 'my_plugin_deactivation' ) );
        
        // Load the plugin textdomain.
        add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );


        // Load the plugin.
        add_action( 'init', array( $this, 'init' ), 0 );

    }

    /**
     *
     */
    public function define_constants()
    {
        define('ERAM_PLUGIN_VERSION', $this->version);
    }

    /**
     * plugin activation
     *
     * @since 1.0.0
     * @internal param $
     */
    public function my_plugin_activation() {

        // Then flush rewrite rules
        flush_rewrite_rules();
    }

    /**
     * plugin deactivation
     *
     * @since 1.0.0
     * @internal param $
     */
    public function my_plugin_deactivation() {


        flush_rewrite_rules();

    }


    /**
     * Loads the plugin textdomain for translation.
     *
     * @since 1.0.0
     */
    public function load_plugin_textdomain() {


        $locale = apply_filters( 'plugin_locale', get_locale(), 'eram' );

        load_textdomain( 'eram', WP_LANG_DIR . '/' . 'eram' . '/' . 'eram' . '-' . $locale . '.mo' );
        load_plugin_textdomain( 'eram', false, dirname( plugin_basename( $this->file ) ) . '/languages/' );

    }

    /**
     * Loads the plugin into WordPress.
     *
     * @since 1.0.0
     */
    public function init() {

        require plugin_dir_path( $this->file ) . 'gallery-classes/loader.php';
        require plugin_dir_path( $this->file ) . 'gallery/gallery.php';
        require plugin_dir_path( $this->file ) . 'proof-gallery/proof-gallery.php';
        require plugin_dir_path( $this->file ) . 'client/client.php';
        require plugin_dir_path( $this->file ) . 'portfolio/portfolio.php';
        require plugin_dir_path( $this->file ) . '3rd-party/exifography/exifography.php';
        require plugin_dir_path( $this->file ) . '3rd-party/woocommerce/woocommerce.php';


    }

    /**
     * Returns the instance of the class.
     *
     * @since 1.0.0
     *
     * @return object 
     */
    public static function get_instance() {

        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;

    }

 }

 // Load the main plugin class.
$eram_plugin = EramPlugin::get_instance();



