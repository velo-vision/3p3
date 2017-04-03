<?php $heading = $desc = $btn_url = $theme = $style = $el_class  = $image ='';?>

<?php if (function_exists('vc_map_get_attributes')) {?>
  <?php $atts = vc_map_get_attributes( $this->getShortcode(), $atts );?>

<?php }?>
<?php extract( $atts );?>

<?php $class = $this->getExtraClass( $el_class );?>

<?php $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );?>

<?php $link = vc_build_link( $btn_url );?>

<?php if (strpos( $desc, '#E-' ) !== false) {?>
  <?php $desc = vc_value_from_safe( $desc );?>

  <?php $desc = nl2br( $desc );?>

<?php }?>
<?php $image_src_array = wp_get_attachment_image_src($image, 'full');?>

<?php if (is_array($image_src_array)) {?>
  <?php $image_src = $image_src_array[0];?>

  <?php $image_width = $image_src_array[1];?>

  <?php $image_height = $image_src_array[2];?>

<?php }
 else {?>
  <?php $image_src = '';?>

<?php }?>
<?php $btn_class = 'btn-skin-white';?>

<?php if ($style =='boxed') {?>
  <?php $css_class .= ' style-boxed';?>

<?php }?>
<?php if ($theme == 'dark-theme') {?>
  <?php $css_class .= ' theme-dark';?>

  <?php $btn_class = 'btn-skin-dark';?>

<?php }?>
<div class="eram_free_caption <?php echo $css_class;?>">
  <?php if (! empty($image_src)) {?>
    <img class="free-logo" src="<?php echo $image_src?>" title="<?php echo $heading;?>">
  <?php }?>
  <?php if (! empty ($heading)) {?>
    <h1 class="title">
      <?php echo $heading;?>

    </h1>
  <?php }?>
  <?php if (! empty ($desc)) {?>
    <p class="desc">
      <?php echo $desc;?>

    </p>
  <?php }?>
  <?php if (!empty($link['url'])) {?>
    <a class="btn btn-medium btn-trans btn-icon-right btn-anim-i <?php echo $btn_class; ?>" href="<?php echo $link['url'];?>" target="<?php echo $link['target']?>">
      <span>
        <?php if (!empty($link['title'])) {?>
          <?php echo esc_html($link['title'])?>

        <?php }
         else {?>
          <?php esc_html_e('Discover','eram');?>

        <?php }?>
        <i class="ol ol-forward"></i>
      </span>
    </a>
  <?php }?>
</div>