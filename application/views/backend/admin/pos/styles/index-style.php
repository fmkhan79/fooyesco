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
      padding: 10px;

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
      flex:1;
    }
    #product-options-container{
      padding:15px;
    }
    #pos-add-to-cart{
      padding:10px;
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
    .text-danger{
      font-size:20px !important;
    }

    @media (max-width: 992px) {
      .order-card {
        margin-top: 30px;
      }
    }

    #orderSummaryBtn:not(.active), #variantBtn:not(.active) {
      opacity: 0.5;
    }

    .btn-warning.disabled{
      pointer-events:none;
    }

    .sec-button{
      border:none;
      padding:5px 30px;
    }
    .nav-header{
      color:#2f2f2f;
    }

  </style>