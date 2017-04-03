<div class="page layout-blank single-eramfolio <?php echo join( ' ', get_post_class() );?>" id="post-<?php the_ID(); ?>">
  <div class="page-main">
    <div class="page-contents post-body">
      <?php get_template_part( 'partials/portfolio/single-content' );?>

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
</div>
<?php if (Eram_kirki::get_option('eram_theme_options','eram_footer_for_portfolios',0) == 1) {?>
  
  <?php eram_footer();?>

<?php }?>