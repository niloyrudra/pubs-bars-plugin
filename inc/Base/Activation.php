<?php

/**
 * 
 *  @package pubs-bars-plugin
 *  @version 1.0.0
 * 
 *  ==============================
 *         ACTIVATION CLASS
 *  ==============================
 * 
 */


namespace Inc\Base;

class Activation
{

    public static function activate() {

        add_option( 'Activate_Plugin', 'Pubs-Bars-Plugin' );

        if( is_admin() && get_option( 'Activate_Plugin' ) == 'Pubs-Bars-Plugin' ) {
            //Deleting the Option activated Plugin
            delete_option( 'Activate_Plugin' );
    
            // Loading Text Domain For Plugin
            load_plugin_textdomain('pubs-bars-plugin', false, basename( dirname( __FILE__ ) ) . '/languages' );

            
            flush_rewrite_rules();
        
        }

    }


}