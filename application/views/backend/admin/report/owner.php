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
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Select Date Range</label>
                                <input type="text" class="form-control" name="date_range" id="date_range" placeholder="Select date range">
                            </div>
                        </div>
                        <div class="col-lg-4">
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
                        </div>


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
<?php if (count($commissions)) : ?>

    <div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">List Of Orders</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        Show
                        <select class="custom-select custom-select-sm w-auto d-inline-block">
                            <option selected>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                        entries
                    </div>
                    <div>
                        Search:
                        <input type="text" class="form-control form-control-sm d-inline-block w-auto" placeholder="">
                    </div>
                </div>

                <table style="background-color:#fff" class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Total Order Amount</th>
                            <th>Total Card Payments</th>
                            <th>Total Cash Payments</th>
                            <th>Total Stripe Charges</th>
                            <th>Total Balance Remaining</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- ... your order rows here ... -->
                    </tbody>
                    <tfoot class="thead-light">
                        <tr>
                            <th>Total Order Amount</th>
                            <th>Total Card Payments</th>
                            <th>Total Cash Payments</th>
                            <th>Total Stripe Charges</th>
                            <th>Total Balance Remaining</th>
                        </tr>
                    </tfoot>
                </table>

                <!-- Footer with entry count and pagination -->
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#">Previous</a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link bg-primary border-primary text-white" href="#">1</a>
                            </li>
                            <li class="page-item disabled">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <?php echo get_phrase("commission_list_of_restaurant_owners", true); ?>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="commissions" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?php echo get_phrase("restaurant_name"); ?></th>
                                <th><?php echo get_phrase("restaurant_owner"); ?></th>
                                <th><?php echo get_phrase("total_payable_commission"); ?></th>
                                <th><?php echo get_phrase("total_paid_commission"); ?></th>
                                <th><?php echo get_phrase("action"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($commissions as $key => $commission) :
                                $restaurant_detail = $this->restaurant_model->get_by_id(sanitize($commission['restaurant_id']));
                                $owner_details = $this->user_model->get_user_by_id(sanitize($restaurant_detail['owner_id']));
                                if ($owner_details['role_id'] == 1) continue; ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo site_url('site/restaurant/' . rawurlencode(sanitize($restaurant_detail['slug'])) . '/' . sanitize($restaurant_detail['id'])); ?>" target="_blank"><?php echo sanitize($restaurant_detail['name']); ?></a>
                                    </td>
                                    <td>
                                        <?php if (get_user_role('user_role', $owner_details['id']) != "admin") : ?>
                                            <a href="<?php echo site_url('owner/profile/' . sanitize($owner_details['id'])) ?>"><?php echo sanitize($owner_details['name']); ?></a>
                                        <?php else : ?>
                                            <?php echo sanitize($owner_details['name']); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo currency(sanitize($this->report_model->get_total_payable_commission(sanitize($commission['restaurant_id'])))); ?>
                                    </td>
                                    <td>
                                        <?php echo sanitize($commission['paid_amount']) ? currency(sanitize($commission['paid_amount'])) : currency(0); ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn action-dropdown" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?php echo site_url('report/details/' . sanitize($commission['restaurant_id'])); ?>"><?php echo get_phrase("details"); ?></a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="showAjaxModal('<?php echo site_url('modal/popup/report/pay/' . sanitize($commission['restaurant_id'])); ?>', '<?php echo get_phrase('pay_to_restaurant_owner', true) ?>')"><?php echo get_phrase("pay"); ?></a></li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><?php echo get_phrase("restaurant_name"); ?></th>
                                <th><?php echo get_phrase("restaurant_owner"); ?></th>
                                <th><?php echo get_phrase("total_payable_commission"); ?></th>
                                <th><?php echo get_phrase("total_paid_commission"); ?></th>
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

<?php if (!count($commissions)) : ?>
    <?php isEmpty(); ?>
<?php endif; ?>
