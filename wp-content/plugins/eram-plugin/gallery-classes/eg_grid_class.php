<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class eg_grid_class extends eg_class
{

    protected $grid_direction;
    protected $grid_ratio;
    protected $grid_cols;
    protected $grid_rows;
    
    public function __construct($object_id=null,$gallery_image_ids='')
    {
        parent::__construct($object_id, $gallery_image_ids);

        $this->gallery_type='grid';
        $this->grid_ratio = eg_get_gallery_option('eg_grid_thumb_ratio','square',$this->object_id);
        $this->grid_cols = eg_get_gallery_option('eg_grid_cols',3,$this->object_id);
        $this->grid_rows = eg_get_gallery_option('eg_grid_rows',3,$this->object_id);
    }

    public function get_gallery_wrapper_class()
    {

        $class[] = 'direction-'.$this->grid_direction;

        if ( $this->grid_direction == 'vertical')
        {
            $class[] = 'cols-'.$this->grid_cols;
        }
        else
        {
            $class[] = 'rows-'.$this->grid_rows;

            // needs full-screen for horizontal scroll 
            $class[] = 'full-screen';
        }

        $class_str = implode(' ',$class);

        return parent::get_gallery_wrapper_class() . ' ' . $class_str;
    }


    public function get_gallery_item_class($imgID , $ref_id = 0)
    {
        $class = array();

        $class[] = 'ratio-'.$this->grid_ratio;

        $class[] = $this->get_animation_class();
        
        return parent::get_gallery_item_class($imgID, $ref_id) . ' ' . implode(' ',$class);
    }

    private function get_animation_class()
    {
        $class = array();

        if ( $this->has_animation ){
            
            $class[] = 'ol-animate';

            switch ($this->animation_type) {
                case 'slidefade':
                    $class[] = 'fadeIn'.$this->grid_direction;
                    break;
                
                default: // fadein
                    $class[] = 'fadeIn hinge';

                    break;
            }

            if ( $this->grid_direction == 'horizontal')
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