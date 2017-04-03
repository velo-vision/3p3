<?php while (have_posts()) {?>

  <?php the_post()?>

  <?php $class = '';?>

  <?php $featured_img = 'none';?>

  <?php if (has_post_thumbnail()) {?>
    <?php $class = 'has-bg';?>

    <?php $featured_img = 'url('. get_the_post_thumbnail_url( get_the_ID(), "large" ) .')';?>

  <?php }?>
  <?php $post_class = implode( ' ', get_post_class($class) );?>

  <div class="post em-blog-post layout-minimal <?php echo $post_class;?>">
    <?php if (has_post_thumbnail()) {?>
      <div class="post-bg" style="background-image:<?php echo $featured_img;?>;"></div>
    <?php }?>
    <?php $format = eram_get_single_meta('eram_ps_format','standard');?>

    <?php if ($format != 'aside' && $format != 'quote') {?>
      <div class="tb-vcenter-wrapper">
        <div class="vcenter">
          <div class="post-contents">
            <ul class="categories">
              <?php if (Eram_Kirki::get_option('eram_theme_options', 'eram_blog_show_categories', true)) {?>
                <?php $categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'eram' ) );?>
<?php if (isset($categories_list) ? $categories_list : false) {?>
                    <?php printf( '<li class="cats"><span class="screen-reader-text">%1$s </span>%2$s</li>',
                      _x( 'Categories', 'Used before category names.', 'eram' ),
                      $categories_list
                      );
                    ?>
                  <?php }?>
              <?php }?>
            </ul>
            <h3 class="title">
              <a href="<?php the_permalink();?>">
                <?php the_title()?>

              </a>
            </h3>
            <ul class="meta-data">
              <?php if (Eram_Kirki::get_option('eram_theme_options','eram_blog_show_author',true)) {?>
                <li class="author">
                  <?php esc_html_e('By','eram')?>

                  <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' ));?>">
                    <?php the_author()?>

                  </a>
                </li>
              <?php }?>
              <?php $show_date=intval(Eram_Kirki::get_option('eram_theme_options', 'eram_blog_show_date',true));?>

              <?php if (isset($show_date) ? $show_date : false) {?>
                <li class="post-date">
                  <?php echo get_the_date();?>

                </li>
              <?php }?>
            </ul>
          </div>
        </div>
      </div>
    <?php }
    elseif ($format == 'quote') {?>
      <div class="post-contents">
        <?php $quote_text = eram_get_single_meta('eram_ps_quote_text','') ;?>

        <blockquote class="quote-text">
          <p>
            <?php echo esc_html($quote_text)?>

          </p>
          <footer class="quote-author">
            <cite>
              <?php echo esc_html(eram_get_single_meta('eram_ps_quote_author',''));?>

            </cite>
          </footer>
        </blockquote>
      </div>
    <?php }
    elseif ($format == 'aside') {?>
      <div class="post-contents format-aside">
        <div>
          <?php echo get_the_content();?>

        </div>
      </div>
    <?php }?>
  </div>
<?php }?>


<?php $prev_link = get_previous_posts_link(esc_html__('Newer Posts','eram'));?>

<?php $next_link = get_next_posts_link(esc_html__('Older Posts','eram'));?>

<?php if ($prev_link || $next_link) {?>
  <?php $nav_class='';?>

  <?php if (! $prev_link || ! $next_link) {?>
    <?php $nav_class="no-sibling";?>

  <?php }?>
  <nav class="navigation next-prev <?php echo $nav_class;?>">
    <?php if (isset($prev_link) ? $prev_link : false) {?>
      <div class="prev">
        <?php echo $prev_link?>

      </div>
    <?php }?>
    <?php if (isset($next_link) ? $next_link : false) {?>
      <div class="next">
        <?php echo $next_link?>

      </div>
    <?php }?>
  </nav>
<?php }?>