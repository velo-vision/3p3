<?php
/**
 *  Assets functions for the theme
 *
 * @package Eram
 * @author owwwlab
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'eram_link_pages' ) )
{
    /**
     * Generates wp_link_pages with proper arguments.
     */
    function eram_link_pages ()
    {
        wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'eram' ),
            'after'  => '</div>',
        ) );
    }
}


if ( ! function_exists( 'eram_the_custom_logo' ) )
{
    /**
     *  Displays the optional custom logo.
     *  Does nothing if the custom logo is not available.
     */
    function eram_the_custom_logo ()
    {
        if ( function_exists( 'the_custom_logo' ) )
        {
            if (  ! has_custom_logo() ){
                echo sprintf( '<a href="%1$s" rel="home" itemprop="url">',esc_url( home_url( '/' ) ));
                echo '<h1 class="text-logo">'. get_bloginfo('name') .'</h1>';
                echo "</a>";
            }else{

                $logo_id = get_theme_mod( 'custom_logo' );
                $logo = wp_get_attachment_image_src($logo_id, 'full');

                $retina_logo = false;
                $retina_url = Eram_Kirki::get_option('eram_theme_options','eram_retina_logo','');
                if ( $retina_url )
                {
                    $retina_id = eram_get_image_by_url($retina_url);
                    $retina_logo = wp_get_attachment_image_src($retina_id, 'full');
                }

                $html = "";
                $html .= sprintf( '<a href="%1$s" class="eram-logo" rel="home" itemprop="url">',esc_url( home_url( '/' ) ));
                $html .= sprintf (
                        '<img src="%1$s" alt="%2$s" width="%3$s" height="%4$s" data-retina-width="%5$s" data-retina-height="%6$s" data-retina="%7$s" class="ol-retina">',
                        $logo[0],
                        get_bloginfo('name'),
                        $logo[1],
                        $logo[2],
                        $retina_logo[1],
                        $retina_logo[2],
                        $retina_logo[0]
                        );
                $html .= "</a>";

                echo $html;
            }
            
        }
    }
}

if ( ! function_exists( 'eram_dd' ) )
{
    function eram_dd ( $var )
    {
        echo "<pre>";
        var_dump( $var );
        echo "</pre>";
        die();
    }
}

if ( ! function_exists( 'eram_minify_html' ) )
{
    function eram_minify_html ( $var )
    {
        return preg_replace( array(
            '/ {2,}/',
            '/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s',
        ), array(
            ' ',
            '',
        ), $var );
    }
}


if ( ! function_exists( 'eram_breadcrumb' ) )
{
    function eram_breadcrumb ()
    {

        if ( ERAM_Kirki::get_option( 'eram_theme_options', 'eram_show_breadcrumbs', 1 ) )
        {
            eram_the_breadcrumbs();
        }

    }
}

/**
 * ----------------------------------------------------------------------------------------
 * Add custom breadcrumbs
 * ----------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'eram_the_breadcrumbs' ) )
{

    function eram_the_breadcrumbs ()
    {

        global $post;
        echo "<ul class='er-breadcrumbs'>";
        if ( ! is_home() )
        {

            echo "<li><a href='";
            echo home_url();
            echo "'>";
            echo bloginfo( 'name' );
            echo "</a></li>";

            if ( is_category() || is_single() )
            {

                //@TODO : Don't we need to search for custom taxonomies of the single page?

                $cats = get_the_category( $post->ID );

                foreach ( $cats as $cat )
                {
                    echo "<li>";
                    echo $cat->cat_name;
                    echo " </li> ";
                }
                if ( is_single() )
                {
                    echo "<li class='active'>";
                    the_title();
                    echo "</li>";
                }
            }
            elseif ( is_page() )
            {

                if ( $post->post_parent )
                {
                    $anc = get_post_ancestors( $post->ID );
                    $anc_link = get_page_link( $post->post_parent );

                    foreach ( $anc as $ancestor )
                    {
                        $output = "<li><a href=" . $anc_link . ">" . get_the_title( $ancestor ) . "</a> </li>";
                    }

                    echo $output;
                    echo "<li class='active'>";
                    the_title();
                    echo "</li>";

                }
                else
                {
                    echo "<li class='active'>";
                    the_title();
                    echo "</li>";
                }
            }
        }
        elseif ( is_tag() )
        {
            echo "<li class='active'>";
            single_tag_title();
            echo "</li>";
        }
        elseif ( is_day() )
        {
            echo "<li class='active'>";
            echo "Archive: ";
            the_time( 'F jS, Y' );
            echo '</li>';
        }
        elseif ( is_month() )
        {
            echo "<li class='active'>";
            echo "Archive: ";
            the_time( 'F, Y' );
            echo '</li>';
        }
        elseif ( is_year() )
        {
            echo "<li class='active'>";
            echo "Archive: ";
            the_time( 'Y' );
            echo '</li>';
        }
        elseif ( is_author() )
        {
            echo "<li class='active'>";
            echo "Author's archive: ";
            echo '</li>';
        }
        elseif ( isset( $_GET[ 'paged' ] ) && ! empty( $_GET[ 'paged' ] ) )
        {
            echo "<li class='active'>";
            echo "Blogarchive: ";
            echo '';
            echo "</li>";
        }
        elseif ( is_search() )
        {
            echo "<li class='active'>";
            echo "Search results: ";
            echo "</li>";
        }

        echo "</ul>";
    }
}


if ( ! function_exists( 'eram_get_post_meta' ) )
{
    function eram_get_post_meta ()
    {
        $metas = get_post_meta( get_the_ID() );

        return $metas;
    }
}

/**
 * Get a single meta value of a post
 */
