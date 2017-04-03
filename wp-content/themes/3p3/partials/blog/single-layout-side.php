<div class="page layout-header-side em-single-post <?php echo join( ' ', get_post_class() );?>" id="post-<?php the_ID(); ?>">
  <?php while (have_posts()) {?>

    <?php the_post();?>

    <div class="page-side layout-vertical-padding">
      <div class="inner">
        <?php $bg_wrapper_class = 'no-cover';?>

        <?php $featured_image_url='';?>

        <?php if (has_post_thumbnail()) {?>
          <?php global $post;?>

          <?php $bg_wrapper_class = '';?>

          <?php $featured_image_url = "background-image:url('" . get_the_post_thumbnail_url($post,'full') . "')";?>

        <?php }?>
        <div class="bg-wrapper <?php echo $bg_wrapper_class;?>" style="<?php echo $featured_image_url;?>"></div>
        <div class="side-contents">
          <?php if (intval(Eram_Kirki::get_option('eram_theme_options', 'eram_post_show_date'))) {?>
            <span class="date">
              <?php esc_html_e('On','eram')?>

              <?php the_date()?>

            </span>
          <?php }?>
          <?php if (intval(Eram_Kirki::get_option('eram_theme_options', 'eram_post_show_categories', 1))) {?>
            <?php $categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'eram' ) );?>

            <span class="cats">
              <?php esc_html_e('In','eram')?>

              <?php echo $categories_list;?>

            </span>
          <?php }?>
          <h1 class="title">
            <?php the_title();?>

          </h1>
          <?php $show_author = intval(Eram_Kirki::get_option('eram_theme_options','eram_post_show_author',1));?>

          <?php $author_posts_link = get_author_posts_url(get_the_author_meta( 'ID' ))?>

          <?php if (isset($show_author) ? $show_author : false) {?>
            <a class="avatar-wrapper" href="<?php echo $author_posts_link ;?>">
              <?php echo get_avatar( get_the_author_meta( 'ID' ), 120, '', get_the_author_meta( 'name' ));?>

              <span class="author">
                <?php the_author()?>

              </span>
            </a>
          <?php }?>
        </div>
      </div>
    </div>
    <div class="page-main">
      <div class="page-contents post-body">
        <?php $format = eram_get_single_meta('eram_ps_format','standard');?>

        <?php get_template_part( 'partials/blog/single-format', $format );?>

        <?php if ($format != 'aside') {?>
          <div class="the-content">
            <?php the_content();?>

          </div>
        <?php }?>
        <?php if (intval(Eram_Kirki::get_option('eram_theme_options', 'eram_post_show_tags', 1)) && has_tag()) {?>
          <div class="post-tags">
            <?php echo get_the_tag_list('<p>'.esc_html__('Tags: ','eram'),', ','</p>');?>

          </div>
        <?php }?>
        <?php eram_link_pages();?>

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
      </div>
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
      <?php if (Eram_kirki::get_option('eram_theme_options','eram_footer_for_blog',0) == 1) {?>
        
        <?php eram_footer();?>

      <?php }?>
    </div>
  <?php }?>

</div>