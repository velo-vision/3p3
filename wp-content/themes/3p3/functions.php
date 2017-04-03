<?php
/**
 * functions.php
 *
 * The theme's functions and definitions.
 */



/**
 * ----------------------------------------------------------------------------------------
 * Define constants.
 * ----------------------------------------------------------------------------------------
 */
define ('ERAM_THEME_VERSION', wp_get_theme()->get( 'Version' ));
define ('ERAM_THEME_NAME', wp_get_theme()->get( 'Name' ));
define( 'ERAM_THEMEROOT', get_template_directory_uri() );
define( 'ERAM_CSS', ERAM_THEMEROOT . '/assets/css' );
define( 'ERAM_IMAGES', ERAM_THEMEROOT . '/assets/img' );
define( 'ERAM_SCRIPTS', ERAM_THEMEROOT . '/assets/js' );
define( 'ERAM_FRAMEWORK', get_template_directory() . '/framework' );
define( 'ERAM_GUIDE_TEMPLATES', ERAM_FRAMEWORK . '/eram-guide/templates' );


// add editor style
add_editor_style( 'style.css' );


/**
 * ----------------------------------------------------------------------------------------
 * Set up theme default and register various supported features.
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'eram_setup' ) ) {
    function eram_setup() {
        /**
         * Make the theme available for translation.
         */
        $lang_dir = get_template_directory() . '/languages';
        load_theme_textdomain( 'eram', $lang_dir );

        

        /**
         * Add support for post formats.
         */
        add_theme_support( 'custom-logo' );

        /**
         * Add support for automatic feed links.
         */
        add_theme_support( 'automatic-feed-links' );

        /**
         * Let WordPress handle title
         */
        add_theme_support( 'title-tag' );
        /**
         * Add support for post thumbnails.
         */
        add_theme_support( 'post-thumbnails' );

        if ( ! isset( $content_width ) ) $content_width = 900;

        /**
         * Add custom thumbnail sizes
         */
        add_image_size( 'eram-normal',1000);
        add_image_size( 'eram-large',1500);
        add_image_size( 'eram-square', 800, 800);
        add_image_size( 'eram-lazy', 100 );


        /**
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list',
        ) );
    }

    add_action( 'after_setup_theme', 'eram_setup' );
}



if ( ! class_exists( 'Kirki' ) ) {
    include_once( ERAM_FRAMEWORK . '/kirki/kirki.php' );
}
include_once( ERAM_FRAMEWORK .'/class-kirki-fonts-gooogle-override.php');
include_once( ERAM_FRAMEWORK . '/class-eram-kirki.php' );

/**
 * ----------------------------------------------------------------------------------------
 * widgets
 * ----------------------------------------------------------------------------------------
 */
include_once( ERAM_FRAMEWORK . '/functions-widgets.php' );

/**
 * ----------------------------------------------------------------------------------------
 * include Kirki
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists('eram_load_customizer'))
{
    function eram_load_customizer()
    {
        
        include_once( ERAM_FRAMEWORK . '/class-eram-theme-customizer.php' );

        if ( class_exists('EramPlugin') )
        {
            include_once( ERAM_FRAMEWORK . '/class-eram-gallery-customizer.php' );
            include_once( ERAM_FRAMEWORK . '/class-eram-client-customizer.php' );
            include_once( ERAM_FRAMEWORK . '/class-eram-portfolio-customizer.php' );
        }
    }
}
add_action('init','eram_load_customizer');
        


/**
 * ----------------------------------------------------------------------------------------
 * include option tree
 * ----------------------------------------------------------------------------------------
 */

add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_show_new_layout', '__return_false' );
add_filter( 'ot_theme_mode', '__return_true' );
add_filter( 'ot_use_theme_options', '__return_false' );
include_once( ERAM_FRAMEWORK . '/option-tree/ot-loader.php' );


/**
 * ----------------------------------------------------------------------------------------
 * Register required or recommended plugins to be installed
 * ----------------------------------------------------------------------------------------
 */
include_once( ERAM_FRAMEWORK . '/plugin-register/register-plugins.php' );

/**
 * ----------------------------------------------------------------------------------------
 * register and enqueue styles and scripts
 * ----------------------------------------------------------------------------------------
 */
include_once( ERAM_FRAMEWORK . '/functions-styles-scripts.php' );

/**
 * ----------------------------------------------------------------------------------------
 * Menus
 * ----------------------------------------------------------------------------------------
 */
include_once( ERAM_FRAMEWORK . '/functions-menus.php' );


/**
 * ----------------------------------------------------------------------------------------
 * Require extra hooks
 * ----------------------------------------------------------------------------------------
 */
include_once( ERAM_FRAMEWORK . '/functions-extra-hooks.php' );

/**
 * ----------------------------------------------------------------------------------------
 * Load assets functions
 * ----------------------------------------------------------------------------------------
 */
include_once( ERAM_FRAMEWORK . '/functions-helpers.php' );

/**
 * ----------------------------------------------------------------------------------------
 * load visual composer elements and settings
 * ----------------------------------------------------------------------------------------
 */
include_once( ERAM_FRAMEWORK . '/functions-vc.php' );

/**
 * ----------------------------------------------------------------------------------------
 * Load metaboxes
 * ----------------------------------------------------------------------------------------
 */
include_once( ERAM_FRAMEWORK . '/functions-metabox.php' );

/**
 * ----------------------------------------------------------------------------------------
 * Welcome message
 * ----------------------------------------------------------------------------------------
 */
include_once( ERAM_FRAMEWORK . '/eram-guide/class-eramguide.php' );

/**
 * ----------------------------------------------------------------------------------------
 * Demo importer
 * ----------------------------------------------------------------------------------------
 */
include_once( ERAM_FRAMEWORK . '/demo-importer/class-importer.php' );


/**
 * ----------------------------------------------------------------------------------------
 * advanced lightbox
 * ----------------------------------------------------------------------------------------
 */
include_once( ERAM_FRAMEWORK . '/class-advanced-lightbox.php' );

/**
 * ----------------------------------------------------------------------------------------
 * woocommerce integration
 * ----------------------------------------------------------------------------------------
 */
if ( class_exists( 'WooCommerce' ) )
    include_once( ERAM_FRAMEWORK . '/functions-woo.php' );

