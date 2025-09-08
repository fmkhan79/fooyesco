<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header">
                        <strong><?php echo get_phrase('create_special_code'); ?></strong>
                    </div>
                    <div class="card-body">
                           <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>
                        <form id="specialCodeForm" action="<?php echo site_url('customers-info/special_promo_create'); ?>" method="POST">
                            <input type="hidden" name="selected_days" id="selected_days"> 

                            <div class="form-row">
                                <!-- Offer Code Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="offer_code"><?php echo get_phrase('offer_code'); ?></label>
                                    <input type="text" class="form-control" name="offer_code" id="offer_code" required placeholder="Enter offer code (e.g., PROMO123)">
                                </div>
                                <!-- Discount Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="discount_value"><?php echo get_phrase('discount_percentage'); ?> (%)</label>
                                    <input type="number" min="1" max="100" class="form-control" name="discount" id="discount_value" required placeholder="Enter discount (e.g., 10)">
                                </div>
                            </div>

                            <!-- Days Selection -->
                            <div class="form-row mb-3">
                                <div class="col-md-12">
                                    <label><strong><?php echo get_phrase('valid_days'); ?></strong></label>
                                    <div class="d-flex flex-wrap">
                                        <!-- Select All Days -->
                                        <div class="form-check mr-3">
                                            <input class="form-check-input" type="checkbox" id="select_all_days">
                                            <label class="form-check-label" for="select_all_days">
                                                <?php echo get_phrase('select_all_days'); ?>
                                            </label>
                                        </div>
                                        <?php 
                                        $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
                                        foreach ($days as $day): ?>
                                            <div class="form-check mr-3">
                                                <input class="form-check-input promo_day_checkbox" type="checkbox" value="<?php echo $day ?>" id="day_<?php echo $day ?>">
                                                <label class="form-check-label" for="day_<?php echo $day ?>">
                                                    <?php echo ucfirst(substr($day, 0, 3)) ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <small class="text-muted">Only checked days will be valid for this offer.</small>
                                </div>
                            </div>

                            <!-- Discount Option -->
                            <div class="form-row mb-3">
                                <div class="col-md-12">
                                    <label for="discount_option"><?php echo get_phrase('online_discount_validation'); ?></label>
                                    <div class="d-flex">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="discount_option" id="add_on_by_default" value="default" required>
                                            <label class="form-check-label" for="add_on_by_default">
                                                <?php echo get_phrase('add_on_by_default'); ?>
                                            </label>
                                        </div>
                                        <div class="form-check mx-3">
                                            <input class="form-check-input" type="radio" name="discount_option" id="only_promo" value="promo">
                                            <label class="form-check-label" for="only_promo">
                                                <?php echo get_phrase('only_promo'); ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row mt-2">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> <?php echo get_phrase('create_code'); ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function () {
    localStorage.setItem("selectAllDays", "false");

    // Select All Days functionality
    $('#select_all_days').on('change', function () {
        var isChecked = $(this).prop('checked');
        $('.promo_day_checkbox').prop('checked', isChecked);
        localStorage.setItem('selectAllDays', isChecked);
    });

    // Uncheck Select All Days if any day is unchecked
    $('.promo_day_checkbox').on('change', function () {
        if ($('.promo_day_checkbox:checked').length === $('.promo_day_checkbox').length) {
            $('#select_all_days').prop('checked', true);
            localStorage.setItem('selectAllDays', true);
        } else {
            $('#select_all_days').prop('checked', false);
            localStorage.setItem('selectAllDays', false);
        }
    });

    // Form Submit
    $('#specialCodeForm').on('submit', function (e) {
        let selectedDays = [];
        $('.promo_day_checkbox:checked').each(function () {
            selectedDays.push($(this).val());
        });

        if (selectedDays.length === 0) {
            alert("Please select at least one valid day for the offer.");
            e.preventDefault();
            return;
        }

        const selectAllDays = localStorage.getItem('selectAllDays') === "true";
        const selectedDiscountOption = $('input[name="discount_option"]:checked').val();

        if (selectAllDays && selectedDiscountOption === "default") {
            alert("If all days are selected, you cannot select 'Add on by Default'. Please select 'Only Promo'.");
            e.preventDefault();
            return;
        }

        if (!selectAllDays && selectedDiscountOption === "promo") {
            alert("If you choose selective days, you cannot choose 'Only Promo'. Please select 'Add on by Default'.");
            e.preventDefault();
            return;
        }

        $('#selected_days').val(JSON.stringify(selectedDays));
    });
});
</script>