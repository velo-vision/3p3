<?php $metas = eram_get_post_meta();?>

<?php $cover_type = eram_page_meta('_ep_cover_type',$metas,'image');?>

<?php $has_map = $cover_type == 'google-map' ? true : false;?>

<?php $bg_wrapper_class = 'no-cover';?>

<?php $side_class = '';?>

<?php $featured_image_url='';?>

<?php $video_url = "";?>

<?php $video_poster = "";?>

<?php if (has_post_thumbnail()) {?>
  <?php $has_cover = true;?>

<?php }
 else {?>
  <?php $has_cover = eram_has('_ep_cover_image',$metas,0);?>

<?php }?>
<?php if (!$has_cover) {?>
  <?php $side_class = 'no-cover';?>

<?php }?>
<?php $image_id = get_post_thumbnail_id( get_the_ID() );?>

<?php if (empty( $image_id )) {?>
  <?php $image_id = eram_page_meta('_ep_cover_image',$metas,0);?>

<?php }?>
<?php $cover_image = wp_get_attachment_url($image_id );?>

<?php if ($has_cover && $cover_type=='image') {?>
  <?php $bg_wrapper_class = '';?>

  <?php $featured_image_url = "background-image:url('" . $cover_image . "')";?>

<?php }?>
<?php if ($cover_type == 'video') {?>
  <?php $video_url = wp_get_attachment_url(eram_page_meta('_ep_cover_video',$metas,0));?>

  <?php $video_poster = $cover_image;?>

  <?php $bg_wrapper_class = 'owl-videobg autoplay';?>

<?php }?>
<div class="page layout-header-side <?php echo join( ' ', get_post_class() );?>" id="post-<?php the_ID(); ?>">
  <?php eram_print_page_header_styles($metas);?>

  <div class="page-side layout-vertical-padding <?php echo $side_class;?>">
    <?php if (isset($has_map) ? $has_map : false) {?>
      <div class="inner">
        <div class="bg-wrapper _has-map" style="background-image:none;">
          <div class="gmap" data-address="<?php echo eram_page_meta('_ep_map_address', $metas, '500 17th St NW Washington, DC')?>" data-map-max-zoom="<?php echo eram_page_meta('_ep_map_max_zoom', $metas, 15);?>" data-map-initial-zoom="<?php echo eram_page_meta('_ep_map_initial_zoom', $metas, 10);?>"></div>
        </div>
      </div>
    <?php }
     else {?>
      <div class="inner">
        <?php if (isset($has_cover) ? $has_cover : false) {?>
          <div class="bg-wrapper <?php echo $bg_wrapper_class;?>" data-src="<?php echo $video_url;?>" data-poster="<?php echo $video_poster;?>" style="<?php echo $featured_image_url;?>"></div>
        <?php }?>
        <div class="side-contents">
          <h1 class="title">
            <?php the_title();?>

          </h1>
          <?php $has_desc = eram_has('_ep_description', $metas , false);?>

          <?php if (isset($has_desc) ? $has_desc : false) {?>
            <div class="description">
              <?php echo esc_html(eram_page_meta('_ep_description', $metas , ''));?>

            </div>
          <?php }?>
        </div>
      </div>
    <?php }?>
  </div>
  <div class="page-main">
    <div class="page-contents">
      <?php if (isset($has_map) ? $has_map : false) {?>
        <h1 class="page-title">
          <?php the_title();?>

        </h1>
      <?php }?>
      <?php the_content();?>

      <?php eram_link_pages();?>

      <?php if (comments_open() || get_comments_number()) {?>
        <?php comments_template();?>

      <?php }?>
    </div>
    <?php if (eram_has('_ep_footer',$metas, 'on')) {?>
      
      <?php eram_footer();?>

    <?php }?>
  </div>
</div>