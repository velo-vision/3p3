<?php
/**
 *    Eram WordPress Theme
 *
 *    owwwlab
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * ----------------------------------------------------------------------------------------
 * WooCommerce support
 * ----------------------------------------------------------------------------------------
 */
add_action( 'after_setup_theme', 'eram_woocommerce_support' );
function eram_woocommerce_support()
{
    add_theme_support( 'woocommerce' );
}

/**
 * ----------------------------------------------------------------------------------------
 *  get option
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'eram_woo_get_option' ) ) {
    function eram_woo_get_option( $key = '', $default = FALSE )
    {

        if ( isset( $_GET[ $key ] ) ) {
            $option = sanitize_text_field( wp_unslash( $_GET[ $key ] ) );
        }
        else {
            $option = Eram_Kirki::get_option( 'eram_theme_options', $key, $default );
        }

        if ( is_null( $option ) || $option == '' ) {
            $option = $default;
        }

        return $option;


    }
}

/**
 * ----------------------------------------------------------------------------------------
 *  Before main content
 * ----------------------------------------------------------------------------------------
 */
add_action( 'woocommerce_before_main_content', 'eram_woo_before_main_content' );
if ( ! function_exists( 'eram_woo_before_main_content' ) ) {
    function eram_woo_before_main_content()
    {
        echo '';
    }
}

/**
 * ----------------------------------------------------------------------------------------
 *  After main content
 * ----------------------------------------------------------------------------------------
 */
add_action( 'woocommerce_after_main_content', 'eram_woo_after_main_content' );
if ( ! function_exists( 'eram_woo_after_main_content' ) ) {
    function eram_woo_after_main_content()
    {
        echo '';
    }
}

/**
 * ----------------------------------------------------------------------------------------
 *  Change number of products per row
 * ----------------------------------------------------------------------------------------
 */
add_filter( 'loop_shop_columns', 'eram_woo_loop_columns' );
if ( ! function_exists( 'eram_woo_loop_columns' ) ) {
    function eram_woo_loop_columns()
    {
        return eram_woo_get_option( 'eram_shop_cols', 4 );
    }
}

/**
 * ----------------------------------------------------------------------------------------
 *  Change number of products per page
 * ----------------------------------------------------------------------------------------
 */
add_filter( 'loop_shop_per_page', 'eram_woo_per_page', 20 );
if ( ! function_exists( 'eram_woo_per_page' ) ) {
    function eram_woo_per_page( $cols )
    {
        return eram_woo_get_option( 'eram_shop_items', 10 );
    }
}

function woocommerce_output_content_wrapper()
{
    return '';
}

function woocommerce_output_content_wrapper_end()
{
    return '';
}

/**
 * ----------------------------------------------------------------------------------------
 *  Hide Sorting
 * ----------------------------------------------------------------------------------------
 */
if ( eram_woo_get_option( 'eram_shop_sorting', 1 ) == 0 ) {
    add_filter( 'eram_wc_show_product_sorting', '__return_false' );
}

/**
 * ----------------------------------------------------------------------------------------
 *  Remove Actions
 * ----------------------------------------------------------------------------------------
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20, 0 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30, 0 );

/**
 * ----------------------------------------------------------------------------------------
 *  Handle Shop sideabr
 * ----------------------------------------------------------------------------------------
 */

add_action( 'woocommerce_before_shop_loop', 'eram_woo_shop_products_container_before' );
add_action( 'woocommerce_after_shop_loop', 'eram_woo_shop_products_container_after' );

if ( ! function_exists( 'eram_woo_shop_products_container_before' ) ) {
    function eram_woo_shop_products_container_before()
    {
        $shop_layout = eram_woo_get_option( 'eram_shop_layout', 'full' );
        switch ( $shop_layout ) {
            case 'sidebar-left':
                $shop_class = 'has-sidebar';
                $products_col_class = 'col-md-9 col-md-push-3';
                break;
            case 'sidebar-right':
                $shop_class = 'has-sidebar';
                $products_col_class = 'col-md-9';
                break;
            default:
                $shop_class = 'no-sidebar';
                $products_col_class = 'col-md-12';
        }
        $cols = eram_woo_get_option( 'eram_shop_cols', 4 );
        $shop_class .= ' has-' . $cols . '-cols';
        echo '<div class="row ' . $shop_class . '">';
        echo '<div class="products-container ' . $products_col_class . '">';
    }
}

