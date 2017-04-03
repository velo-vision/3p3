<?php
/**
 * The template for displaying single proof gallery item
 *
 * @package Eram
 */
?>

<?php get_header();?>


<?php if (have_posts()) {?>
  <?php while (have_posts()) {?>

    <?php the_post();?>

    <?php $object_id = get_the_ID();?>

    <?php $gal = proof_gallery_helper($object_id);?>

    <?php set_query_var( 'gal', $gal );?>

    <?php set_query_var( 'object_id', $object_id );?>

    <?php $is_protected = post_password_required();?>

    <div id="main-area" class="layout-padding <?php echo $gal->get_main_area_class(); echo $is_protected ? 'full-screen' : '';?>">
      <?php if (post_password_required()) {?>
        <?php get_template_part( 'content', 'protected' );?>

      <?php }
       else {?>
        <?php do_action( 'eram_proof_gallery_before' );?>

        <?php get_template_part('partials/proofgallery/single');?>

        <?php do_action( 'eram_proof_gallery_after' );?>

      <?php }?>
    </div>
  <?php }?>

<?php }?>

<?php get_footer();?>