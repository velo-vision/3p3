<?php $quote_text = eram_get_single_meta('eram_ps_quote_text','') ;?>

<?php if (!empty($quote_text)) {?>
  <div class="post-format-wrapper format-quote">
    <blockquote class="quote-text">
      <p>
        <?php echo esc_html($quote_text);?>

      </p>
      <footer class="quote-author">
        <cite>
          <?php echo esc_html(eram_get_single_meta('eram_ps_quote_author',''));?>

        </cite>
      </footer>
    </blockquote>
  </div>
<?php }?>