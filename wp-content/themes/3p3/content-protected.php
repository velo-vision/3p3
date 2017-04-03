<?php
/**
  * The template used for displaying password protected pages
  *
  * @package Eram
  */
?>
<?php $inline_style = '';?>

<?php $bg = Eram_Kirki::get_option('eram_theme_options','eram_ppp_bg','');?>

<?php if (!empty($bg)) {?>
  <?php $inline_style='background-image:url('. $bg .')';?>

<?php }?>
<div class="full-screen er-full-bg-page ov-light-alpha-60" style="<?php echo $inline_style;?>">
  <div class="tb-vcenter-wrapper">
    <div class="vcenter">
      <div class="er-boxed">
        <div class="er-clips"></div>
        <div class="er-clips reverse"></div>
        <?php the_content();?>

      </div>
    </div>
  </div>
</div>