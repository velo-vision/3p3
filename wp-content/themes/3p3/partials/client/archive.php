<?php $has_header = Eram_Kirki::get_option('eg_settings','ec_has_details', TRUE);?>

<?php if (isset($has_header) ? $has_header : false) {?>
  <?php $header_class="";?>

  <?php $header_parallax_mode = "";?>

  <?php $content_parallax_mode = "";?>

  <?php $content_class = "";?>

  <?php $cover_image=Eram_Kirki::get_option('eg_settings','ec_archive_cover');?>

  <?php $has_parallax = Eram_Kirki::get_option('eram_theme_options','eram_has_parallax',true);?>

  <?php $inline_styles="";?>

  <?php $header_hvh = "hvh-". intval(Eram_Kirki::get_option('eram_theme_options','eram_top_header_height',60) );?>

  <?php if (isset($cover_image) ? $cover_image : false) {?>
    <?php if (isset($has_parallax) ? $has_parallax : false) {?>
      <?php $header_class="parallax-layer has-cover ov-dark-alpha-50 ". $header_hvh;?>

      <?php $content_class = "parallax-layer";?>

      <?php $header_parallax_mode = "";?>

      <?php $content_parallax_mode = "mode-header-content";?>

    <?php }
     else {?>
      <?php $header_class="has-cover ov-dark-alpha-50 ". $header_hvh;?>

      <?php $inline_styles="background-image:url(" . $cover_image . ");";?>

    <?php }?>
  <?php }?>
  <div class="page-head <?php echo $header_class; ?>" data-img-src="<?php echo $cover_image; ?>" data-parallax-mode="<?php echo $header_parallax_mode; ?>" style="<?php echo $inline_styles;?>">
    <div class="tb-vcenter-wrapper">
      <div class="title-wrapper vcenter <?php echo $content_class; ?>" data-parallax-mode="<?php echo $content_parallax_mode; ?>">
        <h1 class="title">
          <?php echo esc_html(Eram_Kirki::get_option('eg_settings','ec_page_title', esc_html__( 'Awesome Clients', 'eram' )));?>

        </h1>
        <div class="description">
          <?php echo esc_html(Eram_Kirki::get_option('eg_settings','ec_page_description', ''));?>

        </div>
      </div>
    </div>
  </div>
<?php }?>
<div class="page-contents">
  <div class="container">
    <div class="em-clients-list">
      <?php $clients_query = new WP_Query(array('post_type'=>ERAM_CLIENT_CPT_NAME, 'post_status'=>'publish', 'posts_per_page'=>-1));?>

      <?php if ($clients_query->have_posts()) {?>
        <?php while ($clients_query->have_posts()) {?>

          <?php $clients_query->the_post();?>

          <div class="em-client-box post">
            <div class="inner">
              <?php if (has_post_thumbnail()) {?>
                <div class="client-cover" style="background-image:url(<?php the_post_thumbnail_url('medium'); ?>)"></div>
              <?php }
               else {?>
                <div class="client-cover" style="background-image:url(<?php echo ERAM_IMAGES . '/page-bg.jpg'; ?>)"></div>
              <?php }?>
              <div class="client-photo">
                <?php $client_image_url = wp_get_attachment_image_src( get_post_meta( get_the_ID(), '_ec_photo', TRUE ), 'thumbnail' );?>

                <?php if (! $client_image_url) {?>
                  <?php $client_image_url[0] = ERAM_IMAGES . '/avatar.png';?>

                <?php }?>
                <a href="<?php the_permalink();?>">
                  <img src="<?php echo esc_url($client_image_url[0]);?>">
                </a>
              </div>
              <div class="client-name">
                <h3>
                  <a href="<?php the_permalink();?>">
                    <?php the_title();?>

                  </a>
                </h3>
              </div>
              <div class="client-meta">
                <?php $assigned_gals = get_post_meta( get_the_ID(), '_ec_galleries', TRUE );?>

                <?php if (empty($assigned_gals)) {?>
                  <?php esc_html_e( 'No Galleries', 'eram' );?>

                <?php }
                 else {?>
                  <?php $count = count( get_post_meta( get_the_ID(), '_ec_galleries', TRUE ) );?>

                  <?php if ($count == 1) {?>
                    <?php echo esc_html__( 'One', 'eram' ) . ' ' . esc_html__( 'Gallery', 'eram' );?>

                  <?php }
                   else {?>
                    <?php echo $count . ' ' . esc_html__( 'Galleries', 'eram' );?>

                  <?php }?>
                <?php }?>
              </div>
              <?php $client_about = get_post_meta( get_the_ID(), '_ec_about', true );?>

              <?php if (isset($client_about) ? $client_about : false) {?>
                <div class="client-about">
                  <?php echo esc_html( $client_about );?>

                </div>
              <?php }?>
            </div>
          </div>
        <?php }?>

      <?php }
       else {?>
        <?php esc_html_e('No clients available','eram');?>

      <?php }?>
      <?php wp_reset_postdata();?>

    </div>
  </div>
</div>
<?php if (Eram_kirki::get_option('eram_theme_options','eram_footer_for_clients',0) == 1) {?>
  
  <?php eram_footer();?>

<?php }?>