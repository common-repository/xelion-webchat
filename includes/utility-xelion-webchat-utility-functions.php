<?php

/**
 * Validate string.
 * 
 * @since    1.0.0
 */
function xelion_webchat_func_validate_string( $value ) {

  $validated = '';

  if ( isset( $value ) && !empty( $value ) ) {

    if ( is_string( $value ) ) {

      $validated = $value;

    } else {

      $validated = json_encode( $value );

    }

  }

  return $validated;

}

/**
 * Get a valid Xelion Webchat API URL from database.
 * 
 * @since    1.0.0
 */
function xelion_webchat_func_get_valid_url() {

  $https = 'https://';
  $host = preg_replace( '/\s+/', '', get_option( 'xwc_api_host' ) );
  $tenant = preg_replace( '/\s+/', '', get_option( 'xwc_api_tenant' ) );
  $gateway = preg_replace( '/\s+/', '', get_option( 'xwc_api_gateway' ) );

  /**
   * If the user set the host value with https://, or http://,
   * correct it
   */
  if ( preg_match( '/^(https:\/\/)/i', $host ) ) {

    $host = preg_replace( '/(https:\/\/)/i', '', $host );

  } elseif ( preg_match( '/^(http:\/\/)/i', $host ) ) {

    $host = preg_replace( '/(http:\/\/)/i', '', $host );

  }

  /**
   * If tenant value is empty, set it to master,
   * otherwise, set it to its value
   */
  if ( $tenant === false || $tenant === '' ) {

    $tenant = 'master';

  }

  $valid_api_url = $https . $host . '/portal/chat/' . $tenant . '/gateways/' . $gateway;

  return $valid_api_url;

}

/**
 * Save an option to database.
 * 
 * @since    1.0.0
 */
function xelion_webchat_func_save_option( $option_name, $option_value ) {

  /**
   * If the option exists, update it
   * Otherwise, create a new one
   */
  if ( get_option( $option_name ) !== false ) {

    update_option( $option_name, $option_value );

  } else {

    add_option( $option_name, $option_value );
  
  }

}

/**
 * Check if API is valid.
 * 
 * @since    8.3.0
 */
function xelion_webchat_func_check_API_validity() {

  // Check if API config is valid
  $url = xelion_webchat_func_get_valid_url();
      
  $token = get_option( 'xwc_api_token' );
  $api_headers = array(
    'Content-Type' => 'application/json',
    'Authorization' => $token
  );

  $response = wp_remote_get( $url . '/validate', array(
    'headers' => $api_headers,
  ));

  $response_body = wp_remote_retrieve_body( $response );

  $response_body_decoded = json_decode( $response_body );

  // If response_body_decoded throws something other than 0 (JSON_ERROR_NONE), it means that response_body is already a JSON object
  if ( json_last_error() !== 0 ) {
    
    $response_body_decoded = $response_body;

  }

  // If API config is valid, set xwc_api_is_valid to true
  if ( is_object( $response_body_decoded ) && isset( $response_body_decoded->value ) && $response_body_decoded->value === true ) {

    return 'valid';

  } else {

    return 'invalid';

  }

}
