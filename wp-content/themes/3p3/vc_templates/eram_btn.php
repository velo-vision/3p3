<?php $btn_text = $btn_url = $size = $shape = $color = $transparent = $wide = $with_icon = $animate_icon = $icon_align = $el_class  ='';?>

<?php $icon_type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_monosocial = $icon_pixelicons = '';?>

<?php if (function_exists('vc_map_get_attributes')) {?>
  <?php $atts = vc_map_get_attributes( $this->getShortcode(), $atts );?>

<?php }?>
<?php extract( $atts );?>

<?php $class = $this->getExtraClass( $el_class );?>

<?php $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );?>

<?php $link = vc_build_link( $btn_url );?>

<?php $defaultIconClass = 'fa fa-adjust';?>

<?php $iconClass = isset( ${'icon_' . $icon_type} ) ? ${'icon_' . $icon_type} : $defaultIconClass;?>

<?php $has_icon = ($with_icon == 'yes') ? true : false;?>

<?php $btn_class="btn";?>

<?php $btn_class .= ' '. $css_class;?>

<?php $btn_class .= ' '.$size;?>

<?php if ($shape == 'square') {?>
  <?php $shape = '';?>

<?php }?>
<?php $btn_class .= ' '.$shape;?>

<?php if ($color == 'none') {?>
  <?php $color = '';?>

<?php }?>
<?php $btn_class .= ' '.$color;?>

<?php if ($transparent == 'yes') {?>
  <?php $btn_class .= ' btn-trans';?>

<?php }?>
<?php if ($wide == 'yes') {?>
  <?php $btn_class .= ' btn-wide';?>

<?php }?>
<?php if ($icon_align == 'right') {?>
  <?php $btn_class .= ' btn-icon-right';?>

<?php }?>
<?php if ($animate_icon == 'yes') {?>
  <?php $btn_class .=" btn-anim-i";?>

<?php }?>
<?php if (isset($has_icon) ? $has_icon : false) {?>
  <a class="<?php echo $btn_class;?>" href="<?php echo $link['url'];?>" target="<?php echo $link['target'];?>">
    <span>
      <?php echo esc_attr($btn_text)?>

      <i class="<?php echo $iconClass;?>"></i>
    </span>
  </a>
<?php }
 else {?>
  <a class="<?php echo $btn_class;?>" href="<?php echo $link['url'];?>" target="<?php echo $link['target'];?>">
    <?php echo esc_attr($btn_text)?>

  </a>
<?php }?>
<?php if ('pixelicons' !== $icon_type) {?>
  <?php vc_icon_element_fonts_enqueue( $icon_type );?>

<?php }?>