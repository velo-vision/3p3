<?php
/**
 * The template for displaying list of all portfolio items
 *
 * @package Eram
 */
?>

<?php get_header();?>


<?php $object_id = '';?>

<?php $portfolio = portfolio_helper('');?>

<?php set_query_var( 'portfolio', $portfolio );?>

<?php set_query_var( 'object_id', $object_id );?>

<?php $portfolio_layout = epf_get_option('epf_archive_layout', 'v_grid');?>

<div id="main-area" class="layout-padding <?php echo $portfolio->get_main_area_class();?>">
  <?php if (have_posts()) {?>
    <?php if ($portfolio_layout == 'minimal') {?>
      <?php get_template_part('partials/portfolio/archive-minimal');?>

    <?php }
     else {?>
      <?php get_template_part('partials/portfolio/archive');?>

    <?php }?>
  <?php }
   else {?>
    <?php get_template_part( 'content', 'none' );?>

  <?php }?>
</div>
<!-- social-sharing -->
<?php $show_socials = epf_get_option( 'epf_social_share', FALSE, $object_id);?>

<?php if ($show_socials == 1) {?>
  <?php get_template_part('partials/social-sharing');?>

<?php }?>

<?php get_footer();?>