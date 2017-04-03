<?php
/**
 *  Register and config widgets for the theme
 * 
 * @package eram
 * @author owwwlab
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * ----------------------------------------------------------------------------------------
 * Register the widget areas.
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'eram_widget_init' ) ) {
	function eram_widget_init() {
		if ( function_exists( 'register_sidebar' ) ) {
			
			register_sidebar(
				array(
					'name' => esc_html__( 'Sidebar Area', 'eram' ),
					'id' => 'eram-main-sidebar',
					'description' => esc_html__( 'Appears on posts and pages.', 'eram' ),
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget' => '</div> <!-- end widget -->',
					'before_title' => '<h5 class="widget-title">',
					'after_title' => '</h5>',
				)
			);

            register_sidebar(
                array(
                    'name'          => esc_html__( 'Footer Widgets', 'eram' ),
                    'id'            => 'eram-footer-widgets',
                    'description'    => esc_html__( 'Appears on page footer.', 'eram' ),
                    'before_widget' => '<div class="'.eram_get_footer_widget_col_class().'"><div id="%1$s" class="widget %2$s">',
                    'after_widget' => '</div></div> <!-- end widget -->',
                    'before_title' => '<h5 class="widget-title">',
                    'after_title' => '</h5>',
                )
            );

            if(class_exists('Woocommerce')) {
                register_sidebar(
                    array(
                        'name'          => esc_html__( 'Shop Sidebar', 'eram' ),
                        'id'            => 'eram-shop-sidebar',
                        'description'   => esc_html__( 'Appears on Shop.', 'eram' ),
                        'before_widget' => '<div id="%1$s" class="widget %2$s">',
                        'after_widget'  => '</div> <!-- end widget -->',
                        'before_title'  => '<h5 class="widget-title">',
                        'after_title'   => '</h5>',
                    )
                );
            }
			
			/**
			 * add dynamic sidebars
			 */
			$dynamic_sidebars = ERAM_Kirki::get_option('eram_theme_options','eram_dynamic_sidebars',array());

			foreach ($dynamic_sidebars as $sidebar) {
				register_sidebar(array(
					'name' => $sidebar['sidebar'],
					'id' => sanitize_title_with_dashes($sidebar['sidebar']),
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h5 class="widget-title">',
					'after_title' => '</h5>',
				));
			}
		}
	}

    add_action( 'widgets_init', 'eram_widget_init' );
}
