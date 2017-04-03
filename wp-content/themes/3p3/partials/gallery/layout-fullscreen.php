<div class="gallery-wrapper gallery-page-fullscreen <?php echo $gal->get_gallery_wrapper_class()?>">
  <div class="gallery-main <?php echo $gal->get_gallery_main_class()?>">
    <div class='em-gallery <?php echo $gal->get_em_gallery_class()?>' <?php echo $gal->get_em_gallery_atts()?>>
      <?php $gal->print_items_loop();?>

    </div>
  </div>
</div>
<?php if (Eram_kirki::get_option('eram_theme_options','eram_footer_for_galleries',0) == 1 && $gal->scrolls_vertically) {?>
  
  <?php eram_footer();?>

<?php }?>