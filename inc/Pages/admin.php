<div class="wrap">

    <h1>Pubs Bars Plugin</h1>
    <?php settings_errors(); ?>

    <hr>

    <p class="description"><?php _e( 'Shortcode for Search Form ', 'pubs-bars-plugin' ); ?><small><b><?php _e( 'Default', 'pubs-bars-plugin' ); ?></b></small> <code>[search-form]</code></p>
    <p><?php _e( 'Shortcode for Search Form ', 'pubs-bars-plugin' ); ?><small><b><?php _e( 'Standard', 'pubs-bars-plugin' ); ?></b></small> <code>[search-form title="Your Search Form Title" placeholder="Your Search Form Placeholder"]</code></p>
    
    <hr>

<form action="options.php" method="post">

    <?php
    
        settings_fields('pbp_settings_group');
        do_settings_sections('pubs_bars_plugin');
        submit_button( 'Set Google API Key' );

    ?>

</form>

</div>