if ( ! function_exists( 'eram_get_single_meta' ) )
{
    function eram_get_single_meta ( $key, $default )
    {
        $meta = get_post_meta( get_the_ID(), $key, TRUE );

        if ( is_null( $meta ) || $meta == '' ) $meta = $default;

        return $meta;
    }
}


if ( ! function_exists( 'eram_page_meta' ) )
{
    function eram_page_meta ( $key = '', $metas = '', $default = '' )
    {
        if ( ! is_array( $metas ) )
        {
            $metas = eram_get_post_meta();
        }
        if ( ! is_array( $metas ) ) return $default;

        if ( ! array_key_exists( $key, $metas ) ) return $default;

        return $metas[ $key ][ 0 ];
    }
}

/**
 * check if page has ... for on/off settings
 */
if ( ! function_exists( 'eram_has' ) )
{
    function eram_has ( $key, $metas = '', $default = FALSE )
    {
        if ( ! is_array( $metas ) )
        {
            $metas = eram_get_post_meta();
        }
        if ( ! array_key_exists( $key, $metas ) )
        {
            return $default;
        }
        else
        {
            if ( $metas[ $key ][ 0 ] == "on" )
            {
                return TRUE;
            }
            else if ( $metas[ $key ][ 0 ] == "off" )
            {
                return FALSE;
            }
            else if ( $metas[ $key ][ 0 ] == "" )
            {
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }

        return FALSE;

    }
}


/**
 * ----------------------------------------------------------------------------------------
 * Add custom breadcrumbs
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'eram_password_form' ) )
{
    function eram_password_form ()
    {


        global $post;
        $label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
        $title = ERAM_Kirki::get_option( 'eram_theme_options', 'eram_ppp_title', 'Password Protected Area' );
        $text = ERAM_Kirki::get_option( 'eram_theme_options', 'eram_ppp_text', 'This area is restricted and you need a password to access it.' );
        $o = '';
        $o .= '<div class="er-content"><h2 class="title">' . $title . '</h2><div class="description">' . $text . '</div><form class="m-top-50" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post" ><div class="row er-inline-form"><div class="col-sm-10"><label for="' . $label . '">' . esc_html__( "Password:",'eram' ) . ' </label><input name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" /></div><div class="col-sm-2"><input type="submit" name="Submit" value="' . esc_html__( "Send",'eram' ) . '" class="btn" /></div></div></form></div>';

        return $o;
    }
}
add_filter( 'the_password_form', 'eram_password_form' );




/**
 * inline styles for 404 page wrapper
 */
if ( ! function_exists( 'eram_404_inline_style' ) )
{
    function eram_404_inline_style ()
    {
        $st='';
        // background image
        if ( get_theme_mod( 'eram_404_bg' ) )
        {
            $st = 'background-image:url(' . get_theme_mod( 'eram_404_bg' ) . ');';
        }

        return $st;
    }
}

/**
 * truncate text to specified words count
 */
if ( ! function_exists( 'eram_limit_text' ) )
{
    function eram_limit_text ( $text, $limit = 40 )
    {
        if ( str_word_count( $text, 0 ) > $limit )
        {
            $words = str_word_count( $text, 2 );
            $pos = array_keys( $words );
            $text = substr( $text, 0, $pos[ $limit ] ) . '...';
        }

        return $text;
    }
}

/**
 * eram_get_social_sharings
 */
if ( ! function_exists( 'eram_get_social_sharings' ) )
{
    function eram_get_social_sharings ()
    {
        $social_sharings = Eram_Kirki::get_option( 'eram_theme_options', 'eram_social_sharings' );

        return $social_sharings;
    }
}

/**
 * return social sharing markup
 */
if ( ! function_exists( 'eram_add_sharing' ) )
{
    function eram_add_sharing ( $social_sharings, $return = FALSE, $url = '')
    {
        $url = !empty($url) ? urlencode($url) : '{url}';

        $links = array();
        foreach ( $social_sharings as $site ) {

            $media = ( $site['icon'] != 'none' ) ? $site['icon'] : '';

            switch ( $media ) {
                case 'facebook':
                    $pre_link = 'https://www.facebook.com/sharer/sharer.php?u='.$url.'&t={title}';
                    $title = esc_html__( 'Facebook', 'eram' );
                    break;
                case 'twitter':
                    $pre_link = 'https://twitter.com/share?url='.$url;
                    $title = esc_html__( 'Twitter', 'eram' );
                    break;
                case 'google-plus':
                    $pre_link = 'https://plus.google.com/share?url='.$url;
                    $title = esc_html__( 'Google Plus', 'eram' );
                    break;
                case 'digg':
                    $pre_link = 'http://digg.com/submit?url='.$url;
                    $title = esc_html__( 'Digg', 'eram' );
                    break;
                case 'pinterest':
                    $pre_link = 'https://pinterest.com/pin/create/bookmarklet/?media={img}&url='.$url;
                    $title = esc_html__( 'Pinterest', 'eram' );
                    break;
                case 'linkedin':
                    $pre_link = 'http://www.linkedin.com/shareArticle?url='.$url.'&title={title}';
                    $title = esc_html__( 'LinkeIn', 'eram' );
                    break;
                case 'tumblr':
                    $pre_link = 'http://www.tumblr.com/share/link?url='.$url.'&name={title}';
                    $title = esc_html__( 'Tumblr', 'eram' );
                    break;
                case 'reddit':
                    $pre_link = 'http://reddit.com/submit?url='.$url.'&title={title}';
                    $title = esc_html__( 'Reddit', 'eram' );
                    break;
                case 'delicious':
                    $pre_link = 'https://delicious.com/save?v=5&provider=&noui&jump=close&url='.$url.'&title={title}';
                    $title = esc_html__( 'Delicious', 'eram' );
                    break;
                default:
                    $pre_link = '';
                    $title = '';
                    break;
            }
            $this_link = '';

            if ( $pre_link != '' ) {
                $this_link = '<li><a title="' . $title . '" class="sharing-link share-' . $media . '" href="' . $pre_link . '" target="_blank"><i class="fa fa-' . $media . '"></i></a></li>';
            }

            $links[] = $this_link;
        }

        $output = '<div id="social-sharing" class="layout-margin" title="' . esc_html__( 'Share', 'eram' ) . '">';
        $output .= '<ul class="share-icons">' . implode( '', $links ) . '</ul>';
        $output .= '<div class="share-trigger"></div>';
        $output .= '</div>';

        if ( $return ) return $output;
        else
            echo $output;

    }
}



/**
 * Decide about the site layout from $_GET[] or theme_mod
 */
if ( ! function_exists( 'eram_get_site_layout' ) )
{
    function eram_get_site_layout ()
    {

        if ( isset( $_GET[ 'eram_site_layout' ] ) )
        {
            $acceptable_options = array(
                'side',
                'bordered',
                'classic',
                'top',
            );

            if ( in_array( $_GET[ 'eram_site_layout' ], $acceptable_options ) )
            {
                return $_GET[ 'eram_site_layout' ];
            }
        }

        // return it from theme_mod
        return Eram_kirki::get_option( 'eram_theme_options', 'eram_site_layout', 'bordered' );
    }
}


/**
 *
 */
if ( ! function_exists( 'eram_get_gallery_page_layout' ) )
{
    function eram_get_gallery_page_layout ( $object_id )
    {

        $has_details = eg_get_gallery_option( 'eg_has_details', 'off', $object_id );
        $details_position = eg_get_gallery_option( 'eg_details_position', 'top', $object_id );

        if ( is_post_type_archive( ERAM_GALLERY_CPT_NAME ) || is_tax( ERAM_GALLERY_CATEGORY_TAX ) )
        {
            $gallery_layout = eg_get_gallery_option( 'eg_archive_layout', 'simple_horizontal', $object_id );
        }
        else
        {
            $gallery_layout = eg_get_gallery_option( 'eg_gallery_layout', 'simple_horizontal', $object_id );
        }


        $force_fullscreen = array(
            'slider',
            'kenburn',
            'dcarousel',
        );

        if ( $has_details && ! in_array( $gallery_layout, $force_fullscreen ) )
        {
            if ( $details_position == 'top' )
            {
                $layout = 'title-top';
            }
            elseif ( $details_position == 'side' )
            {
                $layout = 'title-side';
            }
            else
            {
                $layout = 'fullscreen';
            }
        }
        else
        {
            $layout = 'fullscreen';
        }

        return $layout;
    }
}


if ( ! function_exists( 'eram_gallery_page_cover_image' ) )
{
    /**
     * provides class and image for gallery side and top
     *
     * @param $object_id : postID or archive
     * @return array
     */
    function eram_gallery_page_cover_image ( $object_id )
    {
        $has_details = eg_get_gallery_option( 'eg_has_details', 'off', $object_id );
        if ( is_singular( ERAM_GALLERY_CPT_NAME ) )
        {

            $has_cover = eg_get_gallery_option( 'eg_has_cover', 'off', $object_id );

            if ( $has_cover && $has_details && has_post_thumbnail( $object_id ) )
            {
                return array(
                    'class'     => 'em-has-cover',
                    'image_url' => get_the_post_thumbnail_url()
                    // this only works for single gallery
                );
            }
        }
        else
        {
            $has_cover = eg_get_gallery_option( 'eg_archive_cover', '', $object_id );
            if ( $has_cover && $has_details )
            {
                return array(
                    'class'     => 'em-has-cover',
                    'image_url' => $has_cover,
                );
            }
        }

        return array(
            'class'     => '',
            'image_url' => 'none',
        );

    }
}

if ( ! function_exists( 'eram_format_date' ) )
{
    function eram_format_date ()
    {
        $date = get_the_date( 'd M y', get_the_ID() );
        $date = explode( ' ', $date );
        echo '<span>' . $date[ 0 ] . '</span>';
        echo '<span>' . $date[ 1 ] . ' ' . $date[ 2 ] . '</span>';
    }
}


if ( ! function_exists( 'eram_inline_post_cats' ) )
{
    function eram_inline_post_cats ( $post_id = NULL )
    {
        if ( is_null( $post_id ) )
        {
            $post_id = get_the_ID();
        }
        $cats = wp_get_post_categories( $post_id );
        $args = array(
            'include'      => $cats,
            'hierarchical' => 0,
            'orderby'      => 'count',
            'title_li'     => '',
        );
        wp_list_categories( $args );
    }
}

if ( ! function_exists( 'eram_show_user_contact_info' ) )
{
    function eram_show_user_contact_info ()
    {

        $social_contacts = array();

        $website_link = esc_url( get_the_author_meta( 'user_url' ) );
        $twitter_link = esc_url( get_the_author_meta( '_eram_twitter' ) );
        $facebook_link = esc_url( get_the_author_meta( '_eram_facebook' ) );
        $googleplus_link = esc_url( get_the_author_meta( '_eram_google-plus' ) );
        $instagram_link = esc_url( get_the_author_meta( '_eram_instagram' ) );
        $p500px_link = esc_url( get_the_author_meta( '_eram_500px' ) );
        $pinterest_link = esc_url( get_the_author_meta( '_eram_pinterest' ) );

        if ( $website_link != '' ) $social_contacts[ 'website' ] = array(
            'title' => esc_html__( 'My Website', 'eram' ),
            'url'   => $website_link,
        );
        if ( $twitter_link != '' ) $social_contacts[ 'twitter' ] = array(
            'title' => esc_html__( 'Twitter', 'eram' ),
            'url'   => $twitter_link,
        );
        if ( $facebook_link != '' ) $social_contacts[ 'facebook' ] = array(
            'title' => esc_html__( 'Facebook', 'eram' ),
            'url'   => $facebook_link,
        );
        if ( $googleplus_link != '' ) $social_contacts[ 'google+' ] = array(
            'title' => esc_html__( 'Google +', 'eram' ),
            'url'   => $googleplus_link,
        );
        if ( $instagram_link != '' ) $social_contacts[ 'instagram' ] = array(
            'title' => esc_html__( 'Instagram', 'eram' ),
            'url'   => $instagram_link,
        );
        if ( $p500px_link != '' ) $social_contacts[ '500px' ] = array(
            'title' => esc_html__( '500px', 'eram' ),
            'url'   => $p500px_link,
        );
        if ( $pinterest_link != '' ) $social_contacts[ 'pinterest' ] = array(
            'title' => esc_html__( 'Pinterest', 'eram' ),
            'url'   => $pinterest_link,
        );

        if ( count( $social_contacts ) > 0 )
        {
            echo "<div class='author-contact'>";
            esc_html_e( 'Keep up with me on', 'eram' );
            foreach ( $social_contacts as $sc )
            {
                echo "<a href='{$sc['url']}'>{$sc['title']}</a>";
            }
            echo "</div>";
        }

    }
}

function eram_all_posts_link ()
{
    if ( 'page' == get_option( 'show_on_front' ) )
    {
        if ( get_option( 'page_for_posts' ) )
        {
            return esc_url( get_permalink( get_option( 'page_for_posts' ) ) );
        }
        else
        {
            return esc_url( home_url( '/?post_type=post' ) );
        }
    }
    else
    {
        return esc_url( home_url( '/' ) );
    }
}

if ( ! function_exists( 'eram_get_meta_values' ) )
{
    function eram_get_meta_values ( $key = '', $type = 'post', $status = 'publish' )
    {

        global $wpdb;

        if ( empty( $key ) ) return;

        $r = $wpdb->get_results( $wpdb->prepare( "
            SELECT pm.meta_value AS name, count(*) AS count  FROM {$wpdb->postmeta} pm
            LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
            WHERE pm.meta_key = '%s'
            AND pm.meta_value != '' 
            AND p.post_type = '%s'
            AND p.post_status = '%s'
            GROUP BY pm.meta_value
            ORDER BY pm.meta_value          
            ", $key, $type, $status ) );

        return $r;
    }
}

if ( ! function_exists( 'eram_list_meta_values' ) )
{
    function eram_list_meta_values ( $key = '', $type = 'post', $title = '', $show_count = FALSE )
    {
        $out = '';

        if ( is_array( $key ) ) $key = $key[ 0 ];

        $meta_values = eram_get_meta_values( $key, $type, 'publish' );
        // group date by year
        if ( $key == '_epf_meta_date' )
        {
            $tmp = array();
            foreach ( $meta_values as $val )
            {

                $val->name = substr( $val->name, 0, 4 );

                if ( ! isset( $tmp[ $val->name ] ) ) $tmp[ $val->name ] = 0;
                $tmp[ $val->name ] += $val->count;
            }
            $i = 0;
            $meta_values = array();
            foreach ( $tmp as $year => $count )
            {
                $this_item = new StdClass;
                $this_item->name = $year;
                $this_item->count = $count;

                $meta_values[ $i ] = $this_item;
                $i++;
            }
        }
        $out .= '<div class="' . $key . '">' . $title;

        if ( count( $meta_values ) > 0 )
        {
            $out .= '<ul>';
            $out .= '<li data-filter="*" class="active"><a href="#">' . esc_html__( 'All', 'eram' ) . '</a></li>';
            foreach ( $meta_values as $value )
            {
                $out .= '<li data-filter=".' . sanitize_title_with_dashes( $value->name ) . '"><a href="#">' . $value->name . '</a>';
                if ( $show_count )
                {
                    $out .= ' (' . $value->count . ')';
                }
                $out .= '</li>';
            }
            $out .= '</ul>';
        }
        else
        {
            $out .= '<ul>';
            $out .= '<li data-filter="*" class="active"><a href="#">' . esc_html__( 'All', 'eram' ) . '</a></li>';
            $out .= '</ul>';
        }

        $out .= '</div>';

        return $out;
    }
}

function recursive_array_search ( $needle, $haystack )
{
    foreach ( $haystack as $key => $value )
    {
        $current_key = $key;
        if ( $needle === $value OR ( is_array( $value ) && recursive_array_search( $needle, $value ) ) )
        {
            return $current_key;
        }
    }

    return FALSE;
}

class eram_Walker_Category extends Walker_Category
{

    public function start_el ( &$output, $category, $depth = 0, $args = array(), $id = 0 )
    {
        parent::start_el( $output, $category, $depth, $args );
        $find = '<li class="cat-item cat-item-' . $category->term_id . '">';
        $replace = '<li data-filter=".category-' . $category->slug . '" class="cat-item cat-item-' . $category->term_id . '">';
        $output = str_replace( $find, $replace, $output );

    }
}

if ( ! function_exists( 'eram_get_permalink' ) )
{
    function eram_get_permalink ( $post_id )
    {
        // get post meta
        $gallery_redirect_meta = get_post_meta( $post_id, '_eg_redirect', TRUE );
        $portfolio_redirect_meta = get_post_meta( $post_id, '_epf_redirect', TRUE );

        if ( ! empty( $gallery_redirect_meta ) )
        {
            return $gallery_redirect_meta;
        }
        elseif ( ! empty( $portfolio_redirect_meta ) )
        {
            return $portfolio_redirect_meta;
        }

        return get_permalink( $post_id );
    }
}

if ( ! function_exists( 'eram_list_terms' ) )
{
    function eram_list_terms ( $post_id = 0, $taxonomy = 'category', $linkable = FALSE )
    {
        // Get a list of terms for this post's custom taxonomy.
        $terms = get_the_terms( $post_id, $taxonomy );

        if ( ! $terms ) return '';

        // Renumber array.
        $terms = array_values( $terms );

        $out = '';
        for ( $cat_count = 0; $cat_count < count( $terms ); $cat_count++ )
        {

            if ( $linkable ) $out .= '<a href="' . get_term_link( $terms[ $cat_count ], $taxonomy ) . '">';

            $out .= '<span>' . $terms[ $cat_count ]->name . '</span>';

            if ( $linkable ) $out .= '</a>';


            // If there is more than one term, comma separate them.
            if ( $cat_count < count( $terms ) - 1 )
            {
                $out .= ', ';
            }
        }

        return $out;
    }
}


function earm_generateRandomString ( $length = 10 )
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen( $characters );
    $randomString = '';
    for ( $i = 0; $i < $length; $i++ )
    {
        $randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
    }

    return $randomString;
}

/**
 * eram_transform_piped_text
 */
if ( ! function_exists( 'eram_transform_piped_text' ) )
{
    function eram_transform_piped_text ( $string )
    {
        $split = explode( "|", $string );
        if ( count( $split ) > 1 )
        {
            $title = $split[ 0 ];
            unset( $split[ 0 ] );
            $text = implode( '', $split );

            return '<div class="splited-text"><h3>' . $title . '</h3><p>' . $text . '</p></div>';
        }
        else
        {
            return $string;
        }
    }
}

/**
* get customizer single blog settings
*/
if ( ! function_exists('eram_get_customizer_single_option') )
{
    function eram_get_customizer_single_option($key,$default) {
        
        // check if we have url parameter for this
        $use_get = false;
        if ( isset( $_GET[ $key ] ) ) {
            $option = sanitize_text_field( wp_unslash( $_GET[ $key ] ) );
        }
        else
        {
            $option = Eram_Kirki::get_option( 'eram_theme_options', $key, $default );
        }

        // convert on-off at option tree to true/false as customizer
        if ( $option == 'on' ) {
            $option = TRUE;
        }
        elseif ( $option == 'off' ) {
            $option = FALSE;
        }

        return $option;

    }
}

if ( ! function_exists( 'eram_get_blog_option' ) )
{
    function eram_get_blog_option ( $key, $default, $post_id=0 )
    {
        // check if we have url parameter for this
        $use_get = false;
        if ( isset( $_GET[ $key ] ) ) {
            $use_get = TRUE;
        }

        if ( $use_get )
        {
            $option = sanitize_text_field( wp_unslash( $_GET[ $key ] ) );
        }
        else{
            if ( is_archive() || is_home() || is_tax() )
            {
                $option = Eram_Kirki::get_option( 'eram_theme_options', $key, $default );
            }
            else
            {
                $option = get_post_meta($post_id,$key,true);
            }
        }

        if ( is_null( $option ) || $option == '' ) {
            $option = $default;
        }

        // convert on-off at option tree to true/false as customizer
        if ( $option == 'on' ) {
            $option = TRUE;
        }
        elseif ( $option == 'off' ) {
            $option = FALSE;
        }

        return $option;

    }
}


function eram_get( $var, $isset = false ) {
    if ( ! isset( $_REQUEST[ $var ] ) ) {
        return null;
    }

    return $isset ? true : $_REQUEST[ $var ];
}
function eram_get_image_by_url($image_url) {
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));
    return $attachment[0];
}

