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
	
	
	<div class="modal fade" id="zipcode">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

	
	
	
	
	
 
	<script type="text/javascript">
	
	
	function get_location() {
  	var coordinates = navigator.geolocation.getCurrentPosition(show_map, handle_error);
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
	//
		
  	
  	if (err.code == 1) {
    	console.log(err);
    	jQuery('#zipcode').modal('show');
		}
		
	}
	
     
  function initialize(coords) {
  
  	var height = jQuery(window).height();
		var nav = jQuery('.wrapper.header').height();
		var trueHeight = height - nav; 
		var mapBox = jQuery('#map-canvas');
				 
		mapBox.css('height', trueHeight);
           
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
