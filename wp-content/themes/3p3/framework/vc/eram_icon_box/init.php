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
    'base'            => 'eram_icon_box',
    'name'            => esc_html__( 'Iconbox', 'eram' ),
    'description'     => esc_html__( 'Single Iconbox element', 'eram' ),
    'category'        => ERAM_THEME_NAME,
    'content_element' => TRUE,
    'icon'            => ERAM_IMAGES.'/vc/ib.png',
    'params'          => array(
    	array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Icon library', 'eram' ),
			'value' => array(
				__( 'Font Awesome', 'eram' ) => 'fontawesome',
				__( 'Open Iconic', 'eram' ) => 'openiconic',
				__( 'Typicons', 'eram' ) => 'typicons',
				__( 'Entypo', 'eram' ) => 'entypo',
				__( 'Linecons', 'eram' ) => 'linecons',
				__( 'Pixel', 'eram' ) => 'pixelicons',
				__( 'Mono Social', 'eram' ) => 'monosocial',
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
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Heading', 'eram' ),
            'param_name'  => 'heading',
            'std'         => '',
            "admin_label" => true,
        ),
        array(
            'type'        => 'textarea_html',
            'heading'     => esc_html__( 'content', 'eram' ),
            'param_name'  => 'content',
            'std'         => '',
        ),
        array(
            'type'        => 'vc_link',
            'heading'     => esc_html__( 'Linked Button', 'eram' ),
            'param_name'  => 'btn_url',
            'description' => esc_html__( 'Configure the button. leave blank to ignore', 'eram' ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Extra class name', 'eram' ),
            'param_name'  => 'el_class',
            'description' => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'eram' ),
        ),
    )
) );


class WPBakeryShortCode_Eram_Icon_Box extends WPBakeryShortCode
{
}