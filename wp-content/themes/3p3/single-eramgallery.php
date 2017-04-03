<?php
/**
 * The template for displaying single gallery item.
 *
 * @package Eram
 */
?>

<?php get_header();?>


<?php if (have_posts()) {?>
  <?php while (have_posts()) {?>

    <?php the_post();?>

    <?php $object_id = get_the_ID();?>

    <?php $gal = gallery_helper($object_id);?>

    <?php set_query_var( 'gal', $gal );?>

    <?php set_query_var( 'object_id', $object_id );?>

    <?php $layout = eram_get_gallery_page_layout($object_id);?>

    <div id="main-area" class="layout-padding <?php echo $gal->get_main_area_class();?>">
      <?php if (post_password_required()) {?>
        <?php get_template_part( 'content', 'protected' );?>

      <?php }
       else {?>
        <?php do_action( 'eram_gallery_before' );?>

        <?php get_template_part('partials/gallery/layout',$layout);?>

        <?php do_action( 'eram_gallery_after' );?>

      <?php }?>
    </div>
  <?php }?>

<?php }?>
<!-- #main-area -->
<!-- social-sharing -->
<?php $show_socials = eg_get_gallery_option( 'eg_social_share', 'off', $object_id);?>

<?php if (isset($show_socials) ? $show_socials : false) {?>
  <?php get_template_part('partials/social-sharing');?>

<?php }?>

<?php get_footer();?>