<?php 
$restaurant_ids = $this->cart_model->get_restaurant_ids();

if (count($restaurant_ids) > 0) {
    $restaurant_details = $this->restaurant_model->get_by_id($restaurant_ids[0]);
}

$isFooyes = false;
$host = get_subdomain();

if($host === 'fooyes' || $host === 'staging')
    $isFooyes=true;
?>

<style>
    .nav-item{
        margin: 0px !important;
    }

</style>

<div class="bg transition">
    <div class="container-fluid fixed" style="background-color: white; z-index:99;">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                   <div class="container">
                     <a class="navbar-brand" href="<?php echo site_url(); ?>">
                        <?php if($isFooyes): ?>
                            <img src="<?php echo base_url('uploads/system/' . get_website_settings('website_logo')); ?>"
                                class="system-icon">
                                <?php else: ?>
                                    <img width="80px" src="<?php echo base_url('uploads/system/restaurant.png'); ?>"
                                class="system-icon">
                                <?php endif; ?>
                        <!-- </?php echo get_system_settings('system_name'); ?> -->
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-menu"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                        <ul class="navbar-nav">

                            <?php if(isset($cartView) && $cartView == true && $isFooyes == true): ?>
                                    <li class="cart-menu ml-3">
                                        <a href="<?php echo site_url('chilli-hut-march'); ?>" class="cart-btn">
                                            <span class="cart-items" id="cart-items">
                                                <?php echo sanitize($this->cart_model->total_cart_items()); ?>
                                            </span>
                                            <img src="<?php echo base_url('assets/frontend/default/images/cart-icon.png') ?>" />
                                        </a>
                                    </li>
                                    
                                    <?php endif; ?>

                                <!-- <li class="nav-item">
                                    <a class="btn btn-outline-light top-btn" href="<?php echo site_url('auth/registration/driver'); ?>"><?php echo site_phrase('become_a_delivery_man', true); ?></a>
                                </li> -->
                                  <li class="nav-item ">
                                         <?php if($isFooyes): ?>
                        <a class="nav-link" href="<?php echo site_url(); ?>">
                                        <?php echo site_phrase('home'); ?>
                                    </a>
                                <?php else: ?>
                                    
                                 
                                <?php endif; ?>
                                <li class="nav-item">
                                   
                                </li>
                                <?php
                                    $host = get_subdomain();
                                    if($host == 'fooyes' || $host == 'staging'){
                                ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <?php echo site_phrase('restaurants'); ?>
                                        <span class="icon-arrow-down"></span>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <a class="dropdown-item"
                                            href="<?php echo site_url('restaurants/popular'); ?>">
                                            <?php echo site_phrase('popular'); ?>
                                        </a>
                                        <a class="dropdown-item"
                                            href="<?php echo site_url('restaurants/recent'); ?>">
                                            <?php echo site_phrase('recently_added'); ?>
                                        </a>
                                    </div>
                                </li>
                                <?php } ?>
                               <li class="nav-item">

                                    <a class="nav-link" href="<?php echo site_url('contact-us'); ?>">
                                        <?php if ($isFooyes): ?>
                                            <?php echo site_phrase('support'); ?>
                                        <?php else: ?>
                                            <?php echo site_phrase('contact'); ?>
                                        <?php endif; ?>
                                    </a>

                                </li>
                                <div class="auth-btn ms-4">
                                    <li class="nav-item reg-btn">
                                        <a class="nav-link" href="<?php echo site_url('login'); ?>">
                                            <?php echo sanitize($this->session->userdata('is_logged_in')) ? site_phrase('manage_profile', true) : site_phrase('login', true); ?>
                                        </a>
                                    </li>
                                    <li class="nav-item login-btn">
                                         <?php if($isFooyes): ?>
                         <a class="nav-link"  href="<?php echo site_url('become-a-partner'); ?>">
                                              <?php echo site_phrase(ucwords('book_a_demo', true)); ?>
                                        </a>
                                <?php else: ?>

                                <?php endif; ?>
                                     
                                    </li>
                                </div>
                            </ul>
                    </div>
                   </div>
                </nav>
            </div>
        </div>
    </div>
</div>