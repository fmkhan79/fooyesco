<!-- Content Header (Page header) -->
<?php include  'header.php'; ?>
<style>
/*
Source - https://stackoverflow.com/a/79274945
Posted by Naeem Akhtar
Retrieved 2026-03-14, License - CC BY-SA 4.0
*/

.toggle {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.toggle input {
  display: none;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #333;
  transition: 0.4s;
  border-radius: 34px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: #FFF;
  transition: 0.4s;
  border-radius: 50%;
}

input:checked + .slider {
  background-color: #f54748;
}

input:checked + .slider:before {
  transform: translateX(26px);
}
    </style>
<!-- /.content-header -->
<section class="content">
    <div class="container-fluid">
        <!-- Custom Tabs -->
        <div class="card">
            <div class="card-header d-flex p-0">
                <ul class="nav nav-pills p-2">
                    <li class="nav-item"><a
                            href="<?php echo site_url('restaurant/edit/' . sanitize($id) . '/basic'); ?>"
                            class="nav-link <?php if ($active_tab == 'basic') echo 'active' ?>"><?php echo get_phrase('basic_data') ?></a>
                    </li>
                    <li class="nav-item"><a
                            href="<?php echo site_url('restaurant/edit/' . sanitize($id) . '/address'); ?>"
                            class="nav-link <?php if ($active_tab == 'address') echo 'active' ?>"><?php echo get_phrase('address_and_phone') ?></a>
                    </li>
                    <li class="nav-item"><a
                            href="<?php echo site_url('restaurant/edit/' . sanitize($id) . '/delivery'); ?>"
                            class="nav-link <?php if ($active_tab == 'delivery') echo 'active' ?>"><?php echo get_phrase('delivery_data') ?></a>
                    </li>
                    <li class="nav-item"><a href="<?php echo site_url('restaurant/edit/' . sanitize($id) . '/seo'); ?>"
                            class="nav-link <?php if ($active_tab == 'seo') echo 'active' ?>"><?php echo "SEO Settings"; ?></a>
                    </li>
                    <li class="nav-item"><a
                            href="<?php echo site_url('restaurant/edit/' . sanitize($id) . '/gallery'); ?>"
                            class="nav-link <?php if ($active_tab == 'gallery') echo 'active' ?>"><?php echo get_phrase("gallery"); ?></a>
                    </li>
                    <li class="nav-item"><a href="<?php echo site_url('restaurant/edit/' . sanitize($id) . '/offers'); ?>" class="nav-link <?php if ($active_tab == 'offers') echo 'active' ?>"><?php echo get_phrase("Offers") . "/Discounts" ?></a></li>

                    <li class="nav-item"><a href="<?php echo site_url('restaurant/edit/' . sanitize($id) . '/visibility'); ?>" class="nav-link <?php if ($active_tab == 'visibility') echo 'active' ?>"><?php echo get_phrase("Visibility"); ?></a></li>
                    
                    <li class="nav-item"><a href="<?php echo site_url('restaurant/edit/' . sanitize($id) . '/timings'); ?>" class="nav-link <?php if ($active_tab == 'timings') echo 'active' ?>">Timings</a></li>

                   <li class="nav-item"><a href="<?php echo site_url('restaurant/edit/' . sanitize($id) . '/emails'); ?>" class="nav-link <?php if ($active_tab == 'emails') echo 'active' ?>"><?php echo get_phrase("Email Settings"); ?></a></li>

                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane <?php if ($active_tab == 'basic') echo 'active' ?>" id="basic">
                        <form action="<?php echo site_url('restaurant/update/basic'); ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo sanitize($restaurant_data['id']); ?>">
                            <div class="row">
                                <div class="col-lg-6" style="padding-right:20px; border-right:1px solid lightgrey">
                                    <h2 style="display: flex;justify-content: space-between;align-items: flex-end;"> <?= $restaurant_data['fooyes_url'] ?><small class="text-muted text-sm">(Fooyes)</small></h2>

                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">fooyes.co.uk/</span>
                                            </div>
                                            <input type="text" class="form-control" name="slug" placeholder="Slug" value="<?php echo sanitize($restaurant_data['slug']); ?>" aria-label="Slug" aria-describedby="basic-addon1">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="restaurant_name"><b>H1 Tag Line</b></label>
                                        <input type="text" class="form-control" id="restaurant_name"
                                            name="restaurant_name"
                                            placeholder="<?php echo get_phrase("enter_restaurant_name"); ?>"
                                            value="<?php echo sanitize($restaurant_data['name']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="tag_line">H2 Tag Line</label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="tag_line"
                                            placeholder="Enter Meta Title "
                                            value="<?php echo sanitize($restaurant_data['tag_line']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="restaurant_about">About Restaurant <small>(Shown on resturant detail page)</small></label>
                                        <textarea class="form-control" id="restaurant_about" name="restaurant_about" rows="3" placeholder="About Restaurant"><?php echo sanitize($restaurant_data['restaurant_about']); ?></textarea>
                                    </div>


                                    <div class="form-group">
                                        <label for="cuisine"><?php echo get_phrase("cuisine"); ?></label>
                                        <select class="form-control select2" name="cuisine[]" multiple="multiple"
                                            data-placeholder="<?php echo get_phrase("choose_cuisines"); ?>" required>
                                            <?php foreach ($cuisines as $cuisine) : ?>
                                                <option value="<?php echo sanitize($cuisine['id']); ?>"
                                                    <?php if (in_array($cuisine['id'], json_decode($restaurant_data['cuisine'], true))) echo "selected"; ?>>
                                                    <?php echo sanitize($cuisine['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>


                                    <!-- standlaone -->



                                    <button
                                        class="btn btn-primary"><?php echo get_phrase('update_basic_data'); ?></button>
                                </div>
                                <div class="col-lg-6" style="padding-left:20px;">
                                    <h2 style="display: flex;justify-content: space-between;align-items: flex-end;"> <?= $restaurant_data['standalone_url'] ?><small class="text-muted text-sm">(Standalone)</small></h2>

                                    <div class="form-group">
                                        <label
                                            for="restaurant_name_standalone">H1 Tag Line</label>
                                        <input type="text" class="form-control" id="restaurant_name_standalone"
                                            name="restaurant_name_standalone"
                                            placeholder="<?php echo get_phrase("enter_restaurant_name"); ?>"
                                            value="<?php echo sanitize($restaurant_data['restaurant_name_standalone']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="tag_line_standalone">H2 Tag Line</label>
                                        <input type="text" class="form-control" id="tag_line_standalone"
                                            name="tag_line_standalone"
                                            placeholder="<?php echo get_phrase("tag_line_standalone"); ?>"
                                            value="<?php echo sanitize($restaurant_data['tag_line_standalone']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="restaurant_about">About Restaurant <small>(Shown on resturant detail page)</small></label>
                                        <textarea class="form-control" id="restaurant_about_standalone" name="restaurant_about_standalone" rows="3" placeholder="About Restaurant"><?php echo sanitize($restaurant_data['restaurant_about_standalone']); ?></textarea>
                                    </div>



                                    <div class="form-group">
                                        <label for="cuisine_standalone">
                                            <?php echo get_phrase("cuisine"); ?>
                                        </label>

                                        <select class="form-control select2" name="cuisine_standalone[]" multiple="multiple"
                                            data-placeholder="<?php echo get_phrase("choose_cuisines"); ?>">

                                            <?php foreach ($cuisines as $cuisine) : ?>

                                                <option value="<?php echo sanitize($cuisine['id']); ?>"
                                                    <?php
                                                    if (in_array($cuisine['id'], json_decode($restaurant_data['cuisine_standalone'], true) ?? []))
                                                        echo "selected";
                                                    ?>>

                                                    <?php echo sanitize($cuisine['name']); ?>

                                                </option>

                                            <?php endforeach; ?>

                                        </select>
                                    </div>
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
                                        <input class="form-control" id="restaurant_address" name="restaurant_address"
                                            placeholder="<?php echo get_phrase('provide_restaurant_address'); ?>" value="<?php echo sanitize($restaurant_data['address']); ?>" required />
                                    </div>
                                    <input type="hidden" id="restaurant_latitude" class="form-control"
                                        name="restaurant_latitude"
                                        placeholder="<?php echo get_phrase("enter_restaurant_latitude"); ?>"
                                        value="<?php echo sanitize($restaurant_data['latitude']); ?>" required>
                                    <input type="hidden" class="form-control" id="restaurant_longitude"
                                        name="restaurant_longitude"
                                        placeholder="<?php echo get_phrase("enter_restaurant_longitude"); ?>"
                                        value="<?php echo sanitize($restaurant_data['longitude']); ?>" required>
                                    <div class="form-group">
                                        <label for="restaurant_phone"><?php echo get_phrase("phone"); ?></label>
                                        <input type="text" class="form-control" id="restaurant_phone"
                                            name="restaurant_phone"
                                            placeholder="<?php echo get_phrase("enter_restaurant_phone"); ?>"
                                            value="<?php echo sanitize($restaurant_data['phone']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="restaurant_website_link"><?php echo get_phrase("restaurant_website_link"); ?></label>
                                        <input type="text" class="form-control" id="restaurant_website_link"
                                            name="restaurant_website_link"
                                            placeholder="<?php echo get_phrase("enter_restaurant_website_link"); ?>"
                                            value="<?php echo sanitize($restaurant_data['website']); ?>" required>
                                    </div>
                                    <button
                                        class="btn btn-primary"><?php echo get_phrase('update_address_data'); ?></button>
                                </div>

                                <div class="col-lg-6">
                                    <div class="pac-card" id="pac-card">
                                        <div>
                                            <div id="title">Search Address</div>
                                        </div>
                                    </div>
                                    <div id="map" style="height:100%"></div>
                                    <div id="infowindow-content">
                                        <span id="place-name" class="title"></span><br />
                                        <span id="place-address"></span>
                                    </div>
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
                                        <label
                                            for="delivery_charge"><?php echo get_phrase("delivery_charge") . ' (' . currency_code_and_symbol('code') . ')'; ?></label>
                                        <input type="number" id="delivery_charge" class="form-control"
                                            name="delivery_charge"
                                            placeholder="<?php echo sanitize(get_delivery_settings('delivery_charge')) . ' (' . get_phrase("default") . ') '; ?>"
                                            value="<?php echo sanitize($restaurant_data['delivery_charge']); ?>"
                                            step=".01">
                                    </div>
                                    <div class="form-group clockpicker">
                                        <label
                                            for="maximum_time_to_deliver"><?php echo get_phrase("maximum_time_to_deliver"); ?></label>
                                        <input type="text" class="form-control" id="maximum_time_to_deliver"
                                            name="maximum_time_to_deliver"
                                            placeholder="<?php echo sanitize(get_delivery_settings('maximum_time_to_deliver')) . ' (' . get_phrase("default") . ') '; ?>"
                                            value="<?php echo sanitize($restaurant_data['maximum_time_to_deliver']); ?>">
                                    </div>

                                    <!-- maximum range -->
                                    <div class="form-group">
                                        <label
                                            for="maximum_range">Maximum Range Of Delivery</label>
                                        <input type="text" class="form-control" id="maximum_range"
                                            name="maximum_range"
                                            placeholder="Select Maximum Miles in number"
                                            value="<?php echo sanitize($restaurant_data['maximum_range']); ?>">
                                    </div>
                                    <!-- free range -->

                                    <div class="form-group">
                                        <label
                                            for="free_range">Free Range In Miles</label>
                                        <input type="text" class="form-control" id="free_range"
                                            name="free_range"
                                            placeholder="Select free range number in miles"
                                            value="<?php echo sanitize($restaurant_data['free_range']); ?>">

                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="free_range">Rate per Mile</label>
                                        <input type="text" class="form-control" id="rate_per_mile"
                                            name="rate_per_mile"
                                            placeholder="Insert rate per mile (Applied on mile after free range)"
                                            value="<?php echo sanitize($restaurant_data['rate_per_mile']); ?>">

                                    </div>


                                    <button
                                        class="btn btn-primary"><?php echo get_phrase('update_delivery_data'); ?></button>
                                </div>
                                <div class="col-lg-6">
                                    <div class="alert alert-info lighten-info mt-4" role="alert">
                                        <h5 class="alert-heading"><i class="icon fas fa-exclamation-triangle"></i>
                                            <?php echo get_phrase('heads_up'); ?>!</h5>
                                        <p><?php echo get_phrase('you_can_overwrite_the_default_delivery_charge_and_maximum_time_to_deliver'); ?>.
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    <!-- /.tab-pane -->
                    <div class="tab-pane <?php if ($active_tab == 'seo') echo 'active' ?>" id="seo">
                        <div class="row">
                            <div class="col-lg-6" style="padding-right:20px; border-right:1px solid lightgrey">
                                <h2 style="display: flex;justify-content: space-between;align-items: flex-end;"> <?= $restaurant_data['fooyes_url'] ?><small class="text-muted text-sm">(Fooyes)</small></h2>
                                <form action="<?php echo site_url('restaurant/update/seo'); ?>" method="post">

                                    <input type="hidden" name="id" value="<?php echo sanitize($restaurant_data['id']); ?>">
                                    <input type="hidden" name="for_standalone" value="0">

                                    <div class="form-group">

                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Home <small class="text-muted text-sm"><?= $restaurant_data['fooyes_url'] ?></small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="home_title"
                                            placeholder="Enter Meta Title"
                                            value="<?php echo sanitize($restaurant_seo_data["fooyes"]->home_title); ?>" required>
                                        <textarea class="form-control" id="description" name="home_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["fooyes"]->home_desc); ?></textarea>

                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Contact <small class="text-muted text-sm">www.fooyes.co.uk/contact-us</small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="contact_us_title"
                                            placeholder="Enter Meta Title "
                                            value="<?php echo sanitize($restaurant_seo_data["fooyes"]->contact_us_title); ?>" required>
                                        <textarea class="form-control" id="description" name="contact_us_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["fooyes"]->contact_us_desc); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> About <small class="text-muted text-sm">www.fooyes.co.uk/about-us</small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="about_us_title"
                                            placeholder="Enter Meta Title "
                                            value="<?php echo sanitize($restaurant_seo_data["fooyes"]->about_us_title); ?>" required>
                                        <textarea class="form-control" id="description" name="about_us_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["fooyes"]->about_us_desc); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Privacy Policy <small class="text-muted text-sm">www.fooyes.co.uk/privacy-policy</small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="privacy_policy_title"
                                            placeholder="Enter Meta Title "
                                            value="<?php echo sanitize($restaurant_seo_data["fooyes"]->privacy_policy_title); ?>" required>
                                        <textarea class="form-control" id="description" name="privacy_policy_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["fooyes"]->privacy_policy_desc); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Terms & Condition <small class="text-muted text-sm">www.fooyes.co.uk/terms-and-conditions</small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="terms_and_conditions_title"
                                            placeholder="Enter Meta Title "
                                            value="<?php echo sanitize($restaurant_seo_data["fooyes"]->terms_and_conditions_title); ?>" required>
                                        <textarea class="form-control" id="description" name="terms_and_conditions_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["fooyes"]->terms_and_conditions_desc); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Become a partner <small class="text-muted text-sm">www.fooyes.co.uk/terms-and-conditions</small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="become_a_partner_title"
                                            placeholder="Enter Meta Title "
                                            value="<?php echo sanitize($restaurant_seo_data["fooyes"]->become_a_partner_title); ?>" required>
                                        <textarea class="form-control" id="description" name="become_a_partner_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["fooyes"]->become_a_partner_desc); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Terms of use <small class="text-muted text-sm">www.fooyes.co.uk/terms-of-use</small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="terms_of_use_title"
                                            placeholder="Enter Meta Title "
                                            value="<?php echo sanitize($restaurant_seo_data["fooyes"]->terms_of_use_title); ?>" required>
                                        <textarea class="form-control" id="description" name="terms_of_use_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["fooyes"]->terms_of_use_desc); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Solutions <small class="text-muted text-sm">www.fooyes.co.uk/solutions</small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="solutions_title"
                                            placeholder="Enter Meta Title "
                                            value="<?php echo sanitize($restaurant_seo_data["fooyes"]->solutions_title); ?>" required>
                                        <textarea class="form-control" id="description" name="solutions_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["fooyes"]->solutions_desc); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Login <small class="text-muted text-sm">www.fooyes.co.uk/login</small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="login_title"
                                            placeholder="Enter Meta Title "
                                            value="<?php echo sanitize($restaurant_seo_data["fooyes"]->login_title); ?>" required>
                                        <textarea class="form-control" id="description" name="login_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["fooyes"]->login_desc); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Auth <small class="text-muted text-sm">www.fooyes.co.uk/auth</small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="auth_title"
                                            placeholder="Enter Meta Title "
                                            value="<?php echo sanitize($restaurant_seo_data["fooyes"]->auth_title); ?>" required>
                                        <textarea class="form-control" id="description" name="auth_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["fooyes"]->auth_desc); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Schema 1 <small class="text-muted text-sm">Takeaway & Delivery Schema</small></label>

                                        <textarea class="form-control" id="description" name="schema_1" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["fooyes"]->schema_1); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Schema 2 <small class="text-muted text-sm">Website Schema</small></label>

                                        <textarea class="form-control" id="schema_2" name="schema_2" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["fooyes"]->schema_2); ?></textarea>
                                    </div>


                                    <button type="submit"
                                        class="btn btn-primary">Update SEO Setting</button>
                                </form>
                            </div>
                            <div class="col-lg-6" style="padding-left:20px;">
                                <h2 style="display: flex;justify-content: space-between;align-items: flex-end;"> <?= $restaurant_data['standalone_url'] ?><small class="text-muted text-sm">(Standalone)</small></h2>
                                <form action="<?php echo site_url('restaurant/update/seo'); ?>" method="post">

                                    <input type="hidden" name="id" value="<?php echo sanitize($restaurant_data['id']); ?>">
                                    <input type="hidden" name="for_standalone" value="1">

                                    <div class="form-group">

                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Home <small class="text-muted text-sm"><?= $restaurant_data['standalone_url'] ?></small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="home_title"
                                            placeholder="Enter Meta Title"
                                            value="<?php echo sanitize($restaurant_seo_data["standalone"]->home_title); ?>" required>
                                        <textarea class="form-control" id="description" name="home_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["standalone"]->home_desc); ?></textarea>

                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Contact <small class="text-muted text-sm"><?= $restaurant_data['standalone_url'] ?>contact-us</small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="contact_us_title"
                                            placeholder="Enter Meta Title "
                                            value="<?php echo sanitize($restaurant_seo_data["standalone"]->contact_us_title); ?>" required>
                                        <textarea class="form-control" id="description" name="contact_us_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["standalone"]->contact_us_desc); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> About <small class="text-muted text-sm"><?= $restaurant_data['standalone_url'] ?>about-us</small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="about_us_title"
                                            placeholder="Enter Meta Title "
                                            value="<?php echo sanitize($restaurant_seo_data["standalone"]->about_us_title); ?>" required>
                                        <textarea class="form-control" id="description" name="about_us_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["standalone"]->about_us_desc); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Privacy Policy <small class="text-muted text-sm"><?= $restaurant_data['standalone_url'] ?>privacy-policy</small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="privacy_policy_title"
                                            placeholder="Enter Meta Title "
                                            value="<?php echo sanitize($restaurant_seo_data["standalone"]->privacy_policy_title); ?>" required>
                                        <textarea class="form-control" id="description" name="privacy_policy_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["standalone"]->privacy_policy_desc); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Terms & Condition <small class="text-muted text-sm"><?= $restaurant_data['standalone_url'] ?>terms-and-conditions</small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="terms_and_conditions_title"
                                            placeholder="Enter Meta Title "
                                            value="<?php echo sanitize($restaurant_seo_data["standalone"]->terms_and_conditions_title); ?>" required>
                                        <textarea class="form-control" id="description" name="terms_and_conditions_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["standalone"]->terms_and_conditions_desc); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Become a partner <small class="text-muted text-sm"><?= $restaurant_data['standalone_url'] ?>terms-and-conditions</small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="become_a_partner_title"
                                            placeholder="Enter Meta Title "
                                            value="<?php echo sanitize($restaurant_seo_data["standalone"]->become_a_partner_title); ?>" required>
                                        <textarea class="form-control" id="description" name="become_a_partner_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["standalone"]->become_a_partner_desc); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Terms of use <small class="text-muted text-sm"><?= $restaurant_data['standalone_url'] ?>terms-of-use</small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="terms_of_use_title"
                                            placeholder="Enter Meta Title "
                                            value="<?php echo sanitize($restaurant_seo_data["standalone"]->terms_of_use_title); ?>" required>
                                        <textarea class="form-control" id="description" name="terms_of_use_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["standalone"]->terms_of_use_desc); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Solutions <small class="text-muted text-sm"><?= $restaurant_data['standalone_url'] ?>solutions</small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="solutions_title"
                                            placeholder="Enter Meta Title "
                                            value="<?php echo sanitize($restaurant_seo_data["standalone"]->solutions_title); ?>" required>
                                        <textarea class="form-control" id="description" name="solutions_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["standalone"]->solutions_desc); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Login <small class="text-muted text-sm"><?= $restaurant_data['standalone_url'] ?>login</small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="login_title"
                                            placeholder="Enter Meta Title "
                                            value="<?php echo sanitize($restaurant_seo_data["standalone"]->login_title); ?>" required>
                                        <textarea class="form-control" id="description" name="login_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["standalone"]->login_desc); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Auth <small class="text-muted text-sm"><?= $restaurant_data['standalone_url'] ?>auth</small></label>
                                        <input type="text" class="form-control" id="tag_line"
                                            name="auth_title"
                                            placeholder="Enter Meta Title "
                                            value="<?php echo sanitize($restaurant_seo_data["standalone"]->auth_title); ?>" required>
                                        <textarea class="form-control" id="description" name="auth_desc" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["standalone"]->auth_desc); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Schema 1 <small class="text-muted text-sm">Takeaway & Delivery Schema</small></label>

                                        <textarea class="form-control" id="description" name="schema_1" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["standalone"]->schema_1); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: flex;justify-content: space-between;align-items: flex-end;"> Schema 2 <small class="text-muted text-sm">Website Schema</small></label>

                                        <textarea class="form-control" id="schema_2" name="schema_2" rows="5"
                                            cols="80"
                                            placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_seo_data["standalone"]->schema_2); ?></textarea>
                                    </div>


                                    <button type="submit"
                                        class="btn btn-primary">Update SEO Setting</button>
                                </form>
                            </div>
                        </div>


                        <!-- <form action="<?php echo site_url('restaurant/update/seo'); ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo sanitize($restaurant_data['id']); ?>">
                            <div class="form-group">
                                <label for="tags"><?php echo "SEO " . get_phrase("tags"); ?></label>
                                <input type="text" id="tags" class="tagged form-control" data-removeBtn="true"
                                    name="seo_tags" value="<?php echo sanitize($restaurant_data['seo_tags']); ?>"
                                    placeholder="<?php echo get_phrase("enter_tags_and_press_enter"); ?>">
                            </div>
                            <div class="form-group">
                                <label for="description"><?php echo "SEO " . get_phrase("description"); ?></label>
                                <textarea class="form-control" id="description" name="seo_description" rows="5"
                                    cols="80"
                                    placeholder="<?php echo get_phrase("this_will_show_in_the_meta_description"); ?>..."><?php echo sanitize($restaurant_data['seo_description']); ?></textarea>
                            </div>
                            <button type="submit"
                                class="btn btn-primary">Update SEO Setting</button>
                        </form> -->
                    </div>
                    <div class="tab-pane <?php if ($active_tab == 'offers') echo 'active' ?>" id="offers">
                        <div class="row">
                            <div class="col-lg-6" style="padding-right:20px; border-right:1px solid lightgrey">
                                <h2 style="display: flex;justify-content: space-between;align-items: flex-end;"> <?= $restaurant_data['fooyes_url'] ?><small class="text-muted text-sm">(Standalone)</small></h2>
                                <form action="<?php echo site_url('restaurant/update/offers'); ?>" method="post">
                                    <input type="hidden" name="id" value="<?php echo sanitize($restaurant_data['id']); ?>">
                                    <div class="form-group">
                                        <label for="restaurant_discount"><?php echo get_phrase("Delivery Discount"); ?></label>
                                        <input type="text" class="form-control" id="res_discount" name="res_discount" placeholder="<?php echo get_phrase("Enter Restaurant Discount in percentage"); ?>" value="<?php echo sanitize($restaurant_data['res_discount']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="restaurant_discount">Collection/Pickup Discount</label>
                                        <input type="text" class="form-control" id="pick_discount" name="pick_discount" placeholder="<?php echo get_phrase("Enter Pickup Discount in percentage"); ?>" value="<?php echo sanitize($restaurant_data['pick_discount']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pos_discount">Point of Sale Discount</label>
                                        <input type="text" class="form-control" id="pos_discount" name="pos_discount" placeholder="<?php echo get_phrase("Enter POS Discount in percentage"); ?>" value="<?php echo sanitize($restaurant_data['pos_discount']); ?>" required>
                                    </div>


                                    <button class="btn btn-primary"><?php echo get_phrase('Update Restaurant Discounts'); ?></button>

                            </div>
                            <div class="col-lg-6" style="padding-left:20px;">
                                <h2 style="display: flex;justify-content: space-between;align-items: flex-end;"> <?= $restaurant_data['standalone_url'] ?><small class="text-muted text-sm">(Standalone)</small></h2>
                                <input type="hidden" name="id" value="<?php echo sanitize($restaurant_data['id']); ?>">

                                <div class="form-group">
                                    <label for="standalone_res_discount">Delivery Discount</label>
                                    <input type="text" class="form-control" id="standalone_res_discount" name="standalone_res_discount" placeholder="<?php echo get_phrase("Enter Standalone Restaurant Discount in percentage"); ?>" value="<?php echo sanitize($restaurant_data['standalone_res_discount']); ?>" required>
                                </div>


                                <div class="form-group">
                                    <label for="standalone_pick_discount">Collection/Pickup Discount</label>
                                    <input type="text" class="form-control" id="standalone_pick_discount" name="standalone_pick_discount" placeholder="<?php echo get_phrase("Enter Standalone Restaurant Discount in percentage"); ?>" value="<?php echo sanitize($restaurant_data['standalone_pick_discount']); ?>" required>
                                </div>
                                </form>
                            </div>
                        </div>


                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane <?php if ($active_tab == 'gallery') echo 'active' ?>" id="gallery">
                        <form action="<?php echo site_url('restaurant/update/gallery'); ?>" method="post"
                            enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo sanitize($restaurant_data['id']); ?>">

                            <!-- RESTAURANT THUMBNAIL -->
                            <div class="form-group">
                                <label for="restaurant_thumbnail"><?php echo get_phrase("restaurant_thumbnail"); ?>
                                    <span class="badge badge-default">(400 X 291)</span></label>
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' class="imageUploadPreview" id="restaurant_thumbnail"
                                            name="restaurant_thumbnail" accept=".png, .jpg, .jpeg" />
                                        <label for="restaurant_thumbnail"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="restaurant_thumbnail_preview"
                                            thumbnail="<?php echo base_url('uploads/restaurant/thumbnail/' . sanitize($restaurant_data['thumbnail'])); ?>">
                                        </div>
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
                                            <label
                                                for='<?php echo "restaurant_gallery_$counter"; ?>'><?php echo get_phrase("restaurant_gallery") . ' ' . $counter; ?>
                                                <span class="badge badge-default">(672 X 414)</span> </label>
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type='file' class="imageUploadPreview"
                                                        id='<?php echo "restaurant_gallery_$counter"; ?>'
                                                        name='<?php echo "restaurant_gallery_$counter"; ?>'
                                                        accept=".png, .jpg, .jpeg" />
                                                    <label for='<?php echo "restaurant_gallery_$counter"; ?>'></label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <div id='<?php echo "restaurant_gallery_" . $counter . "_preview"; ?>'
                                                        thumbnail="<?php echo base_url('uploads/restaurant/gallery/' . $restaurant_gallery_images[$counter - 1]); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                            <button type="submit"
                                class="btn btn-primary"><?php echo get_phrase('update_gallery'); ?></button>
                        </form>
                    </div>

                    <div class="tab-pane <?php if ($active_tab == 'visibility') echo 'active' ?>" id="visibility">
                        <div class="row">
                            <div class="col-lg-6" style="padding-right:20px; border-right:1px solid lightgrey">

                                <h2 style="display: flex;justify-content: space-between;align-items: flex-end;"> <?= $restaurant_data['fooyes_url'] ?><small class="text-muted text-sm">(Fooyes)</small></h2>
                                <form action="<?php echo site_url('restaurant/update/visibility'); ?>" method="post">
                                    <input type="hidden" name="id" value="<?php echo sanitize($restaurant_data['id']); ?>">
                                    
                                    <input type="hidden" name="domain" value="fooyes">
                                    <div class="form-group" style="display: flex;align-items: center;gap: 20px;">
                                        <label for="visible_on_fooyes">Enable:</label>
                                        <label class="toggle">
                                            <input type="checkbox" id="btnToggle" name="flag" <?= $restaurant_data['visible_on_fooyes'] == 1 ? 'checked' : '' ?>/>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <hr>
                                    <div class="form-group" style="display: flex;align-items: center;gap: 20px;">
                                        <label for="visible_on_fooyes">Mark Unavailable:</label>
                                        <label class="toggle">
                                            <input type="checkbox" id="unavailable_on_fooyes" name="unavailable_on_fooyes" <?= $restaurant_data['unavailable_on_fooyes'] == 1 ? 'checked' : '' ?>/>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                     <div class="form-group" style="display: flex;align-items: center;gap: 20px;">
                                        <input type="text" name="unavailable_fooyes_text" class="form-control" placeholder="Popup Text" value="<?php echo sanitize($restaurant_data['unavailable_fooyes_text']); ?>">
                                    </div>
                                    

                                    <button class="btn btn-primary" type="submit">Update Visibility</button>
                                </form>
                            </div>
                            <div class="col-lg-6" style="padding-left:20px;">
                                <h2 style="display: flex;justify-content: space-between;align-items: flex-end;"> <?= $restaurant_data['standalone_url'] ?><small class="text-muted text-sm">(Standalone)</small></h2>
                               <form action="<?php echo site_url('restaurant/update/visibility'); ?>" method="post">
                                    <input type="hidden" name="id" value="<?php echo sanitize($restaurant_data['id']); ?>">
                                    
                                    <input type="hidden" name="domain" value="standalone">
                                    <div class="form-group" style="display: flex;align-items: center;gap: 20px;">
                                        <label for="visible_on_fooyes">Enable:</label>
                                        <label class="toggle">
                                            <input type="checkbox" id="btnToggle" name="flag" <?= $restaurant_data['visible_on_standalone'] == 1 ? 'checked' : '' ?>/>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <hr>
                                    <div class="form-group" style="display: flex;align-items: center;gap: 20px;">
                                        <label for="visible_on_fooyes">Mark Unavailable:</label>
                                        <label class="toggle">
                                            <input type="checkbox" id="unavailable_on_standalone" name="unavailable_on_standalone" <?= $restaurant_data['unavailable_on_standalone'] == 1 ? 'checked' : '' ?>/>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                     <div class="form-group" style="display: flex;align-items: center;gap: 20px;">
                                        <input type="text" name="unavailable_standalone_text" class="form-control" placeholder="Popup Text" value="<?php echo sanitize($restaurant_data['unavailable_standalone_text']); ?>">
                                    </div>
                                    


                                    <button class="btn btn-primary" type="submit">Update Visibility</button>
                                </form>
                               
                            </div>

                        
                            
                        </div>


                    </div>
                    <!-- /.tab-pane -->


                     <div class="tab-pane <?php if ($active_tab == 'timings') echo 'active' ?>" id="timings">
                        <div class="row" style="display: flex;justify-content: center;">
                            <div class="col-lg-6" style="padding-right:20px; border-right:1px solid lightgrey;border-left:1px solid lightgrey">
                                
                                <form action="<?php echo site_url('restaurant/update/timings'); ?>" method="post">
                                    <input type="hidden" name="id" value="<?php echo sanitize($restaurant_data['id']); ?>">

                                    <?php
                                    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                                    foreach ($days as $day):
                                        $open_key   = $day . '_open';
                                        $close_key  = $day . '_close';
                                        $closed_key = $day . '_closed';
                                    ?>
                                    <div class="day-row <?php echo !empty($restaurant_data['timings'][$closed_key]) ? 'is-closed' : ''; ?>" id="row-<?php echo $day; ?>">
                                        <div class="day-label">
                                            <span><?php echo ucfirst($day); ?></span>
                                            <label class="toggle">
                                                <input type="checkbox" name="<?php echo $closed_key; ?>"
                                                    value="1"
                                                    <?php echo !empty($restaurant_data['timings'][$closed_key]) ? 'checked' : ''; ?>
                                                    onchange="toggleDay('<?php echo $day; ?>', this.checked)">
                                                <span class="toggle-track"></span>
                                                <span class="toggle-label-text">Closed</span>
                                            </label>
                                        </div>
                                        <div class="day-times" id="times-<?php echo $day; ?>">
                                            <div class="time-field">
                                                <label>Opens</label>
                                                <input type="time" name="<?php echo $open_key; ?>" class="form-control"
                                                    value="<?php echo sanitize($restaurant_data['timings'][$open_key] ?? '09:00'); ?>">
                                            </div>
                                            <span class="time-sep">→</span>
                                            <div class="time-field">
                                                <label>Closes</label>
                                                <input type="time" name="<?php echo $close_key; ?>" class="form-control"
                                                    value="<?php echo sanitize($restaurant_data['timings'][$close_key] ?? '22:00'); ?>">
                                            </div>
                                        </div>
                                        <div class="closed-badge" id="badge-<?php echo $day; ?>" style="display:none">Closed all day</div>
                                    </div>
                                    <?php endforeach; ?>

                                    <button class="btn btn-primary mt-3" type="submit">Save Hours</button>
                                </form>

                                <style>
                                .day-row {
                                    display: flex;
                                    align-items: center;
                                    gap: 16px;
                                    padding: 12px 16px;
                                    border-radius: 10px;
                                    border: 1px solid #e9ecef;
                                    background: #fff;
                                    margin-bottom: 8px;
                                    transition: background 0.2s;
                                }
                                .day-row.is-closed {
                                    background: #f8f9fa;
                                    opacity: 0.7;
                                }
                                .day-label {
                                    display: flex;
                                    align-items: center;
                                    gap: 12px;
                                    min-width: 200px;
                                }
                                .day-label > span {
                                    font-weight: 600;
                                    font-size: 16px;
                                    width: 90px;
                                    color: #212529;
                                }
                                .toggle {
                                    display: flex;
                                    align-items: center;
                                    gap: 8px;
                                    cursor: pointer;
                                    margin: 0;
                                }
                                .toggle input[type="checkbox"] { display: none; }
                                .toggle-track {
                                    width: 36px;
                                    height: 20px;
                                    background: #dee2e6;
                                    border-radius: 20px;
                                    position: relative;
                                    transition: background 0.2s;
                                    flex-shrink: 0;
                                }
                                .toggle-track::after {
                                    content: '';
                                    position: absolute;
                                    width: 14px;
                                    height: 14px;
                                    border-radius: 50%;
                                    background: #fff;
                                    top: 3px;
                                    left: 3px;
                                    transition: left 0.2s;
                                }
                                .toggle input:checked ~ .toggle-track { background: #dc3545; }
                                .toggle input:checked ~ .toggle-track::after { left: 19px; }
                                .toggle-label-text {
                                    font-size: 13px;
                                    color: #6c757d;
                                }
                                .day-times {
                                    display: flex;
                                    align-items: flex-end;
                                    gap: 10px;
                                    flex: 1;
                                }
                                .time-field {
                                    display: flex;
                                    flex-direction: column;
                                    gap: 4px;
                                }
                                .time-field label {
                                    font-size: 11px;
                                    font-weight: 600;
                                    text-transform: uppercase;
                                    letter-spacing: 0.05em;
                                    color: #6c757d;
                                    margin: 0;
                                }
                                .time-field .form-control {
                                    width: 130px;
                                    padding: 7px 10px;
                                    font-size: 14px;
                                    border: 1px solid #dee2e6;
                                    border-radius: 8px;
                                    background: #f8f9fa;
                                    color: #212529;
                                }
                                .time-field .form-control:focus {
                                    border-color: #0d6efd;
                                    background: #fff;
                                    box-shadow: 0 0 0 3px rgba(13,110,253,.15);
                                    outline: none;
                                }
                                .time-sep {
                                    font-size: 16px;
                                    color: #adb5bd;
                                    padding-bottom: 8px;
                                }
                                .closed-badge {
                                    font-size: 13px;
                                    color: #dc3545;
                                    font-weight: 500;
                                    padding: 6px 12px;
                                    background: #fff5f5;
                                    border-radius: 20px;
                                    border: 1px solid #f5c6cb;
                                }
                                </style>

                                <script>
                                function toggleDay(day, isClosed) {
                                    const row    = document.getElementById('row-' + day);
                                    const times  = document.getElementById('times-' + day);
                                    const badge  = document.getElementById('badge-' + day);
                                    times.style.display = isClosed ? 'none' : 'flex';
                                    badge.style.display = isClosed ? 'block' : 'none';
                                    row.classList.toggle('is-closed', isClosed);
                                }
                                document.querySelectorAll('.toggle input[type="checkbox"]').forEach(cb => {
                                    const day = cb.closest('.day-row').id.replace('row-', '');
                                    toggleDay(day, cb.checked);
                                });
                                </script>
                            </div>
                    
                        </div>


                    </div>

        
                    <div class="tab-pane <?php if ($active_tab == 'emails') echo 'active' ?>" id="emails">
                        <div class="row">

                            <!-- LEFT SIDE (Fooyes) -->
                            <div class="col-lg-6" style="padding-right:20px; border-right:1px solid lightgrey">
                                

                                <form action="<?php echo site_url('restaurant/update_email_settings'); ?>" method="post">
                                    <input type="hidden" name="id" value="<?php echo sanitize($restaurant_data['id']); ?>">

                                    <div class="form-group">
                                        <label>Missed Order Email</label>
                                        <input type="email" name="missed_order_email" class="form-control"
                                            value="<?= $restaurant_data['missed_order_email'] ?? '' ?>"
                                            placeholder="Enter email for missed orders">
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-2">Save Fooyes Settings</button>
                                </form>
                            </div>


                            <!-- RIGHT SIDE (Standalone) -->
                            <div class="col-lg-6" style="padding-left:20px;">
                                

                                <form action="<?php echo site_url('restaurant/update_email_settings'); ?>" method="post">
                                    <input type="hidden" name="id" value="<?php echo sanitize($restaurant_data['id']); ?>">

                                    <div class="form-group">
                                        <label>Missed Order Email Count</label>
                                        <input type="number" name="missed_order_email_count" class="form-control"
                                            value="<?= $restaurant_data['missed_order_email_count'] ?? '' ?>"
                                            placeholder="Enter email count for standalone missed orders">
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-4">Save Email Count Settings</button>
                                </form>
                            </div>

                        </div>
                    </div>



        </div>
    </div>
</div>


                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- ./card -->
    </div>
    <div class="container-fluid">

        <!-- <div id="map" style="height: 500px"></div> -->


    </div>
    <!--/. container-fluid -->
</section>