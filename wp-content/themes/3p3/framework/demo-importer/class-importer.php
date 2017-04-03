<?php
/**
 *  This class is used to introduce Eram demo content to one-click-demo-import found at
 *  https://github.com/proteusthemes/one-click-demo-import
 *  More help: http://www.themevan.com/a-simple-guide-to-provide-one-click-demo-import-feature-in-wordpress/
 *
 * @package eram
 * @author owwwlab
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class Eram_Importer
{
    public $primary_menu_location = 'primary-menu';
    public $secondary_menu_location = 'secondary-menu';

    /**
     * Holds the class object.
     *
     * @since 1.0.0
     *
     * @var object
     */
    public static $instance;
    public static $content_root;
    public static $plugins_to_deactivate = array();
    public static $plugins_to_reactivate = array();

    /**
     * Returns the instance of the class.
     *
     * @since 1.0.0
     *
     * @return object
     */
    public static function get_instance()
    {

        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct()
    {

        self::$plugins_to_deactivate = array(
            'imsanity/imsanity.php',
            'ewww-image-optimizer/ewww-image-optimizer.php',
            'w3-total-cache/w3-total-cache.php',
            'wp-smushit/wp-smush.php',
            'wordpress-importer/wordpress-importer.php'
        );

        // before content import
        add_action( 'pt-ocdi/before_content_import', array( $this, 'before_content_import') );

        // Import files
        add_filter( 'pt-ocdi/import_files', array( $this, 'import_files' ) );

        // After Import
        add_action( 'pt-ocdi/after_import', array( $this, 'after_import' ) );

        // Intro Text
        //add_filter( 'pt-ocdi/plugin_intro_text', array( $this, 'plugin_intro_text' ) );

        // change the location, title and other parameters of the plugin page
        //add_filter( 'pt-ocdi/plugin_page_setup', array( $this, 'plugin_page_setup' ) );

        // before widgets are imported
        //add_action( 'pt-ocdi/before_widgets_import', array( $this, 'before_widgets_import' ) );

    }

    public function before_content_import($selected_import)
    {
        $this->deactivate_plugins();
    }

    public function deactivate_plugins()
    {
        echo "\nDeactivating plugins...";
        foreach (self::$plugins_to_deactivate as $plugin) {
            
            // check if the plugin is active 
            if ( is_plugin_active($plugin) )
            {
                // check if plugin is network activate
                if ( is_plugin_active_for_network($plugin) )
                {
                    echo "\n[NOTICE] $plugin is network activated and cannot be deactivated for this site, if the import does not work, try to deactivate this plugin from your network and retry the import process." ; 
                }
                else
                {
                    // silently diactivate it
                    $res = deactivate_plugins($plugin, true);
                    self::$plugins_to_reactivate[] = $plugin;
                    echo "\nPlugin $plugin deactivated!";
                }
                    
            }
        }
        echo "\nPlugin Deactivation Done!.";
    }

    public function reactivate_plugins()
    {
        echo "\nRe-activating plugins...";
        foreach (self::$plugins_to_reactivate as $plugin) {
            // check if the plugin is active 
            if ( ! is_plugin_active($plugin) )
            {
                // silently activate it
                activate_plugin($plugin, NULL, false, true);
                echo "\nPlugin $plugin re-activated!";
            }
        }
        echo "\nPlugin re-activation Done!.";
    }

    public function import_files()
    {
        return array(

            $this->get_demo1_settings(),
            $this->get_demo2_settings(),
            $this->get_demo3_settings(),
            $this->get_demo4_settings(),
            $this->get_demo5_settings(),
            $this->get_demo6_settings(),
            $this->get_demo7_settings(),
            $this->get_demo8_settings(),
            $this->get_demo9_settings(),
            $this->get_main_settings(),
            $this->get_maindark_settings(),
        );
    }

    public function after_import( $selected_import )
    {

        switch ( $selected_import['demo_id'] ) {
            case 'main':
                $this->finalize_demo_main();
                break;
            case 'maindark':
                $this->finalize_demo_maindark();
                break;
            case 'demo1':
                $this->finalize_demo_demo1();
                break;
            case 'demo2':
                $this->finalize_demo_demo2();
                break;
            case 'demo3':
                $this->finalize_demo_demo3();
                break;
            case 'demo4':
                $this->finalize_demo_demo4();
                break;
            case 'demo5':
                $this->finalize_demo_demo5();
                break;
            case 'demo6':
                $this->finalize_demo_demo6();
                break;
            case 'demo7':
                $this->finalize_demo_demo7();
                break;
            case 'demo8':
                $this->finalize_demo_demo8();
                break;
            case 'demo9':
                $this->finalize_demo_demo9();
                break;
            default:
                // nothing
        }

        $this->reactivate_plugins();

        echo "\nImport finalization done!";

        flush_rewrite_rules();
    }

    public function plugin_intro_text( $default_text )
    {

        return $default_text;
    }

    public function plugin_page_setup( $default_settings )
    {
        return $default_settings;
    }


    public function get_main_settings()
    {
        return array(
            'demo_id'                      => 'main',
            'import_file_name'             => esc_html__( 'Main Demo Light', 'eram' ),
            'categories'                   => array( esc_html__( 'Light', 'eram' ) ),
            'import_file_url'              => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/main/demo-content-v3.xml',
            'import_widget_file_url'       => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/main/widgets.wie',
            'import_customizer_file_url'   => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/main/customizer.dat',
            'import_preview_image_url'     => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/main/preview_import_image.jpg',
            'local_import_redux'           => '',
            'import_redux'                 => '',
            'import_notice'                => esc_html__( 'Make sure that you have a fresh installation of WordPress before import or use "WordPress Reset" plugin to  reset your website.', 'eram' ),
        );
    }

    public function get_maindark_settings()
    {
        return array(
            'demo_id'                      => 'maindark',
            'import_file_name'             => esc_html__( 'Main Demo Dark', 'eram' ),
            'categories'                   => array( esc_html__( 'Dark', 'eram' ) ),
            'import_file_url'              => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/maindark/demo-content-v3.xml',
            'import_widget_file_url'       => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/maindark/widgets.wie',
            'import_customizer_file_url'   => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/maindark/customizer.dat',
            'import_preview_image_url'     => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/maindark/preview_import_image.jpg',
            'local_import_redux'           => '',
            'import_redux'                 => '',
            'import_notice'                => esc_html__( 'Make sure that you have a fresh installation of WordPress before import or use "WordPress Reset" plugin to  reset your website.', 'eram' ),
        );
    }

    public function get_demo1_settings()
    {
        return array(
            'demo_id'                      => 'demo1',
            'import_file_name'             => esc_html__( 'Demo 1', 'eram' ),
            'categories'                   => array( esc_html__( 'Light', 'eram' ) ),
            'import_file_url'              => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo1/demo-content-v2.xml',
            'import_widget_file_url'       => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo1/widgets.wie',
            'import_customizer_file_url'   => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo1/customizer.dat',
            'import_preview_image_url'     => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo1/preview_import_image.jpg',
            'local_import_redux'           => '',
            'import_redux'                 => '',
            'import_notice'                => esc_html__( 'Make sure that you have a fresh installation of WordPress before import or use "WordPress Reset" plugin to  reset your website.', 'eram' ),
        );
    }

    public function get_demo2_settings()
    {
        return array(
            'demo_id'                      => 'demo2',
            'import_file_name'             => esc_html__( 'Demo 2', 'eram' ),
            'categories'                   => array( esc_html__( 'Dark', 'eram' ) ),
            'import_file_url'              => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo2/demo-content-v2.xml',
            'import_widget_file_url'       => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo2/widgets.wie',
            'import_customizer_file_url'   => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo2/customizer.dat',
            'import_preview_image_url'     => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo2/preview_import_image.jpg',
            'local_import_redux'           => '',
            'import_redux'                 => '',
            'import_notice'                => esc_html__( 'Make sure that you have a fresh installation of WordPress before import or use "WordPress Reset" plugin to  reset your website.', 'eram' ),
        );
    }

    public function get_demo3_settings()
    {
        return array(
            'demo_id'                      => 'demo3',
            'import_file_name'             => esc_html__( 'Demo 3', 'eram' ),
            'categories'                   => array( esc_html__( 'Light', 'eram' ) ),
            'import_file_url'              => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo3/demo-content-v2.xml',
            'import_widget_file_url'       => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo3/widgets.wie',
            'import_customizer_file_url'   => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo3/customizer.dat',
            'import_preview_image_url'     => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo3/preview_import_image.jpg',
            'local_import_redux'           => '',
            'import_redux'                 => '',
            'import_notice'                => esc_html__( 'Make sure that you have a fresh installation of WordPress before import or use "WordPress Reset" plugin to  reset your website.', 'eram' ),
        );
    }

    public function get_demo4_settings()
    {
        return array(
            'demo_id'                      => 'demo4',
            'import_file_name'             => esc_html__( 'Demo 4', 'eram' ),
            'categories'                   => array( esc_html__( 'Dark', 'eram' ) ),
            'import_file_url'              => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo4/demo-content-v2.xml',
            'import_widget_file_url'       => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo4/widgets.wie',
            'import_customizer_file_url'   => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo4/customizer.dat',
            'import_preview_image_url'     => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo4/preview_import_image.jpg',
            'local_import_redux'           => '',
            'import_redux'                 => '',
            'import_notice'                => esc_html__( 'Make sure that you have a fresh installation of WordPress before import or use "WordPress Reset" plugin to  reset your website.', 'eram' ),
        );
    }

    public function get_demo5_settings()
    {
        return array(
            'demo_id'                      => 'demo5',
            'import_file_name'             => esc_html__( 'Demo 5', 'eram' ),
            'categories'                   => array( esc_html__( 'Light', 'eram' ) ),
            'import_file_url'              => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo5/demo-content-v2.xml',
            'import_widget_file_url'       => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo5/widgets.wie',
            'import_customizer_file_url'   => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo5/customizer.dat',
            'import_preview_image_url'     => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo5/preview_import_image.jpg',
            'local_import_redux'           => '',
            'import_redux'                 => '',
            'import_notice'                => esc_html__( 'Make sure that you have a fresh installation of WordPress before import or use "WordPress Reset" plugin to  reset your website.', 'eram' ),
        );
    }

    public function get_demo6_settings()
    {
        return array(
            'demo_id'                      => 'demo6',
            'import_file_name'             => esc_html__( 'Demo 6', 'eram' ),
            'categories'                   => array( esc_html__( 'Light', 'eram' ) ),
            'import_file_url'              => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo6/demo-content-v2.xml',
            'import_widget_file_url'       => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo6/widgets.wie',
            'import_customizer_file_url'   => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo6/customizer.dat',
            'import_preview_image_url'     => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo6/preview_import_image.jpg',
            'local_import_redux'           => '',
            'import_redux'                 => '',
            'import_notice'                => esc_html__( 'Make sure that you have a fresh installation of WordPress before import or use "WordPress Reset" plugin to  reset your website.', 'eram' ),
        );
    }

    public function get_demo7_settings()
    {
        return array(
            'demo_id'                      => 'demo7',
            'import_file_name'             => esc_html__( 'Demo 7', 'eram' ),
            'categories'                   => array( esc_html__( 'Light', 'eram' ) ),
            'import_file_url'              => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo7/demo-content-v2.xml',
            'import_widget_file_url'       => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo7/widgets.wie',
            'import_customizer_file_url'   => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo7/customizer.dat',
            'import_preview_image_url'     => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo7/preview_import_image.jpg',
            'local_import_redux'           => '',
            'import_redux'                 => '',
            'import_notice'                => esc_html__( 'Make sure that you have a fresh installation of WordPress before import or use "WordPress Reset" plugin to  reset your website.', 'eram' ),
        );
    }

    public function get_demo8_settings()
    {
        return array(
            'demo_id'                      => 'demo8',
            'import_file_name'             => esc_html__( 'Demo 8', 'eram' ),
            'categories'                   => array( esc_html__( 'Light', 'eram' ) ),
            'import_file_url'              => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo8/demo-content.xml',
            'import_widget_file_url'       => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo8/widgets.wie',
            'import_customizer_file_url'   => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo8/customizer.dat',
            'import_preview_image_url'     => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo8/preview_import_image.jpg',
            'local_import_redux'           => '',
            'import_redux'                 => '',
            'import_notice'                => esc_html__( 'This demo needs WooCommerce and Slider Revolution Plugins Installed and Activated before import. Make sure that you have a fresh installation of WordPress before import or use "WordPress Reset" plugin to  reset your website.', 'eram' ),
        );
    }

    public function get_demo9_settings()
    {
        return array(
            'demo_id'                      => 'demo9',
            'import_file_name'             => esc_html__( 'Demo 9', 'eram' ),
            'categories'                   => array( esc_html__( 'Light', 'eram' ) ),
            'import_file_url'              => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo9/demo-content.xml',
            'import_widget_file_url'       => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo9/widgets.wie',
            'import_customizer_file_url'   => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo9/customizer.dat',
            'import_preview_image_url'     => 'https://raw.githubusercontent.com/owwwlab/Eram-Demo-Contents/master/demo9/preview_import_image.jpg',
            'local_import_redux'           => '',
            'import_redux'                 => '',
            'import_notice'                => esc_html__( 'This demo uses the Exifography Plugin to show EXIF data for photos, install that plugin and make sure that you have a fresh installation of WordPress before import or use "WordPress Reset" plugin to  reset your website.', 'eram' ),
        );
    }

    public function set_menu( $menu_title, $menu_location )
    {
        echo "\nTrying to set menu named : $menu_title";

        $menu = wp_get_nav_menu_object( $menu_title );

        if ( $menu ) {
            set_theme_mod( 'nav_menu_locations', array(
                    $menu_location => $menu->term_id,
                )
            );
            echo "\nMenu is Set!";
        }
        else {
            echo "\nCould not set menu locations, you can set it manually!";
        }
    }

    public function set_front_page( $homepage_title, $postspage_title )
    {
        echo "\nTrying to set Homepage....";

        $front_page = get_page_by_title( $homepage_title );
        $blog_page = get_page_by_title( $postspage_title );

        if ( $front_page ) {
            update_option( 'show_on_front', 'page' );
            update_option( 'page_on_front', $front_page->ID );
            update_option( 'page_for_posts', $blog_page->ID );

            echo "\nHome Page is set to : $homepage_title";
            echo "\nPosts Page is set to : $postspage_title";
        }
        else {
            echo "\nCould not set front page settings, you can set it manually!";
        }

    }

    public function reset_front_page()
    {
        update_option( 'show_on_front', 'posts' );
    }

    public function finalize_demo_main()
    {
        // Assign menus to their locations.
        $this->set_menu( 'Main Menu', $this->primary_menu_location );
        $this->set_menu( 'Main Menu', $this->secondary_menu_location );


        // Assign front page and posts page (blog page).
        $this->set_front_page( 'Rail Carousel', 'Blog' );

        // update menu custom links
        $this->update_menu_links( 'Main Menu' );
    }

    public function finalize_demo_maindark()
    {
        // Assign menus to their locations.
        $this->set_menu( 'Main Menu', $this->primary_menu_location );
        $this->set_menu( 'Main Menu', $this->secondary_menu_location );


        // Assign front page and posts page (blog page).
        $this->set_front_page( 'Hoffman Studio', 'Blog' );

        // update menu custom links
        $this->update_menu_links( 'Main Menu', '/main-dark' );
    }

    public function finalize_demo_demo1()
    {
        // Assign menus to their locations.
        $this->set_menu( 'main menu', $this->primary_menu_location );

        // Assign front page and posts page (blog page).
        $this->reset_front_page();

        // update menu custom links
        $this->update_menu_links( 'main menu', '/demo-1' );
    }

    public function finalize_demo_demo2()
    {
        $this->set_menu( 'main menu', $this->primary_menu_location );
        $this->set_front_page( 'Home', 'Blog' );

        // update menu custom links
        $this->update_menu_links( 'main menu', '/demo-2' );
    }

    public function finalize_demo_demo3()
    {
        $this->set_menu( 'main menu', $this->secondary_menu_location );
        $this->set_front_page( 'Home', 'Blog' );

        // update menu custom links
        $this->update_menu_links( 'main menu', '/demo-3' );
    }

    public function finalize_demo_demo4()
    {
        $this->set_menu( 'menu', $this->primary_menu_location );
        $this->set_front_page( 'Home', 'Blog' );

        // update menu custom links
        $this->update_menu_links( 'menu', '/demo-4' );
    }

    public function finalize_demo_demo5()
    {
        $this->set_menu( 'main menu', $this->primary_menu_location );
        $this->reset_front_page();

        // update menu custom links
        $this->update_menu_links( 'main menu', '/demo-5' );
    }

    public function finalize_demo_demo6()
    {
        $this->set_menu( 'main menu', $this->primary_menu_location );
        $this->set_front_page( 'Placeholder home page', 'Blog' );

        // update menu custom links
        $this->update_menu_links( 'main menu', '/demo-6' );
    }

    public function finalize_demo_demo7()
    {
        $this->set_menu( 'main menu', $this->primary_menu_location );
        $this->set_menu( 'side menu', $this->secondary_menu_location );
        $this->set_front_page( 'Eram Photography', 'Blog' );

        // update menu custom links
        $this->update_menu_links( 'main menu', '/demo-7' );
    }

    public function finalize_demo_demo8()
    {
        $this->set_menu( 'main menu', $this->primary_menu_location );
        $this->set_front_page( 'Home', 'Blog' );

        // update menu custom links
        $this->update_menu_links( 'main menu', '/demo-8' );

        //Import Revolution Slider
        $slider_array = array(
            get_template_directory()."/framework/demo-importer/demo-8/shop-slider.zip",
        );
        $this->import_revslider($slider_array);

    }

    public function finalize_demo_demo9()
    {
        $this->set_menu( 'top menu', $this->primary_menu_location );
        $this->set_menu( 'main', $this->secondary_menu_location );
        $this->set_front_page( 'Home', 'Blog' );
    }

    private function update_menu_links( $menu_name, $url_segment = '' )
    {
        echo "\n --- Trying to update menu links for \"$menu_name\"---";

        $menu = wp_get_nav_menu_object( $menu_name );
        if ( ! $menu ) {
            echo "\n[ERROR] Menu named \"$menu_name\" not found!";

            return FALSE;
        }
        $menuID = (int)$menu->term_id;

        $menu_items = wp_get_nav_menu_items( $menu_name );

        if ( ! $menu_items ) {
            echo "\n[ERROR] Menu named \"$menu_name\" has no items!";

            return FALSE;
        }

        $to_remove = 'http://demo.owwwlab.com/eram' . $url_segment;
        $to_replace = site_url();

        foreach ( $menu_items as $item ) {
            if ( $item->type == 'custom' ) {
                if ( substr( $item->url, 0, strlen( $to_remove ) ) === $to_remove ) {
                    $new_url = str_replace( $to_remove, $to_replace, $item->url );
                    $update = wp_update_nav_menu_item(
                        $menuID,
                        $item->db_id,
                        array(
                            'menu-item-title'      => $item->post_title,
                            'menu-item-url'        => $new_url,
                            'menu-item-attr-title' => $item->post_title,
                            'menu-item-parent-id'  => $item->menu_item_parent,
                            'menu-item-type'       => 'custom',
                            'menu-item-position'   => $item->menu_order,
                        )
                    );
                    if ( $update )
                        echo "\nChanged menu item {$item->title}";
                    else
                        echo "\n[ERROR] Could not change menu item {$item->title}";
                }
            }
        }


        echo "\n Finished updating menu named \"$menu_name\".";

    }

    public function import_revslider($slider_array = array())
    {
        if ( class_exists( 'RevSlider' ) )
        {
            $slider = new RevSlider();

            foreach($slider_array as $file_path){
                $slider->importSliderFromPost(true,true,$file_path);
            }

            echo "\nSlider processed.";
        }
        else{
            echo "\nRevolution Slider is not installed or activated!";
        }
    }
}

// Load the class.
$eram_importer = Eram_Importer::get_instance();