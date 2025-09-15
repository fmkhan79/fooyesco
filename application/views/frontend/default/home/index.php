<!-- NAVIGATION BAR -->
<?php include APPPATH . 'views/frontend/default/navigation/transparent.php'; ?>
<style>
    .disabled {
        pointer-events: none;
        opacity: 0.6;
        cursor: not-allowed;

    }
    .fooyes-welcome {
    background: #fff;
    padding: 60px 20px;
    position: relative;
}

.fooyes-welcome-container {
    display: flex;        
    flex-wrap: wrap;
}

.fooyes-welcome-content {
    max-width: 550px;
    text-align: left;
}

.fooyes-welcome-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #222;
}

.fooyes-text-red {
    color: #e63946;
}

.fooyes-text-yellow {
    color: #f4a261;
}

.fooyes-welcome-description {
    font-size: 1.2rem;
    color: #555;
    margin-top: 15px;
    line-height: 1.6;
}

.fooyes-welcome-image {
    max-width: 400px;
    position: relative;
}

.fooyes-welcome-image img {
    width: 100%;
    border-radius: 15px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}
.fooyes-highlight-red {
    color: #e63946;
}
.fooyes-highlight-yellow {
    color:#fdc55e;
}
.fooyes-section-title {
    font-weight: 700;
}

.fooyes-why-choose {
    background: #fff;
    padding: 0px 20px 60px 20px;
    text-align: center;
}

.fooyes-container {
    max-width: 1100px;
    margin: 0 auto;
}

.fooyes-title {
    font-size: 48px;
    font-weight: 700;
    color: #222;
    margin-bottom: 40px;
}

.text-red {
    color: #e63946;
}

.text-yellow {
    color: #fdc55e;
}

.fooyes-why-grid {
    display: grid;
    grid-template-columns: repeat(2 , 1fr);
    gap: 20px;
    text-align: center;
}
@media (max-width: 480px) {
.fooyes-why-grid{
    grid-template-columns: repeat(1 , 1fr);

}
}

.fooyes-why-card {
    background: #f8f8f8;
    padding: 1px;
    border-radius: 12px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.fooyes-why-card:hover {
    transform: translateY(-5px);
}

.fooyes-why-icon {
    width: 50px;
    margin-bottom: 15px;
}

.fooyes-why-card h3 {
    font-size: 1.5rem;
    color: #222;
    margin-bottom: 10px;
}

.fooyes-why-card p {
    font-size: 18px;
    color: #191919;
    line-height: 1.5;
}

.fooyes-why-icon {
    font-size: 2.5rem;
    color: #e63946;
    margin-bottom: 15px;
}
.fooyes-icon {
    color: #e63946;
    margin-right: 8px;
}
.fooyes-offerings {
    background: #f44647;
    padding: 60px 20px;
    text-align: center;
    margin-bottom:150px;
}

.fooyes-offerings-container {
    max-width: 800px;
    margin: 0 auto;
}

.fooyes-offerings-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #222;
    margin-bottom: 20px;
}

.fooyes-offerings-text {
    font-size: 1.2rem;
    color: #fff;
    line-height: 1.5;
}

.cookie-banner{
    width: 500px;
    position: fixed;
    bottom: 18px;
    right: 10px;
    height: auto;
    background-color: #fff9ef;
    z-index: 99999;
    border-radius: 1rem;
    color: #222;
    display: none;
    padding: 10px 20px;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
}

.cookie-banner .actions{
    padding-top: 25px;
    display: flex;
    justify-content: end;
}

.cookie-banner .btn-cb{
    background-color: #f44647;
    /* border: 5px solid rgb(255, 187, 61); */
    color: #fff !important;
    padding: 8px 28px;
    font-weight: 500;
    border-radius: 2rem;
    font-size: 18px;
}

.cookie-banner h3{
    font-size: 18px;
    font-weight: 300 !important;
    margin-top: 16px;
}
.cookie-banner h2{
    font-size: 28px;
    font-weight: 600 !important;
}

@media (max-width: 768px) {
    .cookie-banner{
        width: 70%;
        right: 15%;
        text-align: center;
        padding: 10px 10px;
    }
    .cookie-banner .actions{
        padding-top: 15px;
        display: flex;
        justify-content: center;
    }
    .cookie-banner h3{
        font-size: 14px;
    }
    .cookie-banner h2{
        font-size: 18px;
        font-weight: 600 !important;
    }

    .cookie-banner p{
        font-size: 11px;
    }
    .cookie-banner .btn-cb{
          background-color: #f44647;
    /* border: 5px solid rgb(255, 187, 61); */
    color: #fff !important;
    padding: 8px 28px;
    font-weight: 500;
    border-radius: 2rem;
        font-size: 12px;
    }

}

