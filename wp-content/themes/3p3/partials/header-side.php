<?php $background_style ='';?>

<?php $background_image = ERAM_Kirki::get_option('eram_theme_options','eram_side_menu_bg','');?>

<?php $open_sidebar = ERAM_Kirki::get_option('eram_theme_options','eram_side_layout_show_sidebar','');?>

<?php $side_class=$open_sidebar?'always-open':'';?>

<?php if (! empty($background_image)) {?>
  <?php $background_style ='background-image:url('.$background_image.');';?>

<?php }?>
<header id="side-header" class="ov-light-alpha-95 <?php echo $side_class;?>" style="<?php echo $background_style;?>">
  <div class="em-scroll-wrapper">
    <div class="side-inner layout-padding p-left-0">
      <!-- logo wrapper -->
      <div class="logo-wrapper">
        <?php eram_the_custom_logo();?>

      </div>
      <div class="side-content">
        <div class="tb-vcenter-wrapper">
          <div class="vcenter">
            <div class="centred-section">
              <?php if (has_nav_menu('primary-menu')) {?>
                <div class="slide-menu-wrapper">
                  <?php wp_nav_menu( array(
                    'theme_location'    => 'primary-menu',
                    'menu_id'           => 'slide-menu',
                    'container'         => false,
                    'link_before'       => '<span>',
                    'link_after'        => '</span>'
                    )
                    );
                  ?>
                </div>
              <?php }?>
            </div>
          </div>
        </div>
      </div>
      <div class="side-footer stagger-animation">
        <?php $social_icons = eram_get_social_icons();?>

        <?php if (count($social_icons)>0 && Eram_Kirki::get_option('eram_theme_options','eram_show_sidebar_socialicons')) {?>
          <ul class="social-icons">
            <?php foreach($social_icons as $icon):?>

            <li>
              <a href="<?php echo esc_url($icon['link_url']); ?>" target="_blank">
                <i class="fa fa-<?php echo esc_attr($icon['media']); ?>"></i>
              </a>
            </li>
            <?php endforeach;?>

          </ul>
        <?php }?>
        <?php if (Eram_Kirki::get_option('eram_theme_options','eram_show_sidebar_cprtext')) {?>
          <div class="er-cprtext">
            <?php echo wpautop(Eram_Kirki::get_option('eram_theme_options','eram_page_footer_cprtext'))?>
          </div>
        <?php }?>
      </div>
    </div>
    <?php if (has_nav_menu('primary-menu')) {?>
      <div class="navigation-trigger">
        <!-- hamburger wrapper -->
        <div class="hamburger-wrapper">
          <a class="menu-trigger" href="#">
            <div class="hamburger hamburger--3dy">
              <div class="hamburger-box">
                <div class="hamburger-inner"></div>
              </div>
            </div>
            <div class="ham-label">
              Menu
            </div>
          </a>

        </div>

      </div>
    <?php }?>
    <div id="fixed-bottom-area">
      <!-- Redes sociales -->
          <div class="icon" style="text-align:center;">
            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
          </div>
      <!-- Fin redes sociales -->
      <!-- audio player wrapper -->
      <div class="audio-player-wrapper"></div>
    </div>
  </div>
</header>
<div id="mobile-header">
  <div class="logo-wrapper">
    <?php eram_the_custom_logo();?>

  </div>
</div>
<?php if (has_nav_menu('primary-menu')) {?>
  <div id="navigation-trigger" class="navigation-trigger">
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
