<?php $images_ids = eram_get_single_meta('eram_ps_gallery','') ;?>

<?php if (! empty($images_ids)) {?>
  <div class="post-format-wrapper format-gallery">
    <div class="gallery-carousel owl-carousel owl-theme">
      <?php $images_array = explode(',',$images_ids);?>

      <?php foreach($images_array as $img_id):?>

      <?php $img_url = wp_get_attachment_image_src( $img_id , 'large');?>

      <div class="item">
        <img src="<?php echo esc_url($img_url[0]);?>" alt="image">
      </div>
      <?php endforeach;?>

    </div>
  </div>
<?php }?>