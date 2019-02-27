<?php

/**
 * 
 *  Custom Post Type Controller Class
 * 
 */

namespace Inc\Controllers;


class CptController
{

    public function Register_bars()
    {

        add_action( 'init', [ $this, 'register_custom_post_type_bars' ] );

        // Adding Meta Boxes
        add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes_for_bars' ] );
        // Saving Meta Data
        add_action( 'save_post', [ $this, 'save_data' ] );


        // Managing Bars Post Type Table Columns
        add_action( 'manage_bars_posts_columns', [ $this, 'set_custom_columns' ] );
        add_action( 'manage_bars_posts_custom_column', [ $this, 'set_custom_column_data' ], 10, 2 );
        add_filter( 'manage_edit-bars_sortable_columns', [ $this, 'set_custom_column_sortable' ] );

    }

    // Register Post Type Callback Func
    public function register_custom_post_type_bars()
    {

        register_post_type( 'bars', [
            'labels'                => [
                'name'                      => __( 'Bars', 'pubs-bars-plugin' ),
                'singular_name'             => __( 'Bar', 'pubs-bars-plugin' ),
                'plural_name'               => __( 'Bars', 'pubs-bars-plugin' ),
                'menu_name'                 => __( 'Bars', 'pubs-bars-plugin' ),
                'edit_item'                 => __( 'Edit Bar', 'pubs-bars-plugin' ),
                'add_new_item'              => __( 'Edit New Bar', 'pubs-bars-plugin' ),
                'add_new'                   => __( 'Add new', 'pubs-bars-plugin' ),
                'all_items'                 => __( 'All Bars', 'pubs-bars-plugin' ),
                'new_item'                  => __( 'New Bar', 'pubs-bars-plugin' ),
                'view_item'                 => __( 'View Bar', 'pubs-bars-plugin' ),
                'view_items'                => __( 'View Bars', 'pubs-bars-plugin' ),
                'search_items'              => __( 'Search Bars', 'pubs-bars-plugin' ),
                'not_found'                 => __( 'No bars found', 'pubs-bars-plugin' ),
                'not_found_in_trash'        => __( 'No Bars found in trash', 'pubs-bars-plugin' ),
                'parent_item_colon'         => __( 'Parent Page:', 'pubs-bars-plugin' ),
                'all_items'                 => __( 'All Bars', 'pubs-bars-plugin' ),
                'archives'                  => __( 'Bar Archives', 'pubs-bars-plugin' ),
                'attributes'                => __( 'Bar Attributes', 'pubs-bars-plugin' ),
                'insert_into_item'          => __( 'Insert into bar', 'pubs-bars-plugin' ),
                'uploaded_to_this_item'     => __( 'Uploaded to this bar', 'pubs-bars-plugin' ),
                'featured_image'            => __( 'Featured Image.', 'pubs-bars-plugin' ),
                'set_featured_image'        => __( 'Set featured image.', 'pubs-bars-plugin' ),
                'remove_featured_image'     => __( 'Remove featured image.', 'pubs-bars-plugin' ),
                'use_featured_image'        => __( 'Use as featured image.', 'pubs-bars-plugin' ),
                'filter_items_list'         => __( 'Filter Bars\' List', 'pubs-bars-plugin' ),
                'items_list_navigation'     => __( 'Bar List Navigation', 'pubs-bars-plugin' ),
                'items_list'                => __( 'Bars\' List', 'pubs-bars-plugin' ),
                'name_admin_bar'            => __( 'Bar', 'pubs-bars-plugin' ),
            ],
            'public'                => true,
            'has_archive'           => true,
            'show_ui'               => true,
            'show_in_rest'          => true,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'show_in_menu'          => true,
            'publicly_queryable'    => true,
            'exclude_from_search'   => false,
            'hierarchical'          => false,
            // 'capability_type'       => 'bars',
            // 'map_meta_cap'          => true,
            'capability_type'       => 'post',
            'supports'              => [
                'title',
                'editor',
                'author',
                'excerpt',
                'comments',
                'revisions',
                'thumbnail',
                'post-formats',
                // 'page-attributes'
            ],
            'taxonomies'            => [ 'category', 'post_tag' ],
            'menu_position'         => 26,
            'menu_icon'             => 'dashicons-location'

        ] );

    }

