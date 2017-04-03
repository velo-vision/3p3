<?php $heading = $subheading = $btn_url = $use_icon = $el_class = $theme = '';?>

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

<?php $has_icon = ($use_icon == 'yes') ? true : false;?>

<?php if (! $has_icon) {?>
  <?php $css_class.= ' no-icon';?>

<?php }?>
<?php $btn_class = 'btn-skin-dark';?>

<?php if ($theme == 'dark-theme') {?>
  <?php $css_class.= ' dark-theme';?>

  <?php $btn_class="";?>

<?php }?>
<?php if ('pixelicons' !== $icon_type) {?>
  <?php vc_icon_element_fonts_enqueue( $icon_type );?>

<?php }?>
<div class="call-out tb-vcenter-wrapper <?php echo $css_class;?>">
  <div class="left-col vcenter">
    <?php if (isset($has_icon) ? $has_icon : false) {?>
      <div class="callout-icon">
        <i class="<?php echo $iconClass; ?>"></i>
      </div>
    <?php }?>
    <div class="callout-texts">
      <h2 class="title">
        <?php echo esc_html($heading)?>

      </h2>
      <h4 class="sub-title">
        <?php echo esc_html($subheading)?>

      </h4>
    </div>
  </div>
  <div class="right-col vcenter text-right">
    <?php if (!empty($link['url'])) {?>
      <a class="btn btn-medium <?php echo $btn_class;?>" href="<?php echo $link['url'];?>" target="<?php echo $link['target']?>">
        <?php if (!empty($link['title'])) {?>
          <?php echo esc_html($link['title'])?>

        <?php }
         else {?>
          <?php esc_html_e('Discover','eram');?>

        <?php }?>
      </a>
    <?php }?>
  </div>
</div>