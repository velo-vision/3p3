<div class="gallery-wrapper gallery-page-title-side <?php echo $gal->get_gallery_wrapper_class()?>">
  <?php $cover = eram_gallery_page_cover_image($object_id);?>

  <?php $coverimage = $cover['image_url']=='none'?'':$cover['image_url'];?>

  <div class="gallery-side layout-vertical-padding">
    <div class="tb-vcenter-wrapper <?php echo $cover['class'];?>">
      <div class="vcenter" style="background-image:url(<?php echo $coverimage;?>);">
        
        <h1 class="title">
          <?php if (is_post_type_archive()) {?>
            <?php echo eg_get_gallery_option( 'eg_page_title', 'Page Title','');?>

          <?php }
          elseif (is_tax()) {?>
            <?php single_term_title();?>

          <?php }
           else {?>
            <?php the_title();?>

          <?php }?>
        </h1>
        <div class="description">
          <?php if (is_tax()) {?>
            <?php echo term_description();?>

          <?php }
          elseif (is_post_type_archive()) {?>
            <?php echo eg_get_gallery_option( 'eg_page_description', '','');?>

          <?php }
           else {?>
            <?php echo get_the_excerpt();?>

          <?php }?>
        </div>
      </div>
    </div>
  </div>
  <div class="gallery-main <?php echo $gal->get_gallery_main_class()?>">
    <div class="em-gallery <?php echo $gal->get_em_gallery_class()?>" <?php echo $gal->get_em_gallery_atts()?>>
      <?php $gal->print_items_loop();?>

    </div>
  </div>
  </div>
</div>