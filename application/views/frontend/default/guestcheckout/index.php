<!-- NAVIGATION BAR -->
<?php
function is_mobile_device() {
    return preg_match('/(android|iphone|ipad|ipod|blackberry|mini|windows\sce|palm)/i', $_SERVER['HTTP_USER_AGENT']);
}
?>
<?php 
$cartView = true;

include APPPATH . 'views/frontend/default/navigation/dark.php';


$cash_on_delivery_settings = get_payment_settings("cash_on_delivery");
$cash_on_delivery_settings = json_decode($cash_on_delivery_settings);

$paypal_settings = get_payment_settings("paypal");
$paypal_settings = json_decode($paypal_settings);

$stripe_settings = get_payment_settings("stripe");
$stripe_settings = json_decode($stripe_settings);

?>

<!-- MAIN CONTENT -->

<style>
    /* ul.billing-list-topbar li:after{
        background: #F54849;
    } */
     .highlighted::after {
        background: #F54849 !important;
    }
    .pac-container{
        z-index: 99999999999;
    }
   -list .d-flex.p-1,#item-list .product-price img{
        visibility: collapse;
    }
    .disabled {
        pointer-events: none;
        /* Prevent clicks */
        opacity: 0.5;
        /* Make it look disabled */
        cursor: not-allowed;
        /* Change cursor to indicate it's not clickable */

    }
    input.invalid {
        border-color: red !important;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(255, 0, 0, 0.25) !important;
    }
    @media (max-width: 768px) {
        .detail-wbox {
            /* margin-top: 20 !important; */
            margin-bottom: 0 !important;
            padding: 0 !important;
        }

        .payment-text {
            padding-top: 10px;
        font-size: 18px;

        }

        .delivery-text {
            font-size: large;
        }
        .navbar{
            display: block !important;
        }

    }

    #d-cal{
    bottom: -0.1em!important;
  font-size: 0.5em;
  left: 20px;
}
    .d-flex.p-1 {
        /* display: none !important; */
        visibility: hidden!important;
    }   
    /* .order-delivery-types{
    display:none;
} */

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


