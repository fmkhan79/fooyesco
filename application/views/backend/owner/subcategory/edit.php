<!-- Content Header (Page header) -->
<?php include  'header.php'; ?>
<!-- /.content-header -->
<br>
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12 ">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo get_phrase('edit_form'); ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <?php
                            // dd($subcategory);
                        ?>
                        
                        <?php if ($category['created_by'] == $this->session->userdata('user_id') || $this->session->userdata("user_role") == "admin") : ?>
                            <form action="<?php echo site_url('subcategory/update'); ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo sanitize($subcategory['id']); ?>">
                                <div class="form-group">
                                    <label for="category_name">Sub Category Name:</label>
                                    <input type="text" id="category_name" class="form-control" name="category_name" placeholder="Enter Sub Category Name" required value="<?php echo sanitize($subcategory['name']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="category_description">Sub Category Description:</label>
                                    <input type="text" id="category_description" class="form-control" name="category_description" placeholder="Enter Sub Category Description" required value="<?php echo sanitize($subcategory['description']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="category_description">Category:</label>
                                    <select class="form-control" name="category_id" id="category_id" required>
                                        <?php foreach ($categories as $category) : ?>
                                            <option value="<?php echo sanitize($category['id']); ?>" <?php if ($subcategory['category_id'] == $category['id']) echo 'selected'; ?>>
                                                <?php echo sanitize($category['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button class="btn btn-primary">Save Sub Category </button>
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
