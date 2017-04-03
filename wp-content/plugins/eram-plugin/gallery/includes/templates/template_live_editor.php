<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * @var $this ol_live_editor
 */


require_once( $this->adminFile( 'admin-header.php' ) );

do_action( 'add_meta_boxes', 'EramGallery', $this->post);

global $wp_meta_boxes;
?>

<div id="ol-editor-wrapper">

    <div id="ol-editor-side">
        <div class="eg-collapse">
        </div>
        <div class="eg-controls">
            <div class="controls-wrapper">
                <a href="<?php echo get_edit_post_link( $this->post->ID);?>" class="eg-back-to-post" title="<?php _e('Back to Post','eram') ?>">
                    <span class="dashicons dashicons-arrow-left-alt"></span>
                </a>
                <div class="responsive-control">
                    <a href="#" class="desktop" title="<?php _e('Desktop view','eram')?>"></a>
                    <a href="#" class="tablet" title="<?php _e('Tablet view','eram')?>"></a>
                    <a href="#" class="phone" title="<?php _e('Phone view','eram')?>"></a>

                </div>
                <a href="#" class="eg-preview-toggle">
                    <span class="preview"><?php _e('Preview','eram')?></span>
                    <span class="customize"><?php _e('Customize','eram')?></span>
                </a>
                <form action="#" id="eg-customize-form" data-post_id="<?php echo $this->post->ID;?>">
                    <input type="submit" name="eg-customize-save" id="eg-customize-save" class="button save right" value="<?php _e('Save','eram');?>">
                </form>
                <div class="eg-notification">
                    <span class="success-message"><?php _e('Setting Saved!','eram')?></span>
                    <span class="error-message"></span>
                </div>
            </div>
        </div>
        <div class="eg-inner">
            <div class="eg-settings">
                <?php call_user_func($wp_meta_boxes['eramgallery']['advanced']['low']['eram_gallery_meta_box']['callback'], $this->post, $wp_meta_boxes['eramgallery']['advanced']['low']['eram_gallery_meta_box']); ?>
            </div>
        </div>
    </div>
    <div id="ol-editor-main">
        <div id="eg-preview-device">
            <div class="eg-no-image">
                <div class="inner">
                    <div class="eg-center">
                        <a href="#" class="button button-primary button-hero" id="eg-uploader-trigger"><?php _e('Add Some Images', 'eram');?></a>
                    </div>
                </div>
            </div>
            <iframe src="<?php echo $this->iframe_url?>" id="ol-editor-iframe"></iframe>
        </div>
    </div>
</div>
<?php
require_once( $this->adminFile( 'admin-footer.php' ) );