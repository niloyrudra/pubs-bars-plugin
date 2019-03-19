<?php

/**
 * 
 *  @package pubs-bars-pugin
 *  @version 1.0.0
 * 
 *  ==========================
 *          ADMIN CLASS
 *  ==========================
 * 
 */

namespace Inc\Base;

use Inc\Callbacks\AdminCallbacks;

class Admin
{

    public $admin_callbacks;

    public function __construct()
    {
        $this->admin_callbacks = new AdminCallbacks();
    }


    public function register_admin_pages()
    {
        add_action( 'admin_menu', [ $this, 'pbp_add_admin_pages' ] );

        add_action( 'admin_init', [ $this, 'add_field_for_storing_google_api_key' ] );
    }

    public function pbp_add_admin_pages()
    {
        
        add_menu_page( __( 'Pubs Bars Plugin', 'pubs-bars-plugin' ), __( 'Pubs/Bars Plugin', 'pubs-bars-plugin' ), 'manage_options', 'pubs_bars_plugin', array( $this->admin_callbacks, 'admin_page_init' ), 'dashicons-store', 110 );

        add_submenu_page( 'pubs_bars_plugin', __( 'Pubs Bars Settings Page', 'pubs-bars-plugin' ), __( 'Dashboard', 'pubs-bars-plugin' ), 'manage_options', 'pubs_bars_plugin', array( $this->admin_callbacks, 'admin_page_init' ) );
       
    }

    public function add_field_for_storing_google_api_key()
    {

        register_setting( 'pbp_settings_group', 'google_api_key_option' );

        add_settings_section( 'pbp_setting_section', __( 'Set Your Valied Google API Key', 'pubs-bars-plugin' ), [ $this->admin_callbacks, 'pbp_setting_section_callback' ], 'pubs_bars_plugin' );

        add_settings_field( 'google_api_key_field', __( 'Your Google API Key', 'pubs-bars-plugin' ), [ $this->admin_callbacks, 'pbp_setting_field_callback' ], 'pubs_bars_plugin', 'pbp_setting_section' );

    }


}