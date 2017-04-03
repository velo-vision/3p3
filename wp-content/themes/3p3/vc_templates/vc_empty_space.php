<?php $height = $mobile_height = $tablet_height = $el_class = $css = '';?>

<?php $atts = vc_map_get_attributes( $this->getShortcode(), $atts );?>

<?php extract( $atts );?>

<?php $pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';?>

<?php $regexr = preg_match( $pattern, $height, $matches );?>

<?php $value = isset( $matches[1] ) ? (float) $matches[1] : (float) WPBMap::getParam( 'vc_empty_space', 'height' );?>

<?php $unit = isset( $matches[2] ) ? $matches[2] : 'px';?>

<?php $height = $value . $unit;?>

<?php $regexr = preg_match( $pattern, $mobile_height, $matches );?>

<?php $value = isset( $matches[1] ) ? (float) $matches[1] : (float) WPBMap::getParam( 'vc_empty_space', 'mobile_height' );?>

<?php $unit = isset( $matches[2] ) ? $matches[2] : 'px';?>

<?php $mobile_height = $value . $unit;?>

<?php $regexr = preg_match( $pattern, $tablet_height, $matches );?>

<?php $value = isset( $matches[1] ) ? (float) $matches[1] : (float) WPBMap::getParam( 'vc_empty_space', 'tablet_height' );?>

<?php $unit = isset( $matches[2] ) ? $matches[2] : 'px';?>

<?php $tablet_height = $value . $unit;?>

<?php $inline_css = ( (float) $height >= 0.0 ) ? 'height: ' . esc_attr( $height )  : '';?>

<?php $class = 'vc_empty_space ' . $this->getExtraClass( $el_class ) . vc_shortcode_custom_css_class( $css, ' ' );?>

<?php $rand_class = ' _'.earm_generateRandomString(10);?>

<?php $class .= $rand_class;?>

<?php $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );?>

<div class="div <?php echo esc_attr( trim( $css_class ) ); ?>">
  <?php $rand_class = str_replace(array("\n","\r"," "), '', '.'.$rand_class);?>

  <?php echo "<style>";?>

  <?php echo $rand_class. '{height:'. $height .'}';?>

  <?php echo '@media (max-width: 1024px){' . $rand_class. '{height:'. $tablet_height .'}}';?>

  <?php echo '@media (max-width: 480px){' . $rand_class. '{height:'. $mobile_height .'}}';?>

  <?php echo "</style>";?>

  <span class="vc_empty_space_inner"></span>
</div>