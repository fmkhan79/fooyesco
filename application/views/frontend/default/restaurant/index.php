<!-- NAVIGATION BAR -->


<?php include APPPATH . 'views/frontend/default/navigation/dark.php';
?>
<style>
    .disabled {
        pointer-events: none;
        /* Prevent clicks */
        opacity: 0.5;
        /* Make it look disabled */
        cursor: not-allowed;
        /* Change cursor to indicate it's not clickable */
    }
</style>
<!-- RESTAURANT GALLERY -->

<!-- RESTAURANT TITLE HEADER -->
<section class="detail-wbox mt-4">
    <div class="container bg-white text-dark border border-light">
        <div class="row">
            <div class="col-md-8">
                <div class="d-md-flex justify-content-between">
                    <div class="detail-wbox-title">
                        <h3>
                            <?php echo $restaurant_details['name']; ?>
                        </h3>

                        <?php if ($restaurant_details["address"]) {
                            echo $restaurant_details["address"]; ?> - <span class="red">Get
                                directions</span>
                        <?php } ?>
                        <div class="red big-txt">
                            <?php

                            $cuisines = json_decode($restaurant_details['cuisine']);
                            foreach ($cuisines as $key => $cuisine):

                            ?>
                                <?php
                                $cuisine = $this->cuisine_model->get_by_id($cuisine);
                                if (isset($cuisine) && count($cuisine)): ?>

                                    <?php if ($key === array_key_last($cuisines)) {
                                        echo sanitize($cuisine['name']);
                                    } else {
                                        echo sanitize($cuisine['name'] . ' |');
                                    } ?>


                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="review-box d-flex justify-content-between align-items-center">


                        <div class="review-box-txt col-md-4">
                            <?php if ($restaurant_details['rating']) { ?>
                                Superb <?php echo sanitize($reviews_count); ?>
                                Reviews
                            <?php } ?>
                        </div>
                        <div class="review-grid d-flex justify-content-around align-items-center m-0 col-md-7">
                            <?php if ($restaurant_details['rating']) { ?>
                                <ul class="inline-grid">
                                    <li><img class="rounded-img" src="https://dummyimage.com/600x400/000/fff" alt
                                            width="38" height="38">
                                    </li>
                                    <li><img class="rounded-img" src="https://dummyimage.com/600x400/000/fff" alt
                                            width="38" height="38">
                                    </li>
                                    <li><img class="rounded-img" src="https://dummyimage.com/600x400/000/fff" alt
                                            width="38" height="38">
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
                                <p class="p-0 m-0">(<?php echo sanitize($restaurant_details['rating']); ?>)</p>
                            <?php } ?>
                        </div>
                    </div>

                </div>

                <div class="row my-4 free-delivery-list">

                    <div class="col-md-3 col-sm-6"><img src="<?php echo base_url('assets/frontend/default/images/delivery-free-icon.png'); ?>" />
                        Delivery fee :
                        0-
                        <?php echo $restaurant_details['delivery_charge']; ?>$
                    </div>
                    <div class="col-md-3 col-sm-6"><img src="<?php echo base_url('assets/frontend/default/images/min-order-icon.png'); ?>" /> Min
                        Order : 10 $
                    </div>
                    <div class="col-md-3 col-sm-6"><img src="<?php echo base_url('assets/frontend/default/images/collect-icon.png'); ?>" />
                        <span id="delivery" class="collect-box">Delivering now</span><span id="collection"
                            class="collect-box" style="display:none">I
                            want to collect</span>
                    </div>
                    <div class="col-md-3 col-sm-6 red"><img src="<?php echo base_url('assets/frontend/default/images/time-icon-red.png'); ?>" />
                        <?php echo $restaurant_details['maximum_time_to_deliver']; ?> mins
                    </div>

                </div>

                <div class="order-about">
                    <h3><strong>About "
                            <?php echo $restaurant_details['name']; ?>"
                        </strong></h3>
                    <?php echo $restaurant_details['restaurant_about']; ?>. <a class="red" href="#"> READ MORE</a>
                </div>

            </div>
            <div class="col-md-4"><img class="img-fluid" src="<?php echo base_url('assets/frontend/default/images/detail-wbox-img.png'); ?>" /></div>
        </div>
    </div>
</section>

<!-- ./ RESTAURANT TITLE HEADER -->

<?php

