<?php $quote_text = eram_get_single_meta('eram_ps_quote_text','') ;?>

<?php $featured_img = 'none';?>

<?php $class = '';?>

<?php if (!empty($quote_text)) {?>
  <?php if (has_post_thumbnail()) {?>
    <?php $class = 'has-bg';?>

    <?php $featured_img = 'url('. get_the_post_thumbnail_url( get_the_ID(), "large" ) .')';?>

  <?php }?>
  <div class="post-header format-quote <?php echo $class;?>" style="background-image:<?php echo $featured_img;?>;">
    <blockquote class="quote-text">
      <p>
        <?php echo $quote_text;?>

      </p>
      <footer class="quote-author">
        <cite>
          <?php echo esc_html(eram_get_single_meta('eram_ps_quote_author',''));?>

        </cite>
      </footer>
    </blockquote>
  </div>
<?php }?>