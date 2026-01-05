<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($category['name']); ?> - Food POS</title>

    <!-- Bootstrap + FontAwesome + Google Fonts -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />

    <?php include 'styles/index-style.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include 'partials/navbar.php'; ?>
        <?php include 'partials/sidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="mt-4">
                    <div class="row">

                        <div class="col-lg-7">
                            <div class="align-items-center mb-3" style="justify-content: flex-start;">
                                <h4><?php echo htmlspecialchars_decode($category['name'], ENT_QUOTES); ?>
 Items</h4>
                                           <div class="required-msg text-danger d-none">Please select the required item</div>

                                <!-- <input type="text" class="search-bar form-control w-50" placeholder="Search items" /> -->
                            </div>

                            <section class="content">
                                <div class="mt-4">
                                    <div class="row">

                                        <?php if (!empty($menus)) { ?>
                                            <?php foreach ($menus as $menu) { 
                                                // Decode price
                                                $priceData = json_decode($menu['price'], true);
                                                $price = isset($priceData['menu']) 
                                                        ? $priceData['menu'] 
                                                        : $menu['price']; 

                                                $menu_main_categories = $this->menu_model->get_options($menu['id']);
                                                $maincatid = !empty($menu_main_categories) 
                                                            ? $menu_main_categories[0]['id'] 
                                                            : 0;
                                            ?>

                                           <div class="col-md-2 mb-4 p-1">                                                     
                                            <div class="menu-card text-center p-3 shadow-sm position-relative"
                                                style="border-radius: 10px; transition: 0.3s; cursor: pointer;
                                                padding: 0!important; padding-bottom: 20px!important; 
                                                min-height: 390px !important;"
                                                data-maincatid="<?php echo $maincatid; ?>"
                                                data-id="<?php echo $menu['id']; ?>"
                                                data-name="<?php echo htmlspecialchars($menu['name']); ?>"
                                                data-price="<?php echo htmlspecialchars($price); ?>"
                                                data-has-variant="<?php echo $menu['has_variant']; ?>"
                                                data-variants='<?php echo htmlspecialchars(json_encode($menu_main_categories), ENT_QUOTES, "UTF-8"); ?>'>



                                                    <!-- TODO: MAKE SURE TO REVERT BEFORE PUSH -->
                                                     <img src="<?php echo !empty($menu['thumbnail']) 
                                                        ? base_url('uploads/menu/' . $menu['thumbnail']) 
                                                        : 'https://via.placeholder.com/150?text=No+Image'; ?>"
                                                        alt="    <?php echo htmlspecialchars_decode($menu['name'], ENT_QUOTES); ?>"
                                                        class="img-fluid mb-2"
                                                        style="border-radius: 10px; height: 150px; object-fit: cover;"> 

                                                    <h6 class="mt-2 text-dark" >    <?php echo htmlspecialchars_decode($menu['name'], ENT_QUOTES); ?>
</h6>

                                                    <p class="text-muted small mb-2">
                                                        <?php echo htmlspecialchars($menu['description']); ?>
                                                    </p>

                                                    <p class="text-danger font-weight-bold mb-0">£
                                                        <?php echo htmlspecialchars(number_format((float)$price, 2)); ?>
                                                    </p>

                                                </div>
                                            </div>

                                            <?php } ?>
                                        <?php } else { ?>

                                            <div class="col-12 text-center">
                                                <p class="text-muted mt-4">No menu items found for this category.</p>
                                            </div>

                                        <?php } ?>

                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="col-lg-5 d-flex flex-column" style="height: 88vh;gap:10px;">
                          <div id="rightPanel" class="order-card " style="top: 20px;">
    <!-- Product/Variant options will load here dynamically -->
     <style>
        #tab-order button {
            background: #f54748;
            width: 100%;
            color: white;
            font-weight: bold;
            border: none;
            padding: 10px;
        }
     </style>
    <div id="tab-order" style="display:flex; justify-content:center; align-items:center; ">
        <button id="orderSummaryBtn" style="border-right: 4px solid white;" class="active">Order Summary</button>
        <button id="variantBtn" class="d-none">Variant Options</button>

    </div>
    <div id="product-options-container"></div>

    <!-- ORDER SUMMARY -->
    <div id="orderSummary" class="p-3">
        <h5 class="mb-2">Order Summary</h5>
        <p class="text-success small">You're All Set</p>

        <!-- CART ITEMS -->
        <div id="cartItemsContainer" style="max-height: 80%; overflow-y: auto;">
            <p class="text-muted text-center" id="emptyCartMsg">No items added yet.</p>
        </div>


        <!-- TOTALS -->
        <div id="orderTotals" style="display: none;">
            <div class="d-flex justify-content-between mb-1">
                <span>Subtotal</span>
                <span id="subtotal">€0.00</span>
            </div>
            <!-- <div class="d-flex justify-content-between mb-1">
                <span>Service Charges</span>
                <span id="service">£1.00</span>
            </div>
            <div class="d-flex justify-content-between mb-1">
                <span>Bag Charges</span>
                <span id="bag">£0.10</span>
            </div> -->
            <div class="d-flex justify-content-between mb-1 text-danger">
                <span>Discount (<span id="discountPercent">0</span>%)</span>
                <span id="discountAmount">-€0.00</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between fw-bold fs-5">
                <span>Total</span>
                <span id="grandTotal">€0.00</span>
            </div>
        </div>
        
        <!-- PLACE ORDER BUTTON -->
        <div class="mt-3" style="display: flex; gap: 10px; height:55px; flex-direction: column;">
            <button id="placeOrderBtn" class="btn btn-warning w-100 h-20">Pay via Cash</button>
            <button id="placeOrderBtnCard" class="btn btn-warning w-100 h-20">Pay via Card</button>

                    </div>
                </div>
                
                <button id="pos-add-to-cart" onclick="addtocart_updated()" style="width:100%" class="d-none">
                <p class="text-white text-small m-0">Price: £ <small id="variantPrice" style="font-weight:bold" data-baseprice=""></small></p>
                                
                <span>Add To Cart</span>
            </button>
                    
            </div>
            


                                                            </div>


                                                            </div>

                                                        <?php include 'scripts/index-script.php'; ?>

                                        </body>

                                    </html>
<script>
    function addtocart_updated(){
        document.getElementById('addToCartBtn').click();
    }
</script>