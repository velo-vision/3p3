<?php $mp3_file = eram_get_single_meta('eram_ps_audio_mp3','') ;?>

<?php $ogg_file = eram_get_single_meta('eram_ps_audio_ogg','') ;?>

<?php $class = '';?>

<?php $featured_img = 'none';?>

<?php if (!empty($mp3_file) || !empty ($ogg_file)) {?>
  <?php if (has_post_thumbnail()) {?>
    <?php $class = 'has-bg';?>

    <?php $featured_img = 'url('. get_the_post_thumbnail_url( get_the_ID(), "large" ) .')';?>

  <?php }?>
  <div class="post-header format-audio <?php echo $class;?>" style="background-image:<?php echo $featured_img;?>;">
    <div class="audio-wrapper">
      <div class="me-wrap">
        <audio controls>
          <?php if (! empty($ogg_file)) {?>
            <source src="<?php echo $ogg_file;?>" type="audio/ogg">
          <?php }?>
          <?php if (! empty ( $mp3_file )) {?>
            <source src="<?php echo $mp3_file;?>" type="audio/mpeg">
          <?php }?>
          <p>
            <?php esc_html_e('Your browser does not support the audio element.' , 'eram')?>

          </p>
        </audio>
      </div>
    </div>
  </div>
<?php }?>