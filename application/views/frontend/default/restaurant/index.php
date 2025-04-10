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



    /* Show the element only on mobile screens (<= 768px) */
    /* @media (max-width: 768px) {
    #mobile-only {
        display: block;
    } */

    .scroll-to-order-btn {
    position: fixed; /* Fix button to the screen */
    bottom: 20px; /* Position from the bottom */
    left: 50%; /* Center horizontally */
    transform: translateX(-50%); /* Ensure it's centered */
    z-index: 1000; /* Ensure it's on top of other content */
    background-color: #ff4d4d; /* Button background color */
    color: white;
    padding: 10px 20px; /* Button padding */
    border-radius: 8px; /* Rounded corners */
    display: none; /* Initially hide the button */
    cursor: pointer; /* Pointer on hover */
}

    #myBtn {
  /* display: none;
  position: fixed;
  bottom: 20px;
  right: 30px;
  z-index: 99;
  font-size: 18px;
  border: none;
  outline: none;
  background-color: #ed2c0d;
  color: white;
  cursor: pointer;
  padding: 5px 10px;
  border-radius: 4px; */

  display: none;
  position: fixed; /* Fix button to the screen */
    bottom: 20px; /* Position from the bottom */
   
    /* Ensure it's centered */
    z-index: 99; /* Ensure it's on top of other content */
    background-color: #ff4d4d; /* Button background color */
    color: white;
    padding: 10px 10px; /* Button padding */
    border-radius: 8px; /* Rounded corners */
    display: none; /* Initially hide the button */
    cursor: pointer; /* Pointer on hover */
}
    #viewmyBtn {
  /* display: none;
  position: fixed;
  bottom: 20px;
  right: 30px;
  z-index: 99;
  font-size: 18px;
  border: none;
  outline: none;
  background-color: #ed2c0d;
  color: white;
  cursor: pointer;
  padding: 5px 10px;
  border-radius: 4px; */

  display: none;
  position: fixed; /* Fix button to the screen */
    bottom: 20px; /* Position from the bottom */
    right: 30px;
    /* Ensure it's centered */
    z-index: 99; /* Ensure it's on top of other content */
    background-color: #ff4d4d; /* Button background color */
    color: white;
    padding: 10px 10px; /* Button padding */
    border-radius: 8px; /* Rounded corners */
    display: none; /* Initially hide the button */
    cursor: pointer; /* Pointer on hover */
}

#myBtn:hover {
  background-color: #555;
}
#cal{
    bottom: -0.1em!important;
    font-size: 0.5em;
    left: 45px;
}

.order-red-mobile-btn{
    
    padding: 11px 22px;
    background: #f54748;
    border-radius: 41px;
    font-size: 14px;
    color: #fff;
    font-weight: 500;
}
</style>
<!-- RESTAURANT GALLERY -->



<section class="detail-wbox mt-4 d-none d-md-block">

    <div class="container bg-white text-dark border border-light">
        <div class="row">
            <div class="col-md-8" style="padding-left: 20px;">
                <div class="d-md-flex justify-content-between">
                    <div class="detail-wbox-title">
                        <h3>
                            <?php echo $restaurant_details['name']; ?>
                        </h3>

                        <?php if ($restaurant_details["address"]) {
                            echo $restaurant_details["address"]; ?> - <span class="red">Get
                                directions</span>
                        <?php } ?>
                        <div class="red big-txt pt-3">
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
                   
                        <?php echo $restaurant_details['delivery_charge']; ?>£
                    </div>
                    <div class="col-md-3 col-sm-6"><img src="<?php echo base_url('assets/frontend/default/images/min-order-icon.png'); ?>" /> Min
                        Order : 10 £
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
                    <h5><strong>About"
                            <?php echo $restaurant_details['name']; ?>"
                        </strong></h5>
                    <?php echo $restaurant_details['restaurant_about']; ?>. 
                    <!-- <a class="red" href="#"> READ MORE</a> -->
                </div>

            </div>
            <div class="col-md-4"><img class="img-fluid" src="<?php echo base_url('assets/frontend/default/images/detail-wbox-img.png'); ?>" /></div>
        </div>
    </div>
</section>


