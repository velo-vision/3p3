<?php
/**
 * The template for displaying ordinary pages
 *
 * @package Eram
 */
?>

<?php get_header();?>


<?php $is_protected = post_password_required();?>

<div id="main-area" class="layout-padding <?php echo $is_protected ? 'full-screen' : '';?>">
  <?php if (isset($is_protected) ? $is_protected : false) {?>
    <?php get_template_part( 'content', 'protected' );?>

  <?php }
   else {?>
    <?php while (have_posts()) {?>

      <?php the_post();?>

      <?php do_action( 'eram_page_before' );?>

      <?php $layout = get_post_meta(get_the_ID(), '_ep_layout', true);?>

      <?php $layout = ( empty($layout) ) ? 'default' : $layout;?>

      <?php get_template_part( 'partials/pages/layout', $layout );?>

      <?php do_action( 'eram_page_after' );?>

    <?php }?>

  <?php }?>
</div>

<?php get_footer();?>