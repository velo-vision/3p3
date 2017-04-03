<div class="em-single-post single-eramfolio">
  <?php $metas = eram_get_post_meta();?>

  <?php $header_class="";?>

  <?php $header_parallax_mode = "";?>

  <?php $content_parallax_mode = "";?>

  <?php $content_class = "";?>

  <?php $cover_image="";?>

  <?php $video_url ="";?>

  <?php $video_poster = "";?>

  <?php $has_cover = eram_has('_epf_cover_image',$metas,0);?>

  <?php $cover_image = wp_get_attachment_url( eram_page_meta('_epf_cover_image',$metas,0));?>

  <?php $cover_type = eram_page_meta('_epf_cover_type',$metas,'image');?>

  <?php $has_parallax = Eram_Kirki::get_option('eram_theme_options','eram_has_parallax',true);?>

  <?php $inline_styles="";?>

  <?php $header_hvh = "hvh-". intval(Eram_Kirki::get_option('eram_theme_options','eram_top_header_height',60) );?>

  <?php if ($has_cover & $cover_type=='image') {?>
    <?php if (isset($has_parallax) ? $has_parallax : false) {?>
      <?php $header_class="parallax-layer has-cover ov-dark-alpha-50 ". $header_hvh;?>

      <?php $content_class = "parallax-layer";?>

      <?php $header_parallax_mode = "";?>

      <?php $content_parallax_mode = "mode-header-content";?>

    <?php }
     else {?>
      <?php $header_class="has-cover ov-dark-alpha-50 ". $header_hvh;?>

      <?php $inline_styles="background-image:url(" . $cover_image . ");";?>

    <?php }?>
  <?php }?>
  <?php if ($cover_type=='video') {?>
    <?php if (isset($has_parallax) ? $has_parallax : false) {?>
      <?php $header_class = "has-cover ov-dark-alpha-50 owl-videobg autoplay ". $header_hvh;?>

      <?php $content_class = "parallax-layer";?>

      <?php $content_parallax_mode = "mode-header-content";?>

    <?php }
     else {?>
      <?php $header_class="has-cover ov-dark-alpha-50 owl-videobg autoplay ". $header_hvh;?>

    <?php }?>
    <?php $video_url = wp_get_attachment_url(eram_page_meta('_epf_cover_video',$metas,0));?>

    <?php $video_poster = $cover_image;?>

  <?php }?>
  <div class="page-head layout-center <?php echo $header_class; ?>" data-img-src="<?php echo $cover_image; ?>" data-parallax-mode="<?php echo $header_parallax_mode; ?>" data-src="<?php echo $video_url;?>" data-poster="<?php echo $video_poster;?>" style="<?php echo $inline_styles;?>">
    <div class="tb-vcenter-wrapper">
      <div class="title-wrapper vcenter <?php echo $content_class; ?>" data-parallax-mode="<?php echo $content_parallax_mode; ?>">
        <div class="cats">
          <?php echo get_the_term_list( get_the_ID(), ERAM_FOLIO_TAX_NAME, '', ', ' );?>

        </div>
        <h1 class="title">
          <?php the_title();?>

        </h1>
        <div class="description">
          <?php echo eram_page_meta('_epf_short_desc',$metas,'');?>

        </div>
      </div>
    </div>
  </div>
  <?php $content_type = eram_page_meta('_epf_content_type',$metas,'container');?>

  <?php $container_class = 'container';?>

  <?php $page_contents_class='';?>

  <?php $vc_enabled = get_post_meta(get_the_ID(), '_wpb_vc_js_status', true);?>

  <?php if ($content_type =='slim-container') {?>
    <?php $container_class = $vc_enabled=="true" ? '' : 'container';?>

    <?php $page_contents_class='slim-container';?>

  <?php }
  elseif ($content_type =='full-width') {?>
    <?php $container_class = '';?>

    <?php $page_contents_class='';?>

  <?php }
   else {?>
    <?php $container_class = $vc_enabled=="true" ? '' : 'container';?>

    <?php $page_contents_class='';?>

  <?php }?>
  <div class="page-contents <?php echo $page_contents_class;?>">
    <div class="post-body <?php echo $container_class;?>">
      <?php get_template_part( 'partials/portfolio/single-content' );?>

    </div>
  </div>
  <?php if (ERAM_Kirki::get_option('eram_theme_options','epf_enable_nav',1)) {?>
    
    <?php $next_post = get_next_post();?>

    <?php $prev_post = get_previous_post();?>

    <?php if ($next_post || $prev_post) {?>
      <?php $nav_class='';?>

      <?php if (!$prev_post || !$next_post) {?>
        <?php $nav_class="no-sibling";?>

      <?php }?>
      <nav class="navigation next-prev post <?php echo $nav_class;?>">
        <?php if (isset($prev_post) ? $prev_post : false) {?>
          <?php $class = '';?>

          <?php $featured_img = 'none';?>

          <?php if (eram_portfolio_has_featured_or_cover($prev_post)) {?>
            <?php $class = 'has-bg';?>

            <?php $featured_img = 'url('. eram_portfolio_get_featured_image( $prev_post->ID, "large", true ) .')';?>

          <?php }?>
          <div class="prev <?php echo $class;?>" style="background-image:<?php echo $featured_img;?>;">
            <a href="<?php echo get_permalink($prev_post);?>">
              <span>
                <?php esc_html_e('Previous', 'eram');?>

              </span>
              <?php echo esc_html($prev_post->post_title)?>

            </a>
          </div>
        <?php }?>
        <?php if (isset($next_post) ? $next_post : false) {?>
          <?php $class = '';?>

          <?php $featured_img = 'none';?>

          <?php if (eram_portfolio_has_featured_or_cover($next_post)) {?>
            <?php $class = 'has-bg';?>

            <?php $featured_img = 'url('. eram_portfolio_get_featured_image( $next_post->ID, "large", true ) .')';?>

          <?php }?>
          <div class="next <?php echo $class;?>" style="background-image:<?php echo $featured_img;?>;">
            <a href="<?php echo get_permalink($next_post);?>">
              <span>
                <?php esc_html_e('Next', 'eram');?>

              </span>
              <?php echo esc_html($next_post->post_title)?>

            </a>
          </div>
        <?php }?>
      </nav>
    <?php }?>
  <?php }?>
</div>
<?php if (Eram_kirki::get_option('eram_theme_options','eram_footer_for_portfolios',0) == 1) {?>
  
  <?php eram_footer();?>

<?php }?>