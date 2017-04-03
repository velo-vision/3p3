<?php
/**
 *    eram button Shortcode
 *
 *    owwwlab
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$pixel_icons = vc_pixel_icons();
vc_map( array(
    'base'            => 'eram_btn',
    'name'            => esc_html__( 'Theme Button', 'eram' ),
    'description'     => esc_html__( 'Theme style buttons', 'eram' ),
    'category'        => ERAM_THEME_NAME,
    'content_element' => TRUE,
    'icon'            => ERAM_IMAGES.'/vc/bt.png',
    'params'          => array(
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Text on button', 'eram' ),
            'param_name'  => 'btn_text',
            'std'         => '',
            "admin_label" => true,
        ),
        array(
            'type'        => 'vc_link',
            'heading'     => esc_html__( 'Button URL', 'eram' ),
            'param_name'  => 'btn_url',
            'description' => esc_html__( 'Configure the button URL. leave blank to ignore', 'eram' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Size', 'eram' ),
            'value' => array(
                esc_html__( 'Extra Small', 'eram' ) => 'btn-extra-small',
                esc_html__( 'Small', 'eram' ) => 'btn-small',
                esc_html__( 'Medium (default)', 'eram' ) => 'btn-medium',
                esc_html__( 'Large', 'eram' ) => 'btn-large',
            ),
            'param_name' => 'size',
            'std'   => 'btn-medium'
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Shape', 'eram' ),
            'value' => array(
                esc_html__( 'Square (default)', 'eram' ) => 'square',
                esc_html__( 'Round corner', 'eram' ) => 'btn-round',
                esc_html__( 'Rounded', 'eram' ) => 'btn-circle',
            ),
            'param_name' => 'shape',
            'std'   => 'square'
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Color', 'eram' ),
            'value' => array(
                esc_html__( 'Default', 'eram' ) => 'none',
                esc_html__( 'Red', 'eram' ) => 'btn-skin-red',
                esc_html__( 'Blue', 'eram' ) => 'btn-skin-blue',
                esc_html__( 'Green', 'eram' ) => 'btn-skin-green',
                esc_html__( 'Purple', 'eram' ) => 'btn-skin-purple',
                esc_html__( 'Yellow', 'eram' ) => 'btn-skin-yellow',
                esc_html__( 'White', 'eram' ) => 'btn-skin-white',
                esc_html__( 'Dark', 'eram' ) => 'btn-skin-dark',
            ),
            'param_name' => 'color',
            'std'   => 'square'
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Transparent Background", 'eram' ),
            "param_name" => "transparent",
            "value"      => array(
                esc_html__( 'Enable', 'eram' ) => 'yes',
            ),
            "std"        => 'no',
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Wider Button", 'eram' ),
            "param_name" => "wide",
            "value"      => array(
                esc_html__( 'Enable', 'eram' ) => 'yes',
            ),
            "std"        => 'no',
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Add Icon?", 'eram' ),
            "param_name" => "with_icon",
            "value"      => array(
                esc_html__( 'Enable', 'eram' ) => 'yes',
            ),
            "std"        => 'no',
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Animate Icon?", 'eram' ),
            "param_name" => "animate_icon",
            "value"      => array(
                esc_html__( 'Enable', 'eram' ) => 'yes',
            ),
            "std"        => 'no',
            'dependency' => array(
                'element' => 'with_icon',
                'value' => array( 'yes' ),
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Icon Alignment', 'eram' ),
            'value' => array(
                esc_html__( 'Right', 'eram' ) => 'right',
                esc_html__( 'Left', 'eram' ) => 'left',
            ),
            'param_name' => 'icon_align',
            'std'       => 'right',
            'dependency' => array(
                'element' => 'with_icon',
                'value' => array( 'yes' ),
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Icon library', 'eram' ),
            'value' => array(
                esc_html__( 'Font Awesome', 'eram' ) => 'fontawesome',
                esc_html__( 'Open Iconic', 'eram' ) => 'openiconic',
                esc_html__( 'Typicons', 'eram' ) => 'typicons',
                esc_html__( 'Entypo', 'eram' ) => 'entypo',
                esc_html__( 'Linecons', 'eram' ) => 'linecons',
                esc_html__( 'Pixel', 'eram' ) => 'pixelicons',
                esc_html__( 'Mono Social', 'eram' ) => 'monosocial',
            ),
            'param_name' => 'icon_type',
            'description' => esc_html__( 'Select icon library.', 'eram' ),
            'dependency' => array(
                'element' => 'with_icon',
                'value' => array( 'yes' ),
            ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon', 'eram' ),
            'param_name' => 'icon_fontawesome',
            'value' => 'fa fa-info-circle',
            'settings' => array(
                'emptyIcon' => false,
                // default true, display an "EMPTY" icon?
                'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'fontawesome',
            ),
            'description' => esc_html__( 'Select icon from library.', 'eram' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon', 'eram' ),
            'param_name' => 'icon_openiconic',
            'settings' => array(
                'emptyIcon' => false,
                // default true, display an "EMPTY" icon?
                'type' => 'openiconic',
                'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'openiconic',
            ),
            'description' => esc_html__( 'Select icon from library.', 'eram' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon', 'eram' ),
            'param_name' => 'icon_typicons',
            'settings' => array(
                'emptyIcon' => false,
                // default true, display an "EMPTY" icon?
                'type' => 'typicons',
                'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'typicons',
            ),
            'description' => esc_html__( 'Select icon from library.', 'eram' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon', 'eram' ),
            'param_name' => 'icon_entypo',
            'settings' => array(
                'emptyIcon' => false,
                // default true, display an "EMPTY" icon?
                'type' => 'entypo',
                'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'entypo',
            ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon', 'eram' ),
            'param_name' => 'icon_linecons',
            'settings' => array(
                'emptyIcon' => false,
                // default true, display an "EMPTY" icon?
                'type' => 'linecons',
                'iconsPerPage' => 4000,
                // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'linecons',
            ),
            'description' => esc_html__( 'Select icon from library.', 'eram' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon', 'eram' ),
            'param_name' => 'icon_pixelicons',
            'settings' => array(
                'emptyIcon' => false,
                // default true, display an "EMPTY" icon?
                'type' => 'pixelicons',
                'source' => $pixel_icons,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'pixelicons',
            ),
            'description' => esc_html__( 'Select icon from library.', 'eram' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon', 'eram' ),
            'param_name' => 'icon_monosocial',
            'value' => 'vc-mono vc-mono-fivehundredpx', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => false, // default true, display an "EMPTY" icon?
                'type' => 'monosocial',
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'monosocial',
            ),
            'description' => esc_html__( 'Select icon from library.', 'eram' ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Extra class name', 'eram' ),
            'param_name'  => 'el_class',
            'description' => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'eram' ),
        ),
    )
) );


class WPBakeryShortCode_Eram_Btn extends WPBakeryShortCode
{
}
