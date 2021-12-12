<?php
    include 'includes/header.php';
    if (!isset($_SESSION['SELLER_ID'])) {
        redirect(SELLER_FRONT_SITE);
    }
    $store_name = '';
    $store_desc = '';
    $business_address = '';
    $business_pincode = '';
    $business_city = '';
    $business_state = '';
    $business_landmark = '';
    $progress_bar_percentage = array();
    $store_Details_status = 'text-danger';
    if($sell_row['seller_store_name'] != '') {
        $store_name = $sell_row['seller_store_name'];
        $progress_bar_percentage[]= 10; 
        $store_Details_status = 'text-success';
    }
    if($sell_row['seller_store_description'] != '') {
        $store_desc = $sell_row['seller_store_description'];
        $progress_bar_percentage[] = 10;
    }
    if($sell_row['business_address'] != '') {
        $business_address = $sell_row['business_address'];
        $progress_bar_percentage[] = 10;
    }
    if($sell_row['business_pincode'] != '') {
        $business_pincode = $sell_row['business_pincode'];
        $progress_bar_percentage[] = 10;
    }
    if($sell_row['business_city'] != '') {
        $business_city = $sell_row['business_city'];
        $progress_bar_percentage[] = 10;
    }
    if($sell_row['business_state'] != '') {
        $business_state = $sell_row['business_state'];
        $progress_bar_percentage[] = 10;
    }
    if($sell_row['business_landmark'] != '') {
        $business_landmark = '<option value="'.$sell_row['business_landmark'].'" selected="selected">'.$sell_row['business_landmark'].'</option>';
        $progress_bar_percentage[] = 10;
    }
                                            
    if($sell_row['seller_signature'] != '')     $progress_bar_percentage[] = 30;

    $TEXT_COLOR = 'text-warning';
    if($sell_row['seller_verified'] > 0) {
        $TEXT_COLOR = 'text-success';
    }

    if($sell_row['bank_cancelled_cheque'] == '') {
        $bank_cancelled_cheque_status = 'text-danger'; // empty then add this text 
    }else{
        $bank_cancelled_cheque_status = 'text-success';
    }

    if($sell_row['seller_signature'] == '') {
        $seller_signature_status = 'text-danger'; // empty then add this text 
    }else{
        $seller_signature_status = 'text-success';
    }

    if($sell_row['bank_acc_verification_status'] > 0) {
        // verified
        $bank_acc_verification_status = 'text-success';
    }else{
        // not verified
        $bank_acc_verification_status = 'text-danger';
    }
    
