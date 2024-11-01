<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.0
 * @package           Xelion_Webchat
 * @author            Jauhari
 *
 * @wordpress-plugin
 * Plugin Name:       Xelion Webchat
 * Description:       This plugin allows Xelion clients to embed a chat app on their websites.
 * Version:           9.0.0
 * Author:            Xelion
 * Author URI:        https://xelion.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       xelion-webchat
 * Domain Path:       /languages
 */

/**
 * If this file is called directly, abort.
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Update it as you release new versions.
 * 
 * Note: WordPress only accepts major.minor.patch format
 * Do not use any suffixes such as -beta.1 etc.
 */
define( 'XELION_WEBCHAT_VERSION', '9.0.0' );

/**
 * Plugin base name.
 * To be accessed everywhere needed.
 */
define( 'XELION_WEBCHAT_BASENAME', plugin_basename( __FILE__ ));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-xelion-webchat-activator.php
 */
function activate_xelion_webchat() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-xelion-webchat-activator.php';
	Xelion_Webchat_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-xelion-webchat-deactivator.php
 */
function deactivate_xelion_webchat() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-xelion-webchat-deactivator.php';
	Xelion_Webchat_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_xelion_webchat' );
register_deactivation_hook( __FILE__, 'deactivate_xelion_webchat' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-xelion-webchat.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_xelion_webchat() {

	$plugin = new Xelion_Webchat();
	$plugin->run();

}
run_xelion_webchat();
