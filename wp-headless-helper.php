<?php
/**
 * Plugin Name:       WP Headless Helper
 * Plugin URI:        #
 * Description:       Headless wordpress helper
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Rawshan
 * Author URI:        https://rawshanars.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        #
 * Text Domain:       whh
 * Domain Path:       /languages
 */

//add some files
require_once dirname( __FILE__ ) . '/inc/whh-tgm-activation.php';
require_once dirname( __FILE__ ) . '/inc/posts-endpoint.php';
//Main Class for this plugins
class wp_headless_heloper
{
    public function __construct()
    {
        add_action('plugin_loaded', [$this, 'whh_plugin_loaded']);
        add_action('wp_enqueue_scripts', [$this, 'whh_assets']);
        add_action('init', [$this, 'whh_register_menus']);
        add_action('widgets_init', [$this, 'whh_widgets']);

    }

    public function whh_plugin_loaded()
    {
        load_plugin_textdomain('whh', false, plugin_dir_url(__FILE__)."/languages");
    }

    public function whh_assets()
    {
//        wp_enqueue_style('one', plugin_dir_url(__FILE__). "assets/one.css");
    }
    /**
     * Menu Register
     */
    public function whh_register_menus() {
        register_nav_menus([
           'main-menu' => __('Main Menu', 'whh'),
           'footer-menu' => __('Footer Menu', 'whh'),
        ]);
    }

    /**
     * Widgets Register
     */

    public function whh_widgets() {
        register_sidebar( array(
            'name'          => __( 'Main Sidebar', 'textdomain' ),
            'id'            => 'sidebar-2',
            'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'textdomain' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widgettitle">',
            'after_title'   => '</h2>',
        ) );
    }

}

new wp_headless_heloper();