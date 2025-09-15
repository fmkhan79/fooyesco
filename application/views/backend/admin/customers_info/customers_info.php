<!-- Filter Customers Data behalf on order_type is delivery -->
<section class="content">
    <div class="container-fluid">

        <div class="row justify-content-center">
            <!-- Filter Orders -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header"><?php echo get_phrase('filter_restaurants'); ?></div>
                    <div class="card-body">
                        <form action="<?php echo site_url('customers-info/index'); ?>" method="get">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label><?php echo get_phrase('restaurant'); ?></label>
                                        <select class="form-control select2 w-100" name="restaurant_id" id="restaurant_id">
                                            <option value="all" <?php if ($restaurant_id == "all") echo "selected"; ?>><?php echo get_phrase('all'); ?></option>
                                            <?php foreach ($restaurants as $restaurant) : ?>
                                                <option value="<?php echo sanitize($restaurant['id']); ?>" <?php if ($restaurant_id == $restaurant['id']) echo "selected"; ?>>
                                                    <?php echo sanitize($restaurant['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="input-group pb-5">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> <?php echo get_phrase('filter'); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Send Message Section -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header">
                        <strong><?php echo get_phrase('send_message'); ?></strong>
                    </div>
                    <div class="card-body">
                        <form id="promotionForm" action="<?= site_url('customers-info/send_message') ?>" method="POST">
                            <input type="hidden" name="selected_customers_data" id="selected_customers_data">
                            <input type="hidden" name="selected_days" id="selected_days"> <!-- NEW hidden field -->

                            <div class="form-row">
                                <!-- Discount Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="discount_value"><?php echo get_phrase('discount_percentage'); ?> (%)</label>
                                    <input type="number" min="1" max="100" class="form-control" name="discount" id="discount_value" min="1" max="100" required placeholder="Enter discount (e.g., 10)">
                                </div>
                                <div class="col-md-4 mx-auto">
                                        <label for="discount_value"><?php echo get_phrase('Send Via'); ?></label>                                    
                                        <div class="d-flex">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="send_email" id="send_email">
                                                <label class="form-check-label" for="send_email"><?php echo get_phrase('email'); ?></label>
                                            </div>
                                            <div class="form-check mx-3">
                                                <input class="form-check-input" type="checkbox" name="send_sms" id="send_sms">
                                                <label class="form-check-label" for="send_sms"><?php echo get_phrase('sms'); ?></label>
                                            </div>
                                        </div>
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
                                                <input class="form-check-input promo_day_checkbox" type="checkbox" value="<?= $day ?>" id="day_<?= $day ?>">
                                                <label class="form-check-label" for="day_<?= $day ?>">
                                                    <?= ucfirst(substr($day, 0, 3)) ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <small class="text-muted">Only checked days will be valid for this promo.</small>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <label for="discount_value"><?php echo get_phrase('online_discount_validation'); ?></label>                                    
                                    <div class="d-flex">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="discount_option" id="add_on_by_default" value="default">
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

                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <textarea class="form-control" name="message" id="message_input" rows="3" placeholder="<?php echo get_phrase('type_your_message'); ?>"></textarea>
                                    <small class="text-muted">
                                        Note: Message must include <code>{customer_name}</code>, <code>{promo_code}</code>, <code>{valid_days}</code>, and <code>{discount}</code> placeholders for a valid promotion.
                                    </small>
                                </div>
                            </div>

                            <div class="form-row mt-2">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i> <?php echo get_phrase('send_message'); ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <!-- Customer List Table -->
        <div class="row mt-2">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo get_phrase("Promotions", true); ?></h3>
                    </div>
                    <div class="card-body">
                        <table id="customers_info" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="select_all"></th>
                                    <th>#</th>
                                    <th><?php echo get_phrase("name"); ?></th>
                                    <th><?php echo get_phrase("email"); ?></th>
                                    <th><?php echo get_phrase("phone"); ?></th>
                                    <th><?php echo get_phrase("restaurant"); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $index = 1;
                                $printed = [];
                                $restaurant_map = [];
                                foreach ($restaurants as $r) {
                                    $restaurant_map[$r['id']] = $r['name'];
                                }

                                foreach ($customers as $customer) {
                                    $billing = json_decode($customer['billing'], true);
                                    if ($billing['email'] == null && $billing['phone'] == null) continue;

                                    $uniqueKey = $billing['email'] . '|' . $billing['phone'];
                                    if (in_array($uniqueKey, $printed)) continue;
                                    $printed[] = $uniqueKey;

                                    $restaurantName = isset($restaurant_map[$customer['restaurant_id']]) ? $restaurant_map[$customer['restaurant_id']] : 'Unknown';
                                ?>
                                    <tr>
                                        <td><input type="checkbox" class="customer_checkbox" name="selected_customers[]" value="<?= $customer['id'] ?>" data-restaurant-id="<?= $customer['restaurant_id'] ?>"></td>
                                        <td><?= $index++ ?></td>
                                        <td><?= $billing['first_name'] . ' ' . $billing['last_name'] ?></td>
                                        <td><?= $billing['email'] ?></td>
                                        <td><?= $billing['phone_mobile'] ?? 'No Phone Number' ?></td>
                                        <td><?= $restaurantName ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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

    // Agar koi din uncheck ho to "Select All Days" bhi uncheck ho jaye
    $('.promo_day_checkbox').on('change', function () {
        if ($('.promo_day_checkbox:checked').length === $('.promo_day_checkbox').length) {
            $('#select_all_days').prop('checked', true);
        } else {
            $('#select_all_days').prop('checked', false);
        }
    });

    // Select All Customers
    $('#select_all').on('change', function () {
        $('.customer_checkbox').prop('checked', $(this).prop('checked'));
    });

    // Form Submit
    $('#promotionForm').on('submit', function (e) {
        let selectedData = [];

        $('.customer_checkbox:checked').each(function () {
            const row = $(this).closest('tr');
            const name = row.find('td:eq(2)').text().trim();
            const email = row.find('td:eq(3)').text().trim();
            const phone = row.find('td:eq(4)').text().trim();
            const restaurant = row.find('td:eq(5)').text().trim();
            const restaurantId = $(this).data('restaurant-id');

            selectedData.push({
                name: name,
                email: email,
                phone: phone,
                restaurant: restaurant,
                restaurant_id: restaurantId
            });
        });

        if (selectedData.length === 0) {
            alert("Please select at least one customer.");
            e.preventDefault();
            return;
        }

        // ✅ Yahan pe ab selectedDays properly collect ho raha hai
        let selectedDays = [];
        $('.promo_day_checkbox:checked').each(function () {
            selectedDays.push($(this).val());
        });

        if (selectedDays.length === 0) {
            alert("Please select at least one valid day for the promo.");
            e.preventDefault();
            return;
        }

        // ✅ Discount option validation
        const selectedDiscountOption = $('input[name="discount_option"]:checked').val();
        const selectAllDays = localStorage.getItem('selectAllDays') === "true";


        const message = $('#message_input').val().trim();

        if (!message.includes('{promo_code}')) {
            alert("Your message must include the {promo_code} placeholder.");
            e.preventDefault();
            return;
        }
 
        if (!selectAllDays) {
            if (!message.includes('{valid_days}')) {
                alert("Your message must include the {valid_days} placeholder.");
                e.preventDefault();
                return;
            }
        }

        if (!message.includes('{discount}')) {
            alert("Your message must include the {discount} placeholder.");
            e.preventDefault();
            return;
        }

        if (!message.includes('{customer_name}')) {
            alert("Your message must include the {customer_name} placeholder.");
            e.preventDefault();
            return;
        }

        $('#selected_customers_data').val(JSON.stringify(selectedData));
        $('#selected_days').val(JSON.stringify(selectedDays));
    });
});
</script>
