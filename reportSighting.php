<?php include('assets/inc/header.php');
include('functions.php');
$currentMonth = date('F'); ?>
<div class="wrapper report-sighting" style="padding:25px;">

<form method="post">
<div class="row">

    <div class="col-lg-3">

        <fieldset>

            <legend>Upload Sighting Images</legend>

            <small>If you have an image of the Swallow-Tailed Kite, you can upload it here.</small>

            <h4>#1</h4>

            <button class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#myModal">Upload!</button>

        </fieldset>

    </div>

    <div class="col-lg-3">

        <fieldset>

            <h4>#2</h4>

            <legend>Plot Sighting Location</legend>

            <small>To pinpoint the exact location of the sighting, drag the pin to the nearest possible spot.</small>


            <button class="btn btn-primary btn-sm btn-block" data-toggle="modal" id="googleModal">Plot!</button>

        </fieldset>

    </div>


    <div class="col-lg-6">

        <fieldset>

            <legend>Automatically generated values</legend>
            <h4>#3</h4>

            <div class="row">
            <div class="form-group col-lg-4">
                <label>Image Link:</label>
                <input type="text" value="" name="imageLink" id="imgurLink" class="form-control" disabled/>
            </div>

            <div class="form-group col-lg-4">
                <label>Latitude:</label>
                <input type="text" id="locationLat" class="form-control" name="sightingLat" value="" disabled/>
            </div>

            <div class="form-group col-lg-4">
                <label>Longitude:</label>
                <input type="text" id="locationLng" class="form-control" name="sightingLng" value="" disabled/>
            </div>
            </div>
        </fieldset>


    </div>


</div>

<div class="row">

<div class="col-lg-4">

    <fieldset>

        <h4>#4</h4>

        <legend>Sighting Date</legend>
        <div class="form-group">
            <label>Month:</label>
            <select name="month" class="form-control input-sm">
                <?php for ($m = 1; $m <= 12; $m++) {
                $month = date("F", mktime(0, 0, 0, $m));
                if ($currentMonth === $month) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                ;
                echo "<option value='$m' " . $selected . "> $month</option>";
            }?></select>
        </div>

        <div class="form-group"><label>Date:</label>
            <select name="day" class="form-control input-sm">
                <?php $currentDate = date('j');
                $currentMonth = get_day_number($currentMonth); for ($m = 1; $m <= $currentMonth; $m++) {
                if ($currentDate == $m) {
                    $sel = "selected";
                } else {
                    $sel = '';
                }
                ;
                echo "<option value='$m' " . $sel . ">$m</option>";
            }?></select>
        </div>
        <div class="form-group">
            <label>Year:</label> <?php $year = str_replace('20', '', date('Y')); $endyear = $year + 10;?>
            <select name="year" class="form-control input-sm">
                <?php  for ($m = $year; $m <= $endyear; $m++) {
                echo "<option value='20$m' >20$m</option>";
            }?> </select>
        </div>
        <div class="form-group"><label>Time:</label>
            <select name="sightingTime" class="form-control input-sm">
                <?php  for ($m = 1; $m <= 12; $m++) {
                echo "<option value='$m'>$m:00 am</option>";
            }
                for ($m = 1; $m <= 12; $m++) {
                    echo "<option value='$m'>$m:00 pm</option>";
                }?></select>
        </div>
        <hr />
        <div class="row">
            <div class="form-group col-lg-6">
                <label>State:</label>
                <select name="state" class="form-control input-sm">

                    <option value="Alabama">
                        Alabama
                    </option>
                    <option value="Alaska">
                        Alaska
                    </option>
                    <option value="Arizona">
                        Arizona
                    </option>
                    <option value="Arkansas">
                        Arkansas
                    </option>
                    <option value="California">
                        California
                    </option>
                    <option value="Colorado">
                        Colorado
                    </option>
                    <option value="Connecticut">
                        Connecticut
                    </option>
                    <option value="Delaware">
                        Delaware
                    </option>
                    <option value="Florida">
                        Florida
                    </option>
                    <option value="Georgia">
                        Georgia
                    </option>
                    <option value="Hawaii">
                        Hawaii
                    </option>
                    <option value="Idaho">
                        Idaho
                    </option>
                    <option value="Illinois">
                        Illinois
                    </option>
                    <option value="Indiana">
                        Indiana
                    </option>
                    <option value="Iowa">
                        Iowa
                    </option>
                    <option value="Kansas">
                        Kansas
                    </option>
                    <option value="Kentucky">
                        Kentucky
                    </option>
                    <option value="Louisiana">
                        Louisiana
                    </option>
                    <option value="Maine">
                        Maine
                    </option>
                    <option value="Maryland">
                        Maryland
                    </option>
                    <option value="Massachusetts">
                        Massachusetts
                    </option>
                    <option value="Michigan">
                        Michigan
                    </option>
                    <option value="Minnesota">
                        Minnesota
                    </option>
                    <option value="Mississippi">
                        Mississippi
                    </option>
                    <option value="Missouri">
                        Missouri
                    </option>
                    <option value="Montana">
                        Montana
                    </option>
                    <option value="Nebraska">
                        Nebraska
                    </option>
                    <option value="Nevada">
                        Nevada
                    </option>
                    <option value="New Hampshire">
                        New Hampshire
                    </option>
                    <option value="New Jersey">
                        New Jersey
                    </option>
                    <option value="New Mexico">
                        New Mexico
                    </option>
                    <option value="New York">
                        New York
                    </option>
                    <option value="North Carolina">
                        North Carolina
                    </option>
                    <option value="North Dakota">
                        North Dakota
                    </option>
                    <option value="Ohio">
                        Ohio
                    </option>
                    <option value="Oklahoma">
                        Oklahoma
                    </option>
                    <option value="Oregon">
                        Oregon
                    </option>
                    <option value="Pennsylvania">
                        Pennsylvania
                    </option>
                    <option value="Rhode Island">
                        Rhode Island
                    </option>
                    <option value="South Carolina">
                        South Carolina
                    </option>
                    <option value="South Dakota">
                        South Dakota
                    </option>
                    <option value="Tennessee">
                        Tennessee
                    </option>
                    <option value="Texas">
                        Texas
                    </option>
                    <option value="Utah">
                        Utah
                    </option>
                    <option value="Vermont">
                        Vermont
                    </option>
                    <option value="Virginia">
                        Virginia
                    </option>
                    <option value="Washington">
                        Washington
                    </option>
                    <option value="West Virginia">
                        West Virginia
                    </option>
                    <option value="Wisconsin">
                        Wisconsin
                    </option>
                    <option value="Wyoming">
                        Wyoming
                    </option>
                </select>
            </div>
            <div class="form-group col-lg-6">
                <label>County:</label>
                <input type="text" name="" placeholder="" class="form-control input-sm"/>
            </div>
        </div>
        <div class="form-group">
            <label>Please give a description of the area where the Kite was seen.</label>
            <textarea class="form-control" name="area-description"></textarea>
        </div>


    </fieldset>


