

<script>
        
    function editCartItem(e){
        e.parentElement.parentElement.classList.add("d-none");
        e.parentElement.parentElement.parentElement.querySelector(".quan-edit").classList.remove("d-none");

        
    }

   

    function updateQuantity(param, e){
        // debugger;  
        let price = e.parentElement.parentElement.querySelector("b");
        let quantity = e.parentElement.parentElement.parentElement.querySelector(".quan");
        
        let priceValue = parseFloat(price.innerText.replace(/[^0-9.]/g, ""));
        let quantityValue = parseInt(quantity.innerText.replace(/\D/g, ""));

        let currentQuantity = quantityValue; 

        if(param < 0 && currentQuantity == 1){
            return;
        }

        let _price = (currentQuantity > 1 ? (priceValue / currentQuantity) : priceValue);
        let updatedPrice = (currentQuantity + param) * _price; 

        price.innerHTML = "€" + (Math.round(updatedPrice * 100) / 100).toFixed(2);
        quantity.innerHTML = "x" + (currentQuantity + param);
            
        

    }
    
const baseUrl = '<?php echo base_url(); ?>';
let cartItems = []; // Global cart
const posCustomerId = 1001; // POS terminal ID

function updateVariantSelect(variant_id,elem) {
    // console.log("Selected variant ID:");
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
    const placeOrderBtnCard = document.getElementById('placeOrderBtnCard');

    const orderSummaryBtn = document.getElementById("orderSummaryBtn");
    const variantBtn = document.getElementById("variantBtn");

    if(orderSummaryBtn){
        orderSummaryBtn.addEventListener('click', () => {

                orderSummaryBtn.classList.add('active');
                variantBtn.classList.remove('active');
                document.getElementById('pos-add-to-cart').classList.add('d-none');

                // productOptionsContainer.innerHTML = "";
                productOptionsContainer.style.display = "none";
                orderSummary.style.display = "block";
            
            });
    }
    if(variantBtn){
        variantBtn.addEventListener('click', () => {
            
            if(document.querySelector("#product-options-container").innerHTML == "")
                return;


            document.getElementById('product-options-container').style.display = "block";
            
            orderSummary.style.display = "none";
            orderSummaryBtn.classList.remove('active');
            variantBtn.classList.add('active');
            
            document.getElementById('pos-add-to-cart').classList.remove('d-none');


        });
    }

    // -------------------------
    // SHOW VARIANT PANEL
    // -------------------------
  function showVariantPanel(name, basePrice, menuId, hasVariant, maincatid, variants) {
    productOptionsContainer.innerHTML = ""; // clear previous variant panel
    productOptionsContainer.style.display = "block";

    let variantOptions = "";
    let dynamicContainers = "";

    // Check for variants and construct variant options
    if (hasVariant == 1 && variants.length > 0) {
        variantOptions = `<option value="">Select...</option>`;
        variants.forEach(v => {
            const extraPrice = parseFloat(v.price) || 0;
            variantOptions += `<option value="${v.id}" data-price="${extraPrice}">${v.name} (+£${extraPrice.toFixed(2)})</option>`;
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
                    let a = cb.closest('.choice-box');

                    selectedExtras.push(cb.parentElement.querySelector("span").dataset.name);
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

                document.getElementById('orderSummaryBtn').click();

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
 

document.addEventListener('click', function(e) {
    if (e.target && e.target.matches('.sec-button[data-cart-id]')) {
        const cartId = e.target.dataset.cartId;
        if (!cartId) return;

        if (!confirm('Are you sure you want to delete this item?')) return;

        fetch(`${baseUrl}pos/item_delete/${cartId}`, {
            method: 'GET', 
        })
        .then(res => res.text()) 
        .then(() => {
            
                    updateOrderSummary();
        })
        .catch(err => {
            console.error(err);
            alert('Failed to delete item.');
        });
    }
});

document.addEventListener('click', function(e) {
    if (e.target && e.target.matches('.sec-button[data-item-id]')) {
        debugger;
        const cartId = e.target.dataset.itemId;
        if (!cartId) return;

        let parent = e.target.closest(".d-flex");
        let quantityEl = parent.querySelector(".quan");
        let quantityValue = parseInt(quantityEl.innerText.replace(/\D/g, ""));
        let priceEl = parent.querySelector(".quan-price b");
        let priceValue = parseFloat(priceEl.innerText.replace(/[^0-9.]/g, "")); 
     
        fetch(`${baseUrl}pos/update_cart`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ 
                cart_id: cartId,
                quantity: quantityValue,
                price: priceValue
            })
        })
        .then(res => res.text())
        .then(res => {
                    updateOrderSummary();

        })
        .catch(err => {
            console.error(err);
            alert('Failed to update item.');
        });
    }
});



    // -------------------------
    // Build order payload
    // -------------------------
    function buildFullOrderData() {
        return {
            customer_id: posCustomerId,
            items: cartItems,
            subtotal: parseFloat(document.getElementById("subtotal").innerText.replace("£", "")) || 0,
            service_charges: parseFloat(document.getElementById("service").innerText.replace("£", "")) || 0,
            bag_charges: parseFloat(document.getElementById("bag").innerText.replace("£", "")) || 0,
            discount_percent: parseFloat(document.getElementById("discountPercent").innerText) || 0,
            discount_amount: Math.abs(parseFloat(document.getElementById("discountAmount").innerText.replace("-£", ""))) || 0,
            grand_total: parseFloat(document.getElementById("grandTotal").innerText.replace("£", "")) || 0
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

            document.getElementById('variantBtn').click();
        
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
                    pos_id: posCustomerId,
                    pay_with: "cash"  
                },
                dataType: "json",
                success: function (res) {
                    const printUrl = `${baseUrl}orders/print_recipt/${res.order_code}`;
                    window.open(printUrl, "_blank"); // opens in new tab or print window

                    send_mail(res.order_code);
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

        if (placeOrderBtnCard) {
        placeOrderBtnCard.addEventListener('click', () => {
            
           $.ajax({
                url: `${baseUrl}pos/cash_on_delivery`,
                method: "POST",
                data: {
                    ...buildFullOrderData(),  
                    pos_id: posCustomerId,
                    pay_with: "card"   
                },
                dataType: "json",
                success: function (res) {
                    const printUrl = `${baseUrl}orders/print_recipt/${res.order_code}`;
                    window.open(printUrl, "_blank"); // opens in new tab or print window

                    // alert("Order placed successfully!");
                    send_mail(res.order_code);
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
        updateOrderSummary();

    function send_mail(order_code){

        $.ajax({
    url: '<?php echo site_url('pos/order_placing_mail/'); ?>' + order_code,
    method: 'POST', 
    success: function(response) {
    
         
    },
    error: function(xhr, status, error) {
        // Handle error response here
    }
});


    }

});




    async function updateOrderSummary() {
    // debugger;
    const cartBox = document.getElementById('cartItemsContainer');
    const orderTotals = document.getElementById('orderTotals');
    if (!cartBox || !orderTotals) return;

    const posId = 1001;

    const response = await fetch(`${baseUrl}pos/pos_cart_items?pos_id=${posId}`);
    var dbCartItems = await response.json();  // DB rows
    document.getElementById('discountPercent').innerHTML = dbCartItems.discount;
    dbCartItems = dbCartItems.menu;
    
    // console.log(cartItems); // JS cart
    if (!dbCartItems || dbCartItems.length === 0) {
        document.getElementById("placeOrderBtn").classList.add("disabled");
        document.getElementById("placeOrderBtnCard").classList.add("disabled");
        cartBox.innerHTML = `<p class="text-muted text-center" id="emptyCartMsg">No items added yet.</p>`;
        orderTotals.style.display = 'none';
        return;
    }

     document.getElementById("placeOrderBtn").classList.remove("disabled");
        document.getElementById("placeOrderBtnCard").classList.remove("disabled");

    let html = '';
    let subtotal = 0;

    dbCartItems.forEach(item => {
        let total = parseFloat(item.price);
        subtotal += total;

        html += `
            <div class="d-flex justify-content-between mb-2 flex-wrap">
                <div class="d-flex justify-content-between flex-wrap" style="width:50%">
                    <span><b>${item.menu_name} <span class="quan">x${item.quantity}</span></b></span>
                     <small>${formatAddons(item.addons)}</small>
                </div>
                <div style="gap:5px;width:50%;flex-direction:column;align-items:flex-end;display:flex;justify-content:space-between;" class="price-buttons">
                    <span><b>£${total.toFixed(2)}</b></span>
                   
                    <div>
                        <button class="sec-button" onclick="editCartItem(this)">Edit</button>
                        <button class="sec-button" style="color:#f54748" data-cart-id="${item.id}">Delete</button>
                    </div>
                </div>
                <div style="gap:5px;width:50%;flex-direction:column;align-items:flex-end;display:flex;justify-content:space-between;" class="quan-edit d-none">
                    <div style="width:100%;text-align:right;" class="quan-price">
                        <span><b>£${total.toFixed(2)}</b></span>
                    </div>
                   
                    <div style="width:100%;display:flex;justify-content:flex-end;gap:5px;">
                    <button class="sec-button" style="padding-left:20px;padding-right:20px"  onclick="close_quan(this,false)" data-item-id="${item.id}">&#x2714;</button>
                        <button class="sec-button" onclick="updateQuantity(1,this)"><b>+</b></button>
                        <button class="sec-button" onclick="updateQuantity(-1,this)"><b>-</b></button>
                        <button class="sec-button" style="padding-left:20px;padding-right:20px" onclick="close_quan(this)">&#10006;</button>
                    </div>
                </div>
            </div>
            <hr>
        `;
    });

    
    cartBox.innerHTML = html;

    const service = parseFloat(document.getElementById('service')?.innerText.replace("£", "")) || 0;
    const bag = parseFloat(document.getElementById('bag')?.innerText.replace("£", "")) || 0;
    const discountPercent = parseFloat(document.getElementById('discountPercent')?.innerText) || 0;
    const discountAmount = subtotal * discountPercent / 100;

    document.getElementById('subtotal').innerText = `£${subtotal.toFixed(2)}`;
    document.getElementById('discountAmount').innerText = `-£${discountAmount.toFixed(2)}`;
    document.getElementById('grandTotal').innerText = `£${(subtotal + service + bag - discountAmount).toFixed(2)}`;

    orderTotals.style.display = 'block';



    

}
  function formatAddons(addons) {
    if (!addons) return "";
    try {
        return JSON.parse(addons).join(", ");   // single line
    } catch (e) {
        return addons;
    }
}
 function close_quan(e,param){

        e.parentElement.parentElement.classList.add("d-none");
        e.parentElement.parentElement.parentElement.querySelector(".price-buttons").classList.remove("d-none");
        let quantity = e.parentElement.parentElement.parentElement.querySelector(".quan");
        if(param)
            quantity.innerHTML = "x1";
    }
    
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
