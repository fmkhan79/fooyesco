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

<!-- Add these CDN links before your script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<!-- Also add the CSS for the buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<script type="text/javascript">
    "use strict";
    //Date range as a button
    initDateRangePicker(['daterange-btn']);

    // initialize select2
    initSelect2();

    // initialize tooltips
    initToolTip();

    $(document).ready(function() {
        // Initialize DataTable with CSV export button
        $('#orders_table').DataTable({
            dom: '<"top"Bf>rt<"bottom"lip><"clear">',
            buttons: [
                {  
                    extend: 'csv',
                    text: 'Export CSV',
                    className: 'btn btn-primary',
                    exportOptions: {
                            columns: ':not(:last-child)'  
                        }
                }
            ],
            pageLength: 25,
            columnDefs: [
                {
                    targets: 0,
                    visible: true, 
                    orderData: [0, 1], 
                    orderable: false,
                }
            ],
            order: [[3, 'desc']]
        });

        $('#select-all').click(function () {
            $('.order-checkbox:not(:disabled)').prop('checked', this.checked);
        });

        $('#bulk-update-form').submit(function (e) {
            if ($('.order-checkbox:checked').length === 0) {
                alert('Please select at least one order.');
                e.preventDefault();
            }
        });

        const $form = $('#bulk-update-form');
        const $paidBtn = $('#bulk-paid-btn');
        const $unpaidBtn = $('#bulk-unpaid-btn');
        let selectedAction = '';

        $paidBtn.on('click', function (e) {
            e.preventDefault();
            if ($('.order-checkbox:checked').length === 0) {
                alert('<?php echo get_phrase("please_select_at_least_one_order"); ?>');
                return;
            }
            selectedAction = $(this).data('action');
            $('#confirmModal').modal('show');
        });

        $unpaidBtn.on('click', function (e) {
            e.preventDefault();
            if ($('.order-checkbox:checked').length === 0) {
                alert('<?php echo get_phrase("please_select_at_least_one_order"); ?>');
                return;
            }
            selectedAction = $(this).data('action');
            $('#confirmModal').modal('show');
        });

        $('#confirmActionBtn').on('click', function () {
            $('#confirmModal').modal('hide');
            $form.attr('action', selectedAction);
            $form.submit();
        });

    });

    // initialize datatable with CSV export
    function initDataTables(arr, pageLength = 25) {
        arr.forEach(function(tableId) {
            $('#' + tableId).DataTable({
                dom: '<"top"Bf>rt<"bottom"lip><"clear">',
                buttons: [
                    {
                        extend: 'csv',
                        text: 'Export CSV',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ],
                "pageLength": pageLength,
                "language": {
                    "emptyTable": "No data available in table",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "Showing 0 to 0 of 0 entries",
                    "lengthMenu": "Show _MENU_ entries",
                    "search": "Search:",
                    "zeroRecords": "No matching records found"
                }
            });
        });
    }
</script>
