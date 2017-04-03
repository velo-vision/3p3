<?php $icon_type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_monosocial = $icon_pixelicons = $heading = $btn_url = $el_class = '';?>

<?php if (function_exists('vc_map_get_attributes')) {?>
  <?php $atts = vc_map_get_attributes( $this->getShortcode(), $atts );?>

<?php }?>
<?php extract( $atts );?>

<?php $class = $this->getExtraClass( $el_class );?>

<?php $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );?>

<?php $link = vc_build_link( $btn_url );?>

<?php $defaultIconClass = 'fa fa-adjust';?>

<?php $iconClass = isset( ${'icon_' . $icon_type} ) ? ${'icon_' . $icon_type} : $defaultIconClass;?>

<?php if ('pixelicons' !== $icon_type) {?>
  <?php vc_icon_element_fonts_enqueue( $icon_type );?>

<?php }?>
<div class="icon-box ib-v1 <?php echo $css_class;?>">
  <i class="<?php echo $iconClass; ?>"></i>
  <h3 class="title">
    <?php echo esc_html($heading)?>

  </h3>
  <?php echo wpb_js_remove_wpautop( $content, true );?>

  <?php if (! empty($link['url'])) {?>
    <a class="btn btn-small btn-wide btn-skin-dark" href="<?php echo $link['url'];?>" target="<?php echo $link['target']?>">
      <?php if (! empty($link['title'])) {?>
        <?php echo esc_html($link['title'])?>

      <?php }
       else {?>
        <?php esc_html_e('Discover','eram');?>

      <?php }?>
    </a>
  <?php }?>
</div>