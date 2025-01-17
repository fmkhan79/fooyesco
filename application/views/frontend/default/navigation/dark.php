<?php 
$restaurant_ids = $this->cart_model->get_restaurant_ids();

if (count($restaurant_ids) > 0) {
    $restaurant_details = $this->restaurant_model->get_by_id($restaurant_ids[0]);
}
?>

<div class="bg transition">
    <div class="container-fluid fixed" style="background-color: white; z-index:99;">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="<?php echo site_url(); ?>">
                        <img src="<?php echo base_url('uploads/system/' . get_website_settings('website_logo')); ?>"
                            class="system-icon">
                        <!-- </?php echo get_system_settings('system_name'); ?> -->
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-menu"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_url(); ?>">
                                    <?php echo site_phrase('home'); ?>
                                </a>
                            </li>
                            <!--<li class="nav-item dropdown">
                                      <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Restaurants                                        <span class="icon-arrow-down"></span>
                                      </a>
                                      <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                          <a class="dropdown-item" href="https://stagging.chilli-hut-march.co.uk/site/restaurants/popular">Popular</a>
                                          <a class="dropdown-item" href="https://stagging.chilli-hut-march.co.uk/site/restaurants/recent">Recently added</a>
                                      </div>
                                  </li>-->

                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <?php echo site_phrase('restaurants'); ?>
                                    <span class="icon-arrow-down"></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="<?php echo site_url('site/restaurants/popular'); ?>">
                                        <?php echo site_phrase('popular'); ?>
                                    </a>
                                    <a class="dropdown-item" href="<?php echo site_url('site/restaurants/recent'); ?>">
                                        <?php echo site_phrase('recently_added'); ?>
                                    </a>
                                </div>
                            </li>
                            <li class="cart-menu">
                                <?php if ($restaurant_details): ?>
                                <a href="<?php echo site_url('cart'); ?>"
                                    class="cart-btn">
                                    <span class="cart-items" id="#cart-items">
                                        <?php echo sanitize($this->cart_model->total_cart_items()); ?>
                                    </span>
                                    <img
                                        src="<?php echo base_url('assets/frontend/default/images/cart-icon.png'); ?>" />
                                </a>
                                <?php else: ?>
                                <a href="#" class="cart-btn">
                                    <span class="cart-items" id="#cart-items">
                                        <?php echo sanitize($this->cart_model->total_cart_items()); ?>
                                    </span>
                                    <img
                                        src="<?php echo base_url('assets/frontend/default/images/cart-icon.png'); ?>" />
                                </a>
                                <?php endif; ?>

                            </li>
                            <li class="nav-item reg-btn">

                            </li>
                            <li class="nav-item login-btn">

                                <a class="nav-link"
                                    href="<?php if($this->session->userdata('is_guest')){ echo "#"; }else{ echo site_url('login'); } ?>">

                                    <?php if($this->session->userdata('is_guest')){ echo site_phrase('login'); }else{ echo sanitize($this->session->userdata('is_logged_in')) ? site_phrase('manage_profile', true) : site_phrase('login'); } ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>