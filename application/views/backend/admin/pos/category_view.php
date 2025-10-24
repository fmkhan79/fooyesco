<style>
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
      padding: 25px;
      height: 95vh;
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
</style>
<section class="content">
  <div class="container-fluid">   
    <div class="container mt-4">
      <div class="row">
        
        <!-- Left Section: Menu Items -->
        <div class="col-lg-8">
          <h4 class="mb-3 font-weight-600">
            <?php echo htmlspecialchars($category['name']); ?> Items
          </h4>

          <div class="row">
            <?php if (!empty($menus)) { ?>
              <?php foreach ($menus as $menu) { ?>
                <div class="col-md-6 col-lg-4 mb-4">
                  <div class="menu-card text-center p-3 shadow-sm" style="border-radius: 10px; transition: 0.3s;">
                  <img src="<?php echo !empty($menu['thumbnail']) ? base_url('uploads/menu/' . $menu['thumbnail']) : 'https://via.placeholder.com/300?text=No+Image'; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($menu['name']); ?>">
                    <h6 class="mt-2 text-dark"><?php echo htmlspecialchars($menu['name']); ?></h6>
                    <p class="text-muted small mb-2"><?php echo htmlspecialchars($menu['description']); ?></p>
                    <?php 
                      $priceData = json_decode($menu['price'], true);
                      $price = isset($priceData['menu']) ? $priceData['menu'] : $menu['price']; 
                    ?>
                    <p class="text-primary font-weight-bold mb-0">
                      €. <?php echo htmlspecialchars(number_format((float)$price, 2)); ?>
                    </p>
                  </div>
                </div>
              <?php } ?>
            <?php } else { ?>
              <p class="text-muted">No menu items found for this category.</p>
            <?php } ?>
          </div>
        </div>

        <!-- Right Section: Order Summary -->
        <div class="col-lg-4">
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

      </div> <!-- end row -->
    </div> <!-- end container -->
  </div> <!-- end container-fluid -->
</section>
