<?php

/**
 *  Template Name: Bars' Location Tracker Template
 */

get_header();

if( isset( $_GET[ 'addressInput' ] ) && $_GET[ 'addressInput' ] !== '' ) {

    $location = sanitize_text_field( $_GET[ 'addressInput' ] );

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
            ]
        ]
    ];

    $bars_coordinators = new \WP_Query( $args );

    if( $bars_coordinators->have_posts() ):

        while( $bars_coordinators->have_posts() ):
            $bars_coordinators->the_post();
    
            $name = esc_html( get_the_title() );
            $link = esc_url( get_the_permalink() );
            $address = get_post_meta( get_the_id(), '_pbp_address_key', true );
            $lat = get_post_meta( get_the_id(), '_pbp_latitude_key', true );
            $lng = get_post_meta( get_the_id(), '_pbp_longitude_key', true );
    
            $bar_collections[] = [
                'name'      => $name,
                'link'      => $link,
                'address'   => $address,
                'lat'       => $lat,
                'lng'       => $lng
            ];
    
        endwhile;
    
    endif;

    $collections = json_encode( $bar_collections );

}

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
            
            <div id="map" class="pbp-map"></div>
            
        </div>

        <br><hr><br>
            
        <div id="pbp-bar-collections"><?php echo ( $bar_collections ? $collections : '' ); ?></div>


    </div> <!-- .pbp-container -->

</div> <!-- . pbp-wrapper -->


<?php
get_footer();