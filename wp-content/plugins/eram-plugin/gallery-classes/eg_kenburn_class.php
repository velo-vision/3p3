<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class eg_kenburn_class extends eg_class
{

    protected $has_kb_captions;
    protected $has_kb_dots;

    public function __construct($object_id=null,$gallery_image_ids='')
    {
        parent::__construct($object_id, $gallery_image_ids);

        $this->has_lightbox     = false;
        $this->has_kb_dots      = eg_get_gallery_option('eg_kb_overlay','on',$this->object_id);
        $this->has_kb_captions  = eg_get_gallery_option('eg_kb_caption','off',$this->object_id);
        $this->gallery_type='kenburn';
    }

    /**
     * @return mixed
     */
    public function get_gallery_image_ids()
    {
        return $this->gallery_image_ids;
    }

    /**
     * @return string
     */
    public function get_em_gallery_class()
    {
        $class = 'em-gallery-' . $this->gallery_layout;

        if( $this->has_kb_dots )
            $class .= ' with-dots';

        return $class;
    }

    /**
     * @return string
     */
    public function get_em_gallery_atts()
    {
        $atts = array();

        $atts['data-kb-zoom'] = eg_get_gallery_option('eg_kb_zoom','1.1',$this->object_id);
        $atts['data-kb-duration'] = eg_get_gallery_option('eg_kb_duration','7',$this->object_id);


        return http_build_query($atts,'',' ');

    }
    /**
     * @param $imgID
     * @param $img
     * @return string
     */
    protected function get_img_html( $imgID, $img )
    {
        $o = '';
        if ( $this->has_kb_captions ){
            $o .= "<div class='caption' data-pos='bottom-left'>";
            $o .= "<h2 class='title'>";
            $o .= get_post( $imgID )->post_excerpt;
            $o .= '</h2>';
            $o .= '</div>';
        }
        return $o . parent::get_img_html($imgID, $img);  
    }

    /**
     * @param $img
     * @param $imgID
     * @return mixed
     */
    protected function get_image_source($img, $imgID)
    {
        $image = $this->get_image($imgID,'full');

        return $image[0];

    }

    public function get_before_loop(){
        echo '<div class="kb-loader em-loader"><div class="spinner"><div class="double-bounce1"></div><div class="double-bounce2"></div></div></div>';
    }

    public function get_gallery_wrapper_class()
    {
        $class[] = 'full-screen';

        $class_str =  implode(' ',$class);

        return parent::get_gallery_wrapper_class() . ' ' . $class_str;
    }
}