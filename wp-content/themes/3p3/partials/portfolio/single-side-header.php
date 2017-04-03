<div class="page layout-header-side single-eramfolio <?php echo join( ' ', get_post_class() );?>" id="post-<?php the_ID(); ?>">
  <?php $metas = eram_get_post_meta();?>

  <?php $cover_type = eram_page_meta('_epf_cover_type',$metas,'image');?>

  <?php $bg_wrapper_class = 'no-cover';?>

  <?php $side_class = '';?>

  <?php $featured_image_url='';?>

  <?php $video_url = "";?>

  <?php $video_poster = "";?>

  <?php $has_cover = eram_portfolio_has_cover(get_the_ID());?>

  <?php if (! $has_cover) {?>
    <?php $side_class = 'no-cover';?>

  <?php }?>
  <?php $cover_image = eram_portfolio_get_cover_image(get_the_ID(),'full',true);?>

  <?php if ($has_cover && $cover_type == 'image') {?>
    <?php $bg_wrapper_class = '';?>

    <?php $featured_image_url = "background-image:url('" . $cover_image . "')";?>

  <?php }?>
  <?php if ($cover_type == 'video') {?>
    <?php $video_url = wp_get_attachment_url(eram_page_meta('_epf_cover_video',$metas,0));?>

    <?php $video_poster = $cover_image;?>

    <?php $bg_wrapper_class = 'owl-videobg autoplay';?>

  <?php }?>
  <div class="page-side layout-vertical-padding <?php echo $side_class;?>">
    <div class="inner">
      <?php if (isset($has_cover) ? $has_cover : false) {?>
        <div class="bg-wrapper <?php echo $bg_wrapper_class;?>" data-src="<?php echo $video_url;?>" data-poster="<?php echo $video_poster;?>" style="<?php echo $featured_image_url;?>"></div>
      <?php }?>
      <div class="side-contents">
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
  <div class="page-main">
    <div class="page-contents post-body">
      <?php get_template_part( 'partials/portfolio/single-content' );?>

    </div>
    <?php if (ERAM_Kirki::get_option('eram_theme_options', 'epf_enable_nav', 1)) {?>
      
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
    <?php if (Eram_kirki::get_option('eram_theme_options','eram_footer_for_portfolios',0) == 1) {?>
      
      <?php eram_footer();?>

    <?php }?>
  </div>
</div>