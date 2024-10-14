<!-- Content Header (Page header) -->
<?php include  'header.php'; ?>
<!-- /.content-header -->
<section class="content">
    <div class="container-fluid">
        <!-- Custom Tabs -->
        <div class="card">
            <div class="card-header d-flex p-0">
                <ul class="nav nav-pills p-2">
                    <li class="nav-item"><a href="<?php echo site_url('restaurant/edit/' . sanitize($id) . '/basic'); ?>" class="nav-link <?php if ($active_tab == 'basic') echo 'active' ?>"><?php echo get_phrase('basic_data') ?></a></li>
                    <li class="nav-item"><a href="<?php echo site_url('restaurant/edit/' . sanitize($id) . '/address'); ?>" class="nav-link <?php if ($active_tab == 'address') echo 'active' ?>"><?php echo get_phrase('address_and_phone') ?></a></li>
                    <li class="nav-item"><a href="<?php echo site_url('restaurant/edit/' . sanitize($id) . '/delivery'); ?>" class="nav-link <?php if ($active_tab == 'delivery') echo 'active' ?>"><?php echo get_phrase('delivery_data') ?></a></li>
                    <li class="nav-item"><a href="<?php echo site_url('restaurant/edit/' . sanitize($id) . '/schedule'); ?>" class="nav-link <?php if ($active_tab == 'schedule') echo 'active' ?>"><?php echo get_phrase('schedule') ?></a></li>
                    <li class="nav-item"><a href="<?php echo site_url('restaurant/edit/' . sanitize($id) . '/seo'); ?>" class="nav-link <?php if ($active_tab == 'seo') echo 'active' ?>"><?php echo "SEO"; ?></a></li>
                    <li class="nav-item"><a href="<?php echo site_url('restaurant/edit/' . sanitize($id) . '/gallery'); ?>" class="nav-link <?php if ($active_tab == 'gallery') echo 'active' ?>"><?php echo get_phrase("gallery"); ?></a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane <?php if ($active_tab == 'basic') echo 'active' ?>" id="basic">
                        <form action="<?php echo site_url('restaurant/update/basic'); ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo sanitize($restaurant_data['id']); ?>">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="restaurant_name"><?php echo get_phrase("restaurant_name"); ?></label>
                                        <input type="text" class="form-control" id="restaurant_name" name="restaurant_name" placeholder="<?php echo get_phrase("enter_restaurant_name"); ?>" value="<?php echo sanitize($restaurant_data['name']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cuisine"><?php echo get_phrase("cuisine"); ?></label> <small class="float-right"><a href="<?php echo site_url('cuisine/create'); ?>"><?php echo get_phrase("create_new_cuisine"); ?></a></small>
                                        <select class="form-control select2" name="cuisine[]" multiple="multiple" data-placeholder="<?php echo get_phrase("choose_cuisines"); ?>" required>
                                            <?php foreach ($cuisines as $cuisine) : ?>
                                                <option value="<?php echo sanitize($cuisine['id']); ?>" <?php if (in_array($cuisine['id'], json_decode($restaurant_data['cuisine'], true))) echo "selected"; ?>><?php echo sanitize($cuisine['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <button class="btn btn-primary"><?php echo get_phrase('update_basic_data'); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane <?php if ($active_tab == 'address') echo 'active' ?>" id="address">
                        <form action="<?php echo site_url('restaurant/update/address'); ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo sanitize($restaurant_data['id']); ?>">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="restaurant_address"><?php echo get_phrase("address"); ?></label>
                                        <textarea class="form-control" id="restaurant_address" name="restaurant_address" rows="3" placeholder="<?php echo get_phrase('provide_restaurant_address'); ?>"><?php echo sanitize($restaurant_data['address']); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="restaurant_latitude"><?php echo get_phrase("latitude"); ?></label> <small class="float-right"><a href="https://youtu.be/CgFiSJ11Uk8" target="_blank"><?php echo get_phrase("how_to_get_it"); ?>?</a></small>
                                        <input type="text" id="restaurant_latitude" class="form-control" name="restaurant_latitude" placeholder="<?php echo get_phrase("enter_restaurant_latitude"); ?>" value="<?php echo sanitize($restaurant_data['latitude']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="restaurant_longitude"><?php echo get_phrase("longitude"); ?></label> <small class="float-right"><a href="https://youtu.be/CgFiSJ11Uk8" target="_blank"><?php echo get_phrase("how_to_get_it"); ?>?</a></small>
                                        <input type="text" class="form-control" id="restaurant_longitude" name="restaurant_longitude" placeholder="<?php echo get_phrase("enter_restaurant_longitude"); ?>" value="<?php echo sanitize($restaurant_data['longitude']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="restaurant_phone"><?php echo get_phrase("phone"); ?></label>
                                        <input type="text" class="form-control" id="restaurant_phone" name="restaurant_phone" placeholder="<?php echo get_phrase("enter_restaurant_phone"); ?>" value="<?php echo sanitize($restaurant_data['phone']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="restaurant_website_link"><?php echo get_phrase("restaurant_website_link"); ?></label>
                                        <input type="text" class="form-control" id="restaurant_website_link" name="restaurant_website_link" placeholder="<?php echo get_phrase("enter_restaurant_website_link"); ?>" value="<?php echo sanitize($restaurant_data['website']); ?>" required>
                                    </div>
                                    <button class="btn btn-primary"><?php echo get_phrase('update_address_data'); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane <?php if ($active_tab == 'delivery') echo 'active' ?>" id="delivery">
                        <form action="<?php echo site_url('restaurant/update/delivery'); ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo sanitize($restaurant_data['id']); ?>">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="delivery_charge"><?php echo get_phrase("delivery_charge") . ' (' . currency_code_and_symbol('code') . ')'; ?></label>
                                        <input type="number" id="delivery_charge" class="form-control" name="delivery_charge" placeholder="<?php echo sanitize(get_delivery_settings('delivery_charge')) . ' (' . get_phrase("default") . ') '; ?>" value="<?php echo sanitize($restaurant_data['delivery_charge']); ?>" step=".01">
                                    </div>
                                    <div class="form-group clockpicker">
                                        <label for="maximum_time_to_deliver"><?php echo get_phrase("maximum_time_to_deliver"); ?></label>
                                        <input type="text" class="form-control" id="maximum_time_to_deliver" name="maximum_time_to_deliver" placeholder="<?php echo sanitize(get_delivery_settings('maximum_time_to_deliver')) . ' (' . get_phrase("default") . ') '; ?>" value="<?php echo sanitize($restaurant_data['maximum_time_to_deliver']); ?>">
                                    </div>
                                    <button class="btn btn-primary"><?php echo get_phrase('update_delivery_data'); ?></button>
                                </div>
                                <div class="col-lg-6">
                                    <div class="alert alert-info lighten-info mt-4" role="alert">
                                        <h5 class="alert-heading"><i class="icon fas fa-exclamation-triangle"></i> <?php echo get_phrase('heads_up'); ?>!</h5>
                                        <p><?php echo get_phrase('you_can_overwrite_the_default_delivery_charge_and_maximum_time_to_deliver'); ?>.</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane <?php if ($active_tab == 'schedule') echo 'active' ?>" id="schedule">
                        <form action="<?php echo site_url('restaurant/update/schedule'); ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo sanitize($restaurant_data['id']); ?>">
                            <?php
                            $schedule = json_decode($restaurant_data['schedule'], true);
                            $days = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
                            foreach ($days as $day) : ?>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="<?php echo sanitize($day); ?>_opening"><?php echo get_phrase($day . "_opening"); ?></label>
                                            <input type="time" class="form-control" name="<?php echo sanitize($day); ?>_opening" value="<?php echo isset($schedule[$day . "_opening"]) ? $schedule[$day . "_opening"] : "00:00:00"; ?>">
                                            <div class="custom-control custom-checkbox mt-2">
                                                <input type="checkbox" class="custom-control-input" name="<?php echo sanitize($day); ?>_opening_is_closed" id="<?php echo sanitize($day); ?>_opening_is_closed" value="1" <?php if (isset($schedule[$day . "_opening"]) && $schedule[$day . "_opening"] == "closed") echo "checked"; ?>>
                                                <label class="custom-control-label" for="<?php echo sanitize($day); ?>_opening_is_closed"><?php echo get_phrase('is_closed_this_day'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="<?php echo sanitize($day); ?>_closing"><?php echo get_phrase($day . "_closing"); ?></label>
                                            <input type="time" class="form-control" name="<?php echo sanitize($day); ?>_closing" value="<?php echo isset($schedule[$day . "_closing"]) ? $schedule[$day . "_closing"] : "00:00:00"; ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <button class="btn btn-primary"><?php echo get_phrase('update_schedule'); ?></button>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane <?php if ($active_tab == 'seo') echo 'active' ?>" id="seo">
                        <form action="<?php echo site_url('restaurant/update/seo'); ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo sanitize($restaurant_data['id']); ?>">
                            <div class="form-group">
                                <label for="tags"><?php echo "SEO " . get_phrase("tags"); ?></label>
                                <input type="text" id="tags" class="tagged form-control" data-removeBtn="true" name="seo_tags" value="<?php echo sanitize($restaurant_data['seo_tags']); ?>" placeholder="<?php echo get_phrase("enter_tags_and_press_enter"); ?>">
                            </div>
                            <div class="form-group">
                                <label for="description"><?php echo "SEO " . get_phrase("description"); ?></label>
                                <textarea class="form-control" id="description" name="seo_description" rows="5" cols="80" placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_data['seo_description']); ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary"><?php echo get_phrase('update') . ' SEO ' . get_phrase('data'); ?></button>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane <?php if ($active_tab == 'gallery') echo 'active' ?>" id="gallery">
                        <form action="<?php echo site_url('restaurant/update/gallery'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo sanitize($restaurant_data['id']); ?>">

                            <!-- RESTAURANT THUMBNAIL -->
                            <div class="form-group">
                                <label for="restaurant_thumbnail"><?php echo get_phrase("restaurant_thumbnail"); ?> <span class="badge badge-default">(400 X 291)</span></label>
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' class="imageUploadPreview" id="restaurant_thumbnail" name="restaurant_thumbnail" accept=".png, .jpg, .jpeg" />
                                        <label for="restaurant_thumbnail"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="restaurant_thumbnail_preview" thumbnail="<?php echo base_url('uploads/restaurant/thumbnail/' . sanitize($restaurant_data['thumbnail'])); ?>"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- RESTAURANT GALLERY IMAGES -->
                            <div class="row">
                                <?php
                                $restaurant_gallery_images = empty($restaurant_data['gallery']) ? ['placeholder.png', 'placeholder.png', 'placeholder.png', 'placeholder.png', 'placeholder.png', 'placeholder.png'] : json_decode($restaurant_data['gallery']);
                                for ($counter = 1; $counter <= 6; $counter++) : ?>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for='<?php echo "restaurant_gallery_$counter"; ?>'><?php echo get_phrase("restaurant_gallery") . ' ' . $counter; ?> <span class="badge badge-default">(672 X 414)</span> </label>
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type='file' class="imageUploadPreview" id='<?php echo "restaurant_gallery_$counter"; ?>' name='<?php echo "restaurant_gallery_$counter"; ?>' accept=".png, .jpg, .jpeg" />
                                                    <label for='<?php echo "restaurant_gallery_$counter"; ?>'></label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <div id='<?php echo "restaurant_gallery_" . $counter . "_preview"; ?>' thumbnail="<?php echo base_url('uploads/restaurant/gallery/' . $restaurant_gallery_images[$counter - 1]); ?>"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                            <button type="submit" class="btn btn-primary"><?php echo get_phrase('update_gallery'); ?></button>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- ./card -->
    </div>
    <!--/. container-fluid -->
</section>