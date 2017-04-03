<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class eg_v_masonry_class extends eg_masonry_class
{
    protected $masonry_direction;

    public function __construct($object_id=null, $gallery_image_ids='')
    {
        parent::__construct($object_id, $gallery_image_ids);

        $this->masonry_direction = 'vertical';
        $this->scrolls_vertically = TRUE;
    }
}