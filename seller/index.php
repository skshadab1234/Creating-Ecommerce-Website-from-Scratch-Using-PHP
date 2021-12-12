<?php
require 'includes/session.php';

if (!isset($_SESSION['SELLER_ID'])) redirect(SELLER_FRONT_SITE.'logintoseller');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css'>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="<?= SELLER_FRONT_SITE ?>"><?= SITE_NAME ?><sup>seller</sup></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav  mr-auto">
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">Fee Structure</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Resources</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">FAQs</a>
                </li> -->
            </ul>
            <ul class='navbar-nav'>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <?= $sell_row['seller_email'] ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="<?= SELLER_FRONT_SITE.'logoutfromseller' ?>">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!-- <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="<?= FRONT_SITE_PATH ?>media/zero_commission.png" alt="First slide">
            </div>
        </div>
    </div> -->

    <?php
        if ($sell_row['seller_pincode'] == '0' && $sell_row['shop_address'] == '' && $sell_row['shop_city'] == '' && $sell_row['shop_state'] == '' && $sell_row['shop_landmark'] == '') {
            ?>
            <title>Add Pincode</title>
            <style>
            body {
                font-size: 14px;
                line-height: 1.8;
                color: #222;
                font-weight: 400;
                font-family: 'Open Sans', sans-serif;
                background-image: linear-gradient(rgb(0, 120, 212) 0%, rgba(0, 120, 212, 0.9) 100%) !important;
                background-repeat: no-repeat;
                padding: 15px 0;
                height: 100vh;
            }

            body.swal2-shown>[aria-hidden="true"] {
                transition: 0.1s filter;
                filter: blur(10px);
            }
            </style>
            <div class="main">
                <section class="signup">
                    <div class="container">
                        <div class="row mb-5 mt-5 ">
                            <div class="col-12 order-2 col-sm-12 col-md-6 mt-3">
                                <h5 class="text-white" style="font-size:1.5rem;font-weight:400">Tell us from where you will ship
                                    your products to buyers all across India!</h5>
                                <h5 class="text-white mt-3">How will this information be used?</h5>
                                <p class="text-white mt-3" style="font-size:0.8rem">Your pick up Address helps us identify which
                                    Logistics partner can pick up your products.</p>
                                <hr class="mt-5" style="background:#fff">
                            </div>
                            <div class="col-12 col-sm-12 col-md-6">
                                <div class="signup-content">
                                    <form id="pincode-form" class="" method="post" action="" style="display:">
                                        <h2 class="mb-5 h5">Give your pick up address</h2>
                                        <!-- Pincode validation wrtten on js/Main.js file refer from there  -->
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="postal_code" id="postal_code"
                                                onkeyup="GetStateCity()" placeholder="Enter your pick up pincode" />
                                        </div>

                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="address_line"
                                                id="address_line_pincode" placeholder="Shop Address" />
                                        </div>


                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="city_address" id="city_address"
                                                disabled placeholder="City" />
                                            <input type="hidden" class="form-control" name="city_for_db" id="city_for_db" />
                                        </div>

                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="state_address" id="state_address"
                                                disabled placeholder="State" />
                                            <input type="hidden" class="form-control" name="state_for_db" id="state_for_db" />
                                        </div>


                                        <div class="input-group mb-3">
                                            <select name="delivery_boy_landmark" id="delivery_boy_landmark"
                                                class="form-control">
                                                <option value="" disabled>--please choose--</option>
                                            </select>
                                        </div>

                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-primary form-control"
                                                id="pickup_address_pincode_button">Continue</button>
                                        </div>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>
                </section>

            </div>
    <?php
        }
        else if ($sell_row['bank_name'] == '' || $sell_row['bank_branch'] == '' || $sell_row['bank_city'] == ''  || $sell_row['bank_state'] == ''  || $sell_row['bank_account_hold_name'] == ''  || $sell_row['bank_account_number'] == ''  || $sell_row['bank_ifsc'] == '' || $sell_row['bank_cancelled_cheque'] == '') {
            ?>
            <title>Update Bank Details</title>
            <link rel="stylesheet" href="css/bank_cheeque.css">
            <style>
            body {
                font-size: 14px;
                line-height: 1.8;
                color: #222;
                font-weight: 400;
                font-family: 'Open Sans', sans-serif;
                background-image: linear-gradient(rgb(0, 120, 212) 0%, rgba(0, 120, 212, 0.9) 100%) !important;
                background-repeat: no-repeat;
                padding: 15px 0;
            }

            body.swal2-shown>[aria-hidden="true"] {
                transition: 0.1s filter;
                filter: blur(10px);
            }
            </style>
            <div class="main">
                <section class="signup">
                    <div class="container">
                        <div class="row mb-5 mt-5 ">
                            <div class="col-12 order-2 col-sm-12 col-md-6 mt-3">
                                <h5 class="text-white" style="font-size:1.5rem;font-weight:400">Get a share of thousands of
                                    crores of rupees paid out every month!</h5>
                                <h5 class="text-white mt-3">What should i do if i don't have a bank account in my registered
                                    business name?</h5>
                                <p class="text-white mt-3" style="font-size:0.8rem">we can only transfer payments to accounts
                                    which are in the registered business name, Please open a new bank account with any bank in
                                    your registered business name.</p>
                                <hr class="mt-5" style="background:#fff">
                                <h5 class="text-white mt-3">How will this information be used?</h5>
                                <p class="text-white mt-3" style="font-size:0.8rem">Your Bank account details will be used to
                                    make payments to you.</p>
                                <hr class="mt-5" style="background:#fff">
                                <h5 class="text-white mt-3">What should i do if i don't have a cancelled cheque with my
                                    registered business name printed on it?</h5>
                                <p class="text-white mt-3" style="font-size:0.8rem">A cancelled cheque with your registered
                                    business name printed on it is mandatory to sell on <?= SITE_NAME ?>, Please ask your bank
                                    to issue a personalised cheque book with your registered business name printed on it.</p>
                                <hr class="mt-5" style="background:#fff">

                            </div>
                            <div class="col-12 col-sm-12 col-md-6">
                                <div class="signup-content">
                                    <form id="bank-account-form" class="" method="post" action="" style="display:">
                                        <h2 class="mb-5 h5">Give your Bank Details</h2>
                                        <!-- Pincode validation wrtten on js/Main.js file refer from there  -->
                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" name="bank_holder_name" id="bank_holder_name"  placeholder="Enter Account Holder Name" />
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control" name="account_number" id="password"
                                                placeholder="Account Number" />
                                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password "></span>
                                        </div>

                                        <div class="form-group">
                                            <input type="number" class="form-control" name="retype_account_number"
                                                placeholder="Re-type Account Number" />
                                        </div>

                                        <div class="form-group row m-0 mb-4">
                                            <input type="text" class="form-control col-9" name="ifsc_code" id="ifsc_code"
                                                placeholder="IFSC Code" />
                                            <!-- <button type="button" class="btn form-control col-3 bg-info text-white" id="ifsc_code_submit_check_btn" ><i class="fa fa-car"></i></button> -->
                                            <button type="button" class="btn form-control col-3 bg-info text-white"
                                                id="ifsc_code_submit_check_btn">Check</button>
                                        </div>
                                        <input type="hidden" name="from_js_get_data_image" id="from_js_get_data_image">
                                        <div id="bank_details">
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-12">
                                                <!-- Upload Area -->
                                                <div id="uploadArea" class="upload-area">
                                                    <!-- Header -->
                                                    <div class="upload-area__header">
                                                        <h1 class="upload-area__title">Upload your Cancelled Cheque</h1>
                                                        <p class="upload-area__paragraph">
                                                            File should be an image
                                                            <strong class="upload-area__tooltip">
                                                                Like
                                                                <span class="upload-area__tooltip-data"></span>
                                                                <!-- Data Will be Comes From Js -->
                                                            </strong>
                                                        </p>
                                                    </div>
                                                    <!-- End Header -->

                                                    <!-- Drop Zoon -->
                                                    <div id="dropZoon" class="upload-area__drop-zoon drop-zoon">
                                                        <span class="drop-zoon__icon">
                                                            <i class='bx bxs-file-image'></i>
                                                        </span>
                                                        <p class="drop-zoon__paragraph">Drop your file here or Click to
                                                            browse</p>
                                                        <span id="loadingText" class="drop-zoon__loading-text">Please
                                                            Wait</span>
                                                        <img src="" alt="Preview Image" id="previewImage"
                                                            class="drop-zoon__preview-image" draggable="false">
                                                        <div class="form-group">
                                                            <input type="file" name="fileInput" id="fileInput" class="form-control drop-zoon__file-input"
                                                                accept="image/*">
                                                        </div>
                                                    </div>
                                                    <!-- End Drop Zoon -->

                                                    <!-- File Details -->
                                                    <div id="fileDetails"
                                                        class="upload-area__file-details file-details">
                                                        <h3 class="file-details__title">Uploaded File</h3>

                                                        <div id="uploadedFile" class="uploaded-file">
                                                            <div class="uploaded-file__icon-container">
                                                                <i class='bx bxs-file-blank uploaded-file__icon'></i>
                                                                <span class="uploaded-file__icon-text"></span>
                                                                <!-- Data Will be Comes From Js -->
                                                            </div>

                                                            <div id="uploadedFileInfo" class="uploaded-file__info">
                                                                <span class="uploaded-file__name">Proejct 1</span>
                                                                <span class="uploaded-file__counter">0%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End File Details -->
                                                </div>
                                                <!-- End Upload Area -->
                                            </div>
                                        </div>
                                    
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-primary form-control"
                                                id="BANK_ACCOUNT_FORM_SUBMIT_BTN">Continue</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
    <?php
        }
        else{
            redirect(SELLER_FRONT_SITE.'profile');
        }
        
    ?>

    <!-- JS -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://adminlte.io/themes/v3/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/jquery-validation/additional-methods.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/main.js"></script>
    <script src="js/bank_cheque.js"></script>

    <script>
    $.validator.setDefaults({
        submitHandler: function(form) {
            $.ajax({
                url: 'seller_ajax_call.php',
                method: 'post',
                data: $(form).serialize(),
                success: (res) => {
                    Swal.fire({
                        title: "Wow!",
                        text: "Pickup Address Added Successfully",
                        icon: "success"
                    }).then(function() {
                        window.location = window.location.href;
                    });
                    // alert(res);
                }
            })
        }
    });
    $('#pincode-form').validate({
        rules: {
            postal_code: {
                required: true,
                number: true,
                rangelength: [6, 6]
            },
            address_line: {
                required: true,
                rangelength: [10, 255]
            }

        },
        messages: {
            postal_code: {
                number: 'Enter Valid Pincode',
                rangelength: "Enter 6 Digits Pincode"
            },
            address_line: {
                rangelength: "Enter Full Shop Address"
            }

        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.input-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

    // For Bank Details 
    $("#BANK_ACCOUNT_FORM_SUBMIT_BTN,#ifsc_code_submit_check_btn").attr("disabled", true);
    
    setInterval( () => {
        if($("#previewImage").attr("src") == ''){
            $("#BANK_ACCOUNT_FORM_SUBMIT_BTN").attr("disabled", true); // disable
        }else{
            $("#BANK_ACCOUNT_FORM_SUBMIT_BTN").attr("disabled", false); // enable
        }
    }, 100)


    
    </script>
</body>

</html>