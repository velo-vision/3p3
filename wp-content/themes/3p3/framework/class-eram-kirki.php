<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * This is a wrapper class for Kirki.
 * If the Kirki plugin is installed, then all CSS & Google fonts
 * will be handled by the plugin.
 * In case the plugin is not installed, this acts as a fallback
 * ensuring that all CSS & fonts still work.
 * It does not handle the customizer options, simply the frontend CSS.
 */
class Eram_Kirki {

    /**
     * @static
     * @access protected
     * @var array
     */
    protected static $config = array();

    /**
     * @static
     * @access protected
     * @var array
     */
    protected static $fields = array();

    /**
     * The class constructor
     */
    public function __construct() {
        // If Kirki exists then there's no reason to proceed
        if ( class_exists( 'Kirki' ) ) {
            return;
        }

    }

    /**
     * Get the value of an option from the db.
     *
     * @param    string $config_id The ID of the configuration corresponding to this field
     * @param    string $field_id The field_id (defined as 'settings' in the field arguments)
     *
     * @param bool $default
     * @return mixed the saved value of the field.
     */
    public static function get_option( $config_id = '', $field_id = '', $default = false ) {
        // if Kirki exists, use it.
        if ( class_exists( 'Kirki' ) ) {
            $return = Kirki::get_option( $config_id, $field_id );

            if ( is_null($return) ){
                return $default;
            }

            return $return;
            
        }else{
            return $default;
        }

    }

    /**
     * Create a new panel
     *
     * @param   string      the ID for this panel
     * @param   array       the panel arguments
     */
    public static function add_panel( $id = '', $args = array() ) {
        if ( class_exists( 'Kirki' ) ) {
            Kirki::add_panel( $id, $args );
        }
        // If Kirki does not exist then there's no reason to add any panels.
    }

    /**
     * Create a new section
     *
     * @param   string      the ID for this section
     * @param   array       the section arguments
     */
    public static function add_section( $id, $args ) {
        if ( class_exists( 'Kirki' ) ) {
            Kirki::add_section( $id, $args );
        }
        // If Kirki does not exist then there's no reason to add any sections.
    }


    /**
     * Sets the configuration options.
     *
     * @param    string    $config_id    The configuration ID
     * @param    array     $args         The configuration arguments
     */
    public static function add_config( $config_id, $args = array() ) {
        // if Kirki exists, use it.
        if ( class_exists( 'Kirki' ) ) {
            Kirki::add_config( $config_id, $args );
            return;
        }
        // Kirki does not exist, set the config arguments
        $config[ $config_id ] = $args;
        // Make sure an option_type is defined
        if ( ! isset( self::$config[ $config_id ]['option_type'] ) ) {
            self::$config[ $config_id ]['option_type'] = 'theme_mod';
        }
    }

    /**
     * Create a new field
     *
     * @param    string    $config_id    The configuration ID
     * @param    array     $args         The field's arguments
     */
    public static function add_field( $config_id, $args ) {
        // if Kirki exists, use it.
        if ( class_exists( 'Kirki' ) ) {
            Kirki::add_field( $config_id, $args );
            return;
        }
        // Kirki was not located, so we'll need to add our fields here.
        // check that the "settings" & "type" arguments have been defined
        if ( isset( $args['settings'] ) && isset( $args['type'] ) ) {
            // Make sure we add the config_id to the field itself.
            // This will make it easier to get the value when generating the CSS later.
            if ( ! isset( $args['kirki_config'] ) ) {
                $args['kirki_config'] = $config_id;
            }
            // Background fields need to be built separately
            if ( 'background' == $args['type'] && isset( $args['output'] ) ) {
                if ( isset( $args['default'] ) && is_array( $args['default'] ) ) {
                    foreach ( $args['default'] as $default_property => $default_value ) {
                        $subfield = $args;
                        // No need to process the opacity, it is factored in the color control.
                        if ( 'opacity' == $key ) {
                            continue;
                        }
                        $key             = esc_attr( $key );
                        $setting         = $key;
                        $output_property = 'background-' . $key;
                        if ( 'attach' == $key ) {
                            $output_property = 'background-attachment';
                        }
                        if ( is_string( $subfield['output'] ) ) {
                            $subfield['output'] = array( array(
                                'element'  => $args['output'],
                                'property' => $output_property,
                            ) );
                        } else {
                            foreach ( $subfield['output'] as $key => $output ) {
                                $subfield['output'][ $key ]['property'] = $output_property;
                            }
                        }
                        $type = 'select';
                        if ( in_array( $key, array( 'color', 'image' ) ) ) {
                            $type = $key;
                        }
                        $property_setting = esc_attr( $args['settings'] ) . '_' . $setting;
                        self::$fields[ $property_setting ] = $subfield;
                    }
                }
            }
            self::$fields[ $args['settings'] ] = $args;
        }
    }

}
new Eram_Kirki();