</style>
<section class="detail-wbox mt-4 mb-2 p-md-5 d-flex justify-content-around">
    <div class="container bg-white text-dark border border-light p-3 w-lg-75 p-md-5">
        <ul id="step-indicator" class="d-flex justify-content-between align-item-center billing-list-topbar p-0">
            
           <script>
                const orderTypeV = localStorage.getItem('order-type');

                // Create the HTML templates
                const deliverySteps = `
                    <li class="payment">
                        <div class="img-box text-center red">Address Info 
                            <img class="billing-active" src="<?= base_url('assets/frontend/default/images/billing-list-icon-acitve.png') ?>" />
                            <img class="billing-notactive" src="<?= base_url('assets/frontend/default/images/billing-list-icon.png') ?>" />
                        </div>
                    </li>
                    <li class="billing acitve">
                        <div class="img-box text-center red">Customer 
                            <img class="billing-active" src="<?= base_url('assets/frontend/default/images/billing-list-icon-acitve.png') ?>" />
                            <img class="billing-notactive" src="<?= base_url('assets/frontend/default/images/billing-list-icon.png') ?>" />
                        </div>
                    </li>
                    <li class="order last">
                        <div class="img-box text-center">Payment
                            <img class="billing-active" src="<?= base_url('assets/frontend/default/images/billing-list-icon-acitve.png') ?>" />
                            <img class="billing-notactive" src="<?= base_url('assets/frontend/default/images/billing-list-icon.png') ?>" />
                        </div>
                    </li>
                `;

                const pickupSteps = `
                    <li class="billing acitve">
                        <div class="img-box text-center red">Customer 
                            <img class="billing-active" src="<?= base_url('assets/frontend/default/images/billing-list-icon-acitve.png') ?>" />
                            <img class="billing-notactive" src="<?= base_url('assets/frontend/default/images/billing-list-icon.png') ?>" />
                        </div>
                    </li>
                    <li class="payment">
                        <div class="img-box text-center">Address Info 
                            <img class="billing-active" src="<?= base_url('assets/frontend/default/images/billing-list-icon-acitve.png') ?>" />
                            <img class="billing-notactive" src="<?= base_url('assets/frontend/default/images/billing-list-icon.png') ?>" />
                        </div>
                    </li>
                    <li class="order last">
                        <div class="img-box text-center">Payment
                            <img class="billing-active" src="<?= base_url('assets/frontend/default/images/billing-list-icon-acitve.png') ?>" />
                            <img class="billing-notactive" src="<?= base_url('assets/frontend/default/images/billing-list-icon.png') ?>" />
                        </div>
                    </li>
                `;

                // Target the container where you want to insert the steps
                const stepIndicator = document.getElementById('step-indicator');

                if (stepIndicator) {
                    stepIndicator.innerHTML = (orderTypeV === 'delivery') ? deliverySteps : pickupSteps;
                }
            </script>
        </ul>
        <div id="billing-address">
            <h4 class="mt-5 text-dark">Customer Details</h4>

            <form id="billing-form" onsubmit="submitForm(); return false;" method="POST" autocomplete="off">
                <div class="form-row mt-4">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">First Name *</label>
                        <input type="text" class="form-control" id="txtfname" name="first_name" required
                            placeholder="Enter first name..." value="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Last Name *</label>
                        <input type="text" id="txtlname" class="form-control" name="last_name" required
                            placeholder="Enter last name..." value="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Mobile *</label>
                        <input type="tel" class="form-control" name="phone_mobile" id="mobile" required
                            placeholder="Enter mobile..." pattern="^(\+447\d{9}|07\d{9})$" value=""
                            title="Please enter a valid mobile number starting with +447 or 07 followed by 9 digits">
                        <small>Format: +44 7123 456 789 or 07123 456 789</small><br>
                    </div>


                    <div class="form-group col-md-6">
                        <label for="inputAddress">Email *</label>
                        <input type="email" class="form-control" name="email" id="email" required
                            value="" placeholder="Enter email...">
                    </div>
                </div>

                <div class="form-row">


                    <div class="form-group col-md-6 d-none" id="collection-time">
                        <label for="inputPassword4">Collection Time (Optional)</label>
                        <input type="text" class="form-control" name="collection_time" placeholder="Wednesday 12:30">
                    </div>

                </div>

                <!-- <div class="form-group">
                    <label>Note for Delivery: </label>
                    <textarea class="form-control" name="note" placeholder="Details" rows="5"></textarea>
                </div> -->
                <button type="submit" class="rr-btn border-0 mt-4">Go to next step: Address Details</button>
            </form>
        </div>


        <div id="payment-option">
            <div class="row flex-column-reverse flex-md-row">
                <div class="col-md-6">
                <div class="d-flex">
                    <h4 class="delivery-text mt-3"><span class="order_type">Delivery</span> Address</h4>
                    <div class="mt-3 fw-bold mx-5 " style="color: #F54748; font-weight: bold; cursor: pointer;" onclick="openAddressEditModal()">Edit</div>
                </div>
                <span id="show-address"></span><br>
                    <button id="next-step-btn" onclick="goToPaymentTable()" class="rr-btn border-0 mt-4" disabled>Go to next step: Place Order</button>
                </div>

                <div class="col-md-6">
                    <div class="d-flex">
                        <h4 class="mt-3">Additional Delivery Instructions</h4>
                        <div class="mt-3 fw-bold mx-5 " style="color: #F54748; font-weight: bold; cursor: pointer;" onclick="openAddressEditModal()">Edit</div>
                    </div>
                    <span id="instructions_hidden"></span>
                </div>
            </div>
        </div>


        <div id="your-address">
            <!-- <h4 class="mt-5 text-dark"><?php //echo site_phrase('choose_way_of_payment', true); 
                                            ?></h4> -->

            <!-- <pre><php print_r($this->session->all_userdata()); ?></pre> -->
            <?php if (
                $this->session->userdata('customer_login') ||
                $this->session->userdata('owner_login') ||
                $this->session->userdata('user_id') ||
                $this->session->userdata('guest_checkout')
            ) :  ?>


                <!-- <pre><php print_r($this->session->all_userdata()); ?></pre> -->



                <?php $customer_details = $this->customer_model->get_by_id($this->session->userdata('user_id')); ?>
                <?php
                $restaurant_ids = $this->cart_model->get_restaurant_ids();
                if (count($restaurant_ids) > 0) : ?>
                    <div class="row justify-content-center">
                        <div class="col-md-12 responsive-wrap">
                            <div class="booking-checkbox_wrap">
                                <div class="row">

                                    <div class="col-md-6 payment-gateways" id="p-gateways">
                                        <!-- <h4 class="delivery-text"><span class="order_type">Delivery</span> Address</h4>
                                        <span id="show-address"></span> -->
                                    </div>
                                    <div class="col-12 col-md-6" id="p-method">
                                        <h4 class="payment-text">Choose Payment Method To Proceed</h4>


                                        <!-- ORDER DELIVERY TYPE -->

                                        <!-- <tr>
                                    <td>
                                        <div class="order-delivery-types">
                                            <input id="delivery" type="radio" name="order_type" value="delivery"
                                                onchange="$('#order-type').text('<?php //echo site_phrase('delivery'); 
                                                                                    ?>'); $('.order_type').val('delivery'); loadFetchedUrl(); $('.delivery-order').removeClass('d-none'); $('.pickup-order').addClass('d-none');"
                                                <?php //if ($order_type == "delivery") echo "checked"; 
                                                ?> />
                                            <label class="order-delivery-type-label order-type-delivery" for="delivery">
                                                <div class="order-type-overlay">
                                                    <p>
                                                        <?php //echo site_phrase('delivery'); 
                                                        ?>
                                                    </p>
                                                </div>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <?php

                                        // $pickup_order_status = 0; if (count($restaurant_ids) == 1 && pickup_order_availability($restaurant_ids[0])) { $pickup_order_status = 1; }
                                        ?>
                                        <div class="order-delivery-types">
                                            <input id="pickup" type="radio" name="order_type" value="pickup"
                                                onchange="$('#order-type').text('<?php //echo site_phrase('pickup'); 
                                                                                    ?>'); $('.order_type').val('pickup'); loadFetchedUrl(); $('.delivery-order').addClass('d-none'); $('.pickup-order').removeClass('d-none');"
                                                <?php //if ($order_type == "pickup") echo "checked"; 
                                                ?>
                                                <?php //if (!$pickup_order_status) echo 'disabled'; 
                                                ?> />
                                            <label class="order-delivery-type-label order-type-pickup" for="pickup">
                                                <div class="order-type-overlay">
                                                    <p>
                                                        <?php //echo site_phrase('Pickup'); 
                                                        ?>
                                                    </p>
                                                </div>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr> -->


                                        <!-- CASH ON DELIVERY FORM -->
                                        <?php if ($cash_on_delivery_settings[0]->active) {
                                            include "cash_on_delivery/cash_on_delivery_form.php";
                                        } ?>

                                        <!-- STRIPE FORM -->
                                        <?php if ($stripe_settings[0]->active) {
                                            include "stripe/stripe_form.php";
                                        } ?>

                                        <!-- PAYPAL FORM -->
                                        <?php if ($paypal_settings[0]->active) {
                                            // include "paypal/paypal_form.php";
                                        } ?>
                                        <!-- <div class="featured-btn-wrap text-right col-12 p-0">
                                            <button
                                                onclick="redirect()"
                                                class="btn btn-dark btn-sm pl-5 pr-5 pt-3 pb-3 w-100 rr-btn border-0 mt-2"><?php echo site_phrase('proceed', true); ?></button>
                                        </div> -->

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    <?php else : ?>
        <div class="row justify-content-md-center">
            <div class="col-md-12 responsive-wrap">
                <div class="booking-checkbox_wrap mb-2">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <img src="<?php echo base_url('assets/frontend/default/images/empty-cart.png'); ?>"
                                class="img-fluid" alt="<?php echo "empty-cart-logo"; ?>">
                            <span class="d-block mt-2"><?php echo site_phrase('you_got_nothing_to_order'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php else : ?>
    <div class="text-center">
        <h5><?php echo site_phrase('user_is_not_logged_in'); ?></h5>
    </div>
<?php endif; ?>
<!-- </form> -->
    </div>
    </div>


<!-- for desktop -->
 <?php if (!is_mobile_device()) { ?>

    <div class="order-summery-box d-none d-md-block" id="order-summary">

        <div>
            <h3>Order Summary</h3>
            <p class="green">You're all set</p>

            <div id="item-list">


            </div>

            <div id="orderTypeMessage" class="d-flex text-center font-weight-bold mb-2"></div>

            <div class="c-basketSwitcher u-spacingBottom d-flex align-items-center justify-content-between my-4 my-display-none">
                <label class="c-basketSwitcher-switch d-flex align-items-center justify-content-between">
                    <input type="radio" name="basket-switcher" value="delivery" checked="checked"
                    <input type="radio" name="basket-switcher" value="delivery" 
                        class="is-visuallyHidden"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none">
                        <g clip-path="url(#clip0_4609_18686)">
                            <path
                                d="M5 21C6.65685 21 8 19.6569 8 18C8 16.3431 6.65685 15 5 15C3.34315 15 2 16.3431 2 18C2 19.6569 3.34315 21 5 21Z"
                                stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M19 21C20.6569 21 22 19.6569 22 18C22 16.3431 20.6569 15 19 15C17.3431 15 16 16.3431 16 18C16 19.6569 17.3431 21 19 21Z"
                                stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 19V15L9 12L14 8L16 11H19" stroke="black" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M17 6C17.5523 6 18 5.55228 18 5C18 4.44772 17.5523 4 17 4C16.4477 4 16 4.44772 16 5C16 5.55228 16.4477 6 17 6Z"
                                stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
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
                </label> <label class="c-basketSwitcher-switch d-flex align-items-center justify-content-between"><input
                        type="radio" name="basket-switcher" value="collection" class="is-visuallyHidden"> <svg
                        xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                        <g clip-path="url(#clip0_4609_18694)">
                            <path
                                d="M18 20C19.3807 20 20.5 18.8807 20.5 17.5C20.5 16.1193 19.3807 15 18 15C16.6193 15 15.5 16.1193 15.5 17.5C15.5 18.8807 16.6193 20 18 20Z"
                                stroke="#F2F2F2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M6.5 8V19C6.50019 19.2107 6.56691 19.4159 6.69063 19.5864C6.81436 19.7569 6.98877 19.884 7.18899 19.9495C7.3892 20.015 7.605 20.0156 7.80558 19.9513C8.00617 19.8869 8.1813 19.7608 8.306 19.591L12 14.5V14.555"
                                stroke="#F2F2F2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M6.5 8H21.5L18 15L10.9 14.253C10.1757 14.1769 9.48595 13.9045 8.90511 13.4651C8.32427 13.0258 7.87439 12.4362 7.604 11.76L4.751 4.63C4.67702 4.44425 4.54906 4.28494 4.38364 4.17264C4.21822 4.06034 4.02294 4.00021 3.823 4H2.5"
                                stroke="#F2F2F2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                        <defs>
                            <clippath id="clip0_4609_18694">
                                <rect width="24" height="24" fill="white" transform="translate(0.5)" />
                            </clippath>
                        </defs>
                    </svg>
                    <div class="c-basketSwitcher-eta-wrapper"><span>
                            Collection
                        </span></div>
                </label>
            </div>


<script>
    $(document).ready(function () {
    // Jab bhi delivery price calculate ho jaye
    if ($('.total-delivery-price').text().trim() !== '') {
        $('.subtotal').hide();
    }

    // Agar dynamically update ho raha hai
    setInterval(function () {
        if ($('.total-delivery-price').text().trim() !== '') {
            $('.subtotal').hide();
        } else {
            $('.subtotal').show();
        }
    }, 500); // Har 500ms mein check karega
});
</script>
<div class="total-price-box d-flex justify-content-between align-items-center">


                        <div class="" id="">Subtotal</div>

                        <div id="ttprice" class="subtotal-price"></div>
                    </div>
                    <hr>



                    <div class="total-price-box d-flex justify-content-between align-items-center" id="delivery-charge">
                        <div class="">Delivery Charges <sub id="cal"></sub></div>
                        <div class="total-delivery-price"></div>
                    </div>

                    <!-- <div class="total-price-box d-none justify-content-between align-items-center">
                        <div class="subtotal">VAT Charges</div>
                        <div class="total-vat-price"></div>
                    </div> -->

                    <div class="total-price-box d-flex justify-content-between align-items-center">
                        <div class="">Service Charges</div>
                        <div class="total-service-price">-</div>
                    </div>

                    <div class="total-price-box d-flex justify-content-between align-items-center">
                        <div class="">Bag Charges</div>
                        <div class="bag-charges">-</div>
                    </div>

                    <div class="total-price-box d-flex justify-content-between align-items-center">
                        <div class="discount-label">Discount (20%)</div>
                        <div class="total-discount-applied">-</div>
                    </div>

                    <div class="row mt-2 d-none online-disc">
                        <div class="col-md-12 d-flex total-price-box">
                        <input type="checkbox" name="online_discount" id="online_discount">
                        <span class="mx-2"> Online Discount</span>
                    </div>
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
                                <div class="grand-product-price d-none"></div> <!-- Total Amount in this like £8.6 -->
                                <input type="text" class="form-control" id="promo_code" name="promo_code" required>
                                <div class="btn btn-sm btn-danger m-2 d-none" id="remove_promo" onclick="remove_promo()">
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <small id="promo_code_message" class="d-block mt-1"></small>
                            <div class="btn btn-sm btn-warning w-100 mt-2 text-dark" id="apply_promo" onclick="apply_promo_action()">
                                APPLY COUPON CODE
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- <div class="offer-spend my-3">Offer Spend £28.05 more to get 10% off</div> -->

            <div class="total-price-box d-flex justify-content-between align-items-center">
                <div class="">Total</div>
                <div class="grand-product-price"></div>
            </div>

            <?php $restaurant_ids = $this->cart_model->get_restaurant_ids(); ?>
            <?php $customer_details = $this->customer_model->get_by_id($this->session->userdata('user_id')); ?>



            <!-- <a href="<?php echo base_url('cart'); ?>" class="d-block order-red-btn text-center mt-4">Order
                        Now!</a> -->
        </div>
    </div>

    <?php } ?>
</section>



<head>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

<!-- for mobile screen  -->
   <div class="container order-summery-box d-block d-md-none" id="mobileOrderSummary">
   
<div class="total-price-box d-flex justify-content-between align-items-center">


                        <div class="" id="">Subtotal</div>

                        <div id="ttprice" class="subtotal-price"></div>
                    </div>
                    <hr>



                    <div class="total-price-box d-flex justify-content-between align-items-center" id="delivery-charge">
                        <div class="">Delivery Charges <sub id="cal"></sub></div>
                        <div class="total-delivery-price"></div>
                    </div>

                    <!-- <div class="total-price-box d-none justify-content-between align-items-center">
                        <div class="subtotal">VAT Charges</div>
                        <div class="total-vat-price"></div>
                    </div> -->

                    <div class="total-price-box d-flex justify-content-between align-items-center">
                        <div class="">Service Charges</div>
                        <div class="total-service-price">-</div>
                    </div>

                    <div class="total-price-box d-flex justify-content-between align-items-center">
                        <div class="">Bag Charges</div>
                        <div class="bag-charges">-</div>
                    </div>

                    <div class="total-price-box d-flex justify-content-between align-items-center">
                        <div class="discount-label">Discount (20%)</div>
                        <div class="total-discount-applied">-</div>
                    </div>

                    <div class="row mt-2 d-none online-disc">
                        <div class="col-md-12 d-flex total-price-box">
                        <input type="checkbox" name="online_discount" id="online_discount">
                        <span class="mx-2"> Online Discount</span>
                    </div>
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
                                <div class="grand-product-price d-none"></div> <!-- Total Amount in this like £8.6 -->
                                <input type="text" class="form-control" id="promo_code" name="promo_code" required>
                                <div class="btn btn-sm btn-danger m-2 d-none" id="remove_promo" onclick="remove_promo()">
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <small id="promo_code_message" class="d-block mt-1"></small>
                            <div class="btn btn-sm btn-warning w-100 mt-2 text-dark" id="apply_promo" onclick="apply_promo_action()">
                                APPLY COUPON CODE
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- <div class="offer-spend my-3">Offer Spend £28.05 more to get 10% off</div> -->

            <div class="total-price-box d-flex justify-content-between align-items-center">
                <div class="">Total</div>
                <div class="grand-product-price"></div>
            </div>

            <?php $restaurant_ids = $this->cart_model->get_restaurant_ids(); ?>
            <?php $customer_details = $this->customer_model->get_by_id($this->session->userdata('user_id')); ?>



            <!-- <a href="<?php echo base_url('cart'); ?>" class="d-block order-red-btn text-center mt-4">Order
                        Now!</a> -->
        </div>
    </div>

            
<!-- //END MOBIKE SCREEN -->


<div class="modal fade" id="guestAddressModal" tabindex="-1" aria-labelledby="guestAddressModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-dark"><span class="order_type">Address</span> Finder</h4>
               <!-- <button type="button" class="close" onclick="history.back();" style="font-size: 1.5rem; cursor: pointer; color: #000; background: none; border: none;">
                        <span>&times;</span>
                        </button> -->
                  </div>
  

      <div class="modal-body">
        <div id="address-option">
          <form id="address-form" onsubmit="submitAddressForm(); return false;" autocomplete="off">
            <div class="form-row mt-4">
              <div class="form-group col-md-6">
                <label>Enter Your Address*</label>
                <input type="text" class="form-control" id="to" data-field="address" placeholder="Enter Your Address" autocomplete="new-password">
                <small class="text-danger d-none" id="not-deliever"> Address not in deliverable range </small>
                <input type="hidden" id="lat_to">
                <input type="hidden" id="long_to">
              </div>
              <div class="form-group col-md-6">
                <label>Postcode*</label>
                <input type="text" class="form-control" id="city" data-field="postcode" placeholder="Postcode" autocomplete="new-password">
              </div>
              <div class="form-group col-md-6">
                <label>House/Flat Number*</label>
                <input type="text" class="form-control" id="flat" data-field="flat" placeholder="House/Flat Number" autocomplete="new-password">
              </div>
              <div class="form-group col-md-6">
                <label>Street Name*</label>
                <input type="text" class="form-control" id="street-value" data-field="street" placeholder="Street Name" autocomplete="new-password">
              </div>
            </div>

            <div class="form-row add-note">
              <div class="form-group col-md-12">
                <label>Additional Delivery Instructions</label>
                <textarea class="form-control" id="instructions" data-field="instructions" placeholder="No" autocomplete="off"></textarea>
              </div>
            </div>

            <input type="hidden" id="inputNameMap" name="inputNameMap" value="">
            <button id="checking" type="submit" class="rr-btn border-0 mt-4 disabled">Confirm Address</button>
              <button type="submit" onclick="history.back();" class="rr-btn border-0 mt-4">Back To Menu</button>

          </form>
        </div>
      </div>
      
    </div> <!-- .modal-content -->
  </div>   <!-- .modal-dialog -->
</div>     <!-- #guestAddressModal -->



<style>

#cookieModal .btn-cb{
    background-color: #fdc55e;
    /* border: 5px solid rgb(255, 187, 61); */
    color: #191919 !important;
    padding: 8px 28px;
    font-weight: 500;
    border-radius: 2rem;
    font-size: 18px;
}

