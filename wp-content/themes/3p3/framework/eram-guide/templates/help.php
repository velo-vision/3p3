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
  
  <div class="eram-about-section">
    <h2>
      Documentation
    </h2>
    <p>
      You can view theme documentation by clicking the button below:
    </p>
    <a class="button button-primary button-large" href="https://owwwlab.gitbooks.io/eram-wordppress-theme/content/" target="_blank">
      Read Documentation
    </a>
    <br>
    <br>
    <br>
  </div>
  <div class="eram-about-section">
    <h2>
      Frequently Asked Questions
    </h2>
    <hr>
    <ul class="faq">
      <li>
        <h4 class="question">
          1. Should I purchase a licnece or activate my visual composer plugin?
        </h4>
        <p class="answer">
          Generally you don't need to purchase any license for it or you don't need to activate it. We have purchased a license that allows us to distribute the Visual Composer bundeled with our theme. Everytime the plugins gets updated, out team will look into it, make the theme compatible with the changes and will update the theme including new updated plugin. So, all you should do is to wait for us to release a new version.
        </p>
      </li>
      <li>
        <h4 class="question">
          3. Flush Rewrite Rules
        </h4>
        <p class="answer">
          If it happens to get 404 Page not found error on some pages/posts that already exist, then you need to flush rewrite rules in order to fix this issue (this works in most cases).
          <br>
          To do apply rewrite rules flush follow these steps:
          <br>
          1. Go to Settings > Permalinks
          <br>
          2. Click "Save Changes" button.
          <br>
          That's all, check those pages to see if its fixed.
        </p>
      </li>
      <li>
        <h4 class="question">
          2. Regenerate Thumbnails
        </h4>
        <p class="answer">
          If your thumbnails are not correctly cropped, you can regenerate them by following these steps:
          <br>
          1. Go to Plugins > Add New
          <br>
          2. Search for "Regenerate Thumbnails"
          <br>
          3. Install and activate that plugin.
          <br>
          4. Go to Tools > Regen. Thumbnails
          <br>
          5. Click "Regenerate All Thumbnails" button and let the process to finish till it reaches 100 percent.
        </p>
      </li>
    </ul>
  </div>
</div>