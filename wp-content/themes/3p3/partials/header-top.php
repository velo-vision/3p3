<?php if (has_nav_menu("primary-menu")) {?>
  <?php $background_style ='';?>

  <?php $background_image = ERAM_Kirki::get_option('eram_theme_options','eram_side_menu_bg','');?>

  <?php if (! empty($background_image)) {?>
    <?php $background_style ='background-image:url('.$background_image.');';?>

  <?php }?>
  <div id="side-area" class="ov-light-alpha-90 layout-padding p-left-0" style="<?php echo $background_style;?>">
    <div class="side-content">
      <div class="slide-menu-wrapper"></div>
    </div>
  </div>
<?php }?>
<header id="top-header">
  <div class="inner">
    <div class="logo-wrapper">
      <?php eram_the_custom_logo();?>

    </div>
    <div class="menu-wrapper">
      <?php wp_nav_menu( array( 
        'theme_location'    => 'primary-menu',
        'container'         => false,
        'menu_id'           => 'list-menu',
        'link_before'       => '<span>',
        'link_after'        => '</span>'
        ) 
        );
      ?>
    </div>
    <div class="side-wrapper">
      <div class="tb-vcenter-wrapper">
        <div class="vcenter">
          <?php $social_icons = eram_get_social_icons();?>

          <?php if (count($social_icons)>0 && Eram_Kirki::get_option('eram_theme_options','eram_show_topbar_socialicons')) {?>
            <ul class="social-icons with-bracket">
              <?php foreach($social_icons as $icon):?>

              <li>
                <a href="<?php echo esc_url($icon['link_url']); ?>" target="_blank">
                  <i class="fa fa-<?php echo esc_attr($icon['media']); ?>"></i>
                </a>
              </li>
              <?php endforeach;?>

            </ul>
          <?php }?>
          <?php $top_text = esc_html(Eram_Kirki::get_option('eram_theme_options','eram_top_text'));?>

          <?php if ($top_text !='') {?>
            <div class="side-text">
              <?php echo wpautop($top_text);?>

            </div>
          <?php }?>
          <?php eram_shop_mini_cart();?>

          <?php if (has_nav_menu("primary-menu")) {?>
            <div class="navigation-trigger">
              <!-- hamburger wrapper -->
              <div class="hamburger-wrapper">
                <a class="menu-trigger" href="#">
                  <div class="hamburger hamburger--3dy">
                    <div class="hamburger-box">
                      <div class="hamburger-inner"></div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          <?php }?>
        </div>
      </div>
    </div>
  </div>
</header>