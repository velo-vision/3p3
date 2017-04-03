<?php $show_sidebar = epf_get_option('epf_has_details',FALSE,$object_id);?>

<?php $sidebar_class = 'no-sidebar';?>

<?php if (isset($show_sidebar) ? $show_sidebar : false) {?>
  <?php $sidebar_class = 'with-sidebar';?>

<?php }?>
<div class="gallery-wrapper portfolio-minimal <?php echo $portfolio->get_gallery_wrapper_class()?> <?php echo $sidebar_class;?>">
  <?php if (isset($show_sidebar) ? $show_sidebar : false) {?>
    <div class="page-side layout-vertical-padding">
      <?php $cover_class = '';?>

      <?php $cover_image_url = epf_get_option('epf_archive_cover','',$object_id);?>

      <?php $has_cover = $cover_image_url == '' ? FALSE : TRUE;?>

      <?php if (isset($has_cover) ? $has_cover : false) {?>
        <?php $cover_class = 'em-has-cover';?>

      <?php }?>
      <div class="tb-vcenter-wrapper <?php echo $cover_class;?>">
        <div class="vcenter" style="background-image:url(<?php echo $cover_image_url;?>);">
          <h1 class="title">
            <?php if (is_post_type_archive()) {?>
              <?php echo epf_get_option( 'epf_page_title', 'Portfolio Title','');?>

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
              <?php echo epf_get_option( 'epf_page_description', '','');?>

            <?php }
             else {?>
              <?php echo get_the_excerpt();?>

            <?php }?>
          </div>
        </div>
      </div>
    </div>
  <?php }?>
  <div class="page-main gallery-main <?php echo $portfolio->get_gallery_main_class()?>">
    <div class="em-gallery <?php echo $portfolio->get_em_gallery_class()?>" <?php echo $portfolio->get_em_gallery_atts()?>>
      <?php $portfolio->print_items_loop();?>

    </div>
  </div>
  </div>
</div>