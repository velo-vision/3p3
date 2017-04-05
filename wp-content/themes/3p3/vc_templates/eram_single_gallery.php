<?php $gal_id = $el_class = $gal_height = $gal_px_height = '';?>

<?php if (function_exists('vc_map_get_attributes')) {?>
  <?php $atts = vc_map_get_attributes( $this->getShortcode(), $atts );?>

<?php }?>
<?php extract( $atts );?>

<?php $class = $this->getExtraClass( $el_class );?>

<?php $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );?>

<?php $rand_class = earm_generateRandomString(10);?>

<?php $css_class .= ' _'.$rand_class;?>

<?php if (empty($gal_id)) {?>
  <?php return;?>

<?php }?>
<?php global $eram_gallery_page_is;?>

<?php $eram_gallery_page_is = 'is_singular';?>

<?php $gal = gallery_helper(intval($gal_id));?>

<?php $is_full = false;?>

<?php $force_full = array('h_masonry', 'h_grid','simple_horizontal');?>

<?php $gallery_layout = $gal->get_gallery_layout();?>

<?php $manual_height = '';?>

<?php if (in_array($gallery_layout, $force_full)) {?>
  <?php $is_full = true;?>

<?php }?>
<?php $wrapperClass=$wrapperStyle='';?>

<?php if ($gal_height =='full' || $is_full) {?>
  <?php $wrapperClass='full-screen';?>

<?php }
elseif ($gal_height =='px') {?>
  <?php $wrapperStyle='height:'.intval($gal_px_height).'px';?>

  <?php $manual_height = ' manual_height';?>

<?php }?>
<div class="gallery-wrapper <?php echo $gal->get_gallery_wrapper_class(); echo ' '.$manual_height;?>" style="<?php echo $wrapperStyle;?>">
  <div class="gallery-main <?php echo $gal->get_gallery_main_class() . ' '. $css_class;?>">
    <div class='em-gallery <?php echo $gal->get_em_gallery_class()?>' <?php echo $gal->get_em_gallery_atts()?>>
    <?php $gal->print_items_loop();?>

    </div>
  </div>
  <?php $gutter = eg_get_gallery_option( 'eg_items_spacing', 15 ,$gal_id);?>

  <?php eram_print_inpage_gallery_styles($gutter, '._'.$rand_class);?>

</div>
