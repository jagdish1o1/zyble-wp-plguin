<?php
/**
 * Plugin Name: Zyble.io WP Integration
 * Description: Integrate Zyble.io API with your WordPress site easily.
 * Version: 1.0.2
 * Author: Zyble.io
 * Author URI: https://zyble.io
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: zyble-io
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

if( ! class_exists( 'Zyble_Updater' ) ){
	include_once( plugin_dir_path( __FILE__ ) . 'updater.php' );
}

$updater = new Zyble_Updater( __FILE__ );
$updater->set_username( 'jagdish1o1' );
$updater->set_repository( 'zyble-wp-plguin' );
$updater->initialize();

// Include the necessary files
require_once plugin_dir_path(__FILE__) . 'includes/class-zyble-activation.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-zyble-deactivation.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-zyble-settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-zyble-api-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-zyble-plugin.php';

// Activation and Deactivation hooks
register_activation_hook(__FILE__, array('Zyble_Activation', 'activate'));
register_deactivation_hook(__FILE__, array('Zyble_Deactivation', 'deactivate'));

// Initialize the plugin
function zyble_init()
{
    $zyble_plugin = new Zyble_Plugin();
    $zyble_plugin->init();

    $zyble_settings = new Zyble_Settings();
    $zyble_settings->init();
}
add_action('plugins_loaded', 'zyble_init');