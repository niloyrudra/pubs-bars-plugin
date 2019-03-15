<?php

/**
 * 
 *  ADMIN CALLBACKS
 *  =========================
 * 
 */


namespace Inc\Callbacks;



class AdminCallbacks
{

    // Admin Dashboard Page Callback Function
    public function admin_page_init()
    {
        require_once PLUGIN_PATH . '/inc/Pages/admin.php';
    }

}