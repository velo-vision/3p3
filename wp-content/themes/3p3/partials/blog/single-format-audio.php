<?php $mp3_file = eram_get_single_meta('eram_ps_audio_mp3','') ;?>

<?php $ogg_file = eram_get_single_meta('eram_ps_audio_ogg','') ;?>
<div class="post-format-wrapper format-audio">
    <div class="audio-wrapper">
      <div class="me-wrap">
        <audio controls>
          <?php if (! empty($ogg_file)) {?>
            <source src="<?php echo esc_url($ogg_file);?>" type="audio/ogg">
          <?php }?>
          <?php if (! empty ( $mp3_file )) {?>
            <source src="<?php echo esc_url($mp3_file);?>" type="audio/mpeg">
          <?php }?>
          <p>
            <?php esc_html_e('Your browser does not support the audio element.' , 'eram')?>

          </p>
        </audio>
      </div>
    </div>
  </div>