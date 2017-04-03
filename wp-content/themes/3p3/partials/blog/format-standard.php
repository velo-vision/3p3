<?php if (has_post_thumbnail()) {?>
  <div class="post-header format-standard">
    <?php if (is_singular()) {?>
      <?php the_post_thumbnail('large');?>

    <?php }
     else {?>
      <a href="<?php the_permalink();?>">
        <?php the_post_thumbnail('large');?>

      </a>
    <?php }?>
  </div>
<?php }?>