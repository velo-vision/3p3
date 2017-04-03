<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class eg_pf_justified_class extends eg_justified_class
{
    protected $hover_style;

    public function __construct( $object_id = NULL, $gallery_image_ids = '' )
    {
        parent::__construct( $object_id, $gallery_image_ids );

        $this->gallery_layout 		= epf_get_option( 'epf_gallery_layout', 'horizontal', $object_id );
        $this->has_infinite_scroll 	= epf_get_option( 'epf_load_type', 'lazy', $object_id ) == 'infinite' ? TRUE : FALSE;
        $this->has_lazy_load 		= epf_get_option( 'epf_load_type', 'lazy', $object_id ) == 'lazy' ? TRUE : FALSE;
        $this->has_lightbox 		= FALSE;
        $this->animation_type       = epf_get_option( 'epf_scroll_animation', 'none', $object_id );
        $this->has_animation        = $this->animation_type == 'none' ? false : true;
        
        $this->posts_per_page 		= epf_get_option( 'epf_infinite_chunk_count', 15, $object_id );
        $this->gallery_image_ids 	= $gallery_image_ids;
        $this->is_proof_mode 		= FALSE;
        $this->grid_direction 		= 'vertical';
        $this->scrolls_vertically 	= TRUE;
        
        $this->is_archive 			= TRUE;
        $this->rowHeight 			= epf_get_option( 'epf_jg_rowheight', 300, $object_id );
        $this->gutterWidth 			= epf_get_option( 'epf_items_spacing', 15, $object_id );
        $this->gallery_type			= 'justified';
        $this->hover_style = epf_get_option('epf_hover','hover-1',$object_id, true);
    }


    public function get_em_gallery_class(){

        $class = ' is-portfolio';
        return parent::get_em_gallery_class() . $class;
    }


    public function get_image_markup( $imgID, $ref_id = 0 )
    {
        $img = $this->get_image( $imgID );
        $img_html = $this->get_img_html( $imgID, $img );
        $href = eram_get_permalink( $ref_id );

        $o = epf_get_hover_style($img_html,$href, $ref_id,$this->hover_style, 'gallery-item '.$this->get_image_wrapper_class($ref_id));

        return $o;

    }
}