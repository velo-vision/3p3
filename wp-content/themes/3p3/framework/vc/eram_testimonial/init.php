<?php
/**
 *	Testimonial Shortcode
 *
 *	owwwlab
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

vc_map( array(
    'base'            => 'eram_testimonial',
    'name'            => esc_html__( 'Testimonial', 'eram' ),
    'description'     => esc_html__( 'A single Testimonial item', 'eram' ),
    'category'        => ERAM_THEME_NAME,
    'content_element' => TRUE,
    'icon'            => ERAM_IMAGES.'/vc/t.png',
    'params'          => array(
        array(
            'type'        => 'attach_image',
            'heading'     => esc_html__( 'Image', 'eram' ),
            'param_name'  => 'image',
            'value'       => '',
            'description' => esc_html__( 'Add image here.', 'eram' ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Title', 'eram' ),
            'param_name'  => 'title',
            'admin_label' => TRUE,
            'description' => esc_html__( 'Title of the item.', 'eram' ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Sub-title', 'eram' ),
            'param_name'  => 'subtitle',
            'description' => esc_html__( 'Goes bellow the title', 'eram' ),
        ),
        array(
            'type'        => 'textarea_safe',
            'heading'     => esc_html__( 'Testimonial text', 'eram' ),
            'param_name'  => 'description',
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Extra class name', 'eram' ),
            'param_name'  => 'el_class',
            'description' => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'eram' ),
        ),
    ),
) );


class WPBakeryShortCode_Eram_Testimonial extends WPBakeryShortCode
{
}