<!-- RESTAURANT TITLE HEADER -->
<section class="detail-wbox mt-4">
<button onclick="topFunction()" class="border-0 fw-bold d-md-none mybtn" id="myBtn"  style="background-color: #ff4d4d; border-radius: 38px;" title="Go to top">View My Order</button>
<button onclick="viewtopFunction()" class="border-0 fw-bold d-none d-lg-block" 
    id="viewmyBtn" style="background-color: #ff4d4d; border-radius: 38px; display: none !important;" 
    title="Go to top">
    View My Order
</button>
    <div class="container bg-white text-dark border border-light d-md-none">
        <div class="row">
            <div class="col-md-8">
                <div class="d-md-flex justify-content-between">
                    <div class="detail-wbox-title pl-3">
                        <h3>
                            <?php echo $restaurant_details['name']; ?>
                        </h3>
                        <?php if ($restaurant_details["address"]) { ?>
                                    <div><?php echo $restaurant_details["address"]; ?> - <span class="red p-0">Get directions</span></div>
                                <?php } ?>
                    </div>
                </div>

                <!-- Accordion Section Start -->
                <div class="accordion" id="restaurantAccordion1">
    <div class="accordion-item" style="padding-left: 15px;">
        <h2 class="accordion-header" id="headingRestaurant1">
            <button class="accordion-button order-red-btn text-center mt-2 border-0 w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRestaurant1" aria-expanded="false" aria-controls="collapseRestaurant1">
                <h5>Restaurant Details</h5>
            </button>
        </h2>
        <div id="collapseRestaurant1" class="accordion-collapse collapse" aria-labelledby="headingRestaurant1" data-bs-parent="#restaurantAccordion1">
            <div class="accordion-body">
                                <!-- Restaurant Address and Directions -->
                              

                                <!-- Cuisines Section -->
                                <div class="red big-txt"ds>
                                    <?php
                                    $cuisines = json_decode($restaurant_details['cuisine']);
                                    foreach ($cuisines as $key => $cuisine):
                                        $cuisine = $this->cuisine_model->get_by_id($cuisine);
                                        if (isset($cuisine) && count($cuisine)):
                                    ?>
                                            <?php if ($key === array_key_last($cuisines)) {
                                                echo sanitize($cuisine['name']);
                                            } else {
                                                echo sanitize($cuisine['name'] . ' |');
                                            } ?>
                                    <?php endif; endforeach; ?>
                                </div>

                                <!-- Review Section -->
                                <div class="review-box d-flex justify-content-between align-items-center">
                                    <div class="review-box-txt col-md-4">
                                        <?php if ($restaurant_details['rating']) { ?>
                                            Superb <?php echo sanitize($reviews_count); ?> Reviews
                                        <?php } ?>
                                    </div>
                                    <div class="review-grid d-flex justify-content-around align-items-center m-0 col-md-7">
                                        <?php if ($restaurant_details['rating']) { ?>
                                            <ul class="inline-grid">
                                                <li><img class="rounded-img" src="https://dummyimage.com/600x400/000/fff" alt width="38" height="38"></li>
                                                <li><img class="rounded-img" src="https://dummyimage.com/600x400/000/fff" alt width="38" height="38"></li>
                                                <li><img class="rounded-img" src="https://dummyimage.com/600x400/000/fff" alt width="38" height="38"></li>
                                            </ul>
                                            <div class="star">
                                                <svg width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.0489 0.926805C11.3483 0.00549436 12.6517 0.00549579 12.9511 0.926806L14.9187 6.98253C15.0526 7.39456 15.4365 7.67352 15.8697 7.67352H22.2371C23.2058 7.67352 23.6086 8.91313 22.8249 9.48253L17.6736 13.2252C17.3231 13.4798 17.1764 13.9312 17.3103 14.3432L19.2779 20.3989C19.5773 21.3203 18.5228 22.0864 17.7391 21.517L12.5878 17.7743C12.2373 17.5197 11.7627 17.5197 11.4122 17.7743L6.2609 21.517C5.47719 22.0864 4.42271 21.3203 4.72206 20.3989L6.68969 14.3432C6.82356 13.9312 6.6769 13.4798 6.32642 13.2252L1.17511 9.48253C0.391392 8.91313 0.794168 7.67352 1.76289 7.67352H8.13026C8.56349 7.67352 8.94744 7.39456 9.08132 6.98253L11.0489 0.926805Z" fill="#FFB800"></path>
                                                </svg>
                                            </div>
                                            <p class="p-0 m-0">(<?php echo sanitize($restaurant_details['rating']); ?>)</p>
                                        <?php } ?>
                                    </div>
                                </div>

                                <!-- Delivery Info -->
                            <div class="row my-4 free-delivery-list">
                                   <div class="col-md-4 col-sm-6"><img src="<?php echo base_url('assets/frontend/default/images/delivery-free-icon.png'); ?>" />
                        Delivery fee :
                   
                        <?php echo $restaurant_details['delivery_charge']; ?>£
                    </div>
                    <div class="col-md-4 col-sm-6"><img src="<?php echo base_url('assets/frontend/default/images/min-order-icon.png'); ?>" /> Min
                        Order : 10 £
                    </div>
                    <div class="col-md-4 col-sm-6"><img src="<?php echo base_url('assets/frontend/default/images/collect-icon.png'); ?>" />
                        <span id="delivery" class="collect-box">Delivering now</span><span id="collection"
                            class="collect-box" style="display:none">I
                            want to collect</span>
                    </div>
                    <div class="col-md-3 col-sm-6 red"><img src="<?php echo base_url('assets/frontend/default/images/time-icon-red.png'); ?>" />
                        <?php echo $restaurant_details['maximum_time_to_deliver']; ?> mins
                    </div>

                                </div> 

                                <!-- About Section -->
                                <div class="order-about">
                                    <h3><strong>About "<?php echo $restaurant_details['name']; ?>"</strong></h3>
                                    <?php echo $restaurant_details['restaurant_about']; ?>.
                                    <!-- <a class="red" href="#"> READ MORE</a> -->
                                </div>

                                <div class="col-md-4">
                <img class="img-fluid" src="<?php echo base_url('assets/frontend/default/images/detail-wbox-img.png'); ?>" />
            </div>
                            </div>
                        </div>
                    </div> <!-- End of Accordion Item -->
                </div> <!-- End of Accordion -->
                <!-- Accordion Section End -->
            </div>

            
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
<!-- <section class="free-delivery-section order-detail-page mb-2 mt-3">
    <div class="container bg-red p-4 text-light rounded border-light">
        <div class="d-md-flex align-items-center">
            <div class="col-md-9">
                <h3><?php //echo !is_null($heading) ? $heading : 'Offers Coming soon'; ?></h3>
                <p class="p-0 m-0">
                    <?php //echo !is_null($description) ? $description : 'Be there, we will have an amazing offer.'; ?>
                </p>
            </div>
            <div id="viewOrderButton" class="col-md-3 text-center"><a <?php //if (!empty($ctaLink)) {
                                                        //echo 'href="' . $ctaLink . '"';
                                                   // } ?> class="w-rounded-btn">More
                    Offers</a></div>
        </div>
    </div>
