<?php
/**
 *    Double Carousel Shortcode
 *
 *    owwwlab
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
vc_map( array(
    'base'                    => 'eram_double_carousel',
    'name'                    => esc_html__( 'Double Carousel', 'eram' ),
    'description'             => esc_html__( 'Eye catching split screen carousel', 'eram' ),
    'category'                => ERAM_THEME_NAME,
    'content_element'         => TRUE,
    'show_settings_on_create' => TRUE,
    'icon'                    => ERAM_IMAGES.'/vc/dc.png',
    'as_parent'               => array( 'only' => 'eram_double_carousel_item' ),
    'params'                  => array(
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Mouse wheel navigation?", 'eram' ),
            "param_name" => "mouse",
            "value"      => array(
                esc_html__( 'Enable', 'eram' ) => 'yes',
            ),
            "std"        => 'yes',
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Keyboard navigation?", 'eram' ),
            "param_name" => "keyboard",
            "value"      => array(
                esc_html__( 'Enable', 'eram' ) => 'yes',
            ),
            "std"        => 'yes',
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Touch", 'eram' ),
            "param_name" => "touchswipe",
            "value"      => array(
                esc_html__( 'Enable', 'eram' ) => 'yes',
            ),
            "std"        => 'yes',
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Show navigation bullets?", 'eram' ),
            "param_name" => "bulletcontroll",
            "value"      => array(
                esc_html__( 'Enable', 'eram' ) => 'yes',
            ),
            "std"        => 'yes',
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Show next/prev links?", 'eram' ),
            "param_name" => "nextprev",
            "value"      => array(
                esc_html__( 'Enable', 'eram' ) => 'yes',
            ),
            "std"        => 'yes',
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Autoplay", 'eram' ),
            "param_name" => "autoplay",
            "value"      => array( esc_html__( 'Enable', 'eram' ) => 'yes' ),
            "std"        => 'yes',
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Slide Numbers", 'eram' ),
            "param_name" => "slide_number",
            "value"      => array( esc_html__( 'Enable', 'eram' ) => 'yes' ),
            "std"        => 'yes',
        ),

        array(
            "type"        => "textfield",
            "heading"     => esc_html__( "Transition Duration", 'eram' ),
            "param_name"  => "duration",
            "value"       => 1.4,
            "description" => esc_html__( "in seconds", 'eram' ),
            "std"         => 1.4,
        ),

        array(
            "type"        => "textfield",
            "heading"     => esc_html__( "Autoplay duration", 'eram' ),
            "param_name"  => "auto_duration",
            "description" => esc_html__( "Duration of changing slides (in second)", 'eram' ),
            'value'       => 5,
            'dependency'  => array(
                'element' => 'autoplay',
                'value'   => array( 'yes' ),
            ),
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

// doubel carousel item
vc_map( array(
    'base'            => 'eram_double_carousel_item',
    'name'            => esc_html__( 'Single Item', 'eram' ),
    'description'     => esc_html__( 'Single item of the Carousel', 'eram' ),
    'category'        => ERAM_THEME_NAME,
    'content_element' => TRUE,
    'icon'            => ERAM_IMAGES.'/vc/dc.png',
    'as_child'        => array( 'only' => 'eram_double_carousel' ),
    'params'          => array(
        array(
            'type'        => 'attach_image',
            'heading'     => esc_html__( 'Image', 'eram' ),
            'param_name'  => 'image',
            'value'       => '',
            'description' => esc_html__( 'Add cover image here.', 'eram' ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Title', 'eram' ),
            'param_name'  => 'title',
            'admin_label' => TRUE,
            'description' => esc_html__( 'Title of the item.', 'eram' ),
        ),
        array(
            'type'        => 'textarea_safe',
            'heading'     => esc_html__( 'Description', 'eram' ),
            'param_name'  => 'description',
            'description' => esc_html__( 'Short description of the item.', 'eram' ),
        ),
        array(
            'type'        => 'vc_link',
            'heading'     => esc_html__( 'URL', 'eram' ),
            'param_name'  => 'btn_url',
            'description' => esc_html__( 'Url of the button. leave blank to ignore', 'eram' ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Extra class name', 'eram' ),
            'param_name'  => 'el_class',
            'description' => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'eram' ),
        ),
    ),
) );

class WPBakeryShortCode_Eram_Double_Carousel extends WPBakeryShortCodesContainer
{
}

class WPBakeryShortCode_Eram_Double_Carousel_Item extends WPBakeryShortCode
{
}