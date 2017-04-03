<?php $social_sharings = eram_get_social_sharings();?>

<?php if (count($social_sharings) > 0) {?>
  <?php eram_add_sharing($social_sharings);?>

<?php }?>