/**
* checks if the exifography function exists and uses it
*/
if ( ! function_exists('eram_exifography_display_exif') )
{
    function eram_exifography_display_exif($setting = NULL ,$post_id = 0, $force_filter = false) {
        if ( function_exists('exifography_display_exif') )
        {
            if ( $force_filter )
                add_filter('exifography_display_exif', 'eram_exifography_filter');

            return exifography_display_exif($setting, $post_id);
        }

        return NULL;
    }
}

/**
 * Show shop mini cart if needed
 */

if ( ! function_exists('eram_shop_mini_cart') )
{
    function eram_shop_mini_cart(){
        if ( class_exists('WooCommerce') )
        {
            earm_woo_show_mini_cart();
        }
    }
}

/**
 * show footer
 */
if ( ! function_exists('eram_footer') )
{
    function eram_footer()
    {
        $display= Eram_Kirki::get_option( 'eram_theme_options', 'eram_footer_display', 1 );
        if ( !$display )
            return;

        //Get options values
        $layout_width=Eram_Kirki::get_option( 'eram_theme_options', 'eram_footer_layout_width', 'contained' );
        $widgetized=Eram_Kirki::get_option( 'eram_theme_options', 'eram_footer_widgetize', 1 );
        $has_bottom_bar=Eram_Kirki::get_option( 'eram_theme_options', 'eram_footer_bottom_bar', 1);
        $bottom_layout=Eram_Kirki::get_option( 'eram_theme_options', 'eram_footer_bottom_bar_layout', 'centered');
        $footer_theme=Eram_Kirki::get_option( 'eram_theme_options', 'eg_footer_theme', 'default');
            
        //Set Classes based on options
        $main_wrapper_class=$layout_width;
        $main_wrapper_class.=$widgetized?' has-widgets':' no-widgets';
        $main_wrapper_class.=$has_bottom_bar?' has-bottom-bar':' no-bottom-bar';
        $main_wrapper_class.=' theme-'.$footer_theme;
        if ($footer_theme=='dark')
            $main_wrapper_class.=' eram-theme-dark';
        $bottom_bar_class='layout-'.$bottom_layout;
        $container_class= ($layout_width=='contained')? 'container':'';
        ?>
        <div class="em-footer-section <?php echo $main_wrapper_class;?>">

            <?php if ($widgetized && is_active_sidebar('eram-footer-widgets')):?>
                <div class="footer-main">
                    <div class="footer-main-wrapper <?php echo $container_class;?>">
                        <div class="row">
                            <?php dynamic_sidebar( 'eram-footer-widgets' );?>
                        </div>
                    </div>
                </div>
            <?php endif;?>

            <?php if ($has_bottom_bar):?>
                <div class="footer-bottom <?php echo $bottom_bar_class;?>">
                    <div class="footer-bottom-wrapper <?php echo $container_class;?>">

                            <div class="bottom-first">
                                <?php eram_layout_parts_dynamic_content('eram_footer_bottom_first','social-icons');?>
                            </div>
                            <div class="bottom-second">
                                <?php eram_layout_parts_dynamic_content('eram_footer_bottom_second','copyright-text');?>
                            </div>

                    </div>
                </div>
            <?php endif;?>
        </div>
        <?php
    }
}


