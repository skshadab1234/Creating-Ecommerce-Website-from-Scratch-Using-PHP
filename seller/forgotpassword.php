<?php
    require 'includes/session.php';

    if (isset($_SESSION['SELLER_ID'])) {
        redirect(SELLER_FRONT_SITE);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login to Seller Account</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-size: 14px;
            line-height: 1.8;
            color: #222;
            font-weight: 400;
            font-family: 'Open Sans', sans-serif;
            background-image: linear-gradient(rgb(0, 120, 212) 0%, rgba(0, 120, 212, 0.9) 100%)!important;
            background-repeat: no-repeat;
            padding: 15px 0;
            height: 100vh;
            }

            body.swal2-shown > [aria-hidden="true"] {
            transition: 0.1s filter;
            filter: blur(10px);
            }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center" style="height:100vh!important;">
    <div class="main">
        <section class="signup">
            <div class="container">
                <div class="row">
                    <div class=" signup-content">
                        <div class="card-body">
                            <form id="forgotpass-form" class="" method="post" action="" style="display:">
                                <h2 class="mb-5 h5">Forgot your Seller Account Password</h2>
                                <div class="form-group">
                                    <input type="text" class="form-control w-30 mr-3" name="reset_email" placeholder="Email id" />
                                    <input type="hidden" name="RESETEMAIL_PASSWORD_LINK">
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-primary form-control" id="reset_pass_btn" >Send Reset Link</button> 
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            Go Back to <a href="<?= SELLER_FRONT_SITE.'logintoseller' ?>">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- jquery-validation -->
    <script src="https://adminlte.io/themes/v3/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/jquery-validation/additional-methods.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="js/main.js"></script>
    <script>
          $.validator.setDefaults({
            submitHandler: function(form) {
                $("#reset_pass_btn").attr("disabled", true);
                $("#reset_pass_btn").html("Sending Mail");
                $.ajax({
                    url:"seller_ajax_call.php",
                    type: "POST",
                    data:$(form).serialize(),
                    success: (result) => {
                        var data = $.parseJSON(result);

                        $("#reset_pass_btn").attr("disabled", false);
                        $("#reset_pass_btn").html("Send reset link");

                        if (data.status == 'success') {
                            $("#forgotpass-form")[0].reset();
                            Swal.fire({
                                icon: 'success',
                                text: data.message,
                                title: 'Check Your Mail',
                            })
                        }

                        else if (data.status == 'error') {
                            Swal.fire({
                                icon: 'error',
                                text: data.message,
                                title: 'Email id Not Found',
                            })
                        }
                    }
                })
            }
        });
        $('#forgotpass-form').validate({
            rules: {
                reset_email : {
                    required: true,
                    email:true,
                },

            },
            messages: {
                reset_email: {
                    email: 'Enter Valid Email',
                }

            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

       
    </script>
</body>

</html>