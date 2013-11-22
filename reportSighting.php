<?php include('assets/inc/header.php');
include('functions.php');
$currentMonth = date('F'); ?>
<div class="wrapper alert alert-info" id="formMsg"></div>
<div class="wrapper sighting-form" style="padding:15px 0;">
<div class="col-lg-3">
    <form id="sightingWhen" method="post" class="one" data-form-number="1">
        <fieldset class="panel panel-default open">
            <header class="panel-heading">When did this sighting occur?</header>
            <ul class="panel-body">
                <li class="half"><label>Month:</label>
                    <select name="month">
                        <?php for ($m = 1; $m <= 12; $m++) {
                        $month = date("F", mktime(0, 0, 0, $m));
                        if ($currentMonth === $month) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        };
                        echo "<option value='$m' " . $selected . "> $month</option>";
                    }?></select></li>
                <li class="half"><label>Date:</label>
                    <select name="day">
                        <?php $currentDate = date('j');
                        $currentMonth = get_day_number($currentMonth); for ($m = 1; $m <= $currentMonth; $m++) {
                        if ($currentDate == $m) {
                            $sel = "selected";
                        } else {
                            $sel = '';
                        };
                        echo "<option value='$m' " . $sel . ">$m</option>";
                    }?></select></li>
                <li class="half">
                    <label>Year:</label> <?php $year = str_replace('20', '', date('Y')); $endyear = $year + 10;?>
                    <select name="year">
                        <?php  for ($m = $year; $m <= $endyear; $m++) {
                        echo "<option value='20$m' >20$m</option>";
                    }?> </select></li>
                <li class="half"><label>Time:</label>
                    <select name="sightingTime">
                        <?php  for ($m = 1; $m <= 12; $m++) {
                        echo "<option value='$m'>$m:00 am</option>";
                    }
                        for ($m = 1; $m <= 12; $m++) {
                            echo "<option value='$m'>$m:00 pm</option>";
                        }?></select></li>
            </ul>
            <footer class="panel-footer">
                <div class="btn-group">
                    <button class="save btn btn-default btn-xs" type="submit">Save</button>
                    <button class="edit btn btn-default btn-xs" style="display:none;">Edit</button>
                </div>
            </footer>
        </fieldset>
    </form>
    <form id="sightingsObservation" class="two" method="post" data-form-number="3">
        <fieldset class="panel panel-default">
            <header class="panel-heading">Observation Details:</header>
            <ul class="panel-body">
                <li>
                    <label>Number of Kites seen:</label>
                    <select name="numberSpotted">
                        <?php  for ($m = 1; $m <= 20; $m++) {
                        echo "<option value='$m'>$m</option>";
                    } ?>
                    </select>
                </li>
                <li>
                    <label>Was a <a href="#" class="tooltip" data-info="">nest</a> observed?</label>
                    <ul class="multi">
                        <li><input type="radio" name="nestObserved" value="0"/><span>Yes</span></li>
                        <li><input type="radio" name="nestObserved" value="1"/><span>No</span></li>
                    </ul>
                </li>
                <li>
                    <label>Please check all that apply:</label>
                    <ul class="multi">
                        <li><input type="checkbox" name="vehicle" value="Soaring"/><a href="#" class="infoWindow"
                                                                                      data-toggle="popover"
                                                                                      title="Soaring!"
                                                                                      data-content="This bird is Soaring"><label>Soaring</label></a>
                        </li>
                        <li><input type="checkbox" name="vehicle" value="Perching"/><a href="#" class="infoWindow"
                                                                                       data-toggle="popover"
                                                                                       title="Perching"
                                                                                       data-content="This bird is perching"><label>Perching</label></a>
                        </li>
                        <li><input type="checkbox" name="vehicle" value="Carry Nest Materials"/><span><a href="#"
                                                                                                         class="tooltip"
                                                                                                         data-info="">Carrying
                            Nest Materials (sticks, Spanish Moss)</a></span></li>
                        <li><input type="checkbox" name="vehicle" value="Vocalizing"/><span><a href="#" class="tooltip"
                                                                                               data-info="">Vocalizing</a></span>
                        </li>
                        <li><input type="checkbox" name="vehicle" value="Flapping"/><span><a href="#" class="tooltip"
                                                                                             data-info="">Flapping</a></span>
                        </li>
                        <li><input type="checkbox" name="vehicle" value="Foraging over open Habitat"/><span><a href="#"
                                                                                                               class="tooltip"
                                                                                                               data-info="">Foraging
                            over open habitat (please describe in comments)</a></span></li>
                        <li><input type="checkbox" name="vehicle" value="Foraging over forest"/><span><a href="#"
                                                                                                         class="tooltip"
                                                                                                         data-info="">Foraging
                            over forest habitat</a></span></li>
                    </ul>
                </li>
            </ul>
            <footer class="panel-footer">
                <div class="btn-group">
                    <button class="save btn btn-default btn-xs" type="submit">Save</button>
                    <button class="edit btn btn-default btn-xs" style="display:none;">Edit</button>
                </div>
            </footer>
        </fieldset>
    </form>
