<?php

/**
 *  
 *  ==================
 *   Shortcodes Class
 *  ==================
 *  
 *  @package pubs-bars-plugin
 *  @version 1.0.0
 * 
 */

namespace Inc\Base;


class Shortcodes
{

    public $db_controller;

    public function __construct()
    {
        $this->db_controller = new DatabaseController();
    }

    public function register_shortcodes()
    {

        // Search Form Shortcode
        add_shortcode( 'search-form', [ $this, 'search_form_handler' ] );

    }

    public function search_form_handler( $atts )
    {
        $attributes = shortcode_atts( [
            'title'         => __( 'Search For Pubs/Bars Near You.', 'pubs-bars-plugin' ),
            'placeholder'   => __( 'Write Your Query Here...', 'pubs-bars-plugin' )
        ], $atts );

        // return '<div style="width:100%;padding:2em 1em;background-color:#ddd;"><h3>' . $attributes[ 'title' ] . '</h3><form method="post" style="display:flex;flex-direction:row;width:100%;"><input type="search" name="pbp_search_field" id="pbp_search_field" placeholder="' . $attributes[ 'placeholder' ] . '" style="border:none;width:85%;border-radius:20px 0 0 20px;font-size:24px;margin-right:0;padding-left:15px;" /><input type="submit" value="Search" name="pbp_search_btn" id="pbp_search_btn" class="btn btn-primary" style="border:none;width:15%;border-radius:0 20px 20px 0;margin-left:0;letter-spacing:1px;" /></form></div>
        // ' . ( ( @$_POST[ 'pbp_search_field' ] && @$_POST[ 'pbp_search_btn' ] ) ? $this->db_controller->display_results() : '' ) . '
        // ';

        return '<div style="width:100%;padding:2em 1em;background-color:#ddd;"><h3>' . $attributes[ 'title' ] . '</h3><form method="get" style="display:flex;flex-direction:row;width:100%;"><input type="search" name="pbp_search_field" id="pbp_search_field" placeholder="' . $attributes[ 'placeholder' ] . '" style="border:none;width:85%;border-radius:20px 0 0 20px;font-size:24px;margin-right:0;padding-left:15px;" /><input type="submit" value="Search" name="pbp_search_btn" id="pbp_search_btn" class="btn btn-primary" style="border:none;width:15%;border-radius:0 20px 20px 0;margin-left:0;letter-spacing:1px;" /></form></div>
        <div style="margin-top:2em;display:block:position:relative;width:100%;padding:1em;border:1px dotted #e1e1e1;box-shadow:0 12px 35px 5px rgba(0,0,0,0.3)">' . ( ( @$_GET[ 'pbp_search_field' ] && @$_GET[ 'pbp_search_btn' ] ) ? 'Search Results Will Show here...' : '' ) . '
        </div>';
    }

}