<?php
/**
 *    Eram WordPress Theme
 *
 *    owwwlab
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// If its not active disable these functions
$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );

if ( is_array( $active_plugins ) && ! in_array( 'js_composer/js_composer.php', $active_plugins ) && function_exists( 'vc_map' ) == FALSE )
{
    return;
}
else if ( function_exists( 'vc_map' ) == FALSE )
{
    return;
}

// Set Visual Composer As Theme Mode
add_action( 'vc_before_init', 'eram_visual_composer_init' );

function eram_visual_composer_init()
{
    vc_set_as_theme();
}


// Default Post Types
add_action( 'vc_before_init', 'eram_vc_default_post_types' );

function eram_vc_default_post_types()
{
    if ( function_exists( 'vc_set_default_editor_post_types' ) )
    {
        $list[] = 'page';

        if ( class_exists( 'EramFolio' ) ) $list[] = ERAM_FOLIO_CPT_NAME;

        vc_set_default_editor_post_types( $list );
    }
}

function eram_vc_add_elems()
{
    // Support for Shortcodes
    $eram_vc_templates_path = ERAM_FRAMEWORK . '/vc/';
    $eram_vc_shortcodes = array(
        'eram_team_members',
        'eram_image_compare',
        'eram_icon_box',
        'eram_price_table',
        'eram_testimonial',
        'eram_rail_carousel',
        'eram_double_carousel',
        'eram_single_gallery',
        'eram_call_to_action',
        'eram_free_layer',
        'eram_btn',
        'eram_free_caption',
        'eram_video',
        'eram_mask_image',
    );
    foreach ( $eram_vc_shortcodes as $shortcode_template ) {
        include_once $eram_vc_templates_path . $shortcode_template . '/init.php';
    }
}
add_action( 'vc_after_init', 'eram_vc_add_elems' );


// VC Tabs 4.7
function eram_vc_tta_tabs_setup() {
    
    $new_param = array( esc_html__('Theme Styled (if selected, other style settings will be ignored)','eram') => 'theme-eram' );
    
    $tabs_param        = WPBMap::getParam( 'vc_tta_tabs', 'style' );
    $accordion_param   = WPBMap::getParam( 'vc_tta_accordion', 'style' );
    
    if ( ! is_array( $tabs_param ) || ! is_array( $accordion_param ) ) {
        return;
    }
    
    $tabs_param['value']       = array_merge( $new_param, $tabs_param['value'] );
    $accordion_param['value']  = array_merge( $new_param, $accordion_param['value'] );

    vc_update_shortcode_param( 'vc_tta_tabs', $tabs_param );
    vc_update_shortcode_param( 'vc_tta_accordion', $accordion_param );
}

add_action( 'vc_after_mapping', 'eram_vc_tta_tabs_setup' );


/**
* adds responsive parameter to spacer
*/
if ( ! function_exists('eram_spacer_params') )
{
    function eram_spacer_params() {
        $attributes = array(
            
            array(
                'type' => 'textfield',
                'heading' => esc_html__( "Tablet Height", 'eram' ),
                'param_name' => 'tablet_height',
                'description' => esc_html__( "When the screen is smaller than 1024px", 'eram' ),
                'weight'    => 0,
                'value'     => 20,
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( "Mobile Height", 'eram' ),
                'param_name' => 'mobile_height',
                'description' => esc_html__( "When the screen is smaller than 480px", 'eram' ),
                'weight'    => 0,
                'value'     => 10,
            ),
        );
        vc_add_params( 'vc_empty_space', $attributes ); 

    }
    add_action( 'vc_after_init', 'eram_spacer_params' );

}


