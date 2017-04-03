<?php
/**
 *  Extra hooks for filters and actions for the theme
 *
 * @package Eram
 * @author owwwlab
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * ----------------------------------------------------------------------------------------
 * Body class for dark/light theme
 * ----------------------------------------------------------------------------------------
 */
add_filter( 'body_class', 'eram_body_color_scheme_classes' );

if ( ! function_exists( 'eram_body_color_scheme_classes' ) ) {
    function eram_body_color_scheme_classes( $classes )
    {

        $scheme = Eram_Kirki::get_option( 'eram_theme_options', 'eram_color_theme', 'light' );
        if ( $scheme == 'light' )
            $classes[] = 'eram-theme-light';
        else
            $classes[] = 'eram-theme-dark';

        return $classes;
    }
}


/**
 * ----------------------------------------------------------------------------------------
 * Add layout related class to body
 * ----------------------------------------------------------------------------------------
 */

add_filter( 'body_class', 'eram_layout_body_class' );

if ( ! function_exists( 'eram_layout_body_class' ) ) {
    function eram_layout_body_class( $classes )
    {
        $layout_type = eram_get_site_layout();
        $classes[] = "er-$layout_type-layout";

        return $classes;
    }
}

/**
 * ----------------------------------------------------------------------------------------
 * Transparent Classic Header body class
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'eram_add_trans_header_body_class' ) ) {
    function eram_add_trans_header_body_class( $classes )
    {
        if ( is_page() ) {
            // get the transparent option
            $is_transparent = eram_has( '_ep_transparent_header', '', FALSE );
            if ( $is_transparent )
                $classes[] = 'em-transparent-header';

            if ( Eram_Kirki::get_option( 'eram_theme_options', 'eram_classic_header_transparent_scroll_bg', 1 ) ) {
                $classes[] = 'em-header-has-scroll-bg';
            }
        }

        return $classes;

    }
}
add_filter( 'body_class', 'eram_add_trans_header_body_class' );


/**
 * ----------------------------------------------------------------------------------------
 * Body class for show/hide sidebar in side layout
 * ----------------------------------------------------------------------------------------
 */
add_filter( 'body_class', 'eram_always_show_sidebar' );

if ( ! function_exists( 'eram_always_show_sidebar' ) ) {
    function eram_always_show_sidebar( $classes )
    {

        if ( Eram_Kirki::get_option( 'eram_theme_options', 'eram_site_layout', '' ) == "side" && Eram_Kirki::get_option( 'eram_theme_options', 'eram_side_layout_show_sidebar', 0 ) ) {
            $classes[] = 'always-show-side';
        }

        return $classes;
    }
}
/**
 * ----------------------------------------------------------------------------------------
 *  Stop wordpress from compressing JPEG images
 * ----------------------------------------------------------------------------------------
 */
add_filter( 'jpeg_quality', create_function( '', 'return 100;' ) );

/**
 * ----------------------------------------------------------------------------------------
 * add post type archives to menu selection
 * from: http://stackoverflow.com/questions/20879401/how-to-add-custom-post-type-archive-to-men
 * ----------------------------------------------------------------------------------------
 */
add_action( 'admin_head-nav-menus.php', 'eram_add_metabox_menu_posttype_archive' );

function eram_add_metabox_menu_posttype_archive()
{
    add_meta_box( 'eram-metabox-nav-menu-posttype', esc_html__( 'Post type Archives', 'eram' ), 'eram_metabox_menu_posttype_archive', 'nav-menus', 'side', 'default' );
}

function eram_metabox_menu_posttype_archive()
{
    $post_types = get_post_types( array(
        'show_in_nav_menus' => TRUE,
        'has_archive'       => TRUE,
    ), 'object' );

    if ( $post_types ) :
        $items = array();
        $loop_index = 999999;

        foreach ( $post_types as $post_type ) {
            $item = new stdClass();
            $loop_index++;

            $item->object_id = $loop_index;
            $item->db_id = 0;
            $item->object = 'post_type_' . $post_type->query_var;
            $item->menu_item_parent = 0;
            $item->type = 'custom';
            $item->title = $post_type->labels->name;
            $item->url = get_post_type_archive_link( $post_type->query_var );
            $item->target = '';
            $item->attr_title = '';
            $item->classes = array();
            $item->xfn = '';

            $items[] = $item;
        }

        $walker = new Walker_Nav_Menu_Checklist( array() );

        echo '<div id="posttype-archive" class="posttypediv">';
        echo '<div id="tabs-panel-posttype-archive" class="tabs-panel tabs-panel-active">';
        echo '<ul id="posttype-archive-checklist" class="categorychecklist form-no-clear">';
        echo walk_nav_menu_tree( array_map( 'wp_setup_nav_menu_item', $items ), 0, (object)array( 'walker' => $walker ) );
        echo '</ul>';
        echo '</div>';
        echo '</div>';

        echo '<p class="button-controls">';
        echo '<span class="add-to-menu">';
        echo '<input type="submit"' . disabled( 1, 0 ) . ' class="button-secondary submit-add-to-menu right" value="' . esc_html__( 'Add to Menu', 'eram' ) . '" name="add-posttype-archive-menu-item" id="submit-posttype-archive" />';
        echo '<span class="spinner"></span>';
        echo '</span>';
        echo '</p>';

    endif;
}


