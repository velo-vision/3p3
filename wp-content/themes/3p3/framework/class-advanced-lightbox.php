<?php
/**
 *  This file handles the advanced lightbox
 *
 * @package Eram
 * @author owwwlab
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if ( ! class_exists( 'Eram_Advanced_Lightbox' ) ) {
    class Eram_Advanced_Lightbox
    {
        protected $image_data = array();
        protected $image_id = 0;

        public function __construct()
        {

            // for logged in user
            add_action( 'wp_ajax_eramlightboxajax', array( $this, 'provide_details' ) );
            // if user not logged in
            add_action( 'wp_ajax_nopriv_eramlightboxajax', array( $this, 'provide_details' ) );


        }

        public function provide_details()
        {
            
            // get attachment ID
            $this->set_image_id();

            // check the image id
            if ( $this->image_id == 0 ) {

                wp_die();
                return FALSE;

            }

            // empty image data
            $this->image_data = array();

            // title
            $this->get_title();

            // content
            $this->get_content();

            // exif
            $this->get_exif();

            // sharing 
            $this->get_sharings();


            echo json_encode( $this->image_data );
            wp_die();
        }

        private function set_image_id()
        {
            if ( ! empty( $_POST['post_id'] ) ) {
                $this->image_id = sanitize_text_field( wp_unslash( $_POST['post_id'] ) );
            }
        }

        private function get_sharings()
        {
            if ( $this->has_sharing() ) {

                $output = '';
                $url = get_permalink( $this->image_id );
                $social_sharings = eram_get_social_sharings();
                if ( count( $social_sharings ) > 0 ) {
                    $output = eram_add_sharing( $social_sharings, TRUE, $url );
                }

                $this->image_data['sharing'][0] = $output;
            }
        }

        private function get_title()
        {
            if ( $this->has_title() )
                $this->image_data['title'][0] = get_post_field( 'post_title', $this->image_id );
        }

        private function get_content()
        {
            if ( $this->has_description() )
                $this->image_data['content'][0] = get_post_field( 'post_content', $this->image_id );
        }

        private function get_exif()
        {
            if ( $this->has_exif() )
                $this->image_data['exif'][0] = eram_exifography_display_exif( NULL, $this->image_id, TRUE );
        }



        /**
         * @return mixed
         */
        private function has_exif()
        {
            return Eram_Kirki::get_option( 'eg_settings', 'eg_lg_side_exif', 1 ) == 1 ? TRUE : FALSE;
        }

        /**
         * @return mixed
         */
        private function has_description()
        {
            return Eram_Kirki::get_option( 'eg_settings', 'eg_lg_side_description', 1 ) == 1 ? TRUE : FALSE;
        }

        /**
         * @return mixed
         */
        private function has_title()
        {
            return Eram_Kirki::get_option( 'eg_settings', 'eg_lg_side_title', 1 ) == 1 ? TRUE : FALSE;
        }

        /**
         * @return mixed
         */
        private function has_sharing()
        {
            return Eram_Kirki::get_option( 'eg_settings', 'eg_lg_side_sharing', 1 ) == 1 ? TRUE : FALSE;
        }

    }
}

$ealb = new Eram_Advanced_Lightbox();


if ( ! function_exists( 'eram_echo_template_scripts' ) ) {
    function eram_echo_template_scripts()
    {

        $o = '<script id="ol-lightbox-sidebar-template" type="x-tmpl-mustache">';
        $o .= '{{#title}}<h2 class="title">{{.}}</h2>{{/title}}';
        $o .= '{{#content}} {{{.}}} {{/content}}';
        $o .= '{{#exif}}<div class="em-exif">{{{.}}}</div>{{/exif}}';
        $o .= '{{#sharing}}<div class="em-sharing">{{{.}}}</div>{{/sharing}}';
        $o .= '</script>';
        echo $o;
    }
}



