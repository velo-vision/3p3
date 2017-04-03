<?php

class eg_dcarousel_class extends eg_class
{

    public function __construct( $object_id, $gallery_image_ids )
    {
        parent::__construct( $object_id, $gallery_image_ids );
        $this->gallery_type = 'dcarousel';
        $this->has_lazy_load = false;
        $this->has_dc_next_prev     = eg_get_gallery_option('eg_dc_show_next_prev','on',$this->object_id);
        $this->has_dc_captions      = eg_get_gallery_option('eg_dc_show_captions','on',$this->object_id);
    }

    public function print_items_loop()
    {

        $img_ids = $this->get_gallery_image_ids();

        $right_ids = $left_ids = array();

        $n = 0;
        foreach ( $img_ids as $ref_id => $img_id ) {
            if ( $n % 2 == 0 ) {
                $left_ids[ $ref_id ] = $img_id;
            }
            else {
                $right_ids[ $ref_id ] = $img_id;
            }
            $n++;
        }

        // loop for left side
        $this->loop( $left_ids, 'left-side' );

        // loop for right side
        $this->loop( $right_ids, 'right-side' );

        if ( $this->has_dc_next_prev ){
            echo '<div class="vcarousel-prev"><a href="#">&#8613;</a></div>';
            echo '<div class="vcarousel-next"><a href="#">&#8615;</a></div>';
        }

        $this->get_after_loop();
            
    }

    /**
     * @param $left_ids
     * @return array
     */
    private function loop( $left_ids, $class )
    {
        echo '<div class="' . $class . '" data-fill="auto-fill">';
        echo '<div class="' . $class . '-wrapper">';
        foreach ( $left_ids as $ref_id => $imgID ) {
            $this->print_image_markup( $imgID, $ref_id );
        }
        echo '</div>';
        echo '</div>';

    }

    public function get_gallery_wrapper_class()
    {
        $class[] = 'full-screen';

        $class_str =  implode(' ',$class);

        return parent::get_gallery_wrapper_class() . ' ' . $class_str;
    }

    public function get_em_gallery_class(){
        $class = 'ol-double-carousel';

        return parent::get_em_gallery_class() . ' ' . $class;
    }

    /**
     * @return string
     */
    public function get_em_gallery_atts()
    {
        $att[] = 'data-autoplay="' . eg_get_gallery_option( 'eg_dc_autoplay', 'on', $this->object_id ) . '"';
        $att[] = 'data-show-bullet="' . eg_get_gallery_option( 'eg_dc_show_bullets', 'on', $this->object_id ) . '"';
        $att[] = 'data-transition-duration="' . eg_get_gallery_option( 'eg_dc_duration', 1, $this->object_id ) . '"';

        $atts_str = implode( ' ', $att );

        return parent::get_em_gallery_atts() . ' ' . $atts_str;
    }

   

    /**
     * @param $imgID
     * @param $img
     * @return string
     */
    protected function get_img_html( $imgID, $img )
    {
        $img_html ='';
        if ( $this->has_dc_captions && ! $this->is_archive ){
            $caption = get_post( $imgID )->post_excerpt;
            $caption = eram_transform_piped_text($caption);
            $img_html .= "<div class='caption'>{$caption}</div>";
        }
        
        $img_html .= "<div class='img-wrapper {$this->get_image_wrapper_class()}'>";
        $img_html .= "<img 
                            class='{$this->get_img_class()}' 
                            src='{$this->get_image_source($img,$imgID)}' 
                            width='{$img[1]}' 
                            height='{$img[2]}'
                            {$this->get_img_extra_atts($img)}>";

        $img_html .= '</div>';

        return $img_html;
    }

}