
const openBtn = document.getElementById('salesBtn');
const modal = document.getElementById('inventoryModal');
const closeBtn = document.getElementById('closeModal');
const cancelBtn = document.getElementById('cancelModal');

// Open modal
openBtn.addEventListener('click', () => {
    modal.classList.remove('hidden');
});

// Close modal (only with buttons)
function closeModal() {
    modal.classList.add('hidden');
}

closeBtn.addEventListener('click', closeModal);
cancelBtn.addEventListener('click', closeModal);

function updateItemNumber() {
    $('#productWrapper .product-row').each(function (index) {
        let rowIndex = index + 1;

        $(this).find('.item-title').text('Item ' + rowIndex);

        // Update category ID and error
        $(this).find('select[name="category[]"]')
            .attr('id', 'category' + rowIndex);
        $(this).find('#category_error')
            .attr('id', 'category' + rowIndex + '_error');

        // Update quantity ID and error
        $(this).find('input[name="quantity[]"]')
            .attr('id', 'quantity' + rowIndex);
        $(this).find('#quantity_error')
            .attr('id', 'quantity' + rowIndex + '_error');

        // Update price ID and error
        $(this).find('input[name="price[]"]')
            .attr('id', 'price' + rowIndex);
        $(this).find('#price_error')
            .attr('id', 'price' + rowIndex + '_error');
    });
}

// Add new row
$('#addContactRow').on('click', function () {
    let newRow = $('#productWrapper .product-row:first').clone();

    // Clear all inputs
    newRow.find('input').val('');
    newRow.find('select').val('');

    $('#productWrapper').append(newRow);
    updateItemNumber();
});



// $(document).on('change', 'select[name="category[]"]', function () {
//     let productId = $(this).val();
//     let currentRow = $(this).closest('.product-row');

//     if (productId) {
//         // Fetch price for selected product
//         $.ajax({
//             url: App.getSiteurl() + "get-product-price",
//             type: "POST",
//             data: { product_id: productId },
//             dataType: "json",
//             success: function (response) {
//                 if (response.success) {
//                     // Set price in current row
//                     currentRow.find('input[name="price[]"]').val(response.price);

//                     // Check if last row is empty before adding new
//                     let lastRow = $('#productWrapper .product-row:last');
//                     let lastRowCategory = lastRow.find('select[name="category[]"]').val();

//                     if (lastRowCategory) {
//                         // Add new empty row only if last row has category selected
//                         let newRow = currentRow.clone();
//                         newRow.find('input').val('');
//                         newRow.find('select').val('');
//                         $('#productWrapper').append(newRow);
//                         updateItemNumber();
//                     }
//                 } else {
//                     alert(response.message);
//                 }
//             }
//         });
//     }
// });

$(document).on('change', '.product-input', function () {
    var $input = $(this);
    var currentRow = $input.closest('.product-row');
    var modalBody = $('#inventoryModal .bg-white.overflow-y-auto');
    var val = $.trim($input.val());
    var hidden = currentRow.find('.product-id');

    let qty = currentRow.find('input[name="quantity[]"]').val('');
    let total = currentRow.find('.total-price').text('Total : ' + 0.00);



    // find matching datalist option (trimmed)
    var $matched = $('#productList option').filter(function () {
        return $.trim($(this).val()) === val;
    }).first();

    var productId = $matched.length ? $matched.data('id') : "";

    // set hidden id (or clear if not matched)
    hidden.val(productId || '');

    // if not a valid product, clear price and notify user
    if (!productId) {
        currentRow.find('input[name="price[]"]').val('');
        // optional: show message to user
        alert("Invalid product selected. Please choose a product from the list.");
        return; // stop here (no AJAX)
    }

    // abort any previous ajax for this row to avoid race conditions
    if (currentRow.data('xhr')) {
        try { currentRow.data('xhr').abort(); } catch (e) { }
        currentRow.removeData('xhr');
    }

    // Always request price for the product selected in this row
    var xhr = $.ajax({
        url: App.getSiteurl() + "get-product-price",
        method: "POST",
        dataType: "json",
        data: { product_id: productId }
    }).done(function (response) {
        if (response && response.success) {
            currentRow.find('input[name="price[]"]').val(response.avg_price);
            var $lastRow = $('#productWrapper .product-row:last');
            var lastRowHasProduct = $lastRow.find('.product-id').val() || $lastRow.find('.product-input').val();

            let label = currentRow.find('label[for="quantity"]');
            if (label.length) {
                label.html(`Quantity Sold 
                <span class="px-2 py-1 bg-green-600 text-white text-xs font-medium rounded-lg ml-2" for="stock" data-stock=" ${response.stock}">
                    ${response.stock}
                </span>`);
            }


            if (lastRowHasProduct) {
                var $newRow = $lastRow.clone();
                // clear values & remove duplicate ids
                $newRow.find('input, select, textarea').each(function () {
                    $(this).val('');
                    $(this).removeAttr('id');
                    $newRow.find('label[for="quantity"]').html('Quantity Sold <span></span>');

                });
                $newRow.find('.product-id').val('');
                // append and update
                $('#productWrapper').append($newRow);
                updateItemNumber();
                modalBody.animate({ scrollTop: modalBody.prop('scrollHeight') }, 300);
                //$newRow.find('.product-input').first().focus();
            }
        } else {
            alert((response && response.message) ? response.message : "Couldn't load price for this product.");
            hidden.val('');
            currentRow.find('input[name="price[]"]').val('');
        }
    }).fail(function (jqXHR, textStatus) {
        if (textStatus !== 'abort') {
            alert("Error fetching product price. Please try again.");
        }
    }).always(function () {
        currentRow.removeData('xhr');
    });
    currentRow.data('xhr', xhr);
});


