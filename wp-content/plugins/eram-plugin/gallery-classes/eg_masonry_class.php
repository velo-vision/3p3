<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class eg_masonry_class extends eg_class
{

    protected $masonry_direction;

    public function __construct($object_id=null, $gallery_image_ids='')
    {
        parent::__construct($object_id, $gallery_image_ids);
        $this->gallery_type='masonry';
        $this->masonry_cols = eg_get_gallery_option('eg_masonry_cols',3,$this->object_id);
        $this->masonry_rows = eg_get_gallery_option('eg_masonry_rows',3,$this->object_id);

        
    }

    public function get_gallery_wrapper_class()
    {
        $class[] = 'direction-'.$this->masonry_direction;

        if ( $this->masonry_direction == 'vertical')
        {
            $class[]= 'cols-'.$this->masonry_cols;
        }
        else
        {
            $class[]= 'rows-'.$this->masonry_rows;

            // needs full-screen for horizontal scroll 
            $class[] = 'full-screen';
        }

        $class_str =  implode(' ',$class);

        return parent::get_gallery_wrapper_class() . ' ' . $class_str; 
    }

    protected function get_gallery_item_class($imgID , $ref_id = 0)
    {
        $class = array();
        $class[] = $this->get_animation_class();

        return parent::get_gallery_item_class($imgID , $ref_id) . ' ' . implode(' ',$class);
    }

    private function get_animation_class()
    {
        $class = array();

        if ( $this->has_animation ){
            
            $class[] = 'ol-animate';

            switch ($this->animation_type) {
                case 'slidefade':
                    $class[] = 'fadeIn'.$this->masonry_direction;
                    break;
                
                default: // fadein
                    $class[] = 'fadeIn hinge';
                    break;
            }
            if ( $this->masonry_direction == 'horizontal')
            {
                $class[] = " _animates_horizontally";
            }
        }

        return implode(' ',$class);
    }

    public function get_main_area_class()
    {
        $class = '';

        return parent::get_main_area_class() . ' ' . $class;  
    }
    

}