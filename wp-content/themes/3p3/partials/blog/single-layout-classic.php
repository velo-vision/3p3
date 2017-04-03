<?php $has_sidebar = eram_get_blog_option('eram_post_show_sidebar','no-sidebar',get_the_ID());?>

<?php if ($has_sidebar == 'no-sidebar') {?>
  <?php $has_sidebar = FALSE;?>

<?php }
 else {?>
  <?php $selected_sidebar = $has_sidebar;?>

  <?php set_query_var( 'selected_sidebar', $selected_sidebar );?>

  <?php $has_sidebar = TRUE;?>

<?php }?>
<div class="em-single-post layout-classic <?php echo $has_sidebar?'with-sidebar':'no-sidebar slim-container';?>">
  <div class="container">
    <div class="post-wrapper">
      <?php while (have_posts()) {?>

        <?php the_post()?>

        <div class="post em-blog-post layout-classic">
          <?php $format = eram_get_single_meta('eram_ps_format','standard');?>

          <?php get_template_part( 'partials/blog/format', $format );?>

          <?php if ($format != 'aside' && $format != 'quote') {?>
            <?php $show_date=intval(Eram_Kirki::get_option('eram_theme_options', 'eram_post_show_date'));?>

          <?php }?>
          <div class="post-contents <?php echo $show_date ? '' : 'no-date'; ?>">
            <?php if (isset($show_date) ? $show_date : false) {?>
              <div class="post-date">
                <?php eram_format_date();?>

              </div>
            <?php }?>
            <div class="meta-data">
              <h3 class="title">
                <?php the_title()?>

              </h3>
              <ul class="meta">
                <?php if (Eram_Kirki::get_option('eram_theme_options', 'eram_post_show_author')) {?>
                  <li class="author">
                    <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' ));?>">
                      <?php the_author()?>

                    </a>
                  </li>
                <?php }?>
                <?php if (Eram_Kirki::get_option('eram_theme_options', 'eram_post_show_categories')) {?>
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
            </div>
            <div class="clearfix"></div>
            <div class="the-content">
              <?php the_content();?>

              <?php if (intval(Eram_Kirki::get_option('eram_theme_options', 'eram_post_show_tags', 1)) && has_tag()) {?>
                <div class="post-tags">
                  <?php echo get_the_tag_list('<p>'. esc_html__('Tags: ','eram'),', ','</p>');?>

                </div>
              <?php }?>
              <?php eram_link_pages();?>

            </div>
          </div>
        </div>
        <!-- about author -->
        
        <?php $authordesc = get_the_author_meta( 'description' );?>

        <?php $show_author = Eram_Kirki::get_option('eram_theme_options', 'eram_post_show_author_bio', 1);?>

        <?php if (! empty($authordesc) && $show_author == 1) {?>
          <div class="author-bio">
            <?php $author_id = get_the_author_meta( 'ID' );?>

            <?php $author_link = get_author_posts_url($author_id);?>

            <a class="avatar-wrapper" href="<?php echo $author_link;?>">
              <?php echo get_avatar( $author_id , 120, '', get_the_author_meta( 'name' ));?>

            </a>
            <div class="author-bio-content">
              <h4>
                <a href="<?php echo $author_link;?>">
                  <?php the_author()?>

                </a>
              </h4>
              <div>
                <?php echo get_the_author_meta('description');?>

              </div>
              <?php eram_show_user_contact_info();?>

            </div>
          </div>
        <?php }?>
        <!-- next/prev links -->
        
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

              <?php if (has_post_thumbnail($prev_post)) {?>
                <?php $class = 'has-bg';?>

                <?php $featured_img = 'url('. get_the_post_thumbnail_url( $prev_post->ID, "large" ) .')';?>

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

              <?php if (has_post_thumbnail($next_post)) {?>
                <?php $class = 'has-bg';?>

                <?php $featured_img = 'url('. get_the_post_thumbnail_url( $next_post->ID, "large" ) .')';?>

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
        <?php if (comments_open() || get_comments_number()) {?>
          <div class="post-comments slim-container">
            <?php comments_template();?>

          </div>
        <?php }?>
      <?php }?>

    </div>
    <?php if (isset($has_sidebar) ? $has_sidebar : false) {?>
      <?php get_template_part('sidebar');?>

    <?php }?>
  </div>
</div>
<?php if (Eram_kirki::get_option('eram_theme_options','eram_footer_for_blog',0) == 1) {?>
  
  <?php eram_footer();?>

<?php }?>