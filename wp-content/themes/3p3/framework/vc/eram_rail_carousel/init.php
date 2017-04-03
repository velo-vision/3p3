<?php
/**
 *    Rail Carousel Shortcode
 *
 *    owwwlab
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

vc_map( array(
    'base'                    => 'eram_rail_carousel',
    'name'                    => esc_html__( 'Rail Carousel', 'eram' ),
    'description'             => esc_html__( 'Eye catching fullscreen carousel', 'eram' ),
    'category'                => ERAM_THEME_NAME,
    'content_element'         => TRUE,
    'show_settings_on_create' => TRUE,
    'icon'                    => ERAM_IMAGES.'/vc/rc.png',
    'as_parent'               => array( 'only' => 'eram_rail_carousel_item' ),
    'params'                  => array(
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Background Type', 'eram' ),
            'param_name'  => 'bgtype',
            'description' => esc_html__( 'How you want the background of slides to be', 'eram' ),
            'value'       => array(
                esc_html__('Solid Color (based on theme)','eram')   => 'none',
                esc_html__('Background Image (set for each slide)', 'eram')   => 'bgimage',
                esc_html__('Adaptive Color (automatic select from image)', 'eram')   => 'bgcolor',
            ),
            'std' => 'bgimage',
            "admin_label" => true,
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Theme', 'eram' ),
            'param_name'  => 'theme',
            'description' => esc_html__( 'Coloring of the slider', 'eram' ),
            'value'       => array(
                esc_html__('Dark Theme','eram')   => 'dark-theme',
                esc_html__('Light Theme', 'eram')   => 'light-theme',
            ),
            'std' => 'dark-theme',
            "admin_label" => true,
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Background Overlay', 'eram' ),
            'param_name'  => 'bgoverlay',
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
            "heading"    => esc_html__( "Mouse Parallax Effect", 'eram' ),
            "param_name" => "parallax",
            "value"      => array(
                esc_html__( 'Enable', 'eram' ) => 'yes',
            ),
            "std"        => 'yes',
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


vc_map( array(
    'base'            => 'eram_rail_carousel_item',
    'name'            => esc_html__( 'Single Slide', 'eram' ),
    'description'     => esc_html__( 'Single Slide of the Rail Carousel', 'eram' ),
    'category'        => ERAM_THEME_NAME,
    'content_element' => TRUE,
    'icon'            => ERAM_IMAGES.'/vc/rc.png',
    'as_child'        => array( 'only' => 'eram_rail_carousel' ),
    'params'          => array(
        
        array(
            'type'        => 'attach_image',
            'heading'     => esc_html__( 'Image', 'eram' ),
            'param_name'  => 'image',
            'value'       => '',
            'description' => esc_html__( 'Add cover image here. Can be used as the cover image of the video if any.', 'eram' ),
        ),
        array(
            'type'        => 'attach_image',
            'heading'     => esc_html__( 'Background Image', 'eram' ),
            'param_name'  => 'bgimage',
            'value'       => '',
            'description' => esc_html__( 'Add Background image here.', 'eram' ),
        ),

        array(
            'type'        => 'href',
            'heading'     => esc_html__( 'MP4 Video URL', 'eram' ),
            'param_name'  => 'video',
            'admin_label' => TRUE,
            'description' => esc_html__( 'If you wish to have a <strong>small</strong> looped self-hosted video as the cover of slide, input the absolute URL of the video file being .mp4 format. You still need to add an image as the cover of the video. Leave blank to ignore.', 'eram' ),
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
            'description' => esc_html__( 'Url of the slide. leave blank to ignore', 'eram' ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Extra class name', 'eram' ),
            'param_name'  => 'el_class',
            'description' => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'eram' ),
        ),
    ),
) );



class WPBakeryShortCode_Eram_Rail_Carousel extends WPBakeryShortCodesContainer
{
}
class WPBakeryShortCode_Eram_Rail_Carousel_Item extends WPBakeryShortCode
{
}