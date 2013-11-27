<div class="wrapper alert alert-info" id="formMsg"></div>
<div class="wrapper sighting-form" style="padding:15px 0;">
<div class="col-lg-3">
    <div id="main">
        <h4>Upload Your Images</h4>
        <div class="alert" id="UploadError" style="display:none;"></div>
        <form method="post" enctype="multipart/form-data"  action="" id="imageUpload">
            <input type="file" name="images" id="images" />
            <button type="submit" class="btn btn-default btn-sm pull-right">Upload Files!</button>
        </form><br /><br />
        <div id="imgContainer" class="col-lg-12" style="height:200px;padding:0; border:2px dashed #bbb; border-radius:15px; overflow:hidden;"></div>
    </div><hr />


</div>
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

<form id="sightingWhen" method="post" class="one" data-form-number="1">
    <fieldset>
        <legend >When did this sighting occur?</legend>
        <label>Month:</label>
        <select name="month">
            <?php for ($m = 1; $m <= 12; $m++) {
            $month = date("F", mktime(0, 0, 0, $m));
            if ($currentMonth === $month) {
                $selected = "selected";
            } else {
                $selected = "";
            };
            echo "<option value='$m' " . $selected . "> $month</option>";
        }?></select>
        <label>Date:</label>
        <select name="day">
            <?php $currentDate = date('j');
            $currentMonth = get_day_number($currentMonth); for ($m = 1; $m <= $currentMonth; $m++) {
            if ($currentDate == $m) {
                $sel = "selected";
            } else {
                $sel = '';
            };
            echo "<option value='$m' " . $sel . ">$m</option>";
        }?></select>

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
                }?></select>

            <div class="btn-group">
                <button class="save btn btn-default btn-xs" type="submit">Save</button>
                <button class="edit btn btn-default btn-xs" style="display:none;">Edit</button>
            </div>
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

<div class="col-lg-9">
    <form id="sightingLocation" class="" method="post">
        <fieldset>
            <legend>Location:
                <a href="#" onclick="initialize();" id="resetMap" class="btn btn-xs btn-default pull-right">Reset Map
                    <span class="glyphicon glyphicon-refresh"></span></a>
            </legend>

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

            <label>County:</label>
            <input type="text" name="county" class="form-control" />



            <div class="btn-group">
                <button class="save btn btn-default btn-xs" type="submit">Save</button>
                <button class="edit btn btn-default btn-xs" style="display:none;">Edit</button>
            </div>
        </fieldset>
    </form>
</div>
</div>