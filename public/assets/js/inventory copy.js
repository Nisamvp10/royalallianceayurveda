
  const openBtn = document.getElementById('inventoryBtn');
  const modal = document.getElementById('inventoryModal');
  const closeBtn = document.getElementById('closeModal');

  // Open modal
  openBtn.addEventListener('click', () => {
    modal.classList.remove('hidden');
  });

  // Close modal
  function closeModal() {
    modal.classList.add('hidden');
  }

  closeBtn.addEventListener('click', closeModal);

  // Optional: close on background click
  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      closeModal();
    }
  });

 function updateItemNumber() {
    $('#productWrapper .product-row').each(function(index){
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
//      let newRow = $('#productWrapper .product-row:first').clone();

//     // Clear all inputs
//     newRow.find('input').val('');
//     newRow.find('select').val('');

//     $('#productWrapper').append(newRow);
//     updateItemNumber();
// });


$(document).on('change', 'select[name="category[]"]', function () {
    let currentRow = $(this).closest('.product-row');
    let productId = $(this).val();

    if (productId) {
        let hasEmptyRow = false;
        $('#productWrapper .product-row').each(function () {
            let cat = $(this).find('select[name="category[]"]').val();
            if (!cat) {
                hasEmptyRow = true;
            }
        });

        if (!hasEmptyRow) {
            let newRow = $('#productWrapper .product-row:first').clone();

            newRow.find('input').val('');
            newRow.find('select').val('');

            $('#productWrapper').append(newRow);
            updateItemNumber();

            $('html, body').animate({
                scrollTop: newRow.offset().top
            }, 500);

            // optional: focus the new row’s category select
            newRow.find('select[name="category[]"]').focus();
        }
    }
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
$('#createPurchase').on('submit',function(e) {
   
        let webForm = $('#createPurchase');
        e.preventDefault();
        let formData = new FormData(this);
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').empty();
        $('#submitBtn').prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
        );
        $.ajax({
            url : App.getSiteurl()+'purachse/save',
            method:'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success:function(response)
            { 
            
                if(response.success){
                    toastr.success(response.message);
                    Swal.fire({  title: "Good job!",  text:response.message,  icon: "success"});
                    webForm[0].reset();
                    closeModal();
                    // loadProducts();
                     loadInventory();
                      $('#submitBtn').prop('disabled', false).html('Saving');
                   
                }else{
                    if(response.errors){
                        $.each(response.errors,function(field,message)
                        {
                            //console.log(field)
                            $('#'+ field).addClass('is-invalid');
                            $('#' + field + '_error').text(message);
                        })
                        
                    }else{
                        if (response.item_errors) {
                                $(".error-text").remove();

                                $.each(response.item_errors, function(field, message) {
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
                            } else {
                                toastr.error(response.message);
                            }

                    }
                }
            },error: function() {
                toastr.error('An error occurred while saving Service');
            },
            complete: function() {
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
    $('#filterDate').on('apply.daterangepicker', function(ev, picker) {
         let startDate = picker.startDate.format('YYYY-MM-DD');
        let endDate = picker.endDate.format('YYYY-MM-DD');
        $(this).val(startDate + ' to ' + endDate);
        let search = $('#searchInput').val();
        loadInventory(search,startDate, endDate)     

        
    });

    // Cancel event
    $('#filterDate').on('cancel.daterangepicker', function(ev, picker) {
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
        if(orderId){
            $.ajax({
                method : 'POST',
                url : App.getSiteurl() + 'purchase-info',
                data:{id:orderId},
                dataType: 'json',
                success:function(response) {
                    if(response.success) {
                        renderInfo(response.products);
                    }
                }
            })
        }
    }

    function renderInfo(products) {
        let html ='';
        if(products.length ===0){
            html += '<p>No Data Found</p>'
        }else{
            products.forEach(product =>{
                html +=`
                <div class="p-6 space-y-6">
                    <!-- Header Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                        <label class="text-sm font-medium text-gray-600">Order Number</label>
                        <p class="text-lg font-semibold text-gray-900">${product.inoicenumber}</p>
                        </div>
                        <div>
                        <label class="text-sm font-medium text-gray-600">Date</label>
                        <p class="text-lg text-gray-900">${product.order_date}</p>
                        </div>
                        <div>
                        <label class="text-sm font-medium text-gray-600">Supplier</label>
                        <p class="text-lg text-gray-900">${product.supplier}</p>
                        </div>
                        <div>
                        <label class="text-sm font-medium text-gray-600">Payment Status</label>
                        <!-- Dynamic Status Badge -->
                        <span class="inline-flex px-3 py-1 text-sm font-semibold capitalize rounded-md  bg-green-100 ${product.payment=='paid' ? 'text-green-800' :'text-red-800'} ">
                            ${product.payment}
                        </span>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label class="text-sm font-medium text-gray-600 block mb-2">Notes</label>
                        <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">  ${product.note ?? ''}</p>
                    </div>

                    <!-- Order Items -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Items</h3>
                        <div class="space-y-2">`
                        if(product.items) {
                            let items = product.items;
                            items.forEach(item => {
                                html += `
                                     <!-- Item 1 -->
                                        <div class="border border-gray-200 rounded-lg p-2">
                                            <div class="grid grid-cols-2 md:grid-cols-6 gap-2 items-center">
                                            <div class="md:col-span-2">
                                                <h6 class="font-medium text-gray-900">${item.product}</h6>
                                                <p class="text-sm text-gray-600 mb-0">${item.sku}</p>
                                                <p class="text-xs font-semibold text-gray-600">Current Stock: ${item.stock}</p>
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
                   
                        html +=`</div>

                        <!-- Total Amount -->
                        <div class="border-t border-gray-200 pt-4 mt-6 bg-gray-50 rounded-lg px-4 py-3 flex justify-end">
                        <div class="text-xl font-bold text-gray-900">Total Amount: $${product.totalAmount}</div>
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