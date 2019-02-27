
jQuery( document ).ready( function($) {
  initMap();
});



var map;
var markers = [];
var infoWindow;
var locationSelect;



function initMap() {
  var barCollections = document.getElementById( 'pbp-bar-collections' ).innerHTML;
  var data = JSON.parse( barCollections );
  
  console.log(data);
  

  // var mapPosition = {lat: -33.863276, lng: 151.107977}; // Sydney Location
  var mapPosition = {lat: 51.5074, lng: -0.1278}; // London Location

  var mapDiv = document.getElementById('map');

  var options = {
    center: mapPosition,
    zoom: 8,
    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
    mapTypeId: 'roadmap'
  }

  map = new google.maps.Map( mapDiv, options );

  // infoWindow = new google.maps.InfoWindow();
  

  // Array of Markers
  var markers = [];
  for (let i = 0; i < data.length; i++) {
    markers[i] = {
        coords: { lat: parseFloat( data[i].lat ), lng: parseFloat( data[i].lng ) },
        content: `<h2><a href="${data[i].link}" target="_blank" role="bookmark">${data[i].name}</a></h2><p>${data[i].address}</p>`
        
      };
    
  }

  // Loop Through Markers
  for (let index = 0; index < markers.length; index++) {
    addMarker( markers[index] );
  }

  

  // Add Marker Function
  function addMarker( props ) {

    var marker = new google.maps.Marker( {
      position: props.coords,
      map: map,
      // icon: props.iconImage
    } );

    // Check for Custom Icon
    if( props.iconImage ) {
      // Set Icon Image
      marker.setIcon( props.iconImage );
    }

    // Check for The Content
    if( props.content ) {
      // Set Content
      var infoWindow = new google.maps.InfoWindow( {
        content: props.content
      } );
    
      // Setting Event Listener for Viewing Content
      marker.addListener( 'click', () => {
        infoWindow.open( map, marker );
      } );

    }


  }


}

