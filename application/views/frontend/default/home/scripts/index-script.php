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

    jQuery(function(){
        jQuery(".grid").masonry({ itemSelector: ".grid-item" });
        
        jQuery(".filtering").on("click", "span", function () {
            var a = jQuery(".gallery").isotope({});
            var e = jQuery(this).attr("data-filter");
            a.isotope({ filter: e });
        });
        
        jQuery(".filtering").on("click", "span", function () {
            jQuery(this).addClass("active").siblings().removeClass("active");
        });
    }) 


    // INITIALIZE TOOLTIPS
    initToolTip();
</script>

<script>
console.log('map script loaded!');

function initMap() {
    const input = document.getElementById("address");
    console.log(input);

    const options = {
        fields: ["formatted_address", "geometry", "name"],
        strictBounds: false,
    };

    const autocomplete = new google.maps.places.Autocomplete(input, options);
    console.log(autocomplete, 'autocomplete created');

    autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();

        if (!place.geometry || !place.geometry.location) {
            console.warn("No details available for input: '" + place.name + "'");
            return;
        }

        console.log(
            place.geometry.location.lat(),
            place.geometry.location.lng(),
            'place.geometry',
            place.formatted_address
        );

        // Set latitude and longitude
        document.getElementById('latitude_1').value = place.geometry.location.lat();
        document.getElementById('longitude_1').value = place.geometry.location.lng();

        // Update button state
        updateButtonState();
    });

    // Update button state based on input values
    function updateButtonState() {
        const address = input.value.trim();
        const latitude = document.getElementById('latitude_1').value.trim();
        const longitude = document.getElementById('longitude_1').value.trim();
        const searchButton = document.getElementById('search-btn');
        const searchButtonmobile = document.getElementById('search-btn-mobile');


        if (address && latitude && longitude) {
            searchButton.disabled = false; // Enable button
            searchButton.classList.remove('disabled');
            searchButtonmobile.classList.remove('disabled');
        } else {
            searchButton.disabled = true; // Disable button
            searchButton.classList.add('disabled');
            searchButtonmobile.classList.add('disabled');

        }
    }

    // Listen for manual address changes to update button state
    input.addEventListener('input', updateButtonState);
}

window.initMap = initMap;
</script>