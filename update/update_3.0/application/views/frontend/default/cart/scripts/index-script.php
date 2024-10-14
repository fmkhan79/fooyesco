<!-- Leaflet JS -->
<script src="<?php echo base_url('assets/global/leaflet/leaflet.js'); ?>"></script>

<script>
    "use strict";
    // CART OPERATIONS
    function updateCart(cartId, isIncreased) {
        var currentQuantity = $('#cart-quantity-' + cartId).text();

        // SHOWING PLACEHOLDERS
        $(".summary-loader").removeClass('d-none');
        $('#sub-total-' + cartId).html('<i class="fas fa-spinner fa-pulse"></i>');
        $('.cart-actions').prop('disabled', true);

        if (isIncreased) {
            currentQuantity = parseInt(currentQuantity) + 1;
        } else {
            currentQuantity = parseInt(currentQuantity) - 1;
            if (currentQuantity == 0) {
                currentQuantity = 1;
            }
        }
        $('#cart-quantity-' + cartId).text(currentQuantity);

        $.ajax({
            url: '<?php echo site_url('cart/update_cart'); ?>',
            type: 'POST',
            data: {
                cartId: cartId,
                quantity: currentQuantity,
            },
            success: function(updatedPrice) {
                $('#sub-total-' + cartId).text(updatedPrice);
                $.ajax({
                    url: '<?php echo site_url('cart/reload_cart_summary'); ?>',
                    success: function(response) {
                        $('#cart-summary').html(response);
                        $('.cart-actions').prop('disabled', false);
                        $(".summary-loader").addClass('d-none');
                    }
                });
            }
        });
    }


    // MAP 1 INITIALIZING
    var map = L.map('mapid1').setView([<?php echo !empty($customer_details['coordinate_1']['latitude']) ? floatval(sanitize($customer_details['coordinate_1']['latitude'])) : 0; ?>, <?php echo !empty($customer_details['coordinate_1']['longitude']) ? floatval(sanitize($customer_details['coordinate_1']['longitude'])) : 0; ?>], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    L.marker([<?php echo !empty($customer_details['coordinate_1']['latitude']) ? floatval(sanitize($customer_details['coordinate_1']['latitude'])) : 0; ?>, <?php echo !empty($customer_details['coordinate_1']['longitude']) ? floatval(sanitize($customer_details['coordinate_1']['longitude'])) : 0; ?>]).addTo(map)
        .bindPopup('<?php echo sanitize(!empty($customer_details['address_1']) ? $customer_details['address_1'] : get_phrase('not_found')); ?>');


    // MAP 2 INITIALIZING
    var map = L.map('mapid2').setView([<?php echo !empty($customer_details['coordinate_2']['latitude']) ? floatval(sanitize($customer_details['coordinate_2']['latitude'])) : 0; ?>, <?php echo !empty($customer_details['coordinate_2']['longitude']) ? floatval(sanitize($customer_details['coordinate_2']['longitude'])) : 0; ?>], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    L.marker([<?php echo !empty($customer_details['coordinate_2']['latitude']) ? floatval(sanitize($customer_details['coordinate_2']['latitude'])) : 0; ?>, <?php echo !empty($customer_details['coordinate_2']['longitude']) ? floatval(sanitize($customer_details['coordinate_2']['longitude'])) : 0; ?>]).addTo(map)
        .bindPopup('<?php echo sanitize(!empty($customer_details['address_2']) ? $customer_details['address_2'] : get_phrase('not_found')); ?>');

    // MAP 3 INITIALIZING
    var map = L.map('mapid3').setView([<?php echo !empty($customer_details['coordinate_3']['latitude']) ? floatval(sanitize($customer_details['coordinate_3']['latitude'])) : 0; ?>, <?php echo !empty($customer_details['coordinate_3']['longitude']) ? floatval(sanitize($customer_details['coordinate_3']['longitude'])) : 0; ?>], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    L.marker([<?php echo !empty($customer_details['coordinate_3']['latitude']) ? floatval(sanitize($customer_details['coordinate_3']['latitude'])) : 0; ?>, <?php echo !empty($customer_details['coordinate_3']['longitude']) ? floatval(sanitize($customer_details['coordinate_3']['longitude'])) : 0; ?>]).addTo(map)
        .bindPopup('<?php echo sanitize(!empty($customer_details['address_3']) ? $customer_details['address_3'] : get_phrase('not_found')); ?>');


    function toggleMap(addressNumber) {
        $(".address-map").hide();
        $("#mapid" + addressNumber).show();
        $("#address-number").val(addressNumber);
    }
    $(document).ready(() => {
        $("#mapid2").hide();
        $("#mapid3").hide();
        $("#address-number").val(1);
    });
</script>

<?php if ($this->session->flashdata('confirm_order') && $this->session->flashdata('order_code')) : ?>
    <script>
        "use strict";
        var orderCode = '<?php echo $this->session->flashdata('order_code'); ?>';
        $.ajax({
            url: '<?php echo site_url('orders/order_placing_mail/'); ?>' + orderCode
        });
    </script>
<?php endif; ?>