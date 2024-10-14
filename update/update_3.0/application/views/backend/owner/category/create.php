<!-- Content Header (Page header) -->
<?php include  'header.php'; ?>
<!-- /.content-header -->

<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo get_phrase('add_form'); ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <form action="<?php echo site_url('category/store'); ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="category_name"><?php echo get_phrase("category_name"); ?></label>
                                <input type="text" id="category_name" class="form-control" name="category_name" placeholder="<?php echo get_phrase("enter_category_name"); ?>" value="">
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
                                        <div id="category_thumbnail_preview" thumbnail="<?php echo base_url('uploads/category/placeholder.png'); ?>"></div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary"><?php echo get_phrase('save_category'); ?></button>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        </div>
    </div>
    <!--/. container-fluid -->
</section>
