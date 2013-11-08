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
<?php include('functions.php'); $db = new Connection(); ?>

	<div class="wrapper header">
		<nav class="nav">
			<ul class="navbar">
				<li><a href="">About kites</a></li>
				<li><a href="">Recent sightings</a></li>
				<li><a href="">Report a sighting</a></li>
			</ul>
		</nav>
	</div>
	
	<div class="col-lg-3 leftCol">
	
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
	
	
function get_location() {
	// GET HTML5 BROWSER COORDINATES IS AVAILABLE
	var coordinates = navigator.geolocation.getCurrentPosition(show_map, handle_error);
}

function zip_error(){
	jQuery('#zipForm').prepend('<div id="zipError" class="alert alert-danger"><p></p></div>');
	jQuery('#zipError p').text('Please enter a valid Zip Code')
}
	

function show_map(position) {

    // GET LATITUTDE FROM BROWSER
 	var latitude = position.coords.latitude;
 	
 	// GET LONGITUTDE FROM BROWSER 
 	var longitude = position.coords.longitude; 
 	
 	// NATIVE JSON OF LAT & LONG
	var coords = {'lat':position.coords.latitude,'long':position.coords.longitude}; 
	
	// IF JSON EXISTS, INITALIZE THE MAP WITH CORRECT COORDINATES AS MAP CENTER, ELSE RUN MODAL TO GRAB ADDRESS	
	if(coords){  initialize(coords);  } else { manual_geolocation();  }	

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
			// DEFINE COORDINATES OBJECT WITH LAT AND LONG 
			var coords = {"lat":results[0].geometry.location.lat(),"long":results[0].geometry.location.lng()}; 
			// HIDE MODAL BEFORE INITIALIZING NEW MAP
			jQuery('#zipcode').modal('hide');
		} else {
			// IF NO COORDINATES OR ERROR IN GEOCODING, SET MAP OBJECT TO EQUATOR
			var coords = {"lat":"0","long":"0"}
		}
		// INITALIZE THE MAP WITH ZIP CODE COORDINATES
		initialize(coords);
	});
} 


     
  function initialize(coords) { 
     
  var height = jQuery(window).height();
	var nav = jQuery('.wrapper.header').height();
	var trueHeight = height - nav; 
	var mapBox = jQuery('#map-canvas');
	
	// ADD HEIGHT OF PAGE TO MAP			 
	mapBox.css('height', trueHeight);
    
    // SET MAP OPTIONS DEPENDING ON GEOLOCATION METHOD      
    var mapOptions = {
       center: new google.maps.LatLng(coords.lat, coords.long),
       zoom: 8,
       mapTypeId: google.maps.MapTypeId.ROADMAP
    };
           
    var map = new google.maps.Map(document.getElementById("map-canvas"),mapOptions, markser);
    
    var coordinates = coords;
    
    jQuery.ajax({
    	type: "GET",
	    url: "findSightings.php",
	    dataType:'JSON',
			data: coordinates,
			success: function(data){
				
				
			}
	    
	    
    })
    
    
    var markser = setMarkers(map);
    
    
    // for (var i =0; i < markerArray.length; i++) {
	
	}
	
	
	function setMarkers(map) {
	
		 var beaches = [
			['Bondi Beach', -33.890542, 151.274856, 4],
			['Coogee Beach', -33.923036, 151.259052, 5],
			['Cronulla Beach', -34.028249, 151.157507, 3],
			['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
			['Maroubra Beach', -33.950198, 151.259302, 1]
		];
		
		var image = {
		  url: 'images/beachflag.png',
		  size: new google.maps.Size(20, 32),
		  origin: new google.maps.Point(0,0),
		  anchor: new google.maps.Point(0, 32)
		};
		
		var shape = {
		    coord: [1, 1, 1, 20, 18, 20, 18 , 1],
		    type: 'poly'
		};
		  
		for (var i = 0; i < beaches.length; i++) {
		  var beach = beaches[i];
		  var myLatLng = new google.maps.LatLng(beach[1], beach[2]);
		  var marker = new google.maps.Marker({
		      position: myLatLng,
		      map: map,
		      icon: image,
		      shape: shape,
		      title: beach[0],
		      zIndex: beach[3]
		  });
		}
}

				
  //google.maps.event.addDomListener(window, 'load', initialize);
      
	</script>

</body>
</html>
