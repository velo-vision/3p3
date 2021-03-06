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

class EramGallery_Posttype {

    /**
     * Holds the class object.
     *
     * @since 1.0.0
     *
     * @var object
     */
    public static $instance;

    /**
     * Path to the file.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $file = __FILE__;

    /**
     * Holds the base class object.
     *
     * @since 1.0.0
     *
     * @var object
     */
    public $base;

    public $post_type_name = ERAM_GALLERY_CPT_NAME;
    public $post_type_slug = ERAM_GALLERY_CPT_SLUG;

    /**
     * Primary class constructor.
     *
     * @since 1.0.0
     */
    public function __construct() {

        // register post type 
        $this->register_post_type();

        $this->register_category();
       
    }


    /*
    * register post type
    */
    public function register_post_type(){
        // Build the labels for the post type.
        $labels = apply_filters( 'eramGallery_post_type_labels',
            array(
                'name'               => __( 'Gallery','eram'),
                'singular_name'      => __( 'gallery','eram'),
                'add_new'            => __( 'Add New','eram'),
                'add_new_item'       => __( 'Add New','eram'),
                'edit_item'          => __( 'Edit Gallery','eram'),
                'new_item'           => __( 'New Gallery Item','eram'),
                'view_item'          => __( 'View Gallery','eram'),
                'search_items'       => __( 'Search Galleries','eram'),
                'not_found'          => __( 'No Galleries Found.','eram'),
                'not_found_in_trash' => __( 'No Galleries Found in trash.','eram'),
                'parent_item_colon'  => '',
                'menu_name'          => __( 'Galleries','eram'),
                'all_items'          => __( 'All Galleries','eram'),
                'taxonomy'           => ERAM_GALLERY_CATEGORY_TAX
            )
        );

        // Build out the post type arguments.
        $args = apply_filters( 'eramGallery_post_type_args',
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
                'menu_icon'           => 'dashicons-format-image',
                'can_export'          => true,
                'delete_with_user'    => false,
                'capability_type'     => 'page',
                'hierarchical'        => false,
                'has_archive'         => $this->post_type_slug,
                'rewrite'             => array( 'slug' => $this->post_type_slug ),
                'supports'            => array( 'title','thumbnail','excerpt'),
                'taxonomies'          => array( ERAM_GALLERY_CATEGORY_TAX ),
            )
        );
        
        // Register the post type with WordPress.
        register_post_type( $this->post_type_name , $args );
    }


    /*
    * register taxonomy
    */
    public function register_category()
    {

        $labels = array(
            'name'                       => _x( 'Gallery Categories', 'Taxonomy General Name', 'eram' ),
            'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'eram' ),
            'menu_name'                  => __( 'Categories', 'eram' ),
            'all_items'                  => __( 'All Categories', 'eram' ),
            'parent_item'                => __( 'Parent Category', 'eram' ),
            'parent_item_colon'          => __( 'Parent Category:', 'eram' ),
            'new_item_name'              => __( 'New Category', 'eram' ),
            'add_new_item'               => __( 'Add New Category', 'eram' ),
            'edit_item'                  => __( 'Edit Category', 'eram' ),
            'update_item'                => __( 'Update Category', 'eram' ),
            'view_item'                  => __( 'View Category', 'eram' ),
            'separate_items_with_commas' => __( 'Separate categories with commas', 'eram' ),
            'add_or_remove_items'        => __( 'Add or remove categories', 'eram' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'eram' ),
            'popular_items'              => __( 'Popular Categories', 'eram' ),
            'search_items'               => __( 'Search Categories', 'eram' ),
            'not_found'                  => __( 'Not Found', 'eram' ),
            'no_terms'                   => __( 'No items', 'eram' ),
            'items_list'                 => __( 'Categories list', 'eram' ),
            'items_list_navigation'      => __( 'Categories list navigation', 'eram' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => false,
            'rewrite'                    => array( 'slug' => ERAM_GALLERY_CATEGORY_SLUG ),
        );
        register_taxonomy( ERAM_GALLERY_CATEGORY_TAX, array( ERAM_GALLERY_CPT_NAME ), $args );

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
$eramGallery_Posttype = EramGallery_Posttype::get_instance();
