<form action="<?php echo site_url('GuestCheckout/pay_with_paypal'); ?>" method="post" id="pay-with-paypal-form" class="payment-form hidden">
    <input type="hidden" name="address_number" value="<?php echo sanitize($_GET['address_number']); ?>">
    <input type="hidden" name="order_type" class="order_type" value="delivery">
    <div class="featured-btn-wrap text-right"><button type="submit" class="btn btn-dark btn-sm pl-5 pr-5 pt-2 pb-2 w-100 rr-btn border-0 mt-2"><?php echo site_phrase('pay_with_paypal', true); ?></button></div>
</form>