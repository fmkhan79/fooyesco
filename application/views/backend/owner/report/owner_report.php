<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><?php echo get_phrase('filter_orders'); ?></div>
            <div class="card-body">
                <form action="<?php echo site_url('report/index'); ?>" method="GET">
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label><?php echo get_phrase('restaurant'); ?></label>
                                <select class="form-control select2 w-100" name="restaurant_id" id="restaurant_id">
                                    <option value="all" <?php if ($restaurant_id == "all") echo "selected"; ?>><?php echo get_phrase('all'); ?></option>
                                    <?php foreach ($restaurants as $key => $restaurant) : ?>
                                        <option value="<?php echo sanitize($restaurant['id']); ?>" <?php if ($restaurant_id == $restaurant['id']) echo "selected"; ?>><?php echo sanitize($restaurant['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                            <div class="form-group">
                                <label><?php echo get_phrase('date_range'); ?></label>
                                <input type="hidden" name="date_range" id="selected-date-range-value" value="<?php echo date('F d, Y', sanitize($starting_timestamp)) . ' - ' . date('F d, Y', sanitize($ending_timestamp)); ?>">
                                <div class="input-group">
                                    <button type="button" class="btn btn-default btn-block text-left" id="daterange-btn">
                                        <i class="far fa-calendar-alt"></i> <span id="selected-date-range"><?php echo date('F d, Y', sanitize($starting_timestamp)) . ' - ' . date('F d, Y', sanitize($ending_timestamp)); ?></span>
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </div>
                            </div>
                        <!-- <div class="col-lg-4">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control select2 w-100" name="status" id="status">
                                    <option value="all">All</option>
                                    <option value="pending">Pending</option>
                                    <option value="preparing">Preparing</option>
                                    <option value="prepared">Prepared</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="canceled">Canceled</option>
                                </select>
                            </div>
                        </div> -->


                        <div class="col-lg-2">
                            <label class="text-white"><?php echo get_phrase('submit'); ?></label>

                            <div class="input-group pb-5">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> <?php echo get_phrase('filter'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <?php include "toptiles.php"; ?>
            </div>
        </div>
    </div>
</div>

<?php if (count($orders)) :
    ?>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <?php echo get_phrase("list_of_orders", true); ?>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="orders" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?php echo get_phrase("order_code"); ?></th>
                                <th><?php echo get_phrase("ordered_from"); ?></th>
                                <th><?php echo get_phrase("order_placing_time"); ?></th>
                                <!-- <th><?php echo get_phrase("delivery_details"); ?></th> -->
                                <th><?php echo get_phrase("payment method"); ?></th>
                                <th><?php echo get_phrase("Order Amount"); ?></th> 
                                <th><?php echo get_phrase("Comission Amount"); ?></th> 
                                <th><?php echo get_phrase("After Commission"); ?></th>

                                <th><?php echo get_phrase("action"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($orders as $order) : 
                            ?>
                            
                                <tr>
                                    <td>
                                        <a href="<?php echo site_url('orders/details/' . sanitize($order['code'])); ?>"><?php echo sanitize($order['code']); ?></a>
                                    </td>
                                    <td>
                                        <?php
                                        $restaurant_ids = $this->order_model->get_restaurant_ids($order['code']);
                                        foreach ($restaurant_ids as $restaurant_id) :
                                            $restaurant_detail = $this->restaurant_model->get_by_id($restaurant_id); ?>
                                            <?php if (isset($restaurant_detail['id'])) : ?>
                                                <a href="<?php echo site_url('site/restaurant/' . sanitize(rawurlencode($restaurant_detail['slug'])) . '/' . sanitize($restaurant_detail['id'])); ?>" class="text-dark" target="_blank"><small class="d-block"> ∙ <?php echo sanitize($restaurant_detail['name']); ?></small></a>
                                            <?php else : ?>
                                                <a href="javascript:void(0)" class="text-red"><small class="d-block"> ∙ <?php echo get_phrase("not_found");; ?></small></a>
                                            <?php endif; ?>

                                        <?php endforeach; ?>
                                    </td>
                                    <td>
                                        <i class="far fa-calendar-alt"></i> <?php echo date('D, d-M-Y', sanitize($order['order_placed_at'])); ?>
                                        <small><i class="far fa-clock"></i> <?php echo date('h:i A', sanitize($order['order_placed_at'])); ?></small><br>
                                    </td>
                                    <!-- <td>
                                        <?php if ($order['order_type'] == "pickup") : ?>
                                            <small><strong><?php echo get_phrase('order_type'); ?> : </strong> <span class="badge badge-success lighten-success"><?php echo get_phrase('pickup'); ?></span></small>
                                            <small class="d-block">
                                                <strong><?php echo get_phrase('customer'); ?> : </strong> <?php echo sanitize($order['customer_name']); ?>
                                            </small>
                                        <?php else : ?>
                                            <small><strong><?php echo get_phrase('order_type'); ?> : </strong> <span class="badge badge-warning lighten-warning"><?php echo get_phrase('delivery'); ?></span></small>
                                            <small class="d-block">
                                                <strong><?php echo get_phrase('customer'); ?> : </strong> <?php echo sanitize($order['customer_name']); ?>
                                            </small>
                                            <small data-toggle="tooltip" data-placement="top" title="<?php echo sanitize($order['delivery_address']); ?>">
                                                <strong><?php echo get_phrase('address'); ?> : </strong> <?php echo ellipsis(sanitize($order['delivery_address'])); ?>
                                            </small>
                                            <small class="d-block">
                                                <strong><?php echo get_phrase('assigned_driver'); ?> : </strong>
                                                <?php if (isset($order['driver_id']) && !empty($order['driver_id'])) : ?>
                                                    <?php echo sanitize($order['driver_name']); ?>
                                                <?php else : ?>
                                                    <span class="badge badge-danger lighten-danger"><?php echo get_phrase('not_assigned_yet'); ?></span>
                                                <?php endif; ?>
                                            </small>
                                        <?php endif; ?>
                                    </td> -->
                                    <td>
                                                                                 <?php $payment_data = $this->payment_model->get_payment_data_by_order_code($order['code']); ?>
                                            <?php if (($payment_data['payment_method']) =="stripe" )  : ?>
                                                       <span class="badge badge-success lighten-success"><?php echo get_phrase(sanitize('Card')); ?></span>
                                            <?php else : ?>
                                                <span class="badge badge-danger lighten-primary"><?php echo get_phrase(sanitize('Cash')); ?></span>
                                            <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php $payment_data = $this->payment_model->get_payment_data_by_order_code($order['code']); ?>
                                        <small class="d-block">
                                            <?php echo currency(isset($payment_data['amount_to_pay']) ? sanitize($payment_data['amount_to_pay']) : 0); ?>
                                        </small>
                                         
                                        <!-- <small class="d-block">
                                            <strong><?php echo get_phrase('method'); ?> : </strong>
                                            <?php if (isset($payment_data['payment_method'])) : ?>
                                                <?php echo ucfirst(str_replace('_', ' ', sanitize($payment_data['payment_method']))); ?>
                                            <?php else : ?>
                                                <?php echo get_phrase('no_found'); ?>
                                            <?php endif; ?>
                                        </small> -->
                                    </td>
                                    
                                    
                                    <td>
                                        <small class="d-block">
                                           <?php echo currency(isset($order['commission_paid']) ? sanitize(  $order['commission_paid']) : 0); ?>    
                                        </small>
                                    </td>
                                     
                                    <td>
                                       <small class="d-block">
                                            <?php
                                                $commission_amount = isset($order['commission_paid']) ? sanitize($order['grand_total'] - $order['commission_paid']) : 0;
                                                $commission_percentage = $order['commission_res'] == NULL ? 0 : $order['commission_res'];

                                                echo currency(number_format($commission_amount, 2)) . " (" . number_format($commission_percentage, 2) . "%)";
                                            ?>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?php echo site_url('orders/details/' . sanitize($order['code'])); ?>" class="btn btn-rounded btn-outline-primary btn-sm mt-2"><?php echo get_phrase('details'); ?></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><?php echo get_phrase("order_code"); ?></th>
                                <th><?php echo get_phrase("ordered_from"); ?></th>
                                <th><?php echo get_phrase("order_placing_time"); ?></th>
                                <!-- <th><?php echo get_phrase("delivery_details"); ?></th> -->
                                <th><?php echo get_phrase("payment method"); ?></th>
                                <th><?php echo get_phrase("Order Amount"); ?></th> 
                                <th><?php echo get_phrase("Comission Amount"); ?></th> 
                                <th><?php echo get_phrase("After Commission"); ?></th>

                                <th><?php echo get_phrase("action"); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
<?php endif; ?>


<div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="far fa-chart-bar"></i> <?php echo get_phrase("admin_income_graph_of_year", true) . ": " . date("Y"); ?></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div id="sales-graph" class="graph-style"></div>
                </div>
            </div>
        </div>

<?php if (!count($commissions)) : ?>
    <?php isEmpty(); ?>
<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#orders').DataTable({
            pageLength: 5,  
        });
    });

</script>
