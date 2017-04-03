<?php
/**
 * Eram Clients Helper Functions
 *
 * @since 1.0.0
 *
 * @package Eram Plugin
 * @author  owwwlab
 */

if ( ! function_exists( 'eram_portfolio_change_title_text' ) ) {
    function eram_portfolio_change_title_text( $title )
    {
        $screen = get_current_screen();

        if ( ERAM_FOLIO_CPT_NAME == $screen->post_type ) {
            $title = __( 'Enter Portfolio Name', 'eram' );
        }

        return $title;
    }
}
add_filter( 'enter_title_here', 'eram_portfolio_change_title_text' );


// add featured thumbnail to admin post columns
function eram_portfolio_add_columns( $columns )
{
    $columns['portfolio_cover'] = __( 'Cover', 'eram' );

    return $columns;
}

function eram_portfolio_add_columns_data( $column, $post_id )
{
    switch ( $column ) {
        case 'portfolio_cover':
            $url = '';
            if ( eram_portfolio_has_cover( $post_id ) )
                $url = eram_portfolio_get_cover_image( $post_id, 'thumbnail', TRUE );
            else
                $url = ERAM_IMAGES . '/no-image.jpg';
            echo '<a href="' . get_edit_post_link() . '">';
            echo '<img src="' . $url . '" width="40" height="40" />';
            echo '</a>';
            break;
    }
}

if ( function_exists( 'add_theme_support' ) ) {
    add_filter( 'manage_' . ERAM_FOLIO_CPT_NAME . '_posts_columns', 'eram_portfolio_add_columns' );
    add_action( 'manage_' . ERAM_FOLIO_CPT_NAME . '_posts_custom_column', 'eram_portfolio_add_columns_data', 10, 2 );
}


if ( ! function_exists( 'portfolio_helper' ) ) {
    function portfolio_helper( $object_id = NULL )
    {

        $imgIDs_array = eg_get_portfolio_archive_images( $object_id );
        $portfolio_layout = epf_get_option( 'epf_archive_layout', 'v_grid', $object_id );

        $class_to_load = 'eg_pf_' . $portfolio_layout . '_class';

        if ( ! class_exists( $class_to_load ) ) {
            $class_to_load = 'eg_class';
        }

        $return = '' != $imgIDs_array ? $class_to_load::get_instance( $object_id, $imgIDs_array ) : FALSE;

        return $return;
    }
}

if ( ! function_exists( 'eg_get_portfolio_archive_images' ) ) {
    function eg_get_portfolio_archive_images( $term_slug = '' )
    {
        $imgs = array();
        $conf = array(
            'post_type'   => ERAM_FOLIO_CPT_NAME,
            'numberposts' => -1
        );

        global $eram_gallery_page_is;
        $page_is = $eram_gallery_page_is;

        if ( is_tax() || $page_is == 'is_tax' ) {

            $conf['tax_query'] = array(
                array(
                    'taxonomy'         => ERAM_FOLIO_TAX_NAME,
                    'field'            => 'slug',
                    'terms'            => $term_slug,
                    'include_children' => TRUE
                )
            );
        }

        $posts = get_posts( $conf );

        foreach ( $posts as $post ) {
            $image_id = get_post_thumbnail_id( $post->ID );
            if ( empty( $image_id ) ) {
                // try to get cover meta instead
                $image_id = get_post_meta( $post->ID, '_epf_cover_image', TRUE );
            }
            if ( empty($image_id) )
                $image_id = 0;
            $imgs[ $post->ID ] = $image_id;
        }

        return $imgs;
    }
}