    /**
     * 
     *  Meta Box Section
     *  ==================
     * 
     */

    public function add_meta_boxes_for_bars()
    {
        add_meta_box(
            'bars_meta_id',
            __( 'Manage Info', 'pubs-bars-plugin' ),
            [
                $this, 'render_meta_boxes'
            ],
            'bars',
            'advanced',
            'high'
        );
    }

    // Rendering Custom Fields
    public function render_meta_boxes( $post )
    {

        wp_nonce_field( basename( __FILE__ ), 'pbp_manage_info_nonce' );

        $address = get_post_meta( $post->ID, '_pbp_address_key', true );
        $postal_code = get_post_meta( $post->ID, '_pbp_postal_code_key', true );
        $city = get_post_meta( $post->ID, '_pbp_city_key', true );
        $country = get_post_meta( $post->ID, '_pbp_country_key', true );
        $csc = get_post_meta( $post->ID, '_pbp_csc_key', true );
        $latitude = get_post_meta( $post->ID, '_pbp_latitude_key', true );
        $longitude = get_post_meta( $post->ID, '_pbp_longitude_key', true );
        $website = get_post_meta( $post->ID, '_pbp_website_key', true );
        $twitter = get_post_meta( $post->ID, '_pbp_twitter_key', true );
        $facebook = get_post_meta( $post->ID, '_pbp_facebook_key', true );
        $phone_num = get_post_meta( $post->ID, '_pbp_phone_num_key', true );
        $feature = get_post_meta( $post->ID, '_pbp_feature_key', true );


        echo '<p><label for="pbp_address">' . __( 'Address', 'pubs-bars-plugin') . ': </label><input type="text" name="pbp_address" id="pbp_address" value="' . esc_attr( $address ) . '" placeholder="" class="widefat" /></p>';

        echo '<p><label for="pbp_postal_code">' . __( 'Post/Zip Code', 'pubs-bars-plugin') . ': </label><input type="text" name="pbp_postal_code" id="pbp_postal_code" value="' . esc_attr( $postal_code ) . '" placeholder="" class="widefat" /></p>';

        echo '<p><label for="pbp_city">' . __( 'City', 'pubs-bars-plugin') . ': </label><input type="text" name="pbp_city" id="pbp_city" value="' . esc_attr( $city ) . '" placeholder="" class="widefat" /></p>';

        echo '<p><label for="pbp_country">' . __( 'Country', 'pubs-bars-plugin') . ': </label><input type="text" name="pbp_country" id="pbp_country" value="' . esc_attr( $country ) . '" placeholder="" class="widefat" /></p>';

        echo '<p><label for="pbp_csc">' . __( 'CSC', 'pubs-bars-plugin') . ': </label><input type="text" name="pbp_csc" id="pbp_csc" value="' . esc_attr( $csc ) . '" placeholder="" class="widefat" /></p>';
        
        echo '<p><label for="pbp_latitude">' . __( 'Latitude', 'pubs-bars-plugin') . ': </label><input type="text" name="pbp_latitude" id="pbp_latitude" value="' . esc_attr( $latitude ) . '" placeholder="" class="widefat" /></p>';
        
        echo '<p><label for="pbp_longitude">' . __( 'Longitude', 'pubs-bars-plugin') . ': </label><input type="text" name="pbp_longitude" id="pbp_longitude" value="' . esc_attr( $longitude ) . '" placeholder="" size="25" class="widefat" /></p>';

        echo '<p><label for="pbp_website">' . __( 'Website', 'pubs-bars-plugin') . ': </label><input type="url" name="pbp_website" id="pbp_website" value="' . esc_attr( $website ) . '" placeholder="" class="widefat" /></p>';

        echo '<p><label for="pbp_twitter">' . __( 'Twitter', 'pubs-bars-plugin') . ': </label><input type="url" name="pbp_twitter" id="pbp_twitter" value="' . esc_attr( $twitter ) . '" placeholder="" class="widefat" /></p>';

        echo '<p><label for="pbp_facebook">' . __( 'Facebook', 'pubs-bars-plugin') . ': </label><input type="url" name="pbp_facebook" id="pbp_facebook" value="' . esc_attr( $facebook ) . '" placeholder="" class="widefat" /></p>';

        echo '<p><label for="pbp_phone_num">' . __( 'Phone Number', 'pubs-bars-plugin') . ': </label><input type="text" name="pbp_phone_num" id="pbp_phone_num" value="' . esc_attr( $phone_num ) . '" placeholder="" class="widefat" /></p>';

        echo '<p><label for="pbp_feature">' . __( 'Feature', 'pubs-bars-plugin') . ': </label><input type="checkbox" name="pbp_feature" id="pbp_feature" value="1" ' . ( $feature ? 'checked' : '' ) . '  /></p>';

    }