#cookieModal{
    align-content: center;
}

#cookieModal h5{
    font-weight: 700;
}

#cookieModal p{
    font-weight: 400;
    font-size: 14px;
}

@media (max-width: 768px) {
    #cookieModal .btn-cb{
          background-color: #fdc55e;
    /* border: 5px solid rgb(255, 187, 61); */
    color: #191919 !important;
    padding: 8px 28px;
    font-weight: 500;
    border-radius: 2rem;
        font-size: 12px;
    }

}

</style>

<!-- Cookie Consent Modal -->
<!-- <div class="modal fade" id="cookieModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <h5 class="mt-3">Accept the Cookies</h5>
        <p class="my-3 px-lg-5">
          We use cookies and similar technologies to improve your browsing experience, analyze site traffic, and personalize content. By clicking “Accept”, you agree to our use of cookies.
<br><br>
    By creating an account, making a purchase, or subscribing to our newsletter, you agree to our <a href="<?php echo site_url('terms-and-conditions'); ?>" target="_blank" style="color: #F54748;">Terms & Conditions</a> and <a target="_blank" href="<?php echo site_url('privacy-policy'); ?>" style="color: #F54748;">Privacy Policy</a>, and you consent to receive promotional emails from us about products, offers, and updates. You can unsubscribe at any time via the link in our emails or by contacting us directly.
            </p>
        <a href="" class="btn btn-cb mb-3" onclick="acceptCookies()">Accept & Continue</a>
      </div>
    </div>
  </div>
