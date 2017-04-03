<?php $url = esc_url( eram_get_single_meta('eram_ps_embed_video','') );?>

<?php if (!empty($url)) {?>
  <div class="post-format-wrapper format-embed video">
    <?php echo wp_oembed_get($url);?>

  </div>
<?php }?>