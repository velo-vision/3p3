<?php
/**
 *	Eram WordPress Theme
 */

// After theme setup hooks
function eram_child_after_setup_theme() {
	// Load translations for child theme
	load_child_theme_textdomain( 'eram-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'eram_child_after_setup_theme' );


// This will enqueue style.css of child theme
function eram_child_wp_enqueue_scripts() {
	wp_enqueue_style( 'eram-child', get_stylesheet_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'eram_child_wp_enqueue_scripts', 100 );