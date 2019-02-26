<?php

/**
 * 
 *  Rest Api Controller Class
 * 
 */

namespace Inc\Controllers;

class RestApiController
{
    public function register()
    {
        add_action( 'rest_api_init', [ $this, 'pbp_custom_rest' ] );
    }

    public function pbp_custom_rest()
    {
        register_rest_field( 'bars', 'author_name', [
            'get_callback'      => function() { return get_the_author(); }
        ] );
    }

}