<?php

/**
 * 
 *  Template Name: Default Search Template
 * 
 */

 get_header();

?>

<div class="pbp-wrapper">

    <div class="pbp-container">

        <div class="pbp-content">

            <div class="pbp-site-content">
            <?php //if( is_front_page() || is_home() ): ?>

            <?php
            
            $search_query = sanitize_text_field( get_search_query() );

            $args = array(  
                'post_status' => 'publish',
                'post_type' => [ 'bars', 'post' ],
                'post_type' => 'bars',
                's' => $search_query
            );

            $bars = new WP_Query( $args );

            $search_results = [
                'posts'      => [],
                'bars'      => []
            ];

            while( $bars->have_posts() ) {
                $bars->the_post();

                if( get_post_type() == 'bars' ) {
               
                    array_push( $search_results[ 'bars' ], [
                        'title'         => get_the_title(),
                        'permalink'     => get_the_permalink(),
                        'postType'      => get_post_type(),
                        'content'      => esc_html( get_the_excerpt() )
                    ] );
                    
                }

                if( get_post_type() == 'post' ) {

                    array_push( $search_results[ 'post' ], [
                        'title'         => get_the_title(),
                        'permalink'     => get_the_permalink(),
                        'postType'      => get_post_type()
                    ] );

                }

            }

            $bar_related_meta_keys = [ 
                '_pbp_city_key',
                '_pbp_country_key',
                '_pbp_postal_code_key'
            ];

            $meta_array = array();
            $meta_array['relation'] = 'OR';  // DECLARE RELATION --> YOU CAN USE 'OR' AS WELL  
           
            foreach($bar_related_meta_keys as $meta_key){  // CREATE QUERY FOR EACH COUNTRY IN ARRAY

                $meta_array[] =  array(
                    'key'       => $meta_key,  
                    'value'     => $search_query,  // THE COUNTRY TO SEARCH
                    'compare'   => 'LIKE',  // TO SEARCH THIS COUNTRY IN YOUR COMMA SEPERATED STRING
                    'type'      => 'CHAR',
                );
            
            }
            
            
            
            $argsTwo = array (
                    'post_type'     => array( 'bars' ),  // YOUR POST TYPE
                    'meta_query'    => $meta_array,  // ARRAY CONTAINING META QUERY
                );
            
            // The Query
            $metaQuery = new WP_Query( $argsTwo );

            while( $metaQuery->have_posts() ) {
                $metaQuery->the_post();

                if( get_post_type() == 'bars' ) {

                    array_push( $search_results[ 'bars' ], [
                        'title'         => get_the_title(),
                        'permalink'     => get_the_permalink(),
                        'postType'      => get_post_type(),
                        'content'       => esc_html( get_the_excerpt() )
                    ] );
                    
                }

            }

            $search_results[ 'bars' ] = array_values( array_unique( $search_results[ 'bars' ], SORT_REGULAR ) );

            // var_dump($search_results);

            ?>

                    <header class="page-header">
                            <h1 class="page-title"><?php esc_html(the_search_query()); ?></h1>
                    </header><!-- .page-header -->

                    <div id="primary" class="content-area">
                    
                    <?php
                    
                    if( ! empty( $search_results[ 'bars' ] ) ) {

                        foreach ( $search_results[ 'bars' ] as $bar ) {
                            echo '<h2 class="entry-title"><a href="'.$bar['permalink'].'" target="_blank" role="bookmark">' . $bar['title'] . '</a></h2>';
                        }
        
                    }

                    ?>

                    </div> <!-- .content-area -->

                </div>

            <?php //endif; ?>

                <div class="pbp-sidebar">

                    <form role="search" action="<?php echo esc_url( home_url('/') ); ?>" method="get" id="searchform" class="search-form">
                    
                        <div class="pbp-custom-searchform-fields">
                            <label for="s">Search for:</label>
                            <input type="text" value="" name="s" id="s" />
                            <input type="hidden" value="1" name="city" />
                            <input type="hidden" value="bars" name="post_type" />
                            <input type="submit" id="searchsubmit" value="Search" />
                        </div>

                    </form>

                </div> <!-- .pbp-sidebar -->

        </div> <!-- .pbp-content -->

    </div> <!-- .pbp-container -->

</div> <!-- .pbp-wrapper -->

<?php

get_footer();