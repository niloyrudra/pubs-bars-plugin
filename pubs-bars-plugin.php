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

    // Function of Rendering Fields on the Admin Page After Activating The Plugin 
    function render_fields()
    {
    
        global $wpdb;

        $table = $wpdb->prefix . 'bars_zone';
        
        $pubs_bars_options = array(
            'pbp_name'          => array( 'title' => __( 'Pub\'s/Bar\'s Name', 'pubs-bars-plugin' ), 'type' => 'text', 'class' => 'regular-text', 'placeholder' => 'Name of the New Pub or the Bar' ),
            'pbp_address'       => array( 'title' => __( 'Address', 'pubs-bars-plugin' ), 'type' => 'text', 'class' => 'regular-text', 'placeholder' => 'Address of New Pub or the Bar' ),
            'pbp_postal_code'   => array( 'title' => __( 'Postal-Code/Zip-code', 'pubs-bars-plugin' ), 'type' => 'text', 'class' => 'regular-text', 'placeholder' => 'Postal/Zip Code' ),
            'pbp_city'          => array( 'title' => __( 'City', 'pubs-bars-plugin' ), 'type' => 'text', 'class' => 'regular-text', 'placeholder' => 'The City Name' ),
            'pbp_country'       => array( 'title' => __( 'Country', 'pubs-bars-plugin' ), 'type' => 'text', 'class' => 'regular-text', 'placeholder' => 'The Country Name' ),
            'pbp_csc'           => array( 'title' => __( 'CSC', 'pubs-bars-plugin' ), 'type' => 'text', 'class' => 'regular-text', 'placeholder' => 'Put CSC' ),
            'pbp_description'   => array( 'title' => __( 'Give a Description', 'pubs-bars-plugin' ), 'type' => 'textarea', 'class' => '', 'placeholder' => 'Give a Standard Discription' ),
            'pbp_latitude'      => array( 'title' => __( 'Latitude', 'pubs-bars-plugin' ), 'type' => 'text', 'class' => 'regular-text', 'placeholder' => 'The Latitude of the Pub or The Bar' ),
            'pbp_longitude'     => array( 'title' => __( 'Longitude', 'pubs-bars-plugin' ), 'type' => 'text', 'class' => 'regular-text', 'placeholder' => 'The Longitude of the Pub or The Bar' ),
            'pbp_pic'           => array( 'title' => __( 'Picture', 'pubs-bars-plugin' ), 'type' => 'media_link', 'class' => 'regular-text', 'placeholder' => 'Attach a picture of the Pub or the Bar' ),
            'pbp_website'       => array( 'title' => __( 'Website', 'pubs-bars-plugin' ), 'type' => 'url', 'class' => 'regular-text', 'placeholder' => 'The Website Address' ),
            'pbp_twitter'       => array( 'title' => __( 'Twitter', 'pubs-bars-plugin' ), 'type' => 'url', 'class' => 'regular-text', 'placeholder' => 'The Twitter Handler' ),
            'pbp_facebook'      => array( 'title' => __( 'Facebook', 'pubs-bars-plugin' ), 'type' => 'url', 'class' => 'regular-text', 'placeholder' => 'The Facebook Handler' ),
            'pbp_featured'      => array( 'title' => __( 'Featured', 'pubs-bars-plugin' ), 'type' => 'checkbox', 'class' => '' )
        );

        // If EDIT Button is Triggered then recall the particular row to be edited
        if( isset( $_POST[ 'pbp_edit_entry' ] ) ) {

            $entry = esc_sql( $_POST[ 'pbp_edit_entry' ] );

            // Generate Entry Row Data to Prepopulate Field To setup the stage to update them
            $entry_row = $wpdb->get_row(
            "SELECT * FROM {$table} WHERE id = '$entry'"
            );

        }

        foreach ($pubs_bars_options as $key => $value) {

            $name = str_replace( 'pbp_', '', $key );

            if( $value[ 'type' ] === 'text' || $value[ 'type' ] === 'url' ) {
                        
                echo '<tr>
                        <th scope="row">
                            <label for="' . $key . '">' . $value[ 'title' ] . '</label>
                        </th>
                        <td>
                            <input name="' . $key . '" type="' . $value[ 'type' ] . '" id="' . $key . '" value="' . ( @$_POST[ 'pbp_edit_entry' ] ? $entry_row->$name : '' ) . '" class="' . $value[ 'class' ] . '" placeholder="' . $value[ 'placeholder' ] . '">
                        </td>
                    </tr>';
                        
            }
            elseif ( $value[ 'type' ] === 'checkbox' ) {

                echo '<tr>
                            <th scope="row">' . $value[ 'title' ] . '</th>
                            <td> 
                                <fieldset>
                                    <legend class="screen-reader-text"><span>Membership</span></legend>
                                    <label for="' . $key . '">
                                        <input name="' . $key . '" type="checkbox" id="' . $key . '" value="1" ' . ( @$_POST[ 'pbp_edit_entry' ] && $entry_row->$name == 1 ? 'checked' : '' ) . '>
                                        <span class="dashicons dashicons-thumbs-up"></span>  <span class="dashicons dashicons-thumbs-down"></span></label>
                                </fieldset>
                            </td>
                        </tr>';

            }
            elseif( $value[ 'type' ] === 'media_link' ) {
                
                echo '<tr><th scope="row">' . $value[ 'title' ] . '</th><td><fieldset>';

                // echo '<input type="text" name="' . $key . '" id="' . $key . '" value="' . ( @$_POST[ 'pbp_edit_entry' ] ? $entry_row->$name : '' ) . '" class="regular-text" />';

                if( empty( $entry_row->pic ) ) {

                    echo '<span class="pbp-upload-btn-icon"><span class="dashicons dashicons-upload"></span><input type="button" class="button button-secondary" value="Upload a Picture" id="upload-button" /></span><input type="hidden" id="' . $key . '" name="' . $key . '" value="" /><code class="pbp-code"></code>';
                    
                }else{

                    echo '<span class="pbp-upload-btn-icon"><span class="dashicons dashicons-undo"></span><input type="button" class="button button-secondary" value="Replace Picture" id="upload-button" /></span>
                        <span class="pbp-upload-btn-icon"><span class="dashicons dashicons-trash"></span><input type="button" class="button button-secondary" value="Remove" id="remove-button" name="remove-button" /></span>
                        <input type="hidden" id="' . $key . '" name="' . $key . '" value="' . ( @$_POST[ 'pbp_edit_entry' ] ? $entry_row->$name : '' ) . '" />';
                    
                }

                echo '</fieldset></td></tr>';


            }
            else{

                echo '<tr>
                        <th scope="row">' . $value[ 'title' ] . '</th>
                            <td>
                            <fieldset>                            
                                <textarea name="' . $key . '" rows="10" cols="50" id="' . $key . '" class="regular-text" placeholder="' . $value[ 'placeholder' ] . '">' . ( @$_POST[ 'pbp_edit_entry' ] ? $entry_row->$name : '' ) . '</textarea>
                            </fieldset>
                        </td>
                    </tr>';

            }
                
        }

        
    }


    // Func for Search Results by Distance
    function pbp_search_by_distance() {
 
        global $wpdb;
                
        $table = $wpdb->prefix . 'bars_zone';

        // if( isset( $_GET[ 'pbp_search_lat' ] ) && isset( $_GET[ 'pbp_search_lng' ] ) && isset( $_GET[ 'pbp_radius' ] ) ) {
        if( isset( $_GET[ 'pbp_radius' ] ) ) {

            //$latitude = esc_sql( $_GET[ 'pbp_search_lat' ] );
            //$longitude = esc_sql( $_GET[ 'pbp_search_lng' ] );
            $relation = esc_sql( $_GET[ 'pbp_select' ] );
            $radius = esc_sql( $_GET[ 'pbp_radius' ] );
            $limit_high = esc_sql( $_GET[ 'pbp_limit' ] );

            $limit_low = 0;

            $results = $wpdb->get_results( "SELECT *, ( 3959 * acos( cos( radians(37) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(-122) ) + sin( radians(37) ) * sin( radians( latitude ) ) ) ) AS distance FROM {$table} HAVING distance {$relation} {$radius} ORDER BY distance LIMIT {$limit_low}, {$limit_high}" );
            

            return $results;

        }

        return array();

    }

}
