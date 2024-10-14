<!--============================= HEADER =============================-->
<div class="nav-menu">
    <div class="bg transition">
        <div class="container-fluid fixed">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="<?php echo site_url(); ?>"> <img src="<?php echo base_url('uploads/system/' . get_website_settings('website_logo')); ?>" class="system-icon"> <span class="d-none d-sm-inline-block"><?php echo get_system_settings('system_name'); ?></span> </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="icon-menu"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="btn btn-outline-light top-btn" href="<?php echo site_url('auth/registration/driver'); ?>"><?php echo site_phrase('become_a_delivery_man', true); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo site_url(); ?>"><?php echo site_phrase('home'); ?></a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php echo site_phrase('restaurants'); ?>
                                        <span class="icon-arrow-down"></span>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <a class="dropdown-item" href="<?php echo site_url('site/restaurants/popular'); ?>"><?php echo site_phrase('popular'); ?></a>
                                        <a class="dropdown-item" href="<?php echo site_url('site/restaurants/recent'); ?>"><?php echo site_phrase('recently_added'); ?></a>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo site_url('login'); ?>"><?php echo sanitize($this->session->userdata('is_logged_in')) ? site_phrase('manage_profile', true) : site_phrase('sign_in', true); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('cart'); ?>" class="btn btn-outline-light top-btn"><span class="cart-items" id="#cart-items"><?php echo sanitize($this->cart_model->total_cart_items()); ?></span><span class="ti-shopping-cart"></span></a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
