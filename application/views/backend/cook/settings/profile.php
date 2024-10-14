<!-- Content Header -->
<?php include 'header.php'; ?>
<!-- /.content-header -->
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo get_phrase('update_user_info', true); ?></h3>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo site_url('settings/update'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="settings_type" value="profile">
                            <input type="hidden" name="updater" value="profile">
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label"><?php echo get_phrase('name'); ?><span class='text-danger'>*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="<?php echo get_phrase('provide_name'); ?>" value="<?php echo sanitize($user_info['name']); ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label"><?php echo get_phrase('email'); ?><span class='text-danger'>*</span></label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" class="form-control" id="email" placeholder="<?php echo get_phrase('provide_valid_email'); ?>" value="<?php echo sanitize($user_info['email']); ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-sm-2 col-form-label"><?php echo get_phrase("phone"); ?><span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="<?php echo get_phrase("enter_phone"); ?>" value="<?php echo sanitize($user_info['phone']); ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-sm-2 col-form-label"><?php echo get_phrase("address"); ?></label>
                                <div class="col-sm-10">
                                    <textarea name="address" class="form-control" id="address" rows="5" placeholder="<?php echo get_phrase('enter_full_address'); ?>."><?php echo sanitize($user_info['address']); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="image" class="col-sm-2 col-form-label"><?php echo get_phrase("image"); ?></label>
                                <div class="col-sm-10">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' class="imageUploadPreview" id="image" name="user_image" accept=".png, .jpg, .jpeg" />
                                            <label for="image"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="image_preview" thumbnail="<?php echo base_url('uploads/user/' . $user_info['thumbnail']); ?>">
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