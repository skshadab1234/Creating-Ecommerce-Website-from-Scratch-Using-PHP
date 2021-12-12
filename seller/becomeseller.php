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
    <title>Create your Seller Account</title>

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

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="<?= SELLER_FRONT_SITE ?>"><?= SITE_NAME ?><sup>seller</sup></a>
    </nav>

    <div class="main">
        <section class="signup" >
            <div class="container">
                <div class="row mb-5 mt-5 ">
                    <div class="col-12 order-2 col-sm-12 col-md-6 mt-3">
                        <h5 class="text-white" style="font-size:1.5rem;font-weight:400">Sell to millions of customers on <?= SITE_NAME ?>, Right from your doorstep</h5>
                        <p class="text-white mt-3" style="font-size:.8rem;font-weight:400">All you need to sell on <?= SITE_NAME ?> is</p>

                        <div class="row text-center mb-4 mt-4 "  style="height:100px">
                            <div class="col-6 col-md-4 border-right">
                                <svg width="60px" viewBox="0 0 56 49"><g id="Page-2" stroke="none" stroke-width="1" fill="#FFFFFF00" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"><g id="A00_Step-1-Copy-152" transform="translate(-931.000000, -245.000000)" stroke="#FFFFFF"><g id="Group" transform="translate(760.000000, 193.000000)"><g id="Group-22" transform="translate(25.000000, 51.000000)"><g id="Group-21" transform="translate(122.000000, 1.000000)"><g id="12--check-sheet-paper-payment-2" transform="translate(25.000000, -0.000000)"><path d="M34.8923077,40.7076923 L36.5538462,44.0307692" id="Stroke-1"></path><g id="Group-54"><path d="M29.42346,44.198001 C28.71486,42.9873625 29.11866,41.4322041 30.32346,40.7244925 L36.86586,36.876951" id="Stroke-2"></path><path d="M50.42754,36.2737398 C49.52694,36.8037706 48.36474,36.5014122 47.83314,35.5955414 C47.30514,34.6872614 47.60754,33.5223983 48.51114,32.9923675 C49.41534,32.4599275 52.19514,33.0297106 52.19514,33.0297106 C52.19514,33.0297106 51.33114,35.7437091 50.42754,36.2737398 Z" id="Stroke-4"></path><path d="M31.3377,47.4776266 C30.7377,47.8347951 29.9619,47.6300105 29.6091,47.0264982 L28.9713,45.9327074 C28.6185,45.3255812 28.8183,44.5510135 29.4237,44.1980612 L45.9555,34.4701897 C46.1961,34.3280451 46.4835,34.2882928 46.7529,34.3575582 C47.0235,34.4280282 47.2551,34.603902 47.3955,34.8460297 L48.2463,36.3048189 C48.5427,36.8083482 48.3735,37.4552266 47.8707,37.751562 L31.3377,47.4776266 Z" id="Stroke-6"></path><path d="M49.68396,20.9637408 L31.17576,25.0696724" id="Stroke-8"></path><path d="M24.97734,14.5362745 C24.91854,14.2628268 24.96834,13.9767307 25.11714,13.7388192 C25.26894,13.5051238 25.50654,13.3382845 25.78014,13.2756445 L45.93174,8.80832838 C46.49694,8.68063915 47.06094,9.04202377 47.18454,9.61361377 L48.09414,13.7388192 C48.21894,14.3110115 47.86134,14.8747715 47.29374,15.0000515 L27.14154,19.4691745 C26.57334,19.5944545 26.01174,19.2354792 25.88694,18.6656961 L24.97734,14.5362745 Z" id="Stroke-10"></path><path d="M46.14138,4.86465854 L41.20638,5.95844931" id="Stroke-12"></path><path d="M10.074,23.2538352 L10.62,25.731729" id="Stroke-14"></path><path d="M12.54378,22.7068193 L13.08738,25.1829062" id="Stroke-16"></path><path d="M15.00876,22.1599239 L15.55476,24.6360108" id="Stroke-18"></path><path d="M17.47854,21.6108602 L18.02334,24.0887541" id="Stroke-20"></path><path d="M19.94592,21.0640251 L20.49072,23.5419189" id="Stroke-22"></path><path d="M4.99392,29.5769215 L22.26852,25.7462446" id="Stroke-24"></path><path d="M7.06116,21.3228367 L20.63316,18.3125028" id="Stroke-26"></path><path d="M4.60842,10.1753862 L47.99622,0.55593 C48.56562,0.43065 49.12422,0.792034615 49.25262,1.36001077 L53.97402,22.8256546 C54.10182,23.3978469 53.74242,23.9616069 53.17422,24.0886938 L9.78702,33.70815 C7.74462,34.1610854 5.72022,32.8649192 5.26782,30.8128569 C4.87722,29.0402654 5.79042,27.2803223 7.36602,26.5437 C7.81602,26.3346992 8.05482,25.8420115 7.94982,25.3583585 L3.24702,3.98366308 C3.17022,3.63733615 2.92782,3.35364923 2.60022,3.22355077 C2.27082,3.09646385 1.90122,3.14223923 1.61142,3.34521692 C0.39882,4.20290308 -0.25098,5.73517385 0.09042,7.2819 L5.26782,30.8128569" id="Stroke-28"></path><path d="M27.7635,15.4338335 L28.0371,16.6715758" id="Stroke-30"></path><path d="M31.46424,14.6134904 L31.73784,15.8512327" id="Stroke-32"></path><path d="M33.93048,14.066595 L34.20408,15.3043373" id="Stroke-34"></path><path d="M36.4002,13.5195792 L36.6726,14.7573215" id="Stroke-36"></path><path d="M40.10274,12.6991758 L40.37514,13.9369182" id="Stroke-38"></path><path d="M42.56892,12.1502928 L42.84252,13.3904444" id="Stroke-40"></path><path d="M45.0363,11.6054453 L45.3063,12.8431876" id="Stroke-42"></path><path d="M19.5879,13.5655955 C19.6485,13.8414524 19.5975,14.1269462 19.4487,14.3630508 C19.2981,14.5991555 19.0587,14.7659947 18.7875,14.8268278 L6.2451,17.6070801 L5.4261,13.8914439 L17.9703,11.1105893 C18.5379,10.9853093 19.0995,11.3442847 19.2255,11.9146701 L19.5879,13.5655955 Z" id="Stroke-44"></path><path d="M35.49432,24.1118827 C34.47372,24.3371458 33.46032,23.6902673 33.23592,22.6651396 C33.01032,21.638205 33.65532,20.6215096 34.67952,20.3938373 C35.70132,20.1685742 36.71292,20.8178619 36.93732,21.8423873" id="Stroke-46"></path><path d="M44.20548,19.5819265 C44.42928,20.6088612 43.78488,21.6231473 42.76248,21.8508196" id="Stroke-48"></path><path d="M37.0746,22.4605357 C36.846,21.435408 37.4946,20.4211218 38.5158,20.1934495" id="Stroke-50"></path><path d="M40.15662,21.7779404 C39.93222,20.7510058 40.57782,19.7361173 41.60082,19.5108542" id="Stroke-52"></path></g></g></g></g></g></g></g></svg>
                                <h5 class="f-22">Bank Account</h5>
                            </div>

                            <div class="col-6 col-md-4">
                                <svg width="60px" viewBox="0 0 56 37"><g id="Page-2" stroke="none" stroke-width="1" fill="#FFFFFF00" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"><g id="A00_Step-1-Copy-152" transform="translate(-1078.000000, -243.000000)" stroke="#FFFFFF"><g id="Group" transform="translate(760.000000, 193.000000)"><g id="Group-22" transform="translate(25.000000, 51.000000)"><g id="05--sneakers" transform="translate(294.000000, 0.000000)"><path d="M27,21 L24,21" id="Stroke-1"></path><polyline id="Stroke-2" points="38 21 49 21 49 25"></polyline><g id="Group-37"><path d="M38.3997912,21.259 L48.737978,21.259 C49.3611099,21.259 49.8706154,20.7502931 49.8706154,20.1287414 L49.8706154,18.9984828 C49.8706154,18.376931 49.3611099,17.8682241 48.737978,17.8682241 L24.9586374,17.8682241 C24.3264396,17.8682241 23.8266044,18.376931 23.8266044,18.9984828 L23.8266044,20.1287414 C23.8266044,20.7502931 24.3264396,21.259 24.9586374,21.259 L27.7031978,21.259" id="Stroke-3"></path><path d="M13.7541099,13.0024397 L11.3099341,12.5655431" id="Stroke-5"></path><path d="M11.6127967,15.8674914 L9.24598352,15.4432672" id="Stroke-7"></path><path d="M17.5439725,18.6407586 L29.2499066,10.5032586 L32.9760055,7.92291379 L34.3721593,9.92877586 C34.6743571,10.3620517 34.5607308,10.9558448 34.1364451,11.2479138" id="Stroke-9"></path><path d="M12.5636319,22.0877155 C12.5539615,22.0877155 12.5539615,22.0877155 12.5636319,22.0973707 L0.432807692,30.516681 L1.82896154,32.5321983 C2.13055495,32.9467672 2.71560989,33.0505603 3.14956593,32.7675431" id="Stroke-11"></path><path d="M12.5636319,22.0877155 C12.5539615,22.0877155 12.5539615,22.0877155 12.5636319,22.0973707 L0.432807692,30.516681 C-0.152247253,29.6784914 -0.142576923,28.5675431 0.451543956,27.7384052 L6.45137912,19.3565086 L9.24308242,15.4479741 L11.3089066,12.5659052 L13.5258297,9.45814655 C13.836489,9.02487069 14.4312143,8.90237069 14.9213791,9.12866379 C15.9591264,9.63676724 18.0533571,10.0229741 21.1944011,7.83788793 C24.5898956,5.48383621 24.7319286,3.23297414 24.5524231,2.15943966 C24.4768736,1.71650862 24.6847857,1.28323276 25.0522582,1.02918103 L25.2976429,0.859612069 C26.3166538,0.143318966 27.731544,0.397974138 28.4483571,1.42443966 L32.9758846,7.92297414 L29.2497857,10.503319 L17.5438516,18.640819" id="Stroke-13"></path><path d="M29.252989,10.507181 C27.8278242,8.45606034 28.3324945,5.6379569 30.3862308,4.20959483 L32.9724396,7.92381897 L29.252989,10.507181 Z" id="Stroke-15"></path><path d="M12.5636319,22.0877155 C12.5539615,22.0877155 12.5539615,22.0877155 12.5636319,22.0973707 L0.432807692,30.516681 C-0.152247253,29.6784914 -0.142576923,28.5675431 0.451543956,27.7384052 L6.45137912,19.3565086 L7.14885165,20.3455603 C7.50725824,20.863319 8.20533516,20.985819 8.72390659,20.6279741 L12.4409396,18.0476293 C13.8842363,17.0398707 15.8364341,17.3222845 16.9587967,18.6221121" id="Stroke-17"></path><path d="M33.4483407,24.3767759 L35.2071319,22.6201379" id="Stroke-19"></path><path d="M36.8451044,25.5016034 L38.5452692,23.8077241" id="Stroke-21"></path><path d="M54.3956044,31.160681 L14.7665934,31.160681 L14.7665934,33.6070603 C14.7665934,34.1242155 15.1836264,34.5472328 15.7100549,34.5472328 L53.4527473,34.5472328 C53.9713187,34.5472328 54.3956044,34.1242155 54.3956044,33.6070603 L54.3956044,31.160681 Z" id="Stroke-23"></path><path d="M52.7966758,28.8890603 L31.6089835,21.3369052 C31.099478,21.1528534 30.5470604,21.3845776 30.2781044,21.8582845 C29.7111813,22.861819 28.2146978,24.3764741 24.3912912,24.3764741 C20.2499725,24.3764741 18.8417308,22.6083707 18.3787637,21.6229397 C18.1901923,21.2240603 17.769533,20.9802672 17.3259066,20.9802672 L17.0297527,20.9802672 C15.7792582,20.9802672 14.7662912,21.9964741 14.7662912,23.2425948 L14.7662912,31.1604397 L54.3959066,31.1604397 C54.3959066,30.1406121 53.7552473,29.2348362 52.7966758,28.8890603 Z" id="Stroke-25"></path><path d="M19.2958132,31.160681 C19.2958132,28.658181 17.265044,26.6354224 14.7664725,26.6354224 L14.7664725,31.160681 L19.2958132,31.160681 Z" id="Stroke-27"></path><path d="M52.7966758,28.8890603 L43.0731593,25.42225 L43.0731593,26.6357845 C43.0731593,27.2621638 42.5666758,27.7678534 41.9423352,27.7678534 L37.4099725,27.7678534 C35.5369505,27.7678534 34.0126648,29.2806983 34.0126648,31.1604397 L54.3959066,31.1604397 C54.3959066,30.1406121 53.7552473,29.2348362 52.7966758,28.8890603 Z" id="Stroke-29"></path><path d="M12.412533,26.3353276 L3.14956593,32.7680862" id="Stroke-31"></path><path d="M34.1365659,11.2476121 L20.5527747,20.6752845" id="Stroke-33"></path><path d="M24.958456,22.0030517 L24.958456,21.259" id="Stroke-35"></path></g></g></g></g></g></g></svg>
                                <h5 class="f-22">Product to sell</h5>
                            </div>
                        </div>

                        <hr class="mb-5" style="background:#fff">
                        <h5 class="text-white mt-3">How will this information be used?</h5>
                        <p class="text-white mt-3" style="font-size:0.8rem">You can use your email address or Username to login to your seller Account.</p>
                        <p class="text-white mt-3" style="font-size:0.8rem">Please note, the ‘Username’ and ‘Password’ used here are only to access
                         your <?= SITE_NAME ?> Seller Account and cannot be used on <?= SITE_NAME ?> shopping destination.</p>
                         <hr class="mt-5" style="background:#fff">
                    </div>    
                    <div class="col-12 col-sm-12 col-md-6  ">
                            <div class="signup-content">
                                <form id="signup-form" class="" method="post" action="" style="display:">
                                    <h2 class="mb-5 h5">Create your Seller Account</h2>
                                        <div class="form-group">
                                            <input type="text" class="form-control w-30 mr-3" name="SellerEmailIdtoGetOTP" placeholder="Email id" />
                                            <input type="hidden" name="creatingaccountseller">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="Password" />
                                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="re_password" id="re_password"
                                                placeholder="Repeat your password" />
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" name="seller_fullname" id="seller_fullname"
                                                placeholder="Enter Your Full Name" />
                                        </div>
                                        <div class="form-group">
                                            <label for="agree-term" class="label-agree-term"><span><span></span></span>By fillng this form I agree all
                                                statements in <a href="#" class="term-service">Terms of service</a></label>
                                        </div>
                                        
                                        <div class="form-group text-center">
                                            <button class="btn btn-primary form-control" id="send_otp" >Sign Up</button> 
                                        </div>
                                        <div class="text-center">Don't have an account? <a href="<?= SELLER_FRONT_SITE.'logintoseller' ?>">Login</a></div>
                                </form>
                                
                                <form id="verify_otp_form" class="" method="post" action="" style="display:none">
                                    <h2 class="mb-5 h5">Verify OTP</h2>
                                        <div class="form-group">
                                            <input type="text" class="form-control w-30 mr-3" name="OTPSENDEBYME" id="OTPSENDEBYME" placeholder="4-digit otp" />
                                            <input type="hidden" name="veried_email" id="veried_email">
                                            <input type="hidden" name="veried_password" id="veried_password">
                                            <input type="hidden" name="veried_name" id="veried_name">
                                            <div id="timer_resend">
                                                <h5 class='float-right mt-1' style='font-size: 14px;'></h5>
                                            </div>
                                            <div class="resend_code_link">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group text-center">
                                            <button class="btn btn-primary form-control" id="verify_otp_sended" >Verify</button> 
                                        </div>
                                </form>
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

        $('input').attr('autocomplete','off');
         $.validator.addMethod("strong_password", function (value, element) {
            let password = value;
            if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@#$%&])(.{8,20}$)/.test(password))) {
                return false;
            }
            return true;
         }, function (value, element) {
            let password = $(element).val();
            if (!(/^(.{8,20}$)/.test(password))) {
                return 'Password must be between 8 and 20 characters long.';
            }
            else if (!(/^(?=.*[A-Z])/.test(password))) {
                return 'Password must contain atleast one uppercase.';
            }
            else if (!(/^(?=.*[a-z])/.test(password))) {
                return 'Password must contain atleast one lowercase.';
            }
            else if (!(/^(?=.*[0-9])/.test(password))) {
                return 'Password must contain atleast one digit.';
            }
            else if (!(/^(?=.*[@#$%&])/.test(password))) {
                return "Password must contain special characters from @#$%&.";
            }
            return false;
        });

    

        $.validator.setDefaults({
            submitHandler: function(form) {
                $('#send_otp').attr('disabled', true);   // disables button
                $("#verify_otp_form").hide();
                $.ajax({
                    type: "POST",
                    url: "seller_ajax_call.php",
                    data: $(form).serialize(),
                    success: (res) => {
                    var data = $.parseJSON(res);
                    $('#send_otp').attr('disabled', false); 
                    if (data.status == 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: data.message,
                            text: ' ',
                        })
                    }else{
                            $("#signup-form").hide();
                            $("#verify_otp_form").show();
                            var timer = 60;
                            var interval = setInterval(()=>{
                                timer--;
                                if(timer < 10) {
                                    timer = "0"+timer;
                                }
                                $("#timer_resend h5").html(timer+'s');
                                if(timer == 0) {
                                    clearInterval(interval);
                                    $("#timer_resend h5").hide();
                                    $(".resend_code_link").show();
                                    $(".resend_code_link").html("<a href='javascript:void(0)' onclick=ResendCode('"+data.email+"') class=\"float-right mt-1\">Resend Code</a>");
                                }
                            }, 1000);

                            $("#veried_email").val(data.email);
                            $("#veried_password").val(data.password);
                            $("#veried_name").val(data.name);
                    }
                    }
                })
            }
        });

        function ResendCode(email) {
            $(".resend_code_link").hide();
            $.ajax({
                type: "POST",
                url: "seller_ajax_call.php",
                data: {resendCodeEmail:email},
                success: (res) => {
                    var data = $.parseJSON(res);
                    if (data.status == 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: data.message,
                            text: ' ',
                        })
                    }

                    if (data.status == 'success') {
                        $("#timer_resend h5").show();
                        $(".resend_code_link").hide();
                        timer = 120 * 2;
                        var interval = setInterval(()=>{
                            timer--;
                                if(timer < 10) {
                                    timer = "0"+timer;
                                }

                                $("#timer_resend h5").html(timer+'s');
                                if(timer == 0) {
                                    clearInterval(interval);
                                    $("#timer_resend h5").hide();
                                    $(".resend_code_link").show();
                                    $(".resend_code_link").html("<a href='javascript:void(0)' onclick=ResendCode('"+email+"') class=\"float-right mt-1\">Resend Code</a>");
                                }
                        }, 1000);
                    }
                }
            })
        }
        $('#signup-form').validate({
            rules: {
                SellerEmailIdtoGetOTP: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                    strong_password: true,
                },
                
                re_password: {
                    required : true,
                    strong_password: true,
                    equalTo: '#password',
                },
                seller_fullname:{
                    required: true,
                    rangelength:[3,60]
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


        // Validating OTP FORM 
        $.validator.setDefaults({
            submitHandler: function(form) {
                $('#verify_otp_sended').attr('disabled', true);   // disables button
                $.ajax({
                    url:"seller_ajax_call.php",
                    type: "POST",
                    data:$(form).serialize(),
                    success: (result) => {
                        var data_json = $.parseJSON(result);
                        $('#verify_otp_sended').attr('disabled', false); 
                        if(data_json.status == 'error') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Not a valid otp',
                            })
                        }

                        if(data_json.status == 'success') {
                            Swal.fire(
                                'Good job!',
                                'You successfully Created Seller Account.',
                                'success'
                            );

                            setTimeout(() => {
                                window.location = 'logintoseller';
                            }, 2000);
                        }
                    }
                })
            }
        });
        $('#verify_otp_form').validate({
            rules: {
                OTPSENDEBYME : {
                    required: true,
                    number:true,
                    rangelength: [4, 4]
                }

            },
            messages: {
                OTPSENDEBYME: {
                    number: 'Enter Valid OTP Sended on Mail',
                    rangelength: "Enter 4 character OTP"
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