/**
 * ----------------------------------------------------------------------------------------
 * overrides option tree function
 * ----------------------------------------------------------------------------------------
 */
function ot_type_custom_post_type_checkbox( $args = array() )
{

    /* turns arguments array into variables */
    extract( $args );

    /* verify a description */
    $has_desc = $field_desc ? TRUE : FALSE;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-custom-post-type-checkbox type-checkbox ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';

    /* description */
    echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';

    /* format setting inner wrapper */
    echo '<div class="format-setting-inner">';

    /* setup the post types */
    $post_type = isset( $field_post_type ) ? explode( ',', $field_post_type ) : array( 'post' );

    /* query posts array */
    $my_posts = get_posts( apply_filters( 'ot_type_custom_post_type_checkbox_query', array(
        'post_type'      => $post_type,
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'post_status'    => 'any',
    ), $field_id ) );

    /* has posts */
    if ( is_array( $my_posts ) && ! empty( $my_posts ) ) {
        foreach ( $my_posts as $my_post ) {
            $post_title = '' != $my_post->post_title ? $my_post->post_title : 'Untitled';
            echo '<p>';
            echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[' . esc_attr( $my_post->ID ) . ']" id="' . esc_attr( $field_id ) . '-' . esc_attr( $my_post->ID ) . '" value="' . esc_attr( $my_post->ID ) . '" ' . ( isset( $field_value[ $my_post->ID ] ) ? checked( $field_value[ $my_post->ID ], $my_post->ID, FALSE ) : '' ) . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
            echo '<label for="' . esc_attr( $field_id ) . '-' . esc_attr( $my_post->ID ) . '">' . $post_title . '</label>';
            echo '</p>';
        }
    }
    else {
        echo '<p>' . esc_html__( 'No Clients Found', 'eram' ) . '</p>';
    }

    echo '</div>';

    echo '</div>';

}

/**
 * ----------------------------------------------------------------------------------------
 * overrides home page with custom post type
 * ----------------------------------------------------------------------------------------
 */

/**
 * Taken from WP_Query::is_front_page and adapted to compare page_on_front with current page ID.
 *
 * @since 1.0.0
 *
 * @param object $query The main WP Query.
 */
function eram_is_front_page( $query )
{
    if ( 'posts' == get_option( 'show_on_front' ) && $query->is_home() ) {
        return TRUE;
    }
    elseif (
        'page' == get_option( 'show_on_front' )
        && get_option( 'page_on_front' )
        && $query->get( 'page_id' ) == get_option( 'page_on_front' )
    ) {
        return TRUE;
    }

    return FALSE;
}

function eram_set_as_front_page( $query )
{
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    $custom_front_page = Eram_Kirki::get_option( 'eram_theme_options', 'eram_front_page_is', 'none' );

    if ( $custom_front_page == 'none' )
        return;

    if ( ! class_exists( 'EramPlugin' ) )
        return;

    switch ( $custom_front_page ) {
        case 'gallery-archive':
            $cpt = ERAM_GALLERY_CPT_NAME;
            break;
        case 'portfolio-archive':
            $cpt = ERAM_FOLIO_CPT_NAME;
            break;
        default:

    }
    if ( eram_is_front_page( $query ) ) {

        $query->set( 'page_id', '' );
        $query->is_page = FALSE;
        $query->is_singular = FALSE;
        $query->set( 'post_type', $cpt );
        $query->is_archive = TRUE;
        $query->is_post_type_archive = TRUE;
        $query->set('eram_front_page', 1);
    }
    else {

    }
}

add_action( 'pre_get_posts', 'eram_set_as_front_page' );


add_filter( 'template_include', 'eram_change_loaded_template_for_homepage' );
function eram_change_loaded_template_for_homepage( $original_template )
{

    if ( ! class_exists( 'EramPlugin' ) )
        return $original_template;

    if ( is_post_type_archive( 'eramgallery' ) ) {
        $to_load = get_template_directory() . '/archive-eramgallery.php';
    }
    elseif ( is_post_type_archive( 'eramfolio' ) ) {
        $to_load = get_template_directory() . '/archive-eramfolio.php';
    }
    else {
        $to_load = $original_template;
    }

    return $to_load;
}


