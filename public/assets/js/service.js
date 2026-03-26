function openPanelservice() {
    document.getElementById('slidePanel').classList.remove('translate-x-full');
}

function closePanel() {
    document.getElementById('slidePanel').classList.add('translate-x-full');
}

loadClients();

$('#searchInput').on('input',function(){
    let value = $(this).val();
    loadClients(value);
})
$('#filerStatus').on('change',function(){
  
    let value = $('#searchInput').val();
    loadClients(value);
})
        
$('#blogForm').on('submit', function(e) {

    let webForm = $('#blogForm');
    e.preventDefault();
    let formData = new FormData(this);

    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();

    $('#blogForm #saveBtn').prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
    );

    $.ajax({

        url : App.getSiteurl()+'services/service-save',
        method:'POST',
        data: formData,
        contentType: false,
        processData: false,

        success:function(response)
        {
           
            if(response.success)
            {
                toastr.success(response.message);
                webForm[0].reset();
                $('#blogForm #saveBtn').prop('disabled', false).text('Save');
                    loadClients();
            }else{
                if(response.errors){
                    $.each(response.errors,function(field,message)
                    {
                        $('#'+ field).addClass('is-invalid');
                        $('#' + field + '_error').text(message);
                    })
                }else{
                    toastr.error(response.message);
                }
            }
            },error: function() {
                toastr.error('An error occurred while saving Service');
            },
            complete: function() {
                // Re-enable submit button
                $('#blogForm #saveBtn').prop('disabled', false).text('Save ');
            }
    })
})



function loadClients(search = '') {
    let filer = $('#filerStatus').val();
    let client = $('#clientsTable').data('client')

    $.ajax({
        url: App.getSiteurl()+'services/search',
        type: "GET",
        data: { client:client,search: search,filer:filer },
        dataType: "json",
        success: function(response) {
            
            if (response.success) {
                renderTable(response.services);
            }
        }
    });
}

function renderTable(services){
    let html = '';
    if (services.length === 0) {
        html += `
            <div class="text-center py-8">
                <h3 class="text-lg font-medium text-gray-700">No Item found</h3>
                <p class="text-gray-500 mt-1">Try adjusting your search</p>
            </div>
        `;
    }else{
        html += `
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
        `;
        services.forEach(service => {
  
    let joinedDate = new Date(service.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
            html += `
                <tr class="hover:bg-gray-50">
                    <td class="px-2 py-2 whitespace-nowrap">
                        <div class="flex items-center">
                            ${service.title ? 
                               
                                `<div class="h-9 w-9 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <span class="text-blue-600 font-medium">${service.title.charAt(0)}</span>
                                </div>`:  `<img class="h-9 w-9 rounded-full mr-3" src="${service.title}" alt="${service.title}">` 
                            }
                            <div class="text-sm font-medium text-gray-900">${service.title}</div>
                        </div>
                    </td>
                    <td class="px-2 py-2 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            <img src="${service.image}" class="w-15 h-15 rounded-full border" />
                        </div>
                    </td>
                    <td class="px-2 py-2 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${joinedDate}</div>
                    </td>
                  
                 
                    <td class="px-2 py-2 whitespace-nowrap text-right text-sm font-medium">
                        <a href="javascript:void(0)" onclick="deleteService(this)" data-id="${service.encrypted_id}" class="!text-red-600 !hover:red-blue-800 mr-3"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            `;
        });
        
        html += `</tbody></table>`;
    }
    $('#clientsTable').html(html);
}


function deleteService(e) {
    if (confirm("are you sure")) {
        let id = $(e).data('id');
         $.ajax({
            url : App.getSiteurl()+'service/delete',
            method:'POST',
            data: {id:id},
            dataType : 'json',
            success:function(response)
            {
                if(response.success)
                {
                    toastr.success(response.message);
                    setTimeout(function() {
                        loadClients();
                    }, 3000);
                }else{
                    toastr.error(response.message);
                }
            }
        })
    }
}