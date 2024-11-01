<?php

/**
 * A constant that defines all WordPress options that are needed by the plugin.
 * 
 * Custom field format:
 * [
 *   'option_group' => (string) The custom field's group
 *   'option_name' => (string) The custom field's name
 *   'default_value' => (string) The custom field's default value
 *   'public' => (bool) true if to be exported to the frontend, false if it's a secret
 * ]
 *
 * @since      1.0.0
 * @package    Xelion_Webchat
 * @subpackage Xelion_Webchat/includes
 * @author     Jauhari
 */
define('XELION_WEBCHAT_CUSTOM_FIELDS', [
  /**
   * xwc_admin_apis
   */
  [
    'option_group' => 'xwc_admin_apis',
    'option_name' => 'xwc_api_host',
    'default_value' => '',
    'public' => false,
  ],
  [
    'option_group' => 'xwc_admin_apis',
    'option_name' => 'xwc_api_tenant',
    'default_value' => '',
    'public' => false,
  ],
  [
    'option_group' => 'xwc_admin_apis',
    'option_name' => 'xwc_api_gateway',
    'default_value' => '',
    'public' => false,
  ],
  [
    'option_group' => 'xwc_admin_apis',
    'option_name' => 'xwc_api_token',
    'default_value' => '',
    'public' => false,
  ],
  [
    'option_group' => 'xwc_admin_apis',
    'option_name' => 'xwc_api_is_valid',
    'default_value' => 'invalid',
    'public' => false,
  ],

  /**
   * xwc_admin_appearance
   * 
   * Stuff that modifies css styles has to start with xwc_style_
   */
  [
    'option_group' => 'xwc_admin_appearance',
    'option_name' => 'xwc_app_title',
    'default_value' => 'Xelion Webchat',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_appearance',
    'option_name' => 'xwc_style_chat_icon_size',
    'default_value' => '64',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_appearance',
    'option_name' => 'xwc_style_chat_icon_position_right',
    'default_value' => '0',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_appearance',
    'option_name' => 'xwc_style_chat_icon_position_padding_x',
    'default_value' => '24',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_appearance',
    'option_name' => 'xwc_style_chat_icon_position_padding_y',
    'default_value' => '24',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_appearance',
    'option_name' => 'xwc_style_chatbox_width',
    'default_value' => '450',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_appearance',
    'option_name' => 'xwc_style_chatbox_height',
    'default_value' => '700',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_appearance',
    'option_name' => 'xwc_style_font_size',
    'default_value' => '16',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_appearance',
    'option_name' => 'xwc_style_color_1',
    'default_value' => '#8d00c9',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_appearance',
    'option_name' => 'xwc_style_color_2',
    'default_value' => '#4d64ff',
    'public' => true,
  ],

  /**
   * xwc_admin_welcome_page
   */
  [
    'option_group' => 'xwc_admin_welcome_page',
    'option_name' => 'xwc_welcome_banner_text_1',
    'default_value' => 'Hello 👋,',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_welcome_page',
    'option_name' => 'xwc_welcome_banner_text_2',
    'default_value' => 'What can we do for you?',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_welcome_page',
    'option_name' => 'xwc_welcome_banner_dnd_text_1',
    'default_value' => 'Sorry, we are currently unavailable.',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_welcome_page',
    'option_name' => 'xwc_welcome_banner_dnd_text_2',
    'default_value' => 'Please come back later.',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_welcome_page',
    'option_name' => 'xwc_initial_form_name_enabled',
    'default_value' => 'true',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_welcome_page',
    'option_name' => 'xwc_initial_form_name_required',
    'default_value' => 'true',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_welcome_page',
    'option_name' => 'xwc_initial_form_email_enabled',
    'default_value' => 'true',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_welcome_page',
    'option_name' => 'xwc_initial_form_email_required',
    'default_value' => 'true',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_welcome_page',
    'option_name' => 'xwc_initial_form_phone_enabled',
    'default_value' => 'true',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_welcome_page',
    'option_name' => 'xwc_initial_form_phone_required',
    'default_value' => 'true',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_welcome_page',
    'option_name' => 'xwc_initial_form_enquiry_enabled',
    'default_value' => 'true',
    'public' => true,
  ],

  /**
   * xwc_admin_enquiries
   */
  [
    'option_group' => 'xwc_admin_enquiries',
    'option_name' => 'xwc_enquiries_format',
    'default_value' => 'dropdown',
    'public' => true,
  ],
  [
    'option_group' => 'xwc_admin_enquiries',
    'option_name' => 'xwc_enquiries',
    'default_value' => '[{"id": "0", "question": "Lorem ipsum dolor sit amet", "response": "Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim."}, {"id": "1", "question": "Etiam rhoncus", "response": "Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem."}]',
    'public' => true,
  ]
]);
