<?php
/**
 *  Register and config menus of the theme
 * 
 * @package Eram
 * @author owwwlab
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * ----------------------------------------------------------------------------------------
 * Set up register menus
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'eram_menus_setup' ) ) {
	function eram_menus_setup() {

		/**
		 * Register nav menus.
		 */
		register_nav_menus(
			array(
				'primary-menu' => esc_html__( 'Primary Menu', 'eram' ),
				'secondary-menu' => esc_html__( 'Secondary Menu', 'eram' ),
			)
		);

	}

	add_action( 'after_setup_theme', 'eram_menus_setup' );
}
