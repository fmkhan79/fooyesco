<!-- Initializer -->
<script src="<?php echo base_url('assets/backend/'); ?>js/init.js"></script>

<!-- IMAGE PREVIEW -->
<script src="<?php echo base_url('assets/backend/'); ?>js/file-upload-preview.js"></script>

<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRluKUOUHip7mS2d-BWqzfXpIu--VXroo&callback=initMap&libraries=places&v=weekly"
    defer></script>


<!-- Custom script for init select2 -->
<script type="text/javascript">
    "use strict";

    // FOR LOADING THE IMAGE FOR WEBSITE GALLERY SECTION. I'VE DONE THIS FOR AVOIDING INLINE CSS.
    initPreviewer(['image_preview']);
</script>

<script>
console.log('map script loaded!')

function initMap() {
    const map = new google.maps.Map(document.getElementById("map"), {
        center: {
            lat: 40.749933,
            lng: -73.98633
        },
        zoom: 13,
        mapTypeControl: false,
    });
    console.log(map, 'map created');
    const card = document.getElementById("pac-card");
    const input = document.getElementById("address_one");
    console.log(input)
    const biasInputElement = document.getElementById("use-location-bias");
    const strictBoundsInputElement = document.getElementById("use-strict-bounds");
    const options = {
        fields: ["formatted_address", "geometry", "name"],
        strictBounds: false,
    };

    map.controls[google.maps.ControlPosition.TOP_LEFT].push(card);

    const autocomplete = new google.maps.places.Autocomplete(input, options);

    console.log(autocomplete, 'autocomplete created');


    // Bind the map's bounds (viewport) property to the autocomplete object,
    // so that the autocomplete requests use the current map bounds for the
    // bounds option in the request.
    autocomplete.bindTo("bounds", map);

    const infowindow = new google.maps.InfoWindow();
    const infowindowContent = document.getElementById("infowindow-content");

    infowindow.setContent(infowindowContent);

    const marker = new google.maps.Marker({
        map,
        anchorPoint: new google.maps.Point(0, -29),
    });

    autocomplete.addListener("place_changed", () => {
        infowindow.close();
        marker.setVisible(false);

        const place = autocomplete.getPlace();

        if (!place.geometry || !place.geometry.location) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }

        console.log(place.geometry.location.lat(), place.geometry.location.lng(), 'place.geometry', place
            .formatted_address)

        document.getElementById('latitude_1').value = place.geometry.location.lat();
        document.getElementById('longitude_1').value = place.geometry.location.lng();

        // robutus address
        //place.formatted_address
        console.log(document.getElementById('address_two'));
        document.getElementById('address_two').value = place.formatted_address;
        document.getElementById('latitude_2').value = place.geometry.location.lat();
        document.getElementById('longitude_2').value = place.geometry.location.lng();

        document.getElementById('address_three').value = place.formatted_address;
        document.getElementById('latitude_3').value = place.geometry.location.lat();
        document.getElementById('longitude_3').value = place.geometry.location.lng();

        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
        infowindowContent.children["place-name"].textContent = place.name;
        infowindowContent.children["place-address"].textContent =
            place.formatted_address;
        infowindow.open(map, marker);
    });
}

window.initMap = initMap;
</script>