if ( ! function_exists( 'epf_get_option' ) ) {
    function epf_get_option( $key, $default, $object_id = FALSE, $is_general = FALSE )
    {
        
        $option_id = 'epf_settings';

        // get saved option from customizer theme_mode

        global $eram_portfolio_page_is;
        global $eram_queried_options;

        $page_is = $eram_portfolio_page_is;

        $use_get = FALSE;
        $use_queried_options = FALSE;
        $option = $default;

        // check if we have url parameter for this
        if ( isset( $_GET[ $key ] ) ) {
            $use_get = TRUE;
        }
        elseif ( isset( $eram_queried_options[ $key ] ) ) {
            $use_queried_options = TRUE;
        }

        if ( $use_get ) {
            $option = sanitize_text_field( wp_unslash( $_GET[ $key ] ) );
        }
        elseif ( $use_queried_options ) {
            $option = sanitize_text_field( wp_unslash( $eram_queried_options[ $key ] ) );
        }
        else {
            if( $is_general ){
                // this is a general option and not specific for archive or a category
                $option = Eram_Kirki::get_option( $option_id, $key, $default );
            }
            elseif ( is_singular( ERAM_FOLIO_CPT_NAME ) || $page_is == 'is_singular' ) {
                $option = get_post_meta( $object_id, $key, TRUE );
            }
            elseif ( is_tax( ERAM_FOLIO_TAX_NAME ) || $page_is == 'is_tax' ) {
                $option = Eram_Kirki::get_option( $option_id, $key . '__' . $object_id . '_epf_cat', $default );
            }
            else {
                $option = Eram_Kirki::get_option( $option_id, $key, $default );
            }
        }

        if ( is_null( $option ) || $option == '' ) {
            $option = $default;
        }

        // convert on-off at option tree to true/false as customizer doese
        if ( $option == 'on' ) {
            $option = TRUE;
        }
        elseif ( $option == 'off' ) {
            $option = FALSE;
        }

        return $option;

    }
}

if ( ! function_exists( 'epf_get_post_class' ) ) {
    function epf_get_post_class( $post_id )
    {
        $class = array();

        // metabox classes
        $metas = get_post_meta( $post_id );
        foreach ( $metas as $metakey => $meta_data ) {
            if ( substr( $metakey, 0, 10 ) === "_epf_meta_" && ! in_array( $metakey, array( '_epf_meta_link_url', '_epf_meta_link_label' ) ) ) {
                if ( $meta_data[0] != '' ) {
                    if ( $metakey == '_epf_meta_date' ) {
                        $class[] = substr( $meta_data[0], 0, 4 );
                    }
                    else {
                        $class[] = sanitize_title_with_dashes( $meta_data[0] );
                    }

                }
            }
        }

        // categories
        $cats = get_the_terms( $post_id, ERAM_FOLIO_TAX_NAME );
        if ( $cats ) {
            foreach ( $cats as $cat ) {
                $class[] = 'category-' . $cat->slug;
            }
        }


        return ' ' . implode( ' ', $class );
    }
}


/**
 * gallery infinite scroll hook
 */
if ( ! function_exists( 'eram_portfolio_infinite_scroll' ) ) {
    function eram_portfolio_infinite_scroll()
    {
        global $eram_portfolio_page_is;
        global $eram_queried_options;

        if ( ! empty( $_POST['options'] ) ) {
            parse_str( sanitize_text_field( wp_unslash( $_POST['options'] ) ), $eram_queried_options );
        }

        $object_id = '';
        if ( ! empty( $_POST['post_id'] ) ) {
            $object_id = sanitize_text_field( wp_unslash( $_POST['post_id'] ) );
        }


        $page_is = sanitize_text_field( wp_unslash( $_POST['page_is'] ) );

        if ( empty ( $page_is ) ) {
            echo 0;
            die();
        }

        $eram_portfolio_page_is = $page_is;

        $eram_portfolio = portfolio_helper( $object_id );

        $out = '';
        foreach ( $eram_portfolio->get_gallery_image_ids() as $ref_id => $imgID ) {
            $out .= $eram_portfolio->get_image_markup( $imgID, $ref_id );
        }
        echo $out;

        die();
    }
}

// for logged in user
add_action( 'wp_ajax_eram_portfolio_infinite_scroll', 'eram_portfolio_infinite_scroll' );
// if user not logged in
add_action( 'wp_ajax_nopriv_eram_portfolio_infinite_scroll', 'eram_portfolio_infinite_scroll' );


if ( ! function_exists( 'epf_get_hover_style' ) ) {
    /**
     * Gets Hover style for portfolio archive item
     * @param string $img_html
     * @param string $href
     * @param int $ref_id
     * @param string $hover_style
     * @param string $wrapper_class
     * @return string
     */
    function epf_get_hover_style( $img_html = "", $href = '#', $ref_id = 0, $hover_style = 'hover-1', $wrapper_class = '' )
    {
        $o = '';
        switch ( $hover_style ) {
            case 'hover-2': // pf-hover-2
                $o .= "<a href=\"{$href}\" class='" . $wrapper_class . " gl-wrapper em-hover pf-hover-2'>";
                $o .= "<div class='hover-wrapper'>";
                $cats = eram_list_terms( $ref_id, ERAM_FOLIO_TAX_NAME );
                if ( ! empty( $cats ) )
                    $o .= "<h4 class='subtitle'>" . $cats . "</h4>";
                $o .= "<h3 class='title'>" . get_the_title( $ref_id ) . "</h3>";
                $o .= "</div>";
                $o .= $img_html;
                $o .= '</a>';
                break;
            default: // pf-hover-1
                $o .= "<a href=\"{$href}\" class='" . $wrapper_class . " gl-wrapper em-hover pf-hover-1'>";
                $o .= "<div class='description'>";
                $o .= "<h3 class='title'>" . get_the_title( $ref_id ) . "</h3>";
                $cats = eram_list_terms( $ref_id, ERAM_FOLIO_TAX_NAME );
                if ( ! empty( $cats ) )
                    $o .= "<h4 class='subtitle'>" . $cats . "</h4>";
                $o .= "</div>";
                $o .= $img_html;
                $o .= '</a>';
        }

        return $o;
    }
}


