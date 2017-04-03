<?php
/**
 * ol_live_editor class.
 *
 * @since 1.0.0
 *
 * @package Eram Gallery
 * @author  owwwlab
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * The Class
 */
class ol_live_editor
{


    /**
     * post ID
     *
     * @var
     */
    protected $post_id;

    /**
     *  Post object
     * @var WP_Post
     */
    protected $post;

    /**
     * Public Url of the Post
     *
     * @var
     */
    protected $post_url;

    /**
     * Url on the iframe to load live preview
     * @var
     */
    protected $iframe_url;


    /**
     * ol_live_editor constructor.
     */
    public function __construct()
    {
        $this->setCurrentPost();
        $this->renderEditor();
    }

    /**
     * Sets current Post
     */
    private function setCurrentPost()
    {
        global $post;
        $this->post = get_post();
        $this->post_id = $this->getUrlParam( 'post' );

        
        if ( $this->post_id && ! is_null($this->post_id ) ) {
            $this->post = get_post( $this->post_id );
        }else{

            wp_redirect( site_url() );
            exit;

        }

        //set global post
        $post = $this->post;


        $this->post_id = $this->post->ID;


    }

    /**
     *
     */
    private function renderEditor()
    {

        $this->post_url = $this->removeUrlProtocol(get_permalink( $this->post_id ));

        // prevent unprivileged users to access here
        if ( ! current_user_can('edit_others_pages') )
            header( 'Location: ' . $this->post_url );

        $this->enqueueStyleScripts();
        
        // check if this is a new post
        $this->handleNewPage();
        
        remove_all_actions( 'admin_notices', 3 );
        remove_all_actions( 'network_admin_notices', 3 );

        $this->iframe_url = $this->post_url . ( preg_match( '/\?/', $this->post_url ) ? '&' : '?' ) . 'ol_editable=true&ol_post_id=' . $this->post->ID;

        $this->loadEditor();
        die();

    }

    /**
     * @param $key
     * @param null $default
     * @return null
     */
    private function getUrlParam($key, $default=null){
        return isset( $_GET[ $key ] ) ? $_GET[ $key ] : $default;
    }

    /**
     * @param $urlStr
     * @return mixed
     */
    private function removeUrlProtocol($urlStr)
    {
        return str_replace( array(
            'https://',
            'http://',
        ), '//', $urlStr );
    }

    /**
     *
     */
    private function loadEditor()
    {
        require plugin_dir_path( __FILE__ ) . '../templates/template_live_editor.php';
    }


    /**
     * @param $path
     * @return string
     */
    public function  adminFile($path ) {
		return ABSPATH . 'wp-admin/' . $path;
	}

    /**
     * enqueue Styles and Scripts
     */
    private function enqueueStyleScripts()
    {
        wp_enqueue_style(
            'ol_editor_style',
            ERAM_GALLERY_CSS_DIR.'/ol_editor_styles.css',
            array(),
            ERAM_GALLERY_VERSION
        );

        wp_enqueue_script(
            'ol_editor_script', ERAM_GALLERY_JS_DIR.'/ol_editor.js',
            array('jquery'),
            ERAM_GALLERY_VERSION,
            true
        );
        wp_localize_script( 'ol_editor_script', 'Eg_Ajax', array(
                'saveNonce' => wp_create_nonce( 'eg_ajax-save-nonce' ),
            )
        );
    }

    /**
     * Checks if this is a new page screen
     */
    private function handleNewPage()
    {
        if ( $this->post && 'auto-draft' === $this->post->post_status )
        {
            $post_data = array(
                'ID' => $this->post_id,
                'post_status' => 'draft',
                'post_title' => 'Draft Gallery #'.$this->post_id,
            );
            add_filter( 'wp_insert_post_empty_content', false );
            wp_update_post( $post_data, true );
            $this->post->post_status = 'draft';
            $this->post->post_title = '';
        }
    }
}


new ol_live_editor();
