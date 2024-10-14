<!-- Swipper Slider -->
<link rel="stylesheet" href="<?php echo base_url('assets/frontend/default/css/swiper.min.css'); ?>">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/frontend/default/css/magnific-popup.css'); ?>">

<!-- LEAFLET CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/global/leaflet/leaflet.css'); ?>">
<!-- order listing carousel -->
<link href="<?php echo base_url('assets/frontend/default/css/owl.theme.default.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/frontend/default/css/owl.carousel.min.css'); ?>" rel="stylesheet">


<style media="screen">
  .food-item-card {
    box-shadow: 0px 3px 40px 0 rgba(206, 205, 205, 0.3);
  }

  .reserve-rating {
    margin-top: -6px;
    font-size: 18px;
    border-radius: 20px;
    background: #FDC55E;
  }


  .popup {
    width: 100%;
    height: 100%;
    display: none;
    position: fixed;
    top: 0px;
    left: 0px;
    background: rgba(0, 0, 0, 0.75);
    z-index: 1070;
  }

  .popup {
    text-align: center;
  }

  .popup:before {
    content: '';
    display: inline-block;
    height: 100%;
    margin-right: -4px;
    vertical-align: middle;
  }

  .popup-inner {
    display: inline-block;
    text-align: left;
    vertical-align: middle;
    position: relative;
    max-width: 700px;
    width: 90%;
    padding: 40px;
    box-shadow: 0px 2px 6px rgba(0, 0, 0, 1);
    border-radius: 3px;
    background: #fff;
    text-align: center;
  }

  .popup-inner h1 {
    font-family: 'Roboto Slab', serif;
    font-weight: 700;
  }

  .popup-inner p {
    font-size: 24px;
    font-weight: 400;
  }

  .popup-close {
    width: 34px;
    height: 34px;
    padding-top: 4px;
    display: inline-block;
    position: absolute;
    top: 20px;
    right: 20px;
    -webkit-transform: translate(50%, -50%);
    transform: translate(50%, -50%);
    border-radius: 100%;
    background: transparent;
    border: solid 4px #808080;
  }

  .popup-close:after,
  .popup-close:before {
    content: "";
    position: absolute;
    top: 11px;
    left: 5px;
    height: 4px;
    width: 16px;
    border-radius: 30px;
    background: #808080;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
  }

  .popup-close:after {
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
  }

  .popup-close:hover {
    -webkit-transform: translate(50%, -50%) rotate(180deg);
    transform: translate(50%, -50%) rotate(180deg);
    background: #f00;
    text-decoration: none;
    border-color: #f00;
  }

  .popup-close:hover:after,
  .popup-close:hover:before {
    background: #fff;
  }

  #map {
    height: 260px;
  }

  /* 4% BORDER RADIUS */
  .border-radius-4 {
    border-radius: 4%;
  }

  /* INCREMENTER AND DECREMENTER BUTTON */
  .quantity-incrementar {
    border-color: #d9d9d9;
    border-radius: 4px 0px 0px 4px;
    border-right: none;
  }

  .quantity-decrementer {
    border-color: #d9d9d9;
    border-radius: 0px 4px 4px 0px;
    border-left: none;
  }

  .quantity-incrementar:focus,
  .quantity-decrementer:focus {
    box-shadow: none;
  }

  .quantity-incrementar:active,
  .quantity-decrementer:active {
    background-color: #c7c7c7;
  }

  /* HIDING ARROWS FROM NUMBER */
  input[type='number'] {
    -moz-appearance: textfield;
  }

  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
  }

  /* pink cart button */
  .pink-cart-btn {
    color: #fff;
    background-color: #fc3a6d;
    border-color: #fc3a6d;
  }

  .pink-cart-btn:active,
  .pink-cart-btn:hover {
    background-color: #c5254f;
    border-color: #c5254f;
  }

  .pink-cart-btn:focus {
    box-shadow: 0 0 0 3px rgb(252 58 109);
  }

  /* custom radio button for menu variation */
  [type="radio"]:checked,
  [type="radio"]:not(:checked) {
    /* position: absolute; */
    left: -9999px;
  }

  [type="radio"]:checked+label,
  [type="radio"]:not(:checked)+label {
    position: relative;
    padding-left: 18px;
    cursor: pointer;
    line-height: 20px;
    display: inline-block;
    color: #666;
  }

  [type="radio"]:checked+label:before,
  [type="radio"]:not(:checked)+label:before {
    content: '';
    position: absolute;
    left: 0;
    top: 3px;
    width: 14px;
    height: 14px;
    border: 1px solid #ddd;
    border-radius: 100%;
    background: #fff;
  }

  [type="radio"]:checked+label:after,
  [type="radio"]:not(:checked)+label:after {
    content: '';
    width: 8px;
    height: 8px;
    background: #fc3a6d;
    position: absolute;
    top: 6px;
    left: 3px;
    border-radius: 100%;
    -webkit-transition: all 0.2s ease;
    transition: all 0.2s ease;
  }

  [type="radio"]:not(:checked)+label:after {
    opacity: 0;
    -webkit-transform: scale(0);
    transform: scale(0);
  }

  [type="radio"]:checked+label:after {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1);
  }

  .note {
    font-size: 13px;
  }

  .each-variant {
    margin-bottom: 10px;
  }

  .each-variant label {
    font-size: 15px;
  }

  .addon-area label {
    font-size: 15px;
    vertical-align: middle;
  }

  .variant-name {
    font-size: 14px;
    font-weight: 900;
    text-align: left;
  }

  .addon-name {
    font-size: 14px;
    font-weight: 900;
    text-align: left;
  }

  /* MENU PRICE STYLE */

  .menu-price #menu-price {
    font-weight: 800;
    font-size: 19px;
  }

  .menu-price .total-menu-price-title {
    font-size: 13px;
  }

  .menu-listing {
    height: 300px;
    padding: 20px;
    display: flex;
    justify-content: center;
    background: gray;
    background: linear-gradient(180deg, rgba(255, 255, 255, 0.00) -31.53%, #F54748 700%);
  }

  .menu-listing img {
    border-radius: 100%;
    width: 198px;
    height: 198px;
  }

  .menu-listing svg {
    position: absolute;
    left: -10px;
    top: -25px;
  }

  .food-ractangle {
    margin: 16px;
    padding: 36px;
    border-radius: 8px;
    border: 0.5px solid #E6E6E6;
    background: #F54748;
    box-shadow: 0px 87px 83px 0px rgba(0, 0, 0, 0.06);
    color: #ffffff;
  }

  .food-ractangle a.btn {
    border-radius: 41px;
    background: #FFF;
    color: #F54748;
  }

  .custom-control-description {
    color: #272727;
    font-family: "Poppins", sans-serif;
    font-size: 16px;
    font-style: normal;
    font-weight: 900;
    line-height: normal;
    letter-spacing: 0.16px;
    text-transform: uppercase;
  }

  .review-grid {
    display: flex;
    gap: 10px;
    align-content: center;
    align-items: center;
    height: 24px;
  }

  .star {
    padding-bottom: 12px;
  }

  .inline-grid {
    list-style: none;
  }

  ul.inline-grid {
    padding: 0;
    margin-left: 16px;
  }

  .inline-grid>li {
    display: inline-block;
    padding-bottom: 10px;
  }

  .rounded-img {
    border-radius: 50%;
    border: 1px solid white;
    margin-left: -20px;
  }

  .review-grid p {
    font-family: Poppins;
    font-weight: 600;
  }

  .main-img img {
    border-radius: 50%;
    width: 198px;
    height: 198px;
    position: absolute;
    top: -100px;
    right: 19%;
  }

  .restaurant-body {
    display: flex;
    flex-direction: column;
    align-content: center;
    padding: 0 20px 20px 20px;
  }

  .featured-responsive-card {
    margin-top: 150px;
    margin-bottom: 100px;
  }

  .featured-title-box a {
    color: var(--Style, #F54748);
    font-feature-settings: 'clig' off, 'liga' off;
    font-family: Poppins;
    font-size: 24px;
    font-style: normal;
    font-weight: 900;
    line-height: normal;
    text-transform: capitalize;
  }

  .menu-price-section p {
    opacity: 0.8;
    color: var(--Style, #191919);
    font-feature-settings: 'clig' off, 'liga' off;
    font-family: Poppins;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    text-transform: capitalize;
  }

  .bg-gradient-primary {
    background: linear-gradient(180deg, rgba(255, 255, 255, 0.00) -31.53%, #F54748 303.75%);
    border-radius: 20px;
  }

  .booking-checkbox_wrap {
    background: transparent;
  }

  .menu-price {
    color: #000;
    font-feature-settings: 'clig' off, 'liga' off;
    font-family: Hellix;
    font-size: 14px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
    text-transform: capitalize;
  }

  .closed-now {
    width: 14px;
  }
  price-box
  /* Nav fixation .owl-carousel */
  .owl-carousel {
    z-index: unset;
  }

  .product-tile {

  }

  .product-tile .options-list li {
    font-weight: normal;
    font-size: 14px;
    line-height: normal;
  }
</style>