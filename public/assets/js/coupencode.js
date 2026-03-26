function openModal(id = false) {
    modal = $('#coupencodeModal');
    toggleModal('coupencodeModal', true);
    modal.find('.head').text('Add Coupon Code');
    let webForm = document.getElementById('coupencodeForm');
    webForm.querySelector('#coupencode').value = '';
    webForm.querySelector('#coupenType').value = '';
    webForm.querySelector('#minimumShopping').value = '';
    webForm.querySelector('#maximum_discount_amount').value = '';
    webForm.querySelector('#discount').value = '';
    webForm.querySelector('#filterDate').value = '';
    webForm.querySelector('#edit_id').value = '';
    webForm.querySelector('#discount_type').value = '';
    webForm.querySelector('#description').value = '';

    if (id) {
        modal.find('.head').text('Edit Coupon Code');
        fetch(App.getSiteurl() + 'admin/coupen-code/edit/' + `${id}`)
            .then(res => res.json())
            .then(result => {
                if (result) {
                    webForm.querySelector('#coupencode').value = result.data.coupencode;
                    webForm.querySelector('#coupenType').value = result.data.coupenType;
                    webForm.querySelector('#minimumShopping').value = result.data.minimumShopping;
                    webForm.querySelector('#maximum_discount_amount').value = result.data.maximum_discount_amount;
                    webForm.querySelector('#discount').value = result.data.discount;
                    webForm.querySelector('#edit_id').value = result.data.id;
                    webForm.querySelector('#filterDate').value = result.data.validity_from + ' to ' + result.data.validity_to;
                    webForm.querySelector('#discount_type').value = result.data.discount_type;
                    webForm.querySelector('#description').value = result.data.description;
                }
            })
    }
}

$('#filterDate').daterangepicker({
    opens: 'left',
    autoUpdateInput: false,
    showCustomRangeLabel: true,
    alwaysShowCalendars: true,
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
});

// Cancel event
$('#filterDate').on('cancel.daterangepicker', function (ev, picker) {
    $(this).val('');
    $('#results').empty();
});


$('#coupencodeForm').on('submit', function (e) {
    e.preventDefault();
    let webForm = $('#coupencodeForm');
    const formData = new FormData(this);
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#submitBtn').prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
    );
    $.ajax({
        url: App.getSiteurl() + 'admin/coupen-code/save',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                toastr.success(response.message);
                $('#coupencodeForm')[0].reset();
                $('#coupencodeForm').trigger('reset');
                $('#submitBtn').prop('disabled', false).html('Save');
            } else {
                if (response.errors) {
                    $.each(response.errors, function (field, message) {
                        console.log(field + ' ' + message);
                        $('#' + field).addClass('is-invalid');
                        $('#' + field + '_error').text(message.replaceAll('_', ' '));

                    })
                }
            }
        }, error: function () {
            toastr.error('An error occurred while saving coupon code');
        }, complete: function () {
            // Re-enable submit button
            $('#submitBtn').prop('disabled', false).text('Save');
        }
    })
})


couponsList();
let currentPage = 1;
let rowsPerPage = 10;
let allData = [];
function couponsList() {
    let search = $('#searchInput').val();
    let filterDate = $('#filterDate').val();
    $.ajax({
        url: App.getSiteurl() + 'admin/coupen-code/list',
        method: 'post',
        data: {
            search: search,
            filterDate: filterDate
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                console.log(response)
                couponsListRender(response.data);

            }
        }, error: function () {
            toastr.error('An error occurred while loading coupon code list');
        }
    })
}



function couponsListRender(response) {

    let html = '';
    allData = response;
    if (response.length === 0) {
        html += `<div class="text-center py-8">
                    <h3 class="text-lg font-medium text-gray-700">No Data found</h3>
                </div>`
    } else {
        let start = (currentPage - 1) * rowsPerPage;
        let end = start + rowsPerPage;
        let paginatedData = allData.slice(start, end);
        html += `
        <div class="overflow-x-auto w-full">
            <table class="min-w-full border border-gray-200 divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">S/N</th>
                        <th class="px-4 py-3 text-left font-medium">Code</th>
                        <th class="px-4 py-3 text-left font-medium">Coupon Type</th>
                        <th class="px-4 py-3 text-left font-medium">Minimum Shopping</th>
                        <th class="px-4 py-3 text-left font-medium">Maximum Discount</th>
                        <th class="px-4 py-3 text-left font-medium">Discount</th>
                        <th class="px-4 py-3 text-left font-medium">Validity</th>
                        <th class="px-4 py-3 text-center font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">`
        paginatedData.forEach(function (item, idx) {
            html += `<tr>
                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">${start + idx + 1}</td>
                
                <td class="px-2 py-2 text-gray-700 break-words max-w-x border border-gray-300 font-extralight">${item.coupencode}</td>
                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">${item.coupenType == 1 ? 'Order' : 'Product'}</td>
                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">${item.minimumShopping}</td>
                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">${item.maximum_discount_amount}</td>
                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">${item.discount}</td>
                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">${item.validity}</td>
                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">
                    <button class="btn btn-sm btn-primary edit-expertise"  onclick="openModal('${item.encrypted_id}')">Edit</button>
                    <button class="btn btn-sm btn-danger delete-coupon" type="button" data-id="${item.encrypted_id}">Delete</button>
                </td>
            </tr>`;
        });
        html += `</tbody>
        </table></div>`;

        let totalPages = Math.ceil(response.length / rowsPerPage);
        html += `
            <div class="flex justify-between items-center mt-4">
                <div>
                    <label class="mr-2">Rows per page:</label>
                    <select onchange="changeRowsPerPage(this.value)" class="px-2 py-1 border rounded">
                
                        <option value="10" ${rowsPerPage == 10 ? 'selected' : ''}>10</option>
                        <option value="20" ${rowsPerPage == 20 ? 'selected' : ''}>20</option>
                        <option value="50" ${rowsPerPage == 50 ? 'selected' : ''}>50</option>
                        <option value="100" ${rowsPerPage == 100 ? 'selected' : ''}>100</option>
                    </select>
                </div>
                <div>
                    <button onclick="prevPage()" ${currentPage === 1 ? 'disabled' : ''} class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50">Prev</button>
                    <span class="mx-2">Page ${currentPage} of ${totalPages}</span>
                    <button onclick="nextPage(${totalPages})" ${currentPage === totalPages ? 'disabled' : ''} class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50">Next</button>
                </div>
            </div>`;

    }
    $('#categorytable').html(html);
}
$('#searchProductInput').on('input', function () {
    search = $(this).val();
    loadCategories(search);

})

// Change rows per page
function changeRowsPerPage(value) {
    rowsPerPage = parseInt(value);
    currentPage = 1;
    renderExpertiseTable(allData);
}

// Pagination functions
function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        renderExpertiseTable(allData);
    }
}
function nextPage(totalPages) {
    if (currentPage < totalPages) {
        currentPage++;
        renderExpertiseTable(allData);
    }
}

document.addEventListener('click', async (e) => {
    if (e.target.classList.contains('delete-coupon')) {
        let id = e.target.dataset.id;
        if (confirm('Are you sure you want to delete this coupon?')) {
            let response = await fetch(App.getSiteurl() + 'admin/coupen-code/delete/' + `${id}`);
            let result = await response.json();
            if (result.success) {
                toastr.success(result.message);
                couponsList();
            } else {
                toastr.error(result.message);
            }
        }
    }
})