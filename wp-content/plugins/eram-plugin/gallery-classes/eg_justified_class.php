<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



class eg_justified_class extends eg_class
{
    protected $rowHeight;
    protected $gutterWidth;
    
    public function __construct( $object_id = NULL, $gallery_image_ids = '' )
    {
        parent::__construct( $object_id, $gallery_image_ids );

        $this->rowHeight = eg_get_gallery_option( 'eg_jg_rowheight', 300, $this->object_id );
        $this->gutterWidth = eg_get_gallery_option( 'eg_items_spacing', 15, $this->object_id );
        $this->gallery_type='justified';
        $this->scrolls_vertically = TRUE;
    }

    public function get_image_markup( $imgID, $ref_id = 0 )
    {
        $img = $this->get_image( $imgID );
        $img_html = $this->get_img_html( $imgID, $img );
        $o = '';

        if ( $this->is_archive ) {
            $o = $this->add_archive_wrapper($img_html,$ref_id,'gallery-item '.$this->get_image_wrapper_class($ref_id));
        }
        else {
            if ( $this->has_lightbox ){

                // check if we have video
                $attachement_meta = get_post_custom($imgID);
                $has_video = array_key_exists('_eg_video_url',$attachement_meta);

                // get caption
                $caption = $this->get_lightbox_image_caption( $imgID );
                $caption_attr = 'data-sub-html="#lg-caption-' . $imgID . '"';

                if ( $has_video )
                {
                    $video_url = $attachement_meta['_eg_video_url'][0];
                    $o .= "<div class='gallery-item {$this->get_image_wrapper_class($ref_id)}' $caption_attr data-id='{$imgID}' data-src='{$video_url}'>";
                    $o .= "<div class='em-video-icon'><span class='ol ol-play'></span></div>";
                }
                else{
                    $full_image = $this->get_image($imgID,'full');
                    $o .= "<div class='gallery-item {$this->get_image_wrapper_class($ref_id)}' $caption_attr data-id='{$imgID}' data-src='{$full_image[0]}'>";
                }

                $o .= $caption;
                $o .= "<div class='hover-icon'>";
                $o .= '</div><!-- .hover-icon-->';
                $o .= $img_html;
                $o .= "</div><!-- .gallery-item-->";
            }
            else{
                $o .= "<div class='gallery-item {$this->get_image_wrapper_class($ref_id)}' data-id='{$imgID}'>";
                $o .= $img_html;
                $o .= '</div><!-- .gallery-item-->';
            }
        }



        return $o;
    }

    protected function get_image_wrapper_class($ref_id=0)
    {
        $class = array();
        
        $class[] = $this->get_animation_class();
        
        if ( $this->is_archive ) {
            $class[] = ' gl-wrapper em-hover hover-2';
        } else {
            if ( $this->has_lightbox ) {
                $class[] = ' lightbox-item em-hover hover-1';
            }        
        }

        if ( $this->has_lazy_load ) {
            $class[] = 'lazy-base loading-lazy';
        }
        
        return implode(' ',$class);
    }

    private function get_animation_class()
    {
        $class = array();

        if ( $this->has_animation ){
            
            $class[] = 'ol-animate';

            switch ($this->animation_type) {
                case 'slidefade':
                    $class[] = '_wait fadeInvertical';
                    break;
                
                default: // fadein
                    $class[] = '_wait fadeIn hinge';
                    break;
            }
            
        }

        return implode(' ',$class);
    }

    public function get_em_gallery_atts()
    {
        $atts = '';  
        $atts .= ' data-jg-rowheight=' . $this->rowHeight;
        $atts .= ' data-jg-maxrowheight=' . $this->rowHeight * 1.3;
        $atts .= ' data-jg-margin=' . $this->gutterWidth;

        return parent::get_em_gallery_atts() . $atts;
    }

    /**
     * @param $imgID
     * @param $img
     * @return string
     */
    protected function get_img_html( $imgID, $img )
    {
        $img_html = "<img 
                            class='{$this->get_img_class()}' 
                            src='{$this->get_image_source($img,$imgID)}' 
                            width='{$img[1]}' 
                            height='{$img[2]}'
                            {$this->get_img_extra_atts($img)}>";


        return $img_html;
    }
}