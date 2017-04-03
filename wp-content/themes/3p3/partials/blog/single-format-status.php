<?php $status = eram_get_single_meta('eram_ps_status','');?>

<?php if (! empty($status)) {?>
  <div class="post-format-wrapper format-status">
    <div class="status-wrap">
      <?php echo esc_html($status);?>

    </div>
  </div>
<?php }?>