<div class="content-header">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h4 class="mt-1 text-dark"><?php echo ucwords($page_title); ?></h4>
                    </div>
                    <div class="col-6">
                        <?php if ($page_name == 'menu/index') : ?>
                            <a href="<?php echo site_url('menu/create'); ?>" class="btn btn-outline-primary btn-rounded float-right" name="button"><?php echo get_phrase("add_new_menu", true); ?></a>
                        <?php elseif ($page_name == 'menu/create') : ?>
                            <a href="<?php echo site_url('menu'); ?>" class="btn btn-outline-primary btn-rounded float-right" name="button"><?php echo get_phrase("back_to_menu", true); ?></a>
                        <?php elseif ($page_name == 'menu/edit') : ?>
                            <?php
                            $restaurant_id = $menu_data['restaurant_id'];
                            $restaurant_slug = slugify($menu_data['restaurant_name']);
                            ?>
                            <a href="<?php echo site_url('menu'); ?>" class="btn btn-outline-primary btn-rounded float-right" name="button"><?php echo get_phrase("back_to_menu", true); ?></a>
                            <a href="<?php echo site_url("site/restaurant/$restaurant_slug/$restaurant_id"); ?>" class="btn btn-outline-primary btn-rounded float-right mr-1" name="button" target="_blank"> <i class="fas fa-external-link-alt"></i> <?php echo get_phrase("view_in_frontend", true); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>