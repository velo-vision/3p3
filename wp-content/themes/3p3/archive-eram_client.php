<?php
/**
 * The template for displaying list of clients
 *
 * @package Eram
 */
?>

<?php get_header();?>


<div id="main-area" class="layout-padding">
  <?php $has_archive = Eram_Kirki::get_option('eg_settings','ec_has_archive',TRUE);?>

  <?php if (isset($has_archive) ? $has_archive : false) {?>
    <?php get_template_part( 'partials/client/archive' );?>

  <?php }
   else {?>
    <?php get_template_part( 'content', 'none' );?>

  <?php }?>
</div>

<?php get_footer();?>