</section> -->
<!-- ./Offer area -->

<?php $restaurant_categories = $this->category_model->get_all(); ?>
<!-- Category tabs with scrool nav -->

<section class="order-detail-btns container d-none d-lg-block " style="border-radius: 20px;">
    <div class="container">
    <div class="order-detail-slider owl-carousel owl-theme my-5 ">
        <?php foreach ($restaurant_categories as $restaurant_category) { ?>
            <a href="#<?php echo strtolower(str_replace(' ', '-', $restaurant_category['name'])); ?>">
                <?php echo $restaurant_category['name']; ?>
            </a>
        <?php } ?>
    </div>
    </div>
 
</section>

<section class="order-detail-btns container-fluid d-lg-none">
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

<div class="container mt-5">
    <!-- Accordion Wrapper -->
    <div class="accordion" id="accordionExample">
    <div class="accordion-item d-md-none">
        <h2 class="accordion-header" id="headingOrder1">
            <button class="accordion-button order-red-btn text-center mt-4 border-0 w-100  d-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrder1" aria-expanded="true" aria-controls="collapseOrder1">
                <h5>View My Order</h5>
            </button>
        </h2>
        <button id="scrollToOrderButton" class="scroll-to-order-btn border-0 fw-bold" style="display: none; border-radius: 38px;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrder1" aria-expanded="true" aria-controls="collapseOrder1">
            View My Order
        </button>
        <?php include(__DIR__ . '/partials/ordersummary.php'); ?>
        <div id="collapseOrder1" class="accordion-collapse collapse" aria-labelledby="headingOrder1" data-bs-parent="#accordionExample">
            <div class="accordion-body">

                    <!-- Order Summary Section (only visible on mobile) -->
                    
              
            </div>
        </div>
    </div> <!-- End of Accordion Wrapper -->