// Remove row
$(document).on('click', '.removeRow', function () {
    if ($('#productWrapper .product-row').length > 1) {
        $(this).closest('.product-row').remove();
        updateItemNumber();
    } else {
        alert("At least one row is required.");
    }
});

// Initialize once
updateItemNumber();

//   $('.productList').select2({
//         placeholder: "Search and select items",
//         allowClear: true,
//         width: '100%'
//     });
//     $('.select2-selection.select2-selection--single').addClass(
//         'pl-10 pr-3 py-2 w-full border border-gray-300 !rounded-lg focus:ring-2 !h-auto focus:ring-blue-500 focus:border-blue-500'
//     );
$(document).on('change', 'input[name="quantity[]"]', function () {
    calculateQuantityPrice($(this));
});

function calculateQuantityPrice(input) {
    let quantity = parseFloat(input.val()) || 0;
    let currentRow = input.closest('.product-row');

    // price calculation
    let price = parseFloat(currentRow.find('input[name="price[]"]').val()) || 0;
    let total = quantity * price;
    currentRow.find('.total-price').text('Total : ' + total.toFixed(2));

    // stock update
    let stockSpan = currentRow.find('span[for="stock"]'); // where current stock is shown
    let currentStock = parseFloat(stockSpan.data('stock')) || 0;
    console.log(currentStock);
    // store original stock in data-stock (important so it won’t keep reducing)

    let remainingStock = currentStock - quantity;
    if (remainingStock < 0) remainingStock = 0; // prevent negative stock

    // update label text
    stockSpan.text(remainingStock);
}


$('#createSale').on('submit', function (e) {
    let webForm = $('#createSale');
    e.preventDefault();
    let formData = new FormData(this);
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#submitBtn').prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
    );
    $.ajax({
        url: App.getSiteurl() + 'sales/save',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (response) {

            if (response.success) {
                toastr.success(response.message);
                Swal.fire({ title: "Good job!", text: response.message, icon: "success" });
                webForm[0].reset();
                closeModal();
                loadSales();
            } else {
                if (response.errors) {
                    $.each(response.errors, function (field, message) {
                        //console.log(field)
                        $('#' + field).addClass('is-invalid');
                        $('#' + field + '_error').text(message);
                        toastr.error(message, 'Error', {
                            timeOut: 10000,
                            extendedTimeOut: 5000,
                            closeButton: true,
                            progressBar: true
                        });
                    })

                } else {
                    if (response.item_errors) {
                        $(".error-text").remove();

                        $.each(response.item_errors, function (field, message) {
                            let parts = field.split(".");
                            let fieldName = parts[0];
                            let index = parts[1];

                            if (typeof index !== "undefined") {
                                let input = $("[name='" + fieldName + "[]']").eq(index);
                                if (input.length > 0) {
                                    input.after('<span class="error-text text-danger">' + message + '</span>');
                                }
                            } else {
                                let input = $("[name='" + fieldName + "']");
                                if (input.length > 0) {
                                    input.after('<span class="error-text text-danger">' + message + '</span>');
                                }
                            }
                        });
                    } else if (response.messages) {
                        response.messages.forEach(msg => {
                            toastr.error(msg, 'Error', {
                                timeOut: 10000,
                                extendedTimeOut: 5000,
                                closeButton: true,
                                progressBar: true
                            });
                        })
                    } else {
                        toastr.error(response.message);
                    }

                }
            }
        }, error: function () {
            toastr.error('An error occurred while saving Service');
        },
        complete: function () {
            // Re-enable submit button
            $('#submitBtn').prop('disabled', false).text('Save');
        }
    })
})

