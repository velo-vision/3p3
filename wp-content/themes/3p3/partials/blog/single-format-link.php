<?php $link = esc_url( eram_get_single_meta('eram_ps_link','') );?>

<?php if (!empty($link)) {?>
  <div class="post-format-wrapper format-link">
    <a href="<?php echo $link; ?>" class="header-text">
      <?php echo $link;?>

    </a>
  </div>
<?php }?>