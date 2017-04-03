<?php if (function_exists('vc_map_get_attributes')) {?>
  <?php $atts = vc_map_get_attributes( $this->getShortcode(), $atts );?>

<?php }?>
<?php extract( $atts );?>

<?php $class = $this->getExtraClass( $el_class );?>

<?php $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );?>

<?php $image_src = wp_get_attachment_image_src($image, 'large');?>

<?php if (is_array($image_src)) {?>
  <?php $image_src = $image_src[0];?>

<?php }
 else {?>
  <?php $image_src = ERAM_IMAGES . "/no-image.jpg";?>

<?php }?>
<?php $link = vc_build_link( $btn_url );?>

<?php if (!empty($link['url'])) {?>
  <a class="vc-card boxed <?php echo esc_attr( $css_class );?>" href="<?php echo $link['url'];?>" target="<?php echo $link['target']?>">
    <div class="img-wrapper" style="background-image:url(<?php echo $image_src; ?>);"></div>
    <div class="vc-card-wrapper">
      <h3 class="title">
        <?php echo esc_html($name)?>

      </h3>
      <div class="subtitle">
        <?php echo esc_html($sub_title)?>

      </div>
    </div>
  </a>
<?php }
 else {?>
  <div class="vc-card boxed <?php echo esc_attr( $css_class );?>">
    <div class="img-wrapper" style="background-image:url(<?php echo $image_src; ?>);"></div>
    <div class="vc-card-wrapper">
      <h3 class="title">
        <?php echo esc_html($name)?>

      </h3>
      <div class="subtitle">
        <?php echo esc_html($sub_title)?>

      </div>
    </div>
  </div>
<?php }?>