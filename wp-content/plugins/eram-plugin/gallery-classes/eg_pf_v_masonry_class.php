<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class eg_pf_v_masonry_class extends eg_masonry_class
{
    protected $masonry_direction;
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
        $this->gallery_image_ids 	= $gallery_image_ids;
        $this->is_proof_mode 		= FALSE;
        $this->scrolls_vertically 	= TRUE;
        $this->masonry_direction 	= 'vertical';
        $this->gallery_type='masonry';
        $this->masonry_cols = epf_get_option('epf_masonry_cols',3,$this->object_id);
        $this->masonry_rows = epf_get_option('epf_masonry_rows',3,$this->object_id);
        $this->is_archive = TRUE;
        $this->hover_style = epf_get_option('epf_hover','hover-1',$object_id, true);
    }

    public function get_gallery_item_class($imgID , $ref_id = 0)
    {
        $class = epf_get_post_class($ref_id);

        return parent::get_gallery_item_class($imgID , $ref_id) . $class;
    }

    public function get_em_gallery_class(){

        $class = ' is-portfolio';
        return parent::get_em_gallery_class() . $class;
    }

    protected function add_archive_wrapper( $img_html, $ref_id = 0, $wrapper_class=''  )
    {
        if ( ! $this->is_archive )
            return $img_html;

        $href = eram_get_permalink( $ref_id );

        $o = epf_get_hover_style($img_html, $href, $ref_id,$this->hover_style);

        return $o;
    }
}