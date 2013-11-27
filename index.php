<?php include('assets/inc/header.php'); ?>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    // This identifies your website in the createToken call below
    Stripe.setPublishableKey('pk_test_czwzkTp2tactuLOEOqbMTRzG');
    // ...
</script>
<div class="wrapper home">
  <div class="container">
    <div class="col-lg-8">

    </div>
    <div class="col-lg-4">

        <form action="" method="POST" id="donationForm" class="form-horizontal">
            <span class="payment-errors"></span>

            <div class="form-group">
                <label>Card Number</label>
                <input type="text" class="form-control" data-stripe="number"/>
            </div>

            <div class="form-group">
                <label>CVC</label>
                <input type="text" class="form-control" data-stripe="cvc"/>
            </div>

            <div class="form-group">
                <fieldset> <legend>Expiration (MM/YYYY) </legend>

                <label>Month:</label>
                <select data-stripe="exp-month">
                    <?php for ($m = 1; $m <= 12; $m++) {
                    $month = date("F", mktime(0, 0, 0, $m));
                    if ($currentMonth === $month) {
                        $selected = "selected";
                    } else {
                        $selected = "";
                    };
                    echo "<option value='$m' " . $selected . "> $month</option>";
                }?></select>
                <label>Year:</label> <?php $year = str_replace('20', '', date('Y')); $endyear = $year + 10;?>
                <select data-stripe="exp-year">
                    <?php  for ($m = $year; $m <= $endyear; $m++) {
                    echo "<option value='20$m' >20$m</option>";
                }?> </select>
                </fieldset>
            </div>

            <button type="submit" class="btn btn-default btn-block">Submit Payment</button>
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

