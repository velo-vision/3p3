<?php
/**
 *  adds required metaboxes using optiontree
 *
 * @package Eram
 * @author owwwlab
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Initialize the custom Meta Boxes.
 */
add_action( 'admin_init', 'eram_page_meta_boxes' );


if ( ! function_exists( 'eram_page_meta_boxes' ) ) {

    function eram_page_meta_boxes()
    {
        $page_metabox_fields = array(
            array(
                'label' => esc_html__( 'Page Layout', 'eram' ),
                'id'    => '_ep_layout',
                'type'  => 'radio-image',
                'std'   => 'default',
                'class' => '',
                'choices'     => array( 
                    array(
                        'value'       => 'default',
                        'label'       => esc_html__( 'Default', 'eram' ),
                        'src'         => ERAM_IMAGES . '/page-default.jpg',
                    ),
                    array(
                        'value'       => 'header-top',
                        'label'       => esc_html__( 'Top Header', 'eram' ),
                        'src'         => ERAM_IMAGES . '/page-header-top.jpg',
                    ),
                    array(
                        'value'       => 'header-side',
                        'label'       => esc_html__( 'Side Image', 'eram' ),
                        'src'         => ERAM_IMAGES . '/page-header-side.jpg',
                    ),
                    array(
                        'value'       => 'blank',
                        'label'       => esc_html__( 'Blank Page', 'eram' ),
                        'src'         => ERAM_IMAGES . '/page-blank.jpg',
                    ),
                )
            ),
            array(
                'label' => esc_html__( 'Show Page Title', 'eram' ),
                'id'    => '_ep_title',
                'type'  => 'on-off',
                'desc'  => sprintf( esc_html__( 'Shows the page title when set to %s. If you wan to build the page title using Visual composer you can turn it off.', 'eram' ), '<code>on</code>' ),
                'std'   => 'on',
                'class' => '',
                'condition' => '_ep_layout:is(default)'
            ),
            array(
                'label' => esc_html__( 'Cover Type', 'eram' ),
                'id'    => '_ep_cover_type',
                'type'  => 'radio',
                'desc'  => esc_html__( 'Choose type of cover.', 'eram' ),
                'std'   => 'image',
                'class' => '',
                'condition'    => '_ep_layout:not(default),_ep_layout:not(blank)',
                'operator'     => 'and',
                'choices'     => array( 
                    array(
                        'value'       => 'image',
                        'label'       => esc_html__( 'Image', 'eram' ),
                        'src'         => ''
                    ),
                    array(
                        'value'       => 'video',
                        'label'       => esc_html__( 'Video', 'eram' ),
                        'src'         => ''
                    ),
                    array(
                        'value'       => 'google-map',
                        'label'       => esc_html__( 'Google Map', 'eram' ),
                        'src'         => ''
                    ),
                )
            ),
            array(
                'label' => esc_html__( 'Video MP4', 'eram' ),
                'id'    => '_ep_cover_video',
                'type'  => 'upload',
                'desc'  => esc_html__( 'Upload and use a short video as cover.', 'eram' ),
                'std'   => '',
                'class' => 'ot-upload-attachment-id',
                'condition'    => '_ep_layout:not(default),_ep_cover_type:is(video),_ep_layout:not(blank)',
                'operator'     => 'and',
            ),
            array(
                'label' => esc_html__( 'Cover Image', 'eram' ),
                'id'    => '_ep_cover_image',
                'type'  => 'upload',
                'desc'  => esc_html__( 'Background image of the header', 'eram' ),
                'std'   => '',
                'class' => 'ot-upload-attachment-id',
                'condition'    => '_ep_layout:not(default),_ep_cover_type:not(google-map),_ep_layout:not(blank)',
                'operator'     => 'and',
            ),
            array(
                'label'        => esc_html__( 'Short Description below title', 'eram' ),
                'id'           => '_ep_description',
                'type'         => 'textarea-simple',
                'desc'         => esc_html__( 'Use this to briefly summarize your page.', 'eram' ),
                'condition'    => '_ep_layout:is(header-top),_ep_layout:is(header-side)',
                'operator'     => 'or',
                'std'          => '',
                'rows'         => 4
            ),
            array(
                'label' => esc_html__( 'Address', 'eram' ),
                'id'    => '_ep_map_address',
                'type'  => 'text',
                'desc'  => esc_html__( 'Your address', 'eram' ),
                'std'   => '500 17th St NW Washington, DC',
                'class' => '',
                'condition' => '_ep_cover_type:is(google-map),_ep_layout:contains(header-)'
            ),
            array(
                'label'        => esc_html__( 'Map Initial Zoom', 'eram' ),
                'id'           => '_ep_map_initial_zoom',
                'type'         => 'numeric-slider',
                'min_max_step' => '1,20,1',
                'desc'         => esc_html__( 'Choose the initial zoom of the map', 'eram' ),
                'condition'    => '_ep_cover_type:is(google-map),_ep_layout:contains(header-)',
                'operator'     => 'and',
                'std'          => '10'
            ),
            array(
                'label'        => esc_html__( 'Map Maximum Zoom', 'eram' ),
                'id'           => '_ep_map_max_zoom',
                'type'         => 'numeric-slider',
                'min_max_step' => '1,20,1',
                'desc'         => esc_html__( 'Choose the maximum zoom of the map', 'eram' ),
                'condition'    => '_ep_cover_type:is(google-map),_ep_layout:contains(header-)',
                'operator'     => 'and',
                'std'          => '15'
            ),
            array(
                'label' => esc_html__( 'Customize Page Header', 'eram' ),
                'id'    => '_ep_header_custom',
                'type'  => 'on-off',
                'condition' => '_ep_layout:not(blank),_ep_layout:not(default)',
                'desc'  => esc_html__( 'You can define the Page Header setting at the theme customizer, if you want to customize it for this page you can turn it on.', 'eram' ),
                'condition' => '_ep_layout:not(blank),_ep_layout:not(default)',
                'operator'     => 'and',
                'std'   => 'off',
                'class' => '',
            ),
            array(
                'label' => esc_html__( 'Page Header Overlay', 'eram' ),
                'id'    => '_ep_header_overlay',
                'type'  => 'on-off',
                'condition' => '_ep_layout:not(blank),_ep_layout:not(default),_ep_header_custom:is(on)',
                'operator'     => 'and',
                'desc'  => esc_html__( 'Add colored overlay to the page header', 'eram' ),
                'std'   => 'on',
                'class' => '',
            ),
            array(
                'label' => esc_html__( 'Page Header Overlay Color', 'eram' ),
                'id'    => '_ep_header_overlay_color',
                'type'  => 'colorpicker-opacity',
                'condition' => '_ep_layout:not(blank),_ep_layout:not(default),_ep_header_overlay:is(on),_ep_header_custom:is(on)',
                'desc'  => esc_html__( 'Color of the overlay', 'eram' ),
                'operator'     => 'and',
                'std'   => 'rgba(0,0,0,0.5)',
                'class' => '',
            ),
            array(
                'label' => esc_html__( 'Page Header Content Color', 'eram' ),
                'id'    => '_ep_header_content_color',
                'type'  => 'colorpicker',
                'condition' => '_ep_layout:not(blank),_ep_layout:not(default),_ep_header_overlay:is(on),_ep_header_custom:is(on)',
                'desc'  => esc_html__( 'Color of the header contents', 'eram' ),
                'operator'     => 'and',
                'std'   => '#fff',
                'class' => '',
            ),
            array(
                'label' => esc_html__( 'Show Page Footer', 'eram' ),
                'id'    => '_ep_footer',
                'type'  => 'on-off',
                'condition' => '_ep_layout:not(blank)',
                'desc'  => sprintf( esc_html__( 'Shows the page footer when set to %s.', 'eram' ), '<code>on</code>' ),
                'std'   => 'on',
                'class' => '',
            ),
           
            array(
                'label'        => esc_html__( 'Content Type', 'eram' ),
                'id'           => '_ep_content_type',
                'type'         => 'radio',
                'desc'         => esc_html__( 'How you want to contain the content?', 'eram' ),
                'condition'    => '_ep_layout:is(default),_ep_layout:is(header-top)',
                'operator'     => 'or',
                'std'          => 'container',
                'choices'     => array( 
                    array(
                        'value'       => 'container',
                        'label'       => esc_html__( 'Normal Container', 'eram' ),
                        'src'         => ''
                    ),
                    array(
                        'value'       => 'slim-container',
                        'label'       => esc_html__( 'Slim Container', 'eram' ),
                        'src'         => ''
                    ),
                )
            ),
        );

        // Add option for transparent classic header if needed
        $site_layout = eram_get_site_layout();
        if ( $site_layout == 'classic')
        {
            $header_option = array(
                'label' => esc_html__( 'Transparent Header', 'eram' ),
                'id'    => '_ep_transparent_header',
                'type'  => 'on-off',
                'condition' => '_ep_layout:is(blank),_ep_layout:is(header-top)',
                'operator'  => 'or',
                'desc'  => sprintf( esc_html__( 'Makes the header transparent when set to %s.', 'eram' ), '<code>on</code>' ),
                'std'   => 'off',
                'class' => '',
            );
            array_push($page_metabox_fields,$header_option);
        }
        
        /**
         * Create a custom meta boxes array that we pass to
         * the OptionTree Meta Box API Class.
         */
        $my_meta_box = array(
            'id'       => 'eram_page_meta_box',
            'title'    => esc_html__( 'Page Settings', 'eram' ),
            'desc'     => '',
            'pages'    => array( 'page' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields'   => $page_metabox_fields
        );

        /**
         * Register our meta boxes using the
         * ot_register_meta_box() function.
         */
        if ( function_exists( 'ot_register_meta_box' ) )
            ot_register_meta_box( $my_meta_box );
        

        $post_meta_box = array(
            'id'       => 'eram_post_meta_box',
            'title'    => esc_html__( 'Format Settings', 'eram' ),
            'desc'     => '',
            'pages'    => array( 'post' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields'   => array(
                array(
                    'id'          => 'eram_ps_format',
                    'label'       => esc_html__( 'Post Format', 'eram' ),
                    //'desc'        => esc_html__( '','eram' ),
                    'std'         => 'standard',
                    'type'        => 'radio',
                    'condition'   => '',
                    'operator'    => 'and',
                    'choices'     => array(
                        array(
                            'value'       => 'standard',
                            'label'       => esc_html__( 'Standard', 'eram' ),
                            'src'         => ''
                        ),
                        array(
                            'value'       => 'aside',
                            'label'       => esc_html__( 'Aside', 'eram' ),
                            'src'         => ''
                        ),
                        array(
                            'value'       => 'embed-video',
                            'label'       => esc_html__( 'Embeded Video', 'eram' ),
                            'src'         => ''
                        ),
                        array(
                            'value'       => 'embed-audio',
                            'label'       => esc_html__( 'Embeded Audio', 'eram' ),
                            'src'         => ''
                        ),
                        array(
                            'value'       => 'quote',
                            'label'       => esc_html__( 'Quote', 'eram' ),
                            'src'         => ''
                        ),
                        array(
                            'value'       => 'link',
                            'label'       => esc_html__( 'Link', 'eram' ),
                            'src'         => ''
                        ),
                        array(
                            'value'       => 'gallery',
                            'label'       => esc_html__( 'Gallery', 'eram' ),
                            'src'         => ''
                        ),
                        array(
                            'value'       => 'status',
                            'label'       => esc_html__( 'Status', 'eram' ),
                            'src'         => ''
                        ),
                        array(
                            'value'       => 'audio',
                            'label'       => esc_html__( 'Audio File', 'eram' ),
                            'src'         => ''
                        ),
                    )
                ),
                
                array(
                    'id'          => 'eram_ps_embed_video',
                    'label'       => esc_html__( 'Video Url', 'eram' ),
                    'desc'        => sprintf(__( 'Input a video or audio link from of supported medias by wordpress. %s ','eram' ),'<a href="https://codex.wordpress.org/Embeds">'.__('Supported medias','eram').'</a>'),
                    'std'         => '',
                    'type'        => 'text',
                    'condition'   => 'eram_ps_format:is(embed-video)',
                    'operator'    => 'and',
                ),

                array(
                    'id'          => 'eram_ps_embed_audio',
                    'label'       => esc_html__( 'Audio Url', 'eram' ),
                    'desc'        => sprintf(__( 'Input a video or audio link from of supported medias by wordpress. %s ','eram' ),'<a href="https://codex.wordpress.org/Embeds">'.__('Supported medias','eram').'</a>'),
                    'std'         => '',
                    'type'        => 'text',
                    'condition'   => 'eram_ps_format:is(embed-audio)',
                    'operator'    => 'and',
                ),

                array(
                    'id'          => 'eram_ps_quote_text',
                    'label'       => esc_html__( 'Quote text', 'eram' ),
                    'desc'        => esc_html__( 'Quoted sentence','eram' ),
                    'std'         => '',
                    'type'        => 'textarea-simple',
                    'condition'   => 'eram_ps_format:is(quote)',
                    'operator'    => 'and',
                ),

                array(
                    'id'          => 'eram_ps_quote_author',
                    'label'       => esc_html__( 'Who Said That?', 'eram' ),
                    'desc'        => esc_html__( 'The name of the person you are quoting from ','eram' ),
                    'std'         => '',
                    'type'        => 'text',
                    'condition'   => 'eram_ps_format:is(quote)',
                    'operator'    => 'and',
                ),

                array(
                    'id'          => 'eram_ps_link',
                    'label'       => esc_html__( 'Link', 'eram' ),
                    'desc'        => esc_html__( 'Url that you are referring to ','eram' ),
                    'std'         => '',
                    'type'        => 'text',
                    'condition'   => 'eram_ps_format:is(link)',
                    'operator'    => 'and',
                ),

                array(
                    'id'          => 'eram_ps_gallery',
                    'label'       => esc_html__( 'Images', 'eram' ),
                    'std'         => '',
                    'type'        => 'gallery',
                    'condition'   => 'eram_ps_format:is(gallery)',
                    'operator'    => 'and',
                ),

                array(
                    'id'          => 'eram_ps_status',
                    'label'       => esc_html__( 'Twitter Status', 'eram' ),
                    'std'         => '',
                    'desc'        => esc_html__( 'Get embed code from status of your twitter','eram' ),
                    'type'        => 'textarea-simple',
                    'condition'   => 'eram_ps_format:is(status)',
                    'operator'    => 'and',
                ),

                array(
                    'id'          => 'eram_ps_audio_mp3',
                    'label'       => esc_html__( 'MP3 File', 'eram' ),
                    'desc'        => esc_html__( 'Url of the .mp3 file','eram' ),
                    'std'         => '',
                    'type'        => 'upload',
                    'condition'   => 'eram_ps_format:is(audio)',
                    'operator'    => 'and',
                ),

                array(
                    'id'          => 'eram_ps_audio_ogg',
                    'label'       => esc_html__( 'OGG File', 'eram' ),
                    'desc'        => esc_html__( 'Url of the .ogg file. You can leave this blank.','eram' ),
                    'std'         => '',
                    'type'        => 'upload',
                    'condition'   => 'eram_ps_format:is(audio)',
                    'operator'    => 'and',
                ),


            )
        );

        if ( function_exists( 'ot_register_meta_box' ) )
            ot_register_meta_box( $post_meta_box );



    }

}


if ( ! function_exists( "eram_change_optiontree_upload_text" ) ) {
    function eram_change_optiontree_upload_text( $example )
    {
        // Maybe modify $example in some way.
        return esc_html__( 'Set Image', 'eram' );
    }
}
add_filter( 'ot_upload_text', 'eram_change_optiontree_upload_text' );



/**
 * Add new fields into 'Contact Info' section.
 *
 * @param  array $fields Existing fields array.
 * @return array
 */
function eram_additional_contact_methods( $fields ) {

    $fields['_eram_twitter'] 	= esc_html__( 'Twitter', 'eram' );
    $fields['_eram_facebook']	= esc_html__( 'Facebook', 'eram' );
    $fields['_eram_google-plus'] = esc_html__( 'Google +', 'eram' );
    $fields['_eram_instagram'] = esc_html__( 'Instagram', 'eram' );
    $fields['_eram_500px'] = esc_html__( '500px', 'eram' );
    $fields['_eram_pinterest'] = esc_html__( 'Pinterest', 'eram' );

    return $fields;
}

add_filter( 'user_contactmethods', 'eram_additional_contact_methods' );

