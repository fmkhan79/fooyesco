<script>
const baseUrl = '<?php echo base_url(); ?>';
let cartItems = []; // Global cart

document.addEventListener("DOMContentLoaded", function () {

    const rightPanel = document.getElementById('rightPanel');
    const orderSummary = document.getElementById('orderSummary');

    // -------------------------
    // LOAD SUB-OPTIONS (Extras)
    // -------------------------
    function loadSubOptions(maincatid, menu_option, containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;

        container.innerHTML = `<div class="text-center p-3"><i class="fas fa-spinner fa-spin"></i> Loading...</div>`;

        fetch(`${baseUrl}site/selected_cat_items/${maincatid}/${menu_option}`)
            .then(res => res.text())
            .then(html => {
                container.innerHTML = html;

                // Extras checkboxes
                container.querySelectorAll('.optional-item').forEach(cb => {
                    cb.addEventListener('change', updateVariantPanelTotal);
                });
            })
            .catch(err => {
                console.error(err);
                container.innerHTML = `<p class="text-danger text-center">Failed to load options.</p>`;
            });
    }

    // -------------------------
    // SHOW VARIANT PANEL
    // -------------------------
    function showVariantPanel(name, basePrice, id, hasVariant, maincatid, variants) {
        let variantOptions = "";
        let dynamicContainers = "";

        if (hasVariant == 1 && variants.length > 0) {
            variantOptions = `<option value="">Select...</option>`;
            variants.forEach(v => {
                const extraPrice = parseFloat(v.price) || 0;
                variantOptions += `<option value="${v.id}" data-price="${extraPrice}">${v.name} (+€${extraPrice.toFixed(2)})</option>`;
                dynamicContainers += `<div id="variant-box-${v.id}" class="dynamic-sub-option-container" style="display:none;"></div>`;
            });
        }

        rightPanel.innerHTML = `
            <div class="p-3">
                <button class="btn btn-light btn-sm mb-3" id="backToSummary"><i class="fas fa-arrow-left"></i> Back</button>
                <h5 class="font-weight-bold">${name}</h5>
                <p class="text-muted">Price: € <span id="variantPrice" data-baseprice="${basePrice}">${basePrice.toFixed(2)}</span></p>
                ${hasVariant ? `<div id="variantArea" class="mb-3">
                    <label>Select Variant:</label>
                    <select id="variantSelect" class="form-control">${variantOptions}</select>
                </div>` : ""}
                <div id="dynamicSubOptionsArea">${dynamicContainers}</div>
                <div class="mt-3">
                    <button class="btn btn-primary w-100" id="addToCartBtn">Add to Cart</button>
                </div>
            </div>
        `;

        // Back button
        const backBtn = document.getElementById('backToSummary');
        if(backBtn){
            backBtn.addEventListener('click', () => {
                rightPanel.innerHTML = "";
                rightPanel.appendChild(orderSummary);
                updateOrderSummary();
            });
        }

        // Variant selection
        const variantSelect = document.getElementById('variantSelect');
        if(variantSelect){
            variantSelect.addEventListener('change', function(){
                const selected = this.options[this.selectedIndex];
                const addPrice = parseFloat(selected.dataset.price || 0);
                const priceSpan = document.getElementById('variantPrice');
                if(priceSpan){
                    const newPrice = basePrice + addPrice;
                    priceSpan.dataset.baseprice = newPrice.toFixed(2);
                    priceSpan.innerText = newPrice.toFixed(2);
                }

                // Show selected variant extras
                document.querySelectorAll('.dynamic-sub-option-container').forEach(box => box.style.display="none");
                if(this.value){
                    const box = document.getElementById('variant-box-'+this.value);
                    if(box) {
                        box.style.display = "block";
                        loadSubOptions(maincatid, this.value, box.id);
                    }
                }
                updateVariantPanelTotal();
            });
        }

        // Add to Cart
        const addBtn = document.getElementById('addToCartBtn');
        if(addBtn){
            addBtn.addEventListener('click', () => {
                const selectedVariantId = variantSelect ? variantSelect.value : 0;
                const priceSpan = document.getElementById('variantPrice');
                const base = priceSpan ? parseFloat(priceSpan.dataset.baseprice) : 0;

                // Extras
                const selectedExtras = [];
                let extrasTotal = 0;
                document.querySelectorAll('.optional-item:checked').forEach(cb=>{
                    selectedExtras.push(cb.closest('.choice-box')?.querySelector('label')?.innerText || "Extra");
                    extrasTotal += parseFloat(cb.dataset.itemPrice) || 0;
                });

                cartItems.push({
                    name: name + (selectedVariantId ? ` (Variant ${selectedVariantId})` : ""),
                    extras: selectedExtras,
                    price: base + extrasTotal,
                    quantity: 1
                });

                updateOrderSummary();
                alert("Item added to cart!");
            });
        }
    }

    // -------------------------
    // Update Variant Price
    // -------------------------
    function updateVariantPanelTotal(){
        const priceSpan = document.getElementById('variantPrice');
        if(!priceSpan) return;

        let base = parseFloat(priceSpan.dataset.baseprice) || 0;
        let extrasTotal = 0;
        document.querySelectorAll('.optional-item:checked').forEach(cb=>{
            extrasTotal += parseFloat(cb.dataset.itemPrice) || 0;
        });

        priceSpan.innerText = (base + extrasTotal).toFixed(2);
    }

    // -------------------------
    // Update Order Summary
    // -------------------------
    function updateOrderSummary(){
        const cartBox = document.getElementById('cartItemsContainer');
        const orderTotals = document.getElementById('orderTotals');
        if(!cartBox || !orderTotals) return;

        if(cartItems.length===0){
            cartBox.innerHTML = `<p class="text-muted text-center" id="emptyCartMsg">No items added yet.</p>`;
            orderTotals.style.display = 'none';
            return;
        }

        let html='';
        let subtotal=0;
        cartItems.forEach(item=>{
            const total = item.price * item.quantity;
            subtotal += total;
            html += `<div class="d-flex justify-content-between mb-1">
                        <span>${item.name}${item.extras.length>0? " - "+item.extras.join(",") : ""} x${item.quantity}</span>
                        <span>€${total.toFixed(2)}</span>
                     </div>`;
        });
        cartBox.innerHTML = html;

        const service = parseFloat(document.getElementById('service')?.innerText.replace("€","")) || 0;
        const bag = parseFloat(document.getElementById('bag')?.innerText.replace("€","")) || 0;
        const discountPercent = parseFloat(document.getElementById('discountPercent')?.innerText) || 0;
        const discountAmount = subtotal * discountPercent / 100;

        document.getElementById('subtotal').innerText = `€${subtotal.toFixed(2)}`;
        document.getElementById('discountAmount').innerText = `-€${discountAmount.toFixed(2)}`;
        document.getElementById('grandTotal').innerText = `€${(subtotal+service+bag-discountAmount).toFixed(2)}`;

        orderTotals.style.display = 'block';
    }

    // -------------------------
    // Menu card click
    // -------------------------
    document.querySelectorAll('.menu-card').forEach(card=>{
        card.addEventListener('click', function(){
            const name = this.dataset.name;
            const price = parseFloat(this.dataset.price);
            const id = this.dataset.id;
            const maincatid = this.dataset.maincatid;
            const hasVariant = parseInt(this.dataset.hasVariant);
            const variants = JSON.parse(this.dataset.variants || '[]');

            showVariantPanel(name, price, id, hasVariant, maincatid, variants);
        });
    });

    // -------------------------
    // Place Order
    // -------------------------
    const placeOrderBtn = document.getElementById('placeOrderBtn');
    if(placeOrderBtn){
        placeOrderBtn.addEventListener('click', ()=>{
            if(cartItems.length===0){
                alert("Cart is empty!");
                return;
            }

            $.ajax({
                url: `${baseUrl}pos/cash_on_delivery`,
                method: "POST",
                data: { items: cartItems },
                success: function(response){
                    alert("Order placed successfully!");
                    cartItems=[];
                    updateOrderSummary();
                },
                error: function(xhr){
                    console.error(xhr.responseText);
                    alert("Failed to place order.");
                }
            });
        });
    }

});
</script>
