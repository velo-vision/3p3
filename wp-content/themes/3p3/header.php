<?php
/**
* The header for Eram theme.
* @package Eram
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' )?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head();?>

  </head>
  <body <?php body_class(); ?>><div id="main-wrapper">
      <?php do_action( 'eram_before_header' );?>

      <?php $layout_type = eram_get_site_layout();?>

      <?php get_template_part( 'partials/header', $layout_type );?>

      <?php do_action( 'eram_after_header' );?>