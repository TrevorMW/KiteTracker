<?php include('assets/inc/header.php'); include('functions.php'); ?>

	<div class="col-lg-3 col-md-3 col-sm-3 leftCol">
		<div class="alert" id="resultsMsg"></div>
		<ul class="sightings" id="sightingsPanel"></ul>
	</div>
	
	<div class="col-lg-9 col-md-9 col-sm-9 rightCol">
		<div id="map-canvas"></div>
	</div>
	
	<div class="modal fade" id="zipcode">
	 	<div class="modal-dialog">
		  	<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Add a Zip Code near your location</h4>        
				</div>
				<div class="modal-body">
					<form  method="post" id="zipForm" class="form-inline" role="form">
						<div class="form-group">
							<label class="sr-only" for="exampleInputEmail2">Zip Code</label>
							<input type="text" class="form-control" id="exampleInputEmail2" placeholder="Enter your Zip Code">
						</div>
						<button type="submit" class="btn btn-default btn-info" id="zipFormSubmit">Geocode Zip Code</button>
					</form>
		  		</div>
				<div class="modal-footer">
					<small>In the interest of privacy, you may enter a Zip Code near your location if you wish, as an alternative to providing location data through your browser.</small>
				</div>
			</div>
		</div>
	</div>


<script type="text/javascript">


function supports_html5_storage() {
    try {
        return 'localStorage' in window && window['localStorage'] !== null;
    } catch (e) {
        return false;
    }
}

// CHANGE ZIP CODE AFTER INITIAL RENDER OF RESULTS
jQuery('#changeZip').submit(function(event){
	event.preventDefault();
	// CLEAR LIST OF PREVIOUS RESULTS
	jQuery('#sightingsPanel').html('');
	// GRAB NEW ZIP CODE
	var zip = jQuery(this).find('input[type="text"]').val();
	// PASS NEW ZIP CODE THROUGH GEOCODER > INITIALIZE > BUILD_SIGHTINGS
    if(zip != null){
        geocode_zip(zip);
    } else {

    }

});



// THROW ERROR IF ZIP ENTERED IS NOT VALID
function zip_error(){
	jQuery('#zipForm').prepend('<div id="zipError" class="alert alert-danger"><p></p></div>');
	jQuery('#zipError p').text('Please enter a valid Zip Code');
}

// GET HTML5 BROWSER COORDINATES IS AVAILABLE	
function get_location() {
	var coordinates = navigator.geolocation.getCurrentPosition(show_map, handle_error);
}



// GET COORDINATES IF USER ALLOWS GEOLOCATION THROUGH BROWSER
function show_map(position) {
    // GET LATITUTDE FROM BROWSER
 	var latitude = position.coords.latitude;
 	// GET LONGITUDE FROM BROWSER
 	var longitude = position.coords.longitude;
    var storage = supports_html5_storage();
    if(latitude && longitude && storage == true){
        localStorage.setItem('latitude', latitude);
        localStorage.setItem('longitude', longitude);
    }
    var tRlat = latitude + 0.25;
 	var bLlat = latitude - 0.25;
 	var tRlng = longitude + 0.25;
 	var bLlng = longitude - 0.25;
 	// NATIVE JSON OF LAT & LONG & CALCULATED BOUNDARIES
	var coords = {'lat':position.coords.latitude,'long':position.coords.longitude, 'tRlat':tRlat, 'tRlng':tRlng, 'bLlat':bLlat, 'bLlng':bLlng};
	// IF JSON EXISTS, INITALIZE THE MAP WITH CORRECT COORDINATES AS MAP CENTER, ELSE RUN MODAL TO GRAB ZIP CODE
	if(coords){
		initialize(coords);
	} else {
		handle_error();
	}
}

// IF USER DENIES ACCESS TO BROWSER GEOLOCATION, ASK FOR ZIPCODE
function handle_error(err) {
	if (err.code == 1) {
  	// IF USER DENIES ACCESS TO LOCATION, SHOW ZIP CODE MODAL
	jQuery('#zipcode').modal('show');
	// FIND FORM
	var form = jQuery('#zipForm');
		// CAPTURE SUBMIT & PREVENT REAL POST SUBMISSION
		form.submit(function(event){
			event.preventDefault();
			// FIND VALUE IN ZIP FORM
			var zip = form.find('input[type="text"]').val();
			if(zip == ''){
				// IF NO VALUE FOR ZIP CODE, THROW ERROR
				zip_error();
			} else {
				// REMOVE ERROR BOX IF THERE, AND PROCEED
				jQuery('#zipError').remove();
				// SEND THIS ZIP TO GOOGLE GEOCODING FUNCTION
				geocode_zip(zip);
			}
		return false;
		});
	}
}

