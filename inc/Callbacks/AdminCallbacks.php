<?php

/**
 * 
 *  ADMIN CALLBACKS
 *  =========================
 * 
 */


namespace Inc\Callbacks;



class AdminCallbacks
{

    // Admin Dashboard Page Callback Function
    public function admin_page_init()
    {
        require_once PLUGIN_PATH . '/inc/Pages/admin.php';
    }

    // Admin Dashboard Page Callback Function
    public function pbp_setting_section_callback()
    {
        echo '<p class="description">' . __('Put your Google API key to use the Google Map properly.', 'pub-bar-plugin' ) . '</p>';
    }

    // Admin Dashboard Page Callback Function
    public function pbp_setting_field_callback()
    {

        $api_option = esc_html( get_option( 'google_api_key_option' ) );
        $value = @$api_option ? $api_option : '';

        echo '<input type="text" class="widefat" name="' . $api_option . '" id="' . $api_option . '" value="' . $value . '" />';
    }

}