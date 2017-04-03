<?php $image1 = $image2 = $el_class = $before_text= $after_text = '';?>

<?php if (function_exists('vc_map_get_attributes')) {?>
  <?php $atts = vc_map_get_attributes( $this->getShortcode(), $atts );?>

<?php }?>
<?php extract( $atts );?>

<?php $class = $this->getExtraClass( $el_class );?>

<?php $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );?>

<?php $image_src1 = wp_get_attachment_image_src($image1, 'large');?>

<?php if (is_array($image_src1)) {?>
  <?php $image_src1 = $image_src1[0];?>

<?php }
 else {?>
  <?php $image_src1 = ERAM_IMAGES . "/no-image.jpg";?>

<?php }?>
<?php $image_src2 = wp_get_attachment_image_src($image2, 'large');?>

<?php if (is_array($image_src2)) {?>
  <?php $image_src2 = $image_src2[0];?>

<?php }
 else {?>
  <?php $image_src2 = ERAM_IMAGES . "/no-image.jpg";?>

<?php }?>
<?php $rand_class = earm_generateRandomString(10);?>

<?php $css_class .= ' _'.$rand_class;?>

<div class="eram-image-compare <?php echo $css_class?>">
  <img src="<?php echo $image_src1;?>">
  <img src="<?php echo $image_src2;?>">
  <?php echo "<style>.eram-image-compare._".$rand_class." .twentytwenty-before-label:before{content:'".$before_text."';}.eram-image-compare._".$rand_class." .twentytwenty-after-label:before{content:'".$after_text."';}</style>";?>

</div>