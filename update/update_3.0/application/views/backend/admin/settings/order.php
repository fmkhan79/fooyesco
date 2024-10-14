<!-- Content Header -->
<?php include 'header.php'; ?>
<!-- /.content-header -->
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <!-- ORDER SETTINGS -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo get_phrase('order_settings_info', true); ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger lighten-danger" role="alert">
                            <span class="text-danger"> <strong>N.B:</strong> <?php echo get_phrase('some_of_these_settings_are_applicable_if_and_only_if_the_multi_restaurant_order_is_disabled'); ?>.</span>
                        </div>
                        <form action="<?php echo site_url('settings/update'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="settings_type" value="order">
                            <div class="form-group">
                                <label id="multi_restaurant_order"><?php echo get_phrase("multi_restaurant_order"); ?><span class="text-danger">*</span></label>
                                <select class="form-control select2 w-100" id="multi_restaurant_order" name="multi_restaurant_order" required>
                                    <option value="1" <?php if (sanitize(get_order_settings('multi_restaurant_order')) == 1) echo 'selected'; ?>><?php echo get_phrase('enabled'); ?></option>
                                    <option value="0" <?php if (sanitize(get_order_settings('multi_restaurant_order')) == 0) echo 'selected'; ?>><?php echo get_phrase('disabled'); ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label id="pickup_order"><?php echo get_phrase("pickup_order"); ?><span class="text-danger">* <small>(<?php echo strtolower(get_phrase('applicable_if_multi_restaurant_order_is_disabled')); ?>)</small></span></label>
                                <select class="form-control select2 w-100" id="pickup_order" name="pickup_order" required>
                                    <option value="1" <?php if (sanitize(get_order_settings('pickup_order')) == 1) echo 'selected'; ?>><?php echo get_phrase('enabled'); ?></option>
                                    <option value="0" <?php if (sanitize(get_order_settings('pickup_order')) == 0) echo 'selected'; ?>><?php echo get_phrase('disabled'); ?></option>
                                </select>
                                <small> <strong>N.B</strong>: <?php echo get_phrase('each_restaurant_has_their_own_pickup_order_settings'); ?>. <?php echo get_phrase('go_to_restaurant_edit_page_then_delivery_option'); ?>.</small>
                            </div>
                            <div class="form-group">
                                <label id="owner_order_processing"><?php echo get_phrase("let_the_restaurant_owner_process_order"); ?><span class="text-danger">* <small>(<?php echo strtolower(get_phrase('applicable_if_multi_restaurant_order_is_disabled')); ?>)</small></span></label>
                                <select class="form-control select2 w-100" id="owner_order_processing" name="owner_order_processing" required>
                                    <option value="1" <?php if (sanitize(get_order_settings('owner_order_processing')) == 1) echo 'selected'; ?>><?php echo get_phrase('enabled'); ?></option>
                                    <option value="0" <?php if (sanitize(get_order_settings('owner_order_processing')) == 0) echo 'selected'; ?>><?php echo get_phrase('disabled'); ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label id="auto_approve_order"><?php echo get_phrase("auto_approve_pending_order"); ?><span class="text-danger">*</span></label>
                                <select class="form-control select2 w-100" id="auto_approve_order" name="auto_approve_order" required>
                                    <option value="1" <?php if (sanitize(get_order_settings('auto_approve_order')) == 1) echo 'selected'; ?>><?php echo get_phrase('enabled'); ?></option>
                                    <option value="0" <?php if (sanitize(get_order_settings('auto_approve_order')) == 0) echo 'selected'; ?>><?php echo get_phrase('disabled'); ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label id="auto_assign_driver"><?php echo get_phrase("assign_driver_to_order_automatically"); ?><span class="text-danger">*</span></label>
                                <select class="form-control select2 w-100" id="auto_assign_driver" name="auto_assign_driver" required>
                                    <option value="1" <?php if (sanitize(get_order_settings('auto_assign_driver')) == 1) echo 'selected'; ?>><?php echo get_phrase('enabled'); ?></option>
                                    <option value="0" <?php if (sanitize(get_order_settings('auto_assign_driver')) == 0) echo 'selected'; ?>><?php echo get_phrase('disabled'); ?></option>
                                </select>
                            </div>
                            <button class="btn btn-primary"><?php echo get_phrase('update_order_settings', true); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->