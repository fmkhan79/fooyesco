<style>
.callout-none {
    border: 1px solid #e0e0e0 !important;
    border-left-width: 1px !important;
}

.payment-gateways img {
    height: 60px;
}

.payment-gateways .callout {
    margin: 5px 0px;
}

label {
    width: 100%;
}


.form-control.invalid {
        border-color: red;
    }


input[type=radio] {
    display: none;
}


.product-tile {
    width: 9rem;
}

.options-list li {
    font-weight: normal;
    font-size: 14px;
    line-height: normal;
}


.cart-btns {
    height: 24px;
    width: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    border-radius: 6px;
    border: 1px solid #F54747;
}


/* IMAGE TYPE SELECTOR */
.order-delivery-types {
    border: 1px solid #dedede87;
    height: 50px;
    border-radius: 4px;
}

.order-delivery-types input {
    margin: 0;
    padding: 0;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.order-type-delivery {
    background-image: url(<?php echo base_url('assets/frontend/default/images/delivery.png');
    ?>);
    background-position: center;
}

.order-type-pickup {
    background-image: url(<?php echo base_url('assets/frontend/default/images/pickup.png');
    ?>);
    background-position: center;
}

.order-delivery-types input:active+.order-delivery-type-label {
    opacity: .9;
}

.order-delivery-types input:checked+.order-delivery-type-label {
    -webkit-filter: none;
    -moz-filter: none;
    filter: none;
    background-color: rgb(0 233 7 / 20%);
}

.order-delivery-type-label {
    cursor: pointer;
    background-size: contain;
    background-repeat: no-repeat;
    display: inline-block;
    width: 100px;
    height: 50px;
    -webkit-transition: all 100ms ease-in;
    -moz-transition: all 100ms ease-in;
    transition: all 100ms ease-in;
    -webkit-filter: brightness(1.8) grayscale(1) opacity(.7);
    -moz-filter: brightness(1.8) grayscale(1) opacity(.7);
    filter: brightness(1.8) grayscale(1) opacity(.7);
    margin-bottom: 0px;
    border-radius: 4px;
}

.order-delivery-type-label:hover {
    -webkit-filter: brightness(1.2) grayscale(.5) opacity(.9);
    -moz-filter: brightness(1.2) grayscale(.5) opacity(.9);
    filter: brightness(1.2) grayscale(.5) opacity(.9);
}

/* Extras */
a:visited {
    color: #888
}

a {
    color: #444;
    text-decoration: none;
}

p {
    margin-bottom: .3em;
}


/* OVERLAY */
.order-type {
    width: 65px;
    width: 65px;
    background-color: rgb(204 251 205);
    border-radius: 4px;
    font-size: 13px;
    text-align: center !important;
    font-weight: 600 !important;
}

.order-type-overlay {
    height: 50px;
    position: absolute;
    width: 100px;
    background-color: rgb(97, 97, 97, 0.26);
}

.order-type-overlay p {
    margin-top: 32px;
    text-align: center;
    font-size: 12px;
    font-weight: bold;
    letter-spacing: 5px;
    text-transform: uppercase;
    color: #fff;
    opacity: 0.7;
    background-color: rgb(66, 66, 66, 0.8);
}

ul.billing-list-topbar li img.billing-active {
    display: none;
}

ul.billing-list-topbar li.acitve img.billing-active {
    display: block;
}

ul.billing-list-topbar li.acitve img.billing-notactive {
    display: none;
}

ul.billing-list-topbar li .img-box {
    cursor: pointer;
}

#payment-option,
#your-address {
    display: none;
}

.payment-option {
      display: flex;
      align-items: center;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 8px;
      margin-bottom: 8px;
      cursor: pointer;
      transition: background-color 0.2s ease;
    }
    .payment-option input[type="radio"] {
      margin-right: 10px;
    }
    .payment-option img {
      width: 24px;
      height: auto;
      margin-right: 10px;
    }
</style>