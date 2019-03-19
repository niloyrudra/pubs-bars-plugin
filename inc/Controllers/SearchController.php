<?php

/**
 * 
 *  ============================
 *     Search Controller Class
 *  ============================
 *   Register custom query vars
 *  ============================
 * 
 *  @package pubs-bars-plugin
 *  @version 1.0.0
 * 
 */

namespace Inc\Controllers;


class SearchController
{

    public function register_query_vars()
    {

        add_action( 'posts_join', [ $this, 'search_posts_join'] );

        add_action( 'posts_where', [ $this, 'search_posts_where'] );

        add_filter( 'query_vars', [ $this, 'pbp_register_query_vars' ] );

        add_action( 'pre_get_posts', [ $this, 'pbp_pre_get_posts' ], 1 );

        add_action('init', [ $this, 'pbp_rewrite_tag' ], 10, 0);

        add_action('init', [ $this, 'pbp_rewrite_rule' ], 10, 0);

    }

    public function search_posts_join( $join ) {
 
        global $wp_query, $wpdb;
      
        // Searching and not in admin
        if ( ! is_admin() && $wp_query->is_search && isset( $wp_query->query_vars['s'] ) ) {
           $join .= "LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id";
        }
        return $join;
      
    }

    public function search_posts_where( $where ) {
 
        global $wp_query, $wpdb;
      
        // Searching and not in admin
        if ( ! is_admin() && $wp_query->is_search && isset( $wp_query->query_vars['s'] ) ) {
      
           // Store search query
           $s = $wp_query->query_vars['s'];
      
           // Write the where clause from scratch
           $where  = " AND (($wpdb->posts.post_title LIKE '%$s%') OR ($wpdb->postmeta.meta_key = '_pbp_city_key' AND $wpdb->postmeta.meta_value LIKE '%$s%')  OR ($wpdb->postmeta.meta_key = '_pbp_country_key' AND $wpdb->postmeta.meta_value LIKE '%$s%') OR ($wpdb->postmeta.meta_key = '_pbp_postal_code_key' AND $wpdb->postmeta.meta_value LIKE '%$s%') OR ($wpdb->postmeta.meta_key = '_pbp_csc_key' AND $wpdb->postmeta.meta_value LIKE '%$s%') OR ($wpdb->postmeta.meta_key = '_pbp_address_key' AND $wpdb->postmeta.meta_value LIKE '%$s%') OR ($wpdb->postmeta.meta_key = '_pbp_phone_num_key' AND $wpdb->postmeta.meta_value LIKE '%$s%'))";
      
           // Only posts from 'products' post type
           $where .= " AND wp_posts.post_type = 'bars'";
      
           // Published posts only
           $where .= " AND wp_posts.post_status = 'publish'";
      
           // Because of the join, otherwise multiple same results
           $where .= " GROUP BY $wpdb->posts.ID";
        }
      
        return $where;
    }

    public function pbp_register_query_vars( $vars )
    {

        $vars[] = 'city';
        $vars[] = 'country';
        $vars[] = 'csc';
        $vars[] = 'postcode';
        $vars[] = 'phone-num';

        return $vars;

    }

    /**
     * Build a custom query
     *
     * @param $query obj The WP_Query instance (passed by reference)
     * 
     */

    public function pbp_pre_get_posts( $query )
    {

        // check if the user is requesting an admin page 
        // or current query is not the main query
        if ( is_admin() || $query->is_feed() || ! $query->is_main_query() ){
            return;
        }

        // edit the query only when post type is 'bars'
        // if it isn't, return
        if ( is_post_type_archive( 'bars' ) ){
            
            $meta_query = array();
    
            if( !empty( get_query_var( 'city' ) ) ){
                $meta_query[] = array( 'key' => '_pbp_city_key', 'value' => get_query_var( 'city' ), 'compare' => 'LIKE' );
            }
    
            if( !empty( get_query_var( 'country' ) ) ){
                $meta_query[] = array( 'key' => '_pbp_country_key', 'value' => get_query_var( 'country' ), 'compare' => 'LIKE' );
            }
    
            if( !empty( get_query_var( 'csc' ) ) ){
                $meta_query[] = array( 'key' => '_pbp_csc_key', 'value' => get_query_var( 'csc' ), 'compare' => 'LIKE' );
            }
    
            if( !empty( get_query_var( 'postcode' ) ) ){
                $meta_query[] = array( 'key' => '_pbp_postal_code_key', 'value' => get_query_var( 'postcode' ), 'compare' => 'LIKE' );
            }
    
            if( !empty( get_query_var( 'phone-num' ) ) ){
                $meta_query[] = array( 'key' => '_pbp_phone_num_key', 'value' => get_query_var( 'phone-num' ), 'compare' => 'LIKE' );
            }
            
            if( count( $meta_query ) > 1 ){
                $meta_query['relation'] = 'AND';
            }
            
            if( count( $meta_query ) > 0 ){
                $query->set( 'meta_query', $meta_query );
            }

        }


    }


    /**
     * Add rewrite tags
     *
     * @link https://codex.wordpress.org/Rewrite_API/add_rewrite_tag
     */

    public function pbp_rewrite_tag()
    {
        add_rewrite_tag( '%city%', '([^&]+)' );
        add_rewrite_tag( '%country%', '([^&]+)' );
        add_rewrite_tag( '%csc%', '([^&]+)' );
        add_rewrite_tag( '%postcode%', '([^&]+)' );
        add_rewrite_tag( '%phone-num%', '([^&]+)' );
    }
    
    /**
     * Add rewrite rules
     *
     * @link https://codex.wordpress.org/Rewrite_API/add_rewrite_rule
     */
    public function pbp_rewrite_rule()
    {
        // Custom Post Archive
        add_rewrite_rule( '^bars/city/([^/]*)/?', 'index.php?post_type=bars&city=$matches[1]','top' );
        add_rewrite_rule( '^bars/country/([^/]*)/?', 'index.php?post_type=bars&country=$matches[1]','top' );
        add_rewrite_rule( '^bars/csc/([^/]*)/?', 'index.php?post_type=bars&csc=$matches[1]','top' );
        add_rewrite_rule( '^bars/postcode/([^/]*)/?', 'index.php?post_type=bars&postcode=$matches[1]','top' );
        add_rewrite_rule( '^bars/phone-number/([^/]*)/?', 'index.php?post_type=bars&phone-num=$matches[1]','top' );
        add_rewrite_rule( '^bars/country/city/([^/]*)/?', 'index.php?post_type=bars&country=$matches[1]&city=$matches[1]','top' );
        add_rewrite_rule( '^bars/country/([^/]*)/city/([^/]*)/?', 'index.php?post_type=bars&country=$matches[1]&city=$matches[1]','top' );
        add_rewrite_rule( '^bars/([^/]*)/([^/]*)/?', 'index.php?post_type=bars&country=$matches[1]&city=$matches[1]','top' );
        
    }
    

}