<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class Eram_Client_Customizer
{

    protected $panel = 'ec_panel';
    protected $archive_section = 'ec_archive';
    protected $single_section = 'ec_single';
    protected $config_id = 'eg_settings';

    public function __construct()
    {
        if ( ! class_exists( 'EramClient' ) )
            return;
        
        if ( ! class_exists( 'Eram_Kirki' ) )
            return;


        add_action( 'init', array( $this, 'run' ), 100 );

    }


    public function run()
    {
        // configure kirki
        $this->config_kirki();

        //add gallery customizer panel
        $this->add_panels();

        // add gallery archive section
        $this->add_sections();

        // add controls
        $this->add_controls();
    }

    public function config_kirki()
    {

        Eram_Kirki::add_config( $this->config_id, array(
            'capability'  => 'edit_theme_options',
            'option_type' => 'theme_mod',
        ) );

    }

    public function add_panels()
    {
        Eram_Kirki::add_panel( $this->panel, array(
            'priority' => 504,
            'title'    => esc_html__( 'Clients Settings', 'eram' ),
        ) );
    }

    public function add_sections()
    {
        Eram_Kirki::add_section( $this->archive_section, array(
            'title'          => esc_html__( 'List Page', 'eram' ),
            'description'    => esc_html__( 'Here you can edit archive page of Clients', 'eram' ),
            'panel'          => $this->panel,
            'priority'       => 10,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
        ) );
        Eram_Kirki::add_section( $this->single_section, array(
            'title'          => esc_html__( 'Clients Page', 'eram' ),
            'description'    => esc_html__( 'Here you can edit Single Client settings', 'eram' ),
            'panel'          => $this->panel,
            'priority'       => 20,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
        ) );
    }

    public function add_controls()
    {
        // add archive controls
        $this->add_archive_controls();

        // add categories controls
        $this->add_single_controls();

    }

    private function add_archive_controls()
    {
        // ec_has_archive
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'toggle',
            'settings'        => 'ec_has_archive',
            'label'           => esc_html__( 'Disable List of Clients', 'eram' ),
            'description'     => esc_html__( 'Toggle off if you prefer to not have a list of clients.', 'eram' ),
            'section'         => $this->archive_section,
            'priority'        => 20,
            'default'         => 1
        ) );

        // ec_has_details
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'toggle',
            'settings'        => 'ec_has_details',
            'label'           => esc_html__( 'Include Title and Description', 'eram' ),
            'section'         => $this->archive_section,
            'priority'        => 20,
            'default'         => 1,
            'active_callback' => array(
                array(
                    'setting'  => 'ec_has_archive',
                    'operator' => '==',
                    'value'    => TRUE
                )
            )
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'text',
            'settings'        => 'ec_page_title',
            'label'           => esc_html__( 'Page Title', 'eram' ),
            'section'         => $this->archive_section,
            'default'         => esc_html__( 'Awesome Clients', 'eram' ),
            'priority'        => 22,
            'active_callback' => array(
                array(
                    'setting'  => 'ec_has_archive',
                    'operator' => '==',
                    'value'    => TRUE
                ),
                array(
                    'setting'  => 'ec_has_details',
                    'operator' => '==',
                    'value'    => TRUE
                ),
            )
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'textarea',
            'settings'        => 'ec_page_description',
            'label'           => esc_html__( 'Short Description', 'eram' ),
            'section'         => $this->archive_section,
            'default'         => '',
            'priority'        => 23,
            'active_callback' => array(
                array(
                    'setting'  => 'ec_has_archive',
                    'operator' => '==',
                    'value'    => TRUE
                ),
                array(
                    'setting'  => 'ec_has_details',
                    'operator' => '==',
                    'value'    => TRUE
                ),
            )
        ) );
        Eram_Kirki::add_field( $this->config_id, array(
            'type'            => 'image',
            'settings'        => 'ec_archive_cover',
            'label'           => esc_html__( 'Cover Image', 'eram' ),
            'section'         => $this->archive_section,
            'default'         => FALSE,
            'priority'        => 24,
            'active_callback' => array(
                array(
                    'setting'  => 'ec_has_archive',
                    'operator' => '==',
                    'value'    => TRUE
                ),
                array(
                    'setting'  => 'ec_has_details',
                    'operator' => '==',
                    'value'    => TRUE
                ),
            )
        ) );

    }

    private function add_single_controls()
    {

    }


}

new Eram_Client_Customizer();