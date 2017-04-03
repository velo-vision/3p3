<?php if (function_exists('vc_map_get_attributes')) {?>
  <?php $atts = vc_map_get_attributes( $this->getShortcode(), $atts );?>

<?php }?>
<?php extract( $atts );?>

<?php $class = $this->getExtraClass( $el_class );?>

<?php $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );?>

<?php $image = wp_get_attachment_image_src($image, 'thumbnail');?>

<?php if (is_array($image)) {?>
  <?php $image_src = $image[0];?>

  <?php $image_width = $image[1];?>

  <?php $image_height = $image[2];?>

<?php }
 else {?>
  <?php $image_src = ERAM_IMAGES . "/no-image.jpg";?>

<?php }?>
<?php if (strpos( $description, '#E-' ) !== false) {?>
  <?php $description = vc_value_from_safe( $description );?>

  <?php $description = nl2br( $description );?>

<?php }?>
<?php $title = empty($title) ? '' : $title;?>

<?php $subtitle = empty($subtitle) ? '' : $subtitle;?>

<div class="testimonial-item <?php echo $css_class;?>">
  <div class="avatar avatar-sm">
    <img src="<?php echo $image_src;?>" alt="<?php echo $title?>">
  </div>
  <div class="texts">
    <p>
      <?php echo $description;?>

    </p>
    <h4 class="their-name">
      <?php echo esc_html($title)?>

    </h4>
    <div class="their-cite">
      <?php echo esc_html($subtitle)?>

    </div>
  </div>
</div>