</div>

<div class="col-lg-4">

    <fieldset>

        <h4>#5</h4>

        <legend>Quantitative Measurements</legend>

        <div class="form-group">
            <label>Number of Kites seen:</label>
            <select name="numberSpotted" class="form-control input-sm">
                <?php  for ($m = 1; $m <= 20; $m++) {
                echo "<option value='$m'>$m</option>";
            } ?>
            </select>

        </div>
        <fieldset>
            <legend>Was a <a href="#" class="" data-info="">nest</a> observed?</legend>
            <label class="radio-inline"><input type="radio" name="nestObserved" value="0"/>Yes</label>
            <label class="radio-inline"><input type="radio" name="nestObserved" value="1"/>No</label>
        </fieldset>

        <fieldset>
            <legend>Have you seen the kites more than once?</legend>
            <label class="radio-inline"><input type="radio" name="nestObserved" value="0"/>Yes</label>
            <label class="radio-inline"><input type="radio" name="nestObserved" value="1"/>No</label>
        </fieldset>

        <fieldset>
            <legend>Did your sighting occur during the SC Audubon boat survey?</legend>
            <label class="radio-inline"><input type="radio" name="nestObserved" value="0"/>Yes</label>
            <label class="radio-inline"><input type="radio" name="nestObserved" value="1"/>No</label>
        </fieldset>

        <fieldset>
            <legend>Did the observation occur on your property?</legend>
            <label class="radio-inline"><input type="radio" name="nestObserved" value="1"
                                               onclick="showAcres(1);"/>Yes</label>
            <label class="radio-inline"><input type="radio" name="nestObserved" value="0"
                                               onclick="showAcres(0);"/>No</label>

            <div class="form-group" id="showAcres" style="display:none;">
                <br />
                <label>How many acres do you manage?</label>
                <input type="number" name="acres-managed" class="form-control input-sm"/>
            </div>


        </fieldset>


    </fieldset>

</div>

