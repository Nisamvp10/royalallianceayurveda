function openModal(id = false) {
    toggleModal('achievementModal', true);
    let myTitle = $('#secTitle').data('title');
    let modal = $('#achievementModal');
    modal.find('.head').text('Add New ' + myTitle);
    const webForm = document.getElementById('achievementForm');
    $('#edit_id').val('');
    webForm.querySelector('#title').value = '';
    webForm.querySelector('#note').value = '';
    webForm.querySelector('#description').value = '';
    $('#selectedPreview').addClass('hidden');
    webForm.querySelector('#previewImg').src = '';
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    if (id) {
        $('#edit_id').val(id)
        fetch(App.getSiteurl() + 'admin/edit-achievements/' + `${id}`)
            .then(res => res.json())
            .then(result => {
                if (result) {
                    console.log(result);
                    $('#achievementModal').find('.head').text('Edit ' + myTitle);
                    webForm.querySelector('#title').value = result.title;
                    webForm.querySelector('#note').value = result.note;
                    webForm.querySelector('#description').value = result.description;
                    if (result.image) {
                        $('#selectedPreview').removeClass('hidden');
                        webForm.querySelector('#previewImg').src = result.image
                            ? result.image
                            : App.getSiteurl() + 'uploads/achievements/default.jpg';
                    }
                }
            })
    }
}

function loadData(search = '') {

    $.ajax({
        url: App.getSiteurl() + 'admin/achievements/data',
        method: 'POST',
        data: { search: search },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                renderTable(response);
            } else {
                html = `<div class="text-center py-8">
                    <h3 class="text-lg font-medium text-gray-700">No Data found</h3>
                </div>`;
                $('#achievementTable').html(html);
            }
        }

    })
}
loadData();
let currentPage = 1;
let rowsPerPage = 10;
let allData = [];

function renderTable(response) {

    let html = '';
    allData = response;
    if (response.result.length === 0) {
        html += `<div class="text-center py-8">
                    <h3 class="text-lg font-medium text-gray-700">No Data found</h3>
                    <p class="text-gray-500 mt-1">${(results.message ? results.message : 'Try adjusting your search')}</p>
                </div>`
    } else {
        let start = (currentPage - 1) * rowsPerPage;
        let end = start + rowsPerPage;
        let paginatedData = allData.result.slice(start, end);
        html += `
        <div class="overflow-x-auto w-full">
            <table class="min-w-full border border-gray-200 divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">S/N</th>
                        <th class="px-4 py-3 text-left font-medium">Image</th>
                        <th class="px-4 py-3 text-left font-medium">Title</th>
                        <th class="px-4 py-3 text-left font-medium">Note</th>
                        <th class="px-4 py-3 text-left font-medium">Description</th>
                        <th class="px-4 py-3 text-center font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">`
        paginatedData.forEach(function (item, idx) {
            html += `<tr>
                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">${start + idx + 1}</td>
                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">
                    <div class="flex items-center">
                        <div class="text-sm font-medium text-gray-900">
                        <img src="${item.image ? item.image : App.getSiteurl() + 'uploads/default.png'}" class="w-20" />
                        </div>
                    </div>
                </td>
                <td class="px-2 py-2 text-gray-700 break-words max-w-x border border-gray-300 font-extralight">${item.title}</td>
                <td class="px-2 py-2 text-gray-700 break-words max-w-x border border-gray-300 font-extralight">${item.note}</td>
                <td class="px-2 py-2 text-gray-700 break-words max-w-x border border-gray-300 font-extralight">${item.description}</td>
                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">
                    <button class="btn btn-sm btn-primary edit-expertise" onclick="openModal('${item.encrypted_id}')">Edit</button>
                    <button class="btn btn-sm btn-danger delete-expertise" type="button" onclick="deleteItem(this)" data-id="${item.encrypted_id}" data-id="${item.id}">Delete</button>
                </td>
            </tr>`;
        });
        html += `</tbody>
        </table></div>`;

        let totalPages = Math.ceil(response.result.length / rowsPerPage);
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
    $('#achievementTable').html(html);
}
$('#searchProductInput').on('input', function () {
    search = $(this).val();
    loadData(search);

})

// Change rows per page
function changeRowsPerPage(value) {
    rowsPerPage = parseInt(value);
    currentPage = 1;
    renderTable(allData);
}

// Pagination functions
function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        renderTable(allData);
    }
}
function nextPage(totalPages) {
    if (currentPage < totalPages) {
        currentPage++;
        renderTable(allData);
    }
}

$('#achievementForm').on('submit', function (e) {
    let modal = $('#achievementModal');
    const previewImg = $('#previewImg');
    let webForm = $('#achievementForm');
    e.preventDefault();
    const formData = new FormData(this);
    e.preventDefault();
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#submitBtn').prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
    );
    $.ajax({
        url: App.getSiteurl() + 'admin/achievements/save',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',

        success: function (response) {

            if (response.success) {
                toastr.success(response.message);
                webForm[0].reset();
                modal.addClass('hidden');
                previewImg.attr('src', '');
                $('#edit_id').val('');
                loadData();
            } else {
                if (response.errors) {
                    $.each(response.errors, function (field, message) {
                        $('#' + field).addClass('is-invalid');
                        $('#' + field + '_error').text(message.replaceAll('_', ' '));
                    })
                } else {
                    toastr.error(response.message);
                }
            }
        }, error: function () {
            toastr.error('An error occurred while saving ');
        },
        complete: function () {
            // Re-enable submit button
            $('#submitBtn').prop('disabled', false).text('Save ');
        }
    })
})

function deleteItem(e) {
    let id = $(e).data('id');
    if (confirm('are you sure You want to Delete This')) {
        if (id) {
            $.ajax({
                url: App.getSiteurl() + 'admin/achievements/delete/' + id,
                type: "DELETE",
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire({ title: "Done!", text: response.message, icon: "success" });
                        loadData();
                    } else {
                        Swal.fire({ title: "Oops!", text: response.message, icon: "error" });
                    }
                }
            })
        } else {
            toastr.error('OOps Item Not Found !Pls try later', 'Error', {
                allProductstimeOut: 10000,
                extendedTimeOut: 5000,
                closeButton: true,
                progressBar: true
            });
        }
    }
}