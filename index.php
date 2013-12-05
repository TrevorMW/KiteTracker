<?php include('assets/inc/header.php'); $currentMonth = date('F');  ?>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    // This identifies your website in the createToken call below
    Stripe.setPublishableKey('pk_test_czwzkTp2tactuLOEOqbMTRzG');
    // ...
</script>
<div class="wrapper home">
  <div class="row">
    <div class="col-lg-8">
        <div id="logo">
           <img src="" alt="" />
            <h1>Kite Tracker</h1>
        </div>
        <article class="main-content">
            <h1>What is Kite Tracker?</h1>


            <p>Kite Tracker is a non-profit interactive map and reporting system for individuals to report sightings of the Swallow-tailed Kites. Swallow-tailed Kites are rare in South Carolina, and efforts to ascertain the breeding stock of our state are ongoing. </p>
        </article>

    </div>
    <div class="col-lg-4">

        <form method="POST" id="donationForm">
            <span class="payment-errors"></span>
            <fieldset>
                <legend>#1</legend>
                <label class="fieldset-label">Donate to the project!</label>
            <div class="form-group">
                <label>Card Number</label>
                <input type="text" class="form-control input-sm" data-stripe="number"/>
            </div>

            <div class="form-group">
                <label>CVC</label>
                <input type="text" class="form-control input-sm" data-stripe="cvc"/>
            </div>


                 <label class="fieldset-class">Expiration (MM/YYYY) </label>
                <div class="form-group">
                <label>Month:</label>
                <select data-stripe="exp-month" class="form-control input-sm">
                    <?php for ($m = 1; $m <= 12; $m++) {
                    $month = date("F", mktime(0, 0, 0, $m));
                    $currentMonth === $month ?  $selected = "selected" : $selected = "";

                    echo "<option value='$m' " . $selected . "> $month</option>";
                }?></select>
                </div>
                <div class="form-group">
                <label>Year:</label> <?php $year = str_replace('20', '', date('Y')); $endyear = $year + 10;?>
                <select data-stripe="exp-year"  class="form-control input-sm">
                    <?php  for ($m = $year; $m <= $endyear; $m++) {
                    echo "<option value='20$m' >20$m</option>";
                }?> </select>
                </div>
            <button type="submit" class="btn btn-primary btn-block">Submit Payment</button>
            </fieldset>
        </form>

    </div>
  </div>
</div>

<script>

    jQuery('#donationForm').submit(function(event){
        // PREVENT DEFAULT FORM ACTION
        event.preventDefault();
        // FIND FORM AND BIND TO VARIABLE
        var form = jQuery(this);
        // DISABLE THE SUBMIT BUTTON TO AVOID MULTIPLE SUBMISSIONS
        form.find('button').prop('disabled', true);
        // ASK STRIPE TO CREATE A TOKEN FOR THE REQUEST, AND THEN ISSUE CALLBACK TO HANDLE RESPONSE
        Stripe.card.createToken(form, stripeResponseHandler);
    });

     function stripeResponseHandler(response, status){
         // BIND FORM TO VARIABLE
         var form = jQuery('#donationForm');
         // CONTROL STRUCTURE FOR ERROR HANDLING AND PROCESSING OF TRANSACTION
         if(response == 200){
            console.log(status.card.id);
             form.find('button').prop('disabled', false);
         } else {
             console.log(status.error.message);
         }
     }

</script>

<?php include('assets/inc/footer.php'); ?>

