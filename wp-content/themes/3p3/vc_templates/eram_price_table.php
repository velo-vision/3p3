<?php $title = $subtitle = $currency = $features = $el_class = '';?>

<?php $image = '';?>

<?php if (function_exists('vc_map_get_attributes')) {?>
  <?php $atts = vc_map_get_attributes( $this->getShortcode(), $atts );?>

<?php }?>
<?php extract( $atts );?>

<?php $class = $this->getExtraClass( $el_class );?>

<?php $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );?>

<?php $link = vc_build_link( $btn_url );?>

<?php $features = vc_value_from_safe( $features );?>

<?php $features = explode( ',', $features );?>

<?php $image_src = wp_get_attachment_image_src($image, 'large');?>

<?php if (is_array($image_src)) {?>
  <?php $image_src = $image_src[0];?>

<?php }
 else {?>
  <?php $image_src = ERAM_IMAGES . "/no-image.jpg";?>

<?php }?>
<div class="ol-price-table <?php echo $css_class;?>">
  <div class="img-box">
    <div class="img-wrapper" style="background-image:url(<?php echo $image_src;?>)"></div>
    <div class="extra-links">
      <?php if (! empty($link['url'])) {?>
        <h5 class="plan-link">
          <a href="<?php echo $link['url'];?>" target="<?php echo $link['target']?>">
            <?php if (! empty($link['title'])) {?>
              <?php echo esc_html($link['title'])?>

            <?php }
             else {?>
              <?php esc_html_e('Request Quote','eram');?>

            <?php }?>
          </a>
        </h5>
      <?php }?>
    </div>
  </div>
  <div class="plan-contents">
    <h3 class="title">
      <?php echo esc_html($title)?>

    </h3>
    <?php if (! empty($subtitle)) {?>
      <p class="subtitle">
        <?php echo $subtitle?>

      </p>
    <?php }?>
    <ul class="plan-list">
      <?php foreach($features as $f):?>

      <li>
        <?php echo $f?>

      </li>
      <?php endforeach;?>

    </ul>
  </div>
</div>