<!-- Content Header -->
<?php include 'header.php'; ?>

<!-- Main Conten -->
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="alert alert-info lighten-info" role="alert">
                    <h5 class="alert-heading"><i class="icon fas fa-exclamation-triangle"></i> <?php echo get_phrase('Notice'); ?></h5>
                    <p>
                        <?php echo get_phrase('this_revenue_settings_is_applicable_for_each_order'); ?>. <br>
                        <?php echo get_phrase('admin_will_get_a_percentage_of_the_total_amount_for_each_order'); ?>.
                    </p>
                </div>
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo get_phrase('revenue_settings'); ?></h3>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo site_url('settings/update'); ?>" method="post">
                            <input type="hidden" name="settings_type" value="revenue">
                            <div class="form-group">
                                <label for="admin_revenue"><?php echo get_phrase("admin_revenue_percentage"); ?></label>
                                <div class="input-group mb-3">
                                    <input type="number" id="admin_revenue" class="form-control" name="admin_revenue" placeholder="<?php echo get_phrase("admin_revenue_percentage"); ?>" value="<?php echo sanitize(get_delivery_settings('admin_revenue')); ?>" min="0" onkeyup="calculateRestaurantRevenue(this.value)" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="restaurant_revenue"><?php echo get_phrase("restaurant_revenue_percentage"); ?></label>
                                <div class="input-group mb-3">
                                    <input type="number" id="restaurant_revenue" class="form-control bg-white" name="restaurant_revenue" placeholder="<?php echo get_phrase("restaurant_revenue_percentage"); ?>" value="<?php echo sanitize(get_delivery_settings('restaurant_revenue')); ?>" min="0" readonly required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary"><?php echo get_phrase('update_delivery_data'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>