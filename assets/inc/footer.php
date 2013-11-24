<script>

   // CONTROL STRUCTURE FOR LOADING UTILITIES AND RESOURCES ASSOCIATED WITH PAGES THAT REQUIRE A GOOGLE MAP
   // THE STRUCTURE CHECKS FOR HTML5 LOCAL STORAGE CAPABILITY AND HTML5 GEOLOCATION CAPABILITY.
   // IT ALSO PROVIDES FALLBACKS IN CASE EACH OF THESE ARE NOT AVAILABLE TO THE USER

   function page_load_checks(){
       //alert('Running Page Checks'); // CHECK TO SEE IF SET TIMEOUT IS WORKING CORRECTLY
       // IS LOCAL STORAGE SUPPORTED?
       var storage = supports_html5_storage();
       if(storage == true){
           // CHECK FOR STORED COORDINATES
           var coords = stored_coordinates();
           // INITIALIZE THE MAP ON EITHER PAGE
           initialize(coords);
       } else {
           // CHECK FOR STORED COOKIES WITH COORDINATES
           var coords = jQuery.cookie('Kite_Tracker_Coordinates');
           if(typeof coords == 'object'){
               // IF COOKIE OBJECT, INITALIZE MAP WITH COORDINATES
               initialize(coords);
           } else {
               // NO COOKIE PRESENT, SO TRY GEOLOCATION TO RETURN COORDINATES
               navigator.geolocation.getCurrentPosition(function(position) {
                   // GET LATITUTDE FROM BROWSER
                   var latitude = position.coords.latitude;
                   // GET LONGITUDE FROM BROWSER
                   var longitude = position.coords.longitude;
                   var coords = {"lat":latitude, "lng":longitude};
                   var local = supports_html5_storage();
                   if(local == false){
                       // SET VALUES INTO LOCAL STORAGE
                       localStorage.setItem('storedLatitude', coords.lat);
                       localStorage.setItem('storedLongitude', coords.lng);
                       initialize(coords);
                   } else {
                       // ALLOW JSON OBJECTS IN COOKIE
                       jQuery.cookie.json = true;
                       // CACHE OBJECT IN COOKIE FOR FURTHER USE
                       jQuery.cookie('Kite_Tracker_Coordinates', coords,  { expires: 1, path: '/' });
                       initialize(coords);
                   }

               }, ask_for_zip);

           }
       }
   }

    // SECONDARY AND TERTIARY FUNCTIONS BELOW ARE USED AS CHECKS AND UTILITIES IN CONTROL STRUCTURES ABOVE

   // IF USER DENIES ACCESS TO BROWSER GEOLOCATION, ASK FOR ZIPCODE
   function ask_for_zip(err) {
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

   /*

           // IF JSON EXISTS, INITALIZE THE MAP WITH CORRECT COORDINATES AS MAP CENTER, ELSE RUN MODAL TO GRAB ZIP CODE
           if(coords){
               initialize(coords);
           } else {
               handle_error();
           }*/

   // DOES THIS BROWSER SUPPORT LOCAL STORAGE (BOOLEAN RETURN VALUE)
   function supports_html5_storage() {
       try {
           return 'localStorage' in window && window['localStorage'] !== null;
       } catch (e) {
           return false;
       }
   }

   function stored_coordinates(){
      var lat =  localStorage.getItem('latitude');
      var lng =  localStorage.getItem('longitude');
      var JSONcoords = {"lat":lat, "lng":lng};
      return JSONcoords;
   }


    function load_map_utilities(){
        if(typeof initialize == 'function') {
            setTimeout(function(){
                page_load_checks();
            }, 500)
        }
    }
</script>
</body>
</html>