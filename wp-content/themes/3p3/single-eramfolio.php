<?php
/**
 * The template for displaying portfolio Single post.
 *
 * @package Eram
 */
?>

<?php get_header();?>


<?php if (have_posts()) {?>
  <?php while (have_posts()) {?>

    <?php the_post();?>

    <div id="main-area" class="layout-padding">
      <?php if (post_password_required()) {?>
        <?php get_template_part( 'content', 'protected' );?>

      <?php }
       else {?>
        <?php $layout = get_post_meta(get_the_ID(),'_epf_layout',true);?>

        <?php get_template_part( 'partials/portfolio/single', $layout );?>

      <?php }?>
    </div>
    <!-- social-sharing -->
    <?php $show_socials = ERAM_Kirki::get_option('eram_theme_options','epf_enable_sharing',1 );?>

    <?php if (isset($show_socials) ? $show_socials : false) {?>
      <?php get_template_part('partials/social-sharing');?>

    <?php }?>
  <?php }?>

<?php }?>

<?php get_footer();?>