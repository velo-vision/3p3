<?php $class = '';?>

<?php $featured_img = 'none';?>

<?php $aside = get_the_content();?>

<?php if ($aside != '') {?>
  <?php if (has_post_thumbnail()) {?>
    <?php $class = 'has-bg';?>

    <?php $featured_img = 'url('. get_the_post_thumbnail_url( get_the_ID(), "large" ) .')';?>

  <?php }?>
  <div class="post-header format-aside <?php echo $class;?>" style="background-image:<?php echo $featured_img;?>;">
    <div>
      <?php echo get_the_content();?>

    </div>
  </div>
<?php }?>