/* @media (min-width: 480px) {
.welcome-foo {
    padding-left: 7rem !important
}

  

} */


</style>
<!-- SLIDER -->
<section class="main-banner d-flex align-items-center">
    <div class="container my-5" style="max-width: 1000px!important">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-5 pl-3 pl-md-0">
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
                            <div>

                      
                            <h1>We're
                                <span class="text-danger">Serious</span> For
                                <span class="text-danger">Food</span> &amp;
                                <span class="text-warning">Delivery</span>.
                            </h1>
                         
                            </div>
                        </div>

                        <!-- for mobile  -->
                  

                    <!-- end for mobile  -->


                     <!-- start for desktop -->
                    <div class="banner-form-box d-md-block d-flex  flex-column-reverse">
                    <h5 class="text-dark font-weight-light pt-4 pt-md-0 " style="font-size:18px;">
                                Best cooks and best delivery guys all at your service. Hot tasty food will reach you in
                                60 minutes.
                            </h5>
                        <form action="<?php echo site_url('site/restaurants/filter'); ?>" class="form-wrap mt-4" method="GET">
                            
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <div class="form-group has-search">
                                    <span class="fa fa-search form-control-feedback"></span>
                                </div>
                                <input type="text" id="address-sc" placeholder="<?php echo site_phrase('which_restaurant_are_you_looking_for'); ?>?"
                                    class="btn-group1 banner-search" name="query" onchange="updateButtonStatesc()">
                                <input type="hidden" name="latitude_1" class="form-control" id="latitude_sc">
                                <input type="hidden" class="form-control" id="longitude_sc" name="longitude_1">
                                <button type="submit" class="btn-search disabled" id="searchsc">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 42 42" fill="none">
                                        <circle cx="21" cy="21" r="21" fill="#FDC55E"></circle>
                                    </svg>
                                    <span class="icon-magnifier search-icon"></span>
                                </button> 
                            </div>


                        <div class="slider-link text-left mt-4 !important">
                            <button type="submit" class="btn btn-danger banner-btn disabled" style="
                            color: #FFF;
    font-size: 14px;
    font-style: normal;
    font-weight: 600;
    line-height: 100%;
    letter-spacing: 0.16px;
    border-radius: 41px;
    padding: 13px;
    vertical-align: sub;
    margin-right: 5px;
    background: #F54748 !important;
    border-color: #F54748 !important;


                            " id="searchwc">
                               
                            Order Now

                                    </button>

                            <!-- <button class="btn btn-danger banner-btn mb-2">
                                    
                                Order now
                                </button> -->

                            <!-- <span>Or</span>  -->
                            </form>

                            <button class="btn btn-danger banner-btn"style="
                            color: #FFF;
    font-size: 14px;
    font-style: normal;
    font-weight: 600;
    line-height: 100%;
    letter-spacing: 0.16px;
    border-radius: 41px;
    padding: 13px;
    vertical-align: sub;
    margin-right: 5px;
    background: #F54748 !important;
    border-color: #F54748 !important;
                                href="<?php echo site_url('how_to_order'); ?>">
                                How to order
                            </button>
                        </div>
                    </div>
                </div>
               
                <div class="col-md-7 text-md-right">
                    <!-- add ? <.?.php -->
                    <img class="img-fluid"
                        src="<?php echo base_url('assets/frontend/default/images/hero-img.png') ?>" />
                </div>
                
            </div>
            
        </div>
        
    </div>
    
    </div>
</section>
<!--// SLIDER -->
<!--//END HEADER -->
<!--============================= FEATURED CUISINES =============================-->
<div class="container">
    <div class="about-txt my-5 py-md-4" style="background: url(<?php echo base_url("assets/frontend/default/images/about-img.png"); ?>) no-repeat right; height: 60vh;
    display: flex;
    align-items: center;">
