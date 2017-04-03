<?php
/**
 *	Icon Box Shortcode
 *
 *	owwwlab
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$pixel_icons = vc_pixel_icons();
vc_map( array(
    'base'            => 'eram_free_caption',
    'name'            => esc_html__( 'Free Caption', 'eram' ),
    'description'     => esc_html__( 'Caption for free Layer', 'eram' ),
    'category'        => ERAM_THEME_NAME,
    'content_element' => TRUE,
    'icon'            => ERAM_IMAGES.'/vc/fc.png',
    "as_child" => array('only' => 'eram_free_layer'),
    'params'          => array(
        array(
            'type'        => 'attach_image',
            'heading'     => esc_html__( 'Transparent Image', 'eram' ),
            'description' => esc_html__( 'Use a transparent png image', 'eram' ),
            'param_name'  => 'image',
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Heading Text', 'eram' ),
            'param_name'  => 'heading',
            "admin_label" => true,
        ),
        array(
            'type'        => 'textarea_safe',
            'heading'     => esc_html__( 'Description Text', 'eram' ),
            'param_name'  => 'desc',
        ),
        array(
            'type'        => 'vc_link',
            'heading'     => esc_html__( 'Button & URL', 'eram' ),
            'param_name'  => 'btn_url',
            'description' => esc_html__( 'Configure the button URL. leave blank to ignore', 'eram' ),
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Theme', 'eram' ),
            'param_name'  => 'theme',
            'description' => esc_html__( 'Coloring of the element', 'eram' ),
            'value'       => array(
                esc_html__('Dark Texts','eram')   => 'dark-theme',
                esc_html__('Light Texts', 'eram')   => 'light-theme',
            ),
            'std' => 'light-theme',
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Style', 'eram' ),
            'param_name'  => 'style',
            'value'       => array(
                esc_html__('Simple','eram')   => 'simple',
                esc_html__('Boxed', 'eram')   => 'boxed',
            ),
            'std' => 'simple',
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Extra class name', 'eram' ),
            'param_name'  => 'el_class',
            'description' => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'eram' ),
        ),
    )
) );


class WPBakeryShortCode_Eram_Free_Caption extends WPBakeryShortCode
{
}