<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class eg_simple_vertical_class extends eg_class
{
    public function __construct($object_id=null,$gallery_image_ids='')
    {
        parent::__construct($object_id, $gallery_image_ids);
        $this->gallery_type='simple';
        $this->isFixedHeight = eg_get_gallery_option('eg_vs_height','fixed',$this->object_id)=='fixed'?TRUE:FALSE;
        $this->FixedHeight = eg_get_gallery_option('eg_vs_image_height',300,$this->object_id);
        $this->scrolls_vertically = TRUE;
    }


    protected function get_gallery_item_class($imgID , $ref_id = 0)
    {
        $class ='';
        if ( $this->has_animation ){
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

    public function get_gallery_wrapper_class()
    {
        $class[] = 'direction-vertical';

        $class_str =  implode(' ',$class);

        return parent::get_gallery_wrapper_class() . ' ' . $class_str;
    }

    public function get_em_gallery_class()
    {
        $class='';
        if ( $this->isFixedHeight )
        {
            $class = ' fill-mode';
        }
        return parent::get_em_gallery_class() . $class;
    }

    /**
     * @return string
     */
    protected function get_gallery_item_style()
    {
        if ( $this->isFixedHeight )
        {
            $style="height:{$this->FixedHeight}px;";
            
            return $style;
        }
        return '';
    }

}