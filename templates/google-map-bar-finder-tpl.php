<?php

/**
 *  Template Name: Bars' Location Tracker Template
 */

get_header();

if( function_exists( 'pbp_search_results_by_distance' ) && ! empty( pbp_search_results_by_distance() ) ) {

    $results = pbp_search_results_by_distance();

}
    
?>

<div class="pbp-wrapper">

    <div class="pbp-container">
    
        <div class="pbp-live-search--container">

            <h1>Search For Pubs' or Bars' Location:</h1>

            <div class="pbp-search-location-form">

                <form action="" method="get">

                    <label for="raddressInput">Search location:</label>
                    <input type="text" id="addressInput" size="15"/>

                    <label for="radiusSelect">Radius:</label>
                    <select id="radiusSelect" name="radiusSelect" label="Radius">
                        <option value="50" selected>50 kms</option>
                        <option value="30">30 kms</option>
                        <option value="20">20 kms</option>
                        <option value="10">10 kms</option>
                    </select>

                    <input type="button" id="searchButton" value="Search" class="btn btn-primary" />

                </form>

            </div>
            <div><select id="locationSelect" style="width: 10%; visibility: hidden"></select></div>
            <div id="map" style="width: 100%; height: 400px"></div>
            
        </div>

        <br><hr><br>

        <?php var_dump($results); ?>

    </div> <!-- .pbp-container -->

</div> <!-- . pbp-wrapper -->


<?php
get_footer();