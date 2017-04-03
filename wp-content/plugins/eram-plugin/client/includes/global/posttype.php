<?php
/**
 * Posttype class.
 *
 * @since 1.0.0
 *
 * @package Eram Plugin
 * @author  owwwlab
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Eram_Client_Posttype {

    /**
     * Holds the class object.
     *
     * @since 1.0.0
     *
     * @var object
     */
    public static $instance;



    public $post_type_name = ERAM_CLIENT_CPT_NAME;
    public $post_type_slug = ERAM_CLIENT_CPT_SLUG;
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
        $labels = apply_filters( 'eram_client_post_type_labels',
            array(
                'name'               => __( 'Clients','eram'),
                'singular_name'      => __( 'Client','eram'),
                'add_new'            => __( 'Add New','eram'),
                'add_new_item'       => __( 'Add New','eram'),
                'edit_item'          => __( 'Edit Client','eram'),
                'new_item'           => __( 'New Client Item','eram'),
                'view_item'          => __( 'View Client','eram'),
                'search_items'       => __( 'Search Clients','eram'),
                'not_found'          => __( 'No Clients Found.','eram'),
                'not_found_in_trash' => __( 'No Clients Found in trash.','eram'),
                'parent_item_colon'  => '',
                'menu_name'          => __( 'Clients','eram'),
                'all_items'          => __( 'All Clients','eram'),
                'featured_image'        => __( 'Cover Photo', 'eram' ),
                'set_featured_image'    => __( 'Set Cover Photo', 'eram' ),
                'remove_featured_image' => __( 'Remove Cover Photo', 'eram' ),
                'use_featured_image'    => __( 'Use Cover Photo', 'eram' )
            )
        );
        
        // Build out the post type arguments.
        $args = apply_filters( 'eram_client_post_type_args',
            array(

                'labels'              => $labels,
                'public'              => true,
                'publicly_queryable'  => true,
                'exclude_from_search' => false,
                'show_ui'             => true,
                'show_in_nav_menus'   => true,
                'show_in_menu'        => true,
                'show_in_admin_bar'   => true,
                'menu_position'       => 20,
                'menu_icon'           => 'dashicons-businessman',
                'can_export'          => true,
                'delete_with_user'    => false,
                'capability_type'     => 'page',
                'hierarchical'        => false,
                'has_archive'         => $this->post_type_slug,
                'rewrite'             => array( 'slug' => $this->post_type_slug ),
                'supports'            => array( 'title','thumbnail'),
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
$eram_client_posttype = Eram_Client_Posttype::get_instance();
