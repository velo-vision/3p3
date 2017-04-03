<?php $metas = eram_get_post_meta();?>

<?php $slim_class = '';?>

<?php $container_class = eram_page_meta('_ep_content_type', $metas, 'container');?>

<?php $has_slim_container = $container_class == 'slim-container' ? true : false;?>

<?php $vc_enabled = get_post_meta(get_the_ID(), '_wpb_vc_js_status', true);?>

<?php if (isset($has_slim_container) ? $has_slim_container : false) {?>
  <?php $slim_class = 'slim-container';?>

  <?php $container_class = $vc_enabled=="true" ? 'has-vc' : 'container';?>

<?php }
 else {?>
  <?php $slim_class = '';?>

  <?php $container_class = $vc_enabled=="true" ? 'has-vc' : 'container';?>

<?php }?>
<div class="page layout-header-top <?php echo join( ' ', get_post_class() );?>" id="post-<?php the_ID(); ?>">
  <?php eram_print_page_header_styles($metas);?>

  <?php $header_class="";?>

  <?php $header_parallax_mode = "";?>

  <?php $content_parallax_mode = "";?>

  <?php $content_class = "";?>

  <?php $cover_image="";?>

  <?php $video_url ="";?>

  <?php $video_poster = "";?>

  <?php if (has_post_thumbnail()) {?>
    <?php $has_cover = true;?>

  <?php }
   else {?>
    <?php $has_cover = eram_has('_ep_cover_image',$metas,0);?>

  <?php }?>
  <?php $image_id = get_post_thumbnail_id( get_the_ID() );?>

  <?php if (empty( $image_id )) {?>
    <?php $image_id = eram_page_meta('_ep_cover_image',$metas,0);?>

  <?php }?>
  <?php $cover_image = wp_get_attachment_url($image_id );?>

  <?php $cover_type = eram_page_meta('_ep_cover_type',$metas,'image');?>

  <?php $has_parallax = Eram_Kirki::get_option('eram_theme_options','eram_has_parallax',true);?>

  <?php $inline_styles = "";?>

  <?php $header_hvh = "hvh-". intval(Eram_Kirki::get_option('eram_theme_options','eram_top_header_height',60) );?>

  <?php if ($has_cover && $cover_type == 'image') {?>
    <?php if (isset($has_parallax) ? $has_parallax : false) {?>
      <?php $header_class="parallax-layer has-cover ov-dark-alpha-50 ". $header_hvh;?>

      <?php $content_class = "parallax-layer";?>

      <?php $header_parallax_mode = "";?>

      <?php $content_parallax_mode = "mode-header-content";?>

    <?php }
     else {?>
      <?php $header_class="has-cover ov-dark-alpha-50 ". $header_hvh;?>

      <?php $inline_styles="background-image:url(" . $cover_image . ");"?>

    <?php }?>
  <?php }?>
  <?php if ($cover_type == 'google-map') {?>
    <?php $header_class="has-cover ov-dark-alpha-50 ". $header_hvh;?>

    <?php if (isset($has_parallax) ? $has_parallax : false) {?>
      <?php $content_class = "parallax-layer";?>

      <?php $content_parallax_mode = "mode-header-content";?>

    <?php }?>
  <?php }?>
  <?php if ($cover_type == 'video') {?>
    <?php if (isset($has_parallax) ? $has_parallax : false) {?>
      <?php $header_class = "has-cover ov-dark-alpha-50 owl-videobg autoplay ". $header_hvh;?>

      <?php $content_class = "parallax-layer";?>

      <?php $content_parallax_mode = "mode-header-content";?>

    <?php }
     else {?>
      <?php $header_class = "has-cover ov-dark-alpha-50 owl-videobg autoplay ". $header_hvh;?>

      <?php $content_class = "";?>

      <?php $content_parallax_mode = "";?>

    <?php }?>
    <?php $video_url = wp_get_attachment_url(eram_page_meta('_ep_cover_video',$metas,0));?>

    <?php $video_poster = $cover_image;?>

  <?php }?>
  <div class="page-head <?php echo $header_class; ?>" data-src="<?php echo $video_url;?>" data-poster="<?php echo $video_poster;?>" data-img-src="<?php echo $cover_image; ?>" data-parallax-mode="<?php echo $header_parallax_mode; ?>" style="<?php echo $inline_styles?>">
    <?php if ($cover_type == 'google-map') {?>
      <div class="gmap" data-address="<?php echo eram_page_meta('_ep_map_address', $metas, '500 17th St NW Washington, DC')?>" data-map-max-zoom="<?php echo eram_page_meta('_ep_map_max_zoom', $metas, 15);?>" data-map-initial-zoom="<?php echo eram_page_meta('_ep_map_initial_zoom', $metas, 10);?>"></div>
    <?php }?>
    <div class="tb-vcenter-wrapper">
      <div class="title-wrapper vcenter <?php echo $content_class; ?>" data-parallax-mode="<?php echo $content_parallax_mode; ?>">
        <h1 class="title">
          <?php the_title();?>

        </h1>
        <?php $has_desc = eram_has('_ep_description', $metas , false);?>

        <?php if (isset($has_desc) ? $has_desc : false) {?>
          <div class="description">
            <?php echo esc_html(eram_page_meta('_ep_description', $metas , ''))?>

          </div>
        <?php }?>
      </div>
    </div>
  </div>
  <div class="page-contents <?php echo $slim_class;?>">
    <div class="contents-container <?php echo $container_class;?>">
      <?php the_content();?>

      <?php eram_link_pages();?>

    </div>
    <?php if (comments_open() || get_comments_number()) {?>
      <div class="container">
        <?php comments_template();?>

      </div>
    <?php }?>
  </div>
  <?php if (eram_has('_ep_footer',$metas, 'on')) {?>
    
    <?php eram_footer();?>

  <?php }?>
</div>