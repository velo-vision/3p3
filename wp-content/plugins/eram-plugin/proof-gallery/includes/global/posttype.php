<?php
/**
 * Posttype class.
 *
 * @since 1.0.0
 *
 * @package Eram Gallery
 * @author  owwwlab
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class EramProofGallery_Posttype {

    /**
     * Holds the class object.
     *
     * @since 1.0.0
     *
     * @var object
     */
    public static $instance;



    public $post_type_name = ERAM_PROOF_GALLERY_CPT_NAME;
    public $post_type_slug = ERAM_PROOF_GALLERY_CPT_SLUG;
    /**
     * Primary class constructor.
     *
     * @since 1.0.0
     */
    public function __construct() {

        // register post type 
        $this->register_post_type();
       
    }


    /*
    * register post type
    */
    public function register_post_type(){
        // Build the labels for the post type.
        $labels = apply_filters( 'eramProofGallery_post_type_labels',
            array(
                'name'               => __( 'Proof Galleries','eram'),
                'singular_name'      => __( 'Proof Gallery','eram'),
                'add_new'            => __( 'Add New','eram'),
                'add_new_item'       => __( 'Add New','eram'),
                'edit_item'          => __( 'Edit Proof Gallery','eram'),
                'new_item'           => __( 'New Proof Gallery Item','eram'),
                'view_item'          => __( 'View Proof Gallery','eram'),
                'search_items'       => __( 'Search Proof Galleries','eram'),
                'not_found'          => __( 'No Proof Galleries Found.','eram'),
                'not_found_in_trash' => __( 'No Proof Galleries Found in trash.','eram'),
                'parent_item_colon'  => '',
                'menu_name'          => __( 'Proof Galleries','eram'),
                'all_items'          => __( 'All Proof Galleries','eram'),
                'featured_image'        => __( 'Cover Photo', 'eram' ),
                'set_featured_image'    => __( 'Set Cover Photo', 'eram' ),
                'remove_featured_image' => __( 'Remove Cover Photo', 'eram' ),
                'use_featured_image'    => __( 'Use Cover Photo', 'eram' ),
            )
        );

        // Build out the post type arguments.
        $args = apply_filters( 'eramProofGallery_post_type_args',
            array(

                'labels'              => $labels,
                'public'              => true,
                'publicly_queryable'  => true,
                'exclude_from_search' => true,
                'show_ui'             => true,
                'show_in_nav_menus'   => true,
                'show_in_menu'        => true,
                'show_in_admin_bar'   => true,
                'menu_position'       => 20,
                'menu_icon'           => 'dashicons-visibility',
                'can_export'          => true,
                'delete_with_user'    => false,
                'capability_type'     => 'page',
                'hierarchical'        => false,
                'has_archive'         => false,
                'rewrite'             => array( 'slug' => $this->post_type_slug ),
                'supports'            => array( 'title','thumbnail','editor','comments'),
            )
        );
        
        // Register the post type with WordPress.
        register_post_type( $this->post_type_name , $args );
    }


    

    /**
     * Returns the singleton instance of the class.
     *
     * @since 1.0.0
     *
     * @return object The EramGallery_Posttype object.
     */
    public static function get_instance()
    {

        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;

    }


}

// Load the posttype class.
$eramProofGallery_Posttype = EramProofGallery_Posttype::get_instance();
