<?php

/**
 * This class is responsible for adding action links on the WP's plugin page.
 *
 * @since      1.0.0
 * @package    Xelion_Webchat
 * @subpackage Xelion_Webchat/includes
 * @author     Jauhari
 */
class Xelion_Webchat_ActionLinks {

  /**
	 * Add extra action links.
	 * Put the extra action links to the $extra_links array.
	 *
	 * @since    1.0.0
	 */
  public function add_links( $actions ) {

		$extra_links = array(
			'settings' => '<a href="admin.php?page=xelion-webchat/settings.php">Settings</a>'
		);

		return array_merge( $actions, $extra_links );

  }

}
