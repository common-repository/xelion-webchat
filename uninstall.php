<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @since      1.0.0
 * @package    Xelion_Webchat
 * @author     Jauhari
 */

/**
 * If uninstall is not called from WordPress, exit.
 */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Else, loop through the xwc's custom fields and delete every one of them
 */
include_once plugin_dir_path( __FILE__ ) . 'includes/const-xelion-webchat-custom-fields.php';

foreach ( XELION_WEBCHAT_CUSTOM_FIELDS as $field ) {

  delete_option( $field['option_name'] );

}