    public function render_meta_boxes_two( $post )
    {

        wp_nonce_field( 'pbp_manage_info_name', 'pbp_manage_info_nonce' );

        $data = get_post_meta( $post->ID, '_pbp_manage_info_meta_box_key', true );

        $address           = @$data[ 'address' ] ?? '';
        $postal_code       = @$data[ 'postal_code' ] ?? '';
        $city              = @$data[ 'city' ] ?? '';
        $country           = @$data[ 'country' ] ?? '';
        $csc               = @$data[ 'csc' ] ?? '';
        $latitude          = @$data[ 'latitude' ] ?? '';
        $longitude         = @$data[ 'longitude' ] ?? '';
        $website           = @$data[ 'website' ] ?? '';
        $twitter           = @$data[ 'twitter' ] ?? '';
        $facebook          = @$data[ 'facebook' ] ?? '';
        $phone_num         = @$data[ 'phone_num' ] ?? '';
        $feature           = @$data[ 'phone_num' ] ?? false;


        echo '<p><label for="pbp_address">' . __( 'Address', 'pubs-bars-plugin') . ': </label><input type="text" name="pbp_address" id="pbp_address" value="' . esc_attr( $address ) . '" placeholder="" class="regular-text" /></p>';

        echo '<p><label for="pbp_postal_code">' . __( 'Post/Zip Code', 'pubs-bars-plugin') . ': </label><input type="text" name="pbp_postal_code" id="pbp_postal_code" value="' . esc_attr( $postal_code ) . '" placeholder="" class="regular-text" /></p>';

        echo '<p><label for="pbp_city">' . __( 'City', 'pubs-bars-plugin') . ': </label><input type="text" name="pbp_city" id="pbp_city" value="' . esc_attr( $city ) . '" placeholder="" class="regular-text" /></p>';

        echo '<p><label for="pbp_country">' . __( 'Country', 'pubs-bars-plugin') . ': </label><input type="text" name="pbp_country" id="pbp_country" value="' . esc_attr( $country ) . '" placeholder="" class="regular-text" /></p>';

        echo '<p><label for="pbp_csc">' . __( 'CSC', 'pubs-bars-plugin') . ': </label><input type="text" name="pbp_csc" id="pbp_csc" value="' . esc_attr( $csc ) . '" placeholder="" class="regular-text" /></p>';
        
        echo '<p><label for="pbp_latitude">' . __( 'Latitude', 'pubs-bars-plugin') . ': </label><input type="text" name="pbp_latitude" id="pbp_latitude" value="' . esc_attr( $latitude ) . '" placeholder="" class="regular-text" /></p>';
        
        echo '<p><label for="pbp_longitude">' . __( 'Longitude', 'pubs-bars-plugin') . ': </label><input type="text" name="pbp_longitude" id="pbp_longitude" value="' . esc_attr( $longitude ) . '" placeholder="" size="25" class="regular-text" /></p>';

        echo '<p><label for="pbp_website">' . __( 'Website', 'pubs-bars-plugin') . ': </label><input type="url" name="pbp_website" id="pbp_website" value="' . esc_attr( $website ) . '" placeholder="" class="regular-text" /></p>';

        echo '<p><label for="pbp_twitter">' . __( 'Twitter', 'pubs-bars-plugin') . ': </label><input type="url" name="pbp_twitter" id="pbp_twitter" value="' . esc_attr( $twitter ) . '" placeholder="" class="regular-text" /></p>';

        echo '<p><label for="pbp_facebook">' . __( 'Facebook', 'pubs-bars-plugin') . ': </label><input type="url" name="pbp_facebook" id="pbp_facebook" value="' . esc_attr( $facebook ) . '" placeholder="" class="regular-text" /></p>';

        echo '<p><label for="pbp_phone_num">' . __( 'Phone Number', 'pubs-bars-plugin') . ': </label><input type="text" name="pbp_phone_num" id="pbp_phone_num" value="' . esc_attr( $phone_num ) . '" placeholder="" class="regular-text" /></p>';

        echo '<p><label for="pbp_feature">' . __( 'Feature', 'pubs-bars-plugin') . ': </label><input type="checkbox" name="pbp_feature" id="pbp_feature" value="1" ' . ( $feature ? 'checked' : '' ) . '  /></p>';

    }

