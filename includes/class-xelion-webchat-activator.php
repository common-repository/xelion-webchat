<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Xelion_Webchat
 * @subpackage Xelion_Webchat/includes
 * @author     Jauhari
 */
class Xelion_Webchat_Activator {

	/**
	 * This fires on plugin activation.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// For each custom field, if entry does not exist, initiate with default_value
		foreach( XELION_WEBCHAT_CUSTOM_FIELDS as $setting ) {

      add_option( $setting['option_name'], $setting['default_value'] );

		}

   /**
	  * Remove old, unused options
	  *
    * Removed options:
	  * 8.3.0 - xwc_initial_form_enquiry_required
	  */
    delete_option('xwc_initial_form_enquiry_required');

	}

}
