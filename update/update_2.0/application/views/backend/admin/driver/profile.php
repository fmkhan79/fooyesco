<!-- Content Header (Page header) -->
<?php include  'header.php'; ?>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle light-thumb-circle" src="<?php echo base_url('uploads/user/' . $driver['thumbnail']); ?>" alt="<?php echo get_phrase('driver_profile_image'); ?>">
                        </div>

                        <h3 class="profile-username text-center"><?php echo sanitize($driver['name']); ?></h3>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b><?php echo get_phrase('status'); ?></b>
                                <a class="float-right">
                                    <?php if ($driver['status']) : ?>
                                        <span class="badge badge-success lighten-success"><?php echo get_phrase('approved'); ?></span>
                                    <?php else : ?>
                                        <span class="badge badge-danger lighten-danger"><?php echo get_phrase('pending'); ?></span>
                                    <?php endif; ?>

                                </a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo get_phrase('email'); ?></b><a class="float-right"><?php echo sanitize($driver['email']); ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo get_phrase('phone'); ?></b><a class="float-right"><?php echo sanitize($driver['phone']); ?></a>
                            </li>
                        </ul>
                        <?php if ($driver['status']) : ?>
                            <a href="javascript:void(0)" onclick="confirm_modal('<?php echo site_url('driver/update_status/' . $driver['id']); ?>')" class="btn btn-danger btn-block"><b><?php echo get_phrase('mark_as_pending'); ?></b></a>
                        <?php else : ?>
                            <a href="javascript:void(0)" onclick="confirm_modal('<?php echo site_url('driver/update_status/' . $driver['id']); ?>')" class="btn btn-success btn-block"><b><?php echo get_phrase('mark_as_approved'); ?></b></a>
                        <?php endif; ?>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- About Me Box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo get_phrase('more_information'); ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="fas fa-truck mr-1"></i> <?php echo get_phrase('vehicle_type'); ?></strong>

                        <p class="text-muted">
                            <?php echo ucfirst($driver['vehicle_type']); ?>
                        </p>
                        <hr>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i> <?php echo get_phrase('address'); ?></strong>

                        <p class="text-muted"><?php echo sanitize($driver['address']); ?></p>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link <?php if ($tab == "activity") echo "active"; ?>" href="#activity" data-toggle="tab"><?php echo get_phrase('Activity'); ?></a></li>
                            <li class="nav-item"><a class="nav-link <?php if ($tab == "profile") echo "active"; ?>" href="#profile" data-toggle="tab"><?php echo get_phrase('profile'); ?></a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- /.tab-pane -->
                            <div class=" <?php if ($tab == "activity") echo "active"; ?> tab-pane" id="activity">
                                <form action="<?php echo site_url('driver/profile/' . $driver['id']) ?>" method="GET">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label><?php echo get_phrase('date_range'); ?></label>
                                                <input type="hidden" name="date_range" id="selected-date-range-value" value="<?php echo date('F d, Y', $starting_timestamp) . ' - ' . date('F d, Y', $ending_timestamp); ?>">
                                                <div class="input-group">
                                                    <button type="button" class="btn btn-default btn-block text-left" id="daterange-btn">
                                                        <i class="far fa-calendar-alt"></i> <span id="selected-date-range"><?php echo date('F d, Y', $starting_timestamp) . ' - ' . date('F d, Y', $ending_timestamp); ?></span>
                                                        <i class="fas fa-caret-down"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="text-white"><?php echo get_phrase('submit'); ?></label>
                                            <button type="submit" class="btn btn-primary"><?php echo get_phrase('filter'); ?></button>
                                        </div>
                                    </div>
                                </form>
                                <!-- The timeline -->
                                <table id="orders" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th><?php echo get_phrase("order_code"); ?></th>
                                            <th><?php echo get_phrase("order_placed_at"); ?></th>
                                            <th><?php echo get_phrase("order_delivered_at"); ?></th>
                                            <th><?php echo get_phrase("delivery_address"); ?></th>
                                            <th><?php echo get_phrase("order_status"); ?></th>
                                            <th><?php echo get_phrase("action"); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $order) : ?>
                                            <tr>
                                                <td>
                                                    <small><a href="<?php echo site_url('orders/details/' . $order['code']); ?>"><?php echo sanitize($order['code']); ?></a></small>
                                                </td>
                                                <td>
                                                    <small><i class="far fa-clock"></i>
                                                        <?php echo !empty(sanitize($order['order_placed_at'])) ? date('h:i A', sanitize($order['order_placed_at'])) : "-"; ?>
                                                    </small><br>
                                                    <small><i class="far fa-calendar-alt"></i>
                                                        <?php echo !empty(sanitize($order['order_placed_at'])) ? date('D, d-M-Y', sanitize($order['order_placed_at'])) : "-"; ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <small><i class="far fa-clock"></i>
                                                        <?php echo !empty(sanitize($order['order_delivered_at'])) ? date('h:i A', sanitize($order['order_delivered_at'])) : "-"; ?>
                                                    </small><br>
                                                    <small><i class="far fa-calendar-alt"></i>
                                                        <?php echo !empty(sanitize($order['order_delivered_at'])) ? date('D, d-M-Y', sanitize($order['order_delivered_at'])) : "-"; ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <small data-toggle="tooltip" data-placement="top" title="<?php echo sanitize($order['delivery_address']); ?>">
                                                        <i class="fas fa-map-marker-alt"></i> <?php echo ellipsis(sanitize($order['delivery_address'])); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <small>
                                                        <?php if ($order['order_status'] == 'pending') : ?>
                                                            <span class="badge badge-warning lighten-warning"><?php echo get_phrase(sanitize($order['order_status'])); ?></span>
                                                        <?php elseif ($order['order_status'] == 'delivered') : ?>
                                                            <span class="badge badge-success lighten-success"><?php echo get_phrase(sanitize($order['order_status'])); ?></span>
                                                        <?php elseif ($order['order_status'] == 'canceled') : ?>
                                                            <span class="badge badge-danger lighten-danger"><?php echo get_phrase(sanitize($order['order_status'])); ?></span>
                                                        <?php else : ?>
                                                            <span class="badge badge-primary lighten-primary"><?php echo get_phrase(sanitize($order['order_status'])); ?></span>
                                                        <?php endif; ?>
                                                    </small>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?php echo site_url('orders/details/' . $order['code']); ?>" class="btn btn-rounded btn-outline-primary btn-xs mt-2"><?php echo get_phrase('details'); ?></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th><?php echo get_phrase("order_code"); ?></th>
                                            <th><?php echo get_phrase("order_placed_at"); ?></th>
                                            <th><?php echo get_phrase("order_delivered_at"); ?></th>
                                            <th><?php echo get_phrase("delivery_address"); ?></th>
                                            <th><?php echo get_phrase("order_status"); ?></th>
                                            <th><?php echo get_phrase("action"); ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="<?php if ($tab == "profile") echo "active"; ?> tab-pane" id="profile">
                                <form class="form-horizontal" action="<?php echo site_url('driver/update'); ?>" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo sanitize($driver['id']); ?>">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label"><?php echo get_phrase('name'); ?><span class='text-danger'>*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" class="form-control" id="name" placeholder="<?php echo get_phrase('provide_name'); ?>" value="<?php echo sanitize($driver['name']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label"><?php echo get_phrase('email'); ?><span class='text-danger'>*</span></label>
                                        <div class="col-sm-10">
                                            <input type="email" name="email" class="form-control" id="email" placeholder="<?php echo get_phrase('provide_valid_email'); ?>" value="<?php echo sanitize($driver['email']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="phone" class="col-sm-2 col-form-label"><?php echo get_phrase("phone"); ?><span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="<?php echo get_phrase("enter_phone"); ?>" value="<?php echo sanitize($driver['phone']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="vehicle_type" class="col-sm-2 col-form-label"><?php echo get_phrase("vehicle_type"); ?></label>
                                        <div class="col-sm-10">
                                            <select class="form-control select2 w-100" id="vehicle_type" name="vehicle_type">
                                                <option value=""><?php echo get_phrase("choose_vehicle_type"); ?></option>
                                                <option value="bicycle" <?php if ($driver['vehicle_type'] == 'bicycle') echo "selected"; ?>><?php echo get_phrase('bicycle'); ?></option>
                                                <option value="tricycle" <?php if ($driver['vehicle_type'] == 'tricycle') echo "selected"; ?>><?php echo get_phrase('tricycle'); ?></option>
                                                <option value="scooters" <?php if ($driver['vehicle_type'] == 'scooters') echo "selected"; ?>><?php echo get_phrase('scooters'); ?></option>
                                                <option value="motorcycle" <?php if ($driver['vehicle_type'] == 'motorcycle') echo "selected"; ?>><?php echo get_phrase('motorcycle'); ?></option>
                                                <option value="van" <?php if ($driver['vehicle_type'] == 'van') echo "selected"; ?>><?php echo get_phrase('van'); ?></option>
                                                <option value="car" <?php if ($driver['vehicle_type'] == 'car') echo "selected"; ?>><?php echo get_phrase('car'); ?></option>
                                                <option value="pick_up" <?php if ($driver['vehicle_type'] == 'pick_up') echo "selected"; ?>><?php echo get_phrase('pick_up'); ?></option>
                                                <option value="others" <?php if ($driver['vehicle_type'] == 'others') echo "selected"; ?>><?php echo get_phrase('others'); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="address" class="col-sm-2 col-form-label"><?php echo get_phrase("address"); ?></label>
                                        <div class="col-sm-10">
                                            <textarea name="address" class="form-control" id="address" rows="5" placeholder="<?php echo get_phrase('enter_full_address'); ?>."><?php echo sanitize($driver['address']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="image" class="col-sm-2 col-form-label"><?php echo get_phrase("image"); ?></label>
                                        <div class="col-sm-10">
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type='file' class="imageUploadPreview" id="image" name="image" accept=".png, .jpg, .jpeg" />
                                                    <label for="image"></label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <div id="image_preview" thumbnail="<?php echo base_url('uploads/user/' . $driver['thumbnail']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary"><?php echo get_phrase('update'); ?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>