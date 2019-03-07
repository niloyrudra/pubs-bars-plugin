<?php

/**
 *  ===================
 *      Settings API
 *  ===================
 * 
 *  @package pubs-bars-plugin
 *  @version 1.0.0
 * 
 */


namespace Inc\Api;


class SettingsApi
{

    public function register()
    {
        add_action( 'admin_init', array( $this, 'register_settings_group' ) );
    }

    public function register_settings_group()
    {

        register_setting( 'pbp_settings_group', 'pbp_option' );

        add_settings_section( 'pbp_settings_section', __( 'Pubs & Bars Data Entry Section', 'pubs-bars-plugin' ), array( $this, 'pbp_settings_section_callback' ), 'pubs_bars_custom_manager' );

        // Fields
        add_settings_field( 'pbp_name', __( 'Pub\'s/Bar\'s Name', 'pubs-bars-plugin' ), array( $this, 'textField' ), 'pubs_bars_custom_manager', 'pbp_settings_section', array(
            'option_name'   => 'pbp_option',
            'label_for'     => 'pbp_name',
            'description'   => '',
            'placeholder'   => 'Write down the Name of new Pub or Bar'
        ) );
        add_settings_field( 'pbp_address', __( 'Address', 'pubs-bars-plugin' ), array( $this, 'textField' ), 'pubs_bars_custom_manager', 'pbp_settings_section', array(
            'option_name'   => 'pbp_option',
            'label_for'     => 'pbp_addres',
            'description'   => '',
            'placeholder'   => 'Write down the Address of new Pub or Bar'
        ) );
        add_settings_field( 'pbp_postal_code', __( 'Postal-Code/Zip-Code', 'pubs-bars-plugin' ), array( $this, 'textField' ), 'pubs_bars_custom_manager', 'pbp_settings_section', array(
            'option_name'   => 'pbp_option',
            'label_for'     => 'pbp_postal_code',
            'description'   => '',
            'placeholder'   => 'Write down the Postal Code of new Pub or Bar'
        ) );

        add_settings_field( 'pbp_city', __( 'City', 'pubs-bars-plugin' ), array( $this, 'textField' ), 'pubs_bars_custom_manager', 'pbp_settings_section', array(
            'option_name'   => 'pbp_option',
            'label_for'     => 'pbp_city',
            'description'   => '',
            'placeholder'   => 'Write down the Name of the City'
        ) );

        add_settings_field( 'pbp_country', __( 'Country', 'pubs-bars-plugin' ), array( $this, 'textField' ), 'pubs_bars_custom_manager', 'pbp_settings_section', array(
            'option_name'   => 'pbp_option',
            'label_for'     => 'pbp_country',
            'description'   => '',
            'placeholder'   => 'Write down the Name of the Country.'
        ) );

        add_settings_field( 'pbp_csc', __( 'CSC', 'pubs-bars-plugin' ), array( $this, 'textField' ), 'pubs_bars_custom_manager', 'pbp_settings_section', array(
            'option_name'   => 'pbp_option',
            'label_for'     => 'pbp_csc',
            'description'   => '',
            'placeholder'   => 'Write down the CSC.'
        ) );

        add_settings_field( 'pbp_description', __( 'Give a Description', 'pubs-bars-plugin' ), array( $this, 'textField' ), 'pubs_bars_custom_manager', 'pbp_settings_section', array(
            'option_name'   => 'pbp_option',
            'label_for'     => 'pbp_description',
            'description'   => '',
            'placeholder'   => 'Describe the Pub or the Bar.'
        ) );

        add_settings_field( 'pbp_latitude', __( 'Latitude', 'pubs-bars-plugin' ), array( $this, 'textField' ), 'pubs_bars_custom_manager', 'pbp_settings_section', array(
            'option_name'   => 'pbp_option',
            'label_for'     => 'pbp_latitude',
            'description'   => '',
            'placeholder'   => 'The Latitude of the Pub or the Bar.'
        ) );

        add_settings_field( 'pbp_longitude', __( 'Longitude', 'pubs-bars-plugin' ), array( $this, 'textField' ), 'pubs_bars_custom_manager', 'pbp_settings_section', array(
            'option_name'   => 'pbp_option',
            'label_for'     => 'pbp_longitude',
            'description'   => '',
            'placeholder'   => 'The Longitude of the Pub or the Bar.'
        ) );

        add_settings_field( 'pbp_pic', __( 'Insert a Picture', 'pubs-bars-plugin' ), array( $this, 'mediaUpload' ), 'pubs_bars_custom_manager', 'pbp_settings_section', array(
            'option_name'   => 'pbp_option',
            'label_for'     => 'pbp_pic',
            'description'   => '',
            'placeholder'   => 'Give a Picture of the Pub or the Bar.'
        ) );

        add_settings_field( 'pbp_website', __( 'Website', 'pubs-bars-plugin' ), array( $this, 'textField' ), 'pubs_bars_custom_manager', 'pbp_settings_section', array(
            'option_name'   => 'pbp_option',
            'label_for'     => 'pbp_website',
            'description'   => '',
            'placeholder'   => 'Write down the Website Address.'
        ) );

        add_settings_field( 'pbp_twitter', __( 'Twitter', 'pubs-bars-plugin' ), array( $this, 'textField' ), 'pubs_bars_custom_manager', 'pbp_settings_section', array(
            'option_name'   => 'pbp_option',
            'label_for'     => 'pbp_twitter',
            'description'   => '',
            'placeholder'   => 'Write down the Twitter Handler.'
        ) );

        add_settings_field( 'pbp_facebook', __( 'Facebook', 'pubs-bars-plugin' ), array( $this, 'textField' ), 'pubs_bars_custom_manager', 'pbp_settings_section', array(
            'option_name'   => 'pbp_option',
            'label_for'     => 'pbp_facebook',
            'description'   => '',
            'placeholder'   => 'Write down the Facebook Handler.'
        ) );

        add_settings_field( 'pbp_featured', __( 'Featured', 'pubs-bars-plugin' ), array( $this, 'checkBox' ), 'pubs_bars_custom_manager', 'pbp_settings_section', array(
            'option_name'   => 'pbp_option',
            'label_for'     => 'pbp_featured',
            'description'   => '',
            'placeholder'   => 'Choose whether this is featured or not!'
        ) );

    }


