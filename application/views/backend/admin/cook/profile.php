<!-- Content Header (Page header) -->
<?php include  'header.php'; ?>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <!-- /.col -->
            <div class="col-md-6">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo get_phrase('cook_registration_form', true); ?></h3>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="<?php echo site_url('cook/update'); ?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo sanitize($cook['id']); ?>">
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label"><?php echo get_phrase('name'); ?><span class='text-danger'>*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="<?php echo get_phrase('provide_name'); ?>" value="<?php echo sanitize($cook['name']); ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label"><?php echo get_phrase('email'); ?><span class='text-danger'>*</span></label>
                                <div class="col-sm-8">
                                    <input type="email" name="email" class="form-control" id="email" placeholder="<?php echo get_phrase('provide_valid_email'); ?>" value="<?php echo sanitize($cook['email']); ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-sm-4 col-form-label"><?php echo get_phrase("phone"); ?><span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="<?php echo get_phrase("enter_phone"); ?>" value="<?php echo sanitize($cook['phone']); ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-sm-4 col-form-label"><?php echo get_phrase("address"); ?></label>
                                <div class="col-sm-8">
                                    <textarea name="address" class="form-control" id="address" rows="5" placeholder="<?php echo get_phrase('enter_full_address'); ?>."><?php echo sanitize(isset($cook['address']) ? $cook['address'] : ""); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image" class="col-sm-4 col-form-label"><?php echo get_phrase("image"); ?></label>
                                <div class="col-sm-8">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' class="imageUploadPreview" id="image" name="image" accept=".png, .jpg, .jpeg" />
                                            <label for="image"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="image_preview" thumbnail="<?php echo base_url('uploads/user/' . $cook['thumbnail']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-sm-8 text-center">
                                    <button type="submit" class="btn btn-primary"><?php echo get_phrase('update'); ?></button>
                                </div>
                            </div>
                        </form>
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