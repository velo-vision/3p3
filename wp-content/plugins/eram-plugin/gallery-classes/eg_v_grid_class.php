<?php

class eg_v_grid_class extends eg_grid_class
{
    protected $grid_direction;

    public function __construct($object_id=null, $gallery_image_ids='')
    {
        parent::__construct($object_id, $gallery_image_ids);

        $this->grid_direction = 'vertical';
        $this->scrolls_vertically = TRUE;
    }
}