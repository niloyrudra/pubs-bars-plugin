<?php

/**
 * 
 *  Advance Search Form Widget Controller Class
 * 
 */

namespace Inc\Controllers;

use WP_Widget;

class AdvanceSearchFormWidgetController extends WP_Widget
{

    public $widget_id;
    public $widget_name;
    public $widget_options;
    public $control_options;

    public function __construct()
    {
        $this->widget_id = 'pbp_advance_searchform';
        $this->widget_name = __( 'Advance Search Form', 'pubs-bars-plugin' );

        $this->widget_options = [
            'classname'                     => $this->widget_id,
            'description'                   => $this->widget_name,
            'customize_selective_refresh'   => true
        ];

        $this->control_options = [
            'width'     => 400,
            'height'    => 650
        ];

    }

    public function register_searchform()
    {

        parent::__construct( $this->widget_id, $this->widget_name, $this->widget_options, $this->control_options );

        add_action( 'widgets_init', [ $this, 'register_advanced_searchform' ] );

    }

    public function register_advanced_searchform()
    {

        register_widget( $this );

    }

    public function widget($args, $instance)
    {

        echo $args[ 'before_widget' ];

        if( !empty( $instance[ 'title' ] ) ) {

            echo $args[ 'before_title' ] . apply_filters( 'widget_title', $instance[ 'title' ] ) . $args[ 'after_title' ];

        }

        ?>

        <form method="get" id="advanced-searchform" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">

            <input type="hidden" name="search" value="advanced">

            <label for="s" class=""><?php esc_attr_e( 'Search By Name: ', 'pubs-bars-plugin' ); ?></label>
            <input type="text" value="" placeholder="<?php esc_attr_e( 'Type the Pub\Bar Name', 'pubs-bars-plugin' ); ?>" name="s" id="name" />

            <label for="pbp_city" class=""><?php esc_attr_e( 'Search By City Name: ', 'pubs-bars-plugin' ); ?></label>
            <input type="text" name="pbp_city" id="pbp_city" value="" class="search-form" placeholder="<?php esc_attr_e( 'Type the City Name', 'pubs-bars-plugin' ); ?>">

            <label for="pbp_country" class=""><?php esc_attr_e( 'Search By Country Name: ', 'pubs-bars-plugin' ); ?></label>
            <input type="text" name="pbp_country" id="pbp_country" value="" class="search-form" placeholder="<?php esc_attr_e( 'Type the Country Name', 'pubs-bars-plugin' ); ?>">

            <label for="pbp_csc" class=""><?php esc_attr_e( 'Search By CSC: ', 'pubs-bars-plugin' ); ?></label>
            <input type="text" name="pbp_csc" id="pbp_csc" value="" class="search-form" placeholder="<?php esc_attr_e( 'Type the CSC Name', 'pubs-bars-plugin' ); ?>">

            <label for="pbp_postal_code" class=""><?php esc_attr_e( 'Search By Post Code: ', 'pubs-bars-plugin' ); ?></label>
            <input type="text" name="pbp_postal_code" id="pbp_postal_code" value="" class="search-form" placeholder="<?php esc_attr_e( 'Type the Post Code', 'pubs-bars-plugin' ); ?>">

            <input type="submit" id="searchsubmit" value="Search" />

        </form>
        
    <?php

        echo $args[ 'after_widget' ];

    }


    public function form( $instance )
    {

        $title = !empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : esc_html__( 'Advance Search', 'pubs-bars-plugin' );
        $title_ID = esc_attr( $this->get_field_id( 'title' ) );
        $field_name = esc_attr( $this->get_field_name( 'title' ) );

        ?>
            <p>
            
                <label for="<?php echo $title_ID; ?>">Title: </label>
                <input type="text" class="widefat" id="<?php echo $title_ID; ?>" name="<?php echo $field_name; ?>" value="<?php echo esc_attr( $title ); ?>">

            </p>
        <?php

    }

    public function update( $new_instance, $old_instance )
    {

        $instance = $old_instance;

        $instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );

        return $instance;

    }

}