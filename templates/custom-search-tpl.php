<?php
/**
 *  Template Name: Custom Search Template
 */

 get_header();

 ?>

<div class="pbp-wrapper">

    <div class="pbp-container">

        <h2>Custom Search Template:</h2>

        <form action="" method="get">

            <!-- For Future Uses -->

            <!-- <code>
                <?php //$s_val_lat = @$_GET[ 'pbp_search_lat' ] ?? ''; ?>
                <label for="pbp_search_lat">Latitude:</label>
                <input type="text" name="pbp_search_lat" id="pbp_search_lat" placeholder="eg. 51.4829" value="<?php //echo $s_val_lat; ?>" label="Latitude" />
                <?php //$s_val_lng = @$_GET[ 'pbp_search_lng' ] ?? ''; ?>
                <label for="pbp_search_lng">Longitude:</label>
                <input type="text" name="pbp_search_lng" id="pbp_search_lng" placeholder="eg. -122.4829" value="<?php //echo $s_val_lng; ?>" label="Longitude" />
            </code> -->

            <!-- // -->

            <div style="display:flex;flex-direction:row;justify-content:center;align-items:center;padding: 2em 1em 0;">

                <?php $selected = @$_GET[ 'pbp_select' ] ?? ''; ?>
                <label for="pbp_radius">Proximity:</label>
                <select name="pbp_select" id="pbp_select" label="Proximity" style="margin-right:1em;margin-left:0.5em;border-radius:14px;padding:0 1em;">
                    <option value=">" <?php echo ($selected == '>' ? 'selected' : '' ); ?>>Out Of ( &gt; ) </option>
                    <option value="<" <?php echo ($selected == '<' ? 'selected' : '' ); ?>>Within ( &lt; ) </option>
                <select>

                <?php $s_val_radius = @$_GET[ 'pbp_radius' ] ?? ''; ?>
                <label for="pbp_radius">Radius:</label>
                <select name="pbp_radius" id="pbp_radius" label="Radius" style="margin-right:1em;margin-left:0.5em;border-radius:14px;padding:0 1em;">
                <?php
                    $radiuses = [ 10000, 8000, 7000, 6000, 50, 45, 40, 35, 30, 25, 20, 15, 10 ];
                    
                    foreach( $radiuses as $radius ) {
                        $selected = intval( $s_val_radius );
                        echo '<option value="' . $radius . '" ' . ( $selected === $radius ? 'selected' : '' ) . '>' . $radius . ' kms</option>';
                    }
                ?>
                </select>

                <?php $s_val_limit = @$_GET[ 'pbp_limit' ] ? esc_sql( $_GET[ 'pbp_limit' ] ) : 20; ?>
                <label for="pbp_limit">Limit:</label>
                <input type="number" name="pbp_limit" id="pbp_limit" label="Limit" style="min-width:70px;margin-right:1em;margin-left:0.5em;border-radius:14px;padding:0 1em;" value="<?php echo $s_val_limit; ?>" />
                
                <input type="submit" value="Custom Search" class="btn btn-primary">

            </div>


        </form>

        <br><hr><br>

        <?php if( function_exists( 'pbp_search_by_distance' ) && ! empty( pbp_search_by_distance() ) ) {

            $results = pbp_search_by_distance();
            

            echo "<div style=\"position:relative;width:100%;display:grid; grid-template-columns:repeat(3,1fr);grid-gap:1em;\">";

            foreach ( $results as $result ):

                // $distance = bcadd($result->distance, 0, 2);
                // $distance = sprintf('%0.2f', $result->distance);
                $distance = number_format( (float)$result->distance, 2, '.', ',' );

                echo "<div style=\"padding:0; border-radius:5px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);\">";
                
                echo "<img src=\"{$result->pic}\" alt=\"\" style=\"width:100%;height:100px;border-radius:5px 5px 0 0;\" />";
                echo "<div style=\"padding: 1em;\">";
                echo "<h3><a href=\"{$result->website}\" target=\"_blank\" role=\"bookmark\">{$result->name}</a></h3> <code>Within a distance of {$distance} kms</code>";
                echo "<p>{$result->city}, {$result->country}</p>";
                echo "</div>";

                echo "</div>";

            endforeach;

            echo "</div>";

        } ?>
        
    </div>

</div>

 <?php
 get_footer();