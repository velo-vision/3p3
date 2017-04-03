<?php
/**
 *	Video Shortcode
 *
 *	owwwlab
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

vc_map( array(
        'name' => esc_html__( 'Mask Image', 'eram' ),
        'base' => 'eram_mask_image',
        'icon' => ERAM_IMAGES.'/vc/mi.png',
        'category' => ERAM_THEME_NAME,
        'description' => esc_html__( 'Single Image with mask reveal', 'eram' ),
        'params' => array(
           array(
                'type'        => 'attach_image',
                'heading'     => esc_html__( 'Image', 'eram' ),
                'param_name'  => 'image',
                'value'       => '',
                'description' => esc_html__( 'Add image here.', 'eram' ),
            ),
           array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Direction', 'eram' ),
                'param_name'  => 'dir',
                'description' => esc_html__( 'Mask Direction', 'eram' ),
                'value'       => array(
                    esc_html__('From Top','eram')   => 'top',
                    esc_html__('From Bottom', 'eram')   => 'bottom',
                    esc_html__('From Left','eram')   => 'left',
                    esc_html__('From Right', 'eram')   => 'right'
                ),
                'std' => 'left',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Extra class name', 'eram' ),
                'param_name' => 'el_class',
                'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'eram' ),
            ),
            array(
                'type' => 'css_editor',
                'heading' => esc_html__( 'CSS box', 'eram' ),
                'param_name' => 'css',
                'group' => esc_html__( 'Design Options', 'eram' ),
            ),
        ),
    )
);


class WPBakeryShortCode_Eram_Mask_Image extends WPBakeryShortCode
{
}