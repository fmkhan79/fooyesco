<!-- DateRange -->
<link rel="stylesheet" href="<?php echo base_url('assets/backend/'); ?>plugins/daterangepicker/daterangepicker.css">
<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url('assets/backend/'); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/backend/'); ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url('assets/backend/'); ?>plugins/select2/css/select2.min.css">

<style>

.toggle-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 25px;
}
.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}
.slider {
    position: absolute;
    cursor: pointer;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 25px;
}
.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 4px;
    bottom: 3.5px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}
#testToggle:checked + .slider {
    background-color: #f54748; 
}
#testToggle:checked + .slider:before {
    transform: translateX(24px);
}


</style>