<?php

/**
 * 
 *  This set file will trigger on Plugin Uninstall
 * 
 */

if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) die;


// Drop Plugin Table wp_pbp_db_table Using $wpdb Object
global $wpdb;

$table = $wpdb->prefix . 'bars_zone';

$wpdb->query( $wpdb->prepare( "DROP TABLE IF EXISTS %s", $table ) );