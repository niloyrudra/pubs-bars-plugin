<div class="wrap">

    <h1><?php _e( 'Pubs Bars DataBase Manager', 'pubs-bars-plugin' ); ?></h1>
    <?php settings_errors(); ?>

    <div class="pbp-db-table-section">

        <?php
            
            global $wpdb;

            $table = $wpdb->prefix . 'bars_zone';
            
            $pbp_rows = $wpdb->get_results( "SELECT * FROM {$table}" );

            echo '<h2>' . __( 'Pubs/Bars Plugin Database Table', 'pubs-bars-plugin' ) . ':</h2>';

            echo '<table class="pbp-db-table"><tr><th>ID</th><th>Pubs\Bars Name</th><th>Address</th><th>City</th><th>Country</th><th>Featured</th><th>Edit | Delete</th></tr>';

            if( count( $pbp_rows ) > 1 ) {

                foreach ( $pbp_rows as $row ) {

                    echo '<tr><td>' . $row->id . '</td><td>' . $row->name . '</td><td>' . $row->address . '</td><td>' . $row->city . '</td><td>' . $row->country . '</td><td>' . ( $row->featured ? "YES" : "NO" ) . '</td><td>';
                    echo '<form method="post" action="" class="inline-block">';
                    echo '<input type="hidden" name="pbp_edit_entry" value="' . $row->id . '">';
                        submit_button( 'Edit', 'primary small', 'submit', false );
                    echo '</form> ';

                    echo '<form method="post" action="" class="inline-block">';
                    echo '<input type="hidden" name="pbp_remove_entry" value="' . $row->id . '">';
                    submit_button( 'Delete', 'delete small', 'submit', false, array(
                            'onclick' => 'return confirm("Are you sure you want to delete this Entry?");'
                    ));
                    echo '</form></td></tr>';
                    
                }

            }elseif( count( $pbp_rows ) === 1 ) {

                echo '<tr><td>' . $pbp_rows[0]->id . '</td><td>' . $pbp_rows[0]->name . '</td><td>' . $pbp_rows[0]->address . '</td><td>' . $pbp_rows[0]->city . '</td><td>' . $pbp_rows[0]->country . '</td><td>' . ( $pbp_rows[0]->featured ? "YES" : "NO" ) . '</td><td>';
                echo '<form method="post" action="" class="inline-block">';
                echo '<input type="hidden" name="pbp_edit_entry" value="' . $pbp_rows[0]->id . '">';
                    submit_button( 'Edit', 'primary small', 'submit', false );
                echo '</form> ';

                echo '<form method="post" action="" class="inline-block">';
                echo '<input type="hidden" name="pbp_remove_entry" value="' . $pbp_rows[0]->id . '">';
                submit_button( 'Delete', 'delete small', 'submit', false, array(
                        'onclick' => 'return confirm("Are you sure you want to delete this Entry?");'
                ));
                echo '</form></td></tr>';

            }else{

                return "No Row is available in the Database Table";

            }

            echo '</table>';

        ?>

    </div> <!-- .pbp-db-table-section -->

    
    <div class="pbp-update-panel<?php echo ( isset( $_POST[ 'pbp_edit_entry' ] ) ? ' reveal' : '' ); ?>">
    
            <?php $id = $_POST[ 'pbp_edit_entry' ]; ?>

            <div class="pbp-form-content">
                
                <form action="" method="post">
                    
                    <button type="button" class="pbp-update-panel-close">&#10005;</button>
                    
                    <table class="form-table">
                        
                        <tbody>
                            
                            <tr>
                                
                                <th>
                                    <h2><?php _e( 'Update/Edit', 'pubs-bars-plugin' );?></h2>
                                </th>
                                <td>
                                    <code>
                                        <?php _e( 'Entry ID: ', 'pubs-bars-plugin' ); ?>
                                        <?php echo '<b>' . esc_sql( $id . '</b>' ); ?>
                                    </code>
                                </td>

                            </tr>

                            <input name="pbp_id" type="hidden" id="pbp_id" value="<?php echo esc_sql($id); ?>" />

                            <?php render_fields(); ?>

                            <tr>
                                <td>
                                    <p class="submit"><input type="submit" name="pbp_update_entry" id="pbp_update_entry" class="button button-primary" value="Update"></p>
                                </td>
                            </tr>
                            
                    </tbody>
                        
                </table>


            </form>

        </div><!-- .pbp-form-content -->
    
    </div> <!-- .pbp-update-panel --> 
   

</div> <!-- .wrap -->


