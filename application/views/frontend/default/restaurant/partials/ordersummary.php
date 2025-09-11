

<style>
 .basket-error-border {
    border: 3px solid red;
    border-radius: 28px;
    box-sizing: border-box;
}

.cursor{
    cursor: pointer;
}



</style>
<div class="col-12 order-summery-box" id="order-summary">
                <div class="sticky-offset">
                    <h3>Order Summary</h3>
                    <p class="green">You're all set</p>

                    <div class="item-list">

                    </div>
                    <div class="d-flex justify-content-center">
                        
                    <div
                        class="c-basketSwitcher u-spacingBottom d-flex align-items-center justify-content-between mt-4 my-display-none">
                        <label class="c-basketSwitcher-switch d-flex align-items-center justify-content-between">
                            <input type="radio" name="basket-switcher" value="delivery"
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
                                </span>
                                <!-- <span class="c-basketSwitcher-eta">
                                    from 7:35
                                </span> -->
                            </div>
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
                                    <!-- 15 Minutes -->
                                </span>
                            </div>

                        </label>


                    </div>

                    
                </div>
                
                        <div class="basket-switcher-error text-danger" style="
                             display: none;
                              margin-top: 7px;
                                justify-content: center;"></div>


                    <div class="total-price-box d-flex justify-content-between align-items-center mt-4">
                        <div class="subtotal" id="">Subtotal</div>

                        <div id="ttprice" class="subtotal-price"></div>
                    </div>
                    <hr>



                    <div class="total-price-box d-flex justify-content-between align-items-center delivery-charge">
                        <div class="subtotal">Delivery Charges <sub id="cal"></sub></div>
                        <div class="total-delivery-price">-</div>
                    </div>

                    <!-- <div class="total-price-box d-none justify-content-between align-items-center">
                        <div class="subtotal">VAT Charges</div>
                        <div class="total-vat-price"></div>
                    </div> -->

                    <div class="total-price-box d-flex justify-content-between align-items-center">
                        <div class="subtotal">Service Charges</div>
                        <div class="total-service-price">-</div>
                    </div>

                    <div class="total-price-box d-flex justify-content-between align-items-center">
                        <div class="subtotal">Bag Charges</div>
                        <div class="bag-charges">-</div>
                    </div>

                    <div class="total-price-box d-flex justify-content-between align-items-center">
                        <div class="subtotal discount-label">Discount (20%)</div>
                        <div class="total-discount-applied">-</div>
                    </div>
                    

                    <?php
                    $cart_items = $this->cart_model->get_cart_by_condition(['customer_id' => $this->session->userdata('user_id'), 'restaurant_id' => sanitize($restaurant_details['id'])]);
                    ?>

                    <hr />
                    <?php if (sizeof($cart_items) > 0 && false) { ?>
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

                    

                    <div class="total-price-box d-flex justify-content-between align-items-center">
                        <div class="subtotal">Total</div>

                        <div class="grand-product-price"></div>
                    </div>

                    <style>
                        #terms{
                            accent-color: #f54748;
                            transform: scale(1.5);
                            margin-right: 5px;
                        }
                        .terms-link{
                            color: #f54748;
                            
                        }
                        .terms-link:hover{
                            color: #f54748 !important;
                        }
                        #tctext{
                            font-size: 1px;
                        }
                        </style>

                    <div class="row mt-3">
                            <div class="col-md-12 mx-2">
                                <p id="tctext">
                                <input type="checkbox" class="alt-terms" id="terms"> By checking this box, I confirm my <span class="mx-4">acceptance of the <a href="<?php echo site_url('terms-and-conditions'); ?>" class="terms-link">Terms & <span class="mx-4">Conditions</span></a></span></p>
                            </div>
                        </div>

                    <?php $restaurant_ids = $this->cart_model->get_restaurant_ids();

                    ?>

                    <?php $customer_details = $this->customer_model->get_by_id($this->session->userdata('user_id')); ?>

                    <style>
                        .btn-proceed{
                            width:50%;
                            padding:0px 5px;
                        }
                        .btn-proceed a {
                            width: 100%;
                            padding: 20px 0px;
                            font-size: 15px;
                        }
                    </style>
                   
                        
                    <?php if ($customer_details['is_guest'] == 0 && $customer_details['name']) : ?>

                        <div class="btn-proceed" style="width:100%">
                            <a onclick="red(this)" data-href="<?php echo site_url('checkout'); ?>" class="d-block order-red-btn-main text-center mt-4 w-100 border-0 disabled CheckoutBtn" style="cursor: pointer;" role="button">
                                    <?php echo site_phrase('checkout', true); ?>
                                </a>
                            
                        </div>
                            
                        <?php else : ?>
                            <div class="row mt-2 d-flex flex-row gap-2">
                                <div class="btn-proceed">
                                <a href="<?php echo site_url('auth'); ?>" class="d-block order-red-btn-main text-center mt-4 border-0">
                                    Login
                                </a>
                            </div>
                            <!-- <div class="btn-proceed">
                                <a href="<?php echo site_url('auth/registration/customer'); ?>" class="d-block order-red-btn-main text-center mt-4">
                                    Sign Up
                                </a>
                            </div> -->
                            <div class="btn-proceed">


                            <a onclick="red(this)"
   data-href="<?php echo site_url('GuestCheckout?guest=1'); ?>" 
   class="guestCheckoutBtn d-block order-red-btn-main text-center mt-4 color-white cursor">
   Guest Checkout
</a>
                            </div>
                            <!-- <div class="btn-proceed">
                                <a href="<?php echo site_url('auth/google_login'); ?>" class="d-block order-red-btn-main text-center mt-4">
        Login with Google
    </a>
                            </div> -->
                            
                        </div>
                        <?php endif; ?>



                </div>
                    

                <!-- <a href="<?php echo base_url('cart'); ?>" class="d-block order-red-btn text-center mt-4">Order
                        Now!</a> -->
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    // Check if the device is mobile (screen width <= 768px is commonly used for mobile)
                    if (window.innerWidth <= 768) {
                        const input = document.querySelector("input[value='delivery']");
                        if (input) {
                            input.click();
                        }
                    }
                });
            </script>

<script>
 function red(param) {
    
    //  debugger;
    const isActive = document.querySelector(".c-basketSwitcher-switch.c-basketSwitcher-switch--active") !== null;
    const switcherBox = document.querySelector(".c-basketSwitcher");
    if (!isActive) {
        // Add red border to switcher box
        document.querySelectorAll(".c-basketSwitcher-switch").forEach(function(switcherBox) {
    switcherBox.classList.add("basket-error-border");
});

        // Show error message
        document.querySelectorAll(".basket-switcher-error").forEach(el => {
            el.textContent = "Please Select Order Type.";
            el.style.display = "flex";
        });
        return;
    }

    // Remove error border and hide error message
    switcherBox.classList.remove("basket-error-border");
    document.querySelectorAll(".basket-switcher-error").forEach(el => {
        el.style.display = "none";
        el.textContent = "";
    });

    // Redirect
    const href = param.getAttribute("data-href");
    window.location.href = href;
}

</script>