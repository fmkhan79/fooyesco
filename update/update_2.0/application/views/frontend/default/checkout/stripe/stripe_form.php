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

<!-- Buy button -->
<div id="buynow" class="featured-btn-wrap text-right mt-3">
    <button type="submit" class="btn btn-danger btn-sm pl-5 pr-5 pt-2 pb-2 payment-form hidden" id="pay-with-stripe-form"><?php echo get_phrase("pay_with_stripe"); ?></button>
</div>

<?php include APPPATH . "views/frontend/default/checkout/scripts/stripe-script.php"; ?>

<!--Stripe API-->
<script>
var buyBtn = document.getElementById('pay-with-stripe-form');
var responseContainer = document.getElementById('stripePaymentResponse');

// Create a Checkout Session with the selected product
var createCheckoutSession = function (stripe) {
    return fetch("<?= site_url('checkout/pay_with_stripe/'.$_GET['address_number']); ?>", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            checkoutSession: 1,
        }),
    }).then(function (result) {
        return result.json();
    });
};

// Handle any errors returned from Checkout
var handleResult = function (result) {
    if (result.error) {
        responseContainer.innerHTML = '<p>'+result.error.message+'</p>';
    }
    buyBtn.disabled = false;
    buyBtn.textContent = 'Buy Now';
};

// Specify Stripe publishable key to initialize Stripe.js
var stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');

buyBtn.addEventListener("click", function (evt) {
    buyBtn.disabled = true;
    buyBtn.textContent = '<?php echo get_phrase("please_wait"); ?>...';

    createCheckoutSession().then(function (data) {
        if(data.sessionId){
            stripe.redirectToCheckout({
                sessionId: data.sessionId,
            }).then(handleResult);
        }else{
            handleResult(data);
        }
    });
});
</script>
