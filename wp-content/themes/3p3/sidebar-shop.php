<?php
/**
* The shop sidebar
*
* @package Eram
*/
?>
<?php $sidebar_to_load = 'eram-shop-sidebar';?>

<?php if (is_active_sidebar($sidebar_to_load)) {?>
  <div id="em-sidebar" class="em-sidebar">
    <?php dynamic_sidebar( $sidebar_to_load );?>

  </div>
<?php }?>