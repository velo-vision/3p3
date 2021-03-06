<?php $show_title = eram_get_blog_option('eram_blog_show_title',true);?>

<?php $archive_cover = eram_get_blog_option('eram_blog_archive_cover',false);?>

<?php $has_sidebar = eram_get_blog_option('eram_blog_show_sidebar','no-sidebar');?>

<?php if ($has_sidebar == 'no-sidebar') {?>
  <?php $has_sidebar = FALSE;?>

<?php }
 else {?>
  <?php $selected_sidebar = $has_sidebar;?>

<?php }?>
<?php if (is_home()) {?>
  <?php $archive_title = eram_get_blog_option('eram_blog_archive_title','');?>

  <?php $archive_desc = eram_get_blog_option('eram_blog_archive_description','');?>

<?php }
elseif (is_archive()) {?>
  <?php $archive_title = get_the_archive_title();?>

  <?php $archive_desc = get_the_archive_description();?>

<?php }?>
<?php $has_parallax = Eram_Kirki::get_option('eram_theme_options','eram_has_parallax',true);?>

<?php $header_hvh = "hvh-". intval(Eram_Kirki::get_option('eram_theme_options','eram_top_header_height',60) );?>

<?php $header_class="";?>

<?php $header_parallax_mode = "";?>

<?php $content_parallax_mode = "";?>

<?php $content_class = "";?>

<?php $inline_styles = "";?>

<?php if ($archive_cover != '') {?>
  <?php if (isset($has_parallax) ? $has_parallax : false) {?>
    <?php $header_class="parallax-layer has-cover ov-dark-alpha-50 ". $header_hvh;?>

    <?php $content_class = "parallax-layer";?>

    <?php $header_parallax_mode = "";?>

    <?php $content_parallax_mode = "mode-header-content";?>

  <?php }
   else {?>
    <?php $header_class="has-cover ov-dark-alpha-50 ". $header_hvh;?>

    <?php $inline_styles="background-image:url(" . $archive_cover . ");"?>

  <?php }?>
<?php }?>
<div class="em-blog-wrapper layout-classic <?php echo $has_sidebar?'with-sidebar':'no-sidebar';?>">
  <?php if (isset($show_title) ? $show_title : false) {?>
    <div class="blog-header page-head layout-center <?php echo $header_class; ?>" data-img-src="<?php echo $archive_cover; ?>" data-parallax-mode="<?php echo $header_parallax_mode; ?>" style="<?php echo $inline_styles?>">
      <div class="tb-vcenter-wrapper">
        <div class="title-wrapper vcenter <?php echo $content_class; ?>" data-parallax-mode="<?php echo $content_parallax_mode; ?>">
          <h1 class="title">
            <?php if (is_archive()) {?>
              <span class="upper-title">
                <?php esc_html_e('Archive for', 'eram');?>

              </span>
            <?php }?>
            <?php echo $archive_title?>

          </h1>
          <?php if ($archive_desc != "") {?>
            <div class="description">
              <p>
                <?php echo esc_html($archive_desc)?>

              </p>
            </div>
          <?php }?>
        </div>
      </div>
    </div>
  <?php }?>
  <?php $blog_class = '';?>

  <?php if (! $has_sidebar) {?>
    <?php $blog_class = 'slim-container';?>

  <?php }?>
  <div class="blog-contents <?php echo $blog_class;?>">
    <div class="container">
      <div class="em-blog-posts">
        <?php get_template_part('partials/blog/loop','classic');?>

        <?php the_posts_pagination( array(
          'prev_text'          => '&#8612;',
          'next_text'          => '&#8614;',
          'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'eram' ) . ' </span>',
          ) );
        ?>
      </div>
      <?php if (isset($has_sidebar) ? $has_sidebar : false) {?>
        <?php get_template_part('sidebar');?>

      <?php }?>
    </div>
  </div>
  <?php if (Eram_kirki::get_option('eram_theme_options','eram_footer_for_blog',0) == 1) {?>
    
    <?php eram_footer();?>

  <?php }?>
</div>