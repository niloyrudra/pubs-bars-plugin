<?php

/*

    Plugin Name: Pubs/Bars Plugin
    Plugin URI:
    Author Name: Niloy Rudra
    Author URI:
    Description: This is Pubs/Bars Searching Plugin writen by Niloy Rudra to give this website a particular ability of searching through the entries of pubs/bars based on user's queries and populate the output with what they need from this beautiful website.
    Author URI: https://niloyrudra.ml/
    Version: 1.0.0
    Licence: GPLv2 or later
    Text Domain: pubs-bars-plugin

*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

//  If this file is called firectly, abort!!
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );


if( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}


use Inc\Init;
use Inc\Base\Activation;
use Inc\Base\Deactivation;


/**
 *  Declare or Define CONSTANTS
 */
define( 'PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PLUGIN_NAME', plugin_basename( __FILE__ ) );


// include_once dirname( __FILE__ ) . '/inc/Base/Activation.php';
function bars_plugin_activation_func(){
    Activation::activate();
}
register_activation_hook( __FILE__, 'bars_plugin_activation_func' );


// include_once dirname( __FILE__ ) . '/inc/Base/Deactivation.php';
function bars_plugin_deactivation_func(){
    Deactivation::deactivate();
}
register_deactivation_hook( __FILE__, 'bars_plugin_deactivation_func' );



/**
 *  Initiate Init Class
 *  ==================================
 */
if( class_exists( Inc\Init::class ) ) {
    
    $init = new Init();
    // Register Admin Page After Activating The Plugin  
    $init->register();

}
