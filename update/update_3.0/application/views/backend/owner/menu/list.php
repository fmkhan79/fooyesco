<div class="card">
    <div class="card-body">
        <form action="<?php echo site_url('menu/index'); ?>" action="get">
            <div class="row justify-content-sm-center">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label><?php echo get_phrase('restaurant'); ?></label>
                        <select class="form-control select2 w-100" name="restaurant_id">
                            <option value="all" <?php if ($restaurant_id == "all") echo "selected"; ?>><?php echo get_phrase('all'); ?></option>
                            <?php foreach ($restaurants as $key => $restaurant) : ?>
                                <option value="<?php echo sanitize($restaurant['id']); ?>" <?php if ($restaurant_id == $restaurant['id']) echo "selected"; ?>><?php echo sanitize($restaurant['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label><?php echo get_phrase('category'); ?></label>
                        <select class="form-control select2 w-100" name="category_id">
                            <option value="all" <?php if ($category_id == "all") echo "selected"; ?>><?php echo get_phrase('all'); ?></option>
                            <?php foreach ($categories as $key => $category) : ?>
                                <option value="<?php echo sanitize($category['id']); ?>" <?php if ($category_id == $category['id']) echo "selected"; ?>><?php echo sanitize($category['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-1">
                    <div class="form-group mt-30">
                        <button type="submit" class="btn btn-primary"><?php echo get_phrase('filter'); ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if (count($menus) > 0) : ?>
    <div class="row justify-content-center">
        <?php foreach ($menus as $key => $menu) : ?>
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle light-thumb-circle square-100" src="<?php echo base_url('uploads/menu/' . sanitize($menu['thumbnail'])); ?>" alt="<?php echo get_phrase('menu_thumbnail'); ?>">
                        </div>
                        <h3 class="profile-username text-center">
                            <?php echo sanitize($menu['name']); ?>
                        </h3>
                        <div class="text-center mb-2">
                            <small><?php echo get_phrase('restaurant'); ?> : <strong><?php echo sanitize($menu['restaurant_name']); ?></strong></small>
                        </div>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b><?php echo get_phrase('category'); ?></b>
                                <a class="float-right"><?php echo sanitize($menu['category_name']); ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo get_phrase('price'); ?></b>
                                <a class="float-right">
                                    <?php
                                    if ($menu['servings'] == "menu") {
                                        echo currency(get_menu_price($menu['id']));
                                    } elseif ($menu['servings'] == "plate") {
                                        echo currency(get_menu_price($menu['id'], "full_plate")) . ', ' . currency(get_menu_price($menu['id'], "half_plate"));
                                    } ?>

                                </a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo get_phrase('availability'); ?></b>
                                <a class="float-right">
                                    <?php if ($menu['availability']) : ?>
                                        <span class="badge badge-success"><?php echo get_phrase('available'); ?></span>
                                    <?php else : ?>
                                        <span class="badge badge-danger"><?php echo get_phrase('not_available'); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                        </ul>
                        <a href="<?php echo site_url('menu/edit/' . sanitize($menu['id'])); ?>" class="btn btn-primary btn-block"><b><?php echo get_phrase('details'); ?></b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        <?php endforeach; ?>
    </div>

    <nav aria-label="Page Navigation">
        <?php echo $this->pagination->create_links(); ?>
    </nav>
<?php endif; ?>

<?php if (count($menus) == 0) : ?>
    <?php isEmpty(); ?>
<?php endif; ?>
