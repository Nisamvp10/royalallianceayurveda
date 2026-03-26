function openModal(id=false) {
    toggleModal('feedbackModal', true);
    let modal = $('#feedbackModal');
    modal.find('.head').text('Add New Feedback');
    const webForm = document.getElementById('feedbackForm');
    $('#edit_id').val('');
    webForm.querySelector('#name').value = '';
    webForm.querySelector('#designation').value = '';
    webForm.querySelector('#note').value = '';
    $('#selectedPreview').addClass('hidden');
    webForm.querySelector('#previewImg').src = '';
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    if(id) {
        $('#edit_id').val(id)
       fetch(App.getSiteurl() +'admin/edit-feedback/'+`${id}`)
       .then(res => res.json())
       .then(result =>{
        if(result) {
            $('#feedbackModal').find('.head').text('Edit Feedback');
            webForm.querySelector('#name').value = result.username;
            webForm.querySelector('#designation').value = result.designation;
            webForm.querySelector('#note').value = result.note;
             if(result.image) {
                $('#selectedPreview').removeClass('hidden');
                webForm.querySelector('#previewImg').src = result.image 
                ? result.image 
                : App.getSiteurl() + 'uploads/feedback/default.jpg';
            }
        }
       })    
    }
}

function loadFeedback(search = '') {
    
    $.ajax({
        url: App.getSiteurl() +'admin/feedback/data',
        method : 'POST',
        data:{search:search},
        dataType: 'json',
        success:function(response){
            if(response.success) {
                renderTable(response);
            }else{
                 html = `<div class="text-center py-8">
                    <h3 class="text-lg font-medium text-gray-700">No Data found</h3>
                </div>`;
                 $('#partnershipTable').html(html);
            }
        }

    })
}
loadFeedback();
let currentPage = 1;
let rowsPerPage = 10;
let allData = [];

function renderTable(response) {
    
    let html = '';
    allData = response;
    if(response.result.length ===0){
        html += `<div class="text-center py-8">
                    <h3 class="text-lg font-medium text-gray-700">No Data found</h3>
                    <p class="text-gray-500 mt-1">${(results.message ? results.message :'Try adjusting your search')}</p>
                </div>`
    }else{
        let start = (currentPage -1) * rowsPerPage;
        let end = start + rowsPerPage;
        let paginatedData = allData.result.slice(start, end);
        html += `
        <div class="overflow-x-auto w-full">
            <table class="min-w-full border border-gray-200 divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">S/N</th>
                        <th class="px-4 py-3 text-left font-medium">Profile</th>
                        <th class="px-4 py-3 text-left font-medium">Name</th>
                        <th class="px-4 py-3 text-left font-medium">Designation</th>
                        <th class="px-4 py-3 text-left font-medium">Note</th>
                        <th class="px-4 py-3 text-center font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">`
        paginatedData.forEach(function(item, idx) {
            html += `<tr>
                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">${start + idx + 1}</td>
                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">
                    <div class="flex items-center">
                        <div class="text-sm font-medium text-gray-900">
                        <img src="${item.profile ? item.profile : App.getSiteurl() +'uploads/default.png'}" class="w-20" />
                        </div>
                    </div>
                </td>
                <td class="px-2 py-2 text-gray-700 break-words max-w-x border border-gray-300 font-extralight">${item.name}</td>
                <td class="px-2 py-2 text-gray-700 break-words max-w-x border border-gray-300 font-extralight">${item.designation}</td>
                <td class="px-2 py-2 text-gray-700 break-words max-w-x border border-gray-300 font-extralight">${item.note}</td>
                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">
                    <button class="btn btn-sm btn-primary edit-expertise" onclick="openModal('${item.encrypted_id}')">Edit</button>
                    <button class="btn btn-sm btn-danger delete-expertise" type="button" onclick="deleteItem(this)" data-id="${item.encrypted_id}" data-id="${item.id}">Delete</button>
                </td>
            </tr>`;
        });
        html +=`</tbody>
        </table></div>`;

        let totalPages = Math.ceil( response.result.length / rowsPerPage);
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
    $('#feedbackTable').html(html);
}
$('#searchProductInput').on('input',function(){
    search = $(this).val();
    loadFeedback(search);

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

$('#feedbackForm').on('submit', function(e) {
    let modal =  $('#feedbackModal');
    const previewImg = $('#previewImg');
    let webForm = $('#feedbackForm');
    e.preventDefault();
    const formData = new FormData(this);
    e.preventDefault();
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#submitBtn').prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
    );
    $.ajax({
        url : App.getSiteurl() +'admin/feedback/save',
        method:'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType : 'json',

        success:function(response)
        { 
           
            if(response.success){
                toastr.success(response.message);
                webForm[0].reset();
                modal.addClass('hidden');
                previewImg.attr('src', '');
                $('#edit_id').val('');
                loadFeedback();
            }else{
                if(response.errors){
                    $.each(response.errors,function(field,message)
                    {
                        $('#'+ field).addClass('is-invalid');
                        $('#' + field + '_error').text(message.replaceAll('_',' '));
                    })
                }else{
                     toastr.error(response.message);
                }
            }
        },error: function() {
            toastr.error('An error occurred while saving ');
        },
        complete: function() {
            // Re-enable submit button
            $('#submitBtn').prop('disabled', false).text('Save ');
        }
    })
})

function deleteItem(e){
    let id = $(e).data('id');
    if(confirm('are you sure You want to Delete This')) {
        if(id) {
            $.ajax({
                 url : App.getSiteurl()+'admin/feedback/delete/'+ id,
                type: "DELETE",
                dataType: 'json',
                success:function(response)
                { 
                   if(response.success){
                     Swal.fire({  title: "Done!",  text:response.message,  icon: "success"});
                     loadFeedback();
                   }else{
                     Swal.fire({  title: "Oops!",  text:response.message,  icon: "error"});
                   }
                }
            })
        }else{
             toastr.error('OOps Item Not Found !Pls try later', 'Error', { 
                allProductstimeOut: 10000,        
                extendedTimeOut: 5000, 
                closeButton: true,     
                progressBar: true      
            });
        }
    }
}