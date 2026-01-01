<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Food POS Dashboard</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
  <style>
    body {
      background-color: #f4f6f8;
      font-family: 'Poppins', sans-serif;
      color: #2f2f2f;
    }

    .category-btn {
      background: #fff;
      border: 1.5px solid #e1e1e1;
      border-radius: 12px;
      padding: 12px 20px;
      margin: 5px;
      font-size: 14px;
      font-weight: 500;
      color: #333;
      transition: 0.3s ease;
      text-align: center;
      width: 110px;
    }

    .category-btn.active,
    .category-btn:hover {
      border-color: #00c58e;
      background-color: #eafff7;
      color: #00c58e;
    }

    .menu-card {
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
      padding: 15px;
      text-align: center;
      transition: 0.3s ease;
    }

    .menu-card img {
      width: 100%;
      border-radius: 12px;
      height: 130px;
      object-fit: cover;
    }

    .menu-card h6 {
      margin-top: 10px;
      font-weight: 600;
      font-size: 15px;
    }

    .menu-card button {
      background-color: #00c58e;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 13px;
      padding: 5px 18px;
      margin-top: 6px;
      transition: 0.3s ease;
    }

    .menu-card button:hover {
      background-color: #00ac7b;
    }

    .order-card {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);

    
    }

    .order-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .order-header h5 {
      font-weight: 600;
    }

    .order-details p {
      margin-bottom: 5px;
      font-size: 14px;
    }

    .order-summary div {
      display: flex;
      justify-content: space-between;
      font-size: 14px;
      margin-bottom: 5px;
    }

    .total-line {
      font-weight: 600;
      font-size: 18px;
      color: #00c58e;
    }

    .btn-print {
      background-color: #00c58e;
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 8px 25px;
      margin-right: 10px;
      transition: 0.3s ease;
    }

    .btn-print:hover {
      background-color: #00b17d;
    }

    .btn-fire {
      background-color: #ff6b6b;
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 8px 25px;
      transition: 0.3s ease;
    }

    .btn-fire:hover {
      background-color: #ff4c4c;
    }

    .search-bar {
      border-radius: 8px;
      border: 1px solid #ddd;
      padding: 7px 10px;
      width: 220px;
    }

    @media (max-width: 992px) {
      .order-card {
        margin-top: 30px;
      }
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
      <?php include 'partials/navbar.php'; ?>
    <?php include 'partials/sidebar.php'; ?>
      <?php
      $restaurant_id = isset($_GET['restaurant_id']) 
          ? sanitize($_GET['restaurant_id']) 
          : null;

      $restaurant_categories = [];

      if ($restaurant_id && $restaurant_id !== 'all') {
          $restaurant_categories = $this->category_model
              ->get_categories_by_restaurant_id($restaurant_id);
      }
      ?>

 <!-- Content Wrapper -->
    <div class="content-wrapper">
      <div class="content">
        <div class="container-fluid mt-4">
  <div class="row">
    <!-- Left Section -->
    <div class="col-lg-12">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Categories</h4>
        <input type="text" class="search-bar" placeholder="Search category" />
      </div>

      <!-- Dynamic Category Buttons -->
      <!-- <div class="d-flex flex-wrap mb-4">
        <?php
        $isFirst = true;
        foreach ($restaurant_categories as $restaurant_category) {
          $slug = strtolower(str_replace(' ', '-', $restaurant_category['name']));
        ?>
          <button class="category-btn <?php echo $isFirst ? 'active' : ''; ?>" data-category="<?php echo $slug; ?>">
            <?php echo htmlspecialchars($restaurant_category['name']); ?>
          </button>
        <?php
          $isFirst = false;
        }
        ?>
      </div> -->

    <h5 class="mb-3 font-weight-600">All Categories</h5>
<div class="row">
  <?php foreach ($restaurant_categories as $restaurant_category) { ?>
    <div class="col-md-2 mb-4">
      <a href="<?php echo site_url('pos/category/' . $restaurant_category['id']); ?>" class="text-decoration-none">
        <div class="menu-card text-center p-3 shadow-sm" style="border-radius: 10px; transition: 0.3s;">
          <!-- <img 
            src="<?php echo !empty($restaurant_category['thumbnail']) ? base_url('uploads/category/' . $restaurant_category['thumbnail']) : 'https://via.placeholder.com/150?text=Category'; ?>" 
            alt="<?php echo htmlspecialchars($restaurant_category['name']); ?>" 
            class="img-fluid mb-2" 
            style="border-radius: 10px; height: 150px; object-fit: cover;"
          > -->
          <h6 class="mt-2 text-dark"><?php echo htmlspecialchars($restaurant_category['name']); ?></h6>
        </div>
      </a>
    </div>
  <?php } ?>
</div>
    </div>

    <!-- Right Section -->
    <!-- <div class="col-lg-4">
      <div class="order-card sticky-top" style="top: 20px;">
        <div class="order-header mb-3">
          <h5>Order Details</h5>
          <small>#4587</small>
        </div>
        <div class="order-details mb-3">
          <p><strong>Customer:</strong> Johnson Mitchell</p>
          <p><i class="far fa-clock"></i> Tue, Aug 2024 - 12:00 PM</p>
        </div>
        <hr>
        <div class="order-summary">
          <div><span>Cheese Selection</span><span>$12.00</span></div>
          <div><span>Beef Burger</span><span>$12.00</span></div>
          <div><span>Almond Crusted Salmon</span><span>$17.00</span></div>
          <hr>
          <div><strong>Sub Total</strong><span>$42.00</span></div>
          <div><span>Discount</span><span>$0.00</span></div>
          <div><span>Service Charge</span><span>$5.50</span></div>
          <hr>
          <div class="total-line d-flex justify-content-between">
            <span>Total</span><span>$68.50</span>
          </div>
        </div>
        <div class="text-center mt-4">
          <button class="btn-print">Print</button>
          <button class="btn-fire">Fire</button>
        </div>
      </div>
    </div>
  </div>
</div> -->
</div>
</div>
    </div>
  </div>
</body>
</html>