</div> -->

<!-- Black backdrop -->
<!-- <div id="termBackdrop"></div> -->

<div class="cookie-banner"  id="cookie-banner">
    <div class="container-fluid my-2">
        <div class="row">
            <div class="col-md-12">
                          <h2>We value your privacy</h2>    
                <h3>To give you the best experience, we use cookies to understand how our site is used, improve functionality, and provide personalized content and offers. By selecting “Accept”, you consent to our use of cookies as described in our Cookie Policy.</h3>
                                    <div class="actions">
                    <a href="" onclick="acceptCookies()" class="mx-2 btn btn-cb">Ignore</a>
                    <a href="" onclick="acceptCookies()" class="mx-2 btn btn-cb">Accept</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

// Accept handler
function acceptCookies() {
    setCookie("cookieConsent", "accepted", 30);
    document.getElementById("cookie-banner").style.display = "none";
    document.getElementById("termBackdrop").style.display = "none";

    // Enable the button when cookies are accepted
    document.getElementById("next-step-btn").disabled = false;
}

// Ignore handler
function ignoreCookies() {
    setCookie("cookieConsent", "ignored", 30);
    document.getElementById("cookie-banner").style.display = "none";
    document.getElementById("termBackdrop").style.display = "none";

    // Keep button disabled if ignored
    document.getElementById("next-step-btn").disabled = true;
}

