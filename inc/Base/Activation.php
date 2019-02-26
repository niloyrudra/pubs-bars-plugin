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


            // Creating Custom Table in the WP Database
            global $wpdb, $bar_db_version;
    
            $bar_db_version = '1.0.0';
        
            $table_name = $wpdb->prefix . 'bars_zone';
            
            $charset_collate = $wpdb->get_charset_collate();

            if( $wpdb->get_var( "SHOW TABLES LIKE " . $table_name ) != $table_name ) {

                $sql = "CREATE TABLE " . $table_name . " (
                    id INTEGER(10) NOT NULL AUTO_INCREMENT,
                    name VARCHAR(255) NOT NULL,
                    address VARCHAR(255),
                    postal_code VARCHAR(128),
                    city VARCHAR(255),
                    country VARCHAR(255),
                    csc VARCHAR(255),
                    description TEXT,
                    pic TEXT,
                    latitude FLOAT(11, 7),
                    longitude FLOAT(11, 7),
                    website VARCHAR(255) NOT NULL,
                    twitter VARCHAR(255) NOT NULL,
                    facebook VARCHAR(255) NOT NULL,
                    featured INTEGER(1) NOT NULL DEFAULT 0,
                    PRIMARY KEY  (id)
                ) $charset_collate;";
            
                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                dbDelta( $sql );
            
                add_option( 'bars_db_version', $bar_db_version );

                // Creating Additional Page
                // Create post object
                        // $pbp_post_object = array(
                        //     'post_title'    => wp_strip_all_tags( 'Pubs & Bars' ),
                        //     'post_content'  => __( 'Auto generated page by Pubs & Bars Plugin', 'pubs-bars-plugin' ),
                        //     'post_status'   => 'publish',
                        //     'post_author'   => 1,
                        //     'post_type'     => 'page',
                        // );
                    
                        // // Insert the post into the database
                        // wp_insert_post( $pbp_post_object );

                
                        
                }
            
            
            flush_rewrite_rules();
        
        }

    }


}