    // Save Meta Data Func
    public function save_data( $post_id )
    {

        $nonce = $_POST[ 'pbp_manage_info_nonce' ];
        $nonce_name = basename( __FILE__ );

        if( ! isset( $nonce ) ) return $post_id;

        if( ! wp_verify_nonce( $nonce, $nonce_name ) ) return $post_id;

        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;

        if( ! current_user_can( 'edit_post', $post_id ) ) return $post_id;

        $data = [
            'address'               => isset( $_POST[ 'pbp_address' ] ) ? sanitize_text_field( $_POST[ 'pbp_address' ] ) : '',
            'postal_code'           => isset( $_POST[ 'pbp_postal_code' ] ) ? sanitize_text_field( $_POST[ 'pbp_postal_code' ] ) : '',
            'city'                  => isset( $_POST[ 'pbp_city' ] ) ? sanitize_text_field( $_POST[ 'pbp_city' ] ) : '',
            'country'               => isset( $_POST[ 'pbp_country' ] ) ? sanitize_text_field( $_POST[ 'pbp_country' ] ) : '',
            'csc'                   => isset( $_POST[ 'pbp_csc' ] ) ? sanitize_text_field( $_POST[ 'pbp_csc' ] ) : '',
            'latitude'              => isset( $_POST[ 'pbp_latitude' ] ) ? sanitize_text_field( $_POST[ 'pbp_latitude' ] ) : '',
            'longitude'             => isset( $_POST[ 'pbp_longitude' ] ) ? sanitize_text_field( $_POST[ 'pbp_longitude' ] ) : '',
            'website'               => isset( $_POST[ 'pbp_website' ] ) ? sanitize_text_field( $_POST[ 'pbp_website' ] ) : '',
            'twitter'               => isset( $_POST[ 'pbp_twitter' ] ) ? sanitize_text_field( $_POST[ 'pbp_twitter' ] ) : '',
            'facebook'              => isset( $_POST[ 'pbp_facebook' ] ) ? sanitize_text_field( $_POST[ 'pbp_facebook' ] ) : '',
            'phone_num'             => isset( $_POST[ 'pbp_phone_num' ] ) ? sanitize_text_field( $_POST[ 'pbp_phone_num' ] ) : '',
            'feature'               => isset( $_POST[ 'pbp_feature' ] ) ? 1 : 0,
        ];

        if ( isset( $_REQUEST['pbp_address'] ) ) {
            update_post_meta( $post_id, '_pbp_address_key', $data[ 'address' ] );
        }

        if ( isset( $_REQUEST['pbp_postal_code'] ) ) {
            update_post_meta( $post_id, '_pbp_postal_code_key', $data[ 'postal_code' ] );
        }

        if ( isset( $_REQUEST['pbp_city'] ) ) {
            update_post_meta( $post_id, '_pbp_city_key', $data[ 'city' ] );
        }

        if ( isset( $_REQUEST['pbp_country'] ) ) {
            update_post_meta( $post_id, '_pbp_country_key', $data[ 'country' ] );
        }

        if ( isset( $_REQUEST['pbp_csc'] ) ) {
            update_post_meta( $post_id, '_pbp_csc_key', $data[ 'csc' ] );
        }

        if ( isset( $_REQUEST['pbp_latitude'] ) ) {
            update_post_meta( $post_id, '_pbp_latitude_key', $data[ 'latitude' ] );
        }

        if ( isset( $_REQUEST['pbp_longitude'] ) ) {
            update_post_meta( $post_id, '_pbp_longitude_key', $data[ 'longitude' ] );
        }

        if ( isset( $_REQUEST['pbp_website'] ) ) {
            update_post_meta( $post_id, '_pbp_website_key', $data[ 'website' ] );
        }

        if ( isset( $_REQUEST['pbp_twitter'] ) ) {
            update_post_meta( $post_id, '_pbp_twitter_key', $data[ 'twitter' ] );
        }

        if ( isset( $_REQUEST['pbp_facebook'] ) ) {
            update_post_meta( $post_id, '_pbp_facebook_key', $data[ 'facebook' ] );
        }

        if ( isset( $_REQUEST['pbp_phone_num'] ) ) {
            update_post_meta( $post_id, '_pbp_phone_num_key', $data[ 'phone_num' ] );
        }

        if ( isset( $_REQUEST['pbp_feature'] ) ) {
            update_post_meta( $post_id, '_pbp_feature_key', $data[ 'feature' ] );
        }

    }

