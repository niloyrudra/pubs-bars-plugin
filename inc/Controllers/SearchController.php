<?php

/**
 * 
 *  Search Controller Class
 *
 * Register custom query vars
 *
 * @param array $vars The array of available query variables
 * 
 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/query_vars
 */

namespace Inc\Controllers;


class SearchController
{

    public function register_query_vars()
    {

        add_filter( 'query_vars', [ $this, 'pbp_register_query_vars' ] );

        add_action( 'pre_get_posts', [ $this, 'pbp_pre_get_posts' ], 1 );

        add_action('init', [ $this, 'pbp_rewrite_tag' ], 10, 0);

        add_action('init', [ $this, 'pbp_rewrite_rule' ], 10, 0);

    }


    public function pbp_register_query_vars( $vars )
    {

        // $vars[] = 'bar';
        $vars[] = 'city';
        $vars[] = 'country';
        $vars[] = 'csc';
        $vars[] = 'postcode';
        // $vars[] = 'pbp_city';
        // $vars[] = 'pbp_country';
        // $vars[] = 'pbp_csc';
        // $vars[] = 'pbp_postal_code';
        $vars[] = 'phone-num';

        return $vars;

    }

    /**
     * Build a custom query
     *
     * @param $query obj The WP_Query instance (passed by reference)
     *
     * @link https://codex.wordpress.org/Class_Reference/WP_Query
     * @link https://codex.wordpress.org/Class_Reference/WP_Meta_Query
     * @link https://codex.wordpress.org/Plugin_API/Action_Reference/pre_get_posts
     */

    public function pbp_pre_get_posts( $query )
    {

        if ( isset( $_REQUEST['search'] ) && $_REQUEST['search'] == 'advanced' && ! is_admin() && $query->is_search && $query->is_main_query() ) {

            $query->set( 'post_type', 'bars' );
    
            $_city = $_GET['pbp_city'] != '' ? $_GET['pbp_city'] : '';
            $_country = $_GET['pbp_country'] != '' ? $_GET['pbp_country'] : '';
            $_csc = $_GET['pbp_csc'] != '' ? $_GET['pbp_csc'] : '';
            $_postal_code = $_GET['pbp_postal_code'] != '' ? $_GET['pbp_postal_code'] : '';
    
            if( $_city || $_country || $_csc || $_postal_code ) {

                $meta_query = array(
                                    array(
                                        'key'     => '_pbp_city_key', // assumed your meta_key is 'car_model'
                                        'value'   => sanitize_text_field( $_city ),
                                        'compare' => 'LIKE', // finds models that matches 'model' from the select field
                                    ),
                                    array(
                                        'key'     => '_pbp_country_key', // assumed your meta_key is 'car_model'
                                        'value'   => sanitize_text_field( $_country ),
                                        'compare' => 'LIKE', // finds models that matches 'model' from the select field
                                    ),
                                    array(
                                        'key'     => '_pbp_postal_code_key', // assumed your meta_key is 'car_model'
                                        'value'   => sanitize_text_field( $_postal_code ),
                                        'compare' => 'LIKE', // finds models that matches 'model' from the select field
                                    ),
                                    array(
                                        'key'     => '_pbp_csc_key', // assumed your meta_key is 'car_model'
                                        'value'   => sanitize_text_field( $_csc ),
                                        'compare' => 'LIKE', // finds models that matches 'model' from the select field
                                    )
                                );

            }
            
            $query->set( 'meta_query', $meta_query );
    
        }

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
        // add_rewrite_tag( '%bar%', '([^&]+)' );
        add_rewrite_tag( '%city%', '([^&]+)' );
        add_rewrite_tag( '%country%', '([^&]+)' );
        add_rewrite_tag( '%csc%', '([^&]+)' );
        add_rewrite_tag( '%postcode%', '([^&]+)' );
        add_rewrite_tag( '%phone-num%', '([^&]+)' );
        // add_rewrite_tag( '%pbp_city%', '([^&]+)' );
        // add_rewrite_tag( '%pbp_country%', '([^&]+)' );
        // add_rewrite_tag( '%pbp_csc%', '([^&]+)' );
        // add_rewrite_tag( '%pbp_postal_code%', '([^&]+)' );
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
        
        // add_rewrite_rule( '^search/country/([^/]*)/?', 'search.php?search=advanced&s=&pbp_city=&pbp_country=$matches[1]&pbp_csc=&pbp_postal_code=','top' );
        // add_rewrite_rule( '^search/city/([^/]*)/?', 'search.php?search=advanced&s=&pbp_city=$matches[1]&pbp_country=&pbp_csc=&pbp_postal_code=','top' );
        // add_rewrite_rule( '^search/csc/([^/]*)/?', 'search.php?search=advanced&s=&pbp_city=&pbp_country=&pbp_csc=$matches[1]&pbp_postal_code=','top' );
        // add_rewrite_rule( '^search/postcode/([^/]*)/?', 'search.php?search=advanced&s=&pbp_city=&pbp_country=&pbp_csc=&pbp_postal_code=$matches[1]','top' );
        
        // flush_rewrite_rules(false);

    }
    

}