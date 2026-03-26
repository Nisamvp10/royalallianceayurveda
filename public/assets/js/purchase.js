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
            url : App.getSiteurl()+'purachse/update',
            method:'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success:function(response)
            { 
            
                if(response.success){
                    toastr.success(response.message);
                    $('#submitBtn').prop('disabled', false).html('Saving');
                    webForm[0].reset();
                    setTimeout(function () {
                    window.location.href=App.getSiteurl() +'admin/inventory';
                    },1000);
                   
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
                            } else if(response.stock_errors){
                               console.log(response.stock_errors);

                                response.stock_errors.forEach(msg => {
                                    toastr.error(msg.stock_error);
                                });
                               
                                // $.each(response.stock_errors,function(field,message){
                                //     toastr.error(message);
                                // })
                              
                            }else{
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