<?php
/**
 * EramGallery_Metabox class.
 *
 * @since 1.0.0
 *
 * @package Eram Gallery
 * @author  owwwlab
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class EramGallery_Metabox
{

    /**
     * Holds the class object.
     *
     * @since 1.0.0
     *
     * @var object
     */
    public static $instance;

    public function __construct()
    {
        // initialize metaboxes
        add_action( 'admin_init', array( $this, 'add_gallery_meta_boxes' ) );

        // Hide this metabox by default unless user checks frome page options
        add_filter( 'hidden_meta_boxes', array( $this,'hide_meta_box'), 10, 2 );

        // Add extra metaboxes
        add_action ( 'admin_init' , array ( $this, 'add_side_settings') );

    }

    /**
     * Hides eram_gallery_meta_box from the page
     *
     * @param $hidden
     * @param $screen
     * @return array
     */
    public function hide_meta_box($hidden, $screen)
    {
        $post_type = $screen->post_type;

        // If we're on a 'post'...
        if ( $post_type == 'eramgallery' )
        {
            // Define which meta boxes we wish to hide
            $hidden[] = 'eram_gallery_meta_box';

            // Pass our new defaults onto WordPress
            return $hidden;
        }
        // If we are not on a 'post', pass the
        // original defaults, as defined by WordPress
        return $hidden;
    }

    public function add_gallery_meta_boxes()
    {
        /**
         * Create a custom meta boxes array that we pass to
         * the OptionTree Meta Box API Class.
         */
        $settings_meta_box = array(
            'id'       => 'eram_gallery_meta_box',
            'title'    => __( 'Gallery Settings', 'eram' ),
            'desc'     => '',
            'pages'    => array( ERAM_GALLERY_CPT_NAME ),
            'context'  => 'advanced',
            'priority' => 'low',
            'fields'   => array(

                /*
                 * Include Gallery Details
                 * eg_has_details
                */
                array(
                    'label'     => __( 'Include Gallery Details', 'eram' ),
                    'id'        => 'eg_has_details',
                    'type'      => 'on-off',
                    'desc'      => __( 'Show title, excerpt and relevant details?', 'eram' ),
                    'std'       => 'off',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:not(slider),eg_gallery_layout:not(kenburn),eg_gallery_layout:not(dcarousel)',
                    'operator'  => 'and',
                ),

                /*
                 * Include Cover
                 * eg_has_cover
                */
                array(
                    'label'     => __( 'Include Gallery Cover Image', 'eram' ),
                    'id'        => 'eg_has_cover',
                    'type'      => 'on-off',
                    'desc'      => '',
                    'std'       => 'off',
                    'class'     => '',
                    'condition' => 'eg_has_details:is(on),eg_gallery_layout:not(slider),eg_gallery_layout:not(kenburn),eg_gallery_layout:not(dcarousel)',
                ),

                /*
                 * Position of details
                 * eg_details_position
                */
                array(
                    'label'     => __( 'Position of details', 'eram' ),
                    'id'        => 'eg_details_position',
                    'type'      => 'radio',
                    'std'       => 'side',
                    'class'     => '',
                    'condition' => 'eg_has_details:is(on),eg_gallery_layout:not(slider),eg_gallery_layout:not(kenburn),eg_gallery_layout:not(dcarousel)',
                    'choices'   => array(
                        array(
                            'value' => 'side',
                            'label' => __( 'Side of the page', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'top',
                            'label' => __( 'Top of the page', 'eram' ),
                            'src'   => ''
                        ),
                    )
                ),
                
                /*
                 * Gallery Photos
                 * eg_photos
                */
                array(
                    'label' => __( 'Manage Photos', 'eram' ),
                    'id'    => 'eg_photos',
                    'type'  => 'gallery',
                    'desc'  => '',
                    'std'   => '',
                    'class' => '',
                ),


                /*
                 * Gallery Type
                 * eg_gallery_layout 
                */
                array(
                    'label'     => __( 'Gallery Type', 'eram' ),
                    'id'        => 'eg_gallery_layout',
                    'type'      => 'radio-image',
                    'desc'      => '',
                    'std'       => 'simple_horizontal',
                    'class'     => '',
                    'condition' => '',
                    'choices'   => array(
                        array(
                            'value' => 'simple_horizontal',
                            'label' => __( 'Simple Horizontal', 'eram' ),
                            'src'   => ERAM_GALLERY_IMG_DIR . '/simple_horizontal.jpg'
                        ),
                        array(
                            'value' => 'simple_vertical',
                            'label' => __( 'Simple Vertical', 'eram' ),
                            'src'   => ERAM_GALLERY_IMG_DIR . '/simple_vertical.jpg'
                        ),
                        array(
                            'value' => 'h_grid',
                            'label' => __( 'Horizontal Grid', 'eram' ),
                            'src'   => ERAM_GALLERY_IMG_DIR . '/h_grid.jpg'
                        ),
                        array(
                            'value' => 'v_grid',
                            'label' => __( 'Vertical Grid', 'eram' ),
                            'src'   => ERAM_GALLERY_IMG_DIR . '/v_grid.jpg'
                        ),
                        array(
                            'value' => 'h_masonry',
                            'label' => __( 'Horizontal Masonry', 'eram' ),
                            'src'   => ERAM_GALLERY_IMG_DIR . '/h_masonry.jpg'
                        ),
                        array(
                            'value' => 'v_masonry',
                            'label' => __( 'Vertical Masonry', 'eram' ),
                            'src'   => ERAM_GALLERY_IMG_DIR . '/v_masonry.jpg'
                        ),
                        array(
                            'value' => 'justified',
                            'label' => __( 'Justified', 'eram' ),
                            'src'   => ERAM_GALLERY_IMG_DIR . '/justified.jpg'
                        ),
                        array(
                            'value' => 'slider',
                            'label' => __( 'Slider', 'eram' ),
                            'src'   => ERAM_GALLERY_IMG_DIR . '/slider.jpg'
                        ),
                        array(
                            'value' => 'kenburn',
                            'label' => __( 'Ken-Burns Effect', 'eram' ),
                            'src'   => ERAM_GALLERY_IMG_DIR . '/kenburn.jpg'
                        ),
                        array(
                            'value' => 'dcarousel',
                            'label' => __( 'Doubel Carousel', 'eram' ),
                            'src'   => ERAM_GALLERY_IMG_DIR . '/dcarousel.jpg'
                        )
                    )
                ),




                /*
                 * Justified Gallery settings
                 * eg_gallery_layout:is(justified)
                */
                array(
                    'label'        => __( 'Heigh of each row', 'eram' ),
                    'id'           => 'eg_jg_rowheight',
                    'type'         => 'numeric-slider',
                    'desc'         => __( 'The preferred height of rows in pixel.<br>Default is 250px', 'eram' ),
                    'std'          => '250',
                    'class'        => '',
                    'condition'    => 'eg_gallery_layout:is(justified))',
                    'operator'     => 'and',
                    'min_max_step' => '150,400,50',
                ),

                /*
                 * Horizontal scroll settings
                 * eg_gallery_layout:is(horizontal)
                */

                array(
                    'label'     => __( 'Image Width', 'eram' ),
                    'id'        => 'eg_hs_width',
                    'type'      => 'radio',
                    'desc'      => __( 'If you want to show only a slice of your images, you should set this to <strong>Fixed Size</strong><br/>To show normal images leave this to <strong>auto</strong>.', 'eram' ),
                    'std'       => 'auto',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:is(simple_horizontal)',
                    'choices'   => array(
                        array(
                            'value' => 'auto',
                            'label' => __( 'Auto', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'fixed',
                            'label' => __( 'Fixed size', 'eram' ),
                            'src'   => ''
                        ),
                    )
                ),
                array(
                    'label'        => __( 'Width of images (px)', 'eram' ),
                    'id'           => 'eg_hs_image_width',
                    'type'         => 'numeric-slider',
                    'desc'         => __( 'This is the width of images in <strong>pixels</strong>. Please note that the height of images are handled based on the height of the device.', 'eram' ),
                    'std'          => '400',
                    'class'        => '',
                    'condition'    => 'eg_gallery_layout:is(simple_horizontal),eg_hs_width:is(fixed)',
                    'operator'     => 'and',
                    'min_max_step' => '200,800,50',
                ),

                /*
                 * Vertical scroll settings
                 * eg_gallery_layout:is(simple_vertical)
                */

                array(
                    'label'     => __( 'Image Height', 'eram' ),
                    'id'        => 'eg_vs_height',
                    'type'      => 'radio',
                    'desc'      => __( 'If you want to show only a slice of your images, you should set this to <strong>Fixed Size</strong><br/>To show normal images leave this to <strong>auto</strong>.', 'eram' ),
                    'std'       => 'fixed',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:is(simple_vertical)',
                    'choices'   => array(
                        array(
                            'value' => 'auto',
                            'label' => __( 'Auto', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'fixed',
                            'label' => __( 'Fixed size', 'eram' ),
                            'src'   => ''
                        ),
                    )
                ),
                array(
                    'label'        => __( 'Height of images (px)', 'eram' ),
                    'id'           => 'eg_vs_image_height',
                    'type'         => 'numeric-slider',
                    'desc'         => __( 'This is the height of images in <strong>pixels</strong>. Please note that the width of images are handled based on the width of the device.', 'eram' ),
                    'std'          => '300',
                    'class'        => '',
                    'condition'    => 'eg_gallery_layout:is(simple_vertical),eg_vs_height:is(fixed)',
                    'operator'     => 'and',
                    'min_max_step' => '200,800,50',
                ),

                /*
                 * Horizontal Grid settings
                 * eg_gallery_layout:is(grid)
                */

                array(
                    'label'        => __( 'Number of Rows', 'eram' ),
                    'id'           => 'eg_grid_rows',
                    'type'         => 'numeric-slider',
                    'desc'         => '',
                    'std'          => '3',
                    'class'        => '',
                    'condition'    => 'eg_gallery_layout:is(h_grid)',
                    'operator'     => 'and',
                    'min_max_step' => '2,4,1',
                ),
                array(
                    'label'        => __( 'Number of Columns', 'eram' ),
                    'id'           => 'eg_grid_cols',
                    'type'         => 'numeric-slider',
                    'desc'         => '',
                    'std'          => '3',
                    'class'        => '',
                    'condition'    => 'eg_gallery_layout:is(v_grid)',
                    'operator'     => 'and',
                    'min_max_step' => '2,4,1',
                ),
                array(
                    'label'     => __( 'Grid Thumbnails type', 'eram' ),
                    'id'        => 'eg_grid_thumb_ratio',
                    'type'      => 'radio-image',
                    'desc'      => '',
                    'std'       => 'square',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:contains(_grid)',
                    'operator'  => 'and',
                    'choices'   => array(
                        array(
                            'value' => 'square',
                            'label' => __( 'Square', 'eram' ),
                            'src'   => ERAM_GALLERY_IMG_DIR . '/grid-square.jpg'
                        ),
                        array(
                            'value' => 'landscape',
                            'label' => __( 'Landscape', 'eram' ),
                            'src'   => ERAM_GALLERY_IMG_DIR . '/grid-landscape.jpg'
                        ),
                        array(
                            'value' => 'portrait',
                            'label' => __( 'Portrait', 'eram' ),
                            'src'   => ERAM_GALLERY_IMG_DIR . '/grid-portrait.jpg'
                        ),
                    )
                ),


                /*
                 * Horizontal scroll settings
                */

                array(
                    'label'        => __( 'Number of Rows', 'eram' ),
                    'id'           => 'eg_masonry_rows',
                    'type'         => 'numeric-slider',
                    'desc'         => '',
                    'std'          => '3',
                    'class'        => '',
                    'condition'    => 'eg_gallery_layout:is(h_masonry)',
                    'operator'     => 'and',
                    'min_max_step' => '2,4,1',
                ),
                array(
                    'label'        => __( 'Number of Columns', 'eram' ),
                    'id'           => 'eg_masonry_cols',
                    'type'         => 'numeric-slider',
                    'desc'         => '',
                    'std'          => '3',
                    'class'        => '',
                    'condition'    => 'eg_gallery_layout:is(v_masonry)',
                    'operator'     => 'and',
                    'min_max_step' => '2,4,1',
                ),


                /*
                 * Slider settings
                 * eg_gallery_layout:is(slider)
                */
                array(
                    'label'     => __( 'Images Fill Mode', 'eram' ),
                    'id'        => 'eg_fullscreen_fill_mode',
                    'type'      => 'radio',
                    'desc'      => 'Choose fit mode to diplay the images in their original ratio and fill to cover the entire screen',
                    'std'       => 'fill',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:is(slider)',
                    'operator'  => 'and',
                    'choices'   => array(
                        array(
                            'value' => 'fill',
                            'label' => __( 'Fill', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'fit',
                            'label' => __( 'Fit', 'eram' ),
                            'src'   => ''
                        )
                    )
                ),
                 array(
                    'label'        => __( 'Space around the frame', 'eram' ),
                    'id'           => 'eg_fullscreen_fit_padding',
                    'type'         => 'numeric-slider',
                    'desc'         => __( 'Value is in pixels and default is 20px', 'eram' ),
                    'std'          => 20,
                    'class'        => '',
                    'condition'    => 'eg_gallery_layout:is(slider),eg_fullscreen_fill_mode:is(fit)',
                    'operator'     => 'and',
                    'min_max_step' => '0,100,1',
                ),
                array(
                    'label'     => __( 'Include Thumbnails', 'eram' ),
                    'id'        => 'eg_fullscreen_thumbs',
                    'type'      => 'on-off',
                    'desc'      => '',
                    'std'       => 'on',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:is(slider)',
                    'operator'  => 'and',
                ),
                array(
                    'label'     => __( 'Include Counter', 'eram' ),
                    'id'        => 'eg_fullscreen_counter',
                    'type'      => 'on-off',
                    'desc'      => '',
                    'std'       => 'on',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:is(slider)',
                    'operator'  => 'and',
                ),
                array(
                    'label'     => __( 'Direction', 'eram' ),
                    'id'        => 'eg_fullscreen_direction',
                    'type'      => 'radio',
                    'desc'      => '',
                    'std'       => 'h',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:is(slider)',
                    'operator'  => 'and',
                    'choices'   => array(
                        array(
                            'value' => 'h',
                            'label' => __( 'Horizontal', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'v',
                            'label' => __( 'Vertical', 'eram' ),
                            'src'   => ''
                        )
                    )
                ),
                array(
                    'label'     => __( 'Auto Play', 'eram' ),
                    'id'        => 'eg_fullscreen_autoplay',
                    'type'      => 'on-off',
                    'desc'      => '',
                    'std'       => 'on',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:is(slider)',
                    'operator'  => 'and',
                ),
                array(
                    'label'     => __( 'Show timer bar', 'eram' ),
                    'id'        => 'eg_fullscreen_timer',
                    'type'      => 'on-off',
                    'desc'      => '',
                    'std'       => 'off',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:is(slider),eg_fullscreen_autoplay:is(on)',
                    'operator'  => 'and',
                ),
                array(
                    'label'     => __( 'Transition Effect', 'eram' ),
                    'id'        => 'eg_fullscreen_fx',
                    'type'      => 'select',
                    'desc'      => '',
                    'std'       => 'fade',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:is(slider)',
                    'operator'  => 'and',
                    'choices'   => array(
                        array(
                            'value' => 'basic',
                            'label' => __( 'Basic', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'fade',
                            'label' => __( 'Fade', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'mask',
                            'label' => __( 'Mask', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'wave',
                            'label' => __( 'Wave', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'flow',
                            'label' => __( 'Flow', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'stack',
                            'label' => __( 'Stack', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'scale',
                            'label' => __( 'Scale', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'focus',
                            'label' => __( 'Focus', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'parallaxMask',
                            'label' => __( 'Parallax Mask', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'partialWave',
                            'label' => __( 'Partial Wave', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'fadeBasic',
                            'label' => __( 'Fade Basic', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'fadeWave',
                            'label' => __( 'Fade Wave', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'fadeFlow',
                            'label' => __( 'Fade Flow', 'eram' ),
                            'src'   => ''
                        ),

                    )
                ),


                /*
                 * kenburn settings
                 * eg_gallery_layout:is(kenburn)
                */
                array(
                    'label'     => __( 'Show Image Captions', 'eram' ),
                    'id'        => 'eg_kb_caption',
                    'type'      => 'on-off',
                    'desc'      => '',
                    'std'       => 'off',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:is(kenburn)',
                    'operator'  => 'and',
                ),
                array(
                    'label'     => __( 'Show Dotted Overlay', 'eram' ),
                    'id'        => 'eg_kb_overlay',
                    'type'      => 'on-off',
                    'desc'      => '',
                    'std'       => 'on',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:is(kenburn)',
                    'operator'  => 'and',
                ),
                array(
                    'label'        => __( 'Transition Duration', 'eram' ),
                    'id'           => 'eg_kb_duration',
                    'type'         => 'numeric-slider',
                    'desc'         => '',
                    'std'          => '7',
                    'class'        => '',
                    'condition'    => 'eg_gallery_layout:is(kenburn)',
                    'operator'     => 'and',
                    'min_max_step' => '5,15,1',
                ),
                array(
                    'label'        => __( 'Zoom', 'eram' ),
                    'id'           => 'eg_kb_zoom',
                    'type'         => 'numeric-slider',
                    'desc'         => '',
                    'std'          => '1.05',
                    'class'        => '',
                    'condition'    => 'eg_gallery_layout:is(kenburn)',
                    'operator'     => 'and',
                    'min_max_step' => '1.05,1.4,0.05',
                ),

                /*
                 * dcarousel
                 * eg_gallery_layout:is(dcarousel)
                */
                array(
                    'label'        => __( 'Transition Duration', 'eram' ),
                    'id'           => 'eg_dc_duration',
                    'type'         => 'numeric-slider',
                    'desc'         => '',
                    'std'          => 1,
                    'class'        => '',
                    'condition'    => 'eg_gallery_layout:is(dcarousel)',
                    'operator'     => 'and',
                    'min_max_step' => '0.5,3,0.1',
                ),
                array(
                    'label'     => __( 'Auto Play', 'eram' ),
                    'id'        => 'eg_dc_autoplay',
                    'type'      => 'on-off',
                    'desc'      => '',
                    'std'       => 'on',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:is(dcarousel)',
                    'operator'  => 'and',
                ),
                array(
                    'label'     => __( 'Pagination Links', 'eram' ),
                    'id'        => 'eg_dc_show_bullets',
                    'type'      => 'on-off',
                    'desc'      => '',
                    'std'       => 'on',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:is(dcarousel)',
                    'operator'  => 'and',
                ),
                array(
                    'label'     => __( 'Next/Prev Links', 'eram' ),
                    'id'        => 'eg_dc_show_next_prev',
                    'type'      => 'on-off',
                    'desc'      => '',
                    'std'       => 'on',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:is(dcarousel)',
                    'operator'  => 'and',
                ),
                array(
                    'label'     => __( 'Image Captions', 'eram' ),
                    'id'        => 'eg_dc_show_captions',
                    'type'      => 'on-off',
                    'desc'      => '',
                    'std'       => 'on',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:is(dcarousel)',
                    'operator'  => 'and',
                ),


                /*
                 * Items Spacing
                 * eg_items_spacing
                */
                array(
                    'label'        => __( 'Items Spacing', 'eram' ),
                    'id'           => 'eg_items_spacing',
                    'type'         => 'numeric-slider',
                    'desc'         => __( 'Define the desired gutter width (spacing between items in the gallery). Value is in pixels and default is 15px', 'eram' ),
                    'std'          => 15,
                    'class'        => '',
                    'condition'    => 'eg_gallery_layout:not(slider),eg_gallery_layout:not(kenburn)',
                    'operator'     => 'and',
                    'min_max_step' => '0,70,1',
                ),

                /*
                 * general
                */
                array(
                    'label'     => __( 'Enable Social Sharing Icons', 'eram' ),
                    'id'        => 'eg_social_share',
                    'type'      => 'on-off',
                    'desc'      => '',
                    'std'       => 'off',
                ),

                array(
                    'label'     => __( 'Enable LightBox Gallery On Click', 'eram' ),
                    'id'        => 'eg_lightgallery',
                    'type'      => 'on-off',
                    'desc'      => '',
                    'std'       => 'on',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:not(kenburn),eg_gallery_layout:not(slider)',
                    'operator'  => 'and',
                ),

                array(
                    'label'     => __( 'Show Lightbox Sidebar', 'eram' ),
                    'id'        => 'eg_lightbox_sidebar',
                    'type'      => 'on-off',
                    'desc'      => __('Displays a sidebar at lightbox.'),
                    'std'       => 'off',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:not(kenburn),eg_gallery_layout:not(slider),eg_lightgallery:is(on)',
                    'operator'  => 'and',
                ),

                array(
                    'label'     => __( 'Animation', 'eram' ),
                    'id'        => 'eg_scroll_animation',
                    'type'      => 'radio',
                    'desc'      => '',
                    'std'       => 'fadein',
                    'choices'   => array(
                        array(
                            'value' => 'none',
                            'label' => __( 'None', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'fadein',
                            'label' => __( 'Fade In', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'slidefade',
                            'label' => __( 'Slide Fade In', 'eram' ),
                            'src'   => ''
                        ),
                    ),
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:not(kenburn),eg_gallery_layout:not(slider),eg_gallery_layout:not(dcarousel)',
                    'operator'  => 'and',
                ),


                array(
                    'label'     => __( 'Page Load Enhancement', 'eram' ),
                    'id'        => 'eg_load_type',
                    'type'      => 'radio',
                    'desc'      => '',
                    'std'       => 'lazy',
                    'class'     => '',
                    'condition' => 'eg_gallery_layout:not(kenburn),eg_gallery_layout:not(slider),eg_gallery_layout:not(dcarousel)',
                    'operator'  => 'and',
                    'choices'   => array(
                        array(
                            'value' => 'lazy',
                            'label' => __( 'Lazy load Images', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'infinite',
                            'label' => __( 'Infinit Scroll - Adds a chunk of images when user reaches the end of page', 'eram' ),
                            'src'   => ''
                        ),
                        array(
                            'value' => 'none',
                            'label' => __( 'None - Loads all images at once', 'eram' ),
                            'src'   => ''
                        ),
                    )
                ),
                array(
                    'label'        => __( 'Image Chunk Count', 'eram' ),
                    'id'           => 'eg_infinite_chunk_count',
                    'type'         => 'numeric-slider',
                    'desc'         => '',
                    'std'          => '15',
                    'class'        => '',
                    'condition'    => 'eg_load_type:is(infinite),eg_gallery_layout:not(kenburn),eg_gallery_layout:not(slider),eg_gallery_layout:not(dcarousel)',
                    'operator'     => 'and',
                    'min_max_step' => '5,50,2',
                ),


            )
        );

        /**
         * Register our meta boxes using the
         * ot_register_meta_box() function.
         */
        if ( function_exists( 'ot_register_meta_box' ) )
            ot_register_meta_box( $settings_meta_box );
    }


    public function add_side_settings()
    {
        /**
         * Create a custom meta boxes array that we pass to
         * the OptionTree Meta Box API Class.
         */
        $settings_meta_box = array(
            'id'       => 'eram_gallery_side_meta_box',
            'title'    => __( 'Gallery Options', 'eram' ),
            'desc'     => '',
            'pages'    => array( ERAM_GALLERY_CPT_NAME ),
            'context'  => 'side',
            'priority' => 'high',
            'fields'   => array(

                // _eg_exclude_from_loop
                array(
                    'id'          => '_eg_exclude_from_loop_text',
                    'label'       => __( 'Hide from lists', 'eram' ),
                    'desc'      => __( "Hide this gallery from lists, If turned on, this gallery will be hidden from public lists but can be accessed directly by URL.", 'eram' ),
                    'std'         => '',
                    'type'        => 'textblock',
                ),
                array(
                    'label'     => '',
                    'id'        => '_eg_exclude_from_loop',
                    'type'      => 'on-off',
                    'std'       => 'off',
                    'class'     => '',
                    'condition' => '',
                ),

                // _eg_redirect
                array(
                    'id'          => '_eg_redirect_text',
                    'desc'        => __( 'Specify the URL which you want to open when a visitor clicks on the gallery link. Leave blank to dismiss. ', 'eram' ),
                    'std'         => '',
                    'type'        => 'textblock',
                ),
                array(
                    'id'          => '_eg_redirect',
                    'std'         => '',
                    'type'        => 'text',
                ),
            )
        );

        /**
         * Register our meta boxes using the
         * ot_register_meta_box() function.
         */
        if ( function_exists( 'ot_register_meta_box' ) )
            ot_register_meta_box( $settings_meta_box );
    }


    /**
     * Returns the singleton instance of the class.
     *
     * @since 1.0.0
     *
     * @return object The EramGallery_Metabox object.
     */
    public static function get_instance()
    {

        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;

    }
}

// Load the metaboxes class.
$eramGallery_metabox = EramGallery_Metabox::get_instance();
