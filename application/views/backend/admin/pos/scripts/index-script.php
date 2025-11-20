<script>
document.addEventListener("DOMContentLoaded", function () {

    const rightPanel = document.getElementById('rightPanel');
    const orderSummary = document.getElementById('orderSummary');
    const baseUrl = '<?php echo base_url(); ?>';

    /* ---------------------------------
       LOAD SUB-OPTIONS (EXTRAS)
    ----------------------------------- */
    function loadSubOptions(maincatid, menu_option, containerId) {
        const container = document.getElementById(containerId);

        container.innerHTML = `
            <div class="text-center p-3">
                <i class="fas fa-spinner fa-spin"></i> Loading...
            </div>
        `;

        fetch(`${baseUrl}site/selected_cat_items/${maincatid}/${menu_option}`)
            .then(res => res.text())
            .then(html => {
                container.innerHTML = html;

                // Attach event listener to ALL extras
                container.querySelectorAll('.extra-option').forEach(cb => {
                    cb.addEventListener('change', () => updateCartTotal());
                });
            })
            .catch(err => {
                console.error("Error loading sub-options:", err);
                container.innerHTML = `<p class="text-danger text-center">Failed to load options.</p>`;
            });
    }

    /* ---------------------------------
       SHOW VARIANT PANEL
    ----------------------------------- */
    function showVariantPanel(name, basePrice, id, hasVariant, maincatid, variants) {
        let variantOptions = "";
        let dynamicContainers = "";

        if (hasVariant == 1 && variants.length > 0) {
            variantOptions = `<option value="">Select...</option>`;

            variants.forEach(v => {
                let extraPrice = parseFloat(v.price) || 0;
                variantOptions += `
                    <option value="${v.id}" data-price="${extraPrice}">
                        ${v.name} (+€${extraPrice.toFixed(2)})
                    </option>
                `;

                dynamicContainers += `
                    <div id="variant-box-${v.id}" class="dynamic-sub-option-container" style="display:none;"></div>
                `;
            });
        }

        rightPanel.innerHTML = `
            <div class="p-3">
                <button class="btn btn-light btn-sm mb-3" id="backToSummary">
                    <i class="fas fa-arrow-left"></i> Back
                </button>

                <h5 class="font-weight-bold">${name}</h5>

                <p class="text-muted">
                    Price: € <span id="variantPrice" data-baseprice="${basePrice}">
                        ${basePrice.toFixed(2)}
                    </span>
                </p>

                ${hasVariant ? `
                <div id="variantArea" class="mb-3">
                    <label class="font-weight-bold">Select Variant:</label>
                    <select id="variantSelect" class="form-control">
                        ${variantOptions}
                    </select>
                </div>` : ""}

                <div id="dynamicSubOptionsArea">${dynamicContainers}</div>

                <!-- CART DISPLAY -->
                <div id="cartItemsContainer" class="mt-3 p-2 border rounded"></div>
            </div>
        `;

        // back
        document.getElementById('backToSummary').onclick = () => {
            rightPanel.innerHTML = "";
            rightPanel.appendChild(orderSummary);
        };

        // Variant selection handler
        const variantSelect = document.getElementById("variantSelect");

        if (variantSelect) {
            variantSelect.addEventListener("change", function () {
                let selected = this.options[this.selectedIndex];
                let addPrice = parseFloat(selected.dataset.price || 0);

                let newBase = basePrice + addPrice;

                let priceSpan = document.getElementById("variantPrice");
                priceSpan.dataset.baseprice = newBase.toFixed(2);
                priceSpan.innerText = newBase.toFixed(2);

                // Hide all containers
                document.querySelectorAll('.dynamic-sub-option-container')
                    .forEach(box => box.style.display = "none");

                // Show selected
                if (this.value) {
                    let boxId = "variant-box-" + this.value;
                    document.getElementById(boxId).style.display = "block";
                    loadSubOptions(maincatid, this.value, boxId);
                }

                updateCartTotal();
            });
        }

        // NO VARIANT
        updateCartTotal();
    }

    /* ---------------------------------
       CALCULATE TOTAL
    ----------------------------------- */
   function updateCartTotal() {
    let cartBox = document.getElementById('cartItemsContainer');
    if (!cartBox) return;

    // Base / variant price
    let priceSpan = document.getElementById("variantPrice");
    let basePrice = parseFloat(priceSpan.dataset.baseprice) || 0;

    let extrasTotal = 0;
    let selectedExtras = [];

    // FIXED: read your actual extras
    document.querySelectorAll('.optional-item:checked').forEach(cb => {
        let p = parseFloat(cb.dataset.itemPrice) || 0; // Use data-item-price
        extrasTotal += p;

        let label = cb.closest('.choice-box')?.querySelector("label")?.innerText || "Extra";
        selectedExtras.push(`${label} (+£${p.toFixed(2)})`);
    });

    let total = basePrice + extrasTotal;

    // Update price shown
    priceSpan.innerText = total.toFixed(2);

    // Update cart preview
    cartBox.innerHTML = `
        <strong>Selected Item</strong><br>
        ${selectedExtras.length > 0 ? selectedExtras.join("<br>") : "No extras selected."}
        <div class="text-right mt-2 text-danger fw-bold">£${total.toFixed(2)}</div>
    `;

    // Update totals summary
    document.getElementById('orderTotals').style.display = 'block';
    document.getElementById('subtotal').innerText = `£${total.toFixed(2)}`;

    let service = parseFloat(document.getElementById('service').innerText.replace("£", "")) || 0;
    let bag = parseFloat(document.getElementById('bag').innerText.replace("£", "")) || 0;
    let delivery = parseFloat(document.getElementById('delivery').innerText.replace("£", "")) || 0;

    let grand = total + delivery + service + bag;

    document.getElementById('grandTotal').innerText = `£${grand.toFixed(2)}`;
}



    /* ---------------------------------
       ATTACH CLICK TO MENU CARDS
    ----------------------------------- */
    document.querySelectorAll('.menu-card').forEach(card => {
        card.addEventListener('click', function () {
            const name = this.dataset.name;
            const price = parseFloat(this.dataset.price);
            const id = this.dataset.id;
            const maincatid = this.dataset.maincatid;
            const hasVariant = parseInt(this.dataset.hasVariant);
            const variants = JSON.parse(this.dataset.variants);

            showVariantPanel(name, price, id, hasVariant, maincatid, variants);
        });
    });

});
</script>
