<?php
// Stripe API configuration
$stripe_keys = get_payment_settings('stripe');
$values = json_decode($stripe_keys);
if ($values[0]->testmode == 'on') {
    $public_key = $values[0]->public_key;
    $private_key = $values[0]->secret_key;
} else {
    $public_key = $values[0]->public_live_key;
    $private_key = $values[0]->secret_live_key;
}

define('STRIPE_API_KEY', $private_key);
define('STRIPE_PUBLISHABLE_KEY', $public_key);
?>

<div id="stripePaymentResponse" class="text-danger"></div>

<input type="hidden" class="order_type" id="order_type" value="delivery">

<!-- Buy button -->
<div id="buynow" class="featured-btn-wrap text-right">
    <!-- <button type="submit" class="btn btn-dark btn-sm pl-5 pr-5 pt-2 pb-2 w-100 rr-btn border-0 mt-2" id="pay-with-stripe-form">
   
    </button> -->
    <button class="payment-option w-100 bg-white" id="pay-with-stripe-form">
      <input type="radio" name="payment" value="Stripe">
      <img src="assets/frontend/default/images/credit-card.png" alt="Stripe">
      <?php echo get_phrase("pay_with_stripe", true); ?>
    </button>
</div>

<!--Stripe API-->
<script src="https://js.stripe.com/v3/"></script>

<!--Stripe API-->
<script>
    var buyBtn = document.getElementById('pay-with-stripe-form');
    var responseContainer = document.getElementById('stripePaymentResponse');
    var order_type = document.querySelectorAll('input[name="order_type"]')[0].value;

    function loadFetchedUrl() {
        debugger;
        order_type = document.querySelectorAll('input[name="order_type"]')[0].value;
        // fetchedUrl = "<= site_url('GuestCheckout/pay_with_stripe' . $_GET['address_number'] . '/'); ?>" + order_type;
        if(order_type == "collection")
            order_type = "pickup";
        
        fetchedUrl = "<?= site_url('GuestCheckout/pay_with_stripe/1/'); ?>" + order_type;
        return fetchedUrl;
    }


    // Handle any errors returned from Checkout
    var handleResult = function(result) {
        if (result.error) {
            responseContainer.innerHTML = '<p>' + result.error.message + '</p>';
        }
        buyBtn.disabled = false;
        buyBtn.textContent = 'Buy Now';
    };

    // Specify Stripe publishable key to initialize Stripe.js
    var stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');

    buyBtn.addEventListener("click", function(evt) {
        var fetchedUrl = loadFetchedUrl();

        var createCheckoutSession = function(stripe) {
            return fetch(fetchedUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    checkoutSession: 1,
                }),
            }).then(function(result) {
                return result.json();
            });
        };


        buyBtn.disabled = true;
        buyBtn.textContent = '<?php echo get_phrase("please_wait"); ?>...';

        createCheckoutSession().then(function(data) {
            if (data.sessionId) {
                stripe.redirectToCheckout({
                    sessionId: data.sessionId,
                }).then(handleResult);
            } else {
                handleResult(data);
            }
        });
    });
</script>