</div>
</div>
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

                        <div class="order-detail-box" style="width:105%">
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
                                                                  
 <?php // Load the model
$this->load->model('user_model');

// Get the current user ID from session (assuming user ID is stored in session)
$user_id = $this->session->userdata('user_id');

// Check if the user is an owner (role_id = 3)
$isOwner = $this->user_model->check_user_role($user_id);

// Pass the result to the view
$data['isOwner'] = $isOwner; // Pass to the view (if needed)
// print_r($isOwner);
                        ?>

                                <?php if ($isOwner): ?>
    <div data-toggle="" data-menu-id="<?php echo $menu['id']; ?>" data-price="<?php 
        $price = json_decode($menu['price']);
        echo $price->menu;?>">
<?php else: ?>
    <div data-toggle="modal" onclick="viewselected_menu(<?php echo $menu['id']; ?>, '<?php 
        $price = json_decode($menu['price']);
        echo $price->menu; ?>')">
<?php endif; ?>
    <!-- Your other content here -->
                                    <div class="d-flex order-detail-box-txt align-items-center justify-content-between flex-row-reverse flex-md-row">
                                        <div class="col-md-8 d-flex align-items-center p-0 m-0 flex-md-row flex-row-reverse
">
                                            <div class="item-img-box mr-3"><a><img class="rounded-circle"
                                                        src="<?php echo base_url('uploads/menu/') . $menu['thumbnail']; ?>" height="80  px" width="80px" /></a></div>
                                                        <div class="order col-md-2 d-md-none" id="order-add">
                                            <a href="#" data-toggle="modal"
                                                onclick="viewselected_menu(<?php echo $menu['id']; ?>,<?php $price = json_decode($menu['price']);
                                                                                                        echo $price->menu; ?>)">


                                        
 <?php // Load the model
$this->load->model('user_model');

// Get the current user ID from session (assuming user ID is stored in session)
$user_id = $this->session->userdata('user_id');

// Check if the user is an owner (role_id = 3)
$isOwner = $this->user_model->check_user_role($user_id);

// Pass the result to the view
$data['isOwner'] = $isOwner; // Pass to the view (if needed)
// print_r($isOwner);
                        ?>
                                           <?php if ($isOwner): ?>
                                            <button class="btn" disabled style="width: 114px; height: 70px; padding: 0; word-wrap: break-word;
 font-size: 14px; color:red; display: flex; align-items: center; justify-content: center; padding-right: 65px;
" disabled>
    Owner <br> can't <br> order
</button>
<?php else: ?>
    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="56" viewBox="0 0 56 56" fill="white" class="svg-mobile">
        <g clip-path="url(#clip0_4609_18554)">
            <path d="M28 49C39.598 49 49 39.598 49 28C49 16.402 39.598 7 28 7C16.402 7 7 16.402 7 28C7 39.598 16.402 49 28 49Z" stroke="#F54748" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M21 28H35" stroke="#F54748" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M28 21V35" stroke="#F54748" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </g>
        <defs>
            <clippath id="clip0_4609_18554" >
                <rect width="56" height="56" fill="white" />
            </clippath>
        </defs>
    </svg>
<?php endif; ?>
                                            </a>
                                        </div>
                                            <div class="item-txt-box d-none d-md-block">
                                                <h3>
                                                    <span>
                                                        <?php echo ucfirst($menu['name']); ?>
                                                    </span>
                                                </h3>
                                                <?php echo $menu['details']; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4 d-flex p-0 m-0 flex-column-reverse flex-md-row align-items-center">
                                            <!-- <div class="col-md-2 d-md-none"></div> -->
                                        <div class="price col-md-6 p-0">
                                            <?php echo currency($starts_from->menu); ?>
                                        </div>
                                        <div class="item-txt-box col-md-6 p-0 d-md-none">
                                                <h3>
                                                    <span>
                                                        <?php echo ucfirst($menu['name']); ?>
                                                    </span>
                                                </h3>
                                                <?php echo $menu['details']; ?>
                                            </div>
                                        <div class="order col-md-2 d-none d-md-block">
                                            <a href="#" data-toggle="modal"
                                                onclick="viewselected_menu(<?php echo $menu['id']; ?>,<?php $price = json_decode($menu['price']);
                                                                                                        echo $price->menu; ?>)">


                                        
 <?php // Load the model
$this->load->model('user_model');

