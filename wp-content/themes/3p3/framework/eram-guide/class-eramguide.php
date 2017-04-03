<?php
/**
 *  Welcome message after theme activation
 * 
 * @package eram
 * @author owwwlab
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class EramGuide{

	public static $instance;

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

	public function __construct()
	{


		// theme activation
		add_action( 'after_switch_theme', array( $this, 'redirect_to_welcome') );

        // Admin menu
        add_action( 'admin_menu', array( $this, 'define_admin_menus') , 1 );

	}


    /**
     * Redirect the user to welcome page
     */
    public function redirect_to_welcome()
	{
        $eram_is_here = 'eram_is_here';

        if ( false == get_option( $eram_is_here, false ) ) {
            update_option( $eram_is_here, true );
            wp_redirect( admin_url( 'themes.php?page=eram_welcome' ) );
            die();
        }

        delete_option( $eram_is_here );
	}

    public function define_admin_menus()
    {

        // Eram About Page
        add_theme_page(
            'About Eram Theme',
            'About Eram Theme',
            'edit_theme_options',
            'eram_welcome',
            array( $this, 'display_about_page')
        );

        // Eram Help page
        add_theme_page(
            'Help',
            'Help',
            'edit_theme_options',
            'eram_docs',
            array( $this, 'display_help_page')
        );


    }

    public function display_about_page()
    {
        include ERAM_GUIDE_TEMPLATES . '/welcome.php';
    }

    public function display_help_page()
    {
        include ERAM_GUIDE_TEMPLATES . '/help.php';
    }

}

$eram_guide = EramGuide::get_instance();

