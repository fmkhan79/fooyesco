 <!-- jQuery first, then Popper.js, then Bootstrap JS -->
 <script src="<?php echo base_url('assets/frontend/default/js/jquery-3.2.1.min.js') ?>"></script>
 <script src="<?php echo base_url('assets/frontend/default/js/popper.min.js') ?>"></script>
 <script src="<?php echo base_url('assets/frontend/default/js/bootstrap.min.js') ?>"></script>
 <!-- Toastr -->
 <script src="<?php echo base_url() . 'assets/global/toastr/toastr.min.js'; ?>"></script>
 <!-- Page wise script -->
 <?php if (file_exists("application/views/frontend/default/$parent_dir/scripts/$file_name-script.php")) : ?>
     <?php include APPPATH . "views/frontend/default/$parent_dir/scripts/$file_name-script.php"; ?>
 <?php endif; ?>
 <!-- Initialize common scripts for frontend and backend here -->
 <?php include APPPATH . "views/common/script.php"; ?>