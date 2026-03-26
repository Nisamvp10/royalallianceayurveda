function nextStep(step) {
    document.querySelectorAll('.step').forEach(el => el.classList.add('hidden'));
    document.getElementById(`step${step}`).classList.remove('hidden');
}

function prevStep(step) {
    document.querySelectorAll('.step').forEach(el => el.classList.add('hidden'));
    document.getElementById(`step${step}`).classList.remove('hidden');
}

$('#registerForm').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    $.ajax({
        url: App.getSiteurl() + '/register',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.success) {
                window.location.href = response.url;
            } else {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                if (response.errors) {
                    $.each(response.errors, function (field, msg) {
                        $('#' + field).addClass('is-invalid');
                        $('#' + field + 'Error').text(msg.replaceAll('_', ' '));
                    })
                }
            }
        }
    });
})

$('#loginForm').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#loginBtn').prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Login...'
    );

    $.ajax({
        url: App.getSiteurl() + '/user-login',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                window.location.href = response.url;
            } else {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                if (response.errors) {
                    $.each(response.errors, function (field, msg) {
                        $('#' + field).addClass('is-invalid');
                        $('#' + field + 'Error').text(msg.replaceAll('_', ' '));
                    })
                }
                $('#loginBtn').prop('disabled', false).html('Login');
            }
        }
    });
})

$('#forgotPasswordForm').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#forgotPasswordBtn').prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...'
    );

    $.ajax({
        url: App.getSiteurl() + 'emailverify',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                toastr.success(response.message);
                $('#forgotPasswordForm')[0].reset();
                $('#forgotPasswordBtn').prop('disabled', false).html('Send Reset Code');
                setTimeout(function () {
                    window.location.href = response.url;
                }, 2000);

            } else {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                if (response.errors) {
                    $.each(response.errors, function (field, msg) {
                        toastr.error(msg);
                        $('#' + field).addClass('is-invalid');
                        $('#' + field + 'Error').text(msg.replaceAll('_', ' '));
                    })
                }
                $('#forgotPasswordBtn').prop('disabled', false).html('Send Reset Code');
            }
        }
    });
})

$('#verifyOtpForm').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#verifyOtpBtn').prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Verifying...'
    );

    $.ajax({
        url: App.getSiteurl() + 'verifyotp',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                toastr.success(response.message);
                $('#verifyOtpForm')[0].reset();
                $('#verifyOtpBtn').prop('disabled', false).html('Verify OTP');
                setTimeout(function () {
                    window.location.href = response.url;
                }, 2000);

            } else {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                if (response.errors) {
                    $.each(response.errors, function (field, msg) {
                        toastr.error(msg);
                        $('#' + field).addClass('is-invalid');
                        $('#' + field + 'Error').text(msg.replaceAll('_', ' '));
                    })
                }
                $('#verifyOtpBtn').prop('disabled', false).html('Verify OTP');
            }
        }
    });
})

$('#resendOtpBtn').on('click', function (e) {
    e.preventDefault();
    $('#resendOtpBtn').prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...'
    );
    $.post(App.getSiteurl() + 'resendotp', $(this).serialize(), function (res) {
        if (res.success) {
            toastr.success(res.message);
        } else {
            toastr.error(res.message);
        }
        $('#resendOtpBtn').prop('disabled', false).text('Resend OTP');
    });
})

$('#resetPwdForm').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#resetOtpBtn').prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Resetting...'
    );

    $.ajax({
        url: App.getSiteurl() + 'reset-password',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                toastr.success(response.message);
                $('#resetPwdForm')[0].reset();
                $('#resetOtpBtn').prop('disabled', false).html('Reset Password');
                setTimeout(function () {
                    window.location.href = response.url;
                }, 2000);

            } else {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                if (response.errors) {
                    $.each(response.errors, function (field, msg) {
                        toastr.error(msg);
                        $('#' + field).addClass('is-invalid');
                        $('#' + field + 'Error').text(msg.replaceAll('_', ' '));
                    })
                }
                $('#resetOtpBtn').prop('disabled', false).html('Reset Password');
            }
        }
    });
})