    public function save_data_two( $post_id )
    {

        $nonce = $_POST[ 'pbp_manage_info_nonce' ];
        $nonce_name = 'pbp_manage_info_name';

        if( ! isset( $nonce ) ) return $post_id;

        if( ! wp_verify_nonce( $nonce, $nonce_name ) ) return $post_id;

        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;

        if( ! current_user_can( 'edit_post', $post_id ) ) return $post_id;

        // Validations
        // if( isset( $_POST[ 'pbp_phone_num' ] ) ){

        //     if ( preg_match( "/^[0-9\-]|[\+0-9]|[0-9\s]|[0-9()]*$/", $_POST['pbp_phone_num'] )) {
        //         preg_match( "/^[0-9\-]|[\+0-9]|[0-9\s]|[0-9()]*$/", $this->phone_num, $_POST['pbp_phone_num'] );
        //     }
        //     var_dump($this->phone_num)
        // }

        $data = [
            'address'               => isset( $_POST[ 'pbp_address' ] ) ? sanitize_text_field( $_POST[ 'pbp_address' ] ) : '',
            'postal_code'           => isset( $_POST[ 'pbp_postal_code' ] ) ? sanitize_text_field( $_POST[ 'pbp_postal_code' ] ) : '',
            'city'                  => isset( $_POST[ 'pbp_city' ] ) ? sanitize_text_field( $_POST[ 'pbp_city' ] ) : '',
            'country'               => isset( $_POST[ 'pbp_country' ] ) ? sanitize_text_field( $_POST[ 'pbp_country' ] ) : '',
            'csc'                   => isset( $_POST[ 'pbp_csc' ] ) ? sanitize_text_field( $_POST[ 'pbp_csc' ] ) : '',
            'latitude'              => isset( $_POST[ 'pbp_latitude' ] ) ? sanitize_text_field( $_POST[ 'pbp_latitude' ] ) : '',
            'longitude'             => isset( $_POST[ 'pbp_longitude' ] ) ? sanitize_text_field( $_POST[ 'pbp_longitude' ] ) : '',
            'website'               => isset( $_POST[ 'pbp_website' ] ) ? sanitize_text_field( $_POST[ 'pbp_website' ] ) : '',
            'twitter'               => isset( $_POST[ 'pbp_twitter' ] ) ? sanitize_text_field( $_POST[ 'pbp_twitter' ] ) : '',
            'facebook'              => isset( $_POST[ 'pbp_facebook' ] ) ? sanitize_text_field( $_POST[ 'pbp_facebook' ] ) : '',
            'phone_num'             => isset( $_POST[ 'pbp_phone_num' ] ) ? sanitize_text_field( $_POST[ 'pbp_phone_num' ] ) : '',
            'feature'               => isset( $_POST[ 'pbp_feature' ] ) ? 1 : 0,
        ];

        update_post_meta( $post_id, '_pbp_manage_info_meta_box_key', $data );

    }