// Set cookie
function setCookie(name, value, days) {
    const date = new Date();
    date.setTime(date.getTime() + (days*24*60*60*1000));
    const expires = "expires=" + date.toUTCString();
    document.cookie = name + "=" + encodeURIComponent(value) + ";" + expires + ";path=/";
}

// Get cookie
function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i].trim();
        if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length));
    }
    return null;
}

// On load
$(document).ready(function () {
    const cookieConsent = getCookie("cookieConsent");
    console.log("Cookie on load:", cookieConsent);

    // Always start disabled
    const btn = document.getElementById("next-step-btn");
    btn.disabled = true;

    // Enable only if cookieConsent is accepted
    if (cookieConsent === "accepted") {
        btn.disabled = false;
    }

    // Show banner if not accepted
    if (cookieConsent !== "accepted") {
        document.getElementById("cookie-banner").style.display = "block";
        document.getElementById("termBackdrop").style.display = "block";
    }

    // Show guest address modal if delivery and cookies accepted
    if (typeof orderTypeV !== 'undefined' && orderTypeV === 'delivery' && cookieConsent === "accepted") {
        $('#guestAddressModal').modal({
            backdrop: 'static',
            keyboard: false
        }).modal('show');
    }
});


const nameMap = {};

function generateRandomName(length = 8) {
  const chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
  let result = '';
  for (let i = 0; i < length; i++) {
    result += chars[Math.floor(Math.random() * chars.length)];
  }
  return result;
}