/**
 * ----------------------------------------------------------------------------------------
 * Change Slug for gallery
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'eram_custom_gallery_slug' ) ) {
    function eram_custom_gallery_slug( $slug )
    {

        $has_custom = Eram_Kirki::get_option( 'eg_settings', 'eg_has_custom_slug', FALSE );
        if ( $has_custom ) {
            $slug = Eram_Kirki::get_option( 'eg_settings', 'eg_custom_slug', 'gallery' );
            $slug = sanitize_title( $slug );
        }

        return $slug;
    }
}
add_filter( 'eramGallery_cpt_slug_filter', 'eram_custom_gallery_slug' );

/**
 * ----------------------------------------------------------------------------------------
 * Change Slug for gallery category
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'eram_custom_gallery_cat_slug' ) ) {
    function eram_custom_gallery_cat_slug( $slug )
    {

        $has_custom = Eram_Kirki::get_option( 'eg_settings', 'eg_cat_has_custom_slug', FALSE );
        if ( $has_custom ) {
            $slug = Eram_Kirki::get_option( 'eg_settings', 'eg_cat_custom_slug', 'egcategory' );
            $slug = sanitize_title( $slug );
        }

        return $slug;
    }
}
add_filter( 'eramGallery_cpt_tax_filter', 'eram_custom_gallery_cat_slug' );


/**
 * ----------------------------------------------------------------------------------------
 * Change Slug for Portfolio
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'eram_custom_portfolio_slug' ) ) {
    function eram_custom_portfolio_slug( $slug )
    {

        $has_custom = Eram_Kirki::get_option( 'epf_settings', 'epf_has_custom_slug', FALSE );
        if ( $has_custom ) {
            $slug = Eram_Kirki::get_option( 'epf_settings', 'epf_custom_slug', 'projects' );
            $slug = sanitize_title( $slug );
        }

        return $slug;
    }
}
add_filter( 'eram_folio_cpt_slug_filter', 'eram_custom_portfolio_slug' );

/**
 * ----------------------------------------------------------------------------------------
 * Change Slug for portfolio category
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'eram_custom_portfolio_cat_slug' ) ) {
    function eram_custom_portfolio_cat_slug( $slug )
    {

        $has_custom = Eram_Kirki::get_option( 'epf_settings', 'epf_cat_has_custom_slug', FALSE );
        if ( $has_custom ) {
            $slug = Eram_Kirki::get_option( 'epf_settings', 'epf_cat_custom_slug', 'portfolio-cat' );
            $slug = sanitize_title( $slug );
        }

        return $slug;
    }
}
add_filter( 'eram_folio_cpt_tax_slug_filter', 'eram_custom_portfolio_cat_slug' );


/**
 * ----------------------------------------------------------------------------------------
 * galleries thumbnail size
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'eram_custom_gallery_image_size' ) ) {
    function eram_custom_gallery_image_size( $size )
    {

        $custom_size = Eram_Kirki::get_option( 'eram_theme_options', 'eg_thumb_size', 'eram-normal' );
        if ( $custom_size != 'eram-normal' ) {
            return $custom_size;
        }

        return $size;
    }
}
add_filter( 'eram_gallery_thumbnail_size', 'eram_custom_gallery_image_size' );


/**
 * ----------------------------------------------------------------------------------------
 * format comments in proof gallery
 * ----------------------------------------------------------------------------------------
 */

add_filter( 'comment_text', 'eram_format_comment' );

if ( ! function_exists( 'eram_format_comment' ) ) {
    function eram_format_comment( $text )
    {

        if ( is_singular( 'proofgallery' ) ) {

            preg_match( '/##(\d+)##/', $text, $matches );

            if ( count( $matches ) > 1 ) {

                $image_id = intval($matches[1]);
                $imageURL = wp_get_attachment_image_url( $image_id );

                if ( $imageURL ) {
                    $removed_text = preg_replace( '/##(\d+)##/', '', $text );

                    return '<div class="comment-with-image"><div class="img-wrap"><img class="prci" src="' . $imageURL . '"/><span>#' . $image_id . '</span></div><div class="image-side">' . $removed_text . '</div></div>';
                }

                return $text;
            }
        }

        return $text;

    }
}


/**
 * ----------------------------------------------------------------------------------------
 * Change the title tag if this is a custom front page
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists('eram_change_title') )
{
    function eram_change_title($title){

        global $wp_query;
        
        if ( array_key_exists('eram_front_page', $wp_query->query_vars) )
        {
            $title =  array(
                'site' => get_bloginfo( 'name', 'display' ),
                'tagline' => get_bloginfo( 'description', 'display' )
            );
        }

        return $title;
    }
}
add_filter('document_title_parts','eram_change_title');
