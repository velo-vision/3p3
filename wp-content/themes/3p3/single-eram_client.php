<?php
/**
 * The template for displaying single client page
 *
 * @package Eram
 */
?>

<?php get_header();?>


<?php if (have_posts()) {?>
  <?php while (have_posts()) {?>

    <?php the_post();?>

    <?php $object_id = get_the_ID();?>

    <?php $gal = client_gallery_helper($object_id);?>

    <?php set_query_var( 'gal', $gal );?>

    <?php set_query_var( 'object_id', $object_id );?>

    <?php $is_protected = post_password_required();?>

    <div id="main-area" class="layout-padding <?php echo $gal->get_main_area_class(); echo $is_protected ? 'full-screen' : '';?>">
      <?php if (isset($is_protected) ? $is_protected : false) {?>
        <?php get_template_part( 'partials/client/single', 'protected' );?>

      <?php }
       else {?>
        <?php do_action( 'eram_client_gallery_before' );?>

        <?php get_template_part('partials/client/single')?>

        <?php do_action( 'eram_client_gallery_after' );?>

      <?php }?>
    </div>
  <?php }?>

<?php }?>

<?php get_footer();?>