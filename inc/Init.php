<?php

/**
 * 
 *  Init Class
 * ===============
 * 
 */


namespace Inc;

use Inc\Base\Admin;
use Inc\Base\Enqueue;
use Inc\Base\Shortcodes;
use Inc\Base\SettingsActionLinks;
use Inc\Controllers\CptController;
use Inc\Controllers\RestApiRoutes;
use Inc\Controllers\SearchController;
use Inc\Controllers\RestApiController;
use Inc\Controllers\DatabaseController;
use Inc\Controllers\TemplatesController;
use Inc\Controllers\RecentSearchesWidgetController;
use Inc\Controllers\AdvanceSearchFormWidgetController;



final class Init
{

    public $enqueue;
    public $rest_api;
    public $shortcodes;
    public $rest_routes;
    public $rct_scr_wdgt;
    public $db_controller;
    public $settings_links;
    public $cpt_controller;
    public $adv_searchform;
    public $tpl_controller;
    public $admin_callbacks;
    public $search_controller;


    public function __construct()
    {

        // Instanciate Admin Callback Class
        $this->admin = new Admin();

        // Instanciate Plugin Action Links
        $this->settings_links = new SettingsActionLinks();

        // Instanciate Database Controller
        $this->db_controller = new DatabaseController();

        // Instanciate Enqueue class to enqeueu css and js files
        $this->enqueue = new Enqueue();

        // Instanciate Search Controller
        $this->cpt_controller = new CptController();

        // Instanciate Rest API Controller
        $this->rest_api = new RestApiController();

        // Instanciate Search Controller
        $this->search_controller = new SearchController();

        // Instanciate Templates Controller Class
        $this->tpl_controller = new TemplatesController();

        // Instanciate Shortcodes Class
        // $this->shortcodes = new Shortcodes();
        
        // Instanciate Advance Search Form Widget Class
        $this->adv_searchform = new AdvanceSearchFormWidgetController();
        
        // Instanciate RestApiRoutes Class
        $this->rest_routes = new RestApiRoutes();

        // Instantiate Recent Search Widget
        $this->rct_scr_wdgt = new RecentSearchesWidgetController();
        

    }

    public function register()
    {

        // Register Admin Page After Activating The Plugin  
        $this->admin->register_admin_pages();
        
        // Registering Plugin Action Links
        $this->settings_links->register_action_links();

        // Database Init
        $this->db_controller->insert_data();
        isset( $_POST[ 'pbp_update_entry' ] ) ? $this->db_controller->update_entries() : '';
        isset( $_POST[ 'pbp_remove_entry' ] ) ? $this->db_controller->deleting_entries() : '';


        // Enqueue Scripts
        $this->enqueue->register();

        // Register Bars Post Type
        $this->cpt_controller->register_bars();

        // Register Rest API Routes
        // $this->rest_api->register();

        // Generate Search Query
        $this->search_controller->register_query_vars();

        // Generate Custom Templates
        $this->tpl_controller->register_templates();

        // Registering Shortcode
        // $this->shortcodes->register_shortcodes();

        // Registering Reat Routes
        $this->rest_routes->register_rest_api_routes();

        // Registering Advance Search Form Widget
        $this->adv_searchform->register_searchform();

        // Register Recent Search Widget
        $this->rct_scr_wdgt->register_recent_searches_widget();

    }


}