<!-- Content Header -->
<?php include 'header.php'; ?>
<!-- /.content-header -->
<?php $social_links = json_decode(get_website_settings('social_links'), true); ?>
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo get_phrase('website_info', true); ?></h3>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo site_url('settings/update'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="settings_type" value="website">
                            <div class="form-group">
                                <label for="title"><?php echo get_phrase("title"); ?><span class = "text-danger">*</span></label>
                                <input type="text" id="title" class="form-control" name="title" placeholder="<?php echo get_phrase("enter_title"); ?>" value="<?php echo sanitize(get_website_settings('title')); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="sub_title"><?php echo get_phrase("sub_title"); ?><span class = "text-danger">*</span></label>
                                <input type="text" id="sub_title" class="form-control" name="sub_title" placeholder="<?php echo get_phrase("enter_sub_title"); ?>" value="<?php echo sanitize(get_website_settings('sub_title')); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="facebook_link"><?php echo get_phrase("facebook_link"); ?></label>
                                <input type="text" id="facebook_link" class="form-control" name="facebook_link" placeholder="<?php echo get_phrase("enter_facebook_link"); ?>" value="<?php echo sanitize($social_links['facebook']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="twitter_link"><?php echo get_phrase("twitter_link"); ?></label>
                                <input type="text" id="twitter_link" class="form-control" name="twitter_link" placeholder="<?php echo get_phrase("enter_twitter_link"); ?>" value="<?php echo sanitize($social_links['twitter']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="instagram_link"><?php echo get_phrase("instagram_link"); ?></label>
                                <input type="text" id="instagram_link" class="form-control" name="instagram_link" placeholder="<?php echo get_phrase("enter_instagram_link"); ?>" value="<?php echo sanitize($social_links['instagram']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="about_us"><?php echo get_phrase("about_us"); ?></label>
                                <textarea name="about_us" class="summernote-custom-styles" id = "about_us" placeholder="<?php echo get_phrase('provide_your_text_here'); ?>"><?php echo get_website_settings('about_us'); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="privacy_policy"><?php echo get_phrase("privacy_policy"); ?></label>
                                <textarea name="privacy_policy" class="summernote-custom-styles" id = "privacy_policy" placeholder="<?php echo get_phrase('provide_your_text_here'); ?>"><?php echo get_website_settings('privacy_policy'); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="terms_and_conditions"><?php echo get_phrase("terms_and_conditions"); ?></label>
                                <textarea name="terms_and_conditions" class="summernote-custom-styles" id = "terms_and_conditions" placeholder="<?php echo get_phrase('provide_your_text_here'); ?>"><?php echo get_website_settings('terms_and_conditions'); ?></textarea>
                            </div>

                            <button class="btn btn-primary"><?php echo get_phrase('update_website_settings', true); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo get_phrase('website_gallery', true); ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                <form action="<?php echo site_url('settings/update'); ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="settings_type" value="gallery">
                                    <input type="hidden" name="gallery_type" value="banner_image">
                                    <div class="form-group">
                                        <label for="banner_image"><?php echo get_phrase("banner_image"); ?> <span class="badge badge-default">(1603 X 828)</span></label>
                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' class="imageUploadPreview" id="banner_image" name="banner_image" accept=".png, .jpg, .jpeg" />
                                                <label for="banner_image"></label>
                                            </div>
                                            <div class="avatar-preview">
                                                <div id="banner_image_preview" thumbnail="<?php echo base_url('uploads/system/'.get_website_settings('banner_image')); ?>"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary"><?php echo get_phrase('update_banner_image', true); ?></button>
                                </form>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                <form action="<?php echo site_url('settings/update'); ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="settings_type" value="gallery">
                                    <input type="hidden" name="gallery_type" value="backend_logo">
                                    <div class="form-group">
                                        <label for="backend_logo"><?php echo get_phrase("backend_logo"); ?> <span class="badge badge-default">(128 X 128)</span></label>
                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' class="imageUploadPreview" id="backend_logo" name="backend_logo" accept=".png, .jpg, .jpeg" />
                                                <label for="backend_logo"></label>
                                            </div>
                                            <div class="avatar-preview">
                                                <div id="backend_logo_preview" thumbnail="<?php echo base_url('uploads/system/'.get_website_settings('backend_logo')); ?>"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary"><?php echo get_phrase('update_backend_logo', true); ?></button>
                                </form>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                <form action="<?php echo site_url('settings/update'); ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="settings_type" value="gallery">
                                    <input type="hidden" name="gallery_type" value="website_logo">
                                    <div class="form-group">
                                        <label for="website_logo"><?php echo get_phrase("website_logo"); ?> <span class="badge badge-default">(128 X 128)</span></label>
                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' class="imageUploadPreview" id="website_logo" name="website_logo" accept=".png, .jpg, .jpeg" />
                                                <label for="website_logo"></label>
                                            </div>
                                            <div class="avatar-preview">
                                                <div id="website_logo_preview" thumbnail="<?php echo base_url('uploads/system/'.get_website_settings('website_logo')); ?>"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary"><?php echo get_phrase('update_website_logo', true); ?></button>
                                </form>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                <form action="<?php echo site_url('settings/update'); ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="settings_type" value="gallery">
                                    <input type="hidden" name="gallery_type" value="favicon">
                                    <div class="form-group">
                                        <label for="favicon"><?php echo get_phrase("favicon"); ?> <span class="badge badge-default">(80 X 80)</span></label>
                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' class="imageUploadPreview" id="favicon" name="favicon" accept=".png, .jpg, .jpeg" />
                                                <label for="favicon"></label>
                                            </div>
                                            <div class="avatar-preview">
                                                <div id="favicon_preview" thumbnail="<?php echo base_url('uploads/system/'.get_website_settings('favicon')); ?>"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary"><?php echo get_phrase('update_favicon', true); ?></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->
