<?php while (have_posts()) {?>

  <?php the_post()?>

  <?php $post_class = implode( ' ', get_post_class() );?>

  <div class="post em-blog-post layout-classic <?php echo $post_class;?>">
    <?php $format = eram_get_single_meta('eram_ps_format','standard');?>

    <?php get_template_part( 'partials/blog/format', $format );?>

    <?php if ($format != 'aside' && $format != 'quote') {?>
      <?php $show_date=intval(Eram_Kirki::get_option('eram_theme_options', 'eram_blog_show_date'));?>

      <div class="post-contents <?php echo $show_date ? '' : 'no-date'; ?>">
        <?php if (isset($show_date) ? $show_date : false) {?>
          <div class="post-date">
            <?php eram_format_date();?>

          </div>
        <?php }?>
        <div class="meta-data">
          <h3 class="title">
            <a href="<?php the_permalink();?>">
              <?php the_title()?>

            </a>
          </h3>
          <ul class="meta">
            <?php if (Eram_Kirki::get_option('eram_theme_options','eram_blog_show_author')) {?>
              <li class="author">
                <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' ));?>">
                  <?php the_author()?>

                </a>
              </li>
            <?php }?>
            <?php if (Eram_Kirki::get_option('eram_theme_options','eram_blog_show_categories')) {?>
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
          <?php if (Eram_Kirki::get_option('eram_theme_options','eram_blog_show_excerpt')) {?>
            <div class="post-excerpt">
              <?php the_excerpt();?>

            </div>
          <?php }?>
          <?php if (Eram_Kirki::get_option('eram_theme_options','eram_blog_show_read_more')) {?>
            <a class="read-more" href="<?php the_permalink();?>">
              <span>
                <?php esc_html_e('Read More', 'eram')?>

              </span>
            </a>
          <?php }?>
        </div>
      </div>
    <?php }?>
  </div>
<?php }?>