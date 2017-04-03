<?php
/**
 * Eram Clients Helper Functions
 *
 * @since 1.0.0
 *
 * @package Eram Plugin
 * @author  owwwlab
 */

if ( ! function_exists( 'eram_client_change_title_text' ) ) {
    function eram_client_change_title_text( $title )
    {
        $screen = get_current_screen();

        if ( ERAM_CLIENT_CPT_NAME == $screen->post_type ) {
            $title = __( 'Enter Client\'s Name', 'eram' );
        }

        return $title;
    }
}
add_filter( 'enter_title_here', 'eram_client_change_title_text' );


/**
 * Filter to add custom option types.
 *
 * @param     array     An array of option types.
 * @return    array
 */
function eram_client_add_custom_option_types( $types )
{

    $types['proof_gallery_select'] = 'Select Proof Galleries';

    return $types;

}

add_filter( 'ot_option_types_array', 'eram_client_add_custom_option_types' );

function ot_type_proof_gallery_select( $args = array() )
{
    /* turns arguments array into variables */
    extract( $args );

    /* verify a description */
    $has_desc = $field_desc ? TRUE : FALSE;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-proof-gallery-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';

    /* description */
    echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';

    /* format setting inner wrapper */
    echo '<div class="format-setting-inner">';


    /* build text input */
    echo '<select multiple="multiple" placeholder="' . __( 'Search and pick galleries ...', 'eram' ) . '" name="' . esc_attr( $field_name ) . '[]" id="' . esc_attr( $field_id ) . '" class="' . esc_attr( $field_class ) . '" />';
    foreach ( $field_value as $post_id ) {
        echo "<option value='" . $post_id . "' selected></option>";
    }
    echo "</select>";
    $proof_galleries = get_posts( array(
        'post_type'      => ERAM_PROOF_GALLERY_CPT_NAME,
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'post_status'    => 'any'
    ) );
    //dd($proof_galleries);
    ?>
    <script>
        ( function ($, window, document) {
            $('#<?php echo esc_attr( $field_id );?>').selectize({
                plugins: ['remove_button'],
                create: false,
                maxItems: null,
                valueField: 'id',
                searchField: 'title',
                options: [
                    <?php
                    foreach ( $proof_galleries as $gal ) {
                        $edit_url = get_edit_post_link( $gal->ID, '' );
                        $url = get_permalink( $gal->ID );
                        $img_url = ERAM_CLIENT_IMG_DIR . "/no-image.jpg";
                        if ( has_post_thumbnail( $gal->ID ) )
                            $img_url = get_the_post_thumbnail_url( $gal->ID, array( 50, 50 ) );
                        echo '{id: ' . $gal->ID . ', title: "' . $gal->post_title . '", url: "' . $url . '", edit_url: "' . $edit_url . '", img_url:"' . $img_url . '"},';
                    }
                    ?>
                ],
                render: {
                    option: function (data, escape) {
                        return '<div class="option">' +
                            '<div class="thumbnail"><img src="' + escape(data.img_url) + '"/></div>' +
                            '<div class="details">' +
                            '<h5 class="title">' + escape(data.title) + '</h5>' +
                            '</div>' +
                            '</div>';
                    },
                    item: function (data, escape) {
                        return '<div class="item">' +
                            '<div class="thumbnail"><img src="' + escape(data.img_url) + '"/></div>' +
                            '<div class="details">' +
                            '<h5 class="title">' + escape(data.title) + '</h5>' +
                            '<a target="_blank" href=' + escape(data.edit_url) + ' class="url"><?php _e( 'Edit', 'eram' );?></a>' +
                            '<a target="_blank" href=' + escape(data.url) + ' class="url"><?php _e( 'View', 'eram' );?></a>' +
                            '</div>' +
                            '</div>';
                    }
                }
            });
        }(jQuery, window, document) );
    </script><?php
    echo '</div>';

    echo '</div>';
}

