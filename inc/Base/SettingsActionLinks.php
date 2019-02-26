<?php

/**
 * 
 *  SETTIGNS PLUGIN ACTION LINKS
 * ==============================
 * 
 */


namespace Inc\Base;


class SettingsActionLinks
{

    protected $plugin;

    public function __construct()
    {
        /**
         * Declaring Plugin Name To Use 
         * As a Variable In plugin_action_links_{ PLUGIN-NAME }
         */ 
        $this->plugin = PLUGIN_NAME;
        
    }
    
    public function register_action_links()
    {

        // Registering Plugin Action Links
        add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );
        
    }


    public function settings_link( $links )
    {

        $plugin_action_links = array(
            'pubs_bars_plugin'          => 'Dashboard',
            'pubs_bars_db_manager'      => 'DB Manager',
        );

        foreach ( $plugin_action_links as $page_slug => $link_title ) {
            
            array_push( $links, '<a href="admin.php?page=' . $page_slug . '">' . __( $link_title, 'pubs-bars-plugin' ) . '</a>' );

        }

        return $links;

    }

}