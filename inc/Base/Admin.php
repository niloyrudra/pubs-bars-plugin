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
        add_action( 'admin_menu', array( $this, 'pbp_add_admin_pages' ) );
    }

    public function pbp_add_admin_pages()
    {
        
        add_menu_page( __( 'Pubs Bars Plugin', 'pubs-bars-plugin' ), __( 'Pubs/Bars Plugin', 'pubs-bars-plugin' ), 'manage_options', 'pubs_bars_plugin', array( $this->admin_callbacks, 'admin_page_init' ), 'dashicons-store', 110 );

        add_submenu_page( 'pubs_bars_plugin', __( 'Pubs Bars Settings Page', 'pubs-bars-plugin' ), __( 'Dashboard', 'pubs-bars-plugin' ), 'manage_options', 'pubs_bars_plugin', array( $this->admin_callbacks, 'admin_page_init' ) );

        add_submenu_page( 'pubs_bars_plugin', __( 'Database Section', 'pubs-bars-plugin' ), __( 'DataBase Manager', 'pubs-bars-plugin' ), 'manage_options', 'pubs_bars_db_manager', array( $this->admin_callbacks, 'pbp_db_manager' ) );
                
    }


}