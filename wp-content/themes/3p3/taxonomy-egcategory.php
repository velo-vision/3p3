<?php
/**
 * The template for displaying Gallery Category
 *
 * @package Eram
 */
?>

<?php get_header();?>


<?php $object_id = get_queried_object()->slug;?>

<?php $gal = gallery_helper($object_id);?>

<?php set_query_var( 'gal', $gal );?>

<?php set_query_var( 'object_id', $object_id );?>

<?php $layout = eram_get_gallery_page_layout($object_id);?>

<div id="main-area" class="layout-padding <?php echo $gal->get_main_area_class();?>">
  <?php if (have_posts()) {?>
    <?php get_template_part( 'partials/gallery/layout', $layout );?>

  <?php }
   else {?>
    <?php get_template_part( 'content', 'none' );?>

  <?php }?>
</div>
<!-- #main-area -->
<!-- social-sharing -->
<?php $show_socials = eg_get_gallery_option( 'eg_social_share', 'off', $object_id);?>

<?php if ($show_socials == 'on' || $show_socials === true) {?>
  <?php get_template_part('partials/social-sharing');?>

<?php }?>

<?php get_footer();?>