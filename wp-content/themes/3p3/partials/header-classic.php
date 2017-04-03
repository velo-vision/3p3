<?php $trigger_class=has_nav_menu('secondary-menu')?'':'hide-desktop';?>

<?php $header_class=has_nav_menu('secondary-menu')?'has-menu-icon':'';?>

<?php $background_image = ERAM_Kirki::get_option('eram_theme_options','eram_side_menu_bg','');?>

<?php $background_style =! empty($background_image)?'background-image:url('.$background_image.');':'';?>

<?php $header_type = ERAM_Kirki::get_option('eram_theme_options','eram_classic_header_type','wide');?>

<?php $container_class = '';?>

<?php if ($header_type == 'contained') {?>
  <?php $container_class = 'container';?>

  <?php $header_class .= ' is-contained';?>

<?php }?>
<div class="navigation-trigger <?php echo $trigger_class;?>">
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
<div id="side-area" class="ov-light-alpha-90" style="<?php echo $background_style;?>">
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
<header id="classic-header" class="<?php echo $header_class;?>">
  <div class="inner <?php echo $container_class;?>">
    <div class="logo-wrapper">
      <?php eram_the_custom_logo();?>

    </div>
    <?php if (has_nav_menu('primary-menu')) {?>
      <div class="menu-wrapper">
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
    <div class="header-icons">
      <?php eram_shop_mini_cart();?>

    </div>
    <div id="navigation-trigger" class="navigation-trigger <?php echo $trigger_class;?>">
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
  </div>
</header>