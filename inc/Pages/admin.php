<div class="wrap">

    <h1>Pubs Bars Plugin</h1>
    <?php settings_errors(); ?>

<hr>
    <p class="description">Shortcode for Search Form <small><b>Default</b></small> <code>[search-form]</code></p>
    <p>Shortcode for Search Form <small><b>Standard</b></small> <code>[search-form title="Your Search Form Title" placeholder="Your Search Form Placeholder"]</code></p>
<hr>

    <div class="pbp-admin-form-section">
    
        <form action="" method="post" class="pbp-general-form">
        
            <table class="form-table">

                <tbody>

                    <?php render_fields(); ?>
                    
                </tbody>
                
            </table>

            <p class="submit"><input type="submit" name="pbp_submit" id="pbp_submit" class="button button-primary" value="Insert"></p>

        </form>
        
    </div>

</div>