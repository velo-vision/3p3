<?php $status = eram_get_single_meta('eram_ps_status','') ;?>

<?php $class = '';?>

<?php $featured_img = 'none';?>

<?php if (! empty($status)) {?>
  <?php if (has_post_thumbnail()) {?>
    <?php $class = 'has-bg';?>

    <?php $featured_img = 'url('. get_the_post_thumbnail_url( get_the_ID(), "large" ) .')';?>

  <?php }?>
  <div class="post-header format-status <?php echo $class;?>" style="background-image:<?php echo $featured_img;?>;">
    <div class="status-wrap">
      <?php echo $status;?>

    </div>
  </div>
<?php }?>