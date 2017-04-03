<?php $url = esc_url( eram_get_single_meta('eram_ps_embed_audio','') );?>

<?php if (!empty($url)) {?>
  <div class="post-format-wrapper format-embed audio">
    <?php echo wp_oembed_get(trim($url));?>

  </div>
<?php }?>