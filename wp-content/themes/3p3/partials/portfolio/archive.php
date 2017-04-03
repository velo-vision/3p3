<div class="gallery-wrapper gallery-page-title-top <?php echo $portfolio->get_gallery_wrapper_class()?>">
  <?php $show_header = epf_get_option('epf_has_details',FALSE,$object_id);?>

  <?php if (isset($show_header) ? $show_header : false) {?>
    <?php $header_class="";?>

    <?php $header_parallax_mode = "";?>

    <?php $content_parallax_mode = "";?>

    <?php $content_class = "";?>

    <?php $cover_image="";?>

    <?php $has_parallax = Eram_Kirki::get_option('eram_theme_options','eram_has_parallax',true);?>

    <?php $inline_styles="";?>

    <?php $header_hvh = "hvh-". intval(Eram_Kirki::get_option('eram_theme_options','eram_top_header_height',60) );?>

    <?php if (is_archive()) {?>
      <?php $cover_image = epf_get_option('epf_archive_cover','',$object_id);?>

      <?php $has_cover = $cover_image==''?FALSE:TRUE;?>

    <?php }
     else {?>
      <?php $has_cover = eram_portfolio_has_cover($object_id);?>

      <?php $cover_image = eram_portfolio_get_cover_image($object_id,'full',true);?>

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
              <?php echo esc_html(epf_get_option( 'epf_page_title', 'Portfolio Title',''))?>

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
              <?php echo term_description()?>

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
      <?php if (! is_tax()) {?>
        <?php $filter_by = epf_get_option('epf_filter_by', 'efcategory');?>

        <?php $gal_layout = epf_get_option('epf_archive_layout', 'v_grid');?>

        <?php if ($filter_by != 'none' && $gal_layout != 'justified') {?>
          <div id="portfolio-filters">
            <?php if ($filter_by == 'efcategory') {?>
              <div class="portfolio-cats">
                <ul>
                  <li data-filter="*" class="active">
                    <a href="#">
                      <?php esc_html_e('All','eram');?>

                    </a>
                  </li>
                  <?php wp_list_categories( array( 'show_count'=> false, 'hierarchical'=>false, 'taxonomy'=>ERAM_FOLIO_TAX_NAME, 'title_li'=>'', 'walker' => new eram_Walker_Category) );?>

                </ul>
              </div>
            <?php }
             else {?>
              <?php echo eram_list_meta_values($filter_by,ERAM_FOLIO_CPT_NAME,false);?>

            <?php }?>
          </div>
        <?php }?>
      <?php }?>
    </div>
  <?php }?>
  <div class="gallery-main <?php echo $portfolio->get_gallery_main_class()?>">
    <div class='em-gallery <?php echo $portfolio->get_em_gallery_class()?>' <?php echo $portfolio->get_em_gallery_atts()?>>
    <?php $portfolio->print_items_loop();?>

    </div>
  </div>
</div>
<?php if (Eram_kirki::get_option('eram_theme_options','eram_footer_for_portfolios',0) == 1) {?>
  
  <?php eram_footer();?>

<?php }?>