// add featured thumbnail to admin post columns
function eram_client_add_columns( $columns )
{
    $columns = array(
        'cb'            => '<input type="checkbox" />',
        'client_photo'  => __( 'Photo', 'eram' ),
        'title'         => __( 'Title', 'eram' ),
        'gallery_count' => __( 'Assigned Galleries', 'eram' ),
        'date'          => __( 'Date', 'eram' ),
    );

    return $columns;
}

function eram_client_add_columns_data( $column, $post_id )
{
    switch ( $column ) {
        case 'client_photo':
            $url = wp_get_attachment_image_src( get_post_meta( $post_id, '_ec_photo', TRUE ), array( 50, 50 ) );
            if ( ! $url )
                $url[0] = ERAM_CLIENT_IMG_DIR . '/avatar.png';
            echo '<a href="' . get_edit_post_link() . '">';
            echo '<img src="' . $url[0] . '" width="40" height="40" />';
            echo '</a>';
            break;

        case 'gallery_count':
            $assigned_gals = get_post_meta( $post_id, '_ec_galleries', TRUE );
            if ( empty($assigned_gals) ){
                echo __( 'No Galleries', 'eram' );
            }
            else{
                $count = count( get_post_meta( $post_id, '_ec_galleries', TRUE ) );
                if ( $count == 1 )
                    echo __( 'One', 'eram' ) . ' ' . __( 'Gallery', 'eram' );
                else
                    echo $count . ' ' . __( 'Galleries', 'eram' );
            }
                
            break;
    }
}

if ( function_exists( 'add_theme_support' ) ) {
    add_filter( 'manage_' . ERAM_CLIENT_CPT_NAME . '_posts_columns', 'eram_client_add_columns' );
    add_action( 'manage_' . ERAM_CLIENT_CPT_NAME . '_posts_custom_column', 'eram_client_add_columns_data', 10, 2 );
}


if ( ! function_exists( 'client_gallery_helper' ) ) {
    function client_gallery_helper( $object_id = NULL )
    {

        //require_once( dirname( __FILE__ ) . '/galleries/loader.php' );

        // get images from metabox
        if ( is_singular( ERAM_CLIENT_CPT_NAME ) ) {
            $imgIDs_array = eg_get_assigned_galleries( $object_id );
            $gallery_layout = 'client';
        }
        elseif ( is_post_type_archive( ERAM_CLIENT_CPT_NAME ) ) {
            // $imgIDs_array = eg_get_proof_archive_images();
            // $gallery_layout = 'v_masonry';
        }
        else {
            $imgIDs_array = '';
            $gallery_layout = '';
        }

        $class_to_load = 'eg_' . $gallery_layout . '_class';
        if ( ! class_exists( $class_to_load ) ) {
            $class_to_load = 'eg_class';
        }

        $return = $class_to_load::get_instance( $object_id, $imgIDs_array );

        return $return;
    }
}

/**
 *  get assigned galleries to a client
 */
if ( ! function_exists( 'eg_get_assigned_galleries' ) ) {
    function eg_get_assigned_galleries( $post_id )
    {
        // get gallery ids from metabox
        $galleries = get_post_meta( $post_id, '_ec_galleries', TRUE );

        // get cover images of galleries
        if ( ! is_array($galleries) )
            return '';

        $cover_ids = array();
        foreach ($galleries as $gallery_id)
        {
            $cover_ids[$gallery_id] = get_post_thumbnail_id($gallery_id);
        }
        
        return $cover_ids;
    }
}

/**
 *  get assigned galleries to a client
 */
function eg_client_the_title_trim($title) {

    if ( ERAM_CLIENT_CPT_NAME != get_post_type() )
        return $title;

    $title = esc_attr($title);

    $findthese = array(
        '#Protected:#',
        '#Private:#'
    );

    $replacewith = array(
        '', // What to replace "Protected:" with
        '' // What to replace "Private:" with
    );

    $title = preg_replace($findthese, $replacewith, $title);
    return $title;
}
add_filter('the_title', 'eg_client_the_title_trim');
