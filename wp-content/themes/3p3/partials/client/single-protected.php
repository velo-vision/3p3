<?php
/**
* The template used for displaying password protected pages
*
* @package Eram
*/
?>
<?php $bg = Eram_Kirki::get_option('eram_theme_options','eram_ppp_bg','');?>

<?php if (!empty($bg)) {?>
  <?php $inline_style='background-image:url('. $bg .')';?>

<?php }?>
<div class="full-height er-full-bg-page ov-light-alpha-60 <?php echo join( ' ', get_post_class() );?>" style="<?php echo $inline_style;?>">
  <div class="tb-vcenter-wrapper">
    <div class="vcenter">
      <div class="er-boxed">
        <div class="er-clips"></div>
        <div class="er-clips reverse"></div>
        <div class="avatar-wrapper layout-center">
          <?php $client_img_id = get_post_meta (get_the_ID(), '_ec_photo', true );?>

          <?php if (isset($client_img_id) ? $client_img_id : false) {?>
            <?php $image = wp_get_attachment_image_src($client_img_id,'thumbnail');?>

            <img class="avatar avatar-lg" src="<?php echo $image[0];?>">
          <?php }?>
        </div>
        <h1 class="title">
          <?php the_title();?>

        </h1>
        <?php the_content();?>

      </div>
    </div>
  </div>
</div>