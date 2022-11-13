$(document).ready(function() {
    var formLogin = $("#form-login");

    formLogin.validate({
        validClass: "success",
        rules: {
            username: {
                required: true,
            },
            password: {
                required: true,
            },
        },
        errorPlacement: function(error, element) {
            $(element).closest('.form-group').find('.form-text').html(error.html());
        },
        success: function(element) {
            $(element).closest('.form-group').find('.form-text').html('');
        },
        submitHandler: function(form) {
            $("#btn-submit-login").prop('disabled', true);
            $("#btn-submit-login").html('<i class="fa fa-spinner"></i> Processing...');

            var formData = new FormData(form);

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/auth/login",
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                },
                success: function(resp) {
                    if (resp.success == true) {
                        window.location.href = '/dashboard';
                    } else {
                        $("#err-message").html(resp.message);
                    }

                    $("#btn-submit-login").prop('disabled', false);
                    $("#btn-submit-login").html('Login');
                },
                error: function(xhr, textstatus, errorthrown) {
                    if (textstatus == "timeout") {
                        this.tryCount++;
                        if (this.tryCount <= this.retryLimit) {
                            $.ajax(this);
                        }
                    } else {
                        $("#err-message").html('Gagal Login');
                    }
                    $("#btn-submit-login").prop('disabled', false);
                    $("#btn-submit-login").html('Login');
                },
            });
        },
    });

});