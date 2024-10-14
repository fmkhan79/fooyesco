<!-- Leaflet JS -->
<script src="<?php echo base_url('assets/global/leaflet/leaflet.js'); ?>"></script>
<script>
    "use strict";
    // MAP INITIALIZING
    var map = L.map('mapid').setView([<?php echo !empty($customer_details['coordinate_' . $order_data['customer_address_id']]['latitude']) ? floatval(sanitize($customer_details['coordinate_' . $order_data['customer_address_id']]['latitude'])) : 0; ?>, <?php echo !empty($customer_details['coordinate_' . $order_data['customer_address_id']]['longitude']) ? floatval(sanitize($customer_details['coordinate_' . $order_data['customer_address_id']]['longitude'])) : 0; ?>], 18);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    L.marker([<?php echo !empty($customer_details['coordinate_' . $order_data['customer_address_id']]['latitude']) ? floatval(sanitize($customer_details['coordinate_' . $order_data['customer_address_id']]['latitude'])) : 0; ?>, <?php echo !empty($customer_details['coordinate_' . $order_data['customer_address_id']]['longitude']) ? floatval(sanitize($customer_details['coordinate_' . $order_data['customer_address_id']]['longitude'])) : 0; ?>]).addTo(map)
        .bindPopup('<?php echo sanitize($customer_details['address_1']); ?>');
</script>