$('#filterDate').daterangepicker({
    opens: 'left',
    autoUpdateInput: false,
    locale: {
        cancelLabel: 'Clear',
        format: 'DD-MM-YYYY'
    },
    ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
});

// Apply event
$('#filterDate').on('apply.daterangepicker', function (ev, picker) {
    let startDate = picker.startDate.format('YYYY-MM-DD');
    let endDate = picker.endDate.format('YYYY-MM-DD');
    $(this).val(startDate + ' to ' + endDate);
    let search = $('#searchInput').val();
    loadSales(search, startDate, endDate)


});

// Cancel event
$('#filterDate').on('cancel.daterangepicker', function (ev, picker) {
    $(this).val('');
    $('#results').empty();
});
const openPurchaseBtn = document.getElementById('inventoryBtn');
const purchaseModal = document.getElementById('purchaseInfoModal');
const closeInfoBtn = document.getElementById('closeInfoModal');
function closeInfoModal() {
    purchaseModal.classList.add('hidden');
}

closeInfoBtn.addEventListener('click', closeInfoModal);


function purchaseDetails(e) {
    purchaseModal.classList.remove('hidden');
    let orderId = $(e).data('id');
    if (orderId) {
        $.ajax({
            method: 'POST',
            url: App.getSiteurl() + 'admin/sale-info',
            data: { id: orderId },
            dataType: 'json',
            success: function (response) {
                console.log(response.products)
                if (response.success) {
                    renderInfo(response.products);
                }
            }
        })
    }
}