/**
* 
*/
if ( ! function_exists('eram_print_page_header_styles') )
{
    function eram_print_page_header_styles($metas) {
        $need_custom = eram_has('_ep_header_custom',$metas,0);
        if ( !$need_custom )
            return false;

        $has_overlay = eram_has('_ep_header_overlay',$metas,1);
        if ( $has_overlay ){
            $overlay_color = eram_page_meta('_ep_header_overlay_color',$metas,'rgba(0,0,0,0.5)');
            $contents_color = eram_page_meta('_ep_header_content_color',$metas,'#ffffff');
            echo "<style>
                .page.layout-header-side .bg-wrapper:after,
                .page-head:before{
                    background:$overlay_color;
                    opacity:1;
                }
                .page-head.has-cover .description,
                .page-head.has-cover .title,
                .page.layout-header-side .side-contents{
                    color: $contents_color;
                }
                </style>";
        }else{
            echo "<style>.page-head:before{background:transparent;}</style>";
        }
    }
}


/**
 * Dynamic content for layout parts (eg: border layout bottom left content)
 * Supports following types (with the exact key):
 * social-icons
 * copyright-text
 * custom
 * none
 * Custom content key is supposed to be $option_key_text
 */

if ( ! function_exists('eram_layout_parts_dynamic_content') )
{
    function eram_layout_parts_dynamic_content($option_key,$default){
        $content_type=Eram_Kirki::get_option('eram_theme_options',$option_key,$default);

        switch ($content_type){
            case "social-icons":
                eram_display_social_icons();
                break;
            case "copyright-text":
                ?>
                <div class="er-cprtext">
                    <?php echo Eram_Kirki::get_option('eram_theme_options','eram_page_footer_cprtext');?>
                </div>
                <?php
                break;
            case "custom":
                 echo Eram_Kirki::get_option('eram_theme_options',$option_key.'_text','');
                break;

        }
    }
}

