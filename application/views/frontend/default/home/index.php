<!-- NAVIGATION BAR -->
<?php include APPPATH . 'views/frontend/default/navigation/transparent.php'; ?>

<!-- SLIDER -->
<section class="main-banner d-flex align-items-center">
    <div class="container-fluid m-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-5">
                        <div class="slider-content_wrap">
                            <div class="people-trust">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                    fill="none">
                                    <circle cx="10" cy="10" r="10" fill="#F54748" />
                                    <path
                                        d="M16.6613 7.45916C16.4441 6.97793 16.1309 6.54185 15.7392 6.17532C15.3472 5.80769 14.8851 5.51555 14.3779 5.31477C13.852 5.10575 13.288 4.99876 12.7185 5.00001C11.9195 5.00001 11.1401 5.20933 10.4627 5.60472C10.3006 5.6993 10.1467 5.80319 10.0008 5.91638C9.85495 5.80319 9.701 5.6993 9.53894 5.60472C8.86155 5.20933 8.08206 5.00001 7.28313 5.00001C6.70783 5.00001 6.15036 5.10545 5.62368 5.31477C5.11483 5.51634 4.65621 5.80629 4.26241 6.17532C3.87023 6.54143 3.55695 6.97762 3.34032 7.45916C3.11506 7.95999 3 8.49182 3 9.03916C3 9.55549 3.1102 10.0935 3.32897 10.6409C3.5121 11.0983 3.77463 11.5727 4.11008 12.0519C4.64162 12.8101 5.37249 13.6008 6.28 14.4025C7.78388 15.7313 9.27317 16.6492 9.33637 16.6864L9.72045 16.9221C9.8906 17.026 10.1094 17.026 10.2795 16.9221L10.6636 16.6864C10.7268 16.6476 12.2145 15.7313 13.72 14.4025C14.6275 13.6008 15.3584 12.8101 15.8899 12.0519C16.2254 11.5727 16.4895 11.0983 16.671 10.6409C16.8898 10.0935 17 9.55549 17 9.03916C17.0016 8.49182 16.8865 7.95999 16.6613 7.45916Z"
                                        fill="#FDC55E" />
                                </svg> People Trust us
                            </div>
                            <h1>We're
                                <span class="text-danger">Serious</span> For
                                <span class="text-danger">Food</span> &amp;
                                <span class="text-warning">Delivery</span>.
                            </h1>
                            <h5 class="text-dark font-weight-light">
                                Best cooks and best delivery guys all at your service. Hot tasty food will reach you in
                                60 minutes.
                            </h5>
                        </div>

                        <div class="banner-form-box">
                            <form action="<?php echo site_url('site/restaurants/filter'); ?>" class="form-wrap mt-4"
                                method="GET">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <div class="form-group has-search">
                                        <span class="fa fa-search form-control-feedback"></span>
                                    </div>
                                    <input type="text" id="address"
                                        placeholder="<?php echo site_phrase('which_restaurant_are_you_looking_for'); ?>?"
                                        class="btn-group1 banner-search" name="query" required="">
                                    <input type="hidden" name="latitude_1" class="form-control" id="latitude_1">
                                    <input type="hidden" class="form-control" id="longitude_1" name="longitude_1">
                                    <button type="submit" class="btn-search">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42"
                                            viewBox="0 0 42 42" fill="none">
                                            <circle cx="21" cy="21" r="21" fill="#FDC55E"></circle>
                                        </svg>
                                        <span class="icon-magnifier search-icon"></span>
                                    </button>
                                </div>
                            </form>
                            <div class="slider-link text-left">
                                <a class="btn btn-danger banner-btn mb-2"
                                    href="<?php echo site_url('site/restaurants/popular'); ?>">
                                    Order now
                                </a>
                                <!-- <span>Or</span>  -->
                                <a class="btn btn-danger banner-btn"
                                    href="<?php echo site_url('site/how_to_order'); ?>">
                                    How to order
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 text-md-right">
                        <!-- add ? <.?.php -->
                        <!-- <img class="img-fluid"
                            src="<php echo base_url('assets/frontend/default/images/main-banner-img.png') ?>" /> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--// SLIDER -->
