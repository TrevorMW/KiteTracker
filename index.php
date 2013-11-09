<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>KiteTracker</title>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/style.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Fjord+One|PT+Sans:400,700' rel='stylesheet' type='text/css'>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAurG7BXBQXqdyRebvS68YZ8-GkfFp3WDE&amp;sensor=true">
</script>
</head>
<body onload="get_location();">
<?php include('functions.php'); ?>

	<div class="wrapper header">
		<nav class="navbar navbar-inverse" role="navigation">
			<form class="navbar-form navbar-right" role="search" id="changeZip">
		      <div class="form-group">
		        <input type="text" class="form-control"  placeholder="Enter a new zipcode">
		      </div>
		      <button type="submit" class="btn btn-default btn-info" id="">Submit</button>
		    </form> 
			<ul class="nav navbar-nav  pull-right">
				<li><a href="">About Swallow-tailed Kites</a></li>
				<li><a href="">Recent sightings</a></li>
				<li><a href="">Report a sighting</a></li>
			</ul>
			<a class="navbar-brand" href="#">KiteTracker</a>
		</nav>
	</div>
	
	<div class="col-lg-3 leftCol">
		<ul class="sightings" id="sightingsPanel">
		
		</ul>
	</div>
	
	<div class="col-lg-9 rightCol">
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

jQuery('#changeZip').submit(function(event){

	event.preventDefault();
	
	jQuery('#sightingsPanel').html('');
	
	var zip = jQuery(this).find('input[type="text"]').val();
	
	geocode_zip(zip);
	
});


function zip_error(){
	jQuery('#zipForm').prepend('<div id="zipError" class="alert alert-danger"><p></p></div>');
	jQuery('#zipError p').text('Please enter a valid Zip Code')
}


	
function get_location() {
	// GET HTML5 BROWSER COORDINATES IS AVAILABLE
	var coordinates = navigator.geolocation.getCurrentPosition(show_map, handle_error);
}


function show_map(position) {

    // GET LATITUTDE FROM BROWSER
 	var latitude = position.coords.latitude;
 	
 	// GET LONGITUTDE FROM BROWSER 
 	var longitude = position.coords.longitude; 
 	
 	var tRlat = latitude + 1;
 	var bLlat = latitude - 1;
 	var tRlng = longitude + 1;
 	var bLlng = longitude - 1;
 	 
 	// NATIVE JSON OF LAT & LONG & CALCULATED BOUNDARIES
	var coords = {'lat':position.coords.latitude,'long':position.coords.longitude, 'tRlat':tRlat, 'tRlng':tRlng, 'bLlat':bLlat, 'bLlng':bLlng}; 
	
	// IF JSON EXISTS, INITALIZE THE MAP WITH CORRECT COORDINATES AS MAP CENTER, ELSE RUN MODAL TO GRAB ZIP CODE	
	if(coords){  
		initialize(coords);  
	} else { 
		handle_error();  
	}	

}
	
	
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
													
			// DEFINE COORDINATES OBJECT WITH LAT AND LONG 
			var coords = {'lat':results[0].geometry.location.lat(),
						  'long':results[0].geometry.location.lng(), 
						  'tRlat':topRight.lat(),
						  'tRlng':topRight.lng(), 
						  'bLlat': bottomLeft.lat(),
						  'bLlng':bottomLeft.lng()}; 
						  
			// HIDE MODAL BEFORE INITIALIZING NEW MAP
			jQuery('#zipcode').modal('hide');
		} else {
			// IF NO COORDINATES OR ERROR IN GEOCODING, SET MAP OBJECT TO EQUATOR
			var coords = {'lat':0,
						  'long':0,
						  'topRightLat':0,
						  'topRightLng':0, 
						  'bottomLeftLat':0,
						  'bottomLeftLng':0};
		}
		// INITALIZE THE MAP WITH ZIP CODE COORDINATES
		initialize(coords);
		
	});
} 


     
function initialize(coords) { 
   	// TURN JSON COORDINATE OBJECT INTO PARAMETERS TO SEND TO AJAX
    var serializedCoords = jQuery.param(coords); console.log(serializedCoords);
  	
  	// DEFINE CERTAIN VARIABLES USED TO BUILD PAGE STRUCTURE
  	var height = jQuery(window).height();
	var nav = jQuery('.header nav').height();
	var trueHeight = height - nav; 
	var mapBox = jQuery('#map-canvas');
	var leftCol = jQuery('.leftCol');
	
	// ADD HEIGHT OF PAGE TO MAP			 
	mapBox.css('height', trueHeight);
	leftCol.css('height', trueHeight);
    
    // SET MAP OPTIONS DEPENDING ON GEOLOCATION METHOD      
    var mapOptions = {
       center: new google.maps.LatLng(coords.lat, coords.long),
       zoom: 10,
       mapTypeId: google.maps.MapTypeId.ROADMAP
    };
        
    // BUILD MAP WITH WHATEVER CURRENT VARIABLES AND DATABASE INFORMATION IS PRESENT
    var map = new google.maps.Map(document.getElementById("map-canvas"),mapOptions);
    
    // WITH JSON PARAMS, CALL FOR SIGHTINGS WITHIN THE VIEWPORT DEFINED BY BROWSER LOCATION OR ZIP CODE 
    jQuery.ajax({
	    url: "findSightings.php",
	    dataType:'json',
	    data: serializedCoords,
		success: function(data){
			// IF DATA IS RETURNED, BEGIN PARSING IT AND ADDING MARKERS TO THE MAP
			if(data){ 		
				build_sightings_list(map, data);
			}	
		}
    });
} // END INITALIZE FUNCTION
	
	
function add_map_markers(map, id, year, species_id, lat, lng) {

	var contentString = '<div class="google-info-window" id="info-window">'+'<h3>'+ species_id +'</h3>'+'<div class="info-window-content">'+
	  '<h5>'+id+'</h5> '+'<p>(Data recorded in '+year+').</p>'+'</div>'+'</div>';
	
	var marker = new google.maps.Marker({
	   position: new google.maps.LatLng(lat, lng),
	   map: map
	});	
	     
	var infowindow = new google.maps.InfoWindow({
	  content: contentString
	});
	
	// ADD CLICK LISTENER ON MARKERS. CLICK SHOWS INFO WINDOW
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker);
	});	
}

function open_info_window(id){
	
	infowindow.open(map,marker);
	
}


function build_sightings_list(map,data){ 
			
    for ( var i = 0; i < data.length; i++) {
    
    	var sightingsHTML = '<li><a href="#" onclick="open_info_window('+data[i].Id+');" id="'+data[i].Id+'"><h4>'+data[i].species_id+'</h4></a></li>';
    	
    	jQuery('#sightingsPanel').append(sightingsHTML);
    	
    	var id = data[i].Id;
    	var year = data[i].year;
    	var species_id = data[i].species_id;
    	var lat = data[i].lat;
    	var lng = data[i].long;
		
		add_map_markers(map, id, year, species_id, lat, lng);
				
	}	
	
}

				
  //google.maps.event.addDomListener(window, 'load', initialize);
      
	</script>

</body>
</html>
