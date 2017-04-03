<?php
/**
 *	Image Compare Shortcode
 *
 *	owwwlab
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

vc_map( array(
    'base'            => 'eram_image_compare',
    'name'            => esc_html__( 'Image Compare', 'eram' ),
    'description'     => esc_html__( 'before/after element', 'eram' ),
    'category'        => ERAM_THEME_NAME,
    'content_element' => TRUE,
    'icon'            => ERAM_IMAGES.'/vc/ic.png',
    'params'          => array(
        array(
            'type'        => 'attach_image',
            'heading'     => esc_html__( 'Before Image', 'eram' ),
            'param_name'  => 'image1',
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Before Text', 'eram' ),
            'param_name'  => 'before_text',
            'std'         => esc_html__( 'Before', 'eram' ),
        ),
        array(
            'type'        => 'attach_image',
            'heading'     => esc_html__( 'After Image', 'eram' ),
            'param_name'  => 'image2',
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'After Text', 'eram' ),
            'param_name'  => 'after_text',
            'std'         => esc_html__( 'After', 'eram' ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Extra class name', 'eram' ),
            'param_name'  => 'el_class',
            'description' => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'eram' ),
        ),
    ),
) );


class WPBakeryShortCode_Eram_Image_Compare extends WPBakeryShortCode
{
}