function assignRandomNamesToInputs() {
  document.querySelectorAll('[data-field]').forEach(input => {
    const fieldKey = input.getAttribute('data-field');
    const randomName = generateRandomName();
    input.setAttribute('name', randomName);
    nameMap[fieldKey] = randomName;
    });
    document.getElementById('inputNameMap').value = JSON.stringify(nameMap);
}

function submitAddressForm() {
  var addressFormData = $('#address-form').serialize();

  $.ajax({
    type: 'POST',
    url: '<?= base_url('GuestCheckout/save_address_data') ?>',
    data: addressFormData,
    success: function (response) {
      console.log('Address Data Saved!');
    //   window.location.href = "<?= site_url('GuestCheckout?guest=1'); ?>";
    $('#guestAddressModal').modal('hide');
        viewselected_cat_items_summary_total();
    },
    error: function (xhr, status, error) {
      console.error('Error:', error);
    }
  });
}


console.log("From JS", sessionAddressData);

function openAddressEditModal() {

    // document.querySelector('#address-form .add-note').classList.remove('d-none');

    assignRandomNamesToInputs();
    $('#guestAddressModal').modal('show');
}

function goToPaymentTable(){

    // const instructionField = document.getElementById("instructions_hidden");

    // sessionAddressData.instructions = instructionField.value;

    // document.getElementById("address_hidden").value = sessionAddressData.address;
    // document.getElementById("flat_hidden").value = sessionAddressData.flat;
    // document.getElementById("street_hidden").value = sessionAddressData.street;
    // document.getElementById("postcode_hidden").value = sessionAddressData.postcode;
    // document.getElementById("instructions_hidden").value = sessionAddressData.instructions;
    // document.getElementById("lat_hidden").value = sessionAddressData.lat;
    // document.getElementById("long_hidden").value = sessionAddressData.long;

    // Step 2: Prepare nameMap for reference
    // let nameMap = {
    //     address: 'address_hidden',
    //     flat: 'flat_hidden',
    //     street: 'street_hidden',
    //     postcode: 'postcode_hidden',
    //     instructions: 'instructions_hidden',
    //     lat: 'lat_hidden',
    //     long: 'long_hidden'
    // };

    // document.getElementById("inputNameMap_hidden").value = JSON.stringify(nameMap);

    // // Step 3: Collect data from hidden fields using nameMap
    // const addressFormData = {
    //     [nameMap.address]: document.getElementById(nameMap.address).value,
    //     [nameMap.flat]: document.getElementById(nameMap.flat).value,
    //     [nameMap.street]: document.getElementById(nameMap.street).value,
    //     [nameMap.postcode]: document.getElementById(nameMap.postcode).value,
    //     [nameMap.instructions]: document.getElementById(nameMap.instructions).value,
    //     [nameMap.lat]: document.getElementById(nameMap.lat).value,
    //     [nameMap.long]: document.getElementById(nameMap.long).value,
    //     inputNameMap: JSON.stringify(nameMap)
    // };

    jQuery('ul.billing-list-topbar li.billing').addClass('acitve')

    jQuery("ul.billing-list-topbar li.order .img-box").removeClass("red");
    jQuery("ul.billing-list-topbar li.billing .img-box").addClass("red");
    jQuery("ul.billing-list-topbar li.payment .img-box").removeClass("red");

    // jQuery("ul.billing-list-topbar li.billing").add("acitve");
    jQuery("ul.billing-list-topbar li.payment").removeClass("acitve");
    jQuery('#billing-address').removeClass('d-none');
    jQuery('#billing-address').addClass('d-block');
    jQuery('#payment-option').removeClass('d-block');
    jQuery('#payment-option').addClass('d-none');

    // Step 4: AJAX Call
    // $.ajax({
    //     type: 'POST',
    //     url: '<?= base_url('GuestCheckout/save_address_data') ?>',
    //     data: addressFormData,
    //     success: function(response) {
    //         console.log(response);
    //         try {
    //             var res = JSON.parse(response);
    //             if (res.success) {
    //                 // Move to next step
    //                 // jQuery("ul.billing-list-topbar li.order").addClass("acitve");
    //                 jQuery('ul.billing-list-topbar li.billing').addClass('acitve')

    //                 jQuery("ul.billing-list-topbar li.order .img-box").removeClass("red");
    //                 jQuery("ul.billing-list-topbar li.billing .img-box").addClass("red");
    //                 jQuery("ul.billing-list-topbar li.payment .img-box").removeClass("red");

    //                 // jQuery("ul.billing-list-topbar li.billing").add("acitve");
    //                 jQuery("ul.billing-list-topbar li.payment").removeClass("acitve");
    //                 jQuery('#billing-address').removeClass('d-none');
    //                 jQuery('#billing-address').addClass('d-block');
    //                 jQuery('#payment-option').removeClass('d-block');
    //                 jQuery('#payment-option').addClass('d-none');
    //                 // jQuery("#billing-address,#payment-option").hide();
    //             } else {
    //                 alert('Failed to save instructions');
    //             }
    //         } catch (e) {
    //             console.error("Invalid JSON response", e);
    //         }
    //     },
    //     error: function(err) {
    //         console.error("AJAX error", err);
    //     }
    // });
}

