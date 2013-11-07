<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Triage Practice</title>
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
			
			<ul class></ul>
			
		</nav>
		
	</div>
	
	<div class="col-lg-3 leftCol">
	
	</div>
	
	<div class="col-lg-9 rightCol">
		<div id="map-canvas"></div>
	</div>
	
 
	<script type="text/javascript">
	
	
	function get_location() {
  	var coordinates = navigator.geolocation.getCurrentPosition(show_map, manual_geolocation);
	}
	

	function show_map(position) {
	 	var latitude = position.coords.latitude; // GET LATITUTDE FROM BROWSER
	 	var longitude = position.coords.longitude; // GET LONGITUTDE FROM BROWSER
		var coords = {'lat':position.coords.latitude,'long':position.coords.longitude}; // NATIVE JSON OF LAT & LONG
  	// IF JSON EXISTS, INITALIZE THE MAP WITH CORRECT COORDINATES AS MAP CENTER, ELSE RUN MODAL TO GRAB ADDRESS	
		if(coords){  initialize(coords);  } else { manual_geolocation();  }	
	
	}
	
	function manual_geolocation(){
		
		
		
	}
	
     
  function initialize(coords) {
  
  	var height = jQuery(window).height();
		var nav = jQuery('.wrapper.header').height();
		var trueHeight = height - nav; 
		var mapBox = jQuery('#map-canvas');
				 
		mapBox.css('height', trueHeight);
  
  	//console.log(coords.lat);
          
     var mapOptions = {
       center: new google.maps.LatLng(coords.lat, coords.long),
       zoom: 8,
       mapTypeId: google.maps.MapTypeId.ROADMAP
     };
        
     var map = new google.maps.Map(document.getElementById("map-canvas"),mapOptions);
	
	}
				
  //google.maps.event.addDomListener(window, 'load', initialize);
      
	</script>

</body>
</html>
