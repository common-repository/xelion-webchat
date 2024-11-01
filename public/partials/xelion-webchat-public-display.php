<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @since      1.0.0
 * @package    Xelion_Webchat
 * @subpackage Xelion_Webchat/public/partials
 * @author     Jauhari
 */

?>

<div
  id="xwc"
  data-xwc_ajaxurl="<?php echo esc_attr( admin_url('admin-ajax.php') ); ?>"

  <?php

    /**
     * Export the public custom fields to the frontend
     */
    foreach ( XELION_WEBCHAT_CUSTOM_FIELDS as $field ) {

      if ( $field['public'] ) {

        /**
         * Escape variables and options on echo
         * For attribute name, remove whitespaces, then escape
         */
        echo 'data-' . esc_attr( preg_replace('/\s+/', '', $field['option_name'] ) ) . '="' . esc_attr( get_option( $field['option_name'] ) ) . '"' . PHP_EOL;

      }

    }

    /**
     * Check website's and browser's language
     */
    $site_language = substr( get_bloginfo( 'language' ), 0, 2 );
    $browser_language = substr( xelion_webchat_func_validate_string( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ), 0, 2 );
    $user_language = 'en';

    /**
     * If site's language is set to en, nl, or de, use it
     * Else if browser's language is set to en, nl, or de, use it
     * Else use en
     */
    if ( $site_language == 'en' || $site_language == 'nl' || $site_language == 'de' ) {
      $user_language = $site_language;
    } else if ( $browser_language == 'en' || $browser_language == 'nl' || $browser_language == 'de' ) {
      $user_language = $browser_language;
    }

    echo 'data-xwc_language="' . esc_attr( $user_language ) . '"' . PHP_EOL;

  ?>
></div>
