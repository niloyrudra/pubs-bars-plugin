jQuery( document ).ready( function($) {

    if( $( '.pbp-update-panel-close' ) ) {
    
        $( '.pbp-update-panel-close' ).on( 'click', e => {
            
            e.preventDefault();
            $( '.pbp-update-panel' ).removeClass( 'reveal' );
            
        } );
    
    }

} );
