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
                    <form action="<?php echo site_url('subcategory/store'); ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="category_name">Sub Category Name</label>
                                <input type="text" id="category_name" class="form-control" name="category_name" placeholder="Enter Sub Category Name" value="">
                            </div>
                        <div class="form-group">
                            <label for="category_description">Sub Category Description:</label>
                            <input type="text" id="category_description" class="form-control" name="category_description" placeholder="Enter Sub Category Description" required value="<?php echo sanitize($subcategory['description']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="category_description">Category:</label>
                            
                            <select class="form-control" name="category_id" id="category_id" required>
                                
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?php echo sanitize($category['id']); ?>" <?php if ($category_id == $category['id']) echo 'selected'; ?>>
                                        <?php echo sanitize($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- CATEGORY THUMBNAIL -->
                        
                        <button class="btn btn-primary">Save Sub Category</button>

                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        </div>
    </div>
    <!--/. container-fluid -->
</section>
