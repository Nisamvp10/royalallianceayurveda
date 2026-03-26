document.addEventListener('click', async (e) => {
    /* ================= ADD TO CART ================= */
    if (e.target.closest('.add-to-cart')) {

        const btn = e.target.closest('.add-to-cart');
        const productId = btn.dataset.id;
        let qty = parseInt(document.getElementById('quantity')?.value) || 1;

        const response = await fetch(App.getSiteurl() + "cart/add", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify({
                product_id: productId,
                qty: qty
            })
        });

        const data = await response.json();

        if (data.status) {
            toastr.success(data.message);
            document.getElementById('cartCount').innerText = data.cartCount;
            cartNotification();
        } else {
            toastr.error(data.message);
        }
    }

    /* ================= REMOVE FROM CART ================= */
    if (e.target.closest('.remove-from-cart')) {

        const btn = e.target.closest('.remove-from-cart');
        const productId = btn.dataset.id;

        const response = await fetch(App.getSiteurl() + "cart/remove", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify({
                product_id: productId
            })
        });

        const data = await response.json();

        if (data.status) {
            toastr.success(data.message);

            // remove item from UI
            document.querySelector(`.cart-item[data-id="${productId}"]`)?.remove();

            document.getElementById('cartCount').innerText = data.cartCount;
            cartNotification();
        } else {
            toastr.error(data.message);
        }
    }

});

cartNotification();
function cartNotification() {
    fetch(App.getSiteurl() + "cart/getCart", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.res) {
                $('#cartCount').text(data.itmsCount);
                if (data.itmsCount > 0) {
                    let cartHtml = "";

                    data.res.forEach(item => {
                        cartHtml += `
                       <div class="mini__cart-widget">
                            <div class="mini__cart-item">
                                <div class="thumb">
                                    <img src="${item.image}" alt="img">
                                </div>
                                <div class="content">
                                    <h6 class="title"><a href="#">
                                            ${item.product_title}
                                        </a></h6>
                                    <p>Rs ${item.price} <span>x${item.quantity}</span></p>
                                </div>
                                <div class="mini__cart-delete">
                                    <img src="${App.getSiteurl()}public/assets/template/assets/img/close.png" alt="icon" class="remove-from-cart" data-id="${item.product_id}">
                                </div>
                            </div>
                        </div>
                    </div>`;
                        cartHtml += `
                    <div class="mini__cart-checkout">
                        <h4 class="title">Subtotal: <span>Rs ${item.subtotal}</span></h4>
                        <div class="mini__cart-checkout-btn">
                            <a href="${App.getSiteurl()}cart" class="tg-btn tg-btn-three">view cart</a>
                            <a href="${App.getSiteurl()}checkout" class="tg-btn tg-btn-three">checkout</a>
                        </div>
                    </div>
                    `;
                    });
                    $('#menuCart').html(cartHtml);
                } else {
                    $('#menuCart').html('<p>No items in cart</p>');
                }
            }
        });
}

