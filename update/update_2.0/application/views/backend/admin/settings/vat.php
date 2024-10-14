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
                        <?php echo "<strong>" . get_delivery_settings('vat') . '% </strong> VAT ' . strtolower(get_phrase('will_be_added_to_total_bill_of_each_order')); ?>.
                    </p>
                </div>
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo "VAT " . get_phrase('settings'); ?></h3>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo site_url('settings/update'); ?>" method="post">
                            <input type="hidden" name="settings_type" value="vat">
                            <div class="form-group">
                                <label for="vat"><?php echo "VAT " . get_phrase("percentage"); ?></label>
                                <div class="input-group mb-3">
                                    <input type="number" id="vat" class="form-control" name="vat" placeholder="<?php echo "VAT " . get_phrase("percentage"); ?>" value="<?php echo sanitize(get_delivery_settings('vat')); ?>" min="0" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary"><?php echo get_phrase('update') . " VAT " . get_phrase('data'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>