<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Eram
 */
?>
<section class="no-results not-found">
  <div class="container">
    <header class="page-header">
      <h1 class="page-title">
        <?php esc_html_e( 'Nothing Found', 'eram' );?>

      </h1>
    </header>
    <!-- .page-header -->
    <div class="page-contents">
      <?php if (is_search()) {?>
        <p>
          <?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'eram' );?>

        </p>
      <?php }
       else {?>
        <p>
          <?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'eram' );?>

        </p>
      <?php }?>
    </div>
  </div>
</section>