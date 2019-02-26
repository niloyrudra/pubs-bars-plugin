<?php

/**
 * 
 *  Template Name: Advanced Search Form Template
 * 
 */

get_header();
?>

<div class="pbp-wrapper">

    <div class="pbp-container">

        <div class="pbp-content">

            <div class="pbp-site-content"></div>

            <div class="pbp-sidebar">

                <form method="get" id="advanced-searchform" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">

                    <h3><?php _e( 'Advanced Search', 'pubs-bars-plugin' ); ?></h3>

                    <!-- PASSING THIS TO TRIGGER THE ADVANCED SEARCH RESULT PAGE FROM functions.php -->
                    <input type="hidden" name="search" value="advanced">

                    <label for="s" class=""><?php _e( 'Search By Name: ', 'pubs-bars-plugin' ); ?></label>
                    <input type="text" value="" placeholder="<?php _e( 'Type the Bar Name', 'pubs-bars-plugin' ); ?>" name="s" id="name" />

                    <label for="pbp_city" class=""><?php _e( 'Search By City Name: ', 'pubs-bars-plugin' ); ?></label>
                    <input type="text" name="pbp_city" id="pbp_city" value="" class="search-form" placeholder="<?php _e( 'Type the Bar Name', 'pubs-bars-plugin' ); ?>">

                    <label for="pbp_country" class=""><?php _e( 'Search By City Name: ', 'pubs-bars-plugin' ); ?></label>
                    <input type="text" name="pbp_country" id="pbp_country" value="" class="search-form" placeholder="<?php _e( 'Type the Country Name', 'pubs-bars-plugin' ); ?>">

                    <label for="pbp_csc" class=""><?php _e( 'Search By CSC: ', 'pubs-bars-plugin' ); ?></label>
                    <input type="text" name="pbp_csc" id="pbp_csc" value="" class="search-form" placeholder="<?php _e( 'Type the CSC Name', 'pubs-bars-plugin' ); ?>">

                    <label for="pbp_postal_code" class=""><?php _e( 'Search By Post Code: ', 'pubs-bars-plugin' ); ?></label>
                    <input type="text" name="pbp_postal_code" id="pbp_postal_code" value="" class="search-form" placeholder="<?php _e( 'Type the Post Code', 'pubs-bars-plugin' ); ?>">

                    <input type="submit" id="searchsubmit" value="Search" />

                </form>
                
            </div>

        </div> <!-- .pbp-content -->

    </div>

</div>

<?php
get_footer();