// GEOCODE ZIP CODE THROUGH GOOGLE MAPS API
function geocode_zip(zip){
	// DEFINE MAP
	var map;
	// DEFINE GEOCODER
	var geocoder;
    	geocoder = new google.maps.Geocoder();
	// START GEOCODING THE ZIPCODE
	geocoder.geocode( { 'address': zip}, function(results, status) {

		if (status == google.maps.GeocoderStatus.OK) {

			// BUILD BOUNDARIES OBJECT TO SEND VIA AJAX TO GRAB NEARBY SIGHTINGS
			var topRight = results[0].geometry.viewport.getNorthEast();
			var bottomLeft = results[0].geometry.viewport.getSouthWest();

            var lat = results[0].geometry.location.lat();
            var lng = results[0].geometry.location.lng();
            var storage = supports_html5_storage();
            if( lat && lng && storage == true){
                localStorage.setItem('latitude', lat);
                localStorage.setItem('longitude', lng);
            }
            // DEFINE COORDINATES OBJECT WITH LAT AND LONG
			var coords = {'lat':results[0].geometry.location.lat(),
						  'long':results[0].geometry.location.lng(),
						  'tRlat':topRight.lat() + .25,
						  'tRlng':topRight.lng()+ .25,
						  'bLlat':bottomLeft.lat()- .25,
						  'bLlng':bottomLeft.lng()-  .25}

			// HIDE MODAL BEFORE INITIALIZING NEW MAP
			jQuery('#zipcode').modal('hide');
		} else {
			// IF NO COORDINATES OR ERROR IN GEOCODING, SET MAP OBJECT TO EQUATOR
			var coords = {'lat':0,
						  'long':0,
						  'topRightLat':40,
						  'topRightLng':-78,
						  'bottomLeftLat':30,
						  'bottomLeftLng':-87};
		}
		// INITALIZE THE MAP WITH ZIP CODE COORDINATES
		initialize(coords);

	});
}

// INITIALIZE GOOGLE MAPS WITH APPLICABLE PARAMETERS
function initialize(coords) {
	// HIDE ANY PREVIOUS MESSAGES
	jQuery('#resultsMsg').html('').hide();

   	// TURN JSON COORDINATE OBJECT INTO PARAMETERS TO SEND TO AJAX
    var serializedCoords = jQuery.param(coords);
    http://open.spotify.com/track/1HlOGL1p6wlpOZatJ2NwFk
  	// DEFINE CERTAIN VARIABLES USED TO BUILD PAGE STRUCTURE
	var trueHeight = jQuery(window).height() - jQuery('.header nav').height();
	var mapBox = jQuery('#map-canvas');
	var leftCol = jQuery('.leftCol');

	// ADD HEIGHT OF PAGE TO MAP
	mapBox.css('height', trueHeight);

    // SET MAP OPTIONS DEPENDING ON GEOLOCATION METHOD
    var mapOptions = {
       center: new google.maps.LatLng(coords.lat, coords.long),
       zoom: 12,
       mapTypeId: google.maps.MapTypeId.ROADMAP
    };

	var bLlng = coords.bLlng - 0.10;
	var bLlat = coords.bLlat - 0.10;
	var tRlat = coords.tRlat + 0.10;
	var tRlng = coords.tRlng + 0.10;

    // BUILD MAP WITH WHATEVER CURRENT VARIABLES AND DATABASE INFORMATION IS PRESENT
    var map = new google.maps.Map(document.getElementById("map-canvas"),mapOptions);

    //flightPath.setMap(map);

    find_sightings_records(map, serializedCoords);

} // END INITALIZE FUNCTION

google.maps.event.addDomListener(window, 'load', initialize);

function find_sightings_records(map, serializedCoords){
// WITH JSON PARAMS, CALL FOR SIGHTINGS WITHIN THE VIEWPORT DEFINED BY BROWSER LOCATION OR ZIP CODE
jQuery.ajax({
    url: "assets/scripts/findSightings.php",
    dataType:'json',
    data: serializedCoords,
    success: function(data){
        // IF DATA IS RETURNED, BEGIN PARSING IT AND ADDING MARKERS TO THE MAP
        if(data){
            jQuery('#resultsMsg').append('<p>We found '+data.length+' sightings in your area.</p>').addClass('alert-success').slideDown();
            build_sightings_list(map, data);
        }
    }
});

}
function add_map_markers(map, sightingObject) {
    var sightingObject;

	// BUILD MARKUP FOR EACH MARKER INFOWINDOW
	var contentString = '<div class="google-info-window" id="info-window">'+'<h3>'+ sightingObject['species_name'] +'</h3>'+'<div class="info-window-content">'+
	  '<h5>'+ sightingObject['id'] +'</h5> '+'<p>(Sighting occured in '+ sightingObject['county'] +' county).</p>'+'</div>'+'</div>';
	// DEFINE MARKER CHARACTERISTICS
	var marker = new google.maps.Marker({
	   position: new google.maps.LatLng(sightingObject['lat'], sightingObject['lng']),
	   map: map,
	   animation:google.maps.Animation.DROP
	});



	// DEFINE INFO WINDOW PARAMETERS
	var infowindow = new google.maps.InfoWindow({
	  content: contentString
	});
	// ADD CLICK LISTENER ON MARKERS. CLICK SHOWS INFO WINDOW
	google.maps.event.addListener(marker, 'click', function() {
		// var sideLink = jQuery('li#' + id);
		// sideLink.addClass('active').find('a').css('font-size','red');
		infowindow.open(map, marker);
	});

}

function build_sightings_list(map,data){
	// LOOP THROUGH DATA TO BUILD SIDEBAR LIST
    for ( var j = 0; j < data.length; j++) {
        //console.log(data[j]);
        var sightingsHTML = '<li id="'+data[j].sample_event_id+'"><a href="#" onclick=""><h4>'+data[j].sample_event_id+'</h4></a></li>';
        jQuery('#sightingsPanel').append(sightingsHTML);

        var sightingObject = {
            "id":data[j].sample_event_id,
            "state":data[j].state,
            "county":data[j].county,
            "scientific":data[j].scientific_name,
            "taxNum":data[j].taxanomic_order_number,
            "species_name":data[j].common_name,
            "lat":data[j].latitude,
            "lng":data[j].longitude
        };

        add_map_markers(map,sightingObject);
    }
}
</script>


<?php include('assets/inc/footer.php'); ?>