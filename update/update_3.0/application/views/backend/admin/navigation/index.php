<aside class="main-sidebar sidebar-dark-danger elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo site_url('dashboard'); ?>" class="brand-link">
        <img src="<?php echo base_url('uploads/system/' . get_website_settings('backend_logo')); ?>" alt="" class="brand-image img-circle opacity-80">
        <span class="brand-text font-weight-light"><?php echo get_system_settings('system_name'); ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo base_url('uploads/user/' . sanitize($current_user['thumbnail'])); ?>" class="img-circle" alt="User Image">
            </div>
            <div class="info">
                <a href="<?php echo site_url('settings/profile'); ?>" class="d-block"><?php echo sanitize($current_user['name']); ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-header"><?php echo get_phrase("navigation_section", true); ?></li>
                <li class="nav-item">
                    <a href="<?php echo site_url('dashboard'); ?>" class="nav-link <?php if ($page_name == "dashboard/index") echo 'active'; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            <?php echo get_phrase('dashboard'); ?>
                        </p>
                    </a>
                </li>
                <?php $order_type = isset($order_type) ? $order_type : ""; ?>
                <li class="nav-item has-treeview <?php if ($page_name == "orders/index" && $order_type == "all"  || $order_type == "today" || $order_type == "live" || $page_name == "orders/details") echo 'menu-open'; ?>">
                    <a href="#" class="nav-link <?php if ($page_name == "orders/index" && $order_type == "all"  || $order_type == "today" || $order_type == "live" || $page_name == "orders/details") echo 'active'; ?>">
                        <i class="nav-icon fas fa-hamburger"></i>
                        <p>
                            <?php echo get_phrase('orders'); ?>
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo site_url('orders/live'); ?>" class="nav-link <?php if ($order_type == "live") echo 'active'; ?>">
                                <i class="fas fa-wave-square nav-icon"></i>
                                <p>
                                    <?php echo get_phrase('live_orders', true); ?>
                                    <div class="pulse right pulse-small"></div>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('orders/today'); ?>" class="nav-link <?php if ($order_type == "today") echo 'active'; ?>">
                                <i class="fas fa-calendar-day nav-icon"></i>
                                <p>
                                    <?php echo get_phrase('todays_orders', true); ?>
                                    <span class="badge badge-warning right" id="number-of-pending-orders-in-navigation">
                                        <?php
                                        $number_of_todays_pending_orders = $this->order_model->get_number_of_todays_pending_orders();
                                        echo sanitize($number_of_todays_pending_orders);
                                        ?>
                                    </span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('orders'); ?>" class="nav-link <?php if ($order_type == "all" || $page_name == "orders/details") echo 'active'; ?>">
                                <i class="fas fa-calendar-alt nav-icon"></i>
                                <p><?php echo get_phrase('all_orders', true); ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="<?php echo site_url('cuisine'); ?>" class="nav-link <?php if ($page_name == "cuisine/index" || $page_name == "cuisine/create" || $page_name == "cuisine/edit") echo 'active'; ?>">
                        <i class="fas fa-pepper-hot nav-icon"></i>
                        <p>
                            <?php echo get_phrase('cuisine'); ?>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo site_url('restaurant'); ?>" class="nav-link <?php if ($page_name == "restaurant/index" || $page_name == "restaurant/create" || $page_name == "restaurant/edit") echo 'active'; ?>">
                        <i class="fas fa-stroopwafel nav-icon"></i>
                        <p><?php echo get_phrase("restaurants"); ?><span class="badge badge-warning right"><?php echo count($this->restaurant_model->get_all_pending()); ?></span></p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo site_url('qrmenu'); ?>" class="nav-link <?php if ($page_name == "qrmenu/index" || $page_name == "qrmenu/create") echo 'active'; ?>">
                        <i class="fas fa-qrcode nav-icon"></i>
                        <p><?php echo "QR " . get_phrase("menu_builder"); ?></p>
                    </a>
                </li>

                <li class="nav-item has-treeview <?php if ($page_name == "ingredient/index" || $page_name == "ingredient/create" || $page_name == "ingredient/edit" || $page_name == "ingredient/report") echo 'menu-open'; ?>">
                    <a href="#" class="nav-link <?php if ($page_name == "ingredient/index" || $page_name == "ingredient/create" || $page_name == "ingredient/edit" || $page_name == "ingredient/report") echo 'active'; ?>">
                        <i class="nav-icon fas fa-seedling"></i>
                        <p>
                            <?php echo get_phrase("food_ingredients", true); ?>
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo site_url('ingredient'); ?>" class="nav-link <?php if ($page_name == "ingredient/index" || $page_name == "ingredient/create" || $page_name == "ingredient/edit") echo 'active'; ?>">
                                <i class="fab fa-pagelines nav-icon"></i>
                                <p><?php echo get_phrase("food_ingredients", true); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('ingredient/report'); ?>" class="nav-link <?php if ($page_name == "ingredient/report") echo 'active'; ?>">
                                <i class="fas fa-calculator nav-icon"></i>
                                <p><?php echo get_phrase("ingredient_report", true); ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview <?php if ($page_name == "category/index" || $page_name == "category/create" || $page_name == "category/edit" || $page_name == "menu/index" || $page_name == "menu/create" || $page_name == "menu/edit" || $page_name == "menu/report") echo 'menu-open'; ?>">
                    <a href="#" class="nav-link <?php if ($page_name == "category/index" || $page_name == "category/create" || $page_name == "category/edit" || $page_name == "menu/index" || $page_name == "menu/create" || $page_name == "menu/edit" || $page_name == "menu/report") echo 'active'; ?>">
                        <i class="nav-icon fas fa-utensils"></i>
                        <p>
                            <?php echo get_phrase("food_menu"); ?>
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo site_url('category'); ?>" class="nav-link <?php if ($page_name == "category/index" || $page_name == "category/create" || $page_name == "category/edit") echo 'active'; ?>">
                                <i class="fas fa-drumstick-bite nav-icon"></i>
                                <p><?php echo get_phrase("menu_category", true); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('menu'); ?>" class="nav-link <?php if ($page_name == "menu/index" || $page_name == "menu/create" || $page_name == "menu/edit") echo 'active'; ?>">
                                <i class="fas fa-bread-slice nav-icon"></i>
                                <p><?php echo get_phrase("food_menu", true); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('menu/report'); ?>" class="nav-link <?php if ($page_name == "menu/report") echo 'active'; ?>">
                                <i class="far fa-chart-bar nav-icon"></i>
                                <p><?php echo get_phrase("menu_report", true); ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <?php $report_type = isset($report_type) ? $report_type : ""; ?>
                <li class="nav-item has-treeview <?php if ($page_name == "report/index" && $report_type == "owner" || $report_type == "admin" || $report_type == "details") echo 'menu-open'; ?>">
                    <a href="#" class="nav-link <?php if ($page_name == "report/index" && $report_type == "owner" || $report_type == "admin" || $report_type == "details") echo 'active'; ?>">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>
                            <?php echo get_phrase('report'); ?>
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo site_url('report/admin'); ?>" class="nav-link <?php if ($report_type == "admin") echo 'active'; ?>">
                                <i class="fas fa-user-shield nav-icon"></i>
                                <p><?php echo get_phrase('admin_revenue', true); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('report'); ?>" class="nav-link <?php if ($report_type == "owner" || $report_type == "details") echo 'active'; ?>">
                                <i class="fas fa-user-tie nav-icon"></i>
                                <p>
                                    <?php echo get_phrase('owner_revenue', true); ?>
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-header"><?php echo get_phrase("user_section", true); ?></li>

                <li class="nav-item">
                    <a href="<?php echo site_url('owner'); ?>" class="nav-link <?php if ($page_name == "owner/index" || $page_name == "owner/edit" || $page_name == "owner/profile") echo 'active'; ?>">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                            <?php echo get_phrase("owners"); ?>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo site_url('customer'); ?>" class="nav-link <?php if ($page_name == "customer/index" || $page_name == "customer/create" || $page_name == "customer/edit" || $page_name == "customer/profile") echo 'active'; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            <?php echo get_phrase("customers"); ?>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo site_url('driver'); ?>" class="nav-link <?php if ($page_name == "driver/index" || $page_name == "driver/create" || $page_name == "driver/edit" || $page_name == "driver/profile") echo 'active'; ?>">
                        <i class="nav-icon fas fa-biking"></i>
                        <p>
                            <?php echo get_phrase("driver"); ?><span class="badge badge-warning right"><?php echo count($this->driver_model->get_pending_drivers()); ?></span>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo site_url('cook'); ?>" class="nav-link <?php if ($page_name == "cook/index" || $page_name == "cook/create" || $page_name == "cook/profile") echo 'active'; ?>">
                        <i class="nav-icon fas fa-chess-queen"></i>
                        <p>
                            <?php echo get_phrase("cook"); ?>
                        </p>
                    </a>
                </li>

                <li class="nav-header"><?php echo get_phrase("settings_section", true); ?></li>

                <li class="nav-item has-treeview <?php if ($page_name == "settings/delivery" || $page_name == "settings/language" || $page_name == "settings/phrase" || $page_name == "settings/system" || $page_name == "settings/website" || $page_name == "settings/payment" || $page_name == "settings/vat" || $page_name == "settings/revenue" || $page_name == "settings/recaptcha" || $page_name == "settings/smtp" || $page_name == "settings/order") echo 'menu-open'; ?>">
                    <a href="#" class="nav-link <?php if ($page_name == "settings/delivery" || $page_name == "settings/language" || $page_name == "settings/phrase" || $page_name == "settings/system" || $page_name == "settings/website"  || $page_name == "settings/payment" || $page_name == "settings/vat" || $page_name == "settings/revenue" || $page_name == "settings/recaptcha" || $page_name == "settings/smtp" || $page_name == "settings/order") echo 'active'; ?>">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            <?php echo get_phrase("settings"); ?>
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo site_url('settings/system'); ?>" class="nav-link <?php if ($page_name == 'settings/system') echo 'active'; ?>">
                                <i class="fas fa-sliders-h nav-icon"></i>
                                <p><?php echo get_phrase("system_settings", true); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('settings/website'); ?>" class="nav-link <?php if ($page_name == 'settings/website') echo 'active'; ?>">
                                <i class="fab fa-chrome nav-icon"></i>
                                <p><?php echo get_phrase("website_settings", true); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('payment'); ?>" class="nav-link <?php if ($page_name == 'settings/payment') echo 'active'; ?>">
                                <i class="fas fa-coins nav-icon"></i>
                                <p><?php echo get_phrase("payment_settings", true); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('settings/smtp'); ?>" class="nav-link <?php if ($page_name == 'settings/smtp') echo 'active'; ?>">
                                <i class="far fa-paper-plane nav-icon"></i>
                                <p><?php echo get_phrase("smtp_settings", true); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('language'); ?>" class="nav-link <?php if ($page_name == 'settings/language' || $page_name == 'settings/phrase') echo 'active'; ?>">
                                <i class="fas fa-language nav-icon"></i>
                                <p><?php echo get_phrase("language_settings", true); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('settings/order'); ?>" class="nav-link <?php if ($page_name == 'settings/order') echo 'active'; ?>">
                                <i class="fas fa-tasks nav-icon"></i>
                                <p><?php echo get_phrase("order_settings", true); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('settings/delivery'); ?>" class="nav-link <?php if ($page_name == 'settings/delivery') echo 'active'; ?>">
                                <i class="fas fa-truck-loading nav-icon"></i>
                                <p><?php echo get_phrase("delivery_settings", true); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('settings/revenue'); ?>" class="nav-link <?php if ($page_name == 'settings/revenue') echo 'active'; ?>">
                                <i class="fas fa-divide nav-icon"></i>
                                <p><?php echo get_phrase("revenue_settings", true); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('settings/vat'); ?>" class="nav-link <?php if ($page_name == 'settings/vat') echo 'active'; ?>">
                                <i class="fas fa-square-root-alt nav-icon"></i>
                                <p><?php echo "VAT " . get_phrase("settings", true); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('settings/recaptcha'); ?>" class="nav-link <?php if ($page_name == 'settings/recaptcha') echo 'active'; ?>">
                                <i class="fas fa-robot nav-icon"></i>
                                <p><?php echo "reCaptcha " . get_phrase("settings", true); ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="<?php echo site_url('settings/profile'); ?>" class="nav-link <?php if ($page_name == "settings/profile") echo 'active'; ?>">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>
                            <?php echo get_phrase("manage_profile"); ?>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>