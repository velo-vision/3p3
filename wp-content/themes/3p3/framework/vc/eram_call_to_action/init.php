<?php
/**
 *    Call to action Shortcode
 *
 *    owwwlab
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$pixel_icons = vc_pixel_icons();
vc_map( array(
    'base'            => 'eram_call_to_action',
    'name'            => esc_html__( 'Call to action', 'eram' ),
    'description'     => esc_html__( 'Encourage visitors to click...', 'eram' ),
    'category'        => ERAM_THEME_NAME,
    'content_element' => TRUE,
    'icon'            => ERAM_IMAGES.'/vc/ca.png',
    'params'          => array(
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Heading', 'eram' ),
            'param_name'  => 'heading',
            'std'         => '',
            "admin_label" => true,
        ),

        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Sub Headeing', 'eram' ),
            'param_name'  => 'subheading',
            'std'         => '',
        ),
        array(
            'type'        => 'vc_link',
            'heading'     => esc_html__( 'Linked Button', 'eram' ),
            'param_name'  => 'btn_url',
            'description' => esc_html__( 'Configure the button. leave blank to ignore', 'eram' ),
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Include Icon", 'eram' ),
            "param_name" => "use_icon",
            "value"      => array(
                esc_html__( 'Enable', 'eram' ) => 'yes',
            ),
            "std"        => 'yes',
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
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Theme', 'eram' ),
            'param_name'  => 'theme',
            'description' => esc_html__( 'Coloring of the item', 'eram' ),
            'value'       => array(
                esc_html__('Dark Theme','eram')   => 'dark-theme',
                esc_html__('Light Theme', 'eram')   => 'light-theme',
            ),
            'std' => 'light-theme',

        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Extra class name', 'eram' ),
            'param_name'  => 'el_class',
            'description' => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'eram' ),
        ),
    )
) );


class WPBakeryShortCode_Eram_Call_To_Action extends WPBakeryShortCode
{
}
