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
<div class="page layout-default <?php echo join( ' ', get_post_class() ); echo ' '.$slim_class;?>" id="post-<?php the_ID(); ?>">
  <?php if (eram_has('_ep_title',$metas, TRUE)) {?>
    <div class="simple-page-head">
      <div class="title-wrapper">
        <div class="container">
          <?php eram_breadcrumb();?>

          <h1 class="page-title">
            <?php the_title();?>

          </h1>
        </div>
      </div>
    </div>
  <?php }?>
  <div class="page-contents">
    <div class="contents-container <?php echo $container_class;?>">
      <?php the_content();?>

      <?php eram_link_pages();?>

    </div>
  </div>
  <?php if (comments_open() || get_comments_number()) {?>
    <div class="container">
      <?php comments_template();?>

    </div>
  <?php }?>
  <?php if (eram_has('_ep_footer',$metas, 'on')) {?>
    
    <?php eram_footer();?>

  <?php }?>
</div>