<?php if (function_exists('vc_map_get_attributes')) {?>
  <?php $atts = vc_map_get_attributes( $this->getShortcode(), $atts );?>

<?php }?>
<?php extract( $atts );?>

<?php $class = $this->getExtraClass( $el_class );?>

<?php $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );?>

<?php $theme = empty($theme) ? 'dark-theme' : $theme;?>

<?php if ($bgtype == 'bgcolor') {?>
  <?php $dynamicbg = 1;?>

  <?php $dynamicbgimage = 0;?>

<?php }
elseif ($bgtype == 'bgimage') {?>
  <?php $dynamicbg = 0;?>

  <?php $dynamicbgimage = 1;?>

<?php }
 else {?>
  <?php $dynamicbg = 0;?>

  <?php $dynamicbgimage = 0;?>

<?php }?>
<?php $parallax = empty($parallax) ? 0 : 1;?>

<?php $css_class = ' '.$theme;?>

<?php if (isset($dynamicbgimage) ? $dynamicbgimage : false) {?>
  <?php $css_class .=' with-dynamic-bg';?>

<?php }?>
<?php if ($bgoverlay == 'none') {?>
  <?php $bgoverlay = false;?>

<?php }?>
<div id="ol-rail-carousel" class="ol-rail-carousel full-screen <?php echo $css_class;?>" data-dynamic-bg="<?php echo $dynamicbg;?>" data-dynamic-bgimage="<?php echo $dynamicbgimage;?>" data-parallax="<?php echo $parallax;?>">
  <div class="rail-carousel-loader em-loader">
    <div class="spinner">
      <div class="double-bounce1"></div>
      <div class="double-bounce2"></div>
    </div>
  </div>
  <div class="swiper-container <?php echo $bgoverlay; ?>">
    <?php if ($dynamicbgimage == 1) {?>
      <div class="dynamic-bg-image">
        <div class="in"></div>
        <div class="out"></div>
      </div>
    <?php }?>
    <div class="nav-rail">
      <div class="rail-line"></div>
      <div class="counter-wrapper">
        <div class="counter">
          <span class="current">
            0
          </span>
          <span class="separator"></span>
          <span class="total">
            0
          </span>
        </div>
      </div>
    </div>
    <div class="swiper-wrapper">
      <?php echo wpb_js_remove_wpautop($content)?>

    </div>
  </div>
</div>