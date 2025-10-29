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

  <style>
    body {
      background-color: #f4f6f8;
      font-family: 'Poppins', sans-serif;
      color: #2f2f2f;
    }

    .menu-card {
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
      padding: 15px;
      text-align: center;
      transition: 0.3s ease;
    }

    .menu-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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

    .menu-card p {
      font-size: 13px;
      margin-bottom: 6px;
      color: #777;
    }

    .menu-card .price {
      color: #00c58e;
      font-weight: 600;
      font-size: 15px;
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
</head>

<body>
<div class="container-fluid mt-4">
  <div class="row">
    <!-- Left Section -->
    <div class="col-lg-8">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><?php echo htmlspecialchars($category['name']); ?> Items</h4>
        <input type="text" class="search-bar form-control w-50" placeholder="Search items" />
      </div>

      <!-- Menu Items Grid -->
      <section class="content">
        <div class="container-fluid">
          <div class="container mt-4">
            <div class="row">
              <?php if (!empty($menus)) { ?>
                <?php foreach ($menus as $menu) { 
                  $priceData = json_decode($menu['price'], true);
                  $price = isset($priceData['menu']) ? $priceData['menu'] : $menu['price']; 
                ?>
                  <div class="col-md-3 mb-4">
                    <div class="menu-card text-center p-3 shadow-sm position-relative"
                        style="border-radius: 10px; transition: 0.3s; cursor:pointer;"
                        data-toggle="modal"
                        data-target="#variantModal"
                        data-id="<?php echo $menu['id']; ?>"
                        data-name="<?php echo htmlspecialchars($menu['name']); ?>"
                        data-price="<?php echo htmlspecialchars($price); ?>"
                        data-has-variant="<?php echo $menu['has_variant']; ?>">
                      <img 
                        src="<?php echo !empty($menu['thumbnail']) ? base_url('uploads/menu/' . $menu['thumbnail']) : 'https://via.placeholder.com/150?text=No+Image'; ?>" 
                        alt="<?php echo htmlspecialchars($menu['name']); ?>" 
                        class="img-fluid mb-2"
                        style="border-radius: 10px; height: 150px; object-fit: cover;">

                      <h6 class="mt-2 text-dark"><?php echo htmlspecialchars($menu['name']); ?></h6>
                      <p class="text-muted small mb-2"><?php echo htmlspecialchars($menu['description']); ?></p>
                      <p class="text-primary font-weight-bold mb-0">€: <?php echo htmlspecialchars(number_format((float)$price, 2)); ?></p>

                      <!-- Add Button -->
                      <div class="order-icon position-absolute" style="bottom: 10px; right: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" viewBox="0 0 56 56">
                          <g clip-path="url(#clip0)">
                            <circle cx="28" cy="28" r="21" stroke="#F54748" stroke-width="2"></circle>
                            <path d="M21 28H35M28 21V35" stroke="#F54748" stroke-width="2" stroke-linecap="round"></path>
                          </g>
                          <defs>
                            <clipPath id="clip0">
                              <rect width="56" height="56" fill="white"/>
                            </clipPath>
                          </defs>
                        </svg>
                      </div>
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
        </div>
      </section>
    </div>

    <!-- Right Section (Order Summary) -->
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

        <!-- Scrollable Cart List -->
        <div id="cartItemsContainer" class="order-summary" style="max-height: 300px; overflow-y: auto;">
          <p class="text-muted text-center" id="emptyCartMsg">No items added yet.</p>
        </div>

        <hr>

        <!-- Totals -->
        <div id="orderTotals" style="display: none;">
          <div class="d-flex justify-content-between"><strong>Sub Total</strong><span id="subtotal">€. 0.00</span></div>
          <div class="d-flex justify-content-between"><span>Discount</span><span>€. 0.00</span></div>
          <div class="d-flex justify-content-between"><span>Service Charge</span><span>€. 50.00</span></div>
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
</div>

<!-- 🔹 Variant Selection Modal -->
<div class="modal fade" id="variantModal" tabindex="-1" role="dialog" aria-labelledby="variantModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content p-3">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="variantModalLabel">Select Variant</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6 id="modalItemName" class="font-weight-bold"></h6>
        <p class="text-muted small mb-2">Price: €. <span id="modalItemPrice"></span></p>

        <div id="variantOptions" class="mb-3"></div>

        <div class="form-group">
          <label for="quantity">Quantity</label>
          <input type="number" class="form-control" id="quantity" value="1" min="1">
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" id="addToCart" class="btn btn-primary">Add to Cart</button>
      </div>
    </div>
  </div>
</div>

<!-- 🔹 JS Section -->
<script>
  const cart = [];

  // Open modal on card click
  document.querySelectorAll('.menu-card').forEach(card => {
    card.addEventListener('click', function() {
    console.log('this', this.dataset);
      const name = this.dataset.name;
      const price = parseFloat(this.dataset.price);
      const id = this.dataset.id;
      const hasVariant = this.dataset.hasVariant;

      document.getElementById('modalItemName').innerText = name;
      document.getElementById('modalItemPrice').innerText = price.toFixed(2);

      const variantContainer = document.getElementById('variantOptions');
      variantContainer.innerHTML = '';

      if (hasVariant == 1) {
        variantContainer.innerHTML = `
          <label>Select Variant:</label>
          <select id="variantSelect" class="form-control">
            <option value="Small">Small - €. ${price.toFixed(2)}</option>
            <option value="Medium">Medium - €. ${(price + 50).toFixed(2)}</option>
            <option value="Large">Large - €. ${(price + 100).toFixed(2)}</option>
          </select>
        `;
      } else {
        variantContainer.innerHTML = `<p class="text-muted">No variants available for this item.</p>`;
      }

      document.getElementById('addToCart').onclick = function() {
        const qty = parseInt(document.getElementById('quantity').value);
        const variant = hasVariant == 1 ? document.getElementById('variantSelect').value : 'Default';
        const variantPrice = hasVariant == 1 
          ? parseFloat(document.getElementById('variantSelect').selectedOptions[0].text.split('€. ')[1]) 
          : price;

        const item = { id, name, variant, qty, price: variantPrice };
        cart.push(item);
        updateCartUI();
        $('#variantModal').modal('hide');
      };
    });
  });

  function updateCartUI() {
    const container = document.getElementById('cartItemsContainer');
    const emptyMsg = document.getElementById('emptyCartMsg');
    const totals = document.getElementById('orderTotals');

    container.innerHTML = '';
    let subtotal = 0;

    if (cart.length === 0) {
      emptyMsg.style.display = 'block';
      totals.style.display = 'none';
      return;
    } else {
      emptyMsg.style.display = 'none';
      totals.style.display = 'block';
    }

    cart.forEach((item, index) => {
      const lineTotal = item.price * item.qty;
      subtotal += lineTotal;

      const div = document.createElement('div');
      div.classList.add('d-flex', 'justify-content-between', 'align-items-center', 'mb-2');
      div.innerHTML = `
        <div>
          <strong>${item.name}</strong><br>
          <small>${item.variant} × ${item.qty}</small>
        </div>
        <div>
          <span>€. ${lineTotal.toFixed(2)}</span>
          <button class="btn btn-sm btn-link text-danger p-0 ml-2 remove-item" data-index="${index}">
            <i class="fas fa-times"></i>
          </button>
        </div>
      `;
      container.appendChild(div);
    });

    document.getElementById('subtotal').innerText = '€. ' + subtotal.toFixed(2);
    const serviceCharge = 50;
    document.getElementById('total').innerText = '€. ' + (subtotal + serviceCharge).toFixed(2);

    document.querySelectorAll('.remove-item').forEach(btn => {
      btn.addEventListener('click', function() {
        const i = this.dataset.index;
        cart.splice(i, 1);
        updateCartUI();
      });
    });
  }
</script>


</body>
</html>
