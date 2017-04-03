<?php
/**
 *    Free Layer Shortcode
 *
 *    owwwlab
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

vc_map( array(
    'base'                    => 'eram_free_layer',
    'name'                    => esc_html__( 'Free Layer', 'eram' ),
    'description'             => esc_html__( 'Stays on top of the contents', 'eram' ),
    'category'                => ERAM_THEME_NAME,
    "as_parent"               => array( 'only' => 'eram_free_caption,vc_column_text,vc_custom_heading,vc_btn,eram_btn,vc_empty_space' ),
    // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element"         => TRUE,
    "show_settings_on_create" => TRUE,
    "is_container"            => TRUE,
    "icon"                    => ERAM_IMAGES.'/vc/fl.png',
    'params'                  => array(

        array(
            "type"        => "dropdown",
            "heading"     => esc_html__( "Position of layer", 'eram' ),
            "param_name"  => "fl_position",
            "description" => esc_html__( "position based on the parent row or the page. (use page in fullscreen elements like kenburn gallery)", 'eram' ),
            "value"       => array(
                esc_html__( "on top of parent row", 'eram' ) => 'row',
                esc_html__( "on top of page", 'eram' )       => 'page',
            ),
            "std"         => 'page',
        ),
        array(
            "type"        => "textfield",
            "heading"     => esc_html__( "Extra class name", 'eram' ),
            "param_name"  => "el_class",
            "description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'eram' ),
        ),
    ),
    'js_view'                 => 'VcColumnView',
) );


class WPBakeryShortCode_Eram_Free_Layer extends WPBakeryShortCodesContainer
{
}