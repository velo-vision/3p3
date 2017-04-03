<?php $header_class="hvh-50";?>

<?php $header_parallax_mode = "";?>

<?php $content_parallax_mode = "";?>

<?php $content_class = "";?>

<?php $has_parallax = Eram_Kirki::get_option('eram_theme_options','eram_has_parallax',true);?>

<?php $inline_styles="";?>

<?php if (has_post_thumbnail()) {?>
  <?php $cover_image= get_the_post_thumbnail_url();?>

  <?php if (isset($has_parallax) ? $has_parallax : false) {?>
    <?php $header_class="hvh-50 parallax-layer has-cover ov-dark-alpha-30";?>

    <?php $header_parallax_mode = "";?>

    <?php $content_parallax_mode = "mode-header-content";?>

    <?php $content_class = "parallax-layer";?>

  <?php }
   else {?>
    <?php $header_class="hvh-50 has-cover ov-dark-alpha-30";?>

    <?php $header_parallax_mode = "";?>

    <?php $content_parallax_mode = "";?>

    <?php $content_class = "";?>

    <?php $inline_styles="background-image:url(" . $cover_image . ");";?>

  <?php }?>
<?php }?>
<div class="page-head proof-header <?php echo $header_class; ?>" data-img-src="<?php echo esc_url($cover_image); ?>" data-parallax-mode="<?php echo $header_parallax_mode; ?>" style="<?php echo $inline_styles;?>">
  <div class="tb-vcenter-wrapper">
    <div class="title-wrapper vcenter <?php echo $content_class; ?>" data-parallax-mode="<?php echo $content_parallax_mode; ?>">
      <h1 class="title">
        <?php the_title();?>

      </h1>
    </div>
  </div>
  <?php $gal_date = eg_get_proof_gallery_option('_epg_event_date','',get_the_ID());?>

  <?php if ($gal_date != '') {?>
    <?php $gal_date = date(get_option( 'date_format' ),(strtotime($gal_date)));?>

    <div class="proof-date">
      <span>
        <?php echo $gal_date;?>

      </span>
    </div>
  <?php }?>
  <?php $download = eg_get_proof_gallery_option('_epg_download_file','',get_the_ID());?>

  <?php if ($download != '') {?>
    <a class="btn btn-skin-dark proof-download" href="<?php echo esc_url($download);?>" download>
      <span>
        <?php esc_html_e('Download','eram')?>

        <i class="ol ol-download_2"></i>
      </span>
    </a>
  <?php }?>
</div>
<div class="page-contents">

  <div class="em-sticky-wrapper">
    <div class="sticky-anchor"></div>
    <div class="sticky-elem em-proof-bar">
      <?php $accepted_photos = $gal->get_accepted_photos();?>

      <?php $accepted_photos_array = $gal->get_accepted_photos_array();?>

      <div class="inner">
        <div class="statistics">
          <h3>
            <?php esc_html_e('Selected','eram')?>

            <span class="accepted-count" id="em-counter">
              <?php echo count($accepted_photos_array);?>

            </span>
            <?php esc_html_e('of total','eram')?>

            <span class="total-count">
              <?php echo count($gal->gallery_image_ids);?>

            </span>
            <?php esc_html_e('Photos','eram')?>

          </h3>
        </div>
        <div class="info">
          <div id="feedback" class="layout-margin">
            <div class="message"></div>
          </div>
          <div class="submission">
            <form class="proofing-submission" mothod="get" action="#">
              <input type="hidden" id="accepted-photos" name="accepted-photos" value="<?php echo $accepted_photos;?>">
              <input class="btn btn-default" type="submit" value="<?php esc_html_e('Submit Selected items','eram');?>" name="submit">
            </form>
          </div>
        </div>
        <div class="filter">
          <span class="filter-lable">
            <?php esc_html_e('filter by:','eram');?>

          </span>
          <ul class="grid-filters">
            <li>
              <a class="active" data-filter="*" href="#">
                <?php esc_html_e('All','eram');?>

              </a>
            </li>
            <li>
              <a data-filter=".em-accepted" href="#">
                <?php esc_html_e('Accepted','eram');?>

              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="gallery-wrapper <?php echo $gal->get_gallery_wrapper_class()?>">
    <div class="gallery-main <?php echo $gal->get_gallery_main_class()?>">
      <div class="em-gallery <?php echo $gal->get_em_gallery_class()?>" <?php echo $gal->get_em_gallery_atts()?>>
        <?php $gal->print_items_loop();?>

      </div>
    </div>
  </div>
  <div class="content-wrapper slim-container">
    <div class="container">
      <?php the_content();?>

    </div>
  </div>
  <?php if (comments_open() || get_comments_number()) {?>
    <div class="gallery-comments slim-container">
      <div class="container">
        <?php comments_template();?>

      </div>
    </div>
  <?php }?>
</div>
<?php if (Eram_kirki::get_option('eram_theme_options','eram_footer_for_proof_galleries',0) == 1) {?>

  <?php eram_footer();?>

<?php }?>