<div class="col-lg-4">

    <fieldset>

        <h4>#6</h4>



        <fieldset>
            <legend>What was the bird doing?
                <small>(check all that apply)</small>
            </legend>
            <ul class="multi">
                <li><input type="checkbox" name="vehicle" value="Soaring"/><label><a href="#" class="infoWindow"
                                                                                     data-toggle="popover"
                                                                                     title="Soaring!"
                                                                                     data-content="This bird is Soaring">Soaring</a></label>
                </li>
                <li><input type="checkbox" name="vehicle" value="Perching"/><label><a href="#" class="infoWindow"
                                                                                      data-toggle="popover"
                                                                                      title="Perching"
                                                                                      data-content="This bird is perching">Perching</a></label>
                </li>
                <li><input type="checkbox" name="vehicle" value="Carry Nest Materials"/><label><a href="#"
                                                                                                  class="infoWindow"
                                                                                                  data-toggle="popover"
                                                                                                  title="Perching"
                                                                                                  data-content="Carrying Nest Materials (sticks, Spanish Moss)">Carrying
                    Nest Materials (sticks, Spanish Moss)</a></label></li>
                <li><input type="checkbox" name="vehicle" value="Vocalizing"/><label><a href="#" class="infoWindow"
                                                                                        data-toggle="popover"
                                                                                        title="Perching"
                                                                                        data-content="This bird is Vocalizing">Vocalizing</a></label>
                </li>
                <li><input type="checkbox" name="vehicle" value="Vocalizing"/><label><a href="#" class="infoWindow"
                                                                                        data-toggle="popover"
                                                                                        title="Perching"
                                                                                        data-content="This bird is Flapping">Flapping</a></label>
                </li>
                <li><input type="checkbox" name="vehicle" value="Foraging over open Habitat"/><label><a href="#"
                                                                                                        class="infoWindow"
                                                                                                        data-toggle="popover"
                                                                                                        title="Perching"
                                                                                                        data-content="This bird is Foraging over open habitat">Foraging
                    over open habitat</a></label></li>
                <li><input type="checkbox" name="vehicle" value="Foraging over forest"/><label><a href="#"
                                                                                                  class="infoWindow"
                                                                                                  data-toggle="popover"
                                                                                                  title="Perching"
                                                                                                  data-content="This bird is Foraging over forest habitat ">Foraging
                    over forest habitat </a></label></li>
            </ul>

        </fieldset>

        <fieldset>
            <legend>Would you be interested in hearing more about managing your land for Swallow-tailed Kites?</legend>
            <label class="radio-inline"><input type="radio" name="nestObserved" value="0"/>Yes</label>
            <label class="radio-inline"><input type="radio" name="nestObserved" value="1"/>No</label>
        </fieldset>


        <fieldset>
            <legend></legend>

        </fieldset>

    </fieldset>

</div>
</div>

</form>


</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Upload Sighting Photos</h4>
            </div>
            <div class="alert alert-full" id="UploadError" style="display:none;"></div>
            <div class="modal-body">
                <div id="main">
                    <form method="post" enctype="multipart/form-data" id="imageUpload">
                        <input type="file" name="images" id="fileInput" style="display:inline-block; width:70%;">
                        <button type="submit" class="btn btn-default btn-sm pull-right" id="uploadImageBtn">Upload
                            Image
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="locationPicker" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirm Sighting location</h4>
            </div>
            <div class="modal-body">
                <small>To show the location of the sighting, click and drag the marker to the closest point possible to
                    the sighting. Latitude and Longitude values will automatically be saved off.
                </small>
                <div id="map-canvas"
                     style="width:100%; height:350px; margin-top:10px; border:1px solid #ddd; display:block;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-block" data-dismiss="modal" aria-hidden="true">Done
                </button>
            </div>
        </div>
    </div>
</div>