    /**
     * Setting Custom Columns
     */
    public function set_custom_columns( $columns )
    {

        $name       = $columns[ 'title' ];
        $date       = $columns[ 'date' ];
        $author     = $columns[ 'author' ];
        $categories = $columns[ 'categories' ];
        $tags       = $columns[ 'tags' ];
        $comments   = $columns[ 'comments' ];

        unset( $columns[ 'title' ], $columns[ 'date' ], $columns[ 'author' ], $columns[ 'categories' ], $columns[ 'tags' ], $columns[ 'comments' ] );

        $columns[ 'title' ]     = $name;
        $columns[ 'city' ]      = __( 'City', 'pubs-bars-plugin' );
        $columns[ 'country' ]   = __( 'Country', 'pubs-bars-plugin' );
        $columns[ 'csc' ]       = __( 'CSC', 'pubs-bars-plugin' );
        $columns[ 'address' ]   = __( 'Address', 'pubs-bars-plugin' );
        $columns[ 'feature' ]   = __( 'Featured', 'pubs-bars-plugin' );
        $columns[ 'date' ]      = $date;

        return $columns;

    }

    public function set_custom_column_data( $column, $post_id )
    {

        $address = get_post_meta( $post_id, '_pbp_address_key', true );
        // $postal_code = get_post_meta( $post_id, '_pbp_postal_code_key', true );
        $city = get_post_meta( $post_id, '_pbp_city_key', true );
        $country = get_post_meta( $post_id, '_pbp_country_key', true );
        $csc = get_post_meta( $post_id, '_pbp_csc_key', true );
        // $latitude = get_post_meta( $post_id, '_pbp_latitude_key', true );
        // $longitude = get_post_meta( $post_id, '_pbp_longitude_key', true );
        // $website = get_post_meta( $post_id, '_pbp_website_key', true );
        // $twitter = get_post_meta( $post_id, '_pbp_twitter_key', true );
        // $facebook = get_post_meta( $post_id, '_pbp_facebook_key', true );
        // $phone_num = get_post_meta( $post_id, '_pbp_phone_num_key', true );
        $feature = get_post_meta( $post_id, '_pbp_feature_key', true );

        $address           = isset( $address ) ? $address : '';
        // $postal_code       = @$data[ 'postal_code' ] ?? '';
        $city              = isset( $city ) ? $city : '';
        $country           = isset( $country ) ? $country : '';
        $csc               = isset( $csc ) ? $csc : '';
        // $phone_num         = @$data[ 'phone_num' ] ?? '';
        $featured          = isset( $feature ) ? __( 'YES', 'pubs-bars-plugin' ) : __( 'NO', 'pubs-bars-plugin' );

        switch ($column) {
            case 'city':
                echo '<strong>' .$city . '</strong>';
                break;

            case 'country':
                echo '<strong>' .$country . '</strong>';
                break;

            case 'csc':
                echo '<strong>' .$csc . '</strong>';
                break;

            case 'address':
                echo '<strong>' .$address . '</strong>';
                break;
            

            case 'feature':
                echo '<strong>' .$featured . '</strong>';
                break;
            
            default:
                # code...
                break;
        }

    }

    public function set_custom_column_sortable( $columns )
    {

        $columns[ 'city' ] = 'city';
        
        $columns[ 'country' ] = 'country';

        $columns[ 'csc' ] = 'csc';

        $columns[ 'address' ] = 'address';

        return $columns;

    }

}