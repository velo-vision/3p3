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
        'name' => esc_html__( 'Lightbox Video', 'eram' ),
        'base' => 'eram_video',
        'icon' => ERAM_IMAGES.'/vc/vp.png',
        'category' => ERAM_THEME_NAME,
        'description' => esc_html__( 'lightbox YouTube/Vimeo player', 'eram' ),
        'params' => array(
           array(
                'type'        => 'attach_image',
                'heading'     => esc_html__( 'Cover Image', 'eram' ),
                'param_name'  => 'cover',
                'value'       => '',
                'description' => esc_html__( 'Add image here.', 'eram' ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Video link', 'eram' ),
                'param_name' => 'link',
                'value' => 'https://vimeo.com/51589652',
                'admin_label' => true,
                'description' => sprintf( esc_html__( 'Enter link to video (Note: read more about available formats at WordPress <a href="%s" target="_blank">codex page</a>).', 'eram' ), 'http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F' ),
            ),
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Image Overlay', 'eram' ),
                'param_name'  => 'overlay',
                'std'         => 'none',
                'value'       => array(
                    esc_html__('None','eram')   => 'none',
                    esc_html__('Gradient #1 - Navy','eram')   => 'ov-grad1-alpha-40',
                    esc_html__('Gradient #2 - pink','eram')   => 'ov-grad2-alpha-40',
                    esc_html__('Gradient #3 - green','eram')   => 'ov-grad3-alpha-40',
                    esc_html__('Gradient #4 - orange','eram')   => 'ov-grad4-alpha-40',
                    esc_html__('Gradient #5 - pink/blue','eram')   => 'ov-grad5-alpha-40',
                    esc_html__('Gradient #6 - dark green','eram')   => 'ov-grad6-alpha-40',
                    esc_html__('Gradient #7 - orange/red','eram')   => 'ov-grad7-alpha-40',
                    esc_html__('Gradient #8 - purple','eram')   => 'ov-grad8-alpha-40',
                    esc_html__('Gradient #9 - green/yellow','eram')   => 'ov-grad9-alpha-40',
                    esc_html__('Gradient #10 - orange/red','eram')   => 'ov-grad10-alpha-40',
                ),
                'description' => esc_html__( 'select the overlay type of the background image', 'eram' ),
            ),
            array(
                "type"       => "checkbox",
                "heading"    => esc_html__( "Mask Reveal Effect?", 'eram' ),
                "param_name" => "has_mask",
                "value"      => array(
                    esc_html__( 'Enable', 'eram' ) => 'yes',
                ),
                "std"        => 'yes',
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
                'dependency'  => array(
                    'element' => 'has_mask',
                    'value'   => array( 'yes' ),
                ),
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


class WPBakeryShortCode_Eram_Video extends WPBakeryShortCode
{
}