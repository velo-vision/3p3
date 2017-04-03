<?php

class eg_proofing_class extends eg_v_masonry_class
{
    protected $masonry_direction;
    protected $accepted_photos;
    protected $accepted_photos_array;
    protected $masonry_cols;
    protected $comments_enable;

    public function __construct( $object_id = NULL, $gallery_image_ids = '' )
    {
        parent::__construct( $object_id, $gallery_image_ids );
        $this->set_accepted_photos();
        $this->set_accepted_photos_array();
        $this->masonry_cols = eg_get_proof_gallery_option( '_epg_masonry_cols', 3, $this->object_id );
        $this->has_infinite_scroll = FALSE;
        $this->has_lazy_load = TRUE;
        $this->has_lightbox = TRUE;
        $this->has_animation = FALSE;
        $this->posts_per_page = 15;
        $this->is_archive = FALSE;
        $this->gallery_layout = 'v_masonry';
        $this->gallery_type = 'masonry';
        $this->scrolls_vertically = TRUE;
        $this->comments_enable = comments_open($object_id);
    }

    public function get_accepted_photos()
    {
        return $this->accepted_photos;
    }

    public function set_accepted_photos()
    {
        $this->accepted_photos = eg_get_proof_gallery_option( '_epg_proof_accepted_imgs', '', $this->object_id );
    }

    public function get_accepted_photos_array()
    {
        return $this->accepted_photos_array;
    }

    public function set_accepted_photos_array()
    {

        if ( $this->accepted_photos == '' ) {
            $this->accepted_photos_array = array();
        }
        else {
            $this->accepted_photos_array = explode( ',', $this->accepted_photos );
        }
    }

    protected function get_gallery_item_class( $imgID, $ref_id = 0 )
    {
        $class = "";
        if ( in_array( $imgID, $this->accepted_photos_array ) )
            $class = 'em-accepted';

        return parent::get_gallery_item_class( $imgID, $ref_id ) . ' ' . $class;
    }

    public function get_gallery_wrapper_class()
    {
        return parent::get_gallery_wrapper_class() . ' ' . 'mode-proofing';
    }


    public function after_item_markup( $imgID )
    {
        $img = $this->get_image( $imgID, 'full' );
        $out = '';
        $out .= "<div class='em-extra-info'>";
        $out .= "<div class='em-proofing-controls'>";
        $out .= "<span class='default'>" . __( 'Select', 'eram' ) . "</span>";
        $out .= "<span class='selected'>" . __( 'Selected', 'eram' ) . "</span>";
        $out .= "</div>";
        $out .= $this->add_comment_icon( $img, $imgID );
        $out .= $this->add_download_btn( $img );
        $out .= $this->add_image_id($imgID );
        $out .= "</div>";

        return $out;
    }

    /**
     * @param $img
     * @return string
     */
    protected function add_download_btn( $img )
    {
        return "<a href='{$img[0]}' title='".esc_html__('Download this Photo','eram')."' download target='_blank' class='download-img'><i class='ol ol-download'></i></a>";

    }

    protected function add_comment_icon( $img, $imgID=0 )
    {
        if ( ! $this->comments_enable )
            return FALSE;

        return "<a href='#respond' title='".esc_html__('Comment on this Photo','eram')."' class='respond-by-image' data-id='{$imgID}' data-image='{$img[0]}'><i class='ol ol-chat'></i></a>";
    }

    private function add_image_id( $imgID )
    {
        return "<span class='image-id' title='".esc_html__('Photo Identifier','eram')."'>#{$imgID}</span>";
    }
}