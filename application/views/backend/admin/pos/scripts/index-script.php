

<script>
const baseUrl = '<?php echo base_url(); ?>';
let cartItems = []; // Global cart
const posCustomerId = 1001; // POS terminal ID

function updateVariantSelect(variant_id,elem) {
    
    document.querySelectorAll('.variant-select-btn').forEach(btn => btn.classList.remove('active'));

    elem.classList.add('active');
    const variantSelect = document.getElementById('variantSelect');
    if (variantSelect) {
        variantSelect.value = variant_id; // set value based on button text
        variantSelect.dispatchEvent(new Event('change')); // trigger change event
    }
}


document.addEventListener("DOMContentLoaded", function () {

    const rightPanel = document.getElementById('rightPanel');
    const orderSummary = document.getElementById('orderSummary');
    const productOptionsContainer = document.getElementById('product-options-container');
    const placeOrderBtn = document.getElementById('placeOrderBtn');
    const orderSummaryBtn = document.getElementById("orderSummaryBtn");
    const variantBtn = document.getElementById("variantBtn");

    if(orderSummaryBtn){
        orderSummaryBtn.addEventListener('click', () => {

                orderSummaryBtn.classList.add('active');
                variantBtn.classList.remove('active');

                productOptionsContainer.innerHTML = "";
                productOptionsContainer.style.display = "none";
                orderSummary.style.display = "block";
            });
    }
    // if(variantBtn){
    //     variantBtn.addEventListener('click', () => {
    //         show
    //         });
    // }

    // -------------------------
    // SHOW VARIANT PANEL
    // -------------------------
  function showVariantPanel(name, basePrice, menuId, hasVariant, maincatid, variants) {
    // debugger;
    productOptionsContainer.innerHTML = ""; // clear previous variant panel
    productOptionsContainer.style.display = "block";

    let variantOptions = "";
    let dynamicContainers = "";

    // Check for variants and construct variant options
    if (hasVariant == 1 && variants.length > 0) {
        variantOptions = `<option value="">Select...</option>`;
        variants.forEach(v => {
            const extraPrice = parseFloat(v.price) || 0;
            variantOptions += `<option value="${v.id}" data-price="${extraPrice}">${v.name} (+€${extraPrice.toFixed(2)})</option>`;
            dynamicContainers += `<div id="variant-box-${v.id}" class="dynamic-sub-option-container" style="display:none;"></div>`;
        });
    }

    // Generate button HTML for variant options
    let variantOptionForButton = variantOptions.split("<option").slice(2);
    let buttonHTML = "";
    variantOptionForButton.forEach(function(element, index){
        let name = element.split(">")[1].split("<")[0];
        let [escaped_name] = name.split("("); 
        let value = element.match(/value="([^"]+)"/)[1];
        let price = name.split(")")[0].split("(")[1];
        buttonHTML += `<button class="variant-select-btn" onclick="updateVariantSelect(${value},this)">
            ${escaped_name}
            <br><small>${price}</small>
        </button>`;
    });

    // Render the product options container
    productOptionsContainer.innerHTML = `
        <div class="">
            <button class="btn btn-light btn-sm mb-3" id="backToSummary"><i class="fas fa-arrow-left"></i> Back</button>
            <h5 class="font-weight-bold">${name}</h5>
            ${hasVariant ? `<div id="variantArea" class="mb-3">
                <div style="display:flex; flex-wrap:wrap;gap:10px;">
                ${buttonHTML}
                </div>
                <select id="variantSelect" class="form-control" style="display:none">${variantOptions}</select>
            </div>` : ""}
            <div id="dynamicSubOptionsArea">${dynamicContainers}</div>
            <div class="mt-3">
                <button class="btn btn-primary w-100" style="display:none" id="addToCartBtn">Add to Cart</button>
            </div>
        </div>
    `;

    // Ensure base price is displayed even when no variants are present
    const priceSpan = document.getElementById('variantPrice');
    if (priceSpan) {
        priceSpan.dataset.baseprice = basePrice.toFixed(2);
        priceSpan.innerText = basePrice.toFixed(2);
    }

    // Hide order summary while variant panel is open
    orderSummary.style.display = "none";

    // Back button functionality
    const backBtn = document.getElementById('backToSummary');
    if (backBtn) {
        backBtn.addEventListener('click', () => {
            productOptionsContainer.innerHTML = "";
            productOptionsContainer.style.display = "none";
            orderSummary.style.display = "block";
        });
    }

    // Variant selection handling
    const variantSelect = document.getElementById('variantSelect');
    if (variantSelect) {
        variantSelect.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            const addPrice = parseFloat(selected.dataset.price || 0);
            if (priceSpan) {
                const newPrice = basePrice + addPrice;
                priceSpan.dataset.baseprice = newPrice.toFixed(2);
                priceSpan.innerText = newPrice.toFixed(2);
            }

            // Show selected variant extras
            document.querySelectorAll('.dynamic-sub-option-container').forEach(box => box.style.display = "none");
            if (this.value) {
                const box = document.getElementById('variant-box-' + this.value);
                if (box) {
                    box.style.display = "block";
                    loadSubOptions(maincatid, this.value, box.id);
                }
            }
            updateVariantPanelTotal();
        });
    }



        // Add to cart
        const addBtn = document.getElementById('addToCartBtn');
        if (addBtn) {
            addBtn.addEventListener('click', () => {
                const selectedVariantId = variantSelect ? variantSelect.value : 0;
                const priceSpan = document.getElementById('variantPrice');
                const base = priceSpan ? parseFloat(priceSpan.dataset.baseprice) : 0;

                // Extras
                const selectedExtras = [];
                let extrasTotal = 0;
                document.querySelectorAll('.optional-item:checked').forEach(cb => {
                    selectedExtras.push(cb.closest('.choice-box')?.querySelector('label')?.innerText || "Extra");
                    extrasTotal += parseFloat(cb.dataset.itemPrice) || 0;
                });

                // Add to JS cart
                cartItems.push({
                    name: name + (selectedVariantId ? ` (Variant ${selectedVariantId})` : ""),
                    extras: selectedExtras,
                    price: base + extrasTotal,
                    quantity: 1,
                    variantId: selectedVariantId,
                    addons: selectedExtras
                });

                updateOrderSummary();

                document.getElementById('backToSummary').click();

                // Save to backend
                $.ajax({
                    url: `${baseUrl}pos/add_to_pos_cart`,
                    method: 'POST',
                    data: {
                        pos_id: posCustomerId, // important
                        menuId: menuId,
                        quantity: 1,
                        totalprice: base + extrasTotal,
                        variantId: selectedVariantId,
                        addons: JSON.stringify(selectedExtras),
                        options_1: JSON.stringify(selectedExtras),
                        options_2: null
                    },
                    success: function (res) {
                        console.log('Saved to DB:', res);
                                updateOrderSummary();

                    },
                    error: function (err) {
                        console.error('Failed to save to DB:', err);
                    }
                });
            });
        }
    }

   
    // -------------------------
    // Load sub-options
    // -------------------------
    function loadSubOptions(maincatid, menu_option, containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;
        container.innerHTML = `<div class="text-center p-3"><i class="fas fa-spinner fa-spin"></i> Loading...</div>`;
        fetch(`${baseUrl}pos/selected_cat_items/${maincatid}/${menu_option}`)
            .then(res => res.text())
            .then(html => {
                container.innerHTML = html;
                console.log(html);
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
    // Update variant panel total
    // -------------------------
    function updateVariantPanelTotal() {
        const priceSpan = document.getElementById('variantPrice');
        const variant_name = document.getElementById('variantSelect');
        console.log(variant_name);
        console.log(priceSpan);
        if (!priceSpan) return;
        let base = parseFloat(priceSpan.dataset.baseprice) || 0;
        let extrasTotal = 0;
        document.querySelectorAll('.optional-item:checked').forEach(cb => {
            extrasTotal += parseFloat(cb.dataset.itemPrice) || 0;
        });
        priceSpan.innerText = (base + extrasTotal).toFixed(2);
    }

    // -------------------------
    // Update order summary
    // -------------------------
   async function updateOrderSummary() {
    // debugger;
    const cartBox = document.getElementById('cartItemsContainer');
    const orderTotals = document.getElementById('orderTotals');
    if (!cartBox || !orderTotals) return;

    const posId = 1001;

    const response = await fetch(`${baseUrl}pos/pos_cart_items?pos_id=${posId}`);
    const dbCartItems = await response.json();  // DB rows
    console.log(dbCartItems);
    console.log(cartItems); // JS cart
    if (!dbCartItems || dbCartItems.length === 0) {
        cartBox.innerHTML = `<p class="text-muted text-center" id="emptyCartMsg">No items added yet.</p>`;
        orderTotals.style.display = 'none';
        return;
    }

    let html = '';
    let subtotal = 0;

    dbCartItems.forEach(item => {
        const total = item.price * item.quantity;
        subtotal += total;

        html += `
            <div class="d-flex justify-content-between mb-1">
                <span>${item.menu_name} x${item.quantity}</span>
                <span>€${total.toFixed(2)}</span>
            </div>
        `;
    });

    cartBox.innerHTML = html;

    const service = parseFloat(document.getElementById('service')?.innerText.replace("€", "")) || 0;
    const bag = parseFloat(document.getElementById('bag')?.innerText.replace("€", "")) || 0;
    const discountPercent = parseFloat(document.getElementById('discountPercent')?.innerText) || 0;
    const discountAmount = subtotal * discountPercent / 100;

    document.getElementById('subtotal').innerText = `€${subtotal.toFixed(2)}`;
    document.getElementById('discountAmount').innerText = `-€${discountAmount.toFixed(2)}`;
    document.getElementById('grandTotal').innerText = `€${(subtotal + service + bag - discountAmount).toFixed(2)}`;

    orderTotals.style.display = 'block';
}


    // -------------------------
    // Build order payload
    // -------------------------
    function buildFullOrderData() {
        return {
            customer_id: posCustomerId,
            items: cartItems,
            subtotal: parseFloat(document.getElementById("subtotal").innerText.replace("€", "")) || 0,
            service_charges: parseFloat(document.getElementById("service").innerText.replace("€", "")) || 0,
            bag_charges: parseFloat(document.getElementById("bag").innerText.replace("€", "")) || 0,
            discount_percent: parseFloat(document.getElementById("discountPercent").innerText) || 0,
            discount_amount: Math.abs(parseFloat(document.getElementById("discountAmount").innerText.replace("-€", ""))) || 0,
            grand_total: parseFloat(document.getElementById("grandTotal").innerText.replace("€", "")) || 0
        };
    }

    // -------------------------
    // Menu click
    // -------------------------
    document.querySelectorAll('.menu-card').forEach(card => {
        card.addEventListener('click', function () {
            showVariantPanel(
                this.dataset.name,
                parseFloat(this.dataset.price),
                this.dataset.id,
                parseInt(this.dataset.hasVariant),
                this.dataset.maincatid,
                JSON.parse(this.dataset.variants || '[]')
            );
        });
    });

    // -------------------------
    // Place order
    // -------------------------
    if (placeOrderBtn) {
        placeOrderBtn.addEventListener('click', () => {
            
           $.ajax({
                url: `${baseUrl}pos/cash_on_delivery`,
                method: "POST",
                data: {
                    ...buildFullOrderData(),  
                    pos_id: posCustomerId 
                },
                
                dataType: "json",
                success: function (res) {
                    console.log("res" . res);
                    const printUrl = `${baseUrl}orders/print_recipt/${res.order_code}`;
                    window.open(printUrl, "_blank"); // opens in new tab or print window
                    alert("Order placed successfully!" + res);
                    cartItems = [];
                    updateOrderSummary();
  
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert("Failed to place order.");
                }
            });

        });
    }
        updateOrderSummary(); // ← runs after DOM loaded

         
});

</script>

<style>
    .variant-select-btn {
    display: flex;
    flex-direction: column;
    flex: 1;
    padding: 15px;
    border: none;
    border: 1px solid #0000002e;
}

.variant-select-btn{
        border-radius: 6px;
        font-weight: 700;
}
.variant-select-btn.active{
        background: #f54748;
    color: white;
}
#pos-add-to-cart{
    background:#f54748;
    color:white;
    font-weight:bold;
    border:none;

    display: flex;
    flex-direction: row-reverse;
    justify-content: space-around;
    align-items: center;
}
#rightPanel{
        overflow-x: hidden;
}
</style>
