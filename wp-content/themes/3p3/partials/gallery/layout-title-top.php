<div class="gallery-wrapper gallery-page-title-top <?php echo $gal->get_gallery_wrapper_class()?>">
  <?php if (isset($gal->scrolls_vertically) ? $gal->scrolls_vertically : false) {?>
    <?php $header_class="";?>

    <?php $header_parallax_mode = "";?>

    <?php $content_parallax_mode = "";?>

    <?php $content_class = "";?>

    <?php $cover_image="";?>

    <?php $has_parallax = Eram_Kirki::get_option('eram_theme_options','eram_has_parallax',true);?>

    <?php $inline_styles="";?>

    <?php $header_hvh = "hvh-". intval(Eram_Kirki::get_option('eram_theme_options','eram_top_header_height',60) );?>

    <?php if (is_archive()) {?>
      <?php $cover_image = eg_get_gallery_option('eg_archive_cover','',$object_id);?>

      <?php $has_cover = $cover_image==''?FALSE:TRUE;?>

    <?php }
     else {?>
      <?php $cover = eram_gallery_page_cover_image($object_id);?>

      <?php $has_cover = $cover['image_url'] == 'none' ? false :true;?>

      <?php $cover_image = $cover['image_url'];?>

    <?php }?>
    <?php if (isset($has_cover) ? $has_cover : false) {?>
      <?php if (isset($has_parallax) ? $has_parallax : false) {?>
        <?php $header_class="parallax-layer has-cover ov-dark-alpha-50 ". $header_hvh;?>

        <?php $content_class = "parallax-layer";?>

        <?php $header_parallax_mode = "";?>

        <?php $content_parallax_mode = "mode-header-content";?>

      <?php }
       else {?>
        <?php $header_class="has-cover ov-dark-alpha-50 ". $header_hvh;?>

        <?php $inline_styles="background-image:url(" . $cover_image . ");"?>

      <?php }?>
    <?php }?>
    <div class="page-head <?php echo $header_class; ?>" data-img-src="<?php echo $cover_image; ?>" data-parallax-mode="<?php echo $header_parallax_mode; ?>" style="<?php echo $inline_styles;?>">
      <div class="tb-vcenter-wrapper">
        <div class="title-wrapper vcenter <?php echo $content_class; ?>" data-parallax-mode="<?php echo $content_parallax_mode; ?>">
          
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
      <div class='em-gallery <?php echo $gal->get_em_gallery_class()?>' <?php echo $gal->get_em_gallery_atts()?>>
        <?php $gal->print_items_loop();?>

        </div>
    </div>
  <?php }
   else {?>
    <?php $cover = eram_gallery_page_cover_image($object_id);?>

    <?php $inline_bg = "";?>

    <?php if ($cover['image_url'] != 'none') {?>
      <?php $inline_bg = "background-image:url(".$cover['image_url'].");";?>

    <?php }?>
    <div class="padding-wrapper">
      <div class="gallery-top <?php echo $cover['class'];?>">
        <div class="inner-wrapper" style="<?php echo $inline_bg;?>">
          <div class="tb-vcenter-wrapper">
            <div class="vcenter">
              
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
      </div>
      <div class="gallery-main <?php echo $gal->get_gallery_main_class()?>">
        <div class='em-gallery <?php echo $gal->get_em_gallery_class()?>' <?php echo $gal->get_em_gallery_atts()?>>
        <?php $gal->print_items_loop();?>

        </div>
      </div>
    </div>
  <?php }?>
</div>
<?php if (Eram_kirki::get_option('eram_theme_options','eram_footer_for_galleries',0) == 1) {?>
  
  <?php eram_footer();?>

<?php }?>