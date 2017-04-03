<?php
/**
  * The template for displaying comments.
  *
  * This is the template that displays the area of the page that contains both the current comments
  * and the comment form.
  *
  * @link https://codex.wordpress.org/Template_Hierarchy
  * @package Eram
  */
?>
<?php if (post_password_required()) {?>
  <?php return;?>

<?php }?>
<div id="comments" class="comments-area">
  <?php if (have_comments()) {?>
    <h2 class="comments-title">
      <?php printf( // WPCS: XSS OK.
        esc_html( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'eram' ) ),
        number_format_i18n( get_comments_number() ),
        '<span>' . get_the_title() . '</span>'
        );
      ?>
    </h2>
    <?php /* List comments */ ?>
    <ol class="comment-list">
      <?php wp_list_comments( array(
        'style'      => 'ol',
        'short_ping' => true,
        ) );
      ?>
    </ol>
    <!-- .comment-list -->
    <?php /* Are there comments to navigate through? */ ?>
    <?php if (get_comment_pages_count() > 1 && get_option( 'page_comments' )) {?>
      <nav id="comment-nav" class="comment-navigation">
        <div class="nav-links">
          <div class="nav-previous">
            <?php previous_comments_link( esc_html__( '&#8612; Older ', 'eram' ) );?>

          </div>
          <div class="nav-separator"></div>
          <div class="nav-next">
            <?php next_comments_link( esc_html__( 'Newer &#8614;', 'eram' ) );?>

          </div>
        </div>
        <!-- .nav-link -->
      </nav>
      <!-- #comment-nav -->
    <?php }?>
  <?php }?>
  <?php /* If comments are closed and there are comments, let's leave a little note, shall we? */ ?>
  <?php if (! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' )) {?>
    <p class="no-comments">
      <?php esc_html_e( 'Comments are closed.', 'eram' );?>

    </p>
  <?php }?>
  <?php /* Display comments form */ ?>
  <?php comment_form();?>

</div>