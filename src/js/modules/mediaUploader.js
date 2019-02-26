
jQuery( document ).ready( function($) {

    var mediaUploader;
    var attachment;

    $( '#upload-button' ).on( 'click', function(e) {
        e.preventDefault();
        if( mediaUploader ) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media( {
            title: 'Choose a Profile Picture',
			library: {
				type: 'image' // mime type
			},
            button: {
                text: 'Choose Picture',
            },
            multiple: false
        } );

        mediaUploader.on( 'select', function() {
            attachment = mediaUploader.state().get( 'selection' ).first().toJSON();
            $( '#pbp_pic' ).val( attachment.url );
            // $( '.pbp-code' ).css( 'opacity', '1' );
            $( '.pbp-code' ).addClass( 'reveal' );
            $( '.pbp-code' ).html( attachment.filename );
        } );

        mediaUploader.open();

    } );


    $( '#remove-button' ).on( 'click', function(e) {
        e.preventDefault();

        var answer = confirm( 'Are you sure you want to remove this picture?' );
        if( answer == true ) {
            $( '#pbp_pic' ).val( '' );
        }
        return;

    } );

} );