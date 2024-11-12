<form action="<?php echo site_url('checkout/cash_on_delivery'); ?>" method="post" id="pay-with-cash-on-delivery-form" class="payment-form">
    <input type="hidden" name="address_number" value="<?php echo $_GET['address_number']; ?>">
      
    <!-- <div class="featured-btn-wrap text-right mt-3"><button type="submit" class="btn btn-dark btn-sm pl-5 pr-5 pt-2 pb-2 w-100 rr-btn border-0"><?php echo site_phrase('confirm_order', true); ?></button></div> -->

    <button class="payment-option w-100 bg-white">
      <input type="radio" name="payment" >
      <img src="assets/frontend/default/images/money.png" alt="payment">
      <span id="cash_button">
        <?php echo site_phrase('confirm_order', true); ?>
      </span>
</button>
</form>