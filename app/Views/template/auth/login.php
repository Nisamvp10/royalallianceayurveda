<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="<?=site_url('public/assets/src/output.css');?>" rel="stylesheet" >
    <link href="<?=site_url('public/assets/css/login.css');?>" rel="stylesheet" >
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">

   
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <div class="rounded-full border border-1 border-solid shadow mr-2 w-[60px] h-[60px] m-auto"><?= (getappdata('applogo') ? '<img class="d-block w-100" src="'.base_url(getappdata('applogo')).'">' :  '<i class="">'.substr(getappdata('company_name'), 0, 1) ).'</i>'; ?></div>
            <h1><?=getappdata('company_name');?></h1>
            <p>Admin Panel</p>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0 text-center">Sign In</h4>
            </div>
            <div class="card-body p-4">
                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger">
                        <?= session('error') ?>
                    </div>
                <?php endif; ?>
                
              
                
                <form  method="post" id="loginForm">
                <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="password" value="<?= old('password') ?>" name="password" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" id="submitBtn">Sign In</button>
                </form>
            </div>
        </div>
        
        <div class="login-footer">
            &copy; <?= date('Y') ?> <?=getappdata('company_name');?>. All Rights Reserved.
        </div>
    </div>
    <!-- alert -->

   

     <!-- close Alert -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('public/assets/js/jquery-3.6.0.min.js') ?>" ></script>
    <script src="<?= base_url('public/assets/js/bootstrap.bundle.min.js') ;?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('public/assets/js/toastr.min.js') ;?>"></script>


    <script>
       $('#loginForm').submit(function(e) {

           let webForm = $('#loginForm');
            e.preventDefault();
            let formData = new FormData(this);

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();

            $('#submitBtn').prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loggedin...'
            );

               $.ajax({
                url : '<?=base_url('login');?>',
                method:'POST',
                data: formData,
                contentType: false,
                processData: false,
                success:function(response)
                {  
                    if(response.success) {
                        window.location.href='<?=base_url('admin/login') ?>';
                    }else{
                        if(response.errors){
                            console.log(response.errors);
                            $.each(response.errors,function(field,message){
                                $('#'+ field).addClass('is-invalid');
                                $('#' + field + '_error').text(message);
                                 toastr.error(message);
                            })
                        }else{
                             toastr.error(response.message);
                        }
                        $('#submitBtn').prop('disabled', false).text('Sign In');
                    }
                }
            })
        });

        setTimeout(() => {
            var alert = document.querySelector('.alert');
            if(alert){
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
            }
        }, 3000);
    </script>
</body>
</html>