/**
 * Display a custom taxonomy dropdown in admin
 */
add_action( 'restrict_manage_posts', 'eram_filter_portfolio_by_category' );
function eram_filter_portfolio_by_category()
{
    global $typenow;
    $post_type = ERAM_FOLIO_CPT_NAME;
    $taxonomy = ERAM_FOLIO_TAX_NAME;
    if ( $typenow == $post_type ) {
        $selected = isset( $_GET[ $taxonomy ] ) ? $_GET[ $taxonomy ] : '';
        $info_taxonomy = get_taxonomy( $taxonomy );
        wp_dropdown_categories( array(
            'show_option_all' => __( "Show All {$info_taxonomy->label}" ),
            'taxonomy'        => $taxonomy,
            'name'            => $taxonomy,
            'orderby'         => 'name',
            'selected'        => $selected,
            'show_count'      => TRUE,
            'hide_empty'      => TRUE,
        ) );
    };
}

/**
 * Filter posts by taxonomy in admin
 */
add_filter( 'parse_query', 'eram_convert_id_to_term_in_portfolio_query' );
function eram_convert_id_to_term_in_portfolio_query( $query )
{
    global $pagenow;
    $post_type = ERAM_FOLIO_CPT_NAME;
    $taxonomy = ERAM_FOLIO_TAX_NAME;
    $q_vars = &$query->query_vars;
    if ( $pagenow == 'edit.php' && isset( $q_vars['post_type'] ) && $q_vars['post_type'] == $post_type && isset( $q_vars[ $taxonomy ] ) && is_numeric( $q_vars[ $taxonomy ] ) && $q_vars[ $taxonomy ] != 0 ) {
        $term = get_term_by( 'id', $q_vars[ $taxonomy ], $taxonomy );
        $q_vars[ $taxonomy ] = $term->slug;
    }
}


/**
 * Checks if portfolio has cover image
 * @param $post_id
 * @return bool
 */
function eram_portfolio_has_cover( $post_id )
{
    $post_id=is_object($post_id)?$post_id->ID:$post_id;
    $image_id = get_post_meta( $post_id, '_epf_cover_image', TRUE );

    return !empty($image_id);


}

/**
 * Gets the cover image of the portfolio post
 * @param $post_id
 * @param string $size
 * @param bool $only_src
 * @return array|false
 */
function eram_portfolio_get_cover_image( $post_id, $size = 'full', $only_src = FALSE )
{
    $image_id = get_post_meta( $post_id, '_epf_cover_image', TRUE );

    if ( empty( $image_id ) )
        return FALSE;

    $url = wp_get_attachment_image_src( $image_id, $size );

    if ( $only_src )
        return $url[0];
    else
        return $url;
}

function eram_portfolio_has_featured_or_cover($post_id = 0)
{
    $post_id = is_object($post_id) ? $post_id->ID : $post_id;
    
    $image_id = get_post_thumbnail_id( $post_id );
    if ( empty( $image_id ) ) {
        // try to get cover meta instead
        $image_id = get_post_meta( $post_id, '_epf_cover_image', TRUE );
    }

    return !empty($image_id);
}

function eram_portfolio_get_featured_image( $post_id = 0, $size = 'full', $only_src = FALSE )
{
    $image_id = get_post_thumbnail_id( $post_id );

    if ( empty( $image_id ) ) {
        // try to get cover meta instead
        $image_id = get_post_meta( $post_id, '_epf_cover_image', TRUE );
    }

    if ( empty( $image_id ) )
        return FALSE;

    $url = wp_get_attachment_image_src( $image_id, $size );

    if ( $only_src )
        return $url[0];
    else
        return $url;
}

