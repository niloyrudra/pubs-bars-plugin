<?php

/**
 * 
 *  Database Controller Class
 * 
 */

namespace Inc\Controllers;


class DatabaseController
{

    public $db;

    public function __construct()
    {
        global $wpdb;

        $this->db = $wpdb;
        
    }


    // Function for Inserting Data into Database Table From Admin Dashboard Form
    public function insert_data()
    {
        
        // if( ! current_user_can( 'edit_others_posts' ) ) {
        //     return __( 'You are not authorized to insert any entry here!', 'pubs-bars-plugin' );
        // }

        $table = $this->db->prefix .'bars_zone';
        
        if( isset( $_POST[ 'pbp_submit' ] ) ) {
            $query = "INSERT INTO $table(name, address, postal_code, city, country, csc, description, latitude, longitude, pic, website, twitter, facebook, featured) VALUES(%s, %s, %s, %s, %s, %s, %s, %f, %f, %s, %s, %s, %s, %d)";
            $name = $_POST[ 'pbp_name' ];
            $address = $_POST[ 'pbp_address' ];
            $postal_code = $_POST[ 'pbp_postal_code' ];
            $city = $_POST[ 'pbp_city' ];
            $country = $_POST[ 'pbp_country' ];
            $csc = $_POST[ 'pbp_csc' ];
            $description = $_POST[ 'pbp_description' ];
            $latitude = $_POST[ 'pbp_latitude' ];
            $longitude = $_POST['pbp_longitude'];
            $pic = $_POST[ 'pbp_pic' ];
            $website = $_POST[ 'pbp_website' ];
            $twitter = $_POST[ 'pbp_twitter' ];
            $facebook = $_POST[ 'pbp_facebook' ];
            $featured  = $_POST[ 'pbp_featured' ];
            
            $prepare_query = $this->db->prepare(
                $query,
                $name,
                $address,
                $postal_code,
                $city,
                $country,
                $csc,
                $description,
                $latitude,
                $longitude,
                $pic,
                $website,
                $twitter,
                $facebook,
                $featured
            );
            
            $this->db->query( $prepare_query );
        }
        
    }
    
    // Function for Updating Database Table Entry
    public function update_entries()
    {

        // if( ! current_user_can( 'edit_others_posts' ) ) {
        //     return __( 'You are not authorized to edit any entry here!', 'pubs-bars-plugin' );
        // }

        if( ! isset( $_POST[ 'pbp_update_entry' ] ) ) {
            return __( 'Update Button is not set.', 'pubs-bars-plugin' );
        }

        $table = $this->db->prefix .'bars_zone';

        $entry_id = ( @$_POST[ 'pbp_id' ] ?? null );
        
        $name = $_POST[ 'pbp_name' ];
        $address = $_POST[ 'pbp_address' ];
        $postal_code = $_POST[ 'pbp_postal_code' ];
        $city = $_POST[ 'pbp_city' ];
        $country = $_POST[ 'pbp_country' ];
        $csc = $_POST[ 'pbp_csc' ];
        $description = $_POST[ 'pbp_description' ];
        $latitude = $_POST[ 'pbp_latitude' ];
        $longitude = $_POST['pbp_longitude'];
        $pic = $_POST[ 'pbp_pic' ];
        $website = $_POST[ 'pbp_website' ];
        $twitter = $_POST[ 'pbp_twitter' ];
        $facebook = $_POST[ 'pbp_facebook' ];
        $featured  = $_POST[ 'pbp_featured' ];
        
        $this->db->update(
            $table,
            [
                'name'          => $name,
                'address'       => $address,
                'postal_code'   => $postal_code,
                'city'          => $city,
                'country'       => $country,
                'csc'           => $csc,
                'description'   => $description,
                'latitude'      => $latitude,
                'longitude'     => $longitude,
                'pic'           => $pic,
                'website'       => $website,
                'twitter'       => $twitter,
                'facebook'      => $facebook,
                'featured'      => $featured
            ],
            [ 
                'id'  => $entry_id
            ],
            [
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%f',
                '%f',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d'
            ],
            [
                '%d'
            ]
        );
        
    }
       
        
    // Function for Updating Database Table Entry
    public function deleting_entries()
    {
        
        // if( ! current_user_can( 'edit_others_posts' ) ) {
        //     return __( 'You are not authorized to edit any entry here!', 'pubs-bars-plugin' );
        // }
        
        if( ! isset( $_POST[ 'pbp_remove_entry' ] ) ) {
            return;
        }
            
        $table = $this->db->prefix .'bars_zone';
        $entry_id = ( @$_POST[ 'pbp_remove_entry' ] ?? null );
            
        // Method ONE
        $this->db->delete(
            $table,
            [ 
                'id'  => $entry_id
            ],
            [
                '%d'
            ]
        );
            
            // Method TWO
            // $this->db->query(
                //     $this->db->prepare(
                    //         "DELETE FROM %s
                    //         WHERE id = %d",
                    //         $table,
                    //         $entry_id
                    //     )
                    // );
                    
    }



    public function display_results()
    {
        if( !isset( $_GET[ 'pbp_search_field' ] ) ) {
            return;
        }

        global $wpdb;
        
        $search_query = esc_sql($_GET[ 'pbp_search_field' ]);
        $search_query = "%$search_query%";

        $querystr = "SELECT wp_posts.*, wp_postmeta.*
        FROM wp_posts
        RIGHT JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id
        AND wp_postmeta.meta_key = '_pbp_manage_info_meta_box_key'
        WHERE wp_posts.post_type = 'bars'
        order by wp_posts.ID asc";

        $metadataResults = $wpdb->get_results( $querystr, OBJECT );
        
        $querystrTwo = "SELECT *
        FROM wp_posts
        INNER JOIN wp_postmeta
        ON (wp_posts.ID = wp_postmeta.post_id )
        WHERE wp_posts.post_type   = 'bars'
        AND   wp_posts.post_status = 'publish'
        AND   wp_postmeta.meta_key = '_pbp_manage_info_meta_box_key'
        AND   wp_postmeta.country LIKE '$search_query'
        -- AND ( m1.meta_key = 'date' AND m1.meta_value > '2010-12-05 00:00:00' )
        -- AND ( m1.meta_key = 'date' AND m1.meta_value < '2017-01-01 00:00:00' )
        -- AND ( m2.meta_key = 'some_other_meta_value' AND m2.meta_value != '' )
        -- GROUP BY wp_posts.ID
        -- ORDER BY wp_posts.post_date
        -- DESC
        ";

        $results = $wpdb->get_results( $querystrTwo, OBJECT );

        if ( ! $results ) {
            $wpdb->print_error();
        }
        else {
            foreach($results as $result){
                echo '<div>' . $result->post_title . '</div><hr>';
            }
        }

    }
                
}