// Get saved settings
$heading = $this->order_model->getSetting('heading');
$description = $this->order_model->getSetting('description');
$ctaLink = $this->order_model->getSetting('ctaLink');

?>
<!-- Offer area -->
<section class="free-delivery-section order-detail-page mb-2 mt-3">
    <div class="container bg-red p-4 text-light rounded border-light">
        <div class="d-md-flex align-items-center">
            <div class="col-md-9">
                <h3><?php echo !is_null($heading) ? $heading : 'Offers Coming soon'; ?></h3>
                <p class="p-0 m-0">
                    <?php echo !is_null($description) ? $description : 'Be there, we will have an amazing offer.'; ?>
                </p>
            </div>
            <div class="col-md-3 text-center"><a <?php if (!empty($ctaLink)) {
                                                        echo 'href="' . $ctaLink . '"';
                                                    } ?> class="w-rounded-btn">More
                    Offers</a></div>
        </div>
    </div>
</section>
<!-- ./Offer area -->

<?php $restaurant_categories = $this->category_model->get_all(); ?>
<!-- Category tabs with scrool nav -->
<section class="order-detail-btns">
    <div class="container">
        <div class="order-detail-slider owl-carousel owl-theme my-5">
            <?php foreach ($restaurant_categories as $restaurant_category) { ?>
                <a href="#<?php echo strtolower(str_replace(' ', '-', $restaurant_category['name'])); ?>">
                    <?php echo $restaurant_category['name']; ?>
                </a>
            <?php } ?>
        </div>

    </div>
</section>
<!-- ./Category tabs with scrool nav -->