// Get the current user ID from session (assuming user ID is stored in session)
$user_id = $this->session->userdata('user_id');

// Check if the user is an owner (role_id = 3)
$isOwner = $this->user_model->check_user_role($user_id);

// Pass the result to the view
$data['isOwner'] = $isOwner; // Pass to the view (if needed)
// print_r($isOwner);
                        ?>
                                           <?php if ($isOwner): ?>
                                            <button class="btn" disabled style="width: 114px; height: 70px; padding: 0; word-wrap: break-word;
 font-size: 14px; color:red; display: flex; align-items: center; justify-content: center; padding-right: 65px;
" disabled>
    Owner <br> can't <br> order
</button>
<?php else: ?>
    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 56 56" fill="none" class="svg-mobile">
        <g clip-path="url(#clip0_4609_18554)">
            <path d="M28 49C39.598 49 49 39.598 49 28C49 16.402 39.598 7 28 7C16.402 7 7 16.402 7 28C7 39.598 16.402 49 28 49Z" stroke="#F54748" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M21 28H35" stroke="#F54748" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M28 21V35" stroke="#F54748" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </g>
        <defs>
            <clippath id="clip0_4609_18554">
                <rect width="56" height="56" fill="white" />
            </clippath>
        </defs>
    </svg>
<?php endif; ?>
                                            </a>
                                        </div>
                                        </div>
                                  
                                  
                                    </div>
                                </div>
                                <div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button style="text-align: right; margin: 20px 20px 0 0; cursor: pointer;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
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
<!-- for screens -->
<?php include(__DIR__ . '/partials/ordersummary.php'); ?>

            <input name="order_type" value="delivery" class="d-none">
            
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

    function closeModal() {
        var modal = document.getElementById('popup');
        $(modal).modal('hide');
    }

    document.querySelector('.close').addEventListener('click', closeModal);
    
    
    const mybutton = document.getElementById("myBtn");
const scrollToOrderButton = document.getElementById("scrollToOrderButton");
const viewOrderButton = document.getElementById("viewOrderButton");
const collapseElement = document.getElementById("collapseOrder1");

// Hide "View My Order" button by default
mybutton.style.display = "none";

// Function to scroll to top smoothly and then toggle collapse
function topFunction() {
    window.scrollTo({ top: 250, behavior: "smooth" });
  // Check scroll position continuously
  let checkScroll = setInterval(() => {
        if (window.scrollY === 250) {
            mybutton.style.display = "none"; // Hide button when at top
            clearInterval(checkScroll); // Stop checking
        }
    }, 100); // Check every 100ms
    // Wait for scrolling to complete using setTimeout
    setTimeout(() => {
        // Toggle collapse
        if (collapseElement.classList.contains("show")) {
            // collapseElement.classList.remove("show");
            //  // Collapse it
        } else {
            collapseElement.classList.add("show"); // Expand it
        }
    }, 600); // Delay slightly to allow scrolling to finish
}

// Hide "View My Order" button when user scrolls down
window.addEventListener("scroll", function () {
    if (window.scrollY > 400) {
        mybutton.style.display = "block"; // Hide button on scroll down
    }else{
        mybutton.style.display = "none"; // Hide button on scroll down
    }
});

// Attach "View My Order" button click event to toggle collapse
// causing issue/
// viewOrderButton.addEventListener("click", function () {
//     topFunction() // Call function
// });

// Attach "Top" button click event
// mybutton.addEventListener("click", toggleOrderView);





 


    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }
    const status = getQueryParam('q');

console.log(status);
    if (status === '2') {
        var element = document.getElementById("collapseOrder1");
        element.classList.remove("accordion-collapse");
        element.classList.remove("collapse");

        element.classList.add("accordion-collapse");

        element.classList.add("collapse");
        element.classList.add("show");

    }
    else{
        console.log("not deleted yet")
    }

    // Button ko select karein
    let viewmyBtn = document.getElementById("viewmyBtn");

    // Jab user scroll kare, function chalay ga
    window.addEventListener("scroll", function() {
        if (window.scrollY > 100) { 
            viewmyBtn.style.display = "block"; // 100px scroll hone ke baad dikhayein
        } else {
            viewmyBtn.style.display = "none"; // 100px se kam scroll hone par chupayein
        }
    });

    function viewtopFunction() {
        window.scrollTo({ top: 500, behavior: 'smooth' }); // Smooth scrolling effect
    }

</script>

<!-- ./Mobile app section -->