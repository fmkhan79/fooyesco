<!-- Content Header -->
<?php include 'header.php'; ?>
<!-- /.content-header -->
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab"><?php echo get_phrase('profile'); ?></a></li>
                            <li class="nav-item"><a class="nav-link" href="#address_1" data-toggle="tab"><?php echo get_phrase('address_1'); ?></a></li>
                            <li class="nav-item"><a class="nav-link" href="#address_2" data-toggle="tab"><?php echo get_phrase('address_2'); ?></a></li>
                            <li class="nav-item"><a class="nav-link" href="#address_3" data-toggle="tab"><?php echo get_phrase('address_3'); ?></a></li>
                            <li class="nav-item"><a class="nav-link" href="#finish" data-toggle="tab"><?php echo get_phrase('finish'); ?></a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- /.tab-pane -->
                            <div class="active tab-pane" id="profile">
                                <form action="<?php echo site_url('settings/update'); ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="settings_type" value="profile">
                                    <input type="hidden" name="updater" value="profile">
                                    <input type="hidden" name="id" value="<?php echo sanitize($user_info['id']); ?>">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label"><?php echo get_phrase('name'); ?><span class='text-danger'>*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" class="form-control" id="name" placeholder="<?php echo get_phrase('provide_name'); ?>" value="<?php echo sanitize($user_info['name']); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label"><?php echo get_phrase('email'); ?><span class='text-danger'>*</span></label>
                                        <div class="col-sm-10">
                                            <input type="email" name="email" class="form-control" id="email" placeholder="<?php echo get_phrase('provide_valid_email'); ?>" value="<?php echo sanitize($user_info['email']); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="phone" class="col-sm-2 col-form-label"><?php echo get_phrase("phone"); ?><span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="<?php echo get_phrase("enter_phone"); ?>" value="<?php echo sanitize($user_info['phone']); ?>">
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
                                                    <div id="image_preview" thumbnail="<?php echo base_url('uploads/user/' . sanitize($user_info['thumbnail'])); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="tab-pane" id="address_1">
                                <div class="form-group row">
                                    <label for="address_1" class="col-sm-2 col-form-label"><?php echo get_phrase('address_1'); ?><span class='text-danger'>*</span></label>
                                    <div class="col-sm-10">
                                        <textarea name="address_1" class="form-control" id="address_1" rows="5" placeholder="<?php echo get_phrase('provide_full_address'); ?>."><?php echo sanitize($user_info['address_1']); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="latitude_1" class="col-sm-2 col-form-label"><?php echo get_phrase('latitude'); ?><span class='text-danger'>*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="latitude_1" class="form-control" id="latitude_1" placeholder="<?php echo get_phrase('latitude_for_address_1'); ?>" value="<?php echo sanitize($user_info['coordinate_1']['latitude']); ?>">
                                        <small class="float-right"><a href="https://youtu.be/CgFiSJ11Uk8" target="_blank"><?php echo get_phrase("how_to_get_it"); ?>?</a></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="longitude_1" class="col-sm-2 col-form-label"><?php echo get_phrase("longitude"); ?><span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="longitude_1" name="longitude_1" placeholder="<?php echo get_phrase("longitude_for_address_1"); ?>" value="<?php echo sanitize($user_info['coordinate_1']['longitude']); ?>">
                                        <small class="float-right"><a href="https://youtu.be/CgFiSJ11Uk8" target="_blank"><?php echo get_phrase("how_to_get_it"); ?>?</a></small>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="address_2">
                                <div class="form-group row">
                                    <label for="address_2" class="col-sm-2 col-form-label"><?php echo get_phrase('address_2'); ?></label>
                                    <div class="col-sm-10">
                                        <textarea name="address_2" class="form-control" id="address_2" rows="5" placeholder="<?php echo get_phrase('provide_full_address'); ?>."><?php echo sanitize($user_info['address_2']); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="latitude_2" class="col-sm-2 col-form-label"><?php echo get_phrase('latitude'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="latitude_2" class="form-control" id="latitude_2" placeholder="<?php echo get_phrase('latitude_for_address_2'); ?>" value="<?php echo sanitize($user_info['coordinate_2']['latitude']); ?>">
                                        <small class="float-right"><a href="https://youtu.be/CgFiSJ11Uk8" target="_blank"><?php echo get_phrase("how_to_get_it"); ?>?</a></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="longitude_2" class="col-sm-2 col-form-label"><?php echo get_phrase("longitude"); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="longitude_2" name="longitude_2" placeholder="<?php echo get_phrase("longitude_for_address_2"); ?>" value="<?php echo sanitize($user_info['coordinate_2']['longitude']); ?>">
                                        <small class="float-right"><a href="https://youtu.be/CgFiSJ11Uk8" target="_blank"><?php echo get_phrase("how_to_get_it"); ?>?</a></small>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="address_3">
                                <div class="form-group row">
                                    <label for="address_3" class="col-sm-2 col-form-label"><?php echo get_phrase('address_3'); ?></label>
                                    <div class="col-sm-10">
                                        <textarea name="address_3" class="form-control" id="address_3" rows="5" placeholder="<?php echo get_phrase('provide_full_address'); ?>."><?php echo sanitize($user_info['address_3']); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="latitude_3" class="col-sm-2 col-form-label"><?php echo get_phrase('latitude'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="latitude_3" class="form-control" id="latitude_3" placeholder="<?php echo get_phrase('latitude_for_address_3'); ?>" value="<?php echo sanitize($user_info['coordinate_3']['latitude']); ?>">
                                        <small class="float-right"><a href="https://youtu.be/CgFiSJ11Uk8" target="_blank"><?php echo get_phrase("how_to_get_it"); ?>?</a></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="longitude_3" class="col-sm-2 col-form-label"><?php echo get_phrase("longitude"); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="longitude_3" name="longitude_3" placeholder="<?php echo get_phrase("longitude_for_address_3"); ?>" value="<?php echo sanitize($user_info['coordinate_3']['longitude']); ?>">
                                        <small class="float-right"><a href="https://youtu.be/CgFiSJ11Uk8" target="_blank"><?php echo get_phrase("how_to_get_it"); ?>?</a></small>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="finish">
                                <div class="row justify-content-center">
                                    <div class="col text-center">
                                        <h1 class="my-3 text-primary"><i class="far fa-smile"></i></h1>
                                        <h3 class="my-3 "><?php echo get_phrase('thank_you', true); ?>!</h3>
                                        <h5 class="font-weight-light"><?php echo get_phrase('you_are_just_one_click_away'); ?>...</h5>
                                        <button type="submit" class="btn btn-primary mt-5"><?php echo get_phrase('update_profile'); ?></button>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo get_phrase('update_password', true); ?></h3>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo site_url('settings/update'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="settings_type" value="profile">
                            <input type="hidden" name="updater" value="password">
                            <div class="form-group">
                                <label for="current_password"><?php echo get_phrase("current_password"); ?><span class="text-danger">*</span></label>
                                <input type="password" id="current_password" class="form-control" name="current_password" placeholder="<?php echo get_phrase("enter_your_current_password"); ?>" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password"><?php echo get_phrase("new_password"); ?><span class="text-danger">*</span></label>
                                <input type="password" id="new_password" class="form-control" name="new_password" placeholder="<?php echo get_phrase("enter_your_new_password"); ?>" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password"><?php echo get_phrase("confirm_password"); ?><span class="text-danger">*</span></label>
                                <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="<?php echo get_phrase("confirm_password"); ?>" value="" required>
                            </div>
                            <button class="btn btn-primary"><?php echo get_phrase('update_your_password', true); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/. container-fluid -->
</section>