</div>

<div class="col-lg-9">
<form id="sightingLocation" class="" method="post" data-form-number="2">
<fieldset class="panel panel-default">
<header class="panel-heading">Location:
    <a href="#" onclick="initialize();" id="resetMap" class="btn btn-xs btn-default pull-right">Reset Map
        <span class="glyphicon glyphicon-refresh"></span></a>
</header>
<div class="panel-body">
    <ul class="col-lg-4">
        <li class="half">
            <label>State:</label>
            <select name="state">

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
        </li>
        <li class="half">
            <label>County:</label>
            <input type="text" name="county" class="form-control" data-regex="" placeholder=""/>
        </li>
        <li class="full">
            <label></label>

        </li>
    </ul>
    <div class="map col-lg-8">
        <ul>
            <li class="quarter">
                <label>Latitude:</label>
                <input type="text" id="locationLat" class="form-control" name="sightingLat" value=""/>
            </li>
            <li class="quarter">
                <label>Longitude:</label>
                <input type="text" id="locationLng" class="form-control" name="sightingLng" value=""/>
            </li>
        </ul>
        <div class="" id="map-canvas" style="border:1px solid #ccc;height:300px"></div>
    </div>
</div>
<footer class="panel-footer">
    <div class="btn-group">
        <button class="save btn btn-default btn-xs" type="submit">Save</button>
        <button class="edit btn btn-default btn-xs" style="display:none;">Edit</button>
    </div>
</footer>
</fieldset>
</form>
</div>
</div>
<script>

    jQuery('a.infoWindow').popover({
        animation:true,
        placement:'right',
        trigger:'hover'
    });

    jQuery('#formMsg').hide();

    function supports_html5_storage() {
        try {
            return 'localStorage' in window && window['localStorage'] !== null;
        } catch (e) {
            return false;
        }
    }

    // ON SAVE BUTTON CLICK, FIND NEAREST FORM, THEN BEGIN VALIDATION
    jQuery(document).on('click', 'button.save', function (event) {
        event.preventDefault();
        var form = jQuery(this).closest('form');
        var btn = jQuery(this);
        var formNumber = form.attr('data-form-number');
        if (form.hasClass('done') == false) {
            var formData = form.serializeArray();
            var storage = supports_html5_storage();
            manage_form_data(form, btn, formNumber, formData, storage);
        }

    });

    function manage_form_data(form, btn, formNumber, formData, storage) {
        if (true) {
            if (storage == true) {
                for (var i = 0; i < formData.length; i++) {
                    localStorage.setItem(JSON.stringify(formData[i].name), JSON.stringify(formData[i].value));
                }
                ;
                form.addClass('done').find('.panel-body').slideUp('slow', function () {
                    form.find('fieldset').addClass('panel-success');
                    form.find('button.edit').show();
                    btn.removeClass('btn-default').addClass('btn-success').text('Saved!');
                });

                var formNumber = parseInt(formNumber) + 1;
                var nextForm = jQuery(document).find('[data-form-number="' + formNumber + '"]');
                nextForm.find('.panel-body').slideDown('slow', function () {
                    nextForm.find('footer button.save').show();
                    initialize();
                });
            } else {
                cookie_storage(formData);
            }
        }
    }

    function initialize() {
        var lat = localStorage.getItem('latitude');
        var lng = localStorage.getItem('longitude');
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

    }


</script>

<?php include('assets/inc/footer.php'); ?>