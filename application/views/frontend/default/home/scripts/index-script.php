<!-- INIT JS -->
<script src="<?php echo base_url('assets/frontend/default/js/init.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js" integrity="sha512-Zq2BOxyhvnRFXu0+WE6ojpZLOU2jdnqbrM1hmVdGzyeCa1DgM3X5Q4A/Is9xA1IkbUeDd7755dNNI/PzSf2Pew==" crossorigin="anonymous"></script>
<script src="<?php echo base_url('assets/frontend/default/js/owl.carousel.min.js') ?>"></script>

<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRluKUOUHip7mS2d-BWqzfXpIu--VXroo&callback=initMap&libraries=places&v=weekly"
    defer></script>

   
<script>

    
    "use strict";
    $(window).scroll(function() {
        // 100 = The point you would like to fade the nav in.

        if ($(window).scrollTop() > 100) {

            $('.fixed').addClass('is-sticky');

        } else {

            $('.fixed').removeClass('is-sticky');

        };
    });

    jQuery(function() {
        jQuery(".grid").masonry({
            itemSelector: ".grid-item"
        });

        jQuery(".filtering").on("click", "span", function() {
            var a = jQuery(".gallery").isotope({});
            var e = jQuery(this).attr("data-filter");
            a.isotope({
                filter: e
            });
        });

        jQuery(".filtering").on("click", "span", function() {
            jQuery(this).addClass("active").siblings().removeClass("active");
        });
    });

    jQuery('.order-detail-slider').owlCarousel({
        loop: false,
        margin: 13,
        nav: true,
        dots: false,
        autoWidth: true,
        responsive: {
            550: {
                items: 1
            },
            768: {
                items: 3
            },
            1000: {
                items: 8
            }
        }
    });

    // INITIALIZE TOOLTIPS
    initToolTip();
</script>