    public function pbp_settings_section_callback()
    {
        echo '<p class="desription">Populate these following fields to entry new Pubs or Bars into your Database.</h2>';
    }

    public function textField( $args )
    {

        $name = $args[ 'label_for' ];
        $option_name = $args[ 'option_name' ];
        $desc = $args[ 'description' ];
        $placeholder = $args[ 'placeholder' ];

        $input = get_option( $option_name );

        $value = $input[ $name ];

        echo '<label for="' . $option_name . '[' . $name . ']"></label><input class="regular-text" type="text" name="' . $option_name . '[' . $name . ']" id="' . $option_name . '[' . $name . ']" value="' . esc_attr( $value ) . '" placeholder="' . $placeholder . '" />';

    }

    public function checkBox( $args )
    {

        $name = $args[ 'label_for' ];
        $option_name = $args[ 'option_name' ];
        $desc = $args[ 'description' ];

        $checkBox = get_option( $option_name );

        $checked = $checkBox[ $name ];

        echo '<label for="' . $option_name . '[' . $name . ']"></label><input type="checkbox" name="' . $option_name . '[' . $name . ']" id="' . $option_name . '[' . $name . ']" value="1" ' . ( @$checked == 1 ? 'checked' : '' ) . ' />';

    }

    public function mediaUpload( $args )
    {

        $name = $args[ 'label_for' ];
        $option_name = $args[ 'option_name' ];

        $input = get_option( $option_name );

        $picture = $input[ $name ];

        var_dump($picture);

        if( empty( $picture ) ) {
    
            echo '<input type="button" class="button button-secondary" value="Upload Profile Picture" id="upload-button" /></span><input type="hidden" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="" />';
    
        } else {
    
            echo '<input type="button" class="button button-secondary" value="Replace Profile Picture" id="upload-button" /><input type="hidden" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="'. $picture .'" /> <input type="button" class="button button-secondary" value="Remove" id="remove-button" />';
    
        }

    }

}