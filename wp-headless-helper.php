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
//Main Class for this plugins
class wp_headless_heloper
{
    public function __construct()
    {
        add_action('plugin_loaded', [$this, 'whh_plugin_loaded']);
        add_action('wp_enqueue_scripts', [$this, 'whh_assets']);
        add_action('init', [$this, 'whh_register_menus']);

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
}

new wp_headless_heloper();