<?php

/**
 *  Template Name: Bars' Location Tracker Template
 */

get_header();

// if( function_exists( 'pbp_search_results_by_distance' ) && ! empty( pbp_search_results_by_distance() ) ) {

//     $results = pbp_search_results_by_distance();

// }
global $wpdb;
$location = esc_sql( $_GET[ 'addressInput' ] );
$query = "$location%";
// $results = $wpdb->get_results( "SELECT wp_postmeta.meta_id,wp_postmeta.post_id FROM wp_postmeta WHERE wp_postmeta.meta_key = '_pbp_city_key' AND wp_postmeta.meta_value LIKE '$query'" );
// $results = $wpdb->get_results( "SELECT * FROM wp_posts WHERE wp_posts.post_type = 'bars' AND wp_posts.post_title LIKE '$query'", OBJECT );

/** */
$args = [
    'post_type' => 'bars',
    'posts_per_page' => -1,
    'meta_query'    => [
        'relation'  => 'OR',
        [
            'key'     => '_pbp_city_key',
            'value'   => $location,
            'compare' => 'LIKE',
        ],
        [
            'key'     => '_pbp_country_key', 
            'value'   => $location,
            'compare' => 'LIKE',
        ],
        // array(
        //     'key'     => '_pbp_postal_code_key', // assumed your meta_key is 'car_model'
        //     'value'   => sanitize_text_field( $_postal_code ),
        //     'compare' => 'LIKE', // finds models that matches 'model' from the select field
        // ),
        // array(
        //     'key'     => '_pbp_csc_key', // assumed your meta_key is 'car_model'
        //     'value'   => sanitize_text_field( $_csc ),
        //     'compare' => 'LIKE', // finds models that matches 'model' from the select field
        // )
    ]
];

$bars_coordinators = new \WP_Query( $args );
?>

<div class="pbp-wrapper">

    <div class="pbp-container">
    
        <div class="pbp-live-search--container">

            <h1>Search For Pubs' or Bars' Location:</h1>

            <div class="pbp-search-location-form">

                <form action="" method="get">

                    <label for="raddressInput">Search location:</label>
                    <input type="text" id="addressInput" name="addressInput" size="15"/>

                    <label for="radiusSelect">Radius:</label>
                    <select id="radiusSelect" name="radiusSelect" label="Radius">
                        <option value="50" selected>50 kms</option>
                        <option value="30">30 kms</option>
                        <option value="20">20 kms</option>
                        <option value="10">10 kms</option>
                    </select>

                    <svg id="pbp-search--icon">
                        <path style="line-height:normal;text-indent:0;text-align:middle;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000;text-transform:none;block-progression:tb;isolation:auto;mix-blend-mode:normal" d="M 13 3 C 7.4889971 3 3 7.4889971 3 13 C 3 18.511003 7.4889971 23 13 23 C 15.396508 23 17.597385 22.148986 19.322266 20.736328 L 25.292969 26.707031 A 1.0001 1.0001 0 1 0 26.707031 25.292969 L 20.736328 19.322266 C 22.148986 17.597385 23 15.396508 23 13 C 23 7.4889971 18.511003 3 13 3 z M 13 5 C 17.430123 5 21 8.5698774 21 13 C 21 17.430123 17.430123 21 13 21 C 8.5698774 21 5 17.430123 5 13 C 5 8.5698774 8.5698774 5 13 5 z" font-weight="400" font-family="sans-serif" white-space="normal" overflow="visible"/>
                        <input type="submit" id="searchButton" value="Search" class="btn btn-primary" />
                    </svg>

                </form>

            </div>

            <div><select id="locationSelect" style="width: 10%; visibility: hidden"></select></div>
            
            <div id="map" style="width: 100%; height: 400px"></div>
            
        </div>

        <br><hr><br>

        <?php 


            if( $bars_coordinators->have_posts() ):
                echo '<div style="position:relative;display:grid;grid-template-columns:repeat(3,1fr);grid-gap:1em;">';
                while( $bars_coordinators->have_posts() ):
                    $bars_coordinators->the_post();

                    $lat = get_post_meta( get_the_id(), '_pbp_latitude_key', true );
                    $lng = get_post_meta( get_the_id(), '_pbp_longitude_key', true );

                    echo '<section style="border:1px solid #e1e1e1;"><h2 class="entry-title">' . get_the_title() . '</h2><p>Latitude: ' . $lat . '</p><p>Longitude: ' . $lng . '</p></section>';

                endwhile;
                echo '</div>';
            endif;
            

        ?>

    </div> <!-- .pbp-container -->

</div> <!-- . pbp-wrapper -->


<?php
get_footer();