<!--//END HEADER -->
<!--============================= FEATURED CUISINES =============================-->
<section class="order-listing featured-responsive-card-section">
    <div class="container p-0">
        <div class="special-offer-titlebox text-center">
            <h2>Today <span class="red">Special</span> Offers</h2>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                industry's
                standard dummy text ever since the 1500s</p>
        </div>

        <?php if (!empty($featured_restaurants)): ?>
        <div class="grid gallery featured-responsive-card">
            <?php foreach ($featured_restaurants as $key => $restaurant):?>
            <div class="card grid-item restaurant-card col-lg-3 col-md-6 mb-lg-0 mb-5">
                <div class="order-img-box main-img">
                    <a
                        href="<?php echo site_url('site/restaurant/' . sanitize(rawurlencode($restaurant['slug'])) . '/' . sanitize($restaurant['id'])); ?>">
                        <img src="<?php echo base_url('uploads/restaurant/thumbnail/' . sanitize($restaurant['thumbnail'])); ?>"
                            alt="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="250" height="250" viewBox="0 0 250 250"
                            fill="none">
                            <circle cx="125.035" cy="124.965" r="116.153" transform="rotate(178.687 125.035 124.965)"
                                stroke="url(#paint0_linear_33_536)" stroke-width="16"></circle>
                            <defs>
                                <linearGradient id="paint0_linear_33_536" x1="131.787" y1="144.132" x2="131.787"
                                    y2="280.046" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#F54748" stop-opacity="0"></stop>
                                    <stop offset="1" stop-color="#FDC55E"></stop>
                                </linearGradient>
                            </defs>
                        </svg>
                        <div class="percent-box">15%</div>
                    </a>
                </div>
                <div class="restaurant-body text-center">
                    <div class="review-grid d-flex justify-content-around align-items-center m-auto">
                        <?php if($restaurant['rating']){ ?>
                        <ul class="inline-grid m-0 p-0">
                            <li><img class="rounded-img" src="https://dummyimage.com/600x400/000/fff" alt="" width="38"
                                    height="38">
                            </li>
                            <li><img class="rounded-img" src="https://dummyimage.com/600x400/000/fff" alt="" width="38"
                                    height="38">
                            </li>
                            <li><img class="rounded-img" src="https://dummyimage.com/600x400/000/fff" alt="" width="38"
                                    height="38">
                            </li>
                        </ul>
                        <div class="star">
                            <svg width="24" height="22" viewBox="0 0 24 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.0489 0.926805C11.3483 0.00549436 12.6517 0.00549579 12.9511 0.926806L14.9187 6.98253C15.0526 7.39456 15.4365 7.67352 15.8697 7.67352H22.2371C23.2058 7.67352 23.6086 8.91313 22.8249 9.48253L17.6736 13.2252C17.3231 13.4798 17.1764 13.9312 17.3103 14.3432L19.2779 20.3989C19.5773 21.3203 18.5228 22.0864 17.7391 21.517L12.5878 17.7743C12.2373 17.5197 11.7627 17.5197 11.4122 17.7743L6.2609 21.517C5.47719 22.0864 4.42271 21.3203 4.72206 20.3989L6.68969 14.3432C6.82356 13.9312 6.6769 13.4798 6.32642 13.2252L1.17511 9.48253C0.391392 8.91313 0.794168 7.67352 1.76289 7.67352H8.13026C8.56349 7.67352 8.94744 7.39456 9.08132 6.98253L11.0489 0.926805Z"
                                    fill="#FFB800"></path>
                            </svg>
                        </div>
                        <p class="p-0 m-0">(
                            <?php echo sanitize($restaurant['rating']); ?>)
                        </p>
                        <?php } ?>
                    </div>
                    <h3><?php echo sanitize($restaurant['name']); ?></h3>
                    <p><?php echo sanitize($restaurant['restaurant_about']) ?></p>
                </div>
                <a class="btn btn-danger"
                    href="<?php echo site_url('site/restaurant/' . sanitize(rawurlencode($restaurant['slug'])) . '/' . sanitize($restaurant['id'])); ?>">Order
                    Now</a>

            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</section>


