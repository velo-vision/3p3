<?php $cover = $link = $overlay = $has_mask = $dir = $el_class = $css = '';?>

<?php if (function_exists('vc_map_get_attributes')) {?>
  <?php $atts = vc_map_get_attributes( $this->getShortcode(), $atts );?>

<?php }?>
<?php extract( $atts );?>

<?php if (empty($link)) {?>
  <?php return;?>

<?php }?>
<?php if ($overlay == 'none') {?>
  <?php $overlay = '';?>

<?php }?>
<?php $mask_class='';?>

<?php if ($has_mask == 'yes') {?>
  <?php if (empty($dir)) {?>
    <?php $dir = 'top';?>

  <?php }?>
  <?php $mask_class='ol-mask-wrapper mask-'.$dir;?>

<?php }?>
<?php $el_class = $this->getExtraClass( $el_class );?>

<?php $el_classes = array('eram_video',$mask_class,$el_class,vc_shortcode_custom_css_class( $css, ' ' ));?>

<?php $css_class = implode( ' ', $el_classes );?>

<?php $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->getShortcode(), $atts );?>

<?php $image_src_array = wp_get_attachment_image_src($cover, 'full');?>

<?php if (is_array($image_src_array)) {?>
  <?php $image_src = $image_src_array[0];?>

  <?php $image_width = $image_src_array[1];?>

  <?php $image_height = $image_src_array[2];?>

<?php }
 else {?>
  <?php $image_src = ERAM_IMAGES . "/no-image.jpg";?>

<?php }?>
<div class="<?php echo esc_attr( $css_class ); ?>">
  <img class="mask-clone" src="<?php echo $image_src;?>">
  <a class="mask-wrapper <?php echo $overlay;?> ol-lightbox" href="<?php echo $link;?>" data-type="iframe" data-offset="inview">
    <div class="mask-elem">
      <div class="video-icon">
        <i class="fa fa-play"></i>
      </div>
      <img src="<?php echo $image_src;?>">
    </div>
  </a>
</div>