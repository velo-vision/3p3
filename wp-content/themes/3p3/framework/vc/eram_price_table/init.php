<?php
/**
 *	Price Table Shortcode
 *
 *	owwwlab
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

vc_map( array(
    'base'            => 'eram_price_table',
    'name'            => esc_html__( 'Price Table', 'eram' ),
    'description'     => esc_html__( 'A single Price Table Item', 'eram' ),
    'category'        => ERAM_THEME_NAME,
    'content_element' => TRUE,
    'icon'            => ERAM_IMAGES.'/vc/pt.png',
    'params'          => array(
        array(
            'type'        => 'attach_image',
            'heading'     => esc_html__( 'Cover Image', 'eram' ),
            'param_name'  => 'image',
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Plan Title', 'eram' ),
            'param_name'  => 'title',
            'admin_label' => TRUE,
            'description' => esc_html__( 'Title of the plan.', 'eram' ),
            'std'         => '',
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Subtitle', 'eram' ),
            'param_name'  => 'subtitle',
            'std'         => '',
        ),
        array(
            'type'        => 'exploded_textarea_safe',
            'heading'     => esc_html__( 'Features List', 'eram' ),
            'param_name'  => 'features',
            'description' => esc_html__( 'Each feature in a new line.', 'eram' ),
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


class WPBakeryShortCode_Eram_Price_Table extends WPBakeryShortCode
{
}