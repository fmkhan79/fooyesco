<form action="<?php echo site_url('GuestCheckout/cash_on_delivery'); ?>" 
      method="post" 
      id="pay-with-cash-on-delivery-form" 
      class="payment-form">

    <input type="hidden" name="address_number" value="<?php echo $_GET['address_number']; ?>">
    <input type="hidden" name="order_type" class="order_type" value="">

    <div class="featured-btn-wrap text-right mt-3">
        <button class="payment-option w-100 bg-white" id="order_completed_button">
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
    // Set order type in hidden input
    const orderType = localStorage.getItem("order-type") || "";
    const hiddenInput = document.querySelector("input.order_type");
    const form = document.getElementById("pay-with-cash-on-delivery-form");

    if (hiddenInput) {
      hiddenInput.value = orderType;
    }

    if (form) {
      const lowerOrderType = orderType.toLowerCase();
      if (lowerOrderType === "collection" || lowerOrderType === "pickup") {
        form.action = "<?php echo site_url('GuestCheckout/cash_on_collection'); ?>";
      } else {
        form.action = "<?php echo site_url('GuestCheckout/cash_on_delivery'); ?>";
      }
    }

    // Handle order completed button click
    const orderCompletedBtn = document.getElementById("order_completed_button");
    if (orderCompletedBtn) {
      orderCompletedBtn.addEventListener("click", function () {
        const currentOrigin = window.location.origin;

    if (currentOrigin === "https://www.fooyes.co.uk") {
        console.log("order_completed_button");

        // Send custom GA4 event
        gtag("event", "order_completed_via_cash", {
          event_category: "order_completed_button",
          event_label: "order_completed_button",
          value: 1,
        });
    }
      });
    }
  });
</script>