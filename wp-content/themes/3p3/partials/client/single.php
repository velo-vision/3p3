<?php $header_class="";?>

<?php $header_parallax_mode = "";?>

<?php $content_parallax_mode = "";?>

<?php $content_class = "";?>

<?php $cover_image="";?>

<?php $has_parallax = Eram_Kirki::get_option('eram_theme_options','eram_has_parallax',true);?>

<?php $inline_styles="";?>

<?php $header_hvh = "hvh-". intval(Eram_Kirki::get_option('eram_theme_options','eram_top_header_height',60) );?>

<?php if (has_post_thumbnail()) {?>
  <?php $cover_image= get_the_post_thumbnail_url()?>

  <?php if (isset($has_parallax) ? $has_parallax : false) {?>
    <?php $header_class="parallax-layer has-cover ov-dark-alpha-50 ".$header_hvh;?>

    <?php $content_class = "parallax-layer";?>

    <?php $header_parallax_mode = "";?>

    <?php $content_parallax_mode = "mode-header-content";?>

  <?php }
   else {?>
    <?php $header_class="has-cover ov-dark-alpha-50 ".$header_hvh;?>

    <?php $inline_styles="background-image:url(" . $cover_image . ");";?>

  <?php }?>
<?php }?>
<div class="page-head client-header <?php echo $header_class; ?>" data-img-src="<?php echo $cover_image; ?>" data-parallax-mode="<?php echo $header_parallax_mode; ?>" style="<?php echo $inline_styles;?>">
  <div class="tb-vcenter-wrapper">
    <div class="title-wrapper vcenter <?php echo $content_class; ?>" data-parallax-mode="<?php echo $content_parallax_mode; ?>">
      <div class="avatar-wrapper layout-center">
        <?php $client_img_id = get_post_meta (get_the_ID(), '_ec_photo', true );?>

        <?php if (isset($client_img_id) ? $client_img_id : false) {?>
          <?php $client_image= wp_get_attachment_image_src($client_img_id,'thumbnail');?>

          <img class="avatar avatar-lg" src="<?php echo $client_image[0];?>">
        <?php }?>
      </div>
      <h1 class="title">
        <?php the_title()?>

      </h1>
      <div class="description">
        <?php echo esc_html(get_post_meta(get_the_ID(),'_ec_about',true))?>

      </div>
    </div>
  </div>
</div>
<div class="page-contents">
  <div class="container">
    <?php if (! empty($gal->gallery_image_ids)) {?>
      <div class="gallery-wrapper <?php echo $gal->get_gallery_wrapper_class()?>">
        <div class="gallery-main <?php echo $gal->get_gallery_main_class()?>">
          <div class="em-gallery <?php echo $gal->get_em_gallery_class()?>" <?php echo $gal->get_em_gallery_atts()?>>
          <?php $gal->print_items_loop();?>

          </div>
        </div>
      </div>
    <?php }
     else {?>
      <?php esc_html_e('No Galleries Found.', 'eram');?>

    <?php }?>
  </div>
</div>
<?php if (Eram_kirki::get_option('eram_theme_options','eram_footer_for_blog',0) == 1) {?>

  <?php eram_footer();?>

<?php }?>
