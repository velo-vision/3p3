<div class="about-eram">
  
  <div class="intro-head">
    <div class="head-contents">
      <h1 class="about-title">
        <span>
          Welcome to 
        </span>
        Eram Photography Theme
      </h1>
      <p class="about-text">
        Thank you for using the Eram theme. This page helps you get familiar with the theme and get started quickly. Let's build your next amazing website!
      </p>
    </div>
    <div class="theme-version">
      <p class="wp-badge wp-eram-badge">
        <img class="theme-thumb" src="<?php echo ERAM_IMAGES . '/thumbnail.png'?>">
        Version:
        <?php echo esc_html(ERAM_THEME_VERSION);?>

      </p>
    </div>
  </div>
  
  <?php $links = array(
    'eram_welcome' => 'About Eram Theme',
    'eram_docs'=> 'Help'
    );
  ?>
  <h2 class="nav-tab-wrapper wp-clearfix">
    <?php foreach ( $links as $link_id=>$title):?>

    <?php $nav_class = 'nav-tab';?>

    <?php if ($link_id == eram_get('page')) {?>
      <?php $nav_class .= ' nav-tab-active';?>

    <?php }?>
    <a href="<?php echo 'themes.php?page='.$link_id; ?>" class="<?php echo $nav_class; ?>">
      <?php echo $title?>

    </a>
    <?php endforeach;?>

  </h2>
  
  <div class="eram-about-section links-section">
    <div id="plugin_needed" class="notice notice-warning eram-notice" style="display:none;">
      <p>
        To import a demo, you need to 
        <strong>
          install and activate
        </strong>
        One Click Demo Import Plugin first.
      </p>
    </div>
    <?php global $submenu;?>

    <?php if (isset( $submenu[ 'themes.php' ] ) && in_array( 'tgmpa-install-plugins', wp_list_pluck( $submenu[ 'themes.php' ], 2 ) )) {?>
      <a class="eram-quick-link" href="<?php echo 'themes.php?page=tgmpa-install-plugins'; ?>">
        <div class="inner-wrapper">
          <div class="icon-wrapper">
            <img class="icon" src="<?php echo ERAM_IMAGES . '/introduction/plugins.png'?>">
          </div>
          <div class="contents">
            <h4 class="title">
              Install Plugins
            </h4>
            <div class="subtitle">
              Required and recommended
            </div>
          </div>
        </div>
      </a>
    <?php }
     else {?>
      <div class="eram-quick-link">
        <div class="inner-wrapper">
          <div class="icon-wrapper">
            <img class="icon" src="<?php echo ERAM_IMAGES . '/introduction/plugins.png'?>">
          </div>
          <div class="contents">
            <h4 class="title">
              Install Plugins
            </h4>
            <div class="subtitle done">
              <span class="dashicons dashicons-yes"></span>
              All Done!
            </div>
          </div>
        </div>
      </div>
    <?php }?>
    <?php $activeclass = '';?>

    <?php if (! is_plugin_active( 'one-click-demo-import/one-click-demo-import.php' )) {?>
      <?php $activeclass = 'needs-activation';?>

    <?php }?>
    <a class="eram-quick-link <?php echo $activeclass;?>" href="<?php echo 'themes.php?page=pt-one-click-demo-import'; ?>">
      <div class="inner-wrapper">
        <div class="icon-wrapper">
          <img class="icon" src="<?php echo ERAM_IMAGES . '/introduction/import.png'?>">
        </div>
        <div class="contents">
          <h3 class="title">
            Import a Demo
          </h3>
          <div class="subtitle">
            One click import
          </div>
        </div>
      </div>
    </a>
    <a class="eram-quick-link" href="https://owwwlab.gitbooks.io/eram-wordppress-theme/content/" target="_blank">
      <div class="inner-wrapper">
        <div class="icon-wrapper">
          <img class="icon" src="<?php echo ERAM_IMAGES . '/introduction/documentation.png'?>">
        </div>
        <div class="contents">
          <h3 class="title">
            Documentation
          </h3>
          <div class="subtitle">
            Leran how it works
          </div>
        </div>
      </div>
    </a>
    <a class="eram-quick-link" href="http://owwwlab.ticksy.com/" target="_blank">
      <div class="inner-wrapper">
        <div class="icon-wrapper">
          <img class="icon" src="<?php echo ERAM_IMAGES . '/introduction/support.png'?>">
        </div>
        <div class="contents">
          <h3 class="title">
            Support Center
          </h3>
          <div class="subtitle">
            Need Help?
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="eram-what-is-new">
    <h2 class="section-title">
      What is New in v2.0
    </h2>
    <div class="row">
      <div class="one-third column">
        <div class="new-feature">
          <img src="<?php echo ERAM_IMAGES . '/introduction/v2/woo.jpg'; ?>">
          <div class="contents">
            <h4>
              WooCommerce support
            </h4>
            <p>
              Eram theme is now compatible with WooCommerce plugin comming with a new demo dedicated to shop.
            </p>
          </div>
        </div>
      </div>
      <div class="one-third column">
        <div class="new-feature">
          <img src="<?php echo ERAM_IMAGES . '/introduction/v2/purchase.jpg'; ?>">
          <div class="contents">
            <h4>
              Purchase Button @ Galleries
            </h4>
            <p>
              Your visitors can purchase photos while exploring your galleries. You can add purchase link for each image at media library, it can be an exteranl link to 500px, for example, or your self hosted shop using WooCommerce or any other plugin.
            </p>
          </div>
        </div>
      </div>
      <div class="one-third column">
        <div class="new-feature">
          <img src="<?php echo ERAM_IMAGES . '/introduction/v2/single-page.jpg'; ?>">
          <div class="contents">
            <h4>
              Single Page for Images
            </h4>
            <p>
              For thoese of you who need a single detailed page on each of your precious photography, there it is now providing a photo scene, description, exif, comments, etc.
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="one-third column">
        <div class="new-feature">
          <img src="<?php echo ERAM_IMAGES . '/introduction/v2/exif.jpg'; ?>">
          <div class="contents">
            <h4>
              EXIF support
            </h4>
            <p>
              Install the
              <a href="https://wordpress.org/plugins/thesography/">
                Exifography
              </a>
              plugin to add EXIF data at the single photo page and lightbox sidebar at galleries.
            </p>
          </div>
        </div>
      </div>
      <div class="one-third column">
        <div class="new-feature">
          <img src="<?php echo ERAM_IMAGES . '/introduction/v2/sidebar.jpg'; ?>">
          <div class="contents">
            <h4>
              Advanced lightbox with sidebar
            </h4>
            <p>
              You can enable the sidebar for your lightboxes at galleries to show more details about each photo to your visitors. Find the related option at Customizer under Gallery Settings.
            </p>
          </div>
        </div>
      </div>
      <div class="one-third column">
        <div class="new-feature">
          <img src="<?php echo ERAM_IMAGES . '/introduction/v2/revslider.jpg'; ?>">
          <div class="contents">
            <h4>
              Revolution slider bundle
            </h4>
            <p>
              V2.0 comes with the #1 WordPress slider plugin bundeled with the Eram theme.
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="one-third column">
        <div class="new-feature">
          <img src="<?php echo ERAM_IMAGES . '/introduction/v2/proof.jpg'; ?>">
          <div class="contents">
            <h4>
              Proof Gallery Discussion per Image
            </h4>
            <p>
              Now there is an icon under each photo at proof galleries that can add a photo referenced comment to begin a discussion about that specific photo with your client.
            </p>
          </div>
        </div>
      </div>
      <div class="one-third column">
        <div class="new-feature">
          <img src="<?php echo ERAM_IMAGES . '/introduction/v2/header.jpg'; ?>">
          <div class="contents">
            <h4>
              More Page Header & Footer Options
            </h4>
            <p>
              Along with adding more option to configure page headers, a brand new footer system is introduced at v2.0. You can find the related settings at the customizer under Theme Settings.
            </p>
          </div>
        </div>
      </div>
      <div class="one-third column">
        <div class="new-feature">
          <img src="<?php echo ERAM_IMAGES . '/introduction/v2/lightbox.jpg'; ?>">
          <div class="contents">
            <h4>
              New Lightbox Options
            </h4>
            <p>
              New options to configure lightbox are available at the Customizer under Gallery Settings.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="eram-about-section">
    <h2 class="section-title">
      Getting Started Videos
    </h2>
    <div class="eram-hero">
      <div class="video-wrapper">
        <a class="video-thumb" href="https://youtu.be/7C7H5RgOg-I?list=PLGoQt89pyIX-nU2tfRCQ0yT-retW2zoim" target="_blank" style="background-image:url(<?php echo ERAM_IMAGES . '/introduction/video-customizer.jpg';?>)">
          <div class="video-icon">
            <img class="icon" src="<?php echo ERAM_IMAGES . '/introduction/play.png';?>">
          </div>
        </a>
      </div>
      <div class="content-wrapper">
        <div class="inner-wrapper">
          <h3 class="title">
            Basic Configuration
          </h3>
          <h5 class="subtitle">
            Using WordPress customizer to change theme options
          </h5>
          <ul>
            <li>
              Logo & Site Name
            </li>
            <li>
              Menus
            </li>
            <li>
              Site Layout
            </li>
            <li>
              Social icons
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="eram-hero">
      <div class="video-wrapper">
        <a class="video-thumb" href="https://youtu.be/iA-rtNUz5OI?list=PLGoQt89pyIX-nU2tfRCQ0yT-retW2zoim" target="_blank" style="background-image:url(<?php echo ERAM_IMAGES . '/introduction/video-gallery.jpg';?>)">
          <div class="video-icon">
            <img class="icon" src="<?php echo ERAM_IMAGES . '/introduction/play.png';?>">
          </div>
        </a>
      </div>
      <div class="content-wrapper">
        <div class="inner-wrapper">
          <h3 class="title">
            Live Gallery Editor
          </h3>
          <h5 class="subtitle">
            Using WordPress customizer to change theme options
          </h5>
          <ul>
            <li>
              Create a Gallery
            </li>
            <li>
              Use Gallery Live Builder
            </li>
            <li>
              Gallery Types
            </li>
            <li>
              Gallery Settings
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="eram-hero">
      <div class="video-wrapper">
        <a class="video-thumb" href="https://youtu.be/rWYRpYs1ZwA?list=PLGoQt89pyIX-nU2tfRCQ0yT-retW2zoim" target="_blank" style="background-image:url(<?php echo ERAM_IMAGES . '/introduction/video-portfolio.jpg';?>)">
          <div class="video-icon">
            <img class="icon" src="<?php echo ERAM_IMAGES . '/introduction/play.png';?>">
          </div>
        </a>
      </div>
      <div class="content-wrapper">
        <div class="inner-wrapper">
          <h3 class="title">
            Portfolio
          </h3>
          <h5 class="subtitle">
            Using WordPress customizer to change theme options
          </h5>
          <ul>
            <li>
              Create a Portfolio
            </li>
            <li>
              Portfolio Customizer
            </li>
            <li>
              Portfolio Archive
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="eram-hero">
      <div class="video-wrapper">
        <a class="video-thumb" href="https://youtu.be/gZDRjnHBm6I?list=PLGoQt89pyIX-nU2tfRCQ0yT-retW2zoim" target="_blank" style="background-image:url(<?php echo ERAM_IMAGES . '/introduction/video-proof.jpg';?>)">
          <div class="video-icon">
            <img class="icon" src="<?php echo ERAM_IMAGES . '/introduction/play.png';?>">
          </div>
        </a>
      </div>
      <div class="content-wrapper">
        <div class="inner-wrapper">
          <h3 class="title">
            Clients & Proof Gallery
          </h3>
          <h5 class="subtitle">
            Using WordPress customizer to change theme options
          </h5>
          <ul>
            <li>
              Create a Proof Gallery
            </li>
            <li>
              Create a Client
            </li>
            <li>
              Password Protection
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  (function ($) {
    $('body').on('click','a.needs-activation',function(e){
      e.preventDefault();
      // show note
      $('#plugin_needed').fadeIn();
      return false;
    });
  })(jQuery);
</script>