<?php $muted="yes";?>

<?php if (function_exists('vc_map_get_attributes')) {?>
  <?php $atts = vc_map_get_attributes( $this->getShortcode(), $atts );?>

<?php }?>
<?php extract( $atts );?>

<?php $class = $this->getExtraClass( $el_class );?>

<?php $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );?>

<?php $image = wp_get_attachment_image_src($image, 'large');?>

<?php if (is_array($image)) {?>
  <?php $image_src = $image[0];?>

  <?php $image_width = $image[1];?>

  <?php $image_height = $image[2];?>

<?php }
 else {?>
  <?php $image_src = ERAM_IMAGES . "/no-image.jpg";?>

<?php }?>
<?php $bgimage = wp_get_attachment_image_src($bgimage, 'full');?>

<?php if (is_array($bgimage)) {?>
  <?php $bgimage_src = $bgimage[0];?>

  <?php $bgimage_width = $bgimage[1];?>

  <?php $bgimage_height = $bgimage[2];?>

<?php }
 else {?>
  <?php $bgimage_src = "";?>

<?php }?>
<?php if (strpos( $description, '#E-' ) !== false) {?>
  <?php $description = vc_value_from_safe( $description );?>

  <?php $description = nl2br( $description );?>

<?php }?>
<?php $link = vc_build_link( $btn_url );?>

<?php $muted= empty($muted)?"no":"yes";?>

<?php $media_type = empty($video) ? 'image' : 'video';?>

<div class="swiper-slide ol-slide" data-media-type="<?php echo $media_type;?>" data-bg-image="<?php echo $bgimage_src;?>">
  <div class="shadow"></div>
  <div class="slide-container">
    <?php if (!empty($link['url'])) {?>
      <a href="<?php echo esc_url($link['url']);?>" target="<?php echo $link['target'];?>">
        <div class="slide-media">
          <div class="shine">
            <?php if ($media_type == 'video') {?>
              <div class="owl-videobg manual-trigger" data-src="<?php echo esc_url($video);?>" data-poster="<?php echo $image_src;?>" data-mute="<?php echo $muted;?>"></div>
            <?php }
             else {?>
              <img class="slide-image" src="<?php echo $image_src;?>" width="<?php echo $image_width;?>" height="<?php echo $image_height;?>">
            <?php }?>
          </div>
        </div>
      </a>
    <?php }
     else {?>
      <div class="slide-media">
        <div class="shine"></div>
        <?php if ($media_type == 'video') {?>
          <div class="owl-videobg manual-trigger" data-src="<?php echo esc_url($video);?>" data-poster="<?php echo $image_src;?>" data-mute="<?php echo $muted;?>"></div>
        <?php }
         else {?>
          <img class="slide-image" src="<?php echo $image_src;?>" width="<?php echo $image_width;?>" height="<?php echo $image_height;?>">
        <?php }?>
      </div>
    <?php }?>
    <div class="description">
      <?php echo $description;?>

    </div>
    <?php if (! empty($link['url'])) {?>
      <a class="link" href="<?php echo esc_url($link['url']);?>" target="<?php echo $link['target'];?>">
        <?php if (empty($link['title'])) {?>
          <?php echo esc_html( apply_filters('rail_carousel_link_label',esc_html__('Explore','eram')) );?>

        <?php }
         else {?>
          <?php echo esc_html($link['title']);?>

        <?php }?>
      </a>
    <?php }?>
  </div>
  <div class="slide-details">
    <h2 class="title">
      <?php echo esc_html($title);?>

    </h2>
  </div>
</div>