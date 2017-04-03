<?php $trigger_class=has_nav_menu('secondary-menu')?'':'hide-desktop';?>

<?php $background_image = ERAM_Kirki::get_option('eram_theme_options','eram_side_menu_bg','');?>

<?php $background_style =! empty($background_image)?'background-image:url('.$background_image.');':'';?>

<div id="side-area" class="ov-light-alpha-90 layout-padding p-left-0" style="<?php echo $background_style;?>">
  <div class="side-content">
    <div class="slide-menu-wrapper">
      <?php wp_nav_menu( array(
        'theme_location'    => 'secondary-menu',
        'menu_id'           => 'slide-menu',
        'container'         => false,
        'link_before'       => '<span>',
        'link_after'        => '</span>'
        )
        );
      ?>
    </div>
  </div>
</div>
<div class="er-top-bar layout-top-height layout-horizontal-padding">
  <div class="logo-wrapper">
    <?php eram_the_custom_logo();?>

  </div>
  <div id="navigation-trigger" class="navigation-trigger <?php echo $trigger_class;?>">
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
  <?php eram_shop_mini_cart();?>

  <?php if (has_nav_menu('primary-menu')) {?>
    <div class="aside-menu-wrapper">
      <?php wp_nav_menu( array( 
        'theme_location'    => 'primary-menu',
        'container'         => false,
        'menu_id'           => 'classic-menu',
        'link_before'       => '<span>',
        'link_after'        => '</span>'
        ) 
        );
      ?>
    </div>
  <?php }?>
</div>
<div class="er-bottom-bar layout-bottom-height layout-horizontal-padding">
  <div class="em-bottom-left">
    <?php eram_layout_parts_dynamic_content('eram_bordered_bottom_left','copyright-text');?>

  </div>
  <div class="em-bottom-right">
    <?php eram_layout_parts_dynamic_content('eram_bordered_bottom_right','social-icons');?>

  </div>
</div>
<div class="er-left-bar layout-horizontal-width layout-vertical-padding"></div>
<div class="er-right-bar layout-horizontal-width layout-vertical-padding"></div>