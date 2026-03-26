mycart();

function mycart() {
    alert('hi')
    $.ajax({
        url: "<?=base_url('cart/getMyCartItems');?>",
        method: "POST",
        success: function (response) {
            $('#cartItems').html(response.res);
            $('#cartSubtotal').html(response.subtotal);
        }
    });
}


$(document).on('submit', '#cartForm', function (e) {
    e.preventDefault();
    const formData = $(this).serialize();
    $.ajax({
        url: App.getSiteurl() + "cart/update",
        method: 'POST',
        data: $(this).serialize(),
        success: function (data) {
            if (data.status) {
                toastr.success(data.message);
                cartNotification();
                mycart();
            } else {
                toastr.error(data.message);
            }
        }
    });
});