<section class="multi-service-box">
    <div class="container-fluid">
        <div class="d-md-flex align-items-center">
            <div class="col-md-5"><img class="img-fluid"
                    src="<?php echo base_url('assets/frontend/default/images/multi-services-img.png') ?>"></div>
            <div class="col-md-7">
                <h3>We are <span class="red">more</span> than<br /> <span class="yellow">multiple</span> service</h3>
                <p>This is a type of resturent which typically serves food and drink, in addition to light refreshments
                    such as
                    baked goods or snacks. The term comes frome the rench word meaning food</p>
                <div class="row multi-service-list mt-4 mb-3">
                    <div class="col-lg-4 col-md-6"><img
                            src="<?php echo base_url('assets/frontend/default/images/online-order-icon.png') ?>" />
                        Online Order</div>
                    <div class="col-lg-4 col-md-6"><img
                            src="<?php echo base_url('assets/frontend/default/images/24-7-icon.png') ?>" /> 24/7 Service
                    </div>
                </div>
                <div class="row multi-service-list mb-3">
                    <div class="col-lg-4 col-md-6"><img
                            src="<?php echo base_url('assets/frontend/default/images/pre-reservation-icon.png') ?>" />
                        Pre-Reservation
                    </div>
                    <div class="col-lg-5 col-md-6"><img
                            src="<?php echo base_url('assets/frontend/default/images/pre-reservation-icon.png') ?>" />
                        Oragonized
                        Foodhut Place</div>
                </div>
                <div class="row multi-service-list mb-3">
                    <div class="col-lg-4 col-md-6"><img
                            src="<?php echo base_url('assets/frontend/default/images/pre-reservation-icon.png') ?>" />
                        Super Chef
                    </div>
                    <div class="col-lg-4 col-md-6"><img
                            src="<?php echo base_url('assets/frontend/default/images/pre-reservation-icon.png') ?>" />
                        Clean Kitchen
                    </div>
                </div>

                <a class="rr-btn mt-4" href="#">About Us</a>

            </div>
        </div>
    </div>
</section>


