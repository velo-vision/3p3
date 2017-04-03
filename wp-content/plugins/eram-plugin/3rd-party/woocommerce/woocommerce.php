<?php
/**
 * Compatibility with woocommerce plugin
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'eram_woo_cats' ) ) {

    function eram_woo_cats( $atts )
    {

        extract( shortcode_atts( array(
            'number'     => 0,
            'orderby'    => 'title',
            'order'      => 'ASC',
            'columns'    => 3,
            'hide_empty' => 1,
            'ids'        => ''
        ), $atts ) );

        global $eram_woo_category_thumb_large;
        $eram_woo_category_thumb_large = true;
        
        return '<div class="shop-categories-list">' . do_shortcode( '[product_categories number="' . $number . '" orderby="' . $orderby . '" order="' . $order . '" columns="' . $columns . '" hide_empty="' . $hide_empty . '" ids="' . $ids . '"]' ) . '</div>';

    }

    add_shortcode( 'eram_woo_cats', 'eram_woo_cats' );
}


add_action( 'vc_after_init', 'eram_woo_add_shortcodes' );

function eram_woo_add_shortcodes()
{
    $order_by_values = array(
        '',
        __( 'Date', 'eram' )          => 'date',
        __( 'ID', 'eram' )            => 'ID',
        __( 'Author', 'eram' )        => 'author',
        __( 'Title', 'eram' )         => 'title',
        __( 'Modified', 'eram' )      => 'modified',
        __( 'Random', 'eram' )        => 'rand',
        __( 'Comment count', 'eram' ) => 'comment_count',
        __( 'Menu order', 'eram' )    => 'menu_order',
    );

    $order_way_values = array(
        '',
        __( 'Descending', 'eram' ) => 'DESC',
        __( 'Ascending', 'eram' )  => 'ASC',
    );

    vc_map(
        array(
            'name'        => __( 'Masonry Product categories', 'eram' ),
            'base'        => 'eram_woo_cats',
            'icon'        => 'icon-wpb-woocommerce',
            'category'    => __( 'WooCommerce', 'eram' ),
            'description' => __( 'Display product categories loop', 'eram' ),
            'params'      => array(
                array(
                    'type'        => 'textfield',
                    'heading'     => __( 'Number', 'eram' ),
                    'param_name'  => 'number',
                    'description' => __( 'The `number` field is used to display the number of products.', 'eram' ),
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => __( 'Order by', 'eram' ),
                    'param_name'  => 'orderby',
                    'std'         => 'title',
                    'value'       => $order_by_values,
                    'save_always' => TRUE,
                    'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'eram' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => __( 'Sort order', 'eram' ),
                    'param_name'  => 'order',
                    'std'         => 'DESC',
                    'value'       => $order_way_values,
                    'save_always' => TRUE,
                    'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'eram' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => __( 'Columns', 'eram' ),
                    'value'       => 3,
                    'param_name'  => 'columns',
                    'save_always' => TRUE,
                    'description' => __( 'How much columns grid', 'eram' ),
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => __( 'Hide empty', 'eram' ),
                    'param_name'  => 'hide_empty',
                    'std'         => 1,
                    'description' => __( 'Hide empty accepts 0 or 1', 'eram' ),
                ),
                array(
                    'type'        => 'autocomplete',
                    'heading'     => __( 'Categories', 'eram' ),
                    'param_name'  => 'ids',
                    'settings'    => array(
                        'multiple' => TRUE,
                        'sortable' => TRUE,
                    ),
                    'save_always' => TRUE,
                    'description' => __( 'List of product categories', 'eram' ),
                ),
            ),
        )
    );
}