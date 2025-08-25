<!-- Filter Customers Data behalf on order_type is delivery -->
<style>

code{
    color: #f54748 !important;
}


</style>

<section class="content">
    <div class="container-fluid">

        <!-- Customer List Table -->
        <div class="row mt-2">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo get_phrase("promo_codes", true); ?></h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="customers_info">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Promo Code</th>
                                    <th>Discount (%)</th>
                                    <th>Is Valid</th>
                                    <th>Valid Days</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($promo_codes)): ?>
                                    <?php $i = 1;
                                    foreach ($promo_codes as $promo): ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><code><?= $promo->offer_code ?></code></td>
                                            <td><?= $promo->discount ?>%</td>
                                            <td>
                                                <?php
                                                
                                                if($promo->is_used){
                                                    echo '<div class="badge bg-danger">Not Valid</div>';
                                                }else{
                                                    echo '<div class="badge bg-success">Valid</div>';
                                                }

                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                
                                                $this->load->model('Promo_model');
                                                $validDays = $this->Promo_model->get_valid_days($promo->id);
                                                // print_r($validDays);
                                                if (count($validDays) == 7) {
                                                    if($promo->is_used){
                                                        echo'<span>-</span>';
                                                    }else{
                                                        echo'<span>All Days</span>';
                                                    }
                                                }else{
                                                foreach ($validDays as $key => $day): ?>
                                                    <span><?= $day ?></span>
                                                <?php endforeach;
                                                } ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No promo codes found.</td>
                                    </tr>
                                <?php endif; ?>
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