<div class="container px-0 pt-md-5 px-md-4 " style="padding-bottom: 20px  max-width: 1000px!important">

            <div class="p-0 m-0 " style="margin-left: 0px;">
                <div class="welcome-foo col-md-6 ">
                <h2 class="fooyes-section-title">
            Welcome to <span class="fooyes-highlight-red">Fooyes</span> <span class="fooyes-highlight-yellow">UK</span>
        </h2>
                    <p style="font-size: 18px; line-height: 31px;">At <b>Fooyes UK</b>, we bring you an unforgettable food experience, combining the finest ingredients,
bold flavors, and a passion for culinary excellence. Whether you're craving classic British
favorites or globally inspired delights, we've got something to satisfy every palate.</p>
            </div>
        </div>
        </div>
</div>
</div>


<!-- Special offer -->
<section class="order-listing featured-responsive-card-section">
    <div class="container p-0" style="max-width: 1045px!important">
        <div class="special-offer-titlebox ">
            <h2>Today<span class="red">Special</span> Offers</h2>
            <p>7 DAYS ONLY! Enjoy 25% OFF on all collection orders and 20% OFF on delivery orders. Don't miss out—order now and indulge in your favorite flavors at a discounted price!</p>
        </div>

            <div class="row gallery featured-responsive-card justify-content-between">
                <?php 
                $menus = $this->menu_model->get_menu_by_condition(['today_special' => true]);
                if(!empty($menus)):
                foreach ($menus as $key => $menu): ?>
                    <div class="card grid-item restaurant-card col-lg-3 col-md-6 mb-lg-0 mb-5">
                        <div class="order-img-box main-img">
                            <a
                                href="<?php echo site_url('site/restaurant/' . sanitize(rawurlencode($menu['slug'])) . '/' . sanitize($restaurant['id'])); ?>">
                                <img src="<?php echo base_url('uploads/restaurant/thumbnail/' . sanitize($menu['thumbnail'])); ?>"
                                    alt="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="250" height="250" viewBox="0 0 250 250"
                                    fill="none">
                                    <circle cx="125.035" cy="124.965" r="116.153" transform="rotate(178.687 125.035 124.965)"
                                        stroke="url(#paint0_linear_33_536)" stroke-width="16"></circle>
                                    <defs>
                                        <linearGradient id="paint0_linear_33_536" x1="131.787" y1="144.132" x2="131.787"
                                            y2="280.046" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#F57484" stop-opacity="0"></stop>
                                            <stop offset="1" stop-color="#FDC55E"></stop>
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <div class="percent-box"><?php 
                                    $jsonDecodePrice = json_decode($menu['price']);
                                    echo currency(number_format($jsonDecodePrice->menu, 0));  
                                ?></div>
                            </a>
                        </div>
                        <div class="restaurant-body text-center">
                            <div class="review-grid d-flex justify-content-around align-items-center m-auto">
                                <?php if ($restaurant['rating']) { ?>
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
                            <h3><?php echo sanitize($menu['name']); ?></h3>
                            <p><?php echo sanitize($menu['details']) ?></p>
                        </div>
                        <a class="btn btn-danger"
                             href="javascript:void(0);"
                            onclick="addToCart('<?php echo $menu['id']; ?>', '<?php $jsonDecodePrice = json_decode($menu['price']); echo $jsonDecodePrice->menu; ?>', true)">Order
                            Now</a>
                        <!-- <a class="btn btn-danger"
                            href="http://<?= $restaurant['slug']; ?>.fooyes.local">Order
                            Now</a> -->

                    </div>
                <?php endforeach;
                    endif;
                ?>
            </div>

    </div>
</section>

<!-- Restaurants -->
<section class="order-listing featured-responsive-card-section">
    <div class="container p-0" style="max-width: 1045px !important">
        <div class="special-offer-titlebox">
            <h2>Explore <span style="color:#fdc55e;">-</span> <span class="red">Restaurants</span></h2>
            <p>7 DAYS ONLY! Enjoy 25% OFF on all collection orders and 20% OFF on delivery orders. Don't miss out—order now and indulge in your favorite flavors at a discounted price!</p>
        </div>

        <?php if (!empty($featured_restaurants)): ?>
            <div class="row gallery featured-responsive-card justify-content-between">
                <?php foreach ($featured_restaurants as $key => $restaurant): ?>
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
                                            <stop stop-color="#F57484" stop-opacity="0"></stop>
                                            <stop offset="1" stop-color="#FDC55E"></stop>
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <div class="percent-box">20%</div>
                            </a>
                        </div>
                        <div class="restaurant-body text-center">
                            <div class="review-grid d-flex justify-content-around align-items-center m-auto">
                                <?php if ($restaurant['rating']) { ?>
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
                        <!-- <a class="btn btn-danger"
                            href="http://<?= $restaurant['slug']; ?>.fooyes.local">Order
                            Now</a> -->

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>


<section class="fooyes-offerings">
    <div class="fooyes-offerings-container">
        <h2 class="fooyes-offerings-title"><span class="yellow">Explore</span> <span style="color:white;">Our Offerings</span></h2>
        <p class="fooyes-offerings-text">
            <strong>Dine-In & Takeaway –</strong> Experience our food at your convenience. <br>
            <strong>Fast & Reliable Delivery –</strong> Get your favorite dishes straight to your door.
        </p>
    </div>
</section>


<section class="fooyes-why-choose">
    <div class="fooyes-container pl-2 pl-md-0" style="max-width: 1000px!important">
        <h2 class="fooyes-title">
            <span class="text-red">Why</span> Choose <span class="text-yellow">Fooyes UK?</span>
        </h2>
        <div class="fooyes-why-grid">
            <div class="fooyes-why-card">
            <i class="fas fa-check-circle fooyes-why-icon"></i>
                <h3>Quality You Can Trust</h3>
                <p>We source the best ingredients to ensure every bite is fresh and delicious.</p>
            </div>
            <div class="fooyes-why-card">
            <i class="fas fa-utensils fooyes-why-icon"></i>
                <h3>Innovative & Exciting Menus</h3>
                <p>From timeless dishes to creative new flavors, we’re always pushing boundaries.</p>
            </div>
            <div class="fooyes-why-card">
            <i class="fas fa-leaf fooyes-why-icon"></i>  
                <h3>Sustainability Matters</h3>
                <p>We are committed to eco-friendly practices, reducing waste, and supporting local producers.</p>
            </div>
            <div class="fooyes-why-card">
            <i class="fas fa-heart fooyes-why-icon"></i>
                <h3>Customer-First Approach</h3>
                <p>Your satisfaction is at the heart of everything we do.</p>
            </div>
        </div>
    </div>
</section>


<section class="multi-service-box">
    <div class="container" style="max-width: 1000px!important pl-0!important">
        <div class="d-md-flex align-items-center">
            <div class="col-md-5"><img class="img-fluid"
                    src="<?php echo base_url('assets/frontend/default/images/mult-service.png') ?>"></div>
            <div class="col-md-7">
                <h3>We are <span class="red">more</span> than<br /> <span class="yellow">multiple</span> service</h3>
                <p>This is a type of resturent which typically serves food and drink, in addition to light refreshments
                    such as
                    baked goods or snacks. The term comes frome the rench word meaning food</p>
                <div class="row multi-service-list mt-4 mb-3">
                    <div class="col-lg-4 col-md-6 pl-3"><img
                            src="<?php echo base_url('assets/frontend/default/images/online-order-icon.png') ?>" />
                        Online Order</div>
                    <div class="col-lg-4 col-md-6 pl-3"><img
                            src="<?php echo base_url('assets/frontend/default/images/24-7-icon.png') ?>" /> 24/7 Service
                    </div>
                </div>
                <div class="row multi-service-list mb-3 ">
                    <div class="col-lg-4 col-md-6 pl-3"><img
                            src="<?php echo base_url('assets/frontend/default/images/pre-reservation-icon.png') ?>" />
                        Pre-Reservation
                    </div>
                    <div class="col-lg-5 col-md-6 pl-3"><img
                            src="<?php echo base_url('assets/frontend/default/images/pre-reservation-icon.png') ?>" />
                        Oragonized
                        Foodhut Place</div>
                </div>
                <div class="row multi-service-list mb-3 ">
                    <div class="col-lg-4 col-md-6 pl-3"><img
                            src="<?php echo base_url('assets/frontend/default/images/pre-reservation-icon.png') ?>" />
                        Super Chef
                    </div>
                    <div class="col-lg-4 col-md-6 pl-3"><img
                            src="<?php echo base_url('assets/frontend/default/images/pre-reservation-icon.png') ?>" />
                        Clean Kitchen
                    </div>
                </div>

                <a class="rr-btn mt-4" href="<?php echo site_url('about-us'); ?>">About Us</a>

            </div>
        </div>
    </div>
</section>


<!-- <section class="featured-responsive-card-section">
    <div class="container p-0">
        <div class="special-offer-titlebox text-center">
            <h2>
                <sapn class="red">Menu</sapn> That <sapn class="yellow">Always</sapn> Make<br /> You Fall In <sapn
                    class="red">
                    Love</sapn>
            </h2>
        </div>

    
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
                                <?php if ($restaurant['rating']) { ?>
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
</section> -->


<section class="dt-hide d-none"><img class="img-fluid"
        src="<?php echo base_url('assets/frontend/default/images/footer-mob-img.png') ?>" /></section>
<section class="before-footer mt-4">
    <div class="container" style="max-width: 1000px!important">
        <div class="d-md-flex ">
            <div class="col-md-6">
                <h3>Join the <span class="red">Fooyes</span> Community </span></h3>
                <p>Follow us on social media and sign up for exclusive offers, new menu launches, and foodie events.</p>
                <p><i class="fas fa-map-marker-alt fooyes-icon"></i> <strong>Find Us:</strong> 40 High St, March PE15 9JR, United Kingdom</p>
    <p><i class="fas fa-phone-alt fooyes-icon"></i> <strong>Contact Us:</strong> <a href="tel:+44 1354 654992" style="color:#191919">+44 1354 654992</a></p>
    <p><i class="fas fa-envelope fooyes-icon"></i> <strong>Email:</strong> <a href="mailto:chillihutmarchonline.com" style="color:#191919">chillihutmarchonline.com</a></p>
    <p style="font-size:18px"> <b>Delicious moments start here. Welcome to Fooyes UK!</b></p>
            </div>
            <div class="col-md-6 mob-hide"><img class="img-fluid"
                    src="<?php echo base_url('assets/frontend/default/images/footer-top.png') ?>" /></div>
        </div>
    </div>
</section>


<div class="cookie-banner"  id="cookie-banner">
    <div class="container-fluid my-2">
        <div class="row">
            <div class="col-md-12">
                          <h2>We value your privacy</h2>    
                <h3>To give you the best experience, we use cookies to understand how our site is used, improve functionality, and provide personalized content and offers. By selecting “Accept”, you consent to our use of cookies as described in our Cookie Policy.</h3>
                                    <div class="actions">
                    <a href="" onclick="ignoreCookies()" class="mx-2 btn btn-cb">Ignore</a>
                    <a href="" onclick="acceptCookies()" class="mx-2 btn btn-cb">Accept</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Backdrop */
#termBackdrop {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    z-index: 9998;
    display: none;
}

/* Popup */
#termPopup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff9ef;
    padding: 30px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0px 0px 15px rgba(0,0,0,0.2);
    border-radius: 10px;
    z-index: 9999;
    display: none;
    text-align: center;
}

#termPopup h5 {
    font-weight: 700;
    margin-bottom: 15px;
}

