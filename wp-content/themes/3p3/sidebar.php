<?php
/**
* The sidebar containing the main widget area.
*
* @package Eram
*/
?>
<?php $sidebar_to_load = 'eram-main-sidebar';?>

<?php if (isset($selected_sidebar)) {?>
  <?php $sidebar_to_load = $selected_sidebar;?>

<?php }?>
<?php if (! is_active_sidebar( $sidebar_to_load )) {?>
  <?php return;?>

<?php }?>
<div id="em-sidebar" class="em-sidebar">
  <?php dynamic_sidebar( $sidebar_to_load );?>

</div>