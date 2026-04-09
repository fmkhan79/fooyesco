<!-- Content Header (Page header) -->
<?php include  'header.php'; ?>
<!-- /.content-header -->

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
                        
                        <?php if ($category['created_by'] == $this->session->userdata('user_id') || $this->session->userdata("user_role") == "admin") : ?>
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
                    <hr>
                    
                    <div class="" style="padding-left:20px;padding-right:20px;">
                        
                        <a href="<?php echo site_url('subcategory/create/'. $category['id']); ?>">
                            <button style="float:right" class="btn btn-primary">Add Sub Category</button>
                        </a>
                        <br>
                        <br>

                        <table id="categories" class="table table-hover" >
                        <thead style="background-color: #f54748;color:white;">
                            <tr>
                                <th><?php echo "Sub Categories"; ?></th>
                                <th><?php echo "Description"; ?></th>
                                <th><?php echo get_phrase("action"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($sub_categories as $category) : ?>
                                <tr>
                                    <td>
                                        <?php echo sanitize($category['name']); ?>
                                    </td>
                                        <td>
                                        <?php echo sanitize($category['description']); ?>
                                    </td>

                                    <td class="text-center">
                                            <button class="btn action-dropdown" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                            <ul class="dropdown-menu">
                                                
                                                <li><a class="dropdown-item" href="<?php echo site_url('subcategory/edit/' . sanitize($category['id'])); ?>"><?php echo get_phrase("edit"); ?></a></li>
                                                
                                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="confirm_modal('<?php echo site_url('subcategory/delete/' . sanitize($category['id']) . '/' . sanitize($category['category_id'])); ?>')"><?php echo get_phrase("delete"); ?></a></li>
                                            </ul>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><?php echo get_phrase("category_name"); ?></th>
                                <th><?php echo get_phrase("description"); ?></th>
                                <th><?php echo get_phrase("action"); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                    
                </div>

            </div>
        </div>
    </div>
    <!--/. container-fluid -->
</section>