<section class="featured-responsive-card-section">
    <div class="container p-0">
        <div class="special-offer-titlebox text-center">
            <h2>
                <sapn class="red">Menu</sapn> That <sapn class="yellow">Always</sapn> Make<br /> You Fall In <sapn
                    class="red">
                    Love</sapn>
            </h2>
        </div>

        <!-- Featured Resturants -->
        <div class="special-offer-btnlist mt-5">
            <ul class="m-0 p-0 text-center filtering">
                <span data-filter="*" class="gb-btn active" href="#">All</span>
                <?php foreach ($cuisines as $cuisine_row) :  ?>
                <span data-filter=".cuisine_<?php echo sanitize($cuisine_row['id']); ?>" class="gb-btn"
                    href="#"><?php echo sanitize($cuisine_row['name']); ?></span>
                <?php endforeach; ?>
            </ul>
        </div>

        <?php if (!empty($featured_restaurants)): ?>
        <div class="grid gallery featured-responsive-card">
            <?php foreach ($featured_restaurants as $key => $restaurant):
              $idArray = json_decode($restaurant['cuisine']); 
              $cuisineClasses = '';
          
              if (!empty($idArray)) {
                  $cuisineClasses = implode(' ', array_map(function ($id) {
                      return 'cuisine_' . $id;
                  }, $idArray));
              } 
        ?>
            <div class="card grid-item <?php echo $cuisineClasses; ?> restaurant-card col-lg-3 col-md-6 mb-lg-0 mb-5">
                <div class="order-img-box main-img">
                    <a
                        href="<?php echo site_url('site/restaurant/' . sanitize(rawurlencode($restaurant['slug'])) . '/' . sanitize($restaurant['id'])); ?>">
                        <img src="<?php echo base_url('uploads/restaurant/thumbnail/' . sanitize($restaurant['thumbnail'])); ?>"
                            alt="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="250" height="250" viewBox="0 0 250 250"
                            fill="none">
                            <circle cx="125.035" cy="124.965" r="116.153" transform="rotate(178.687 125.035 124.965)"
                                stroke="url(#paint0_linear_33_536)" stroke-width="16"></circle>
                            <defs>
                                <linearGradient id="paint0_linear_33_536" x1="131.787" y1="144.132" x2="131.787"
                                    y2="280.046" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#F54748" stop-opacity="0"></stop>
                                    <stop offset="1" stop-color="#FDC55E"></stop>
                                </linearGradient>
                            </defs>
                        </svg>
                        <div class="percent-box">15%</div>
                    </a>
                </div>
                <div class="restaurant-body text-center">
                    <div class="review-grid d-flex justify-content-around align-items-center m-auto">
                        <?php if($restaurant['rating']){ ?>
                        <ul class="inline-grid m-0 p-0">
                            <li><img class="rounded-img" src="https://dummyimage.com/600x400/000/fff" alt="" width="38"
                                    height="38">
                            </li>
                            <li><img class="rounded-img" src="https://dummyimage.com/600x400/000/fff" alt="" width="38"
                                    height="38">
                            </li>
                            <li><img class="rounded-img" src="https://dummyimage.com/600x400/000/fff" alt="" width="38"
                                    height="38">
                            </li>
                        </ul>
                        <div class="star">
                            <svg width="24" height="22" viewBox="0 0 24 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.0489 0.926805C11.3483 0.00549436 12.6517 0.00549579 12.9511 0.926806L14.9187 6.98253C15.0526 7.39456 15.4365 7.67352 15.8697 7.67352H22.2371C23.2058 7.67352 23.6086 8.91313 22.8249 9.48253L17.6736 13.2252C17.3231 13.4798 17.1764 13.9312 17.3103 14.3432L19.2779 20.3989C19.5773 21.3203 18.5228 22.0864 17.7391 21.517L12.5878 17.7743C12.2373 17.5197 11.7627 17.5197 11.4122 17.7743L6.2609 21.517C5.47719 22.0864 4.42271 21.3203 4.72206 20.3989L6.68969 14.3432C6.82356 13.9312 6.6769 13.4798 6.32642 13.2252L1.17511 9.48253C0.391392 8.91313 0.794168 7.67352 1.76289 7.67352H8.13026C8.56349 7.67352 8.94744 7.39456 9.08132 6.98253L11.0489 0.926805Z"
                                    fill="#FFB800"></path>
                            </svg>
                        </div>
                        <p class="p-0 m-0">(
                            <?php echo sanitize($restaurant['rating']); ?>)
                        </p>
                        <?php } ?>
                    </div>
                    <h3><?php echo sanitize($restaurant['name']); ?></h3>
                    <p><?php echo sanitize($restaurant['restaurant_about']) ?></p>
                </div>
                <a class="btn btn-danger"
                    href="<?php echo site_url('site/restaurant/' . sanitize(rawurlencode($restaurant['slug'])) . '/' . sanitize($restaurant['id'])); ?>">Order
                    Now</a>

            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>


        <!-- ./Featured Resturants loop -->

    </div>
</section>


<section class="dt-hide"><img class="img-fluid"
        src="<?php echo base_url('assets/frontend/default/images/footer-mob-img.png') ?>" /></section>
<section class="footer-top mt-4">
    <div class="container-fluid">
        <div class="d-md-flex ">
            <div class="col-md-6">
                <h3>It’s Now <span class="red">More Easy</span> to <span class="yellow">Order</span> by Our Mobile <span
                        class="red">App</span></h3>
                <p>All you need to do is downlode one of the best delivery apps, make a and most companies are opting
                    for mobile
                    app devlopment for food delivery</p>
                <div class="google-btns"><a href="#" class="goole-play-btn"><img
                            src="<?php echo base_url('assets/frontend/default/images/google-play-icon.png') ?>" /></a>
                    <a href="#"><img
                            src="<?php echo base_url('assets/frontend/default/images/app-store-icon.png') ?>" /></a>
                </div>
            </div>
            <div class="col-md-6 mob-hide"><img class="img-fluid"
                    src="<?php echo base_url('assets/frontend/default/images/footer-top-img.png') ?>" /></div>
        </div>
    </div>
</section>