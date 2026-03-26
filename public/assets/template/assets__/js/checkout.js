shippingAddress();

function shippingAddress() {
    let address = $('#shippingAddress');
    address.html();
    $.ajax({
        url: App.getSiteurl() + 'shipping-address',
        method: 'POST',
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            address.html(response.result);
        }

    })
}


$('#addShippingAddressForm').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    let webForm = $('#addShippingAddressForm');
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#loginBtn').prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
    );

    $.ajax({
        url: App.getSiteurl() + 'user/add-shipping-address',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                webForm[0].reset();
                $('#loginBtn').prop('disabled', false).html('Save Address');
                shippingAddress();
            } else {
                $('#loginBtn').prop('disabled', false).html('Save Address');
                if (response.login === false) {
                    $('#addNewAddressModal').css('display', 'none');
                    $('#loginModal').modal('show');
                }
                else if (response.errors) {
                    $.each(response.errors, function (field, msg) {
                        $('#' + field).addClass('is-invalid');
                        $('#' + field + 'Error').text(msg.replaceAll('_', ' '));
                    })
                }

            }
        }
    });
})

document.addEventListener('click', async (e) => {
    if (e.target.classList.contains('checkoutBtn')) {

        let btn = $('.checkoutBtn');

        btn.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm"></span> Placing Order...'
        );

        try {

            /* LOGIN CHECK */
            const isLogin = await fetch(App.getSiteurl() + '/isLogin');
            const res = await isLogin.json();

            if (!res.status) {

                $('#loginModal').modal('show');
                btn.prop('disabled', false).html('Place Order');
                return;
            }

            /* ADDRESS CHECK */
            const address = $('input[name="address_id"]:checked').val();

            if (!address) {

                toastr.error('Please select address');
                btn.prop('disabled', false).html('Place Order');
                return;
            }

            /* PLACE ORDER */
            $.ajax({

                url: App.getSiteurl() + 'place-order',
                method: 'POST',
                data: { address_id: address },
                dataType: 'json',

                success: function (response) {

                    if (!response.success) {

                        toastr.error(response.message);
                        btn.prop('disabled', false).html('Place Order');
                        return;
                    }

                    /* OPEN RAZORPAY */
                    if (response.razorpay_order_id) {

                        var options = {

                            key: response.key,
                            amount: response.amount,
                            currency: "INR",
                            name: "Robin Food",
                            description: "Order Payment",
                            image: App.getSiteurl() + "/public/assets/template/assets/images/logo.png",
                            order_id: response.razorpay_order_id,

                            handler: function (payment) {
                                /* VERIFY PAYMENT */

                                $.ajax({

                                    url: App.getSiteurl() + 'verify-payment',
                                    type: 'POST',
                                    data: {
                                        razorpay_payment_id: payment.razorpay_payment_id,
                                        razorpay_order_id: payment.razorpay_order_id,
                                        razorpay_signature: payment.razorpay_signature
                                    },
                                    dataType: 'json',

                                    success: function (res) {
                                        window.location.href = App.getSiteurl() + 'order-success/' + res.order_id;
                                    },

                                    error: function () {
                                        toastr.error("Payment verification failed");

                                        btn.prop('disabled', false).html('Place Order');

                                    }

                                });

                            },

                            modal: {

                                ondismiss: function (res) {
                                    //here set order cancel updation
                                    toastr.error("Payment cancelled");
                                    $.post(App.getSiteurl() + "cancel-order", { order_id: response.razorpay_order_id });
                                    btn.prop('disabled', false).html('Place Order');

                                }

                            },

                            theme: {
                                color: "#3399cc"
                            }

                        };

                        var rzp1 = new Razorpay(options);

                        /* PAYMENT FAILED EVENT */

                        rzp1.on('payment.failed', function (response) {

                            console.log(response.error);

                            toastr.error(response.error.description);

                            btn.prop('disabled', false).html('Place Order');

                        });

                        rzp1.open();

                    }

                },

                error: function () {

                    toastr.error("Server error");

                    btn.prop('disabled', false).html('Place Order');

                }

            });

        } catch (error) {

            console.log(error);

            toastr.error("Something went wrong");

            btn.prop('disabled', false).html('Place Order');

        }

    }

    if (e.target.classList.contains('applyCoupon')) {
        const couponCode = $('.couponcodeInput').val();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').empty();
        let btn = $('.applyCoupon');
        btn.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Applying...'
        );
        if (couponCode) {
            $.ajax({
                url: App.getSiteurl() + 'apply-coupon',
                method: 'POST',
                data: { coupon_code: couponCode },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        mycart();
                    } else {
                        if (response.errors) {
                            $.each(response.errors, function (field, msg) {
                                $('#' + field).addClass('is-invalid');
                                $('#' + field + 'Error').text(msg.replaceAll('_', ' '));
                            })
                        }
                        if (response.message) {
                            toastr.error(response.message);
                        }
                    }
                    btn.prop('disabled', false).html('Apply');
                }
            })
        } else {
            toastr.error('Please enter coupon code');
            btn.prop('disabled', false).html('Apply');
        }
    }
})



function isDefault(e) {
    if (e.checked) {
        $.ajax({
            url: App.getSiteurl() + 'set-default-address',
            method: 'POST',
            data: { address_id: e.value },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            }
        })
    }
}
