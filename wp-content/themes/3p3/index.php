<?php
/**
 * The template for displaying all posts.
 *
 * This is the template that displays all posts by default.
 *
 * @package Eram
 */
?>

<?php get_header();?>


<?php $layout = eram_get_blog_option('eram_blog_archive_layout','minimal');?>

<div id="main-area" class="layout-padding">
  <?php if (have_posts()) {?>
    <?php get_template_part('partials/blog/layout',$layout);?>

  <?php }
   else {?>
    <?php get_template_part( 'content', 'none' );?>

  <?php }?>
</div>

<?php get_footer();?>