function renderInfo(products) {
    let html = '';
    if (products.length === 0) {
        html += '<p>No Data Found</p>'
    } else {
        products.forEach(product => {
            html += `
                <div class="p-6 space-y-6">
                    <!-- Header Info -->
                    <input type="hidden" id="orderId" value="${product.orderId}">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                        <label class="text-sm font-medium text-gray-600">Order Number</label>
                        <p class="text-lg font-semibold text-gray-900">${product.inoicenumber}</p>
                        </div>
                        <div>
                        <label class="text-sm font-medium text-gray-600">Date</label>
                        <p class="text-lg text-gray-900">${product.sale_date}</p>
                        </div>
                        <div>
                        <label class="text-sm font-medium text-gray-600">Customer</label>
                        <p class="text-xs font-[12px] text-gray-900 mb-0">${product.customer}</p>
                        <p class="text-xs font-[12px] text-gray-900 mb-0">${product.phone}</p>
                        <p class="text-xs font-[12px] text-gray-900 mb-0">${product.email}</p>
                        </div>
                        <div>
                        <!-- Dynamic Status Badge -->
                        <span class="inline-flex px-3 py-1 text-sm font-semibold capitalize rounded-md  bg-green-100 ${product.payment == 'paid' ? 'text-green-800' : 'text-red-800'} ">
                            Payment Status : ${product.payment}
                        </span>
                        <span class="inline-flex px-3 my-2 py-1 text-sm font-semibold capitalize rounded-md  bg-green-100 ${product.paymentMethod == 'cod' ? 'text-yellow-800' : 'text-green-800'} ">
                            Payment Method : ${product.paymentMethod}
                        </span>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold capitalize rounded-md  bg-green-100 ${product.orderStatus == 'confirmed' ? 'text-green-800' : product.paymentStatus == 'pending' ? 'text-yellow-800' : 'text-red-800'} ">
                            Order Status : ${product.orderStatus}
                        </span>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="flex justify-between items-center" >
                       <div class="p-2 w-100 relative">
                        <label class="text-sm font-medium text-gray-600 block mb-2">Order Status</label>
                        <div id="orderStatusMsg" class="absolute top-10 right-0"></div>
                        <select name="orderStatus" id="orderStatus" class="form-control">
                            <option ${product.orderStatus == 'pending' ? 'selected' : ''} value="pending">Pending</option>
                            <option ${product.orderStatus == 'confirmed' ? 'selected' : ''} value="confirmed">Confirmed</option>
                            <option ${product.orderStatus == 'delivered' ? 'selected' : ''} value="delivered">Delivered</option>
                            <option ${product.orderStatus == 'cancelled' ? 'selected' : ''} value="cancelled">Cancelled</option>
                        </select>
                       </div>
                       <div class="p-2 w-100 relative">
                        <label class="text-sm font-medium text-gray-600 block mb-2">Payment Status</label>
                        <div id="paymentStatusMsg" class="absolute top-10 right-0"></div>
                        <select name="paymentStatus" id="paymentStatus" class="form-control">
                            <option ${product.payment == 'pending' ? 'selected' : ''} value="pending">Pending</option>
                            <option ${product.payment == 'paid' ? 'selected' : ''} value="paid">Paid</option>
                            <option ${product.payment == 'unpaid' ? 'selected' : ''} value="unpaid">Unpaid</option>
                            <option ${product.payment == 'failed' ? 'selected' : ''} value="failed">Failed</option>
                        </select>
                       </div>
                       <div class="p-2 w-100">
                            <button id="downloadInvoice" onclick="downloadInvoice()"  class="flex items-center space-x-2 float-right px-4 py-2 bg-green-600 text-white !rounded-lg hover:bg-green-700">  Download Invoice</button>
                       </div>
                    </div>

                    <!-- Order Items -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Items</h3>
                        <div class="space-y-2">`
            if (product.items) {
                let items = product.items;
                items.forEach(item => {
                    html += `
                                     <!-- Item 1 -->
                                        <div class="border border-gray-200 rounded-lg p-2">
                                            <div class="grid grid-cols-2 md:grid-cols-6 gap-2 items-center">
                                            <div class="md:col-span-2">
                                                <h6 class="font-medium text-gray-900">${item.product}</h6>
                                                <p class="text-sm text-gray-600 mb-0">${item.sku}</p>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-sm text-gray-600 mb-0">Ordered</p>
                                                <p class="font-semibold text-gray-900">${item.quantity}</p>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-sm text-gray-600 mb-0">Unit Price</p>
                                                <p class="font-semibold text-gray-900">${item.price}</p>
                                            </div>
                                            <div class="text-center md:col-span-2 md:text-right">
                                                <p class="text-sm text-gray-600 mb-0">Total</p>
                                                <p class="font-semibold text-gray-900">${item.total}</p>
                                            </div>
                                            </div>
                                        </div>
                                `;
                })
            }

            html += `</div>

                        <!-- Total Amount -->
                          <div class="border-t border-gray-200 pt-1 mt-2 bg-gray-50 rounded-lg px-4 py-1 flex justify-end">
                         <div class="text-xl font-[12px] text-gray-200"> Tax: ${product.tax}</div>
                         </div>
                           <div class="border-t border-gray-200 pt-1 mt-2 bg-gray-50 rounded-lg px-4 py-1 flex justify-end">
                             <div class="text-xl font-[12px] text-gray-200"> Discount: ${product.discount}</div>
                         </div>   
                        <div class="border-t border-gray-200 pt-4 mt-6 bg-gray-50 rounded-lg px-4 py-3 flex justify-end">
                         <div class="text-xl font-bold text-gray-900">Total Amount RS: ${product.totalAmount}</div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-end pt-6 border-t border-gray-200">
                        <button onclick="closeInfoModal()" class="px-6 py-2 border border-gray-300 text-gray-700 !rounded-lg hover:bg-gray-50 transition-colors">
                        Close
                        </button>
                    </div>
                    </div>

                `;
        })
    }
    $('#purchaseDetailsWrapper').html(html)
}

document.addEventListener('change', async function (e) {
    let orderId = $('#orderId').val();
    if (e.target.id === 'paymentStatus') {
        let orderStatus = $('#orderStatus').val();
        let paymentStatus = $('#paymentStatus').val();
        let paymentStatusMsg = $('#paymentStatusMsg');
        paymentStatusMsg.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')

        await $.ajax({
            method: 'POST',
            url: App.getSiteurl() + 'admin/payment-update',
            data: { orderId: orderId, orderStatus: orderStatus, paymentStatus: paymentStatus },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                    loadSales();
                    purchaseDetails(orderId);
                    paymentStatusMsg.html('');
                }
            }
        })
    }
    if (e.target.id === 'orderStatus') {
        let orderStatus = $('#orderStatus').val();
        let paymentStatus = $('#paymentStatus').val();
        // show loading on order status after select
        $('#orderStatusMsg').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
        await $.ajax({
            method: 'POST',
            url: App.getSiteurl() + 'admin/order-update',
            data: { orderId: orderId, orderStatus: orderStatus, paymentStatus: paymentStatus },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                    loadSales();
                    purchaseDetails(orderId);
                    $('#orderStatusMsg').html('');
                }
            }
        })
    }
})

function downloadInvoice() {
    let orderId = $('#orderId').val();
    window.location.href = App.getSiteurl() + 'admin/downloadInvoice/' + orderId;

}  
