<?php
/**
 * The template for displaying Gallery Archive ( list of all galleries )
 *
 * @package Eram
 */
?>

<?php get_header();?>


<?php $object_id = 'gallery_archive';?>

<?php $gal = gallery_helper('');?>

<?php set_query_var( 'gal', $gal );?>

<?php set_query_var( 'object_id', $object_id );?>

<?php $layout = eram_get_gallery_page_layout($object_id);?>

<div id="main-area" class="layout-padding <?php echo $gal->get_main_area_class();?>">
  <?php if (have_posts()) {?>
    <?php get_template_part('partials/gallery/layout',$layout);?>

  <?php }
   else {?>
    <?php get_template_part( 'content', 'none' );?>

  <?php }?>
</div>
<!-- social-sharing -->
<?php $show_socials = eg_get_gallery_option( 'eg_social_share', 'off', $object_id);?>

<?php if (isset($show_socials) ? $show_socials : false) {?>
  <?php get_template_part('partials/social-sharing');?>

<?php }?>

<?php get_footer();?>