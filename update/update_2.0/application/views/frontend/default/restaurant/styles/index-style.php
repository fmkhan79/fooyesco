<!-- Swipper Slider -->
<link rel="stylesheet" href="<?php echo base_url('assets/frontend/default/css/swiper.min.css'); ?>">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/frontend/default/css/magnific-popup.css'); ?>">

<!-- LEAFLET CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/global/leaflet/leaflet.css'); ?>">

<style media="screen">
  .food-item-card {
    box-shadow: 0px 3px 40px 0 rgba(206, 205, 205, 0.3);
  }

  .reserve-rating {
    margin-top: -6px;
    font-size: 18px;
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
    position: absolute;
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
</style>