/**
 * Social Network lists
 */
if ( ! function_exists('eram_social_networks_list') ) {
    function eram_social_networks_list()
    {
        $social_icons = array(
            'facebook'   => esc_html__( 'Facebook', 'eram' ),
            'twitter'    => esc_html__( 'Twitter', 'eram' ),
            'instagram'  => esc_html__( 'Instagram', 'eram' ),
            '500px'      => esc_html__( '500px', 'eram' ),
            'linkedin'   => esc_html__( 'LinkedIn', 'eram' ),
            'googleplus' => esc_html__( 'Google Plus', 'eram' ),
            'youtube'    => esc_html__( 'YouTube', 'eram' ),
            'pinterest'  => esc_html__( 'Pinterest', 'eram' ),
            'vimeo'      => esc_html__( 'Vimeo', 'eram' ),
        );

        return apply_filters('eram_social_networks_list',$social_icons);
    }
}

/**
 * Get social icons from customizer
 */
if ( ! function_exists( 'eram_get_social_icons' ) )
{
    function eram_get_social_icons ()
    {

        $social_icons = Eram_Kirki::get_option( 'eram_theme_options', 'eram_social_icons' );

        return $social_icons;
    }
}



/**
 *  Displays Social icons.
 */

if ( ! function_exists( 'eram_display_social_icons' ) )
{

    function eram_display_social_icons ()
    {
        $social_list=eram_social_networks_list();
        $social_icons = eram_get_social_icons();
        if ( count($social_icons)>0 ) {
            ?>
            <ul class="social-icons">
                <?php foreach ( $social_icons as $icon ): ?>
                    <?php $title=array_key_exists($icon['media'],$social_list)?$social_list[$icon['media']]:'';?>
                    <li>
                        <a href="<?php echo esc_url( $icon['link_url'] ); ?>"  target="_blank" title="<?php echo $title;?>">
                            <i class="fa fa-<?php echo esc_attr( $icon['media'] ); ?>"></i>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php
        }
    }
}


/**
 *  Get footer columns
 */

if ( ! function_exists( 'eram_get_footer_widget_col_class' ) ) {

    function eram_get_footer_widget_col_class()
    {
        $col_num=Eram_Kirki::get_option('eram_theme_options','eram_footer_widgetize_columns',3);
        //eram_dd($col_num);
        $col_class='col-sm-12';
        switch ( $col_num ) {
            case '2':
                $col_class = 'col-sm-6';
                break;

            case '3':
                $col_class = 'col-sm-4';
                break;

            case '4':
                $col_class = 'col-sm-3';
                break;
            case '6':
                $col_class = 'col-sm-2';
                break;
            default:
                $col_class='col-sm-12';
        }

        return $col_class;

    }
}