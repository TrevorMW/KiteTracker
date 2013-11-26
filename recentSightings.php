<?php include('assets/inc/header.php'); include('functions.php'); ?>

	<div class="col-lg-3 col-md-3 col-sm-3 leftCol">
		<div class="alert" id="resultsMsg"></div>
		<ul class="sightings" id="sightingsPanel"></ul>
	</div>
	
	<div class="col-lg-9 col-md-9 col-sm-9 rightCol">
		<div id="map-canvas"></div>
	</div>
	



<script type="text/javascript">


// CHANGE ZIP CODE AFTER INITIAL RENDER OF RESULTS
jQuery('#changeZip').submit(function(event){
	event.preventDefault();
	// CLEAR LIST OF PREVIOUS RESULTS
	jQuery('#sightingsPanel').html('');
	// GRAB NEW ZIP CODE
	var zip = jQuery(this).find('#newZip').val();
    var limit = jQuery(this).find('#limitSightings').val();
	// PASS NEW ZIP CODE THROUGH GEOCODER > INITIALIZE > BUILD_SIGHTINGS
    if(zip != null){
        geocode_zip(zip, limit);
    } else {

    }

});

// THROW ERROR IF ZIP ENTERED IS NOT VALID
function zip_error(){
	jQuery('#zipForm').prepend('<div id="zipError" class="alert alert-danger"><p></p></div>');
	jQuery('#zipError p').text('Please enter a valid Zip Code');
}


// GEOCODE ZIP CODE THROUGH GOOGLE MAPS API
function geocode_zip(zip, limit){
	// DEFINE MAP
	var map;
	// DEFINE GEOCODER
	var geocoder;
    	geocoder = new google.maps.Geocoder();
	// START GEOCODING THE ZIPCODE
	geocoder.geocode( { 'address': zip}, function(results, status) {

		if (status == google.maps.GeocoderStatus.OK) {

            var storage = supports_html5_storage();

            var lat = results[0].geometry.location.lat();
            var lng = results[0].geometry.location.lng();

            if( lat && lng && storage == true){
                localStorage.setItem('storedLatitude', lat);
                localStorage.setItem('storedLongitude', lng);
            }
			var coordinates = {'lat':results[0].geometry.location.lat(),
						       'lng':results[0].geometry.location.lng()};

			// HIDE MODAL BEFORE INITIALIZING NEW MAP
			jQuery('#zipcode').modal('hide');
		}
        initialize(coordinates);
	});
}

// INITIALIZE GOOGLE MAPS WITH APPLICABLE PARAMETERS
function initialize(coordinates) {

	// HIDE ANY PREVIOUS MESSAGES
	jQuery('#resultsMsg').html('').hide();

    var tRlat = new Number(coordinates.lat) + 0.25;
    var bLlat = new Number(coordinates.lat) - 0.15;
    var tRlng = new Number(coordinates.lng) + 0.25;
    var bLlng = new Number(coordinates.lng) - 0.35;

    console.log(coordinates.lat, coordinates.lng);
    // NATIVE JSON OF LAT & LONG & CALCULATED BOUNDARIES
    var coords = {"lat":coordinates.lat,"long":coordinates.lng, "tRlat":tRlat, "tRlng":tRlng, "bLlat":bLlat, "bLlng":bLlng};

    if(coords.lat == ''){
        var coords = {'lat':0,'long':0, 'tRlat':0, 'tRlng':0, 'bLlat':0, 'bLlng':0};
    }

    console.log(coords);
   	// TURN JSON COORDINATE OBJECT INTO PARAMETERS TO SEND TO AJAX
    var serializedCoords = jQuery.param(coords);

  	// DEFINE CERTAIN VARIABLES USED TO BUILD PAGE STRUCTURE
	var trueHeight = jQuery(window).height() - jQuery('.header nav').height();
	var mapBox = jQuery('#map-canvas');
	var leftCol = jQuery('.leftCol');

	// ADD HEIGHT OF PAGE TO MAP
	mapBox.css('height', trueHeight);

    var center = new google.maps.LatLng(coords.lat, coords.long);

    // SET MAP OPTIONS DEPENDING ON GEOLOCATION METHOD
    var mapOptions = {
       center: center,
       zoom: 10,
       mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    // BUILD MAP WITH WHATEVER CURRENT VARIABLES AND DATABASE INFORMATION IS PRESENT
    var map = new google.maps.Map(document.getElementById("map-canvas"),mapOptions);

    /* var populationOptions = {
        strokeColor: '#FF0000',
        strokeOpacity: 0.5,
        strokeWeight: 2,
        fillColor: '#FF0000',
        fillOpacity: 0.15,
        map: map,
        center: center,
        radius: 30000
    };

    var cityCircle = new google.maps.Circle(populationOptions); */

    //find_sightings_records(map, serializedCoords);
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
	var contentString = '<div class="google-info-window" id="info-window">'+'<h3>'+ sightingObject['species_name'] +'</h3>'+'<div  class="info-window-content">'+
	  '<h5>'+ sightingObject['id'] +'</h5> '+'<p>(Sighting occured in '+ sightingObject['county'] +' county).</p>'+'</div>'+'</div>';
	// DEFINE MARKER CHARACTERISTICS
	var marker = new google.maps.Marker({
	   position: new google.maps.LatLng(sightingObject['lat'], sightingObject['lng']),
	   map: map,
	   animation:google.maps.Animation.DROP
	});
    marker.set('id',sightingObject['id']);

	// DEFINE INFO WINDOW PARAMETERS
	var infoWindow = new google.maps.InfoWindow({
	  content: contentString
	});

    this.myclick=function(i) {
        google.maps.event.trigger(gmarkers[i], 'click');
    };

    // ADD CLICK LISTENER ON MARKERS. CLICK SHOWS INFO WINDOW
	google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(this.html);
		// var sideLink = jQuery('li#' + id);
		// sideLink.addClass('active').find('a').css('font-size','red');
        infoWindow.open(map, marker);
	});



    google.maps.event.addListener(infoWindow,'closeclick',function(){

    });

}

jQuery(document).on('click', 'a.infoWindowHandler', function(){
    var markerId = jQuery(this).closest('li').attr('id'); console.log(markerId);
    //var infoWindowID = marker.get('id');console.log(infoWindowID);
    //infoWindow.open(map, markerId);
});


function build_sightings_list(map,data){
	// LOOP THROUGH DATA TO BUILD SIDEBAR LIST
    for ( var j = 0; j < data.length; j++) {

        var sightingsHTML = '<li id="'+data[j].sample_event_id+'"><a href="#" onclick="myClick('+data[j].sample_event_id+');" class="infoWindowHandler"><h4>'+data[j].sample_event_id+'</h4></a></li>';
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

        add_map_markers(map, sightingObject);
    }
}
</script>


<?php include('assets/inc/footer.php'); ?>