<?php if (function_exists('vc_map_get_attributes')) {?>
  <?php $atts = vc_map_get_attributes( $this->getShortcode(), $atts );?>

<?php }?>
<?php extract( $atts );?>

<?php $class = $this->getExtraClass( $el_class );?>

<?php $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );?>

<?php $image_src_array = wp_get_attachment_image_src($image, 'full');?>

<?php if (is_array($image_src_array)) {?>
  <?php $image_src = $image_src_array[0];?>

  <?php $image_width = $image_src_array[1];?>

  <?php $image_height = $image_src_array[2];?>

<?php }
 else {?>
  <?php $image_src = ERAM_IMAGES . "/no-image.jpg";?>

<?php }?>
<?php if (strpos( $description, '#E-' ) !== false) {?>
  <?php $description = vc_value_from_safe( $description );?>

  <?php $description = nl2br( $description );?>

<?php }?>
<?php $link = vc_build_link( $btn_url );?>

<?php global $double_carousel_counter;?>

<?php $double_carousel_counter++;?>

<?php $counter = "#";?>

<?php if ($double_carousel_counter < 10) {?>
  <?php $counter .= '0'.$double_carousel_counter;?>

<?php }
 else {?>
  <?php $counter .= $double_carousel_counter;?>

<?php }?>
<div class="dc-item">
  <div class="dc-right-side <?php echo $css_class; ?>">
    <div class="item">
      <div class="item-wrapper ov-light-alpha-95" style="background-image:url(<?php echo $image_src;?>)">
        <div class="item-border"></div>
        <div class="tb-vcenter-wrapper">
          <div class="vcenter">
            <h3 class="title">
              <span>
                <?php echo esc_html($title);?>

              </span>
              <div class="item-number">
                <?php echo $counter;?>

              </div>
            </h3>
            <div class="info">
              <?php echo esc_html($description);?>

            </div>
            <?php if (! empty($link['url'])) {?>
              <a class="btn btn-medium btn-skin-dark" href="<?php echo esc_url($link['url']);?>" target="<?php echo esc_attr($link['target']); ?>" title="<?php echo esc_attr($link['title']); ?>">
                <?php if (empty($link['title'])) {?>
                  <?php esc_html_e('Explore', 'eram');?>

                <?php }
                 else {?>
                  <?php echo esc_html($link['title']);?>

                <?php }?>
              </a>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="dc-left-side">
    <div class="item">
      <img src="<?php echo $image_src;?>" alt="<?php echo esc_html($title); ?>" width="<?php echo $image_width; ?>" height="<?php echo $image_height ; ?>">
    </div>
  </div>
</div>