<script>
document.addEventListener("DOMContentLoaded", function () {

    const cart = [];
    const rightPanel = document.getElementById('rightPanel');
    const orderSummary = document.getElementById('orderSummary');

    /* ================================
       SHOW VARIANT PANEL
    ================================== */
    function showVariantPanel(name, price, id, hasVariant, maincatid) {

        rightPanel.innerHTML = `
          <div class="p-3">
            <button class="btn btn-sm btn-light mb-3" id="backToSummary"><i class="fas fa-arrow-left"></i> Back</button>
            <h5 class="font-weight-bold">${name}</h5>
            <p class="text-muted">Price: €. ${price.toFixed(2)}</p>

            <div id="variantArea">
              <label>Select Variant:</label>
              <select id="variantSelect" class="form-control mb-2">
                <option value="">Select...</option>
                <option value="Small">Small</option>
                <option value="Medium">Medium</option>
                <option value="Large">Large</option>
              </select>
            </div>

            <div id="dynamicSubOptions"></div>
          </div>
        `;

        // Back button
        document.getElementById('backToSummary').onclick = () => {
            rightPanel.innerHTML = '';
            rightPanel.appendChild(orderSummary);
        };

        // When user selects a variant → Load PHP sub-options
        document.getElementById("variantSelect").addEventListener("change", function () {
            if (this.value !== "") {
                loadSubOptions(maincatid);
            }
        });
    }

    /* ================================
       AJAX: LOAD SUB OPTIONS
    ================================== */
    function loadSubOptions(maincatid) {

        fetch(`<?php echo base_url("site/selected_cat_items/"); ?>${maincatid}/menu-option-1`)
            .then(response => response.json())
            .then(data => {

                if (data.status === true) {
                    document.getElementById("dynamicSubOptions").innerHTML = data.html;
                } else {
                    document.getElementById("dynamicSubOptions").innerHTML = "<p>Error loading options.</p>";
                }

            })
            .catch(err => {
                console.error(err);
                document.getElementById("dynamicSubOptions").innerHTML = "<p>Error loading options.</p>";
            });
    }

    /* ================================
       CARD CLICK → Open Variant Panel
    ================================== */
    document.querySelectorAll('.menu-card').forEach(card => {
        card.addEventListener('click', function () {
          // debugger;
            const name = this.dataset.name;
            const price = parseFloat(this.dataset.price);
            const id = this.dataset.id;
            const maincatid = this.dataset.maincatid;  

            showVariantPanel(name, price, id, 1, maincatid);
        });
    });
});
</script>
