<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class eg_slider_class extends eg_class
{
    protected $fill_mode;
    protected $has_thumbs;
    protected $direction;
    protected $has_counter;
    protected $has_autoplay;
    protected $has_timer;
    protected $fx;
    protected $fit_padding;

    public function __construct($object_id=null, $gallery_image_ids='')
    {
        parent::__construct($object_id, $gallery_image_ids);

        $this->fill_mode= eg_get_gallery_option( 'eg_fullscreen_fill_mode','fill', $object_id);
        $this->has_thumbs = eg_get_gallery_option( 'eg_fullscreen_thumbs','on', $object_id);
        $this->direction = eg_get_gallery_option('eg_fullscreen_direction','h', $object_id);
        $this->has_counter = eg_get_gallery_option( 'eg_fullscreen_counter','on', $object_id);
        $this->has_autoplay = eg_get_gallery_option( 'eg_fullscreen_autoplay','on', $object_id) ;
        $this->has_timer = eg_get_gallery_option( 'eg_fullscreen_timer','off', $object_id) ;
        $this->fx = eg_get_gallery_option( 'eg_fullscreen_fx','on', $object_id);
        $this->fit_padding = eg_get_gallery_option( 'eg_fullscreen_fit_padding',20, $object_id);
        $this->gallery_type='slider';
    }

    public function get_image_markup($imgID,$ref_id=0)
    {
        $img = $this->get_image($imgID, 'full');
        $thumbnail = $this->get_image($imgID,'thumbnail');

        $alt_text = get_post_meta( $imgID, '_wp_attachment_image_alt', true);

        $img_html = "<div class='ms-slide'>";
        //$img_html .= "{$this->justified_extra_markup()}";
        $img_html .="<img
            src='".get_template_directory_uri()."/assets/img/blank.gif'
            data-src='{$img[0]}'
            alt='{$alt_text}' />";

        if ( $this->has_thumbs )
        {
            $img_html .= "<img src='{$thumbnail[0]}' alt='{$alt_text}' class='ms-thumb' />";
        }
        $img_html .= '</div>';



        return $img_html;
    }

    public function get_em_gallery_atts()
    {

        $attributes = array('data-layout="autofill"');

        //Display mode
        $attributes[] = 'data-fillmode="' . $this->fill_mode . '"';

        // thumbnails
        $attributes[] = 'data-gallery="' . $this->has_thumbs . '"';

        // counter
        $attributes[] = 'data-counter="'. $this->has_counter .'"';

        // direction
        $attributes[] = 'data-dir="'.$this->direction.'"';

        // autoplay
        $attributes[] = 'data-autoplay="' . $this->has_autoplay . '"';

        //Timer bar
        $attributes[] = 'data-timer="' . $this->has_timer . '"';

        // fx
        $attributes[] = 'data-view="' . $this->fx . '"';

        // id
        $attributes[] = 'id="masterslider-'.$this->object_id.'"';

        return implode(' ', $attributes);
    }

    public function get_em_gallery_class()
    {

        $class = array('tj-ms-slider', 'tj-ms-skin', 'tj-ms-gallery','fillmode');

        $class[] = 'em-gallery-' . $this->gallery_layout;

        if ( ! $this->has_thumbs )
        {
            $class[]= 'no-thumbnails';
        }
        return implode(' ', $class);
    }
   

    public function get_gallery_wrapper_class()
    {
        $class[] = 'full-screen';

        $class_str =  implode(' ',$class);

        return parent::get_gallery_wrapper_class() . ' ' . $class_str;
    }

     public function get_before_loop(){
        if ($this->fill_mode=='fit'){
            echo '<style>';
            echo '.ms-slide-bgcont{padding:'.$this->fit_padding.'px}';
            echo '</style>';
        }

        if ($this->has_thumbs){
            echo '<div id="gallery-thumb-trigger"></div>';
        }
        

    }

}