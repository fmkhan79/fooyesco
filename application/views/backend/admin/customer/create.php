<!-- Content Header (Page header) -->
<?php include  'header.php'; ?>
<!-- /.content-header -->
<section class="content">
    <div class="container-fluid">
        <!-- Custom Tabs -->
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#basic" data-toggle="tab"><?php echo get_phrase('basic'); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="#address_1" data-toggle="tab"><?php echo get_phrase('address_1'); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="#address_2" data-toggle="tab"><?php echo get_phrase('address_2'); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="#address_3" data-toggle="tab"><?php echo get_phrase('address_3'); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="#finish" data-toggle="tab"><?php echo get_phrase('finish'); ?></a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <form action="<?php echo site_url('customer/store'); ?>" method="post" enctype="multipart/form-data">
                    <div class="tab-content">
                        <div class="tab-pane active" id="basic">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name"><?php echo get_phrase("name"); ?><span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="<?php echo get_phrase("enter_name"); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="email"><?php echo get_phrase("email"); ?><span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="<?php echo get_phrase("enter_valid_email"); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="password"><?php echo get_phrase("password"); ?><span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo get_phrase("enter_password"); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="phone"><?php echo get_phrase("phone"); ?><span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="<?php echo get_phrase("enter_phone"); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="image"><?php echo get_phrase("image"); ?></label>
                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' class="imageUploadPreview" id="image" name="image" accept=".png, .jpg, .jpeg" />
                                                <label for="image"></label>
                                            </div>
                                            <div class="avatar-preview">
                                                <div id="image_preview" thumbnail="<?php echo base_url('uploads/user/placeholder.png'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="address_1">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="address_1"><?php echo get_phrase("address_1"); ?><span class='text-danger'>*</span></label>
                                        <textarea name="address_1" class="form-control" id="address_1" rows="5" placeholder="<?php echo get_phrase('enter_full_address'); ?>."></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="latitude_1"><?php echo get_phrase("latitude_for_address_1"); ?><span class='text-danger'>*</span></label> <small class="float-right"><a href="https://youtu.be/CgFiSJ11Uk8" target="_blank"><?php echo get_phrase("how_to_get_it"); ?>?</a></small>
                                        <input type="text" class="form-control" id="latitude_1" name="latitude_1" placeholder="<?php echo get_phrase("enter_latitude"); ?>">
                                        <small class="text-muted"><?php echo get_phrase('provide_latitude_for_exact_location'); ?></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="longitude_1"><?php echo get_phrase("longitude_for_address_1"); ?><span class='text-danger'>*</span></label> <small class="float-right"><a href="https://youtu.be/CgFiSJ11Uk8" target="_blank"><?php echo get_phrase("how_to_get_it"); ?>?</a></small>
                                        <input type="text" class="form-control" id="longitude_1" name="longitude_1" placeholder="<?php echo get_phrase("enter_longitude"); ?>">
                                        <small class="text-muted"><?php echo get_phrase('provide_longitude_for_exact_location'); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="address_2">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="address_2"><?php echo get_phrase("address_2"); ?></label>
                                        <textarea name="address_2" class="form-control" id="address_2" rows="5" placeholder="<?php echo get_phrase('enter_full_address'); ?>."></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="latitude_2"><?php echo get_phrase("latitude_for_address_2"); ?></label> <small class="float-right"><a href="https://youtu.be/CgFiSJ11Uk8" target="_blank"><?php echo get_phrase("how_to_get_it"); ?>?</a></small>
                                        <input type="text" class="form-control" id="latitude_2" name="latitude_2" placeholder="<?php echo get_phrase("enter_latitude"); ?>">
                                        <small class="text-muted"><?php echo get_phrase('provide_latitude_for_exact_location'); ?></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="longitude_2"><?php echo get_phrase("longitude_for_address_2"); ?></label> <small class="float-right"><a href="https://youtu.be/CgFiSJ11Uk8" target="_blank"><?php echo get_phrase("how_to_get_it"); ?>?</a></small>
                                        <input type="text" class="form-control" id="longitude_2" name="longitude_2" placeholder="<?php echo get_phrase("enter_longitude"); ?>">
                                        <small class="text-muted"><?php echo get_phrase('provide_longitude_for_exact_location'); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="address_3">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="address_3"><?php echo get_phrase("address_3"); ?></label>
                                        <textarea name="address_3" class="form-control" id="address_3" rows="5" placeholder="<?php echo get_phrase('enter_full_address'); ?>."></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="latitude_3"><?php echo get_phrase("latitude_for_address_3"); ?></label> <small class="float-right"><a href="https://youtu.be/CgFiSJ11Uk8" target="_blank"><?php echo get_phrase("how_to_get_it"); ?>?</a></small>
                                        <input type="text" class="form-control" id="latitude_3" name="latitude_3" placeholder="<?php echo get_phrase("enter_latitude"); ?>">
                                        <small class="text-muted"><?php echo get_phrase('provide_latitude_for_exact_location'); ?></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="longitude_3"><?php echo get_phrase("longitude_for_address_3"); ?></label> <small class="float-right"><a href="https://youtu.be/CgFiSJ11Uk8" target="_blank"><?php echo get_phrase("how_to_get_it"); ?>?</a></small>
                                        <input type="text" class="form-control" id="longitude_3" name="longitude_3" placeholder="<?php echo get_phrase("enter_longitude"); ?>">
                                        <small class="text-muted"><?php echo get_phrase('provide_longitude_for_exact_location'); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="finish">
                            <div class="row justify-content-center">
                                <div class="col text-center">
                                    <h1 class="my-3 text-primary"><i class="far fa-smile"></i></h1>
                                    <h3 class="my-3 "><?php echo get_phrase('thank_you', true); ?>!</h3>
                                    <h5 class="font-weight-light"><?php echo get_phrase('you_are_just_one_click_away'); ?>...</h5>
                                    <button type="submit" class="btn btn-primary mt-5"><?php echo get_phrase('save_customer'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- /.card-body -->
        </div>
        <!-- ./card -->
    </div>
    <!--/. container-fluid -->
</section>
