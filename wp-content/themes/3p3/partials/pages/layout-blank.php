<?php $metas = eram_get_post_meta();?>

<div class="page layout-blank <?php echo join( ' ', get_post_class() );?>" id="post-<?php the_ID(); ?>">
  <div class="page-contents">
    <?php the_content();?>

  </div>
  <?php if (comments_open() || get_comments_number()) {?>
    <div class="container">
      <?php comments_template();?>

    </div>
  <?php }?>
</div>