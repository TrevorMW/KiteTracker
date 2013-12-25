<?php include('assets/inc/header.php');?>

	<div class="col-lg-12 rightCol">
    <nav class="navbar navbar-default" role="navigation" draggable="true" id="css-toolbar">
          <div id="js-sightingsList" class="panel panel-default" style="display:none;">
              <div class="panel-heading">
                  <h4 style="margin:0">Sightings List <span class="label" id="resultNum">Default</span></h4>
              </div>
              <ul class="panel-body"></ul>
          </div>
          <ul class="nav navbar-nav">
              <li><a href="#" id="legend" title="Marker Legend"><span class="glyphicon glyphicon-map-marker"></span></a></li>
              <li id="legendBox" style="width:0;height:100%;overflow:hidden"><a href="" style="background:#ddd;border-right:1px solid #ccc; border-left:1px solid #ccc;">Hello</a></li>
              <li><a href="#" title="Open Sightings List" id="sightingsPanelTrigger"><span class="glyphicon glyphicon-list"></span></a></li>
          </ul>
          <form class="navbar-form navbar-left" role="search" id="changeZip">
              <div class="form-group">
                  <input type="text" id="newZip" class="form-control input-sm" data-toggle="" placeholder="Change Zip Code">
              </div>
              <button type="submit" class="btn btn-default btn-sm">Submit</button>
          </form>
      </nav>
    <div id="map-canvas"></div>
	</div>

<script type="text/javascript">

jQuery(document).on('click','#legend',function(){
   var legend =  jQuery('#legendBox');
   if(legend.hasClass('open')){
       legend.css('width', '0px').removeClass('open');
   } else {
       legend.addClass('open').css('width', '400px');
   }
});

jQuery(document).on('click','#sightingsPanelTrigger',function(){
    var height = jQuery(window).height() * .75;
    jQuery('#js-sightingsList').css('height', height).slideToggle();
});

// CHANGE ZIP CODE AFTER INITIAL RENDER OF RESULTS
jQuery('#changeZip').submit(function(event){
	event.preventDefault();
	// GRAB NEW ZIP CODE
  jQuery('#js-sightingsList ul').html('');
	var zip = jQuery(this).find('input[type="text"]').val();
	// PASS NEW ZIP CODE THROUGH GEOCODER > INITIALIZE > BUILD_SIGHTINGS
    if(zip != ''){
        geocode_zip(zip);
    } else {
       jQuery(this).find('.form-group').addClass('has-error').find('input').attr('placeholder','Please Enter Zip Code');
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
function initialize(coordinates, zoom){
   currentzoom = zoom;
	// HIDE ANY PREVIOUS MESSAGES
	jQuery('#resultsMsg').html('').hide();

  // DEFINE CERTAIN VARIABLES USED TO BUILD PAGE STRUCTURE
	var trueHeight = jQuery(window).height() - jQuery('.header nav').height();
	var mapBox = jQuery('#map-canvas');
	var leftCol = jQuery('.leftCol');

	// ADD HEIGHT OF PAGE TO MAP
	mapBox.css('height', trueHeight);

  var center = new google.maps.LatLng(coordinates.lat, coordinates.lng);

  if(currentzoom != null){
     zoomLevel = zoom;
  }  else {
     zoomLevel = 12;
  }

  // SET MAP OPTIONS DEPENDING ON GEOLOCATION METHOD
  var mapOptions = {
        center: center,
        zoom: zoomLevel,
        mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  // BUILD MAP WITH WHATEVER CURRENT VARIABLES AND DATABASE INFORMATION IS PRESENT
  var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

  var bounds = map.getBounds();

  if(bounds){
    var tRlat = bounds.getNorthEast().lat();
    var bLlat = bounds.getSouthWest().lat();
    var tRlng = bounds.getNorthEast().lng();
    var bLlng = bounds.getSouthWest().lng();

    var coords = {"tRlat":tRlat, "tRlng":tRlng, "bLlat":bLlat, "bLlng":bLlng};

    var serializedCoords = jQuery.param(coords);

  }

  google.maps.event.addListener(map, 'dragend', function() {
     var coordinates = {'lat':map.center.lat(),'lng':map.center.lng()};
     var zoom = map.getZoom();
     map.setZoom(zoom);
     jQuery('#js-sightingsList ul').html('');
     initialize(coordinates, zoom);
  });

  google.maps.event.addDomListener(map,'zoom_changed', function() { alert('zoomed');
      google.maps.event.addListenerOnce(map, 'idle', function () {
        var zoom = map.getZoom();
        map.setZoom(zoom);
        var coordinates = {'lat':map.center.lat(),'lng':map.center.lng()};
        jQuery('#js-sightingsList ul').html('');
        initialize(coordinates, zoom);
      });
  });

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
            build_sightings_list(map, data);
        }
    }
});

}

function add_map_markers(map, sightingObject, i, gmarkers) {

	// BUILD MARKUP FOR EACH MARKER INFOWINDOW
	var contentString = '<div class="google-info-window" id="info-window">'+'<h3>'+ sightingObject['species_name'] +'</h3>'+'<div  class="info-window-content">'+
	  '<h5>'+ sightingObject['id'] +'</h5> '+'<p>(Sighting occured in '+ sightingObject['county'] +' county).</p>'+'</div>'+'</div>';
	// DEFINE MARKER CHARACTERISTICS
	var marker = new google.maps.Marker({
	   position: new google.maps.LatLng(sightingObject['lat'], sightingObject['lng']),
	   map: map,
	   animation:google.maps.Animation.DROP
	});

	// DEFINE INFO WINDOW PARAMETERS
	var infoWindow = new google.maps.InfoWindow({
	  content: contentString
	});


  google.maps.event.addListener(marker, 'click', function() {
      infoWindow.setContent(contentString);
      infoWindow.open(map, marker);
  });

  function myclick(i) {
      google.maps.event.trigger(gmarkers[i], "click");
  }

}


function build_sightings_list(map,data){
   var i = 0;
   var gmarkers = [];
 	 // LOOP THROUGH DATA TO BUILD SIDEBAR LIST
   var numResults =  jQuery('span#resultNum');
    numResults.text(data.length);
    numResults.removeClass('label-success').removeClass('label-danger');

    if(data.length <= 0){
        numResults.addClass('label-danger');
    } else {
        numResults.addClass('label-success');
    }
    console.log(data.length);
    for ( var j = 0; j < data.length; j++) {

        var sightingsHTML = '<li id="'+data[j].sample_event_id+'">'+
        '<a href="#" onclick="myclick('+data[j].sample_event_id+');" class="infoWindowHandler"> '+
        '<h4><span class="glyphicon glyphicon-comment infowWindowHandler"></span>&nbsp;'+data[j].sample_event_id+'</h4></a></li>';

        jQuery('#js-sightingsList ul').append(sightingsHTML);

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

        setTimeout(add_map_markers, j++ * 10, map, sightingObject, i, gmarkers)
    }


}















</script>


<?php include('assets/inc/footer.php'); ?>