<?php include('assets/inc/header.php'); include('functions.php'); $currentMonth = date('F');   ?>

<div class="wrapper sighting-form" style="padding:15px 0;">

    <div class="col-lg-3">

        <form id="sightingWhen" action="" method="post" class="">

            <fieldset class="panel panel-default">

            <header class="panel-heading">When did this sighting occur?</header>

            <ul class="panel-body">

            <li class="half"><label>Month:</label>
            <select name="month">
            <?php for($m = 1;$m <= 12; $m++){ $month =  date("F", mktime(0, 0, 0, $m));
                if($currentMonth === $month ){ $selected = "selected"; } else { $selected = "";};
                echo "<option value='$m' ".$selected."> $month</option>";
            }?></select></li>

            <li class="half"><label>Date:</label>
            <select name="day">
            <?php $currentDate = date('j');
                $currentMonth = get_day_number($currentMonth); for($m = 1;$m <= $currentMonth; $m++){
                if($currentDate == $m){ $sel = "selected"; } else { $sel = '';};
                echo "<option value='$m' ".$sel.">$m</option>";
            }?></select></li>

            <li class="half"><label>Year:</label> <?php $year = str_replace('20','',date('Y')); $endyear = $year + 10;?>
            <select name="year">
                <?php  for($m = $year;$m <= $endyear; $m++){
                echo "<option value='20$m' >20$m</option>";
            }?> </select></li>

            <li class="half"><label>Time:</label>
            <select name="year">
            <?php  for($m = 1;$m <= 12; $m++){
                echo "<option value='$m'>$m:00 am</option>";
            }
            for($m = 1;$m <= 12; $m++){
                echo "<option value='$m'>$m:00 pm</option>";
            }?></select></li>

            </ul>

            <footer class="panel-footer">
                <div class="btn-group ">
                    <button class="save btn btn-default btn-xs" type="submit">Save</button>
                </div>
            </footer>

        </fieldset>

        </form>

        <form id="sightingsObservation" class="" action="" method="">

        <fieldset class="panel panel-default">

            <header class="panel-heading">Observation Details:</header>

            <ul class="panel-body">

                <li></li>

                <li></li>

                <li></li>

            </ul>

            <footer class="panel-footer ">

                <div class="btn-group">

                     <button class="save btn btn-default btn-xs" type="submit">Save</button>
                    <button class="edit btn btn-default btn-xs" type="submit">Save</button>

                </div>

            </footer>

        </fieldset>

    </form>

    </div>

    <div class="col-lg-9">

        <form id="sightingLocation" class="" action="" method="">

            <fieldset class="panel panel-default">

                <header class="panel-heading">Location:</header>

                <ul class="panel-body">



                </ul>

                <footer class="panel-footer">

                    <ul>

                        <li><button class="btn btn-default btn-xs" type="submit">Save</button></li>

                        <li><button class="btn btn-default btn-xs" type="submit">Save</button></li>

                    </ul>

                </footer>

            </fieldset>

        </form>

    </div>

</div>

<script>
    function supports_html5_storage() {
        try {
            return 'localStorage' in window && window['localStorage'] !== null;
        } catch (e) {
            return false;
        }
    }

    jQuery('#sightingWhen').submit(function(event){
        event.preventDefault();
        var form = jQuery(this);
        var formData = form.serialize();
        var formData = JSON.stringify(formData);
        var storage = supports_html5_storage();
        if(storage == true){
            form.find('ul.panel-body').slideToggle();
            form.find('fieldset.panel').toggleClass('panel-default').toggleClass('panel-success');
            var formbutton = form.find('footer button');
            if(formbutton.length <= 1){
                form.find('footer.panel-footer').append('<button class="edit btn btn-default btn-xs">Edit</button>');
                form.find('footer button.save').html('Saved').toggleClass('btn-default').toggleClass('btn-success');
            } else {
                form.find('footer button.edit').hide();
                form.find('footer button.save').html('Save').toggleClass('btn-success').toggleClass('btn-default');
            }

        } else {

        }
        console.log(storage, formData);
    });


</script>

<?php include('assets/inc/footer.php'); ?>