<script>

    jQuery(document).ready(function () {
        jQuery('input[type="file"]').addClass('form-control input-sm')
    });

    jQuery(document).on('click', '#googleModal', function () {
        jQuery('#locationPicker').modal('show');
    });

    jQuery('#locationPicker').on('shown.bs.modal', function () {
        initialize();
    });

    function showAcres(num) {

        if (num == 1) {
            jQuery('#showAcres').slideDown();
        } else {
            jQuery('#showAcres').slideUp();
            return false;
        }
    }

    jQuery('#imageUpload').submit(function (event) { // CATCH FORM SUBMIT
        // PREVENT DEFAULT FORM FUNCTIONALITY
        event.preventDefault();
        // DEFINE FORM
        var form = jQuery(this);
        // FORM BUTTON
        var formBtn = form.find('button#uploadImageBtn');
        // DISABLE FORM BUTTON WHILE UPLOADING
        formBtn.text('Hello...').prop('disabled', true).prepend('<img src="http://www.bba-reman.com/images/fbloader.gif" alt=""/>');
        // GET FORMDATA FOR IMAGES TO SEND TO PHP SCRIPT
        var formData = new FormData(form[0]);
        // CALL AJAX AND POST DATA FROM FORM - RETURN VALUE IS A JSON STRING FROM IMGUR
        var uploadError = jQuery('#UploadError');
        // CREATE DIV FOR UPLOADED IAMGE
        var imageField = '<div id="imgContainer"></div>';
        // REMOVE ALL CLASSES FROM UPLOAD ERROR DIV
        uploadError.removeClass('alert-danger').removeClass('alert-success');
        // DELETE IMG FIELD AND CLEAR ALL HTML OUT OF IT
        jQuery('#imgContainer').html('').remove();
        // START AJAX FUNCTION TO PUSH IMAGE DATA TO IMGUR PHP SCRIPT
        jQuery.ajax({
            url:'assets/scripts/upload.php',
            type:'POST',
            data:formData,
            async:false,
            success:function (imgurData) { // REGARDLESS OF WHAT IT IS, THERE WILL BE A RESPONSE
                // PARSE RESPONSE INTO JSON FORMAT
                var imgurData = JSON.parse(imgurData);

                if (imgurData.success == true) { // IF JSON OBJECT RETURNS TRUE, THEN IMGUR SENT THE RESPONSE
                    // BIND IMGUR LINK TO UPLOADED IMAGE - WILL BE STORED IN DATABASE
                    var imgLink = imgurData.data.link;
                    // APPEND NEWLY UPLOADED IMAGE TO A SPOT IN THE CURRENT APP TO LET THE USER KNOW IT WAS GOOD
                    form.append(imageField);
                    jQuery('#imgContainer').append('<img src="' + imgLink + '" style="width:100%; height:100%;" alt=""/>');
                    uploadError.html('<p>Upload Successful!</p>').addClass('alert-success').slideDown();
                    formBtn.html('Upload Image').prop('disabled', false);
                    jQuery('#imgurLink').val(imgLink);
                    form.trigger('reset');
                } else { // HANDLE ANY ERRORS THROWN
                    uploadError.html('<p>' + imgurData.message + '</p>').addClass('alert-danger').slideDown();
                    formBtn.html('Upload Image').prop('disabled', false);
                }
            },
            cache:false,
            contentType:false,
            processData:false
        });
    });

    jQuery('a.infoWindow').popover({
        animation:true,
        placement:'bottom',
        trigger:'hover'
    });


    function supports_html5_storage() {
        try {
            return 'localStorage' in window && window['localStorage'] !== null;
        } catch (e) {
            return false;
        }
    }


    function initialize() {
        // CHECK FOR LOCAL STORAGE
        var storage = supports_html5_storage();
        // IF STORAGE ASSUME THERE IS A SET OF STORED COORDINATES
        if (storage == false) {
            var lat = localStorage.getItem('storedLatitude');
            var lng = localStorage.getItem('storedLongitude');
        } else { // ELSE ASSUME THERE IS A COOKIE WITH JSON OBJECT OF COORDINATES
            var cookieCoords = JSON.parse(jQuery.cookie('Kite_Tracker_Coordinates'));
            var lat = cookieCoords.lat;
            var lng = cookieCoords.lng;
        }
        // TAKE VALUES FROM EITHER LOCAL STORAGE OR COOKIE AND TURN THEM INTO COORDINATES TO RENDER MAP FROM
        var coords = new google.maps.LatLng(lat, lng);
        // TAKE LAT AND LONG VALUES AND ADD THEM TO INPUTS FOR FORM SUBMISSION
        jQuery('#locationLat').val(lat);
        jQuery('#locationLng').val(lng);
        // DEFINE MAP OPTIONS
        var mapOptions = {
            center:coords,
            zoom:12,
        };
        // DEFINE MAP WITH OPTIONS AND BIND TO CONTAINER
        var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

        // DEFINE A DRAGGABLE MARKER
        var marker = new google.maps.Marker({
            position:coords,
            map:map,
            animation:google.maps.Animation.DROP,
            draggable:true,
            title:'Draggable Coordinate Picker'
        });
        // LISTEN FOR MARKER DRAG AND UPDATE COORDINATES IN FORM FIELDS ON DRAG
        google.maps.event.addListener(marker, 'drag', function (event) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            jQuery('#locationLat').val(lat);
            jQuery('#locationLng').val(lng);
        });

    }


</script>

<?php include('assets/inc/footer.php'); ?>