<script>
$(document).ready(function() {
    // Pehli category ka ID lo
    var firstCategoryId = $(".category-tab.active").data("id");
    if (firstCategoryId) {
        loadRestaurants(firstCategoryId);
    }

    // Click event
    $(document).on('click', '.category-tab', function() {
        $(".category-tab").removeClass("active");
        $(this).addClass("active");

        var categoryId = $(this).data('id');
        loadRestaurants(categoryId);
    });

    // Load function
    function loadRestaurants(categoryId) {
        $.ajax({
            url: "<?php echo site_url('site/get_restaurants_by_category/'); ?>" + categoryId,
            type: "GET",
            beforeSend: function() {
                $("#restaurant-list").html('<p class="text-center">Loading...</p>');
            },
            success: function(response) {
                $("#restaurant-list").html(response);
            },
            error: function() {
                $("#restaurant-list").html('<p class="text-danger text-center">Failed to load restaurants.</p>');
            }
        });
    }
});
        window.console = {
    log: function() {},
    warn: function() {},
    error: function() {},
    info: function() {}
};
    console.log('map script loaded!');

    function initMap() {
        // Check if the page has elements for both address inputs
        const inputMobile = document.getElementById("address");
        const inputScreen = document.getElementById("address-sc");
        
        // Initialize autocomplete for mobile address input
        if (inputMobile) {
            const optionsMobile = {
                fields: ["formatted_address", "geometry", "name"],
                strictBounds: false,
            };

            const autocompleteMobile = new google.maps.places.Autocomplete(inputMobile, optionsMobile);
            console.log(autocompleteMobile, 'autocomplete mobile created');

            autocompleteMobile.addListener("place_changed", () => {
                const place = autocompleteMobile.getPlace();

                if (!place.geometry || !place.geometry.location) {
                    console.warn("No details available for input: '" + place.name + "'");
                    return;
                }

                console.log(
                    place.geometry.location.lat(),
                    place.geometry.location.lng(),
                    'place.geometry mobile',
                    place.formatted_address
                );

                // Set latitude and longitude for mobile input
                document.getElementById('latitude_1').value = place.geometry.location.lat();
                document.getElementById('longitude_1').value = place.geometry.location.lng();

                // Update button state for mobile
                updateButtonState(inputMobile, 'latitude_1', 'longitude_1', 'search-btn');
            });

            // Listen for manual address changes on mobile input to update button state
            inputMobile.addEventListener('input', () => updateButtonState(inputMobile, 'latitude_1', 'longitude_1', 'search-btn'));
        }

        // Initialize autocomplete for screen address input
        if (inputScreen) {
            const optionsScreen = {
                fields: ["formatted_address", "geometry", "name"],
                strictBounds: false,
            };

            const autocompleteScreen = new google.maps.places.Autocomplete(inputScreen, optionsScreen);
            console.log(autocompleteScreen, 'autocomplete screen created');

            autocompleteScreen.addListener("place_changed", () => {
                const place = autocompleteScreen.getPlace();

                if (!place.geometry || !place.geometry.location) {
                    console.warn("No details available for input: '" + place.name + "'");
                    return;
                }

                console.log(
                    place.geometry.location.lat(),
                    place.geometry.location.lng(),
                    'place.geometry screen',
                    place.formatted_address
                );

                // Set latitude and longitude for screen input
                document.getElementById('latitude_sc').value = place.geometry.location.lat();
                document.getElementById('longitude_sc').value = place.geometry.location.lng();

                // Update button state for screen
                updateButtonStatesc(inputScreen, 'latitude_sc', 'longitude_sc', 'searchsc' ,'searchwc');
            });

            // Listen for manual address changes on screen input to update button state
            inputScreen.addEventListener('input', () => updateButtonStatesc(inputScreen, 'latitude_sc', 'longitude_sc', 'searchsc' ,'searchwc'));
        }
    }

     // CART OPERATIONS
    function addToCart(menu_id, price, isButton, restaurantSlug, restId) {
        if(
            menu_id != undefined && //If click on when have no variant
            isButton == false && // clicked on div
            window.innerWidth > 450
        ){
            return;
        }

        if(
            window.innerWidth < 450 && 
            menu_id != undefined && //If click on when have no variant
            isButton == true // clicked on div
            
        ){
            return;
        }

        var menuId = menu_id || $('#menu-id').val();

        var quantity = menu_id == undefined || null ? $('#quantity_for_menu').val() : 1;

        var totalprice = price || $('#totalprice').val();

        var variantId = $("input[name=variant]:checked").val() || 0;
        var addons = $('#addons').val() || "";
        var note = $('#note').val() || "";

        // Initialize arrays to store selected items
        var selectedItemsArray1 = [];
        var selectedItemsArray2 = [];
        var selectedItemsArrayOptional = [];

        // Function to collect selected items
        function collectSelectedItems(selector, array) {
            var selectedItems = $(selector);
            selectedItems.each(function() {
                var subVariantId = $(this).data('sub-variant-id');
                var itemId = $(this).data('item-id');
                array.push({
                    subVariantId: subVariantId,
                    itemId: itemId
                });
                console.log('Data Sub Variant ID:', subVariantId);
                console.log('Data Item ID:', itemId);
            });
        }

        // collect items
        collectSelectedItems('.menu-option-1 .required-item:checked', selectedItemsArray1);
        collectSelectedItems('.menu-option-2 .required-item:checked', selectedItemsArray2);
        collectSelectedItems('.menu-option-1 .optional-item:checked', selectedItemsArrayOptional);

        // Merge selectedItemsArray1 and selectedItemsArrayOptional
        var mergedSelectedItemsArray1 = selectedItemsArray1.concat(selectedItemsArrayOptional);

        // Convert the arrays to JSON strings
        var jsonStringSelectedItems1 = JSON.stringify(mergedSelectedItemsArray1);
        var jsonStringSelectedItems2 = JSON.stringify(selectedItemsArray2);

        console.log('jsonStringSelectedItems1:', jsonStringSelectedItems1);
        console.log('jsonStringSelectedItems2:', jsonStringSelectedItems2);

        // AJAX request to add items to the cart
        $.ajax({
            url: '<?php echo site_url('cart/add_to_cart'); ?>',
            type: 'POST',
            data: {
                menuId: menuId,
                quantity: quantity,
                variantId: variantId,
                addons: addons,
                note: note,
                totalprice: totalprice,
                options_1: jsonStringSelectedItems1,
                options_2: jsonStringSelectedItems2
            },
            success: function(response) {
                if (response === "multi_restaurant") {
                    toastr.warning(
                        '<?php echo site_phrase('sorry_you_can_not_order_from_multiple_restaurant'); ?>');
                } else {
                    if (Math.floor(response) == response && $.isNumeric(response)) {
                        $('.cart-items').text(response);
                        toastr.success('<?php echo site_phrase('added_to_the_cart'); ?>');
                        $(".modal").modal('hide');
                        window.location.href = "<?= base_url() ?>site/restaurant/" + restaurantSlug + "/" + restId;
                    }
                }
            }
        });
    }

     function viewselected_menu(menuid, menuprice, hasvariant, isButton) {
        if(hasvariant == 0){

            addToCart(menuid, menuprice,isButton);
            return;
        }

        let url = '<?php echo base_url(); ?>site/selected_menu/' + menuid;

        $.ajax({
            url: url,
            success: function(res) {
                $("#getdetails_selected_menu").html(res);
                // console.log(res); 
                $('#popup').modal('show');
                calculatePrice();
            },
            error: function() {
                // alert("<?php echo $this->lang->line('fail'); ?>")
            }
        });

        // holdModal('popup');
    }

    function handleOrderNow(menuId, menuPrice, hasVariant, restaurantSlug, restId) {
    if (hasVariant == 0) {
        // Agar variant nahi hai → direct add to cart
        addToCart(menuId, menuPrice, true, restaurantSlug, restId);
    } else {
        // Agar variant hai → pehle restaurant page open karo aur uske baad popup dikhana
        let restaurantUrl = "<?= base_url() ?>site/restaurant/" + restaurantSlug + "/" + restId + "#menu-" + menuId;
        window.location.href = restaurantUrl;
    }

    function handleCuisine(restaurantSlug, restId, categoryName){
        let restaurantUrl = "<?= base_url() ?>site/restaurant/" + restaurantSlug + "/" + restId + "#" + categoryName;
        window.location.href = restaurantUrl;
    }
}


    // Update button state for mobile map
    function updateButtonState(input, latId, longId, buttonId) {
        const address = input.value.trim();
        const latitude = document.getElementById(latId).value.trim();
        const longitude = document.getElementById(longId).value.trim();
        const searchButton = document.getElementById(buttonId);

        if (address && latitude && longitude) {
            searchButton.disabled = false;
            searchButton.classList.remove('disabled');
        } else {
            searchButton.disabled = true;
            searchButton.classList.add('disabled');
        }
    }

    // Update button state for screen map
    function updateButtonStatesc(input, latId, longId, buttonId ,orderId) {
        const address = input.value.trim();
        const latitude = document.getElementById(latId).value.trim();
        const longitude = document.getElementById(longId).value.trim();
        const searchButton = document.getElementById(buttonId);
        const orderButton = document.getElementById(orderId);


        if (address && latitude && longitude) {
            searchButton.disabled = false;
            searchButton.classList.remove('disabled');
            orderButton.classList.remove('disabled');

        } else {
            searchButton.disabled = true;
            searchButton.classList.add('disabled');
            orderButton.classList.add('disabled');

        }
    }

    window.initMap = initMap;

    window.onload = function () {
        if (!getCookie("cookieConsent")) {
            document.getElementById("cookie-banner").style.display = "block";
        }
    };

    // Accept handler
    function acceptCookies() {
        setCookie("cookieConsent", "accepted", 30);
        document.getElementById("cookie-banner").style.display = "none";
    }

    // Ignore handler
    function ignoreCookies() {
        setCookie("cookieConsent", "ignored", 30);
        document.getElementById("cookie-banner").style.display = "none";
    }

    // Set cookie
    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        const expires = "expires=" + date.toUTCString();
        document.cookie = name + "=" + encodeURIComponent(value) + ";" + expires + ";path=/";
    }

    // Get cookie
    function getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i].trim();
            if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length));
        }
        return null;
    }


</script>
