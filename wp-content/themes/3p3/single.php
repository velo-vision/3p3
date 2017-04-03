<?php
/**
 * The template for displaying Single Blog posts
 *
 * @package Eram
 */
?>

<?php get_header();?>


<?php $is_protected = post_password_required();?>

<?php $layout = eram_get_customizer_single_option('eram_post_layout','modern');?>

<div id="main-area" class="layout-padding <?php echo $is_protected ? 'full-screen' : '';?>">
  <?php if (isset($is_protected) ? $is_protected : false) {?>
    <?php get_template_part( 'content', 'protected' );?>

  <?php }
   else {?>
    <?php if (have_posts()) {?>
      <?php get_template_part('partials/blog/single-layout',$layout);?>

    <?php }
     else {?>
      <?php get_template_part( 'content', 'none' );?>

    <?php }?>
  <?php }?>
</div>

<?php get_footer();?>