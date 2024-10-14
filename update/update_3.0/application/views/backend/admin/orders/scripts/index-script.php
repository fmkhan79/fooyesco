<!-- DATE RANGE PICKER JS-->
<script src="<?php echo base_url('assets/backend/plugins/moment/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backend/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
<!-- DataTables -->
<script src="<?php echo base_url('assets/backend/'); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/backend/'); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets/backend/'); ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url('assets/backend/'); ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url('assets/backend/'); ?>plugins/select2/js/select2.full.min.js"></script>
<!-- Initializer -->
<script src="<?php echo base_url('assets/backend/'); ?>js/init.js"></script>

<script type="text/javascript">
    "use strict";
    //Date range as a button
    initDateRangePicker(['daterange-btn']);

    // initialize datatable
    initDataTables(['orders'], 5);

    // initialize select2
    initSelect2();

    // initialize tooltips
    initToolTip();
</script>

<!-- live order script -->
<?php if ($order_type == "live") : ?>
    <script type="text/javascript">
        "use strict";

        var previousOrders;

        setInterval(() => {

            if (!previousOrders) {
                previousOrders = '<?php echo json_encode($orders); ?>';
            }

            $.ajax({
                url: '<?php echo site_url('orders/live/data'); ?>',
                success: function(newOrders) {

                    const newOrdersObj = JSON.parse(newOrders);
                    const previousOrdersObj = JSON.parse(previousOrders);

                    if (Object.keys(JSON.stringify(newOrdersObj.pending)).length > Object.keys(JSON.stringify(previousOrdersObj.pending)).length) {
                        // YOU CAN ADD ALERT CODE HERE FOR FUTURE.
                    }

                    if (JSON.stringify(newOrders) === JSON.stringify(previousOrders)) {
                        // nothing changed yet
                    } else {

                        previousOrders = newOrders;

                        $.ajax({
                            url: '<?php echo site_url('orders/live/view'); ?>',
                            success: function(liveOrders) {
                                $("#live-order-data").html(liveOrders);
                                // GET THE NUMBER OF PENDING ORDERS
                                $.ajax({
                                    url: '<?php echo site_url('orders/get_number_of_orders/pending'); ?>',
                                    success: function(numberOfPendingOrders) {
                                        $("#number-of-pending-orders-in-navbar").html(numberOfPendingOrders);
                                    }
                                });
                                // GET THE NUMBER OF PENDING ORDERS FOR TODAY
                                $.ajax({
                                    url: '<?php echo site_url('orders/get_number_of_todays_pending_orders'); ?>',
                                    success: function(numberOfPendingOrdersToday) {
                                        $("#number-of-pending-orders-in-navigation").html(numberOfPendingOrdersToday);
                                    }
                                });
                            }
                        });
                    }
                }
            });
        }, 5000);
    </script>
<?php endif; ?>