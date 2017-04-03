<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class eg_pf_minimal_class extends eg_simple_vertical_class
{
    
    protected $hover_style;

    public function __construct($object_id=null, $gallery_image_ids='')
    {

    	parent::__construct($object_id, $gallery_image_ids);
        
        $this->gallery_layout 		= epf_get_option( 'epf_gallery_layout', 'horizontal', $object_id );
        $this->has_infinite_scroll 	= epf_get_option( 'epf_load_type', 'lazy', $object_id ) == 'infinite' ? TRUE : FALSE;
        $this->has_lazy_load 		= epf_get_option( 'epf_load_type', 'lazy', $object_id ) == 'lazy' ? TRUE : FALSE;
        $this->has_lightbox 		= FALSE;
        $this->animation_type       = epf_get_option( 'epf_scroll_animation', 'none', $object_id );
        $this->has_animation        = $this->animation_type == 'none' ? false : true;
        $this->posts_per_page 		= epf_get_option( 'epf_infinite_chunk_count', 15, $object_id );
        $this->gallery_type 		= 'simple';
        $this->gallery_image_ids 	= $gallery_image_ids;
        $this->is_proof_mode 		= FALSE;
        $this->scrolls_vertically 	= TRUE;
        $this->is_archive           = TRUE;
        $this->isFixedHeight        = TRUE;
        $this->FixedHeight          = 280;
        $this->scrolls_vertically   = TRUE;
        $this->isFixedHeight        = TRUE;
        $this->FixedHeight          = epf_get_option( 'epf_minimal_height', 280 , $object_id );

        $this->hover_style = epf_get_option('epf_hover','hover-1',$object_id, true);
    }

    protected function get_gallery_item_class($imgID , $ref_id = 0)
    {
        $class ='';
        if ( $this->has_animation )
        {
            switch ($this->animation_type) {
                case 'slidefade':
                    $class .= ' ol-animate fadeInvertical';
                    break;
                
                default: // fadein
                    $class .= ' ol-animate fadeIn hinge';
                    break;
            }
            
        }

        return parent::get_gallery_item_class($imgID , $ref_id) . ' ' . $class;
    }

    public function get_em_gallery_class(){

        $class = ' is-portfolio';
        return parent::get_em_gallery_class() . $class;
    }

    protected function add_archive_wrapper( $img_html, $ref_id = 0 , $wrapper_class='' )
    {
        if ( ! $this->is_archive )
            return $img_html;

        $href = eram_get_permalink( $ref_id );

        $o = epf_get_hover_style($img_html,$href, $ref_id,$this->hover_style);

        return $o;
    }
}