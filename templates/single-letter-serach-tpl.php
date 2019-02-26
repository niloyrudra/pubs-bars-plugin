<?php

/**
 *  Template Name: Single Letter Search Template
 */

get_header();
             
global $wpdb;

$table = $wpdb->prefix . 'bars_zone';

$search_query = esc_sql( $_GET[ 'pbp_search_field' ] );
$query = "%$search_query%";

$results = $wpdb->get_results("SELECT * FROM {$table} WHERE city LIKE '$query' OR country LIKE '$query' OR name LIKE '$query' OR address LIKE '$query' OR postal_code LIKE '$query' OR csc LIKE '$query' OR latitude LIKE '$query' OR longitude LIKE '$query'");


?>


<div class="pbp-wrapper">

    <div class="pbp-container">
    
        <h2>Single Letter Search:</h2>

        <div class="pbp-search-form">
            <h3>Search For Pubs/Bars</h3>
            
            <form method="get">
                <input type="search" name="pbp_search_field" id="pbp_search_field" placeholder="<?php echo ( $search_query !== null ?? 'Search for based on name or city or country' ); ?>" value="" />
                <svg id="pbp-search--icon">
                    <path style="line-height:normal;text-indent:0;text-align:middle;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000;text-transform:none;block-progression:tb;isolation:auto;mix-blend-mode:normal" d="M 13 3 C 7.4889971 3 3 7.4889971 3 13 C 3 18.511003 7.4889971 23 13 23 C 15.396508 23 17.597385 22.148986 19.322266 20.736328 L 25.292969 26.707031 A 1.0001 1.0001 0 1 0 26.707031 25.292969 L 20.736328 19.322266 C 22.148986 17.597385 23 15.396508 23 13 C 23 7.4889971 18.511003 3 13 3 z M 13 5 C 17.430123 5 21 8.5698774 21 13 C 21 17.430123 17.430123 21 13 21 C 8.5698774 21 5 17.430123 5 13 C 5 8.5698774 8.5698774 5 13 5 z" font-weight="400" font-family="sans-serif" white-space="normal" overflow="visible"/>
                </svg>
                <input type="submit" value="" name="pbp_search_btn" id="pbp_search_btn" />
            </form>
    
        </div>

        <?php if( isset( $_GET[ 'pbp_search_field' ] ) && isset( $_GET[ 'pbp_search_btn' ] ) && $_GET[ 'pbp_search_field' ] !== '' ): ?>

            <div class="pbp-search-result-container">

                    <?php

                        if( count( $results ) === 1 ){
                
                            echo '<div class="pbp-card"><img src="' . $results[0]->pic . '" alt="" /><div class="pbp-card-content"><h3><a href="' . $results[0]->website . '" target="_blank" role="bookmark">' . $results[0]->name . '</a></h3><p>' . $results[0]->city . ', ' . $results[0]->country . '</p><p>' . wp_trim_words( $results[0]->description, 18, '<a href="' . $results[0]->website . '" target="_blank" role="bookmark">(...)</a>' ) . '</p></div></div>';
                
                        } elseif( count( $results ) > 1 ){
                
                            foreach ( $results as $result ) {
                                echo '<div class="pbp-card"><img src="' . $result->pic . '" alt="" /><div class="pbp-card-content"><h3><a href="' . $result->website . '" target="_blank" role="bookmark">' . $result->name . '</a></h3><p>' . $result->city . ', ' . $result->country . '</p><p>' . wp_trim_words( $result->description, 18, '<a href="' . $result->website . '" target="_blank" role="bookmark">(...)</a>' ) . '</p></div></div>';
                            
                            }
                
                        }else{
                
                            return 'No Result Found!';
                
                        }
            

                    ?>

            </div><!-- .pbp-search-result-container -->

        <?php endif; ?>



    </div><!-- .container -->

</div><!-- .wrapper -->

<?php
get_footer();