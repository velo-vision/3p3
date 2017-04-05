<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class eg_class
{

    protected static $instance;
    public $is_proof_mode;
    public $scrolls_vertically;
    protected $gallery_type;
    protected $gallery_layout;
    public $gallery_image_ids;
    protected $posts_per_page;
    protected $has_lightbox;
    protected $has_infinite_scroll;
    protected $has_lazy_load;
    protected $has_animation;
    public $object_id;
    protected $is_archive;
    protected $hover_style;
    protected $has_lightbox_sidebar;

    public function __construct( $object_id = NULL, $gallery_image_ids = '' )
    {

        if ( $gallery_image_ids == '' )
            return;

        if ( is_null( $object_id ) ) {
            $this->object_id = get_the_ID();
        }
        else {
            $this->object_id = $object_id;
        }

        $this->gallery_layout = eg_get_gallery_option( 'eg_gallery_layout', 'horizontal', $object_id );
        $this->has_infinite_scroll = eg_get_gallery_option( 'eg_load_type', 'lazy', $object_id ) == 'infinite' ? TRUE : FALSE;
        $this->has_lazy_load = eg_get_gallery_option( 'eg_load_type', 'lazy', $object_id ) == 'lazy' ? TRUE : FALSE;
        $this->has_lightbox = eg_get_gallery_option( 'eg_lightgallery', 'on', $object_id );
        $this->has_lightbox_sidebar = eg_get_gallery_option( 'eg_lightbox_sidebar', 'off', $object_id );

        $this->animation_type = eg_get_gallery_option( 'eg_scroll_animation', 'none', $object_id );
        $this->has_animation = $this->animation_type == 'none' ? FALSE : TRUE;

        $this->posts_per_page = eg_get_gallery_option( 'eg_infinite_chunk_count', 15, $object_id );
        $this->set_is_archive();
        $this->gallery_type = 'default';

        $this->gallery_image_ids = $gallery_image_ids;
        $this->is_proof_mode = eg_get_gallery_option( 'eg_gallery_proof_mode', FALSE, $object_id );
        $this->scrolls_vertically = FALSE;
        $this->hover_style = eg_get_gallery_option( 'eg_hover', 'hover-1', $object_id, TRUE );
    }

    public function get_gallery_wrapper_class()
    {
        $class = 'type-' . $this->gallery_type;

        return $class;
    }

    /**
     * @return string
     */
    public function get_em_gallery_class()
    {
        $class = '';
        //$class = 'em-gallery-' . $this->gallery_layout;

        // if lightbox
        if ( $this->has_lightbox )
            $class .= ' em-lightBox-gallery';

        // if infinite scroll
        if ( $this->has_infinite_scroll )
            $class .= ' em-infinite-gallery';

        return $class;
    }

    public function get_gallery_main_class()
    {
        return '';
    }

    /**
     * @return string
     */
    public function get_em_gallery_atts()
    {
        $atts = array();

        // if infinite scroll
        if ( $this->has_infinite_scroll ) {
            $atts['data-pagecount'] = $this->get_page_count();
        }
        if ( $this->object_id )
            $atts['data-postid'] = $this->object_id;

        $atts['data-lazy-mode'] = $this->has_lazy_load;

        // add advanced lightbox indicator
        if ( $this->has_lightbox_sidebar && $this->has_lightbox ) {
            $atts['data-lightbox-mode'] = 'advanced';
        }

        return http_build_query( $atts, '', ' ' );

    }

    /**
     * @return mixed
     */
    public function get_gallery_image_ids()
    {

        if ( $this->has_infinite_scroll ) {
            $paged = 0;
            if ( ! empty( $_POST['page_no'] ) ) {
                $paged = absint( $_POST['page_no'] );
            }

            $start_from = $this->posts_per_page + $this->posts_per_page * ( $paged - 1 );

            $chunk_images = array_slice( $this->gallery_image_ids, $start_from, $this->posts_per_page, TRUE );

            //ridi($chunk_images);
            return $chunk_images;
        }

        return $this->gallery_image_ids;
    }

    /**
     * @param $imgID
     */
    public function print_image_markup( $imgID, $ref_id = 0 )
    {
        echo $this->get_image_markup( $imgID, $ref_id );
    }

    /**
     * @param $imgID
     * @return string
     */
    public function get_image_markup( $imgID, $ref_id = 0 )
    {
        $img = $this->get_image( $imgID );
        $img_html = $this->get_img_html( $imgID, $img );

        $out = "<div class='{$this->get_gallery_item_class($imgID,$ref_id)}' style='{$this->get_gallery_item_style()}' {$this->get_gallery_item_atts($imgID)}>";

        if ( $this->is_archive ) {
            $out .= $this->add_archive_wrapper( $img_html, $ref_id );
        }
        else {
            if ( $this->has_lightbox ) {
                $out .= $this->add_lightbox_wrapper( $imgID, $img_html );
            }
            else {
                $out .= '<div class="gl-wrapper">';
                $out .= $img_html;
                $out .= "</div>";
            }
        }

        $out .= $this->after_item_markup( $imgID );

        $out .= "</div>";

        return $out;
    }

    /**
     * @param $imgID
     * @param $img
     * @return string
     */
    protected function get_img_html( $imgID, $img )
    {
        $img_html = "<div class='img-wrapper {$this->get_image_wrapper_class()}'>";
        $img_html .= "<img
                            class='{$this->get_img_class()}'
                            src='{$this->get_image_source($img,$imgID)}'
                            width='{$img[1]}'
                            height='{$img[2]}'
                            {$this->get_img_extra_atts($img)}>";

        $img_html .= '</div><!-- .img-wrapper-->';

        return $img_html;
    }

    /**
     * @param $imgID
     * @param $img_html
     * @return string
     */
    protected function add_lightbox_wrapper( $imgID, $img_html )
    {

        if ( $this->has_lightbox ) {

            $img = $this->get_image( $imgID, 'full' );

            // get caption
            $caption = $this->get_lightbox_image_caption( $imgID );
            $caption_attr = 'data-sub-html="#lg-caption-' . $imgID . '"';

            $o = '';

            // check if we have video
            $video_url = $this->get_video_url( $imgID );
            if ( $video_url ) {
                $o .= "<div class='gl-wrapper lightbox-item em-hover hover-1' $caption_attr data-src='{$video_url}'>";
                $o .= "<div class='em-video-icon'><span class='ol ol-play'></span></div>";
            }
            else {
                $o .= "<div class='gl-wrapper lightbox-item em-hover hover-1' $caption_attr data-src='{$img[0]}'>";
            }

            $o .= $caption;
            $o .= "<div class='hover-icon'>cdb<br>2.9 ";
            $o .= '</div><!-- .hover-icon-->';
            $o .= $img_html;
            $o .= '</div><!-- .lightbox-item-->';

            return $o;

        }


        return $img_html;

    }

    public function get_video_url( $attachment_id = 0 )
    {
        $attachement_meta = get_post_custom( $attachment_id );
        if ( ! empty( $attachement_meta['_eg_video_url'] ) ) {
            return empty( $attachement_meta['_eg_video_url'][0] ) ? FALSE : $attachement_meta['_eg_video_url'][0];
        }

        return FALSE;
    }

    /**
     * @param $img_html
     * @param int $ref_id
     * @return string
     */
    protected function add_archive_wrapper( $img_html, $ref_id = 0, $wrapper_class = '' )
    {
        if ( ! $this->is_archive )
            return $img_html;

        $href = eram_get_permalink( $ref_id );

        $o = '';
        switch ( $this->hover_style ) {
            case 'hover-2': // pf-hover-2
                $o .= "<a href=\"{$href}\" class='" . $wrapper_class . " gl-wrapper em-hover pf-hover-2'>";
                $o .= "<div class='hover-wrapper'>";
                $cats = eram_list_terms( $ref_id, ERAM_GALLERY_CATEGORY_TAX );
                if ( ! empty( $cats ) )
                    $o .= "<h4 class='subtitle'>" . $cats . "</h4>";
                $o .= "<h3 class='title'>" . get_the_title( $ref_id ) . "</h3>";
                $o .= "</div>";
                $o .= $img_html;
                $o .= '</a>';
                break;
            default: // pf-hover-1
                $o .= "<a href=\"{$href}\" class='" . $wrapper_class . " gl-wrapper em-hover pf-hover-1'>";
                $o .= "<div class='hover-wrapper'>";
                $o .= "<div class='description'>";
                $o .= "<h3 class='title'>" . get_the_title( $ref_id ) . "</h3>";
                $cats = eram_list_terms( $ref_id, ERAM_GALLERY_CATEGORY_TAX );
                if ( ! empty( $cats ) )
                    $o .= "<h4 class='subtitle'>" . $cats . "</h4>";
                $o .= "</div>";
                $o .= "</div>";
                $o .= $img_html;
                $o .= '</a>';
        }

        return $o;
    }

    /**
     * @param $imgID
     * @param string $size
     * @return array|false
     */
    protected function get_image( $imgID, $size = '' )
    {
        if ( empty($size) ) {
            $size = apply_filters( 'eram_gallery_thumbnail_size', 'eram-normal' );
        }

        if ( $imgID == '' ) {
            $img = array(
                0 => ERAM_GALLERY_IMG_DIR . '/no-image.jpg',
                1 => 1000,
                2 => 750,
                3 => TRUE
            );
        }
        else {
            $img = wp_get_attachment_image_src( $imgID, $size );
        }

        return $img;
    }

    /**
     * @return string
     */
    protected function get_gallery_item_style()
    {

        return '';
    }

    protected function get_gallery_item_atts( $imgID )
    {
        $img = $this->get_image( $imgID );

        return "data-id={$imgID} data-width={$img[1]} data-height='{$img[2]}'";

    }

    protected function get_gallery_item_class( $imgID, $ref_id = 0 )
    {
        return 'gallery-item';
    }

    protected function get_image_wrapper_class( $ref_id = 0 )
    {
        if ( $this->has_lazy_load ) {
            return 'lazy-base loading-lazy';
        }
    }

    /**
     * @return bool|string
     */
    protected function get_img_class()
    {
        if ( $this->has_lazy_load ) {
            return 'lazy';
        }

        return FALSE;
    }


    /**
     * @param $img
     * @param $imgID
     * @return mixed
     */
    protected function get_image_source( $img, $imgID )
    {
        if ( $this->has_lazy_load ) {
            // load blurry image
            $blurry_image = $this->get_image( $imgID, 'eram-lazy' );

            return $blurry_image[0];
        }
        else {
            // no need to recalculate just return the src of current image
            return $img[0];
        }
    }

    /**
     * @param $img
     * @return bool|string
     */
    protected function get_img_extra_atts( $img )
    {
        if ( $this->has_lazy_load ) {
            return " data-original='{$img[0]}'";
        }

        return FALSE;
    }

    /**
     * @return float
     */
    private function get_page_count()
    {
        return ceil( count( $this->gallery_image_ids ) / $this->posts_per_page );
    }

    public function get_before_loop()
    {
        return '';
    }


    /**
     * @param null $post_id
     * @return mixed
     */
    public static function get_instance( $post_id = NULL, $gallery_img_ids )
    {
        $called_class = get_called_class();
        self::$instance = new $called_class( $post_id, $gallery_img_ids );
        return self::$instance;
    }

    public function set_is_archive()
    {
        global $eram_gallery_page_is;

        $this->is_archive = FALSE;
        if (
            is_tax() ||
            is_post_type_archive() ||
            $eram_gallery_page_is == "is_tax" ||
            $eram_gallery_page_is == "is_archive"
        ) {
            $this->is_archive = TRUE;
        }

    }

    public function get_main_area_class()
    {
        return '';
    }

    public function print_items_loop()
    {
        $this->get_before_loop();

        foreach ( $this->get_gallery_image_ids() as $ref_id => $imgID ) {
            $this->print_image_markup( $imgID, $ref_id );
        }

        $this->get_after_loop();

    }

    public function after_item_markup( $imgID )
    {
        return '';
    }

    public function get_gallery_layout()
    {
        return $this->gallery_layout;
    }

    public function get_after_loop()
    {
        if ( $this->has_lightbox_sidebar && $this->has_lightbox ) {
            eram_echo_template_scripts();
        }
    }

    /**
     * @param $imgID
     * @return string
     */
    protected function get_lightbox_image_caption( $imgID )
    {

        $caption = '';
        $purchase_url = get_post_meta( $imgID, '_eg_purchase_url', TRUE );

        if ( eg_get_gallery_option( 'eg_lg_caption', 1, NULL, TRUE ) == 1 ) {
            $image_post = get_post( $imgID );

            $class = "";
            if ( eg_get_gallery_option( 'eg_lg_thumbnail', 1, NULL, TRUE ) == 1 ) {
                $class .= ' has-thumb-icon';
            }

            if ( ! empty( $purchase_url ) ) {
                $class .= ' has-purchase-link';
            }

            $caption .= '<div class="lightbox-caption' . $class . '">';

            if ( eg_get_gallery_option( 'eg_lg_caption_with_title', 1, NULL, TRUE ) == 1 ) {
                $caption .= "<h3>" . $image_post->post_title . "</h3>";
            }
            $caption .= $image_post->post_excerpt . '</div>';
        }


        if ( ! empty( $purchase_url ) ) {
            $caption .= '<div class="em-purchase"><a target="_blank" href="' . $purchase_url . '" class="purchase-link btn btn-circle btn-extra-small btn-skin-blue btn-anim-i"><span>' . esc_html__( 'Purchase', 'eram' ) . '<i class="ol ol-shopping_bag"></i></span></a></div>';
        }


        return '<div style="display:none;" id="lg-caption-' . $imgID . '">' . $caption . '</div>';

    }

}