<!-- Menu section -->
<section class="order-detail-listing mt-4 mb-2">
    <div class="container p-md-4 text-dark p-0">
        <div class="d-md-flex align-items-start">
            <div class="col-md-8  mr-md-4">

                <?php

                foreach ($restaurant_categories as $k3y => $restaurant_category) {
                    $menus = $this->menu_model->get_menu_by_condition(['category_id' => sanitize($restaurant_category['id']), 'restaurant_id' => sanitize($restaurant_details['id'])]);


                    if (count($menus) > 0) {
                ?>
                        <h3 class="mt-2" id="<?php echo strtolower(str_replace(' ', '-', $restaurant_category['name'])); ?>">
                            <?php echo $restaurant_category['name']; ?>
                        </h3>

                        <div class="order-detail-box">
                            <div class="d-flex order-detail-box-title align-items-center justify-content-between">
                                <div class="item col-md-8 p-0 m-0">Item</div>
                                <div class="price col-md-2">Price</div>
                                <div class="order col-md-2">Order</div>
                            </div>
                            <?php
                            $counter = 1;
                            foreach ($menus as $key => $menu):

                                $starts_from = json_decode($menu["price"]);
                            ?>
                                <div data-toggle="modal" onclick="viewselected_menu(<?php echo $menu['id']; ?>,<?php $price = json_decode($menu['price']);
                                                                                                                echo $price->menu; ?>)">
                                    <div class="d-flex order-detail-box-txt align-items-center justify-content-between">
                                        <div class="col-md-8 d-flex align-items-center p-0 m-0">
                                            <div class="item-img-box mr-3"><a><img class="rounded-circle"
                                                        src="<?php echo base_url('uploads/menu/') . $menu['thumbnail']; ?>" height="80  px" width="80px" /></a></div>
                                            <div class="item-txt-box">
                                                <h3>
                                                    <span>
                                                        <?php echo ucfirst($menu['name']); ?>
                                                    </span>
                                                </h3>
                                                <?php echo $menu['details']; ?>
                                            </div>
                                        </div>
                                        <div class="price col-md-2">
                                            <?php echo currency($starts_from->menu); ?>
                                        </div>
                                        <div class="order col-md-2">
                                            <a href="#" data-toggle="modal"
                                                onclick="viewselected_menu(<?php echo $menu['id']; ?>,<?php $price = json_decode($menu['price']);
                                                                                                        echo $price->menu; ?>)">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56"
                                                    viewBox="0 0 56 56" fill="none">
                                                    <g clip-path="url(#clip0_4609_18554)">
                                                        <path
                                                            d="M28 49C39.598 49 49 39.598 49 28C49 16.402 39.598 7 28 7C16.402 7 7 16.402 7 28C7 39.598 16.402 49 28 49Z"
                                                            stroke="#F54748" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path d="M21 28H35" stroke="#F54748" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M28 21V35" stroke="#F54748" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </g>
                                                    <defs>
                                                        <clippath id="clip0_4609_18554">
                                                            <rect width="56" height="56" fill="white" />
                                                        </clippath>
                                                    </defs>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="popup" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <button style="    text-align: right;margin: 20px 20px 0 0;cursor: pointer;"
                                                type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                    aria-hidden="true">&times;</span></button>
                                            <div class="modal-body p-0" id="getdetails_selected_menu">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php $counter++;
                            endforeach; ?>


                            <!-- for last time there is class "last in between"  -->
                            <!-- <div class="d-flex order-detail-box-txt last align-items-center justify-content-between">
            <div class="col-md-8 d-flex align-items-center p-0 m-0">
              <div class="item-img-box mr-3"><a href="#"><img
                    src="<.?php echo base_url('assets/frontend/default/images/product-img3.png') ?>" /></a></div>
              <div class="item-txt-box">
                <h3><a href="#">1. Mexican Enchiladas</a></h3>
                Fuisset mentitum deleniti sit ea.
              </div>
            </div>
            <div class="price col-md-2">79.99 $</div>
            <div class="order col-md-2"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="56" height="56"
                  viewBox="0 0 56 56" fill="none">
                  <g clip-path="url(#clip0_4609_18554)">
                    <path
                      d="M28 49C39.598 49 49 39.598 49 28C49 16.402 39.598 7 28 7C16.402 7 7 16.402 7 28C7 39.598 16.402 49 28 49Z"
                      stroke="#F54748" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M21 28H35" stroke="#F54748" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" />
                    <path d="M28 21V35" stroke="#F54748" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" />
                  </g>
                  <defs>
                    <clippath id="clip0_4609_18554">
                      <rect width="56" height="56" fill="white" />
                    </clippath>
                  </defs>
                </svg></a></div>
          </div> -->

                        </div>

                <?php }
                } ?>


            </div>
            <div class="col-md-4 order-summery-box d-none d-md-block sticky" id="order-summary">
                <div class="sticky-offset">
                    <h3>Order Summary</h3>
                    <p class="green">You're all set</p>

                    <div id="item-list">

                    </div>

                    <div
                        class="c-basketSwitcher u-spacingBottom d-flex align-items-center justify-content-between my-4">
                        <label class="c-basketSwitcher-switch d-flex align-items-center justify-content-between">
                            <input type="radio" name="basket-switcher" value="delivery" checked="checked"
                                class="is-visuallyHidden"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none">
                                <g clip-path="url(#clip0_4609_18686)">
                                    <path
                                        d="M5 21C6.65685 21 8 19.6569 8 18C8 16.3431 6.65685 15 5 15C3.34315 15 2 16.3431 2 18C2 19.6569 3.34315 21 5 21Z"
                                        stroke="black" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M19 21C20.6569 21 22 19.6569 22 18C22 16.3431 20.6569 15 19 15C17.3431 15 16 16.3431 16 18C16 19.6569 17.3431 21 19 21Z"
                                        stroke="black" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M12 19V15L9 12L14 8L16 11H19" stroke="black" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M17 6C17.5523 6 18 5.55228 18 5C18 4.44772 17.5523 4 17 4C16.4477 4 16 4.44772 16 5C16 5.55228 16.4477 6 17 6Z"
                                        stroke="black" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </g>
                                <defs>
                                    <clippath id="clip0_4609_18686">
                                        <rect width="24" height="24" fill="white" />
                                    </clippath>
                                </defs>
                            </svg>
                            <div class="c-basketSwitcher-eta-wrapper"><span>
                                    Delivery<br />
                                </span> <span class="c-basketSwitcher-eta">
                                    from 7:35
                                </span></div>
                        </label> <label
                            class="c-basketSwitcher-switch d-flex align-items-center justify-content-between"><input
                                type="radio" name="basket-switcher" value="collection" class="is-visuallyHidden">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24"
                                viewBox="0 0 25 24" fill="none">
                                <g clip-path="url(#clip0_4609_18694)">
                                    <path
                                        d="M18 20C19.3807 20 20.5 18.8807 20.5 17.5C20.5 16.1193 19.3807 15 18 15C16.6193 15 15.5 16.1193 15.5 17.5C15.5 18.8807 16.6193 20 18 20Z"
                                        stroke="#F2F2F2" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M6.5 8V19C6.50019 19.2107 6.56691 19.4159 6.69063 19.5864C6.81436 19.7569 6.98877 19.884 7.18899 19.9495C7.3892 20.015 7.605 20.0156 7.80558 19.9513C8.00617 19.8869 8.1813 19.7608 8.306 19.591L12 14.5V14.555"
                                        stroke="#F2F2F2" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M6.5 8H21.5L18 15L10.9 14.253C10.1757 14.1769 9.48595 13.9045 8.90511 13.4651C8.32427 13.0258 7.87439 12.4362 7.604 11.76L4.751 4.63C4.67702 4.44425 4.54906 4.28494 4.38364 4.17264C4.21822 4.06034 4.02294 4.00021 3.823 4H2.5"
                                        stroke="#F2F2F2" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </g>
                                <defs>
                                    <clippath id="clip0_4609_18694">
                                        <rect width="24" height="24" fill="white"
                                            transform="translate(0.5)" />
                                    </clippath>
                                </defs>
                            </svg>
                            <div class="c-basketSwitcher-eta-wrapper"><span>
                                    Collection<br />
                                    15 Minutes
                                </span></div>
                        </label>
                    </div>

                    <div class="total-price-box d-flex justify-content-between align-items-center">
                        <div class="subtotal">Subtotal</div>
                        <div id="no-menu" class="subtotal-price"></div>
                    </div>

                    <div class="total-price-box d-flex justify-content-between align-items-center">
                        <div class="subtotal">Delivery Charges</div>
                        <div class="total-delivery-price"></div>
                    </div>

                    <div class="total-price-box d-flex justify-content-between align-items-center">
                        <div class="subtotal">VAT Charges</div>
                        <div class="total-vat-price"></div>
                    </div>

                    <div class="total-price-box d-flex justify-content-between align-items-center">
                        <div class="subtotal">Service Charges</div>
                        <div class="total-service-price"></div>
                    </div>

                    <?php
                    $cart_items = $this->cart_model->get_cart_by_condition(['customer_id' => $this->session->userdata('user_id'), 'restaurant_id' => sanitize($restaurant_details['id'])]);
                    ?>

                    <hr />
                    <?php if (sizeof($cart_items) > 0) { ?>
                        <div class="row justify-content-md-end">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="promo_code">Promo Code</label>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <input type="text" class="form-control" id="promo_code" name="promo_code"
                                            value="<?php echo $cart_items[0]['offer_code']; ?>" required>
                                        <?php if (isset($cart_items[0]['offer_code'])) { ?>
                                            <div class="btn btn-sm btn-danger m-2" onclick="remove_promo()">
                                                <i class="fa fa-times"></i>
                                            </div>
                                        <?php } ?>
                                        <div class="btn btn-sm btn-danger m-2" id="remove_promo" style="display:none"
                                            onclick="remove_promo()">
                                            <i class="fa fa-times"></i>
                                        </div>
                                    </div>
                                    <small id="promo_code_message"></small> <!-- Container for messages -->
                                    <?php if (isset($cart_items[0]['offer_code'])) { ?>
                                        <small class="text-success">Promo is already applied.</small>
                                        <!-- Container for messages -->
                                    <?php } else { ?>
                                        <div class="btn btn-sm btn-warning w-100 mt-2 text-dark" id="apply_promo"
                                            onclick="apply_promo_action()">APPLY COUPON CODE
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- <div class="offer-spend my-3">Offer Spend £28.05 more to get 10% off</div> -->

                    <div class="day-time-box my-4 p-2">

                        <div class="d-flex align-items-center justify-content-between mb-2">
                            Day <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none">
                                <g clip-path="url(#clip0_4609_18708)">
                                    <path
                                        d="M11.795 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V7C3 6.46957 3.21071 5.96086 3.58579 5.58579C3.96086 5.21071 4.46957 5 5 5H17C17.5304 5 18.0391 5.21071 18.4142 5.58579C18.7893 5.96086 19 6.46957 19 7V11"
                                        stroke="#F54748" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M18 22C20.2091 22 22 20.2091 22 18C22 15.7909 20.2091 14 18 14C15.7909 14 14 15.7909 14 18C14 20.2091 15.7909 22 18 22Z"
                                        stroke="#F54748" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M15 3V7" stroke="#F54748" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M7 3V7" stroke="#F54748" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M3 11H19" stroke="#F54748" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M18 16.4961V18.0001L19 19.0001" stroke="#F54748" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                                <defs>
                                    <clippath id="clip0_4609_18708">
                                        <rect width="24" height="24" fill="white" />
                                    </clippath>
                                </defs>
                            </svg>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            Time <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none">
                                <g clip-path="url(#clip0_4609_18717)">
                                    <path
                                        d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z"
                                        stroke="#F54748" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M12 12L15 10" stroke="#F54748" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M12 7V12" stroke="#F54748" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </g>
                                <defs>
                                    <clippath id="clip0_4609_18717">
                                        <rect width="24" height="24" fill="white" />
                                    </clippath>
                                </defs>
                            </svg>
                        </div>

                    </div>

                    <div class="total-price-box d-flex justify-content-between align-items-center">
                        <div class="subtotal">Total</div>

                        <div class="grand-product-price"></div>
                    </div>

                    <?php $restaurant_ids = $this->cart_model->get_restaurant_ids();

                    ?>
                    <?php $customer_details = $this->customer_model->get_by_id($this->session->userdata('user_id')); ?>

                    <div class="row mt-2 d-flex flex-column">


                        <?php if (empty($customer_details) || empty($customer_details['name'])) : ?>
                            <a href="<?php echo site_url('auth'); ?>" class="d-block order-red-btn text-center mt-4">
                                <?php echo site_phrase('login_first', true); ?>
                            </a>
                            
                            <a href="<?php echo site_url('auth/registration/customer'); ?>"  class="d-block order-red-btn text-center mt-4">
                                Sign in
                            </a>
                            <a href="<?php echo site_url('GuestCheckout'); ?>" id="guestCheckoutBtn" class="d-block order-red-btn text-center mt-4 disabled">
                                Guest Checkout
                            </a>
                          
                          
                        <?php else : ?>
                            <a href="<?php echo site_url('checkout'); ?>" class="d-block order-red-btn text-center mt-4 w-100 border-0 disabled" id="CheckoutBtn" style="cursor: pointer;" role="button">
                                <?php echo site_phrase('checkout', true); ?>
                            </a>
                        <?php endif; ?>

                    </div>

                </div>


                <!-- <a href="<?php echo base_url('cart'); ?>" class="d-block order-red-btn text-center mt-4">Order
                        Now!</a> -->
            </div>
        </div>
    </div>
</section>
<!-- ./Menu section -->


<!-- Mobile app section -->
<section class="dt-hide"><img class="img-fluid" src="<?php echo base_url('assets/frontend/default/images/footer-mob-img.png'); ?>" />
</section>
<section class="footer-top mt-4">
    <div class="container-fluid">
        <div class="d-md-flex ">
            <div class="col-md-6">
                <h3>It's Now <span class="red">More Easy</span> to <span class="yellow">Order</span> by Our Mobile
                    <span class="red">App</span>
                </h3>
                <p>All you need to do is downlode one of the best delivery apps,
                    make a and most companies are opting for mobile app devlopment
                    for food delivery</p>
                <div class="google-btns"><a href="#" class="goole-play-btn"><img
                            src="<?php echo base_url('assets/frontend/default/images/google-play-icon.png'); ?>" /></a>
                    <a href="#"><img src="<?php echo base_url('assets/frontend/default/images/app-store-icon.png'); ?>" /></a>
                </div>
            </div>
            <div class="col-md-6 mob-hide"><img class="img-fluid" src="<?php echo base_url('assets/frontend/default/images/footer-top-img.png'); ?>" /></div>
        </div>
    </div>



</section>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll(".owl-item.cloned").forEach(function(element) {
            let anchor = element.querySelector("a");
            // if(anchor == "")
            if (anchor) {
                let href = anchor.getAttribute("href");

                if (href) {
                    let elem_id = href.replace("#", '');
                    let data = document.getElementById(elem_id);

                    if (!data) {
                        element.style.display = "none";
                        // console.log();
                        let multiple = document.querySelectorAll(".owl-item a[href='#" + elem_id + "']");
                        multiple.forEach(function(element) {
                            let owlItem = element.closest(".owl-item");
                            if (owlItem) {
                                owlItem.style.display = 'none';
                            }
                        });

                    }
                }
            }
        });
    });
</script>
<!-- ./Mobile app section -->