<?php

/**
 * 
 *  @package pubs-bars-plugin
 *  @version 1.0.0
 * 
 *  ===============================
 *         DEACTIVATION CLASS
 *  ===============================
 * 
 */


namespace Inc\Base;

class Deactivation
{

    public static function deactivate()
    {

        flush_rewrite_rules();

        if( get_option( 'Activate_Plugin' ) == 'Pubs-Bars-Plugin' ) {

            delete_option( 'Activate_Plugin' );

        }
        
    }

}