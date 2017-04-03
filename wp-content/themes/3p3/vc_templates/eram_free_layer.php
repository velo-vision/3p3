<?php $fl_position='page';?>

<?php if (function_exists('vc_map_get_attributes')) {?>
  <?php $atts = vc_map_get_attributes( $this->getShortcode(), $atts );?>

<?php }?>
<?php extract( $atts );?>

<?php $class = $this->getExtraClass( $el_class );?>

<?php $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );?>

<?php if ($fl_position=='page') {?>
  <?php $css_class.=" _em-fixed layout-padding";?>

<?php }?>
<div class="em-free-layer <?php echo $css_class;?>">
  <div class="tb-vcenter-wrapper">
    <div class="vcenter">
      <?php echo wpb_js_remove_wpautop($content)?>

    </div>
  </div>
</div>