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

    <?php include 'styles/index-style.php';?>
</head>
<?php 
$menu_sub_catagory_items = $this->menu_model->get_sub_options($maincatid);
 print_r($menu_sub_catagory_items);
        die();
// Build mapping array: menu_id → sub_option_id
$subOptionMap = [];
if (!empty($menu_sub_catagory_items)) {
    foreach ($menu_sub_catagory_items as $opt) {
        $subOptionMap[$opt['menu_id']] = $opt['id'];
        print_r($subOptionMap);
        die();
    }
}
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'partials/navbar.php'; ?>
        <?php include 'partials/sidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="mt-4">
                    <div class="row">

                        <!-- Left Section -->
                        <div class="col-lg-8">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4><?php echo htmlspecialchars($category['name']); ?> Items</h4>
                                <input type="text" class="search-bar form-control w-50" placeholder="Search items" />
                            </div>

                            <!-- Menu Items Grid -->
                            <section class="content">
                                <div class="mt-4">
                                    <div class="row">

                                        <?php if (!empty($menus)) { ?>
                                            <?php foreach ($menus as $menu) { 
                                                $priceData = json_decode($menu['price'], true);
                                                $price = isset($priceData['menu']) ? $priceData['menu'] : $menu['price']; 

                                                // Find correct real ID for THIS menu
                                                $real_id = isset($subOptionMap[$menu['id']]) 
                                                            ? $subOptionMap[$menu['id']] 
                                                            : $menu['id'];
                                            ?>

                                            <div class="col-md-3 mb-4 p-1">
                                                <div class="menu-card text-center p-3 shadow-sm position-relative"
                                                    style="border-radius: 10px; transition: 0.3s; cursor: pointer; 
                                                    padding: 0!important; padding-bottom: 20px!important; 
                                                    min-height: 278px !important;"

                                                    data-id="<?php echo $real_id; ?>"
                                                    data-maincatid="<?php echo $real_id; ?>"
                                                    data-name="<?php echo htmlspecialchars($menu['name']); ?>"
                                                    data-price="<?php echo htmlspecialchars($price); ?>"
                                                    data-has-variant="<?php echo $menu['has_variant']; ?>"
                                                >

                                                    <img src="<?php echo !empty($menu['thumbnail']) 
                                                        ? base_url('uploads/menu/' . $menu['thumbnail']) 
                                                        : 'https://via.placeholder.com/150?text=No+Image'; ?>"
                                                        alt="<?php echo htmlspecialchars($menu['name']); ?>"
                                                        class="img-fluid mb-2"
                                                        style="border-radius: 10px; height: 150px; object-fit: cover;">

                                                    <h6 class="mt-2 text-dark"><?php echo htmlspecialchars($menu['name']); ?></h6>

                                                    <p class="text-muted small mb-2"><?php echo htmlspecialchars($menu['description']); ?></p>

                                                    <p class="text-danger font-weight-bold mb-0">€. 
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

                        <!-- Right Section (unchanged) continues... -->

                        <div class="col-lg-4">
                            <div id="rightPanel" class="order-card sticky-top" style="top: 20px;">
                                <!-- Default Order Summary -->
                                <div id="orderSummary">
                                    <div class="order-header mb-3">
                                        <h5>Order Details</h5>
                                        <small>#4587</small>
                                    </div>
                                    <div class="order-details mb-3">
                                        <p><strong>Customer:</strong> Johnson Mitchell</p>
                                        <p><i class="far fa-clock"></i> Tue, Aug 2024 - 12:00 PM</p>
                                    </div>
                                    <hr>
                                    <div id="cartItemsContainer" class="order-summary"
                                        style="max-height: 300px; overflow-y: auto;">
                                        <p class="text-muted text-center" id="emptyCartMsg">No items added yet.</p>
                                    </div>
                                    <hr>
                                    <div id="orderTotals" style="display: none;">
                                        <div class="d-flex justify-content-between"><strong>Sub Total</strong><span
                                                id="subtotal">€. 0.00</span></div>
                                        <div class="d-flex justify-content-between"><span>Discount</span><span>€.
                                                0.00</span></div>
                                        <div class="d-flex justify-content-between"><span>Service Charge</span><span>€.
                                                50.00</span></div>
                                        <hr>
                                        <div class="total-line d-flex justify-content-between">
                                            <span>Total</span><span id="total">€. 50.00</span>
                                        </div>
                                    </div>
                                    <div class="text-center mt-4">
                                        <button class="btn btn-secondary">Print</button>
                                        <button class="btn btn-danger">Fire</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- 🔹 Variant Selection Modal -->

                    </div>

                    <?php include 'scripts/index-script.php'; ?>

</body>

</html>