<?php
/**
 *	Single Gallery Shortcode
 *
 *	owwwlab
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


if ( !class_exists('EramPlugin') )
    return;

function eram_vc_get_posts( $post_type = 'post' ) {
    $posts = get_posts( array(
        'posts_per_page' 	=> -1,
        'post_type'			=> $post_type,
    ));
    $result = array();
    foreach ( $posts as $post )	{
        $result[] = array(
            'value' => $post->ID,
            'label' => $post->post_title,
        );
    }
    return $result;
}

vc_map( array(
    'base'            => 'eram_single_gallery',
    'name'            => esc_html__( 'Single Gallery', 'eram' ),
    'description'     => esc_html__( 'Show a gallery in a page', 'eram' ),
    'category'        => ERAM_THEME_NAME,
    'content_element' => TRUE,
    'icon'            => ERAM_IMAGES.'/vc/sg.png',
    'params'          => array(
        array(
            'type' => 'autocomplete',
            'heading' => esc_html__( 'Select Gallery', 'eram' ),
            'param_name' => 'gal_id',
            'description' => esc_html__( 'Start typing the title of the gallery...', 'eram' ),
            'settings' => array(
                'values' => eram_vc_get_posts('eramgallery'),
                'multiple' => false,
            ),

        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Gallery height', 'eram' ),
            'param_name'  => 'gal_height',
            'description' => __( "How you want the gallery be shown.<br><code>Default</code> is useful for vertical grid and masonry gallery layouts.<br><code>Full</code> is useful for kenburn, slider, horizontal and double carousel layouts. <br><code>Define in Pixels</code> is useful for custom layouting.", 'eram' ),
            'std'         =>'auto',
            'value'     => array(
                esc_html__('Default','eram') => 'auto',
                esc_html__('Full','eram') =>'full',
                esc_html__('Define in Pixels','eram') => 'px',
            )
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Define Height', 'eram' ),
            'param_name'  => 'gal_px_height',
            'description' => esc_html__( "The height of gallery wrapper in px (eg : 500).", 'eram' ),
            'std'         => 500,
            'dependency' => array(
                'element' => 'gal_height',
                'value' => array( 'px' ),
            ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Extra class name', 'eram' ),
            'param_name'  => 'el_class',
            'description' => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'eram' ),
        ),
    ),
) );


class WPBakeryShortCode_Eram_Single_Gallery extends WPBakeryShortCode
{
}