// assignRandomNamesToInputs();

</script>




<script>
document.addEventListener('DOMContentLoaded', function () {
    const currentOrigin = window.location.origin;

    if (currentOrigin === "https://www.fooyes.co.uk" || currentOrigin === "https://www.chilli-hut-march.co.uk") {
        const confirmButton = document.getElementById("checking");

        if (confirmButton) {
            confirmButton.addEventListener("click", function () {
                const addressField = document.getElementById("to");

                if (addressField) {
                    const enteredAddress = addressField.value.trim();

                    if (enteredAddress !== "") {
                        console.log("Address info added: " + enteredAddress);

                        // Send event to GA4
                        gtag("event", "add_shipping_info", {
                            event_category: "menu-item",
                            event_label: "Shipping address entered",
                            value: 1,
                            address: enteredAddress  
                        });
                    }
                }
            });
        }
    }
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const currentOrigin = window.location.origin;

    if (currentOrigin === "https://www.fooyes.co.uk" || currentOrigin === "https://www.chilli-hut-march.co.uk") {
        const submitButton = document.querySelector('#billing-form button[type="submit"]');

        if (submitButton) {
            submitButton.addEventListener("click", function () {
                const email = document.getElementById("email")?.value.trim();
                const phone = document.getElementById("mobile")?.value.trim();
                const fname = document.getElementById("txtfname")?.value.trim();
                const lname = document.getElementById("txtlname")?.value.trim();

                if (email && phone) {
                    gtag("event", "customer_details", {
                        event_category: "form_submission",
                        event_label: "billing_step",
                        email: email,
                        phone: phone,
                        first_name: fname,
                        last_name: lname
                    });

                    console.log("GA4 event: email_phone_details_entered", {
                        email,
                        phone,
                        first_name: fname,
                        last_name: lname
                    });
                }
            });
        }
    }
});

document.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
        const tag = e.target.tagName.toLowerCase();
        // textarea me enter allow rehne do
        if (tag !== 'textarea') {
            e.preventDefault();
            return false;
        }
    }
});
</script>


