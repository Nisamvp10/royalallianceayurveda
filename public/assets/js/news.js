function openModal(id=false) {
    let modal = $('#newsModal');
    toggleModal('newsModal',true);
    modal.find('.head').text('Add News');
    let webForm = document.getElementById('newsForm');
    webForm.querySelector('#title').value = '';
    webForm.querySelector('#type').value = '';
    webForm.querySelector('#note').value = '';
    webForm.querySelector('#description').value = '';
    tinymce.get('description').setContent('');
    $('#selectedPreview').addClass('hidden');
    webForm.querySelector('#previewImg').src = '';
    const preview = $('#selectedMultiPreview');
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    prevStep(1);
    let html ='';
    preview.html(html)
    $('#edit_id').val('');
    if(id) {
        $('#edit_id').val(id);
         modal.find('.head').text('Edit News');
       fetch(App.getSiteurl() +'admin/edit-news/'+`${id}`)
       .then(res => res.json())
       .then(result =>{
        if(result) {
           
                webForm.querySelector('#title').value = result[0].title;
                //webForm.querySelector('#status').value = result[0].status;
                $('#status').val(result[0].jobType ?? '').trigger('change');
                $('#duration').val(result[0].duration ?? '').trigger('change');
                webForm.querySelector('#note').value = result[0].shortnote;
                webForm.querySelector('#description').value = result[0].description;
                tinymce.get('description').setContent(result[0].description);
                webForm.querySelector('#type').value = result[0].type;
                webForm.querySelector('#edit_id').value = result[0].careerId;
                if( result[0].image) {
                    $('#selectedPreview').removeClass('hidden');
                    webForm.querySelector('#previewImg').src = result[0].image;
                }
                if (result[0].gallery && result[0].gallery.length > 0) {
                    console.log(result[0].gallery.length)

                    $('#selectedMultiPreview').removeClass('hidden');
                     result[0].gallery.forEach(rs => {
                    let i =0;
                     html+=`
                        <div class="relative group inline-block m-1">
                        <img src="${rs.img}" class="w-100 h-24 object-cover border rounded">
                        <span class="absolute delete-btn top-1 right-1 bg-red-500 text-white rounded-full p-1 text-xs hidden group-hover:block" data-id="${rs.imgId}">✕</span>
                        </div>`
                     })
                     preview.html(html)
                    }
                $("#productWrapper").empty();
                  $("#productWrapper").append(`<div class="border border-gray-200 rounded-lg p-2 new-row text-right">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold">New Points</label>
                                    <button type="button" onclick="addPoint()" class="text-blue-600 text-sm">+ Add Point</button>
                                </div>
                            </div>`);
                if (result[0].highlights && result[0].highlights.length > 0) {
                    result[0].highlights.forEach(carpoin => {
                        

                        const escapeHtml = (text) => {
                            return text
                                .replace(/&/g, "&amp;")
                                .replace(/</g, "&lt;")
                                .replace(/>/g, "&gt;")
                                .replace(/"/g, "&quot;")
                                .replace(/'/g, "&#039;");
                        };

                        const safeValue = escapeHtml(carpoin.points);

                        let newRow = `
                            <div class="border border-gray-200 rounded-lg py-2 px-2 new-row mt-2">
                                <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-4 gap-4">
                                    <div class="md:col-span-3">
                                        <label>Meta Descriptions for Seo *</label>
                                        <input type="hidden" name="pointId[]" value="${carpoin.pointId}" />
                                        <textarea  name="points[]" rows="3" class="w-full border p-2 rounded mb-2 mt-2" placeholder="Another highlight">${safeValue}</textarea>
                                        <div class="invalid-feedback" id="points_error"></div>
                                    </div>
                                    <!-- Delete Button -->
                                    <div class="flex items-end align-items-center">
                                        <button type="button" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors removeRow">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2 w-4 h-4">
                                                <path d="M3 6h18"></path>
                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                <line x1="10" x2="10" y1="11" y2="17"></line>
                                                <line x1="14" x2="14" y1="11" y2="17"></line>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>`;

                        $("#productWrapper").append(newRow);
                        updateItemNumber();
                    });
                }

            }
        })
    }else{
        $("#productWrapper").empty();
         $("#productWrapper").append(` <div class="border border-gray-200 rounded-lg p-4 new-row mt-2">
            <div>
                <label class="block mb-2 text-sm font-semibold">Meta Descriptions for Seo</label>
                <div id="points">
                    <input type="text" name="points[]" class="w-full border p-2 rounded mb-2" placeholder="Highlight point 1">
                    <div class="invalid-feedback" id="points_error"></div>
                </div>
                <button type="button" onclick="addPoint()" class="text-blue-600 text-sm mb-4">+ Add Point</button>
            </div>
        </div>`);
    }
}

 function nextStep(step) {
      document.querySelectorAll('.step').forEach(el => el.classList.add('hidden'));
      document.getElementById(`step${step}`).classList.remove('hidden');
      updateProgress(step);
    }

    function prevStep(step) {
      document.querySelectorAll('.step').forEach(el => el.classList.add('hidden'));
      document.getElementById(`step${step}`).classList.remove('hidden');
      updateProgress(step);
    }

    function updateProgress(step) {
      [1,2,3].forEach(i => {
        const circle = document.getElementById(`step${i}circle`);
        if (i <= step) {
          circle.classList.add('bg-blue-600','text-white');
          circle.classList.remove('bg-gray-300','text-gray-700');
        } else {
          circle.classList.remove('bg-blue-600','text-white');
          circle.classList.add('bg-gray-300','text-gray-700');
        }
      });
    }

    function addPoint() {
     addNewRow()
    }

$(document).on('change', 'input[name="points[]"]', function () {
    let lastSelect = $('input[name="points[]"]').last();
    // If the changed dropdown is the last one
    if ($(this).is(lastSelect) && $(this).val() !== "") {
        addNewRow();
    }
});
function updateItemNumber() {
    $('#productWrapper .new-row').each(function(index){
        let rowIndex = index + 1;

        $(this).find('.item-title').text('Item ' + rowIndex);

        // Update category ID and error
        $(this).find('input[name="points[]"]').attr('id', 'points' + rowIndex);
        $(this).find('#points_error').attr('id', 'points' + rowIndex + '_error');
    });
}
  function addNewRow() {
    let newRow = `
    <div class="border border-gray-200 rounded-lg py-2 px-2 new-row mt-2">
        <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-4 gap-4">
            <div class="md:col-span-3">
                <label>Highlights Points *</label>
                <input type="text" name="points[]" class="w-full border p-2 rounded mb-2 mt-2" placeholder="Another highlight">
                <div class="invalid-feedback" id="points_error"></div>
            </div>
            <!-- Delete Button -->
            <div class="flex items-end align-items-center">
                 <button type="button" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors removeRow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2 w-4 h-4"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line>
                    </svg>
                </button>
            </div>
        </div>
    </div>`;

    $("#productWrapper").append(newRow);
    updateItemNumber();
    
}
// Remove row
$(document).on('click', '.removeRow', function () {
    $(this).closest('.new-row').remove();
});

    // document.getElementById('serviceForm').addEventListener('submit', e => {
    //   e.preventDefault();
    //   const formData = new FormData(e.target);
    //   const data = Object.fromEntries(formData.entries());
    //   data.points = formData.getAll('points[]');
    //   console.log("Final Data:", data);

    //   // Send to server via AJAX or fetch
    //   fetch('save_service.php', {
    //     method: 'POST',
    //     body: JSON.stringify(data),
    //     headers: {'Content-Type': 'application/json'}
    //   }).then(res => res.json()).then(response => {
    //     alert('Service saved successfully!');
    //   });
    // });
    tinymce.init({
      selector: '#description',
      plugins: 'lists link image table code',
      toolbar: 'undo redo | bold italic underline | bullist numlist | link image | code',
      height: 300,
      menubar: false,
      branding: false
    });

    $('#newsForm').on('submit', function(e) {
         tinymce.triggerSave();
    let modal =  $('#newsModal');
    const previewImg = $('#previewImg');
    let webForm = $('#newsForm');
    e.preventDefault();
    const formData = new FormData(this);
    e.preventDefault();
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#submitBtn').prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
    );
    $.ajax({
        url : App.getSiteurl() +'admin/news/save',
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
                loadNews();
            }else{
                if(response.errors){
                    $.each(response.errors,function(field,message)
                    {
                        toastr.error(message.replaceAll('_',' '));
                        $('#'+ field).addClass('is-invalid');
                        $('#' + field + '_error').text(message.replaceAll('_',' '));
                    })
                }else{
                    if(response.pointsErrors) {
                        $(".error-text").remove();
                        $.each(response.pointsErrors,function(filed,message) {
                            let parts = filed.split('.');
                            let fieldName = parts[0];
                            let index = parts[1];
                            toastr.error(message);
                             
                            if (typeof index !== "undefined") { 
                                let input = $("[name='" + fieldName + "[]']").eq(index);
                                if (input.length > 0) {
                                    input.after('<span class="error-text text-danger">' + message + '</span>');
                                }

                            }else {
                                let input = $("input='"+fieldName+"[]'").eq(index);
                            }
                        })

                    }else{
                     toastr.error(response.message);
                    }
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

loadNews();

function loadNews(search ='') {
    $.ajax({
        url : App.getSiteurl() +'admin/news/data',
        method:'POST',
        data:{search:search},
        dataType: 'json',
        success:function(res) {
            if(res.success) {
                renderfun(res);
            }else{
                  html = `<div class="text-center py-8">
                    <h3 class="text-lg font-medium text-gray-700">No Data found</h3>
                    <p class="text-gray-500 mt-1">${(res.message ? res.message :'Try adjusting your search')}</p>
                </div>`
                $('#newstable').html(html);
            }
        }
    })
}
let currentPage = 1 ;
let rowsPerPage = 10;
let allData = [];
function renderfun(response) {
    let html = '';
    allData = response;
    if(response.result.length ===0){
        html += `<div class="text-center py-8">
                    <h3 class="text-lg font-medium text-gray-700">No Data found</h3>
                    <p class="text-gray-500 mt-1">${(results.message ? results.message :'Try adjusting your search')}</p>
                </div>`
            $('#newstable').html(html);
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
                        <th class="px-4 py-3 text-left font-medium">Image</th>
                        <th class="px-4 py-3 text-left font-medium">Title</th>
                        <th class="px-4 py-3 text-left font-medium">Points</th>
                        <th class="px-4 py-3 text-left font-medium">Short Description</th>
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
                        <img src="${item.image ? item.image : App.getSiteurl() +'uploads/default.png'}" class="w-20" />
                        </div>
                    </div>
                </td>
                <td class="px-2 py-2 text-gray-700 break-words max-w-x border border-gray-300 font-extralight">${item.title}</td>
                <td class="px-2 py-2 text-gray-700 break-words max-w-x border border-gray-300 font-extralight">`
                if(item.highlights) { 
                    let highlights = item.highlights;
                    highlights.forEach(points => {
                         html += `
                                <div class="flex p-0 m-0">
                                <div class="p-0 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">  <circle cx="8" cy="8" r="3.5"/></svg>
                                </div>
                                <div> <p class="px-2 py-2 m-1 text-gray-700 break-words max-w-x border border-gray-300 font-extralight text-xs">${points.points}</p></div>
                                </div>`;
                    })
                }
                html += `</td>
                <td class="px-2 py-2 text-gray-700 break-words max-w-x border border-gray-300 font-extralight text-xs">${item.shortnote}</td>
                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">
                    <button class="btn btn-sm btn-primary edit-expertise" onclick="openModal('${item.careerId}')">Edit</button>
                    <button class="btn btn-sm btn-danger delete-expertise" type="button" onclick="deleteItem(this)" data-id="${item.careerId}" >Delete</button>
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
                
                        <option value="10"  ${rowsPerPage == 10 ? 'selected' : ''}>10</option>
                        <option value="20"  ${rowsPerPage == 20 ? 'selected' : ''}>20</option>
                        <option value="50"  ${rowsPerPage == 50 ? 'selected' : ''}>50</option>
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
    $('#newstable').html(html);
}
function deleteItem(e){
    let id = $(e).data('id');
    if(confirm('are you sure You want to Delete This')) {
        if(id) {
            $.ajax({
                 url : App.getSiteurl()+'admin/news/delete/'+ id,
                type: "DELETE",
                dataType: 'json',
                success:function(response)
                { 
                   if(response.success){
                     Swal.fire({  title: "Done!",  text:response.message,  icon: "success"});
                     loadNews();
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

// function deleteGallery(e) {
//     if(e) {
//         if(confirm('are you sure . You want to delete this ?'))
//         fetch(App.getSiteurl()+'admin/delete-gallery/'+`${e}`, {
//             method: 'POST',    
//         }).then(res => res.json()).then(response => {
//             if(response) {

//             }
//         });
//     }
// }
document.addEventListener('click', function (e) { 
    if (e.target.classList.contains('delete-btn')) {
        const btn = e.target;
        const galleryId = btn.getAttribute('data-id');
        console.log('Deleting gallery:', galleryId);

        // Hide the parent .relative div
        const parentDiv = btn.closest('.relative');
        // if (parentDiv) {
        //     parentDiv.style.display = 'none';
        // }
        if(confirm('are you sure . You want to delete this ?')){
         fetch(App.getSiteurl() + 'admin/news/delete-gallery/' + galleryId, {
                method: 'POST', 
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', 
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(result => {
                 if(result.success) {
                    toastr.success(result.message);
                    parentDiv.style.display = 'none';
                 }else{
                    toastr.error(result.message);
                 }
            })
        }

    }
})