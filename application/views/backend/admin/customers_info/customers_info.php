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
                                    <th><?php echo get_phrase("profile"); ?></th>
                                    <th><?php echo get_phrase("name"); ?></th>
                                    <th><?php echo get_phrase("email"); ?></th>
                                    <th><?php echo get_phrase("phone"); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $index=1;
                                foreach ($customers as $customer) {
                                    if ($customer['name'] == null || $customer['email'] == null) {
                                        continue;
                                    }
                                ?>
                                    <tr>
                                        <td><?= $index++ ?></td>
                                        <td>
                                            <img style="width: 80px;" src="<?php echo base_url('uploads/user/' . sanitize($customer['thumbnail'])); ?>" alt="" class="img-circle img-fluid">
                                        </td>
                                        <td><?= $customer['name'] ?></td>
                                        <td><?= $customer['email'] ?></td>
                                        <td><?= $customer['phone']  ?? 'No Phone Number' ?></td>
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