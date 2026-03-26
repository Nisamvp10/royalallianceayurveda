function openModal(id=false){
    toggleModal('staffModal', true);
    let modal = $('#staffModal');
    modal.find('.head').text('Add New Team Member');
    const webForm = document.getElementById('teamForm');
    webForm.querySelector('#name').value='';
    webForm.querySelector('#email').value='';
    webForm.querySelector('#phone').value='';
    webForm.querySelector('#instagram').value='';
    webForm.querySelector('#twitter').value='';
    webForm.querySelector('#role').value='';
    webForm.querySelector('#facebook').value='';
    webForm.querySelector('#linkedin').value='';
    webForm.querySelector('#position').value='';
    $('#selectedPreview').addClass('hidden');
    webForm.querySelector('#previewImg').src = '';
    $('#edit_id').val('');
    if(id){
        $('#edit_id').val(id)
        fetch(App.getSiteurl()+'admin/edit-staff/'+`${id}`)
        .then(res => res.json())
        .then(result => {
            if(result) {
                modal.find('.head').text('Edit Member Info');
                webForm.querySelector('#name').value=result[0].name ?? '';
                webForm.querySelector('#email').value=result[0].email ?? '';
                webForm.querySelector('#phone').value=result[0].phone ?? '';
                webForm.querySelector('#instagram').value=result[0].instagram ?? '';
                webForm.querySelector('#twitter').value=result[0].twitter ?? '';
                //webForm.querySelector('#role').value=result[0].role ?? '';
                $('#role').val(result[0].roleId ?? '').trigger('change');
                webForm.querySelector('#facebook').value=result[0].facebook ?? '';
                webForm.querySelector('#linkedin').value=result[0].linkedin ?? '';
                webForm.querySelector('#position').value=result[0].position ?? $result[0].position ?? '';
                if(result[0].profileimg) {
                $('#selectedPreview').removeClass('hidden');
                webForm.querySelector('#previewImg').src = result[0].profileimg 
                ? result[0].profileimg 
                : App.getSiteurl() + 'uploads/user/default.jpg';
            }
            }
        })

    }
}

$('#teamForm').on('submit', function(e) {
    let modal =  $('#staffModal');
    const previewImg = $('#previewImg');
    let webForm = $('#teamForm');
    e.preventDefault();
    const formData = new FormData(this);
    e.preventDefault();
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#submitBtn').prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
    );
    $.ajax({
        url : App.getSiteurl() +'admin/staff/save',
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
                loadClients();
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
function deletestaff(e){
    let id = $(e).data('id');
    if(confirm('are you sure You want to Delete This')) {
        if(id) {
            $.ajax({
                url : App.getSiteurl()+'admin/staff/delete/'+ id,
                type: "DELETE",
                dataType: 'json',
                success:function(response)
                { 
                   if(response.success){
                     Swal.fire({  title: "Done!",  text:response.message,  icon: "success"});
                     loadClients();
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