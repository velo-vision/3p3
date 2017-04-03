<?php
/**
* The template for displaying image attachments.
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package Eram
*/
?>

<?php get_header();?>


<div id="main-area" class="layout-padding">
  <?php if (have_posts()) {?>
    <?php while (have_posts()) {?>

      <?php the_post();?>

      <div id="attachment-viewer" class="fullscreen-wrapper">
        <?php $image = wp_get_attachment_image_src( $post->ID, "full");?>

        <div class="viewer-ineractions">
          <?php get_template_part('partials/social-sharing');?>

          <div class="em-go-fullscreen"></div>
          <?php $purchase_url = get_post_meta( $post->ID, '_eg_purchase_url', TRUE );?>

          <?php if (! empty( $purchase_url )) {?>
            <div class="em-purchase">
              <a class="purchase-link btn btn-block btn-circle btn-small btn-skin-blue btn-anim-i" href="<?php echo esc_url($purchase_url);?>" target="_blank">
                <span>
                  <?php echo esc_html__( 'Purchase', 'eram' );?>

                  <i class="ol ol-shopping_bag"></i>
                </span>
              </a>
            </div>
          <?php }?>
        </div>
        <div class="attachment-wrapper em-fit-image">
          <?php echo wp_get_attachment_image($post->ID, 'full');?>

        </div>
      </div>
      <div id="attachment-details" class="slim-container">
        <div class="container">
          <div class="row">
            <?php $exif = eram_exifography_display_exif(null,$post->ID);?>

            <?php if (empty($exif)) {?>
              <div class="col-md-12">
                <h2 class="title">
                  <?php the_title();?>

                </h2>
                <hr>
                <?php the_content();?>

              </div>
            <?php }
             else {?>
              <div class="col-md-6">
                <h2 class="title">
                  <?php the_title();?>

                </h2>
                <hr>
                <?php the_content();?>

              </div>
              <div class="col-md-6">
                <div class="em-exif">
                  <?php echo $exif;?>

                </div>
              </div>
            <?php }?>
          </div>
        </div>
      </div>
      <div id="attachment-comments" class="slim-container">
        <div class="container">
          <?php if (comments_open() || get_comments_number()) {?>
            <div class="post-comments">
              <?php comments_template();?>

            </div>
          <?php }?>
        </div>
      </div>
    <?php }?>

  <?php }?>
</div>

<?php get_footer();?>