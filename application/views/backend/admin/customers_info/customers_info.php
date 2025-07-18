<!-- Filter Customers Data behalf on order_type is delivery -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <?php echo get_phrase("Customers Information", true); ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <table id="customers_info" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo get_phrase("#"); ?></th>
                                    <th><?php echo get_phrase("name"); ?></th>
                                    <th><?php echo get_phrase("email"); ?></th>
                                    <th><?php echo get_phrase("phone"); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $index = 1;
                                $printed = []; // Array to track unique email/phone

                                foreach ($customers as $customer) {

                                    $billing = json_decode($customer['billing'], true);

                                    // Create unique key using email and phone
                                    $uniqueKey = $billing['email'] . '|' . $billing['phone'];

                                    if (in_array($uniqueKey, $printed)) {
                                        continue; // Skip duplicate
                                    }

                                    $printed[] = $uniqueKey; // Mark as printed
                                ?>
                                    <tr>
                                        <td><?= $index++ ?></td>
                                        <td><?= $billing['first_name'] . ' ' . $billing['last_name'] ?></td>
                                        <td><?= $billing['email'] ?></td>
                                        <td><?= $billing['phone_mobile'] ?? 'No Phone Number' ?></td>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>