<?php while (have_posts()) {?>

  <?php the_post()?>

  <?php $format = eram_get_single_meta('eram_ps_format','standard');?>

  <?php $post_class = implode( ' ', get_post_class() );?>

  <div class="post em-blog-post layout-masonry <?php echo $post_class;?>">
    <?php get_template_part( 'partials/blog/format', $format );?>

    <?php if ($format != 'aside' && $format != 'quote') {?>
      <div class="post-contents">
        <h3 class="title">
          <a href="<?php the_permalink();?>">
            <?php the_title()?>

          </a>
        </h3>
        <ul class="meta">
          <?php if (Eram_Kirki::get_option('eram_theme_options', 'eram_blog_show_author')) {?>
            <li class="author">
              <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' ));?>">
                <?php the_author()?>

              </a>
            </li>
          <?php }?>
          <?php $show_date=intval(Eram_Kirki::get_option('eram_theme_options', 'eram_blog_show_date'));?>

          <?php if (isset($show_date) ? $show_date : false) {?>
            <li class="post-date">
              <span>
                <?php echo get_the_date()?>

              </span>
            </li>
          <?php }?>
          <?php if (Eram_Kirki::get_option('eram_theme_options', 'eram_blog_show_categories')) {?>
            <?php eram_inline_post_cats();?>

          <?php }?>
        </ul>
        <?php if (Eram_Kirki::get_option('eram_theme_options', 'eram_blog_show_excerpt')) {?>
          <div class="post-excerpt">
            <?php echo get_the_excerpt();?>

          </div>
        <?php }?>
        <?php if (Eram_Kirki::get_option('eram_theme_options', 'eram_blog_show_read_more')) {?>
          <a class="read-more" href="<?php the_permalink();?>">
            <span>
              <?php esc_html_e('Read More', 'eram');?>

            </span>
          </a>
        <?php }?>
      </div>
    <?php }?>
  </div>
<?php }?>