if ( ! function_exists( 'eram_woo_shop_products_container_after' ) ) {
    function eram_woo_shop_products_container_after()
    {
        $shop_layout = eram_woo_get_option( 'eram_shop_layout', 'full' );

        // close products-container
        echo "</div>";

        if ( $shop_layout != 'full' ) {
            $side_class = $shop_layout == 'sidebar-left' ? 'col-md-pull-9' : '';
            echo '<div class="col-md-3 ' . $side_class . '">';
            echo '<div id="em-sidebar" class="em-sidebar ' . $shop_layout . '">';
            dynamic_sidebar( 'eram-shop-sidebar' );
            echo '</div>';
            echo '</div>';
        }

        echo "</div>";
    }
}
/**
 * ----------------------------------------------------------------------------------------
 *  Add add to cart icon before title
 * ----------------------------------------------------------------------------------------
 */
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10, 0 );

/**
 * ----------------------------------------------------------------------------------------
 *  filter pagination
 * ----------------------------------------------------------------------------------------
 */
add_filter( 'woocommerce_pagination_args', 'eram_woo_pagination_args', 10 );
if ( ! function_exists( 'eram_woo_pagination_args' ) ) {
    function eram_woo_pagination_args( $args )
    {
        $args['prev_text'] = '<i class="ol ol-left"></i>';
        $args['next_text'] = '<i class="ol ol-right"></i>';

        return $args;
    }
}


/**
 * ----------------------------------------------------------------------------------------
 *  Place a cart icon with number of items and total cost in the menu bar.
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'earm_woo_show_mini_cart' ) ) {
    function earm_woo_show_mini_cart()
    {
        $cart_items_count = WC()->cart->cart_contents_count;

        echo '<a id="shop-cart-icon" href="' . wc_get_cart_url() . '">';
        echo '<i class="ol ol-shopping_bag"></i>';
        echo '<span class="counter">' . $cart_items_count . '</span>';
        echo '</a>';//shop-cart-icon
    }
}

/**
 * ----------------------------------------------------------------------------------------
 *  Move rating at single to top of title
 * ----------------------------------------------------------------------------------------
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 2 );

/**
 * ----------------------------------------------------------------------------------------
 *  Remove title from description tab
 * ----------------------------------------------------------------------------------------
 */
add_filter( 'woocommerce_product_description_heading', 'eram_woo_remove_description_title', 10 );
add_filter( 'woocommerce_product_additional_information_heading', 'eram_woo_remove_description_title', 10 );
function eram_woo_remove_description_title( $heading )
{
    return '';
}


/**
 * ----------------------------------------------------------------------------------------
 * get shop featured image
 * ----------------------------------------------------------------------------------------
 */
function eram_woo_get_shop_featured_image_id()
{
    if ( is_shop() ) {
        $shop = get_option( 'woocommerce_shop_page_id' );
        if ( has_post_thumbnail( $shop ) ) {
            return get_post_thumbnail_id( $shop );
        }
    }

    return FALSE;
}

/**
 * ----------------------------------------------------------------------------------------
 *  Changes the subcategory title
 * ----------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woocommerce_template_loop_category_title' ) ) {

    /**
     * Show the subcategory title in the product loop.
     */
    function woocommerce_template_loop_category_title( $category )
    {
        ?>
        <h3>
            <?php

            echo $category->name;

            if ( $category->count > 0 )
                echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">' . $category->count . ' ' . apply_filters( 'eram_woo_subcategory_item_count_lable', esc_html__( 'items', 'eram' ) ) . '</mark>', $category );

            ?>
        </h3>
        <?php
    }
}

/**
 * ----------------------------------------------------------------------------------------
 *  force subcategory image size
 * ----------------------------------------------------------------------------------------
 */
add_filter( 'subcategory_archive_thumbnail_size', 'eram_woo_force_subcategory_thumb_size', 10 );

if ( ! function_exists( 'eram_woo_force_subcategory_thumb_size' ) ) {
    function eram_woo_force_subcategory_thumb_size($size)
    {
        global $eram_woo_category_thumb_large;

        if ( isset($eram_woo_category_thumb_large) )
            return 'large';

        return $size;
    }
}

/**
 * ----------------------------------------------------------------------------------------
 *  Remove up-sell display form product single
 * ----------------------------------------------------------------------------------------
 */
remove_action('woocommerce_after_single_product_summary','woocommerce_upsell_display', 15);

/**
 * ----------------------------------------------------------------------------------------
 *  Remove cross sel from cart
 * ----------------------------------------------------------------------------------------
 */
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );


/**
 * ----------------------------------------------------------------------------------------
 *  Ajax update cart count
 * ----------------------------------------------------------------------------------------
 */

add_action( 'wp_ajax_eram_get_woo_cart_count', 'eram_get_woo_cart_count' );
add_action( 'wp_ajax_nopriv_eram_get_woo_cart_count', 'eram_get_woo_cart_count' );

if ( ! function_exists('eram_get_woo_cart_count') )
{
    function eram_get_woo_cart_count()
    {
        echo json_encode(WC()->cart->cart_contents_count);
        wp_die();
    }
}
