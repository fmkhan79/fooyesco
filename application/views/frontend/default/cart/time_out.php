
<?php include APPPATH . 'views/frontend/default/navigation/dark.php'; ?>

<div class="booking-checkbox_wrap mb-2">
    <div class="row">
        <div class="col-sm-12 text-center">
            <h5>
                Oops!
            </h5>
            <!-- Failed logo -->
            <!-- <img src="<?php echo base_url('assets/frontend/default/images/failed.png'); ?>" 
                 class="img-fluid success-tick" height="72" alt="failed-logo"> -->
            <span class="d-block mt-2">
                Your cancellation time is finished. You can no longer cancel this order.
            </span>
            <a href="<?php echo site_url(); ?>" class="rr-btn btn-danger mt-4">
                Go To Home
            </a>
        </div>
    </div>
</div>
