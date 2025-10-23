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
     height: 95VH; /* full screen height minus some margin */

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
<body>

  <div class="container-fluid mt-4">
    <div class="row">
      <!-- Left Section -->
      <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Category</h4>
          <input type="text" class="search-bar" placeholder="Search menu" />
        </div>

        <div class="d-flex flex-wrap mb-4">
          <button class="category-btn active"><i class="fas fa-utensils mr-1"></i> Food</button>
          <button class="category-btn"><i class="fas fa-cocktail mr-1"></i> Bar</button>
          <button class="category-btn"><i class="fas fa-mug-hot mr-1"></i> Soup</button>
          <button class="category-btn"><i class="fas fa-pizza-slice mr-1"></i> Pizzas</button>
          <button class="category-btn"><i class="fas fa-fish mr-1"></i> Fish</button>
        </div>

        <h5 class="mb-3 font-weight-600">Special Menu for You</h5>
        <div class="row">
          <div class="col-md-3 mb-4">
            <div class="menu-card">
              <img src="https://i.imgur.com/vLwzZkP.png" alt="Pizza">
              <h6>Super Delicious Pizza</h6>
              <button>ADD</button>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="menu-card">
              <img src="https://i.imgur.com/gG1fDgN.png" alt="Burger">
              <h6>Super Delicious Burger</h6>
              <button>ADD</button>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="menu-card">
              <img src="https://i.imgur.com/obEQD3N.png" alt="Chicken">
              <h6>Super Delicious Chicken</h6>
              <button>ADD</button>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="menu-card">
              <img src="https://i.imgur.com/nL64lNK.png" alt="Chips">
              <h6>Super Delicious Chips</h6>
              <button>ADD</button>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="menu-card">
              <img src="https://i.imgur.com/nL64lNK.png" alt="Chips">
              <h6>Super Delicious Chips</h6>
              <button>ADD</button>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="menu-card">
              <img src="https://i.imgur.com/nL64lNK.png" alt="Chips">
              <h6>Super Delicious Chips</h6>
              <button>ADD</button>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="menu-card">
              <img src="https://i.imgur.com/nL64lNK.png" alt="Chips">
              <h6>Super Delicious Chips</h6>
              <button>ADD</button>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="menu-card">
              <img src="https://i.imgur.com/nL64lNK.png" alt="Chips">
              <h6>Super Delicious Chips</h6>
              <button>ADD</button>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="menu-card">
              <img src="https://i.imgur.com/nL64lNK.png" alt="Chips">
              <h6>Super Delicious Chips</h6>
              <button>ADD</button>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="menu-card">
              <img src="https://i.imgur.com/nL64lNK.png" alt="Chips">
              <h6>Super Delicious Chips</h6>
              <button>ADD</button>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="menu-card">
              <img src="https://i.imgur.com/nL64lNK.png" alt="Chips">
              <h6>Super Delicious Chips</h6>
              <button>ADD</button>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="menu-card">
              <img src="https://i.imgur.com/nL64lNK.png" alt="Chips">
              <h6>Super Delicious Chips</h6>
              <button>ADD</button>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="menu-card">
              <img src="https://i.imgur.com/nL64lNK.png" alt="Chips">
              <h6>Super Delicious Chips</h6>
              <button>ADD</button>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="menu-card">
              <img src="https://i.imgur.com/nL64lNK.png" alt="Chips">
              <h6>Super Delicious Chips</h6>
              <button>ADD</button>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="menu-card">
              <img src="https://i.imgur.com/nL64lNK.png" alt="Chips">
              <h6>Super Delicious Chips</h6>
              <button>ADD</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Section -->
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

</body>
</html>
