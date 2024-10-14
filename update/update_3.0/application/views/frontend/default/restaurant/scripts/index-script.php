<!-- Magnific popup JS -->
<script src="<?php echo base_url('assets/frontend/default/js/jquery.magnific-popup.js') ?>"></script>
<!-- Swipper Slider JS -->
<script src="<?php echo base_url('assets/frontend/default/js/swiper.min.js') ?>"></script>

<!-- Leaflet JS -->
<script src="<?php echo base_url('assets/global/leaflet/leaflet.js'); ?>"></script>

<!-- INIT JS -->
<script src="<?php echo base_url('assets/frontend/default/js/init.js') ?>"></script>
<script>
  "use strict";

  var swiper = new Swiper('.swiper-container', {
    slidesPerView: 3,
    slidesPerGroup: 3,
    loop: true,
    loopFillGroupWithBlank: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });

  if ($('.image-link').length) {
    $('.image-link').magnificPopup({
      type: 'image',
      gallery: {
        enabled: true
      }
    });
  }
  if ($('.image-link2').length) {
    $('.image-link2').magnificPopup({
      type: 'image',
      gallery: {
        enabled: true
      }
    });
  }

  // INITIALIZE TOOLTIPS
  initToolTip();

  // CART OPERATIONS
  function addToCart() {
    console.log("i am haer");
    var menuId = $('#menu-id').val();
    var quantity = $('#quantity_for_menu').val();
    var variantId = $('#variant-id').val();
    var addons = $('#addons').val();
    var note = $('#note').val();
    $.ajax({
      url: '<?php echo site_url('cart/add_to_cart'); ?>',
      type: 'POST',
      data: {
        menuId: menuId,
        quantity: quantity,
        variantId: variantId,
        addons: addons,
        note: note
      },
      success: function(response) {
        console.log(response);
        if (response === "multi_restaurant") {
          toastr.warning('<?php echo site_phrase('sorry_you_can_not_order_from_multiple_restaurant'); ?>');
        } else {
          if (Math.floor(response) == response && $.isNumeric(response)) {
            $('.cart-items').text(response);
            toastr.success('<?php echo site_phrase('added_to_the_cart'); ?>');
            $(".modal").modal('hide');
          }
        }
      }
    });
  }

  // MAP INITIALIZING
  var map = L.map('map').setView([<?php echo !empty($restaurant_details['latitude']) ? floatval(sanitize($restaurant_details['latitude'])) : 0; ?>, <?php echo !empty($restaurant_details['longitude']) ? floatval(sanitize($restaurant_details['longitude'])) : 0; ?>], 16);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

  L.marker([<?php echo !empty($restaurant_details['latitude']) ? floatval(sanitize($restaurant_details['latitude'])) : 0; ?>, <?php echo !empty($restaurant_details['longitude']) ? floatval(sanitize($restaurant_details['longitude'])) : 0; ?>]).addTo(map)
    .bindPopup('<?php echo sanitize($restaurant_details['address']); ?>');

  // CHANGING QUANTITY ON INCREMENT OR DECREMENT BUTTON CLICK
  function changeQuantity(flag) {
    var currentQuantity = $("#quantity_for_menu").val();
    if (flag === 1) {
      currentQuantity++;
    } else {
      if (currentQuantity > 1) {
        currentQuantity--;
      } else {
        currentQuantity = 1;
        toastr.warning('<?php echo site_phrase('minimum_quantity_is'); ?>: 1');
      }
    }

    $("#quantity_for_menu").val(currentQuantity);
    calculateMenuPrice();
  }


  // CALCULATE MENU PRICE AFTER CHOOSING MENU VARIANTS
  function calculateMenuPrice() {
    var selectedVariants;
    var selectedAddons;
    var quantity;
    var menuId = $("#menu-id").val();

    quantity = $('#quantity_for_menu').val();

    $('input:radio').each(function() {
      if ($(this).is(':checked')) {
        selectedVariants = selectedVariants ? selectedVariants + ',' + $(this).val() : $(this).val();
      }
    });

    $('input:checkbox').each(function() {
      if ($(this).is(':checked')) {
        selectedAddons = selectedAddons ? selectedAddons + ',' + $(this).val() : $(this).val();
      }
    });

    $.ajax({
      url: '<?php echo site_url('cart/get_menu_details_with_variants_and_addons'); ?>',
      type: 'POST',
      data: {
        menuId: menuId,
        selectedVariants: selectedVariants,
        selectedAddons: selectedAddons,
        quantity: quantity
      },
      success: function(response) {
        response = JSON.parse(response);
        if (response.status) {
          $(".calculated-price").text(response.currencyCode + response.totalPrice);
          $(".calculated-price").removeClass("d-none");
          $(".fa-spinner").addClass('d-none');

          $("#menu-id").val(response.menuId);
          $("#addons").val(response.addons);
          if (response.hasVariant) {
            $("#variant-id").val(response.variantId);
            $('.pink-cart-btn').prop("disabled", false);
          }
        } else {
          $("#addons").val(null);
          $("#variant-id").val(null);
          $('.pink-cart-btn').prop("disabled", true);
          $(".calculated-price").addClass("d-none");
          $(".fa-spinner").removeClass('d-none');
        }
      }
    });
  }
</script>