#termPopup p {
    font-size: 14px;
    margin-bottom: 20px;
}

#termPopup a {
    color: #f44647;
    text-decoration: underline;
}
#termPopup a:hover {
    color: #f44647 !important;
    text-decoration: underline;
}

#termPopup .btn-cb {
    background-color: #f44647;
    color: #fff;
    padding: 8px 24px;
    font-weight: 500;
    border-radius: 2rem;
    font-size: 14px;
    border: none;
}
</style>

<!-- Black backdrop -->
<div id="termBackdrop"></div>

<!-- Terms & Conditions Popup -->
<!-- <div id="termPopup">
  <h5>Terms & Conditions</h5>
  <p>
    Please review and accept our 
    <a href="<?php echo site_url('privacy-policy'); ?>" target="_blank">Privacy Policy</a> and 
    <a href="<?php echo site_url('terms-and-conditions'); ?>" target="_blank">Terms & Conditions</a> 
    before continuing.
  </p>
  <button class="btn btn-cb" onclick="continueTerms()">Continue</button>
</div> -->

<script>
document.addEventListener("DOMContentLoaded", function () {
    if (localStorage.getItem("terms_accepted") !== "true") {
        // Show popup & backdrop
        document.getElementById("termPopup").style.display = "block";
        document.getElementById("termBackdrop").style.display = "block";

        // Disable page scroll
        document.body.style.overflow = "hidden";
    }
});

function continueTerms() {
    localStorage.setItem("terms_accepted", "true");

    // Hide popup & backdrop
    document.getElementById("termPopup").style.display = "none";
    document.getElementById("termBackdrop").style.display = "none";

    // Enable scroll again
    document.body.style.overflow = "auto";
}
</script>
