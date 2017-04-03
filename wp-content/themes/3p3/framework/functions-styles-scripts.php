<?php
/**
 *  Register and enqueue styles and scripts
 *
 * @package eram
 * @author owwwlab
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * ----------------------------------------------------------------------------------------
 * include other scripts and styles
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'eram_add_styles_and_scripts' ) ) {

	function eram_add_styles_and_scripts() {

		// Adds support for pages with threaded comments
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Register scripts

		wp_register_script('theme-custom-js', ERAM_SCRIPTS . '/custom.min.js', array('jquery') ,ERAM_THEME_VERSION, true );
		wp_register_script('eram-js-vendors', ERAM_SCRIPTS . '/vendors.min.js', array('jquery'),ERAM_THEME_VERSION, true);

		wp_register_style( 'eram-vendors', ERAM_CSS . '/vendors.min.css',array(),ERAM_THEME_VERSION);
		wp_register_style( 'eram-style', ERAM_THEMEROOT . '/style.css',array(),ERAM_THEME_VERSION);


		//load  google map scripts ony for specific page
		if ( is_page() ){
			$page_uses_map = eram_page_meta('_ep_cover_type','','image') == 'google-map' ? TRUE : FALSE;
			if ($page_uses_map){
				$google_map_api_key = ERAM_Kirki::get_option('eram_theme_options','eram_gmap_api_key','');
				if ( empty($google_map_api_key) ) $google_map_api_key = 'AIzaSyC_pY2xP2spfwhjVQPMWvvAMWm7aQlr794';
				$language = get_locale();
				
				wp_register_script('google-map-api', "http://maps.google.com/maps/api/js?v=3&key=$google_map_api_key" , array( 'jquery' ),false,true );
				wp_register_script( 'eram-gmap3', ERAM_SCRIPTS . '/vendors/gmap3.min.js', array('jquery'),false,true );
				
				wp_enqueue_script('google-map-api');
				wp_enqueue_script( 'eram-gmap3' );
			}
				
		}

		
		wp_enqueue_style( 'eram-vendors');
		wp_enqueue_style( 'eram-style');
		wp_enqueue_script('eram-js-vendors');
		
		// enqueue theme js file and pass variables
		wp_enqueue_script('theme-custom-js');
		
		if( is_singular() )
			$page_is='is_singular';
		elseif( is_tax() )
			$page_is='is_tax';
		elseif( is_post_type_archive() )
			$page_is='is_archive';
		else
			$page_is='';

		$eram_vars = array(
			'adminAjaxUrl'   	=> admin_url( 'admin-ajax.php' ),
			'page_is'		 	=> $page_is,
			'queried_options' 	=> $_SERVER['QUERY_STRING'],
            'pg_extra_notice'   => esc_html__('You are commenting on a selected photo. The photo will be added to your comment as a reference.','eram')
		);
		wp_localize_script( 'theme-custom-js', 'eram_vars', apply_filters('eram_js_vars',$eram_vars) );


	}

	add_action( 'wp_enqueue_scripts', 'eram_add_styles_and_scripts',100 );
}

/**
 * ----------------------------------------------------------------------------------------
 * Add general admin css
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists('eram_add_admin_css') )
{
	function eram_add_admin_css() {
		wp_register_style( 'eram_wp_admin_css', ERAM_CSS . '/eram-admin.css', false, ERAM_THEME_VERSION);
        wp_enqueue_style( 'eram_wp_admin_css' );
	}
}
add_filter('admin_enqueue_scripts','eram_add_admin_css');

/**
 * ----------------------------------------------------------------------------------------
 * Add copyright right click to js_vars
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists('eram_add_cpt_owner') )
{
	function eram_add_cpt_owner($eram_vars) {
		$eram_vars['show_copyright_note'] = ERAM_Kirki::get_option('eram_theme_options','eram_show_copyright_note',TRUE);
		$notice = ERAM_Kirki::get_option('eram_theme_options','eram_copyright_notice',get_bloginfo( 'name' ));
		$eram_vars['copyright_notice'] = $notice;
		
		return $eram_vars;
	}
}
add_filter('eram_js_vars','eram_add_cpt_owner');

/**
 * ----------------------------------------------------------------------------------------
 * Add mobile menu vars to js_vars
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists('eram_add_mobile_menu_vars') )
{
	function eram_add_mobile_menu_vars($eram_vars) {

		// we need that for classic and bordered layout
		$layout = ERAM_Kirki::get_option('eram_theme_options','eram_site_layout','side');
		$situation = array('classic','bordered');
		if ( in_array($layout, $situation) ){
			// get the visible mobile menu
			$eram_vars['mobile_menu_is'] = ERAM_Kirki::get_option('eram_theme_options','eram_keep_menu_at_mobile','primary-menu');
		}
		
		if ( $layout=="top"){
			$eram_vars['mobile_menu_is'] ="primary-menu";
		}
		return $eram_vars;
	}
}
add_filter('eram_js_vars','eram_add_mobile_menu_vars');

/**
 * ----------------------------------------------------------------------------------------
 * lighbox js settings
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists('eram_lightbox_settings') )
{
	function eram_lightbox_settings($eram_vars)
	{
		$eram_vars['lg_mode'] = Eram_Kirki::get_option('eg_settings','eg_lg_mode', 'lg-fade');
		$eram_vars['lg_download'] = (bool) Eram_Kirki::get_option('eg_settings','eg_lg_download', 1);
		$eram_vars['lg_counter'] = (bool) Eram_Kirki::get_option('eg_settings','eg_lg_counter', 1);
		$eram_vars['lg_controls'] = (bool) Eram_Kirki::get_option('eg_settings','eg_lg_controls', 1);
		$eram_vars['lg_keyPress'] = (bool) Eram_Kirki::get_option('eg_settings','eg_lg_keypress', 1);
		$eram_vars['lg_escKey'] = (bool) Eram_Kirki::get_option('eg_settings','eg_lg_esckey', 1);
		$eram_vars['lg_loop'] = (bool) Eram_Kirki::get_option('eg_settings','eg_lg_loop', 1);
		$eram_vars['lg_thumbnail'] = (bool) Eram_Kirki::get_option('eg_settings','eg_lg_thumbnail', 1);
		$eram_vars['lg_showThumbByDefault'] = (bool) Eram_Kirki::get_option('eg_settings','eg_lg_thumbnaildefault', 1);
		$eram_vars['lg_autoplay'] = (bool) Eram_Kirki::get_option('eg_settings','eg_lg_autoplay', 0);
		$eram_vars['lg_progressBar'] = (bool) Eram_Kirki::get_option('eg_settings','eg_lg_progressbar', 1);
		$eram_vars['lg_zoom'] = (bool) Eram_Kirki::get_option('eg_settings','eg_lg_zoom', 1);


		return $eram_vars;
	}
}
add_filter('eram_js_vars','eram_lightbox_settings');

/**
 * ----------------------------------------------------------------------------------------
 * extra hooks to wp_head()
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists('eram_wp_head_hook') ){
	function eram_wp_head_hook(){

		// Custom JavaScript in Header
		$user_custom_js_head = ERAM_Kirki::get_option('eram_theme_options','eram_header_js','');
		if ( ! empty( $user_custom_js_head ) ) {
			if ( ! preg_match( "/^\s*<script/", $user_custom_js_head ) ) {
				$user_custom_js_head = '<script id="eram-header-custom-js"> ' . $user_custom_js_head . ' </script>';
			}
			echo $user_custom_js_head;
		}

		// Custom Css in Header
		$user_custom_css_head = ERAM_Kirki::get_option('eram_theme_options','eram_custom_css','');
		if ( ! empty($user_custom_css_head) ) {
			$user_custom_css_head = "<style id='eram-custom-css'>" . $user_custom_css_head . "</style>";
		}
		echo $user_custom_css_head;


        // add lightbox spacing
        $styles = '';
        $lightbox_padding = intval(Eram_Kirki::get_option('eg_settings','eg_lg_padding',0));
        $styles .= ".lg-outer .lg-img-wrap{padding:{$lightbox_padding}px;}";
        echo '<style id="eram-lightbox-spacing">' . preg_replace( '/[ \t]+/', ' ', preg_replace( '/[\r\n]+/', "\n", $styles ) ) . '</style>';
	}

	add_action( 'wp_head', 'eram_wp_head_hook', 1000 );
}

/**
 * ----------------------------------------------------------------------------------------
 * extra hooks to wp_footer
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists('eram_wp_footer_hook') ){
	function eram_wp_footer_hook(){

		// Custom JavaScript in Footer
    	$user_custom_js = ERAM_Kirki::get_option('eram_theme_options','eram_footer_js','');
    
        if ( ! empty( $user_custom_js ) ) {
            
            if ( ! preg_match( "/^\s*<script/", $user_custom_js ) ) {
                $user_custom_js = '<script id="eram-footer-custom-js"> ' . $user_custom_js . ' </script>';
            }
            
            echo $user_custom_js;
        }
		
	}

	add_action( 'wp_footer', 'eram_wp_footer_hook', 1000 );
}


/**
 * ----------------------------------------------------------------------------------------
 * extra typography styles
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists('eram_wp_head_typography') ){
	function eram_wp_head_typography(){

		/* Get settings */
	    $typo_heading = Eram_Kirki::get_option( 'eram_theme_options', 'eram_headeings_typo',array() );
	    $typo_body = Eram_Kirki::get_option( 'eram_theme_options', 'eram_body_typo',array() );
		

		$styles = ".em-blog-post.layout-classic .post-date span, 
				.em-blog-post.layout-classic ul.meta,
				.em-blog-post.layout-minimal ul.meta-data li, 
				.em-blog-post.layout-minimal ul.meta-data li a,
				.btn,
				.slide-menu-wrapper a{";

		if ( isset( $typo_heading[ 'font-family' ] ) )
	    {
	        $styles .= "font-family:" . $typo_heading[ 'font-family' ];
	    }

		$styles .= "}";

		if ( ! empty($styles) ) {
			$styles = "<style id='eram-custom-typography'>" . $styles . "</style>";
		}
		echo $styles;
	}

	add_action( 'wp_head', 'eram_wp_head_typography' );
}

