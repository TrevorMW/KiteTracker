<?php include('assets/inc/header.php');
include('functions.php');
$currentMonth = date('F'); ?>
<script type="text/javascript" src="assets/scripts/filestyle.js"> </script>
<div class="wrapper report-sighting" style="padding:15px;">

    <form id="" class="" action="" method="post">

        <div class="col-lg-4"><fieldset>

            <legend>Step #1:</legend>

            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Upload Sighting Images</button>

        </fieldset></div>

       <div class="col-lg-4"> <fieldset>

            <legend>Step #2:</legend>



        </fieldset></div>



    </form>








</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Upload Sighting Photos</h4>
            </div>
            <div class="alert alert-full" id="UploadError" style="display:none;"></div>
            <div class="modal-body">
                <div id="main">
                    <form method="post" enctype="multipart/form-data"  action="" id="imageUpload">
                            <!--<input type="file" name="images" id="images" class="filestyle " data-input="false"/> -->
                        <input type="file" name="images" class="filestyle" id="fileInput">
                        <button type="submit" class="btn btn-default btn-sm pull-right ">Upload Image</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<script>

    jQuery(":file").filestyle({classButton: "btn btn-default btn-sm"});



    jQuery('#imageUpload').submit(function(event){ // CATCH FORM SUBMIT
        // PREVENT DEFAULT FORM FUNCTIONALITY
        event.preventDefault();
        // DEFINE FORM
        var form = jQuery(this);
        // GET FORMDATA FOR IMAGES TO SEND TO PHP SCRIPT
        var formData = new FormData(form[0]);
        // CALL AJAX AND POST DATA FROM FORM - RETURN VALUE IS A JSON STRING FROM IMGUR
        var uploadError = jQuery('#UploadError');
        // REMOVE ALL CLASSES FROM UPLOAD ERROR DIV
        uploadError.removeClass('alert-danger').removeClass('alert-success');
        // DISABLE FORM BUTTON WHILE UPLOADING
        form.find('button').html('Uploading...').prop('disabled', true);
        // START AJAX FUNCTION TO PUSH IMAGE DATA TO IMGUR PHP SCRIPT
        jQuery.ajax({
            url: 'assets/scripts/upload.php',
            type: 'POST',
            data: formData,
            async: false,
            success: function (imgurData) { // REGARDLESS OF WHAT IT IS, THERE WILL BE A RESPONSE
                // PARSE RESPONSE INTO JSON FORMAT
                var imgurData = JSON.parse(imgurData);

                if(imgurData.success == true){ // IF JSON OBJECT RETURNS TRUE, THEN IMGUR SENT THE RESPONSE
                    // BIND IMGUR LINK TO UPLOADED IMAGE - WILL BE STORED IN DATABASE
                    var imgLink = imgurData.data.link;
                    // APPEND NEWLY UPLOADED IMAGE TO A SPOT IN THE CURRENT APP TO LET THE USER KNOW IT WAS GOOD
                    form.append('<div id="imgContainer"></div>');
                    jQuery('#imgContainer').append('<img src="'+imgLink+'" style="width:100%; height:100%;" alt=""/>');
                    uploadError.html('<p>Upload Successful!</p>').addClass('alert-success').slideDown();
                    form.find('button').html('Upload Image').prop('disabled', false);
                    form.trigger('reset');
                } else { // HANDLE ANY ERRORS THROWN
                    uploadError.html('<p>'+imgurData.message+'</p>').addClass('alert-danger').slideDown();
                    form.find('button').html('Upload Image').prop('disabled', false);
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    jQuery('a.infoWindow').popover({
        animation:true,
        placement:'right',
        trigger:'hover'
    });


    function supports_html5_storage() {
        try {
            return 'localStorage' in window && window['localStorage'] !== null;
        } catch (e) {
            return false;
        }
    }



    /* function initialize() { // DEFINE LOCAL STORAGE VERSUS COOKIES HERE
        var lat = localStorage.getItem('storedLatitude');
        var lng = localStorage.getItem('storedLongitude');
        var coords = new google.maps.LatLng(lat, lng);
        jQuery('#locationLat').val(lat);
        jQuery('#locationLng').val(lng);
        var mapOptions = {
            center:coords,
            zoom:12
        };

        var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

        var marker = new google.maps.Marker({
            position:coords,
            map:map,
            animation:google.maps.Animation.DROP,
            draggable:true,
            title:'Draggable Coordinate Picker'
        });

        google.maps.event.addListener(marker, 'drag', function (event) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            jQuery('#locationLat').val(lat);
            jQuery('#locationLng').val(lng);
        });

    } */


</script>

<?php include('assets/inc/footer.php'); ?>