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
    initDataTables(['orders']);

    // initialize tooltips
    initToolTip();

    // initialize select2
    initSelect2();

    // BEEP SOUND
    function playBeep() {
        var audio = new Audio(
            '<?php echo base_url('assets/backend/alert.mp3'); ?>');
        audio.play();
    }
</script>

<!-- LIVE ORDER SCRIPT -->
<?php if ($order_type == "today") : ?>
    <script type="text/javascript">
        var previousOrders;
        "use strict";

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
                        playBeep();
                    }

                    if (JSON.stringify(newOrders) === JSON.stringify(previousOrders)) {
                        // nothing changed yet
                    } else {

                        previousOrders = newOrders;

                        $.ajax({
                            url: '<?php echo site_url('orders/live/view'); ?>',
                            success: function(liveOrders) {
                                $("#live-order-data").html(liveOrders);
                            }
                        });
                    }
                }
            });
        }, 5000);
    </script>
<?php endif; ?>