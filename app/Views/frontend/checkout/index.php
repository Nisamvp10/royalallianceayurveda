<?= view('frontend/inc/header') ?>
    <main class="main-area fix">
        <!-- breadcrumb-area -->
        <section class="breadcrumb__area breadcrumb__bg" data-background="<?=base_url('public/assets/template/');?>assets/img/bg/sd_bg.jpg">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <div class="breadcrumb__content">
                            <h2 class="title">Checkout</h2>
                            <nav class="breadcrumb">
                                <span property="itemListElement" typeof="ListItem">
                                    <a href="index-2.html">Home</a>
                                </span>
                                <span class="breadcrumb-separator">|</span>
                                <span property="itemListElement" typeof="ListItem">Checkout</span>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
          
        </section>


<div class="checkout-wrapper section-padding fix checkout__area section-py-150">
    <div class="container">
            <div class="row ">
                <div class="col-lg-8  col-sm-12">


                    <!--  -->
                    <div id="accordion">
                        <div class="card mb-3">
                            <button class="card-header border collapsed card-link bg-white d-flex align-items-center justify-content-between" data-toggle="collapse" data-target="#collapseaddress">

                                <b class="header-title float-left">
                                    Shipping Info
                                </b>
                                <i class="fa fa-plus float-right "></i>
                            </button>

                            <div id="collapseaddress" class="collapse show"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <!-- create a form here user email address with shipping address -->
                                    <form action="" id="addShippingAddressForm2">
                                        <label class="d-flex justify-content-end logbtn"  data-toggle="modal" data-target="#loginModal">Login</label>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <!-- Enter Email id or Mobile number -->
                                            <input type="text" name="shipping_email_id" autocomplete="email" class="form-control" id="user_email" placeholder="Enter email">
                                             <div id="user_emailError" class="text-danger invalid-feedback"></div>
                                        </div>
                                        <div class="form-group mt-2 mb-2">
                                            <label>Phone</label>
                                            <input type="text" class="form-control w-100" autocomplete="tel" id="shipping_phone" name="shipping_phone" placeholder="Phone Number" >
                                            <div id="shipping_phoneError" class="text-danger invalid-feedback"></div>
                                        </div>
                                       
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" autocomplete="name" name="shipping_name" id="shipping_name" placeholder="Name">
                                            <input type="hidden" name="shipping_address_id" id="shipping_address_id" value="">
                                            <div id="shipping_nameError" class="text-danger invalid-feedback"></div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" name="shipping_address" placeholder="Address" autocomplete="street-address" id="shipping_address" rows="3"></textarea>
                                            <div id="shipping_addressError" class="text-danger invalid-feedback"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <input type="text" class="form-control" placeholder="City" name="shipping_city" autocomplete="city" id="shipping_city">
                                                    <div id="shipping_cityError" class="text-danger invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>State</label>
                                                    <input type="text" class="form-control" placeholder="State" autocomplete="state" name="shipping_state" id="shipping_state">
                                                    <div id="shipping_stateError" class="text-danger invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label>Pincode</label>
                                                    <input type="text" class="form-control" placeholder="Pincode" autocomplete="postal-code" name="shipping_pincode" id="shipping_pincode">
                                                    <div id="shipping_pincodeError" class="text-danger invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <input type="text" class="form-control" placeholder="Country" name="shipping_country" autocomplete="country" id="shipping_country">
                                                    <div id="shipping_countryError" class="text-danger invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">
                                                Reset
                                            </button>
                                            <button type="submit" class="btn btn-primary" id="saveAddress">
                                                Save Address
                                            </button>
                                        </div>
                                    </form>
                                    <div id="shippingAddress"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <button class="card-header  border collapsed card-link bg-white d-flex align-items-center justify-content-between" data-toggle="collapse" data-target="#collapseTwo">

                                <div class="header-title float-left">
                                    <b class="header-title float-left">
                                        Shopping Cart
                                    </b>
                                </div>
                                <i class="fa fa-plus float-right "></i>
                            </button>

                            <div id="collapseTwo" class="collapse"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <div class="course-terms cart" id="cartItems"></div> <!-- course terms -->
                                </div>
                            </div>
                        </div>

                    
                    </div>
                    <!--  -->
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="" id="cartSubtotal"> </div>
                </div>
            </div>
        
        <!-- <h4 class="mb-4">Your Order</h4> -->
        
     
    </div>
</div>

</main>

    <!--  -->

    <?= view('modal/shippingAddressModal')?>
    <?= view('modal/loginModal')?>
    <?= view('frontend/inc/footerLink') ?>
    <!-- REQUIRED JS ORDER -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="<?=base_url('public/assets/template/');?>assets/js/count.js"></script>
    <script src="<?=base_url('public/assets/template/');?>assets/js/auth.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="<?=base_url('public/assets/template/');?>assets/js/checkout.js"></script>

<script>
    mycart();

    function mycart(){
      
        $.ajax({
            url: "<?=base_url('cart/checkout-items');?>",
            method: "POST",
            success: function (response) {
                $('#cartItems').html(response.res);
                $('#cartSubtotal').html(response.subtotal);
            }
        });
    }


   $(document).on('submit','#cartForm', function (e) {
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

document.addEventListener('click', async (e) => {

    /* ================= REMOVE FROM CART ================= */
    if (e.target.closest('.removeFromCart')) {
        const btn = e.target.closest('.removeFromCart');
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
            mycart();
        } else {
            toastr.error(data.message);
        }
    }

});



</script>
<!-- intlTelInput CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css" />
<!-- intlTelInput JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<!-- Utils (required for validation) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>

<script>
$(document).ready(function () {
    const input = document.querySelector("#shipping_phone") ?? null;
    if (!input) return;
    // Initialize intlTelInput and store instance in `iti`
    const iti = window.intlTelInput(input, {
        separateDialCode: true,
        initialCountry: "in",
        preferredCountries: ["in"],
        hiddenInput: "phone_number",
        //width of the input
        width: "100%",
        nationalMode: false,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
    });

    const errorMsg = $("#error-msg");
    const validMsg = $("#valid-msg");

    function reset() {
        errorMsg.hide();
        validMsg.hide();
    }

    input.addEventListener('blur', function () {
        reset();
        if (input.value.trim()) {
            if (iti.isValidNumber()) {
                const countryData = iti.getSelectedCountryData();
                if (countryData.iso2 === "in") {
                    validMsg.show();
                    $("#phone_country_code").val(countryData.dialCode);
                } else {
                    errorMsg.text("Only Indian (+91) numbers allowed.").show();
                }
            } else {
                errorMsg.text("Invalid number").show();
            }
        }
    });

    input.addEventListener('change', reset);
    input.addEventListener('keyup', reset);
});
</script>