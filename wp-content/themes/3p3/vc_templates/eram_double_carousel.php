<?php if (function_exists('vc_map_get_attributes')) {?>
  <?php $atts = vc_map_get_attributes( $this->getShortcode(), $atts );?>

<?php }?>
<?php extract( $atts );?>

<?php global $double_carousel_counter;?>

<?php $double_carousel_counter=0;?>

<?php $class = $this->getExtraClass( $el_class );?>

<?php $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );?>

<?php $duration = empty($duration) ? 1.4 : intval($duration);?>

<?php $auto_duration = empty($auto_duration) ? 5 : intval($auto_duration);?>

<?php $mouse = empty($mouse) ? 0 : 1;?>

<?php $keyboard = empty($keyboard) ? 0 : 1;?>

<?php $touchswipe = empty($touchswipe) ? 0 : 1;?>

<?php $bulletcontroll = empty($bulletcontroll) ? 0 : 1;?>

<?php $autoplay = empty($autoplay) ? 0 : 1;?>

<?php $slide_number = empty($slide_number) ? 0 : 1;?>

<?php $nextprev = empty($nextprev) ? 0 : 1;?>

<?php if (! $slide_number) {?>
  <?php $css_class .=' no-number';?>

<?php }?>
<div class="ol-double-carousel-wrapper full-screen">
  <div class="ol-double-carousel type-project-carousel <?php echo $css_class;?>" data-duration="<?php echo $duration;?>" data-mouse="<?php echo $mouse;?>" data-keyboard="<?php echo $keyboard;?>" data-touch="<?php echo $touchswipe;?>" data-bullet="<?php echo $bulletcontroll;?>" data-autoplay="<?php echo $autoplay?>" data-auto-duration="<?php echo $auto_duration;?>">
    <div class="left-side" data-fill="true">
      <div class="left-side-wrapper"></div>
    </div>
    <div class="right-side">
      <div class="right-side-wrapper"></div>
    </div>
    <div class="dc-contents" style="display:none;">
      <?php echo wpb_js_remove_wpautop($content)?>

    </div>
    <?php if (isset($nextprev) ? $nextprev : false) {?>
      <div class="vcarousel-prev">
        <a href="#">
          &#8613;
        </a>
      </div>
      <div class="vcarousel-next">
        <a href="#">
          &#8615;
        </a>
      </div>
    <?php }?>
  </div>
</div>