<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      1.0.0
 * @package    Xelion_Webchat
 * @subpackage Xelion_Webchat/admin/partials
 * @author     Jauhari
 */

?>

<div
  id="xwc"
  data-xwc_ajaxurl="<?php echo admin_url('admin-ajax.php'); ?>"

  <?php

    /**
     * Export all custom fields to the admin panel (including the private ones)
     */
    foreach ( XELION_WEBCHAT_CUSTOM_FIELDS as $field ) {

      /**
       * Escape variables and options on echo
       * For attribute name, remove whitespaces, then escape
       */
      echo 'data-' . esc_attr( preg_replace('/\s+/', '', $field['option_name'] ) ) . '="' . esc_attr( get_option( $field['option_name'] ) ) . '"' . PHP_EOL;

    }

  ?>
>
  <?php settings_errors(); ?>
</div>
