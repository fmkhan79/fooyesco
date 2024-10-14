<!-- Content Header (Page header) -->
<?php include  'header.php'; ?>
<!-- /.content-header -->

<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo get_phrase('edit_form'); ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <?php if ($category['created_by'] == $this->session->userdata('user_id')) : ?>
                            <form action="<?php echo site_url('category/update'); ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo sanitize($category['id']); ?>">
                                <div class="form-group">
                                    <label for="category_name"><?php echo get_phrase("category_name"); ?></label>
                                    <input type="text" id="category_name" class="form-control" name="category_name" placeholder="<?php echo get_phrase("enter_category_name"); ?>" value="<?php echo sanitize($category['name']); ?>">
                                </div>
                                <!-- CATEGORY THUMBNAIL -->
                                <div class="form-group">
                                    <label for="category_thumbnail"><?php echo get_phrase("category_thumbnail"); ?> <span class="badge badge-default">(512 X 512)</span></label>
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' class="imageUploadPreview" id="category_thumbnail" name="category_thumbnail" accept=".png, .jpg, .jpeg" />
                                            <label for="category_thumbnail"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="category_thumbnail_preview" thumbnail="<?php echo base_url('uploads/category/' . sanitize($category['thumbnail'])); ?>"></div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary"><?php echo get_phrase('save_category'); ?></button>
                            </form>
                        <?php else : ?>
                            <div class="alert alert-danger lighten-danger alert-dismissible">
                                <i class="icon fas fa-exclamation-triangle"></i> <strong><?php echo get_phrase('oops'); ?></strong>!
                                <?php echo get_phrase('you_are_not_authorized_to_modify_this'); ?>.
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        </div>
    </div>
    <!--/. container-fluid -->
</section>
