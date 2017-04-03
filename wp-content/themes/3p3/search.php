<?php
/**
 * The template for displaying Search Results
 *
 * @package Eram
 */
?>

<?php get_header();?>


<?php global $wp_query, $s, $page;?>

<?php $found_posts = $wp_query->found_posts;?>

<div id="main-area" class="layout-padding">
  <div class="page layout-default">
    <div class="page-head">
      <div class="title-wrapper slim-container">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <p>
                <?php echo $found_posts == 0 ? esc_html__( 'There is nothing found that matches your search criteria.', 'eram' ) : sprintf( _n( 'We have found one match with the word you searched.', 'We have found %d results with the word you searched.', $found_posts, 'eram' ), $found_posts );?>

              </p>
              <h1 class="page-title">
                <?php printf( esc_html__( '%d results for "%s"', 'eram' ), $found_posts, $s );?>

              </h1>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="page-contents eram-search-results slim-container">
      <div class="container">
        <?php if (have_posts()) {?>
          <?php while (have_posts()) {?>

            <?php the_post();?>

            <div class="result-box">
              <h4>
                <a href="<?php echo get_the_permalink();?>">
                  <?php the_title();?>

                </a>
              </h4>
              <p>
                <?php the_excerpt();?>

              </p>
              <a class="read-more" href="<?php echo get_the_permalink();?>">
                <?php esc_html_e( 'Continue &#65515;', 'eram' );?>

              </a>
            </div>
          <?php }?>

          <?php the_posts_pagination( array(
            'prev_text'          => '&#8612;',
            'next_text'          => '&#8614;',
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'eram' ) . ' </span>',
            ) );
          ?>
        <?php }
         else {?>
          <?php esc_html_e('No Results Found.', 'eram');?>

        <?php }?>
      </div>
    </div>
  </div>
</div>

<?php get_footer();?>