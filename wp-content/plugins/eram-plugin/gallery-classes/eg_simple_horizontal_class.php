<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class eg_simple_horizontal_class extends eg_class
{
    protected $widthMode;

    public function __construct( $object_id=null, $gallery_image_ids='')
    {
        parent::__construct($object_id, $gallery_image_ids);
        $this->gallery_type='simple';
        $this->widthMode=eg_get_gallery_option('eg_hs_width','auto', $this->object_id);

    }

    /**
     * @return string
     */
    public function get_em_gallery_atts()
    {
        return parent::get_em_gallery_atts(). ' data-mode="'. $this->widthMode .'"';

    }

    /**
     * @return string
     */
    protected function get_gallery_item_style()
    {

        if ( $this->widthMode=='fixed' )
        {
            $width=eg_get_gallery_option('eg_hs_image_width','auto',$this->object_id);
            $style="width:{$width}px;";
            return $style;
        }
        return '';
    }

    public function get_em_gallery_class()
    {
        $class='';

        // add direction
        $class .=' direction-horizontal';

        return parent::get_em_gallery_class() . ' ' . $class;
    }

    protected function get_gallery_item_class($imgID , $ref_id = 0)
    {
        $class ='';
        if ( $this->has_animation ){
            switch ($this->animation_type) {
                case 'slidefade':
                    $class .= ' ol-animate fadeInhorizontal _animates_horizontally';
                    break;
                
                default: // fadein
                    $class .= ' ol-animate fadeIn hinge _animates_horizontally';
                    break;
            }
            
        }

        return parent::get_gallery_item_class($imgID , $ref_id) . ' ' . $class;
    }

    public function get_main_area_class()
    {
        $class = "";

        return parent::get_main_area_class() . ' ' . $class;  
    }

    public function get_gallery_wrapper_class()
    {
        $class[] = 'direction-horizontal';

        // make it fullscreen
        $class[] = "full-screen";

        $class_str =  implode(' ',$class);

        return parent::get_gallery_wrapper_class() . ' ' . $class_str;
    }
}