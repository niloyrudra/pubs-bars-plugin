<?php

/**
 * 
 *  ==============================================
 *  This set file will trigger on Plugin Uninstall
 *  ==============================================
 * 
 *  @package pubs-bars-plugin
 *  @version 1.0.0
 * 
 */

if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) die;


// Drop Plugin Table wp_pbp_db_table Using $wpdb Object
global $wpdb;

$table = $wpdb->prefix . 'bars_zone';

$post_table = $wpdb->prefix . 'posts';
$postmeta_table = $wpdb->prefix . 'postmeta';
$term_relationship_table = $wpdb->prefix . 'term_relationships';
$post_type = 'bars';

$wpdb->query( $wpdb->prepare( "DELETE FROM %s WHERE post_type = %s", $post_table, $post_type ) );
$wpdb->query( $wpdb->prepare( "DELETE FROM %s WHERE post_id NOT IN (SELECT id FROM %s)", $postmeta_table, $post_table ) );
$wpdb->query( $wpdb->prepare( "DELETE FROM %s WHERE object_id NOT IN (SELECT id FROM %s)", $term_relationship_table, $post_table ) );

$wpdb->query( $wpdb->prepare( "DROP TABLE IF EXISTS %s", $table ) );