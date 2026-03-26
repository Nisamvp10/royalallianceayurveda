
function openModal(e = false) {
    toggleModal('categoryModal', true);
    let id = e;
    let webForm = $('#categoryForm');
    const modal = document.getElementById('categoryForm');
    let title = $('#openModal').data('title');
    $('#categoryModal').find('.head').text(title)
    $('#edit_id').val('');
    modal.querySelector('#category').value = '';
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    if (id) {
        fetch(App.cust() + 'edit/' + `${id}`)
            .then(res => res.json())
            .then(banner => {
                if (banner) {
                    $('#categoryModal').find('.head').text('Edit ' + title)
                    modal.querySelector('#edit_id').value = `${id}`;
                    modal.querySelector('#category').value = banner.category;
                }
            });
    } else {
        $('#selectedPreview').addClass('hidden');
        webForm[0].reset();
    }
}


function loadCategories(search = '') {
    $.ajax({
        url: App.cust() + "list",
        method: 'POST',
        data: { search: search },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                renderExpertiseTable(response);
            } else {
                html = `<div class="text-center py-8">
                    <h3 class="text-lg font-medium text-gray-700">No Data found</h3>
                </div>`
                $('#categorytable').html(html);
            }
        }

    })
}
loadCategories();
let currentPage = 1;
let rowsPerPage = 10;
let allData = [];

function renderExpertiseTable(response) {

    let html = '';
    allData = response;
    if (response.categories.length === 0) {
        html += `<div class="text-center py-8">
                    <h3 class="text-lg font-medium text-gray-700">No Data found</h3>
                    <p class="text-gray-500 mt-1">${(results.message ? results.message : 'Try adjusting your search')}</p>
                </div>`
    } else {
        let start = (currentPage - 1) * rowsPerPage;
        let end = start + rowsPerPage;
        let paginatedData = allData.categories.slice(start, end);
        html += `
        <div class="overflow-x-auto w-full">
            <table class="min-w-full border border-gray-200 divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">S/N</th>
                        <th class="px-4 py-3 text-left font-medium">Category</th>
                        <th class="px-4 py-3 text-center font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">`
        paginatedData.forEach(function (item, idx) {
            html += `<tr>
                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">${start + idx + 1}</td>
                
                <td class="px-2 py-2 text-gray-700 break-words max-w-x border border-gray-300 font-extralight">${item.category}</td>
                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">
                    <button class="btn btn-sm btn-primary edit-expertise"  onclick="openModal('${item.encrypted_id}')">Edit</button>
                    <button class="btn btn-sm btn-danger delete-expertise" type="button" onclick="deleteItem(this)" data-id="${item.encrypted_id}" data-id="${item.id}">Delete</button>
                </td>
            </tr>`;
        });
        html += `</tbody>
        </table></div>`;

        let totalPages = Math.ceil(response.categories.length / rowsPerPage);
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


$('#categoryForm').on('submit', function (e) {
    let webForm = $('#categoryForm');
    let modal = $('#categoryModal');
    e.preventDefault();
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#submitBtn').prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
    );
    $.ajax({
        url: App.cust() + 'save',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                toastr.success(response.message);
                webForm[0].reset();
                modal.addClass('hidden');
                loadCategories();
            } else {
                if (response.errors) {
                    $.each(response.errors, function (field, message) {
                        $('#' + field).addClass('is-invalid');
                        $('#' + field + '_error').text(message);
                    })
                } else {
                    toastr.error(response.message);
                }
            }
        }, error: function () {
            toastr.error('An error occurred while saving Category');
        },
        complete: function () {
            // Re-enable submit button
            $('#submitBtn').prop('disabled', false).text('Save Category');
        }
    })
})
function deleteItem(e) {
    if (confirm('are you sure ! You want to delete the Category')) {
        $(e).prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...'
        );
        let id = $(e).data('id');
        $.ajax({
            url: App.cust() + 'delete/' + id,
            method: 'DELETE',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                    loadCategories();
                } else {
                    toastr.error(response.message);
                    $(e).prop('disabled', false).html('Deleting');
                }
            }
        })
    }
}
//})
function unlockCategory(e) {
    if (confirm('are you sure ! You want to Unlock Category')) {
        $(e).prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Unlocking...'
        );
        let id = $(e).data('id');
        $.ajax({
            url: App.getSiteurl() + 'admin/category/unlock',
            method: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(function () {
                        loadCategories();
                    }, 3000)


                } else {
                    toastr.error(response.message);
                }
            }
        })
    }
}