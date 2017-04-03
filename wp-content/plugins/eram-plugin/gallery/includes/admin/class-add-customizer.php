<?php
/**
 * Eg_Add_Customizer class.
 *
 * @since 1.0.0
 *
 * @package Eram Gallery
 * @author  owwwlab
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Eg_Add_Customizer
 */
class Eg_Add_Customizer{


    /**
     * Eg_Add_Customizer constructor.
     */
    public function __construct()
    {
        add_action( 'edit_form_advanced', array( $this , 'render_btn' ) );

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

    }


    /**
     * Renders a button to load eram gallery customizer
     */
    public function render_btn()
    {
        // get this post 
        $post = $this->get_previewed_post();

        // if this is our CPT
        if ( $post->post_type == ERAM_GALLERY_CPT_NAME )
        {

            $edit_link = get_edit_post_link($post->ID);
            $eg_customizer_link = str_replace('action=edit', 'ol_edit_mode=ol_live_edit', $edit_link);

            ?>
            <div class='eg-customizer'>
                <div class="inner-wrapper">
                    <a href="<?php echo $eg_customizer_link; ?>" id="eg-post-preview"
                       class="button button-primary button-hero">
                        <span class="dashicons dashicons-admin-customizer"></span>
                        <?php _e('Customize Gallery', 'eram') ?>
                    </a>
                </div>

            </div>
            <?php
        }

    }

    /**
     * Get previewed post.
     *
     * @return WP_Post|null
     */
    public function get_previewed_post() {
        if ( function_exists( 'get_current_screen' ) && get_current_screen() && 'post' === get_current_screen()->base ) {
            $post = get_post();
        } elseif ( is_preview() ) {
            $post = get_post();
        } elseif ( isset( $_GET['previewed_post'] ) && preg_match( '/^\d+$/', wp_unslash( $_GET['previewed_post'] ) ) ) {
            $post = get_post( intval( $_GET['previewed_post'] ) );
        }
        if ( empty( $post ) ) {
            return null;
        }
        $post_type_obj = get_post_type_object( $post->post_type );
        if ( ! $post_type_obj || ! current_user_can( $post_type_obj->cap->edit_post, $post->ID ) ) {
            return null;
        }

        return $post;
    }

    public function enqueue_scripts() {
        
        // get this post 
        $post = $this->get_previewed_post();

        if ( ! $post ) return;

        // if this is our CPT
        if ( $post->post_type == ERAM_GALLERY_CPT_NAME )
        {
            wp_register_script(
                'eram-gallery-customizer-btn',
                ERAM_GALLERY_JS_DIR . '/admin.js',
                array(
                    'jquery',
                ),
                ERAM_GALLERY_VERSION,
                true
            );
            wp_enqueue_script( 'eram-gallery-customizer-btn' );

            wp_register_style(
                'eram-gallery-customizer-btn',
                ERAM_GALLERY_CSS_DIR . '/admin.css',
                array(),
                ERAM_GALLERY_VERSION
            );
            wp_enqueue_style( 'eram-gallery-customizer-btn' );
        }

    }



}

$eg_customizer_btn = new Eg_Add_Customizer();
