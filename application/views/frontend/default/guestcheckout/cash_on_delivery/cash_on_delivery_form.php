<form action="<?php echo site_url('GuestCheckout/cash_on_delivery'); ?>" 
      method="post" 
      id="pay-with-cash-on-delivery-form" 
      class="payment-form">

    <input type="hidden" name="address_number" value="<?php echo $_GET['address_number']; ?>">
    <input type="hidden" name="order_type" class="order_type" value="">

    <div class="featured-btn-wrap text-right mt-3">
        <button class="payment-option w-100 bg-white">
            <input type="radio" name="payment">
            <img src="assets/frontend/default/images/money.png" alt="payment">
            <span id="cash_button">
                <?php echo site_phrase('confirm_order', true); ?>
            </span>
        </button>
    </div>
</form>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const orderType = localStorage.getItem("order-type") || "";
    const hiddenInput = document.querySelector("input.order_type");
    const form = document.getElementById("pay-with-cash-on-delivery-form");

    if (hiddenInput) {
        hiddenInput.value = orderType;
    }

    if (form) {
        if (orderType.toLowerCase() === "collection" || orderType.toLowerCase() === "pickup") {
            form.action = "<?php echo site_url('GuestCheckout/cash_on_collection'); ?>";
        } else {
            form.action = "<?php echo site_url('GuestCheckout/cash_on_delivery'); ?>";
        }
    }
});
</script>
