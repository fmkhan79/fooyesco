<!-- Content Header -->
<?php include 'header.php'; ?>

<!-- Main Conten -->
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="alert alert-info lighten-info" role="alert">
                    <h5 class="alert-heading"><i class="icon fas fa-exclamation-triangle"></i> <?php echo get_phrase('heads_up'); ?>!</h5>
                    <p>
                        <?php echo get_phrase('this_is_the_global_delivery_cahrge'); ?> <?php echo get_phrase('for'); ?> <strong><?php echo get_phrase('each'); ?></strong> <?php echo get_phrase('restaurant'); ?>. <br>
                        <?php echo get_phrase('you_can_overwrite_the_charge_for_individual_restaurant_from_their_edit_section'); ?>.
                    </p>
                </div>
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo get_phrase('delivery_settings'); ?></h3>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo site_url('settings/update'); ?>" method="post">
                            <input type="hidden" name="settings_type" value="delivery">

                            <div class="custom-control custom-checkbox mb-1">
                                <input class="custom-control-input" name="free_delivery_charge" type="checkbox" id="free_delivery_charge" <?php echo get_delivery_settings('free_delivery_charge') ? "checked" : ""; ?>>
                                <label for="free_delivery_charge" class="custom-control-label"><?php echo get_phrase("free"); ?> <small>( <?php echo get_phrase('check') . ', ' . get_phrase('if_delivery_charge_is_free'); ?> )</small></label>
                            </div>

                            <div class="form-group">
                                <label for="delivery_charge"><?php echo get_phrase("delivery_charge") . ' (' . currency_code_and_symbol('code') . ')'; ?></label>
                                <input type="number" id="delivery_charge" class="form-control" name="delivery_charge" placeholder="<?php echo get_phrase("enter_a_convenient_delivery_charge"); ?>" value="<?php echo sanitize(get_delivery_settings('delivery_charge')); ?>" step=".01" required>
                            </div>

                            <div class="form-group clockpicker">
                                <label for="maximum_time_to_deliver"><?php echo get_phrase("maximum_time_to_deliver"); ?></label>
                                <input type="text" class="form-control" id="maximum_time_to_deliver" name="maximum_time_to_deliver" placeholder="<?php echo get_phrase("provide_maximum_time_to_deliver"); ?> (hh:mm)" value="<?php echo sanitize(get_delivery_settings('maximum_time_to_deliver')); ?>" required>
                            </div>
                            <button class="btn btn-primary"><?php echo get_phrase('update_delivery_data'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>