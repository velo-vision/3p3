<?php
/**
* The template for displaying 404 pages (not found).
*
* @link https://codex.wordpress.org/Creating_an_Error_404_Page
*
* @package Eram
*/
?>

<?php get_header();?>


<div id="main-area" class="layout-padding full-screen">
  <div class="full-height er-full-bg-page ov-light-alpha-60" style="<?php echo eram_404_inline_style();?>">
    <div class="tb-vcenter-wrapper">
      <div class="vcenter">
        <div class="er-boxed">
          <div class="er-clips"></div>
          <div class="er-clips reverse"></div>
          <div class="er-content text-center">
            <div class="sp-blank-50"></div>
            <h2 class="title">
              <?php echo esc_html(get_theme_mod('eram_404_title','[ 404 ]'))?>

            </h2>
            <div class="description">
              <?php echo esc_html(get_theme_mod('eram_404_text','We were unable to find that page!'))?>

            </div>
            <div class="sp-blank-50"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php get_footer();?>