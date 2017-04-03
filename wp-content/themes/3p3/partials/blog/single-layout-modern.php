<?php $show_author = intval(Eram_Kirki::get_option('eram_theme_options','eram_post_show_author',1));?>

<?php $author_class = '';?>

<?php if (!$show_author) {?>
  <?php $author_class = 'no-author';?>

<?php }?>
<div class="em-single-post layout-modern <?php echo $author_class;?>">
  <?php while (have_posts()) {?>

    <?php the_post();?>

    <?php $featured_img = '';?>

    <?php $header_hvh = "hvh-". intval(Eram_Kirki::get_option('eram_theme_options','eram_top_header_height',60) );?>

    <?php $page_head_class = 'no-cover hvh-40';?>

    <?php $inline_styles = "";?>

    <?php $title_class = '';?>

    <?php if (has_post_thumbnail()) {?>
      <?php $featured_img = get_the_post_thumbnail_url( get_the_ID(), "large" );?>

      <?php $has_parallax = Eram_Kirki::get_option('eram_theme_options','eram_has_parallax',true);?>

      <?php $page_head_class = "ov-dark-alpha-50 ". $header_hvh;?>

      <?php if (isset($has_parallax) ? $has_parallax : false) {?>
        <?php $page_head_class = "parallax-layer ov-dark-alpha-50 ". $header_hvh;?>

        <?php $title_class = 'parallax-layer';?>

      <?php }
       else {?>
        <?php $inline_styles="background-image:url(" . $featured_img . ");"?>

      <?php }?>
    <?php }?>
    <div class="page-head <?php echo $page_head_class; ?>" data-img-src="<?php echo $featured_img; ?>" data-parallax-mode="" style="<?php echo $inline_styles;?>">
      <div class="tb-vcenter-wrapper">
        <div class="title-wrapper vcenter <?php echo $title_class;?>" data-parallax-mode="mode-header-content" data-anchor-target=".page-head" type="height">
          <?php if (intval(Eram_Kirki::get_option('eram_theme_options','eram_post_show_categories',1))) {?>
            <?php $categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'eram' ) );?>

            <h4 class="head">
              <?php echo $categories_list;?>

            </h4>
          <?php }?>
          <h1 class="title">
            <?php the_title();?>

          </h1>
        </div>
      </div>
    </div>
    <div class="post-contents slim-container">
      <?php $vc_enabled = get_post_meta(get_the_ID(), '_wpb_vc_js_status', true);?>

      <?php $vc_enabled = ( $vc_enabled === 'true');?>

      <?php $container_class = "";?>

      <?php if (! $vc_enabled) {?>
        <?php $container_class = 'container';?>

      <?php }?>
      <div class="<?php echo $container_class;?>">
        <div class="post-metas center-meta">
          <?php $author_posts_link = get_author_posts_url(get_the_author_meta( 'ID' ));?>

          <?php if (isset($show_author) ? $show_author : false) {?>
            <a class="avatar-wrapper" href="<?php echo $author_posts_link ;?>">
              <?php echo get_avatar( get_the_author_meta( 'ID' ), 120, '', get_the_author_meta( 'name' ));?>

            </a>
          <?php }?>
          <ul class="meta">
            <?php if (isset($show_author) ? $show_author : false) {?>
              <li class="author">
                <?php esc_html_e('by','eram')?>

                <a href="<?php echo $author_posts_link;?>">
                  <?php the_author()?>

                </a>
              </li>
            <?php }?>
            <?php if (intval(Eram_Kirki::get_option('eram_theme_options', 'eram_post_show_date'))) {?>
              <li class="publish_date">
                <?php esc_html_e('On','eram')?>

                <span class="date">
                  <?php the_date()?>

                </span>
              </li>
            <?php }?>
          </ul>
        </div>
        <?php $format = eram_get_single_meta('eram_ps_format','standard');?>

        <div class="post-body">
          <?php get_template_part( 'partials/blog/single-format', $format );?>

          <?php if ($format != 'aside') {?>
            <div class="the-content">
              <?php the_content();?>

            </div>
          <?php }?>
        </div>
        <div class="post-body container">
          <?php if (intval(Eram_Kirki::get_option('eram_theme_options','eram_post_show_tags',1)) && has_tag()) {?>
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
        <div class="mb-50"></div>
      </div>
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
        <div class="container">
          <?php comments_template();?>

        </div>
      </div>
    <?php }?>
  <?php }?>

</div>
<?php if (Eram_kirki::get_option('eram_theme_options','eram_footer_for_blog',0) == 1) {?>
  
  <?php eram_footer();?>

<?php }?>