 <!-- 🔹 JS Section -->
    <script>
      const cart = [];
      const rightPanel = document.getElementById('rightPanel');
      const orderSummary = document.getElementById('orderSummary');

      // Function to show variant form
      function showVariantPanel(name, price, id, hasVariant) {
        rightPanel.innerHTML = `
          <div class="p-3">
            <button class="btn btn-sm btn-light mb-3" id="backToSummary"><i class="fas fa-arrow-left"></i> Back</button>
            <h5 class="font-weight-bold">${name}</h5>
            <p class="text-muted">Price: €. ${price.toFixed(2)}</p>

            <div id="variantOptions" class="mb-3">
              ${hasVariant == 1 ? `
                <label>Select Variant:</label>
                <select id="variantSelect" class="form-control mb-2">
                  <option value="Small">Small - €. ${price.toFixed(2)}</option>
                  <option value="Medium">Medium - €. ${(price + 50).toFixed(2)}</option>
                  <option value="Large">Large - €. ${(price + 100).toFixed(2)}</option>
                </select>
              ` : `<p class="text-muted">No variants available for this item.</p>`}
            </div>

            <div class="form-group">
              <label for="quantity">Quantity</label>
              <input type="number" class="form-control" id="quantity" value="1" min="1">
            </div>

            <div class="text-right mt-4">
              <button class="btn btn-secondary" id="cancelVariant">Cancel</button>
              <button class="btn btn-primary" id="confirmAdd">Add to Cart</button>
            </div>
          </div>
        `;

        document.getElementById('cancelVariant').onclick = () => {
          rightPanel.innerHTML = '';
          rightPanel.appendChild(orderSummary);
        };

        document.getElementById('backToSummary').onclick = () => {
          rightPanel.innerHTML = '';
          rightPanel.appendChild(orderSummary);
        };

        document.getElementById('confirmAdd').onclick = () => {
          const qty = parseInt(document.getElementById('quantity').value);
          const variant = hasVariant == 1 ? document.getElementById('variantSelect').value : 'Default';
          const variantPrice = hasVariant == 1
            ? parseFloat(document.getElementById('variantSelect').selectedOptions[0].text.split('€. ')[1])
            : price;

          cart.push({ id, name, variant, qty, price: variantPrice });
          updateCartUI();

          // Return to summary after adding
          rightPanel.innerHTML = '';
          rightPanel.appendChild(orderSummary);
        };
      }

      // Card click to show variant panel
      document.querySelectorAll('.menu-card').forEach(card => {
        card.addEventListener('click', function() {
          const name = this.dataset.name;
          const price = parseFloat(this.dataset.price);
          const id = this.dataset.id;
          const hasVariant = this.dataset.hasVariant;
          showVariantPanel(name, price, id, hasVariant);
        });
      });

      function updateCartUI() {
        const container = document.getElementById('cartItemsContainer');
        const emptyMsg = document.getElementById('emptyCartMsg');
        const totals = document.getElementById('orderTotals');

        container.innerHTML = '';
        let subtotal = 0;

        if (cart.length === 0) {
          emptyMsg.style.display = 'block';
          totals.style.display = 'none';
          return;
        } else {
          emptyMsg.style.display = 'none';
          totals.style.display = 'block';
        }

        cart.forEach((item, index) => {
          const lineTotal = item.price * item.qty;
          subtotal += lineTotal;

          const div = document.createElement('div');
          div.classList.add('d-flex', 'justify-content-between', 'align-items-center', 'mb-2');
          div.innerHTML = `
            <div>
              <strong>${item.name}</strong><br>
              <small>${item.variant} × ${item.qty}</small>
            </div>
            <div>
              <span>€. ${lineTotal.toFixed(2)}</span>
              <button class="btn btn-sm btn-link text-danger p-0 ml-2 remove-item" data-index="${index}">
                <i class="fas fa-times"></i>
              </button>
            </div>
          `;
          container.appendChild(div);
        });

        document.getElementById('subtotal').innerText = '€. ' + subtotal.toFixed(2);
        const serviceCharge = 50;
        document.getElementById('total').innerText = '€. ' + (subtotal + serviceCharge).toFixed(2);

        document.querySelectorAll('.remove-item').forEach(btn => {
          btn.addEventListener('click', function() {
            const i = this.dataset.index;
            cart.splice(i, 1);
            updateCartUI();
          });
        });
      }
    </script>