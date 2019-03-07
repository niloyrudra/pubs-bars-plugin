
jQuery( document ).ready( function($) {
  initMap();
});



var map;
var markers = [];
var infoWindow;
var locationSelect;
var data;


function initMap() {
  
  // Collecting Data
  var barCollections = document.getElementById( 'pbp-bar-collections' ).innerHTML;
  var radius = document.getElementById("radiusSelect").value;
  var submitButton = document.getElementById("searchButton");

  if( barCollections ) {
    data = JSON.parse( barCollections );
  }

  var mapPosition = {lat: 51.5074, lng: -0.1278}; // London Location

  var mapDiv = document.getElementById('map');

  var options = {
    center: mapPosition,
    zoom: 4,
    // gestureHandling: 'greedy',
    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
    mapTypeId: 'roadmap'
  }

  map = new google.maps.Map( mapDiv, options );
  

  // Array of Markers
  var markers = [];

  if( data && data.length > 0 ) {

    // Need a better API To Work
    // This will give a Location Coordinators to use those to find
    // the location to query for the bars within a certain radius
    // It will change the mapPosition and take the viewport to the right place

    //submitButton.addEventListener( 'click', searchLocations );

    // This section only gives this bars of a certain City or Country or  an Address
    // Radius might not work properly here...
    if( radius && radius !== '' ) {

      var bars = data.filter( bar => ( 3959 * Math.acos(Math.sin(mapPosition.lat)*Math.sin(bar.lat)+Math.cos(mapPosition.lat)*Math.cos(bar.lat)*Math.cos(mapPosition.lng - bar.lng)) ) < parseFloat(radius) );

      if( bars.length > 0 ) {
  
        for (let i = 0; i < bars.length; i++) {
          markers[i] = {
              coords: { lat: parseFloat( bars[i].lat ), lng: parseFloat( bars[i].lng ) },
              content: `<h2><a href="${bars[i].link}" target="_blank" role="bookmark">${bars[i].name}</a></h2><p>${bars[i].address}</p>`
              
          };
          
        }
    
        // Loop Through Markers
        for (let index = 0; index < markers.length; index++) {
          addMarker( markers[index] );
        }
  
      }

    }

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

  // Search Location Of Given Location in the Search Input Field
  function searchLocations() {

    var address = document.getElementById("addressInput").value;

    var geocoder = new google.maps.Geocoder();

    geocoder.geocode({ address: address }, function( results, status ) {

      if (status == google.maps.GeocoderStatus.OK) {
      searchLocationsNear(results[0].geometry.location);
      } else {
        alert(address + ' not found');
      }
      
    });

  }

  // Covert Degree To Radian
  function toRadians(angle) {
    return angle * (Math.PI / 180);
  }
  // Covert Radian To Degree
  function toDegrees(angle) {
    return angle * (180 / Math.PI);
  }

}

