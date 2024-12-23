<!-- INIT JS -->
<script src="<?php echo base_url('assets/frontend/default/js/init.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js" integrity="sha512-Zq2BOxyhvnRFXu0+WE6ojpZLOU2jdnqbrM1hmVdGzyeCa1DgM3X5Q4A/Is9xA1IkbUeDd7755dNNI/PzSf2Pew==" crossorigin="anonymous"></script>

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
    })


    // INITIALIZE TOOLTIPS
    initToolTip();
</script>

<script>
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
                updateButtonStatesc(inputScreen, 'latitude_sc', 'longitude_sc', 'searchsc');
            });

            // Listen for manual address changes on screen input to update button state
            inputScreen.addEventListener('input', () => updateButtonStatesc(inputScreen, 'latitude_sc', 'longitude_sc', 'searchsc'));
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
    function updateButtonStatesc(input, latId, longId, buttonId) {
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

    window.initMap = initMap;
</script>
