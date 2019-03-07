<?php

/**
 * 
 *  Template Controller Class
 *  ==========================
 * 
 */

namespace Inc\Controllers;


class TemplatesController
{
    public $templates;
 
    public function register_templates()
    {

        $this->templates = [
            'templates/google-map-tpl.php' => __( 'Bars\' Location Tracker Template', 'pubs-bars-plugin' ),
        ];

        add_filter( 'theme_page_templates', array( $this, 'custom_templates' ) );
        // Loading the Search Result Template
        add_filter( 'template_include', [ $this, 'load_template' ] );

    }

    public function custom_templates( $templates )
    {

        $templates = array_merge( $templates, $this->templates );

        return $templates;

    }

    public function load_template( $template )
    {

        global $post;

        if( ! $post ) return $template;

        $template_name = get_post_meta( $post->ID, '_wp_page_template', true );

        if( ! isset( $this->templates[ $template_name ] ) ) return $template;

        $file = PLUGIN_PATH . $template_name;

        if( file_exists( $file ) ) return $file;


        return $template;

    }

}