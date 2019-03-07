<?php

/**
 * 
 *  REST API ROUTES REGISTER
 *  =========================
 * 
 *  @package pubs-bars-plugin
 *  @version 1.0.0
 * 
 */

namespace Inc\Controllers;


if( class_exists( 'WP_REST_Controller' ) ):

    // class RestApiRoutes extends WP_REST_Controller
    class RestApiRoutes
    {

        public function __construct()
        {
            $this->namespace = '/bars/v1';
            $this->resource_name = 'search/';
        }

        public function register_rest_api_routes()
        {
            add_action( 'rest_api_init', [ $this, 'register_rest_route' ] );
        }

        public function register_rest_route()
        {

            register_rest_route( $this->namespace, '/' . $this->resource_name, [
            
                'methods'               => \WP_REST_SERVER::READABLE,
                'callback'              => [ $this, 'pbp_search_results_callback' ],
                'show_in_rest'          => true
            
            ] );

        }

        public function pbp_search_results_callback( $data )
        {

            $search_query = sanitize_text_field( $data[ 'term' ] );

            $args = array(  
                'post_status' => 'publish',
                'post_type' => [ 'bars', 'post' ],
                'post_type' => 'bars',
                's' => $search_query
            );

            $bars = new \WP_Query( $args );

            $search_results = [
                'posts'      => [],
                'bars'      => []
            ];

            while( $bars->have_posts() ) {
                $bars->the_post();

                if( get_post_type() == 'bars' ) {
               
                    array_push( $search_results[ 'bars' ], [
                        'title'         => esc_html( get_the_title() ),
                        'permalink'     => esc_html( get_the_permalink() ),
                        'postType'      => esc_html( get_post_type() ),
                        'content'       => esc_html( get_the_excerpt() )
                    ] );
                    
                }

                if( get_post_type() == 'post' ) {

                    array_push( $search_results[ 'post' ], [
                        'title'         => esc_html( get_the_title() ),
                        'permalink'     => esc_html( get_the_permalink() ),
                        'postType'      => esc_html( get_post_type() )
                    ] );

                }

            } 



            /**
             * 
             *  Adding Custom Fields Value Indicator
             * 
             */

            $bar_related_meta_keys = [ 
                '_pbp_city_key',
                '_pbp_country_key',
                '_pbp_postal_code_key',
                '_pbp_csc_key',
                '_pbp_phone_num_key',
            ];

            $meta_array = array();
            $meta_array['relation'] = 'OR';  // DECLARE RELATION --> YOU CAN USE 'OR' AS WELL  
           
            foreach($bar_related_meta_keys as $meta_key){  // CREATE QUERY FOR EACH COUNTRY IN ARRAY

                $meta_array[] =  array(
                    'key'       => $meta_key,  
                    'value'     => $search_query,  // THE COUNTRY TO SEARCH
                    'compare'   => 'LIKE',  // TO SEARCH THIS COUNTRY IN YOUR COMMA SEPERATED STRING
                    'type'      => 'CHAR',
                );
            
            }
                        
            $argsTwo = array (
                    'post_type'     => array( 'bars' ),  // YOUR POST TYPE
                    'meta_query'    => $meta_array,  // ARRAY CONTAINING META QUERY
                );
            
            // The Query
            $metaQuery = new \WP_Query( $argsTwo );

            while( $metaQuery->have_posts() ) {
                $metaQuery->the_post();

                if( get_post_type() == 'bars' ) {

                    array_push( $search_results[ 'bars' ], [
                        'title'         => esc_html( get_the_title() ),
                        'permalink'     => esc_html( get_the_permalink() ),
                        'postType'      => esc_html( get_post_type() ),
                        'content'       => esc_html( get_the_excerpt() )
                    ] );
                    
                }

            }

            // Filtering for removing duplicate entries
            $search_results[ 'bars' ] = array_values( array_unique( $search_results[ 'bars' ], SORT_REGULAR ) );

            return $search_results;

        }
        
    }
    
endif;
