<?php
/**
 *    Team Members Shortcode
 *
 *    owwwlab
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Team Member
vc_map( array(
    'base'            => 'eram_team_member',
    'name'            => esc_html__( 'Team Member', 'eram' ),
    'description'     => esc_html__( 'Member details', 'eram' ),
    'category'        => ERAM_THEME_NAME,
    'content_element' => TRUE,
    'icon'            => ERAM_IMAGES.'/vc/t.png',
    'params'          => array(
        array(
            'type'        => 'attach_image',
            'heading'     => esc_html__( 'Image', 'eram' ),
            'param_name'  => 'image',
            'value'       => '',
            'description' => esc_html__( 'Add team member image here.', 'eram' ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Name', 'eram' ),
            'param_name'  => 'name',
            'admin_label' => TRUE,
            'description' => esc_html__( 'Name of the member.', 'eram' ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Sub Title', 'eram' ),
            'param_name'  => 'sub_title',
            'description' => esc_html__( 'Position or title of the member.', 'eram' ),
        ),
        array(
            'type'        => 'vc_link',
            'heading'     => esc_html__( 'URL', 'eram' ),
            'param_name'  => 'btn_url',
            'description' => esc_html__( 'Configure the linked URL. leave blank to ignore', 'eram' ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Extra class name', 'eram' ),
            'param_name'  => 'el_class',
            'description' => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'eram' ),
        ),
    ),
) );


class WPBakeryShortCode_Eram_Team_Member extends WPBakeryShortCode
{
}