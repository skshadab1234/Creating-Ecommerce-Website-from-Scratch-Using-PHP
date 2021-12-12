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
                            <form id="login-form" class="" method="post" action="" style="display:">
                                <h2 class="mb-5 h5">Login to Seller Account</h2>
                                <div class="form-group">
                                    <input type="text" class="form-control w-30 mr-3" name="LoginEmail" placeholder="Email id" />
                                    <input type="hidden" name="LogintoSellerAccount">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Password" />
                                    <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                                </div>
                                <div class="text-right mb-2">
                                    <a href="<?= SELLER_FRONT_SITE.'forgotpassword' ?>">I forgot my passowrd</a>
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-primary form-control" id="logintoselleracount" disabled>Login</button> 
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            Don't have an Seller Account? <a href="<?= SELLER_FRONT_SITE.'becomeseller' ?>">Create one</a>
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
                $('#logintoselleracount').attr('disabled', true);   // disables button
                
                $.ajax({
                    url:"seller_ajax_call.php",
                    type: "POST",
                    data:$(form).serialize(),
                    success: (result) => {
                        var data_json = $.parseJSON(result);
                        // alert(result);
                        if(data_json.status == 'error') {
                            Swal.fire({
                                icon: 'error',
                                title: data_json.msg,
                                text: ' ',
                            })
                        }

                        if(data_json.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: data_json.msg,
                                text: ' ',
                            })
                            setTimeout(() => {
                                window.location = window.location.href; 
                            }, 3000);
                        }
                    }
                })
            }
        });
        $('#login-form').validate({
            rules: {
                LoginEmail : {
                    required: true,
                    email:true,
                },
                password:{
                    required : true,
                }

            },
            messages: {
                LoginEmail: {
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

        $('#login-form input').bind('keyup blur click', function () { // fires on every keyup & blur
            if ($('#login-form').validate().checkForm()) {                   // checks form for validity
                $('#logintoselleracount').attr('disabled', false); // enables button
            } else {
                $('#logintoselleracount').attr('disabled', true);   // disables button
            }
    });
    </script>
</body>

</html>