/**
 * ----------------------------------------------------------------------------------------
 * Dynamic Style for WordPress editor
 * ----------------------------------------------------------------------------------------
 */

/* Add Editor Style */
add_filter( 'mce_css', 'eram_dynamic_mce_css' );

/**
 * Add Link Color Option in Editor Style (MCE CSS)
 * @since 1.1.0
 */
function eram_dynamic_mce_css ( $mce_css )
{
    $mce_css .= ', ' . add_query_arg( array(
            'action' => 'eram_dynamic_mce_css',
            '_nonce' => wp_create_nonce( 'eram_dynamic_mce_css', __FILE__ ),
        ), admin_url( 'admin-ajax.php' ) );

    return $mce_css;
}

/* Ajax Callback Hook */
add_action( 'wp_ajax_eram_dynamic_mce_css', 'eram_dynamic_mce_css_ajax_callback' );
add_action( 'wp_ajax_no_priv_eram_dynamic_mce_css', 'eram_dynamic_mce_css_ajax_callback' );

/**
 * Ajax Callback
 */
function eram_dynamic_mce_css_ajax_callback ()
{

    /* Check nonce for security */
    $nonce = isset( $_REQUEST[ '_nonce' ] ) ? $_REQUEST[ '_nonce' ] : '';
    if( ! wp_verify_nonce( $nonce, 'my-color-mce-nonce' ) ){
        die(); // don't print anything
    }

    /* Set File Type and Print the CSS Declaration */
    header( 'Content-type: text/css' );

    /* Get settings */
    $typo_heading = Eram_Kirki::get_option( 'eram_theme_options', 'eram_headeings_typo',array() );
    $typo_body = Eram_Kirki::get_option( 'eram_theme_options', 'eram_body_typo',array() );

    $families = '';
    if ( isset( $typo_heading[ 'font-family' ] ) )
    {
        $families .= $typo_heading[ 'font-family' ];
    }
    $subsets ="";
    if ( isset( $typo_heading['subsets'] ) ) {
        if ( is_array( $typo_heading['subsets'] ) ) {
            $subsets .= implode( ',', $typo_heading['subsets']);
        } else {
            $subsets .= $typo_heading['subsets'];
        }
    }
    if ( ! empty($families) )
    {
        echo "@import url(//fonts.googleapis.com/css?family={$families}&subset={$subsets});";
    }

    $families = '';
    if ( isset( $typo_body[ 'font-family' ] ) )
    {
        $families .= $typo_body[ 'font-family' ];
    }
    $subsets ="";
    if ( isset( $typo_body['subsets'] ) ) {
        if ( is_array( $typo_body['subsets'] ) ) {
            $subsets .= implode( ',', $typo_body['subsets']);
        } else {
            $subsets .= $typo_body['subsets'];
        }
    }
    if ( ! empty($families) )
    {
        echo "@import url(//fonts.googleapis.com/css?family={$families}&subset={$subsets});";
    }


    if ( ! empty($families) )
    {
        echo "@import url(//fonts.googleapis.com/css?family={$families}&subset={$subsets});";
    }

    if ( $typo_heading )
    {
        echo "
		h1, h2, h3, h4, h5, h6,
		.em-blog-post.layout-classic .post-date span, 
		.em-blog-post.layout-classic ul.meta,
		.em-blog-post.layout-minimal ul.meta-data li, 
		.em-blog-post.layout-minimal ul.meta-data li a,
		nav.navigation.next-prev .prev, 
		nav.navigation.next-prev .next,
		.avatar-wrapper .author,
		.btn {";
        if ( isset( $typo_heading[ 'font-family' ] ) )
        {
            echo "font-family: {$typo_heading['font-family']};";
        }
        if ( isset( $typo_heading[ 'variant' ] ) )
        {
            echo "font-weight:{$typo_heading['variant']};";
        }
        if ( isset( $typo_heading[ 'font-size' ] ) )
        {
            echo "font-size:{$typo_heading['font-size']};";
        }
        if ( isset( $typo_heading[ 'line-height' ] ) )
        {
            echo "line-height:{$typo_heading['line-height']};";
        }
        if ( isset( $typo_heading[ 'letter-spacing' ] ) )
        {
            echo "letter-spacing:{$typo_heading['letter-spacing']};";
        }
        if ( isset( $typo_heading[ 'color' ] ) )
        {
            echo "color:{$typo_heading['color']};";
        }
        echo "}";
    }

    if ( $typo_body )
    {
        echo "
        body{";
        if ( isset( $typo_body[ 'font-family' ] ) )
        {
            echo "font-family: {$typo_body['font-family']};";
        }
        if ( isset( $typo_body[ 'variant' ] ) )
        {
            echo "font-weight:{$typo_body['variant']};";
        }
        if ( isset( $typo_body[ 'font-size' ] ) )
        {
            echo "font-size:{$typo_body['font-size']};";
        }
        if ( isset( $typo_body[ 'line-height' ] ) )
        {
            echo "line-height:{$typo_body['line-height']};";
        }
        if ( isset( $typo_body[ 'letter-spacing' ] ) )
        {
            echo "letter-spacing:{$typo_body['letter-spacing']};";
        }
        if ( isset( $typo_body[ 'color' ] ) )
        {
            echo "color:{$typo_body['color']};";
        }
        echo "}";
    }

    die(); // end ajax process.
}

/**
 * ----------------------------------------------------------------------------------------
 * styling options
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists('eram_gallery_spacing_styles') )
{
	function eram_gallery_spacing_styles() {
		

		if ( ! class_exists('EramGallery') )
			return;
		
		$gutter = 15;
		if ( is_singular( ERAM_GALLERY_CPT_NAME ) )
		{
			// post is available, get meta value
			global $post;
			$object_id = get_the_ID();
			$gutter = eg_get_gallery_option( 'eg_items_spacing', 15 ,$object_id);
			
		}
		elseif( is_tax( ERAM_GALLERY_CATEGORY_TAX ) )
		{
			// get value from customizer option for this term
			$object_id = get_queried_object()->slug;
			$gutter = eg_get_gallery_option( 'eg_items_spacing', 15 ,$object_id);
		}
		elseif( is_post_type_archive( ERAM_GALLERY_CPT_NAME ) )
		{
			// get value from customizer option
			$gutter = eg_get_gallery_option( 'eg_items_spacing' );
		}
		elseif (is_tax( ERAM_FOLIO_TAX_NAME ) )
		{
			// get value from customizer option for this term
			$object_id = get_queried_object()->slug;
			$gutter = epf_get_option( 'epf_items_spacing', 15 ,$object_id);
		}
		elseif (is_post_type_archive( ERAM_FOLIO_CPT_NAME ) )
		{
			$gutter = epf_get_option( 'epf_items_spacing', 15 ,'portfolio_archive');
		}


		eram_print_gallery_styles($gutter);

	}

	add_action( 'wp_head', 'eram_gallery_spacing_styles' );
}



/**
 * ----------------------------------------------------------------------------------------
 * styling options
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists('eram_print_gallery_styles') )
{
	function eram_print_gallery_styles($gutter = 15, $custom_class='')
	{
		$doublecarouselMargin = $gutter /2;
		$styles = '
		'.$custom_class.'.gallery-main{
		    padding-top: '.$gutter.'px;
		    padding-left: '.$gutter.'px;
		}
		'.$custom_class.'.gallery-main >*{
		    height: 100%;
		}
		'.$custom_class.'.gallery-main .gallery-item,
		'.$custom_class.'.em-proof-bar{
		    padding: 0 '.$gutter.'px '.$gutter.'px 0;
		}
		body.er-full-layout '.$custom_class.'.gallery-main{
			padding-top:0;
			margin:0 -'.$gutter.'px;
		}
		.ol-double-carousel.em-gallery .vcarousel-prev, .ol-double-carousel.em-gallery .vcarousel-next{
			margin-left:-'.$doublecarouselMargin.'px;
			-webkit-transform: translate3d(-50%,-'.$gutter.'px,0);
		    -ms-transform: translate3d(-50%,-'.$gutter.'px,0);
		    transform: translate3d(-50%,-'.$gutter.'px,0);
		}

		';

		echo '<style id="eram-gallery-spacing">' . preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $styles)) .'</style>';
	}
}

/**
 * ----------------------------------------------------------------------------------------
 * inline css for inpage gallery vc element
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists('eram_print_inpage_gallery_styles') )
{
	function eram_print_inpage_gallery_styles($gutter = 15, $custom_class='') {
		$doublecarouselMargin = $gutter /2;
		$styles = '
		'.$custom_class.'.gallery-main{
			padding-top:'.$gutter.'px;
			padding-left:'.$gutter.'px;
		}
		.layout-header-side .type-grid.direction-vertical '.$custom_class.'.gallery-main,
		.container .type-grid.direction-vertical '.$custom_class.'.gallery-main,
		.layout-header-side .type-masonry.direction-vertical '.$custom_class.'.gallery-main,
		.container .type-masonry.direction-vertical '.$custom_class.'.gallery-main{
		    padding:0px;
		    margin-right: -'.$gutter.'px;
		}

		'.$custom_class.'.gallery-main .gallery-item {
		    padding: 0 '.$gutter.'px '.$gutter.'px 0;
		}
		.type-justified '.$custom_class.'.gallery-main .gallery-item {
		    padding: 0px;
		}
		.type-justified '.$custom_class.'.gallery-main,
		.type-kenburn '.$custom_class.'.gallery-main,
		.type-slider '.$custom_class.'.gallery-main{
			padding-top: 0px;
			padding-left: 0px;
		}
		.container .type-justified '.$custom_class.'.gallery-main{
			margin-right:-'.$gutter.'px;
			margin-left: -'.$gutter.'px;
		}
		.ol-double-carousel.em-gallery .vcarousel-prev, .ol-double-carousel.em-gallery .vcarousel-next{
			margin-left:-'.$doublecarouselMargin.'px;
			-webkit-transform: translate3d(-50%,-'.$gutter.'px,0);
		    -ms-transform: translate3d(-50%,-'.$gutter.'px,0);
		    transform: translate3d(-50%,-'.$gutter.'px,0);
		}

 		';

		echo '<style id="eram-inpage-gallery-styles">' . preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $styles)) .'</style>';
	}
}


/**
 * ----------------------------------------------------------------------------------------
 * Custom colors
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists('eram_custom_colors') ){
	function eram_custom_colors(){

		$site_layout = ERAM_Kirki::get_option('eram_theme_options','eram_site_layout','bordered');
		$theme_color_scheme = ERAM_Kirki::get_option('eram_theme_options','eram_color_theme','light');

		$custom_colors = array();

		// check if we should use custom colors
		$eram_use_custom_colors = ERAM_Kirki::get_option('eram_theme_options','eram_use_custom_colors',false);
		if ( ! $eram_use_custom_colors ) return false;

		if ( $theme_color_scheme == 'light'){
			$eram_c_headings_option = 'eram_c_headings';
			$eram_c_headings_default = '#444444';

			$eram_c_text_option = 'eram_c_text';
			$eram_c_text_default = '#777777';

			$eram_c_bg_option = 'eram_c_bg';
			$eram_c_bg_default = '#ffffff';

			$eram_c_boxed_bg_option = 'eram_c_boxed_bg';
			$eram_c_boxed_bg_default = '#f5f5f5';

			$eram_c_border_option = 'eram_c_border';
			$eram_c_border_default = '#dddddd';

			$eram_c_link_option = 'eram_c_link';
			$eram_c_link_default = '#555555';

			$eram_c_side_bg_option = 'eram_c_side_bg';
			$eram_c_side_bg_default = '#F9F9F9';

			$eram_c_side_menu_item_option = 'eram_c_side_menu_item';
			$eram_c_side_menu_item_default = '#888888';

			$eram_c_side_menu_item_hover_option = 'eram_c_side_menu_item_hover';
			$eram_c_side_menu_item_hover_default = '#444444';

			$eram_c_frame_option = 'eram_c_frame';
			$eram_c_frame_default = '#f1f1f1';

			$eram_c_classic_menu_option = 'eram_c_classic_menu';
			$eram_c_classic_menu_default = '#f1f1f1';

			$eram_c_classic_menu_hover_option = 'eram_c_classic_menu_hover';
			$eram_c_classic_menu_hover_default = '#f1f1f1';

			$eram_c_classic_menu_bg_option = 'eram_c_classic_menu_bg';
			$eram_c_classic_menu_bg_default = '#1e1e1e';

			$eram_c_header_bg_option = 'eram_c_header_bg';
			$eram_c_header_bg_default = '#ffffff';

			$eram_c_top_menu_item_option = 'eram_c_top_menu_item';
			$eram_c_top_menu_item_default = '#444444';

		}
		else{
			// it is dark here!
			$eram_c_headings_option = 'eram_cd_headings';
			$eram_c_headings_default = '#f5f5f5';

			$eram_c_text_option = 'eram_cd_text';
			$eram_c_text_default = '#808080';

			$eram_c_bg_option = 'eram_cd_bg';
			$eram_c_bg_default = '#222222';

			$eram_c_boxed_bg_option = 'eram_cd_boxed_bg';
			$eram_c_boxed_bg_default = '#303030';

			$eram_c_border_option = 'eram_cd_border';
			$eram_c_border_default = '#363636';

			$eram_c_link_option = 'eram_cd_link';
			$eram_c_link_default = '#cccccc';

			$eram_c_side_bg_option = 'eram_cd_side_bg';
			$eram_c_side_bg_default = '#2c2c2c';

			$eram_c_side_menu_item_option = 'eram_cd_side_menu_item';
			$eram_c_side_menu_item_default = '#888888';

			$eram_c_side_menu_item_hover_option = 'eram_cd_side_menu_item_hover';
			$eram_c_side_menu_item_hover_default = '#f5f5f5';

			$eram_c_frame_option = 'eram_cd_frame';
			$eram_c_frame_default = '#2c2c2c';

			$eram_c_classic_menu_option = 'eram_cd_classic_menu';
			$eram_c_classic_menu_default = '#c0c0c0';

			$eram_c_classic_menu_hover_option = 'eram_cd_classic_menu_hover';
			$eram_c_classic_menu_hover_default = '#ffffff';

			$eram_c_classic_menu_bg_option = 'eram_cd_classic_menu_bg';
			$eram_c_classic_menu_bg_default = '#1e1e1e';

			$eram_c_header_bg_option = 'eram_cd_header_bg';
			$eram_c_header_bg_default = '#2c2c2c';

			$eram_c_top_menu_item_option = 'eram_cd_top_menu_item';
			$eram_c_top_menu_item_default = '#c0c0c0';
		}
		// Headings 
		$eram_c_headings = ERAM_Kirki::get_option('eram_theme_options',$eram_c_headings_option,$eram_c_headings_default);
		if ( $eram_c_headings != $eram_c_headings_default){
			$custom_colors[] = 'h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6,.em-blog-post.layout-masonry .post-contents .title a,.gallery-page-title-top .gallery-top.page-head .gallery-title,.em-blog-wrapper.layout-classic .em-blog-posts a,.em-blog-post.layout-classic .post-date,.author-bio .author-bio-content h4 a,.em-blog-post.layout-classic .title a,.em-client-box .client-name h3 a,body.eram-theme-dark h1, body.eram-theme-dark .h1, body.eram-theme-dark h2, body.eram-theme-dark .h2, body.eram-theme-dark h3, body.eram-theme-dark .h3, body.eram-theme-dark h4, body.eram-theme-dark .h4, body.eram-theme-dark h5, body.eram-theme-dark .h5, body.eram-theme-dark h6, body.eram-theme-dark .h6,body.eram-theme-dark .em-blog-post.layout-masonry .post-contents .title a,body.eram-theme-dark .gallery-page-title-top .gallery-top.page-head .gallery-title,body.eram-theme-dark .em-blog-wrapper.layout-classic .em-blog-posts a,body.eram-theme-dark .em-blog-post.layout-classic .post-date,body.eram-theme-dark .author-bio .author-bio-content h4 a,body.eram-theme-dark .em-blog-post.layout-classic .title a,body.eram-theme-dark .em-client-box .client-name h3 a,.em-client-box .client-name h3 a,body.eram-theme-dark .em-client-box .client-name h3 a{color:'.$eram_c_headings.'}';
			$custom_colors[] = ".em-blog-post.layout-masonry .post-contents .title a:hover,.em-blog-wrapper.layout-classic .em-blog-posts a:hover,.author-bio .author-bio-content h4 a:hover,.em-blog-post.layout-classic .title a:hover,.em-client-box .client-name h3 a:hover,body.eram-theme-dark .em-blog-post.layout-masonry .post-contents .title a:hover,body.eram-theme-dark .em-blog-wrapper.layout-classic .em-blog-posts a:hover,body.eram-theme-dark .author-bio .author-bio-content h4 a:hover,body.eram-theme-dark .em-blog-post.layout-classic .title a:hover,body.eram-theme-dark .em-client-box .client-name h3 a:hover,.em-client-box .client-name h3 a:hover,body.eram-theme-dark .em-client-box .client-name h3 a:hover{color:".eram_color_luminance($eram_c_headings,-0.2) ."}";
			$custom_colors[] ='.simple-page-head .title-wrapper .page-title:after,.widget .widget-title:after,#comments .comments-title:after,body.eram-theme-dark .simple-page-head .title-wrapper .page-title:after,body.eram-theme-dark .widget .widget-title:after,#comments .comments-title:after{background-color:'.$eram_c_headings.'}';
		}

		
		// body text
		$eram_c_text = ERAM_Kirki::get_option('eram_theme_options',$eram_c_text_option,$eram_c_text_default);
		if ( $eram_c_text != $eram_c_text_default){
			$custom_colors[] = 'body,.icon-box.ib-v1 >i,.ol-price-table .body ul li,.er-cprtext,.er-breadcrumbs li, .er-breadcrumbs li a,body.eram-theme-dark ,body.eram-theme-dark .icon-box.ib-v1 >i,body.eram-theme-dark .ol-price-table .body ul li,body.eram-theme-dark .er-cprtext,body.eram-theme-dark .er-breadcrumbs li, .er-breadcrumbs li a{color:'.$eram_c_text.'}';
		}

		// background
		$eram_c_bg = ERAM_Kirki::get_option('eram_theme_options',$eram_c_bg_option,$eram_c_bg_default);
		if ( $eram_c_bg != $eram_c_bg_default){
			$custom_colors[] = 'body,.gallery-wrapper,.gallery-page-title-side .gallery-main,.gallery-page-title-side .gallery-main,.em-blog-wrapper.layout-masonry,.em-single-post .post-comments,.post-type-archive-eram_client,body.eram-theme-dark,body.eram-theme-dark .gallery-wrapper,body.eram-theme-dark .gallery-page-title-side .gallery-main,body.eram-theme-dark .gallery-page-title-side .gallery-main,body.eram-theme-dark .em-blog-wrapper.layout-masonry,body.eram-theme-dark .em-single-post .post-comments,body.eram-theme-dark .post-type-archive-eram_client,body.eram-theme-dark .er-boxed, .er-boxed,body.eram-theme-dark input,.portfolio-minimal .page-main{background-color:'.$eram_c_bg.'}';
			$custom_colors[] = '.em-single-post nav.navigation .prev a, .em-single-post nav.navigation .next a, .single-eramfolio nav.navigation .prev a, .single-eramfolio nav.navigation .next a,.em-blog-wrapper .post-header.has-bg:before, .em-single-post .post-header.has-bg:before,body.eram-theme-dark .em-single-post nav.navigation .prev a,body.eram-theme-dark  .em-single-post nav.navigation .next a,body.eram-theme-dark  .single-eramfolio nav.navigation .prev a,body.eram-theme-dark  .single-eramfolio nav.navigation .next a,body.eram-theme-dark .em-blog-wrapper .post-header.has-bg:before,body.eram-theme-dark  .em-single-post .post-header.has-bg:before{background-color:'.eram_lighten_alpha($eram_c_bg,0.4).'}';
		}


		// boxed color
		$eram_c_boxed_bg = ERAM_Kirki::get_option('eram_theme_options',$eram_c_boxed_bg_option,$eram_c_boxed_bg_default);
		if ( $eram_c_boxed_bg != $eram_c_boxed_bg_default ){
			$custom_colors[] = ".vc-card.boxed,.vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-panel-body,.vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active,.vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active >a:hover, .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active >a:focus,.vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab >a:hover, .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab >a:focus,.vc_tta.vc_tta-style-theme-eram .vc_tta-panel .vc_tta-panel-heading .vc_tta-panel-title >a,.ol-price-table.skin-dark,.em-client-box .inner,.tagcloud a,.em-blog-post.layout-masonry .post-contents,.em-blog-wrapper .format-embed, .em-single-post .format-embed,body.eram-theme-dark .vc-card.boxed,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-panel-body,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active >a:hover,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active >a:focus,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab >a:hover,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab >a:focus,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram .vc_tta-panel .vc_tta-panel-heading .vc_tta-panel-title >a,body.eram-theme-dark .ol-price-table.skin-dark,body.eram-theme-dark .em-client-box .inner,body.eram-theme-dark .tagcloud a,body.eram-theme-dark .em-blog-post.layout-masonry .post-contents,body.eram-theme-dark .em-blog-wrapper .format-embed,body.eram-theme-dark .em-single-post .format-embed{background-color:$eram_c_boxed_bg;}";
			$custom_colors[] = '.vc_tta.vc_tta-style-theme-eram .vc_tta-panel .vc_tta-panel-heading .vc_tta-panel-title >a:hover, .vc_tta.vc_tta-style-theme-eram .vc_tta-panel .vc_tta-panel-heading .vc_tta-panel-title >a:focus,.vc_tta.vc_tta-style-theme-eram .vc_tta-panel.vc_active .vc_tta-panel-heading .vc_tta-panel-title >a,.tagcloud a:hover,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram .vc_tta-panel .vc_tta-panel-heading .vc_tta-panel-title >a:hover,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram .vc_tta-panel .vc_tta-panel-heading .vc_tta-panel-title >a:focus,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram .vc_tta-panel.vc_active .vc_tta-panel-heading .vc_tta-panel-title >a,body.eram-theme-dark .tagcloud a:hover{background-color:'.eram_color_luminance($eram_c_boxed_bg,-0.2).'}';
		}

		// Border color
		$eram_c_border = ERAM_Kirki::get_option('eram_theme_options',$eram_c_border_option,$eram_c_border_default);
		if ( $eram_c_border != $eram_c_border_default){
			$custom_colors[] = ".single-eramfolio .page-contents .the-meta,.em-single-post nav.navigation, .single-eramfolio nav.navigation,.em-blog-post.layout-minimal,.widget .widget-title,.simple-page-head .title-wrapper .page-title:before,.vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-panels,.vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active,.ol-price-table.skin-dark,.page-footer,.em-blog-post.layout-classic .post-date,.vc-card .links,body.eram-theme-dark .single-eramfolio .page-contents .the-meta,.em-single-post nav.navigation,body.eram-theme-dark  .single-eramfolio nav.navigation,body.eram-theme-dark .em-blog-post.layout-minimal,body.eram-theme-dark .widget .widget-title,body.eram-theme-dark .simple-page-head .title-wrapper .page-title:before,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-panels,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active,body.eram-theme-dark .ol-price-table.skin-dark,body.eram-theme-dark .page-footer,body.eram-theme-dark .em-blog-post.layout-classic .post-date,body.eram-theme-dark .vc-card .links, .vc-card.boxed, body.eram-theme-dark .vc-card.boxed{border-color:$eram_c_border}";
			$custom_colors[] = ".em-blog-wrapper.layout-minimal.with-sidebar .blog-contents:before, .em-blog-wrapper.layout-masonry.with-sidebar .blog-contents:before,.vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active:after,body.eram-theme-dark .em-blog-wrapper.layout-minimal.with-sidebar .blog-contents:before,body.eram-theme-dark .em-blog-wrapper.layout-masonry.with-sidebar .blog-contents:before,body.eram-theme-dark .vc_tta.vc_tta-style-theme-eram.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab.vc_active:after{background-color:$eram_c_border;}";
		}

		// Link color
		$eram_c_link = ERAM_Kirki::get_option('eram_theme_options',$eram_c_link_option,$eram_c_link_default);
		if( $eram_c_link != $eram_c_link_default){
			$custom_colors[] = 'a,body.eram-theme-dark a{color:'.$eram_c_link.'}';
			$custom_colors[] = 'a:hover,a:focus,body.eram-theme-dark a:hover,body.eram-theme-dark a:focus{color:'.eram_color_luminance($eram_c_link,-0.2).'}';
		}

		if ( $site_layout == 'side')
		{

			// sidebar
			$eram_c_side_bg = ERAM_Kirki::get_option('eram_theme_options',$eram_c_side_bg_option,$eram_c_side_bg_default);
			if ( $eram_c_side_bg != $eram_c_side_bg_default){
				$custom_colors[] = '#side-header .side-inner,body.eram-theme-dark #side-header .side-inner{background-color:'.$eram_c_side_bg.'}';
			}
			// sidebar menu item
			$eram_c_side_menu_item = ERAM_Kirki::get_option('eram_theme_options',$eram_c_side_menu_item_option,$eram_c_side_menu_item_default);
			if ( $eram_c_side_menu_item != $eram_c_side_menu_item_default){
				$custom_colors[] = '.slide-menu-wrapper a,.hamburger-wrapper .ham-label,body.eram-theme-dark .slide-menu-wrapper a,body.eram-theme-dark .hamburger-wrapper .ham-label{color:'.$eram_c_side_menu_item.'}';
				$custom_colors[] = '.slide-menu-wrapper a span:before,.hamburger-inner, .hamburger-inner::before, .hamburger-inner::after,body.eram-theme-dark .slide-menu-wrapper a span:before,body.eram-theme-dark .hamburger-inner, body.eram-theme-dark .hamburger-inner::before, body.eram-theme-dark .hamburger-inner::after{background-color:'.$eram_c_side_menu_item.'}';
			}
			// sidebar menu item hover and active
			$eram_c_side_menu_item_hover = ERAM_Kirki::get_option('eram_theme_options',$eram_c_side_menu_item_hover_option,$eram_c_side_menu_item_hover_default);
			if ( $eram_c_side_menu_item_hover != $eram_c_side_menu_item_hover_default){
				$custom_colors[] = '.slide-menu-wrapper li.current-menu-item > a, .slide-menu-wrapper li.current-menu-parent > a, .slide-menu-wrapper li.current-menu-ancestor > a, .slide-menu-wrapper li.active > a,body .slide-menu-wrapper a:hover,body.eram-theme-dark .slide-menu-wrapper li.current-menu-item > a,body.eram-theme-dark .slide-menu-wrapper li.current-menu-parent > a,body.eram-theme-dark .slide-menu-wrapper li.current-menu-ancestor > a,body.eram-theme-dark .slide-menu-wrapper li.active > a,body.eram-theme-dark .slide-menu-wrapper a:hover{color:'.$eram_c_side_menu_item_hover.'}';
				$custom_colors[] = ".slide-menu-wrapper a:hover span:before,body.eram-theme-dark .slide-menu-wrapper a:hover span:before{background-color:$eram_c_side_menu_item_hover;}";
			}
		}

		if ( $site_layout == 'bordered')
		{
			// Frame eram_c_frame
			$eram_c_frame = ERAM_Kirki::get_option('eram_theme_options',$eram_c_frame_option,$eram_c_frame_default);
			if ( $eram_c_frame != $eram_c_frame_default){
				$custom_colors[] = '.er-bordered-layout .er-top-bar, .er-bordered-layout .er-bottom-bar, .er-bordered-layout .er-left-bar, .er-bordered-layout .er-right-bar, .er-full-layout .er-top-bar, .er-full-layout .er-bottom-bar, .er-full-layout .er-left-bar, .er-full-layout .er-right-bar,body.eram-theme-dark.er-bordered-layout .er-top-bar,body.eram-theme-dark.er-bordered-layout .er-bottom-bar,body.eram-theme-dark.er-bordered-layout .er-left-bar,body.eram-theme-dark.er-bordered-layout .er-right-bar,body.eram-theme-dark.er-full-layout .er-top-bar,body.eram-theme-dark.er-full-layout .er-bottom-bar,body.eram-theme-dark.er-full-layout .er-left-bar,body.eram-theme-dark.er-full-layout .er-right-bar{background-color:'.$eram_c_frame.'}';
			}
		}

		//eram_c_classic_menu
		$eram_c_classic_menu = ERAM_Kirki::get_option('eram_theme_options',$eram_c_classic_menu_option,$eram_c_classic_menu_default);
		if ( $eram_c_classic_menu != $eram_c_classic_menu_default){
			$custom_colors[] = '#classic-menu >li > a,#classic-menu li a,body.eram-theme-dark #classic-menu >li > a,body.eram-theme-dark #classic-menu li a{color:'.$eram_c_classic_menu.'}';
			$custom_colors[] = ".hamburger-inner, .hamburger-inner::before, .hamburger-inner::after,body.eram-theme-dark .hamburger-inner, body.eram-theme-dark .hamburger-inner::before, body.eram-theme-dark .hamburger-inner::after{background-color:$eram_c_classic_menu;}";
		}
		//eram_c_classic_menu_hover
		$eram_c_classic_menu_hover = ERAM_Kirki::get_option('eram_theme_options',$eram_c_classic_menu_hover_option,$eram_c_classic_menu_hover_default);
		if ( $eram_c_classic_menu_hover != $eram_c_classic_menu_hover_default){
			$custom_colors[] = '#classic-menu >li > a:hover,#classic-menu .current-menu-parent > a, #classic-menu .current-menu-item > a, #classic-menu .current-menu-ancestor > a,#classic-menu li a:hover, #classic-menu li a:focus,body.eram-theme-dark #classic-menu >li > a:hover,body.eram-theme-dark #classic-menu .current-menu-parent > a,body.eram-theme-dark  #classic-menu .current-menu-item > a,body.eram-theme-dark  #classic-menu .current-menu-ancestor > a,body.eram-theme-dark #classic-menu li a:hover,body.eram-theme-dark  #classic-menu li a:focus{color:'.$eram_c_classic_menu_hover.'}';
		}
		//eram_c_classic_menu_hover
		$eram_c_classic_menu_bg = ERAM_Kirki::get_option('eram_theme_options',$eram_c_classic_menu_bg_option,$eram_c_classic_menu_bg_default);
		if ( $eram_c_classic_menu_bg != $eram_c_classic_menu_bg_default){
			$custom_colors[] = '#classic-menu ul.sub-menu,body.eram-theme-dark #classic-menu ul.sub-menu{background-color:'.$eram_c_classic_menu_bg.'}';
			$custom_colors[] = "#classic-menu >li>ul.sub-menu>li ul.sub-menu,body.eram-theme-dark #classic-menu >li>ul.sub-menu>li ul.sub-menu{border-color:$eram_c_classic_menu_bg}";
		}

		// eram_c_header_bg
		$eram_c_header_bg = ERAM_Kirki::get_option('eram_theme_options',$eram_c_header_bg_option,$eram_c_header_bg_default);
		if ( $eram_c_header_bg != $eram_c_header_bg_default){
			$custom_colors[] = '#classic-header,#top-header,body.eram-theme-dark #classic-header,body.eram-theme-dark #top-header{background-color:'.$eram_c_header_bg.'}';
		}

		// eram_c_top_menu_item
		$eram_c_top_menu_item = ERAM_Kirki::get_option('eram_theme_options',$eram_c_top_menu_item_option,$eram_c_top_menu_item_default);
		if ( $eram_c_top_menu_item != $eram_c_top_menu_item_default){
			$custom_colors[] = '#top-header .menu-wrapper li a,body.eram-theme-dark #top-header .menu-wrapper li a{color:'.$eram_c_top_menu_item.'}';
			$custom_colors[] = "#top-header .menu-wrapper li a >span:after,body.eram-theme-dark #top-header .menu-wrapper li a >span:after{background-color:$eram_c_top_menu_item}";
		}			
		

		// echo all into header
		$custom_colors = implode('',$custom_colors);
		$custom_colors = "<style id='eram-custom-colors'>" . $custom_colors . "</style>";
		echo $custom_colors;
	}

	add_action( 'wp_head', 'eram_custom_colors', 999 );
}

function eram_hextorgb($hex, $alpha = false) {
   $hex = str_replace('#', '', $hex);
   if ( strlen($hex) == 6 ) {
      $rgb['r'] = hexdec(substr($hex, 0, 2));
      $rgb['g'] = hexdec(substr($hex, 2, 2));
      $rgb['b'] = hexdec(substr($hex, 4, 2));
   }
   else if ( strlen($hex) == 3 ) {
      $rgb['r'] = hexdec(str_repeat(substr($hex, 0, 1), 2));
      $rgb['g'] = hexdec(str_repeat(substr($hex, 1, 1), 2));
      $rgb['b'] = hexdec(str_repeat(substr($hex, 2, 1), 2));
   }
   else {
      $rgb['r'] = '0';
      $rgb['g'] = '0';
      $rgb['b'] = '0';
   }
   if ( $alpha ) {
      $rgb['a'] = $alpha;
   }
   return $rgb;
}
function eram_lighten_alpha($color,$alpha=0.5)
{
	$rgba = eram_hextorgb($color,false);

	return "rgba({$rgba['r']},{$rgba['g']},{$rgba['b']},{$alpha})";
}
function eram_color_luminance( $hex, $percent ) {
	
	// validate hex string
	$hex = preg_replace( '/[^0-9a-f]/i', '', $hex );
	$new_hex = '#';
	
	if ( strlen( $hex ) < 6 ) {
		$hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
	}
	
	// convert to decimal and change luminosity
	for ($i = 0; $i < 3; $i++) {
		$dec = hexdec( substr( $hex, $i*2, 2 ) );
		$dec = min( max( 0, $dec + $dec * $percent ), 255 ); 
		$new_hex .= str_pad( dechex( $dec ) , 2, 0, STR_PAD_LEFT );
	}		
	
	return $new_hex;
}

/**
 * ----------------------------------------------------------------------------------------
 * Custom layouts specific CSS
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists('eram_layout_specific_styles') )
{
	function eram_layout_specific_styles() {
		
		$styles ="";

		//--- top layout
		$top_header_padding = ERAM_Kirki::get_option('eram_theme_options','eram_top_padding',70);
		$styles .="@media (min-width: 769px){top-header{padding:0 ".$top_header_padding."px}}";

		
		echo '<style id="eram-layout-specific-styles">' . preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $styles)) .'</style>';
	
	}

	add_action( 'wp_head', 'eram_layout_specific_styles' );
}

/**
 * ----------------------------------------------------------------------------------------
 * Custom colors for shop
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists('eram_shop_custom_colors') ){
    function eram_shop_custom_colors()
    {
        if ( class_exists( 'WooCommerce' ) ) {

            $styles = '';
            // get the color setting
            $default_accent_color = '#da7878';
            $accent_color = ERAM_Kirki::get_option( 'eram_theme_options', 'eram_shop_accent_color', $default_accent_color );
            if ( $accent_color != $default_accent_color ) {

                $styles .= "
                    .woocommerce-page span.onsale, 
                    .woocommerce span.onsale,
                    #shop-cart-icon .counter
                    {
                        background-color:{$accent_color};
                    }
                ";
            }

            $default_shop_gallery_bg = '#ededed';
            $shop_gallery_bg = ERAM_Kirki::get_option( 'eram_theme_options', 'eram_shop_photo_bg', $default_shop_gallery_bg );

            if ( $shop_gallery_bg != $default_shop_gallery_bg ) {

                $styles .= "
                    .er-product-scene .er-product-left
                    {
                        background-color:{$shop_gallery_bg};
                    }
                ";
            }

            echo '<style id="eram-shop">' . preg_replace( '/[ \t]+/', ' ', preg_replace( '/[\r\n]+/', "\n", $styles ) ) . '</style>';
        }
    }
}
add_action( 'wp_head', 'eram_shop_custom_colors' );


function eram_dequeue_jquery_migrate( $scripts ) {
    if ( ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
        $jquery_dependencies = $scripts->registered['jquery']->deps;
        $scripts->registered['jquery']->deps = array_diff( $jquery_dependencies, array( 'jquery-migrate' ) );
    }
}
add_action( 'wp_default_scripts', 'eram_dequeue_jquery_migrate' );



/**
* Custom Page header for pages
*/
add_action( 'wp_head', 'eram_global_page_header_styles' );
if ( ! function_exists('eram_global_page_header_styles') )
{
    function eram_global_page_header_styles() {

        $styles = '';
        $has_overlay = Eram_Kirki::get_option( 'eram_theme_options', 'eram_page_header_overlay', 1 );
        if ( $has_overlay == 1 ){

            $needs_custom = Eram_Kirki::get_option( 'eram_theme_options', 'eram_page_header_custom_colors', 0 );
            if ( $needs_custom == 1)
            {
                $overlay_color = Eram_Kirki::get_option( 'eram_theme_options', 'eram_page_header_overlay_color', 'rgba(0,0,0,0.5)' );
                $contents_color = Eram_Kirki::get_option( 'eram_theme_options', 'eram_page_header_contents_color', '#ffffff' );
                $styles .= "
                .page.layout-header-side .bg-wrapper:after,
                .page-head:before,
                .em-has-cover>.inner-wrapper:before, 
                .em-has-cover>.vcenter:before{
                    background:$overlay_color;
                    opacity:1;
                }
                .page-head.has-cover .description,
                .page-head.has-cover .title,
                .page.layout-header-side .side-contents,
                .single-eramfolio .page-head.has-cover .cats a,
                .em-has-cover>.inner-wrapper .title, 
                .em-has-cover>.vcenter .title,
                .em-has-cover>.inner-wrapper .description, 
                .em-has-cover>.vcenter .description,
                .single-eramfolio.layout-header-side .page-side .side-contents .cats a,
                .em-single-post.layout-modern .page-head .title-wrapper .title,
                .em-single-post.layout-modern .page-head .title-wrapper .head a,
                .em-single-post.layout-header-side .page-side .side-contents .cats, 
                .em-single-post.layout-header-side .page-side .side-contents .cats a, 
                .em-single-post.layout-header-side .page-side .side-contents .date, 
                .em-single-post.layout-header-side .page-side .side-contents .date a,
                .em-single-post.layout-header-side .page-side .side-contents a.avatar-wrapper span.author,
                .proof-header .proof-date{
                    color: $contents_color;
                }
                .single-eramfolio.layout-header-side .page-side .side-contents .cats a:hover,
                .single-eramfolio.layout-header-side .page-side .side-contents .cats a:focus,
                .em-single-post.layout-modern .page-head .title-wrapper .head a:hover,
                .em-single-post.layout-modern .page-head .title-wrapper .head a:focus,
                .em-single-post.layout-header-side .page-side .side-contents .cats a:hover,
                .em-single-post.layout-header-side .page-side .side-contents .cats a:focus, 
                .em-single-post.layout-header-side .page-side .side-contents .date a:hover,
                .em-single-post.layout-header-side .page-side .side-contents .date a:focus,
                .em-single-post.layout-header-side .page-side .side-contents a.avatar-wrapper:hover span.author,
                .em-single-post.layout-header-side .page-side .side-contents a.avatar-wrapper:focus span.author
                {
                    color: " .eram_color_luminance($contents_color,-0.90). ";
                }
                ";

            }
        }else{
            $styles .= ".page-head:before{background:transparent;}";
        }

        echo '<style id="eram-global-page-header">' . preg_replace( '/[ \t]+/', ' ', preg_replace( '/[\r\n]+/', "\n", $styles ) ) . '</style>';

    }
}