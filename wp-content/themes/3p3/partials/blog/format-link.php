<?php $link = esc_url( eram_get_single_meta('eram_ps_link','') );?>

<?php $featured_img = 'none';?>

<?php $class = '';?>

<?php if (!empty($link)) {?>
  <?php if (has_post_thumbnail()) {?>
    <?php $class = 'has-bg';?>

    <?php $featured_img = 'url('. get_the_post_thumbnail_url( get_the_ID(), "large" ) .')';?>

  <?php }?>
  <div class="post-header format-link <?php echo $class;?>" style="background-image:<?php echo $featured_img;?>;">
    <a href="<?php echo $link; ?>" class="header-text">
      <?php echo $link;?>

    </a>
  </div>
<?php }?>