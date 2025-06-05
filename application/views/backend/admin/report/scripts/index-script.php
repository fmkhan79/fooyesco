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
    initDataTables(['commissions'], 25);

    // initialize select2
    initSelect2();

    // initialize tooltips
    initToolTip();

     $(document).ready(function() {

        $('#orders_table').DataTable({
            pageLength: 5,
            columnDefs: [
                {
                    targets: 0,
                    visible: true, 
                    orderData: [0, 1], 
                }
            ],
            order: [[0, 'desc']]
        });

        $('#select-all').click(function () {
            $('.order-checkbox').prop('checked', this.checked);
        });

        $('#bulk-update-form').submit(function (e) {
            if ($('.order-checkbox:checked').length === 0) {
                alert('Please select at least one order.');
                e.preventDefault();
            }
        });
    });
</script>