?>
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12 col-md-12 col-lg-9">
                <?php
                if(array_sum($progress_bar_percentage) == 100) {
                    echo '<h4 class="mt-4 h4">Profile</h4>';
                }else{
                    echo '<h4 class="mt-4 h4">You are almost ready to start selling! </h4>
                          <p class="text-muted">Please complete all the steps below</p>';
                }
                ?>
                
                <div class="row mt-3">
                    <div class="col-12 col-md-1 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" style="fill: coral;transform: scaleX(-1);background: #fff;padding: 10px;border-radius: 50%;"><path d="M19 2H5C3.346 2 2 3.346 2 5v2.831c0 1.053.382 2.01 1 2.746V20a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-5h4v5a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-9.424c.618-.735 1-1.692 1-2.746V5c0-1.654-1.346-3-3-3zm1 3v2.831c0 1.14-.849 2.112-1.891 2.167L18 10c-1.103 0-2-.897-2-2V4h3c.552 0 1 .449 1 1zM10 8V4h4v4c0 1.103-.897 2-2 2s-2-.897-2-2zM4 5c0-.551.448-1 1-1h3v4c0 1.103-.897 2-2 2l-.109-.003C4.849 9.943 4 8.971 4 7.831V5zm6 11H6v-3h4v3z"></path></svg>
                    </div>
                    <div class="col-12 col-md-11">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h5 class="card-title h6">Store Details</h5>
                                <p>Your store details will be displayed to the buyers when they browse your products</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-8">
                                        <form method="post" id="store_detail_form">
                                            <!-- This hidden flag will create some unique way so in ajax call nothing will get wrong -->
                                            <input type="hidden" name="WorkingonStoreDetails">
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="<?= $store_name ?>"
                                                    name="seller_store_name" id="seller_store_name"
                                                    placeholder="Store Name">
                                            </div>
                                            <div class="form-group">
                                                <textarea name="seller_store_description" id="seller_store_description"
                                                    class="form-control" placeholder="Store Details" cols="30"
                                                    rows="10"><?= $store_desc ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary form-control w-50"> Save</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-12 col-md-4 align-items-center d-flex">
                                        <a href="<?= SELLER_FRONT_SITE.'images/store_details_pic_demo.jpg' ?>"
                                            target="_blank"><img
                                                src="<?= SELLER_FRONT_SITE.'images/store_details_pic_demo.jpg' ?>"
                                                alt=""></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-1 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" style="fill: steelblue;background: #fff;padding: 10px;border-radius: 50%;"><path d="M12 14c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm0-6c1.103 0 2 .897 2 2s-.897 2-2 2-2-.897-2-2 .897-2 2-2z"></path><path d="M11.42 21.814a.998.998 0 0 0 1.16 0C12.884 21.599 20.029 16.44 20 10c0-4.411-3.589-8-8-8S4 5.589 4 9.995c-.029 6.445 7.116 11.604 7.42 11.819zM12 4c3.309 0 6 2.691 6 6.005.021 4.438-4.388 8.423-6 9.73-1.611-1.308-6.021-5.294-6-9.735 0-3.309 2.691-6 6-6z"></path></svg>
                    </div>
                    <div class="col-12 col-md-11">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h5 class="card-title h6">Business Address</h5>
                                <p>Your business address will be displayed to the buyers when they browse your products
                                </p>
                            </div>
                            <div class="card-body">
                                <div class="row container">
                                    <div class="col-12 col-md-12">
                                        <form id="business_address" method="post">
                                            <div class="form-group">
                                                <textarea name="seller_store_address" id="seller_store_address"
                                                    class="form-control" placeholder="Store Address" cols="30"
                                                    rows="2"><?= $business_address ?></textarea>
                                            </div>
                                            <div class="row ">
                                                <div class="form-group col-12 col-md-6">
                                                    <input type="text" class="form-control mr-3" name="postal_code"
                                                        id="postal_code_pincode" onkeyup="GetValidStateCity()"
                                                        value="<?= $business_pincode ?>" placeholder="Pincode">
                                                </div>
                                                <div class="form-group col-12 col-md-6">
                                                    <input type="text" class="form-control" name="city_address"
                                                        id="city_address" placeholder="City"
                                                        value="<?= $business_city ?>" disabled>
                                                    <input type="hidden" class="form-control" name="city_for_db"
                                                        id="city_for_db" placeholder="City"
                                                        value="<?= $business_city ?>">

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="state_address"
                                                    id="state_address" placeholder="State"
                                                    value="<?= $business_state ?>" disabled>
                                                <input type="hidden" class="form-control" name="state_for_db"
                                                    id="state_for_db" placeholder="State"
                                                    value="<?= $business_state ?>">
                                            </div>
                                            <div class="form-group">
                                                <select name="business_landmark" class="form-control"
                                                    id="business_landmark">
                                                    <option value="" selected="" disabled>--please choose--</option>
                                                    <?= $business_landmark ?>

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary form-control w-50"
                                                    id="save_address_store_btn"> Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-1 text-center">
                        <img src="https://st2.depositphotos.com/3271675/7617/v/600/depositphotos_76179443-stock-illustration-handshake-icon-design.jpg" width="50px" class="img-fluid" style='border-radius:50%'>
                    </div>
                    <div class="col-12 col-md-11">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h5 class="card-title h6">Signature</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6 border-right">
                                        <form method="post" id="signature_upload">
                                            <input type="hidden" name="from_js_get_data_image" id="from_js_get_data_image">
                                            <!-- below flag is used for proper conditional statement  -->
                                            <input type="hidden" name="signature_upload" >
                                            <div id="uploadArea" class="upload-area">
                                                <!-- Header -->
                                                <div class="upload-area__header">
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
                                                    <input type="file" name="fileInput" id="fileInput"
                                                        class="form-control drop-zoon__file-input"
                                                        style="display: none;" accept="image/*">
                                                </div>
                                                <!-- End Drop Zoon -->

                                                <!-- File Details -->
                                                <div id="fileDetails" class="upload-area__file-details file-details">
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
                                            <div class="form-group mt-4">
                                                <button type="submit" class="btn btn-primary form-control w-50" id="sinature_upload_btn"> Save</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-12 col-md-6 align-items-center d-flex">
                                        <?php
                                            if($sell_row['seller_signature'] == '') {
                                                
                                                ?>
                                                <a id="view_sign_href" href="<?= SELLER_FRONT_SITE.'images/sample_sign.png' ?>" target="_blank">
                                                    <img id="view_sign_img" src="<?= SELLER_FRONT_SITE.'images/sample_sign.png' ?>" class="img-responsive" width="400" alt="">
                                                </a>
                                                <?php
                                            }else{
                                                ?>
                                                <a id="view_sign_href" href="<?= $sell_row['seller_signature'] ?>" target="_blank">
                                                    <img id="view_sign_img" src="<?= $sell_row['seller_signature'] ?>" class="img-responsive" width="400" alt="">
                                                </a>
                                                <?php
                                            }
                                        ?>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-5 mt-3">
                    <div class="col-12  col-sm-1 col-md-1 mt-3">

                    </div>
                    <div class="col-12 col-sm-12 col-md-11 ">
                        <div class="row ">
                            <div class="col-12 col-md-12 col-lg-6 border-right">
                                <div class="signup-content">
                                    <form id="bank-account-form" method="post" >
                                        <h2 class="mb-5 h5">Update your Bank Details</h2>
                                        <!-- Pincode validation wrtten on js/Main.js file refer from there  -->
                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" name="bank_holder_name" id="bank_holder_name" value="<?= $sell_row['bank_account_hold_name'] ?>" placeholder="Enter Account Holder Name" />
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control" name="account_number" id="password" value="<?= $sell_row['bank_account_number'] ?>"
                                                placeholder="Account Number" />
                                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password "></span>
                                        </div>

                                        <div class="form-group">
                                            <input type="number" class="form-control" name="retype_account_number" 
                                                placeholder="Re-type Account Number" />
                                        </div>

                                        <div class="form-group row m-0 mb-4">
                                            <input type="text" class="form-control col-9" name="ifsc_code" id="ifsc_code" value="<?= $sell_row['bank_ifsc'] ?>"
                                                placeholder="IFSC Code" />
                                            <!-- <button type="button" class="btn form-control col-3 bg-info text-white" id="ifsc_code_submit_check_btn" ><i class="fa fa-car"></i></button> -->
                                            <button type="button" class="btn form-control col-3 bg-info text-white"
                                                id="ifsc_code_submit_check_btn">Check</button>
                                        </div>
                                        <input type="hidden" name="from_js_get_data_image" value="<?= $sell_row['bank_cancelled_cheque'] ?>" >
                                        <div id="bank_details">
                                        </div>
                                    
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-primary form-control"
                                                id="BANK_ACCOUNT_FORM_SUBMIT_BTN">Continue</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="signup-content">
                                    <h2 class="h5">
                                        <img src="data:image/png;base64,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" width='30px'> 
                                    Linked Bank Account</h2>
                                    <dl class="row mt-4">
                                        <dt class="col-sm-6">Acc. Holder Name</dt>
                                        <dd class="col-sm-6"><?= $sell_row['bank_account_hold_name'] ?></dd>
                                        <dt class="col-sm-6">Acc. Number</dt>
                                        <dd class="col-sm-6"><?= substr_replace($sell_row['bank_account_number'],"XXXXXXX",-5); ?></dd>
                                        <dt class="col-sm-6">IFSC Code</dt>
                                        <dd class="col-sm-6"><?= $sell_row['bank_ifsc'] ?></dd>
                                        <dt class="col-sm-6">Bank Name</dt>
                                        <dd class="col-sm-6"><?= $sell_row['bank_name'] ?></dd>
                                        <dt class="col-sm-6">Branch</dt>
                                        <dd class="col-sm-6"><?= $sell_row['bank_branch'] ?></dd>
                                        <dt class="col-sm-6">City</dt>
                                        <dd class="col-sm-6"><?= $sell_row['bank_city'] ?></dd>
                                        <dt class="col-sm-6">State</dt>
                                        <dd class="col-sm-6"><?= $sell_row['bank_state'] ?></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-3 mt-2">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-2">
                                <img src="<?= FRONT_SITE_PATH.'media/store.png' ?>" width="50px" class="img-fluid">
                            </div>
                            <div class="col-10">
                                <h5 class='h6'><?= $sell_row['seller_fullname'] ?></h5>
                                <div class="progress">
                                    <div class="progress-bar" style="width:<?= array_sum($progress_bar_percentage) ?>%"><?= array_sum($progress_bar_percentage) ?>%</div>
                                </div>
                                <p class="mt-1">Your account is <?= array_sum($progress_bar_percentage) ?>% is completed</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <h5 class='h6'>Account Details</h5>
                        <span class="ml-3 d-flex">
                            <i class='bx bx-check-circle <?= $TEXT_COLOR ?> mt-1'></i>
                            <p class="ml-1">Email Verification</p>
                        </span>

                        <h5 class='h6'>Business Details</h5>
                        <span class="ml-3 d-flex">
                            <i class='bx bx-check-circle <?= $seller_signature_status ?> mt-1'></i>
                            <p class="ml-1">Signature</p>
                        </span>
                        <h5 class='h6'>Bank Account Details</h5>
                        <span class="ml-3 d-flex">
                            <i class='bx bx-check-circle <?= $bank_cancelled_cheque_status ?> mt-1'></i>
                            <p class="ml-1">Cancelled Cheque</p>
                        </span>
                        <span class="ml-3 d-flex">
                            <i class='bx bx-check-circle <?= $bank_acc_verification_status ?> mt-1'></i>
                            <p class="ml-1">Bank Acc. Verification</p>
                        </span>
                        <h5 class='h6'><i class='bx bx-check-circle text-warning mt-1'></i> Listing Created</h5>
                        <h5 class='h6'><i class='bx bx-check-circle <?= $store_Details_status ?>  mt-1'></i> Store Details</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <?php
        include 'includes/footer.php';
   ?>
    <script>
    $.validator.setDefaults({
        submitHandler: function(form) {
            $.ajax({
                url: 'seller_ajax_call.php',
                method: 'post',
                data: $(form).serialize(),
                success: (res) => {
                    Swal.fire({
                        title: "Congrats!",
                        text: "Store Details Added Successfully.",
                        icon: "success"
                    })
                }
            })
        }
    });
    $('#store_detail_form').validate({
        rules: {
            seller_store_name: {
                required: true,
                rangelength: [3, 50]
            },
            seller_store_description: {
                required: true,
                maxlength: 400
            },

        },
        messages: {
            seller_store_name: {
                rangelength: "Enter your Legal Store Name."
            },
            seller_store_description: {
                maxlength: "Maximum 400 Character",
            },
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

    // Business Address Form Validaton 
    $.validator.setDefaults({
        submitHandler: function(form) {
            $.ajax({
                url: 'seller_ajax_call.php',
                method: 'post',
                data: $(form).serialize(),
                success: (res) => {
                    Swal.fire({
                        title: "Congrats!",
                        text: "Business Address Added Successfully.",
                        icon: "success"
                    })
                }
            })
        }
    });
    $('#business_address').validate({
        rules: {
            seller_store_address: {
                required: true,
                rangelength: [40, 255]
            },
            postal_code: {
                required: true,
                rangelength: [6, 6]
            },
            city_for_db: {
                required: true,
            },
            state_for_db: {
                required: true
            }

        },
        messages: {
            seller_store_address: {
                rangelength: "Enter your Full Business Address."
            },
            postal_code: {
                rangelength: "Enter valid pincode.",
            },
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
    function GetValidStateCity() {
        var zip = $("#postal_code_pincode");

        if (zip.val().length > 5) {
            $.ajax({
                url: '../ajax_call.php',
                type: 'post',
                data: 'pincodeOfAddressToGetCityState=' + zip.val(),
                success: function (data) {
                    if (data == 'no') {
                        $('#city_address, #city_for_db').val('');
                        $('#state_address, #state_for_db').val('');
                        $("#business_landmark").html('<option value=""  disabled>--please choose--</option>');
                        $("#save_address_store_btn").attr("disabled",true);
                        
                    } else {
                        var getData = $.parseJSON(data);
                        
                        $("#save_address_store_btn").attr("disabled",false);
                        $('#city_address, #city_for_db').val(getData.city);
                        $('#state_address, #state_for_db').val(getData.state);
                        $("#business_landmark").html('<option value=""  disabled>--please choose--</option>');
                        $("#business_landmark").append(getData.address_complement);
                        
                    }
                }
            });
        }
    }

    // Signature Upload Form 
    setInterval( () => {
        if($("#previewImage").attr("src") == ''){
            $("#sinature_upload_btn").attr("disabled", true); // disable
        }else{
            $("#sinature_upload_btn").attr("disabled", false); // enable
        }
    }, 100)

    $("#signature_upload").submit( (e) => {
        e.preventDefault();

        var form_data = $("#signature_upload").serialize();
        $.ajax({
            url: 'seller_ajax_call.php',
            method: 'post',
            data: form_data,
            success: (res) => {
                Swal.fire({
                    title: "Congrats!",
                    text: "Signature Uploaded Successfully",
                    icon: "success"
                });

                // Diplaying Image   after upload 
                var from_js_get_data_image = $("#from_js_get_data_image").val();
                $("#view_sign_img").attr("src", from_js_get_data_image);
                $("#view_sign_href").attr("href", from_js_get_data_image);
            }
        })
    })

    // BANK dETAILS
    
    $.validator.setDefaults({
        submitHandler: function(form) {
            $.ajax({
                url: 'seller_ajax_call.php',
                method: 'post',
                data: $(form).serialize(),
                success: (res) => {
                    if(res == 'invalid') {
                        Swal.fire({
                            icon: 'error',
                            title: "Invalid Ifsc code",
                            text: "Please enter valid ifsc code.",
                        });
                    }else{
                        Swal.fire({
                            title: "Congratulations!",
                            text: "Bank Details Updated Successfully",
                            icon: "success"
                        }).then(function() {
                            window.location = window.location.href;
                        });
                    }
                }
            })
        }
    });
    $('#bank-account-form').validate({
        rules: {
            bank_holder_name: {
                required: true,
                rangelength: [3, 50]
            },
            account_number: {
                required: true,
                digits: true,
                rangelength: [9, 17]
            },
            retype_account_number: {
                required: true,
                digits: true,
                rangelength: [9, 17],
                equalTo: "#password",
            },
            ifsc_code: {
                required: true,
                rangelength: [11, 11],
            },
        },
        messages: {
            bank_holder_name: {
                rangelength: "Enter your full name mentioned on bank pass book."
            },
            account_number: {
                digits: "Enter Digits Only",
                rangelength: "Enter Correct Account Number",
            },
            retype_account_number: {
                digits: "Enter Digits Only",
                rangelength: "Enter Correct Account Number",
                equalTo: "Account Number didn't match"
            },
            ifsc_code: {
                rangelength: "Enter Valid IFSC Code"
            },
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

    $('#ifsc_code').on('keyup blur', function() { // fires on every keyup & blur
        if ($('#ifsc_code').valid()) { // checks form for validity
            $('#ifsc_code_submit_check_btn, #BANK_ACCOUNT_FORM_SUBMIT_BTN').prop('disabled',false); // enables button
        } else {
            $('#ifsc_code_submit_check_btn, #BANK_ACCOUNT_FORM_SUBMIT_BTN').prop('disabled','disabled'); // disables button
        }
    });
    $("#ifsc_code_submit_check_btn").click(() => {
        var ifsccode = $("#ifsc_code");

        $.ajax({
            url: "seller_ajax_call.php",
            method: 'post',
            data: "IFSC_CODE_FOR_GETTING_VERIFIED_BANK_DETAILS=" + ifsccode.val(),
            success: (res) => {

                if (res == 'Invalid') {
                    $("#bank_details").html('');
                    $("#BANK_ACCOUNT_FORM_SUBMIT_BTN").attr("disabled", true);
                    Swal.fire({
                        icon: 'error',
                        title: "Invalid Ifsc code",
                        text: "Please enter valid ifsc code.",
                    })
                } else {
                    $("#bank_details").html(res);
                    $("#BANK_ACCOUNT_FORM_SUBMIT_BTN").attr("disabled", false);
                }
            }
        })

    });

    </script>
</body>

</html>