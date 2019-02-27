<?php

/**
 * 
 *  @package pubs-bars-plugin
 *  @version 1.0.0
 * 
 *  ==============================
 *          ENQUEUE CLASS
 *  ==============================
 * 
 */


namespace Inc\Base;



class Enqueue
{

    public function register()
    {
        // Hooking Style and Script files for Admin Sections
        add_action( 'admin_enqueue_scripts', array( $this, 'pbp_admin_enqueue_script' ) );

        // Hooking Style and Script files for front Sections
        add_action( 'wp_enqueue_scripts', array( $this, 'pbp_wp_enqueue_script' ) );
        
        
    }
    
    // Scripts Callback Function for ADMIN SEACTION
    public function pbp_admin_enqueue_script( $hook )
    {
        // echo $hook;
        wp_enqueue_style( 'custom-styles', PLUGIN_URL . '/assets/css/style-admin.min.css' );
        
        // Enqueue Media
        wp_enqueue_media();
        
        // wp_enqueue_script( 'media-upload-js', PLUGIN_URL . '/assets/js/media-upload.min.js' );
        wp_enqueue_script( 'custom-js', PLUGIN_URL . '/assets/js/main-admin.min.js' );
            
            
    }
        
    // Scripts Callback Function for FRONT-END SEACTION
    public function pbp_wp_enqueue_script()
    {
            
        // Enqueue jQuery File
        wp_enqueue_script( 'front-jQuery-file', 'https://code.jquery.com/jquery.js' );
            

        if( is_page_template( 'templates/google-map-bar-finder-tpl.php' ) ) {
           
            // Enqueue initMap Function js File
            wp_enqueue_script( 'google-map-init-func', PLUGIN_URL . '/assets/js/google-map.min.js' );
                
            // Enqueuing Google API Key
            $API = 'AIzaSyDxzkVnPv1w97W88F4H6fFcbZhKWAhBwTo';
            wp_enqueue_script( 'pbp-google-map-js', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=' . $API );
            // wp_enqueue_script( 'pbp-google-map-js', 'https://maps.googleapis.com/maps/api/js?key=' . $API . '&callback=initMap' );
    
            add_filter( 'script_loader_tag', [ $this, 'make_script_async' ], 10, 3 );
            
        }



        // Enqueuing Custom CSS
        wp_enqueue_style( 'custom-styles', PLUGIN_URL . '/assets/css/style-front.min.css' );
        
        // Enqueuing JS File
        // wp_enqueue_script( 'geo-location-js', PLUGIN_URL . '/assets/js/geo_location.js' );
        wp_enqueue_script( 'custom-js', PLUGIN_URL . '/assets/js/main-front.min.js', array( 'jquery' ), '1.0.0', true );
    
        add_filter( 'script_loader_tag', [ $this, 'make_script_async_two' ], 10, 3 );

        // ***** //
        // global $bar_collections;
        wp_localize_script( 'custom-js', 'barsData', [
            'root_url'      => get_site_url()
        ] );

    }


    public function make_script_async( $tag, $handle, $src )
    {
        if ( 'pbp-google-map-js' != $handle ) {
            return $tag;
        }

        return str_replace( '<script', '<script async defer', $tag );
    }

    public function make_script_async_two( $tag, $handle, $src )
    {
        if ( 'custom-js' != $handle ) {
            return $tag;
        }

        return str_replace( '<script', '<script async defer', $tag );
    }

}
