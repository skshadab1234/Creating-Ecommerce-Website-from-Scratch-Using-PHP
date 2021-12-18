<?php
require 'includes/session.php';
require ('../smtp/PHPMailerAutoload.php');

if (isset($_POST['SellerEmailIdtoGetOTP']) && $_POST['SellerEmailIdtoGetOTP'] != '' && isset($_POST['creatingaccountseller']))  {
    $seller_email = get_safe_value($_POST['SellerEmailIdtoGetOTP']);
    $password = get_safe_value($_POST['password']);
    $seller_fullname = get_safe_value($_POST['seller_fullname']);
    $password = password_hash($password, PASSWORD_BCRYPT);
    $data = ExecutedQuery("SELECT * FROM seller_account WHERE seller_email = '$seller_email'");
    if ($data != 0) {
        $arr = array("status" => 'error', 'message'=> 'Email id already exist');
    }else{
        // $_COOKIE['hey'] = 1212;
        if (isset($_COOKIE['verificationCode']) && $_COOKIE['verificationCode'] != '') {
            $rand = $_COOKIE['verificationCode'];
            setcookie("verificationCode", "", time()-3600);
            setcookie("verificationCode", $rand, time() + (60 * 10)); // 60 seconds ( 1 minute) * 20 = 20 minutes
        }else{
            $rand = rand(1111,9999);
            setcookie("verificationCode", $rand, time() + (60 * 10)); // 60 seconds ( 1 minute) * 20 = 20 minutes
        }
        
        $html = '<div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
                    <div style="margin:50px auto;width:70%;padding:20px 0">
                    <div style="border-bottom:1px solid #eee">
                        <a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">'.SITE_NAME.'</a>
                    </div>
                    <p style="font-size:1.1em">Hi,</p>
                    <p>Thank you for becoming a Seller. Use the following OTP to complete your Sign Up procedures. OTP is valid for 10 minutes</p>
                    <h2 style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">'.$rand.'</h2>
                    <p style="font-size:0.9em;">Regards,<br />'.SITE_NAME.'</p>
                    <hr style="border:none;border-top:1px solid #eee" />
                    <div style="float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300">
                        <p>Your '.SITE_NAME.' Inc</p>
                    </div>
                    </div>
                </div>';
        $responseMail = send_email($seller_email, $html, 'OTP FOR SELLER ACCOUNT');
        if($responseMail == 'Sended') {
            $arr = array("status"=>"success", "email" => $seller_email, 'password'=>$password, 'name'=>$seller_fullname);
        }else{
            $arr = array("status"=>"error", "message" => "Something Went Wrong");
        }
    }
    echo json_encode($arr);
}

elseif (isset($_POST['veried_email'])  && $_POST['veried_email'] != '' && isset($_POST['veried_password'])  && $_POST['veried_password'] != ''  && isset($_POST['OTPSENDEBYME']) && $_POST['OTPSENDEBYME'] != '') {
    $OTPSENDEBYME = get_safe_value($_POST['OTPSENDEBYME']);
    $veried_email = get_safe_value($_POST['veried_email']);
    $veried_password = get_safe_value($_POST['veried_password']);
    $veried_name = get_safe_value($_POST['veried_name']);

    if ($OTPSENDEBYME == $_COOKIE['verificationCode']) {
        $arr = array("status" => 'success');
        SqlQuery("INSERT INTO seller_account(seller_email,seller_password,seller_fullname,seller_verified) VALUES('$veried_email','$veried_password','$veried_name',1)");
    }else{
        $arr = array("status" => 'error');
    }

    echo json_encode($arr);
}

elseif (isset($_POST['resendCodeEmail']) && $_POST['resendCodeEmail'] != '') {
    $rand = rand(1111,9999);
    setcookie("verificationCode", "", time()-3600);
    setcookie("verificationCode", $rand, time() + (60 * 10)); // 60 seconds ( 1 minute) * 20 = 20 minutes

    $email = get_safe_value($_POST['resendCodeEmail']);

    $html = '<div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
                <div style="margin:50px auto;width:70%;padding:20px 0">
                <div style="border-bottom:1px solid #eee">
                    <a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">'.SITE_NAME.'</a>
                </div>
                <p style="font-size:1.1em">Hi,</p>
                <p>Thank you for becoming a Seller. Use the following OTP to complete your Sign Up procedures. OTP is valid for 10 minutes</p>
                <h2 style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">'.$rand.'</h2>
                <p style="font-size:0.9em;">Regards,<br />'.SITE_NAME.'</p>
                <hr style="border:none;border-top:1px solid #eee" />
                <div style="float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300">
                    <p>Your '.SITE_NAME.' Inc</p>
                </div>
                </div>
            </div>';
    $responseMail = send_email($email, $html, 'RESEND OTP FOR SELLER ACCOUNT');
    if($responseMail == 'Sended') {
        $arr = array("status"=>"success");
    }else{
        $arr = array("status"=>"error", "message" => "Something Went Wrong");
    }

    echo json_encode($arr);
}

elseif (isset($_POST['LoginEmail']) && $_POST['LoginEmail'] && isset($_POST['LogintoSellerAccount']) && isset($_POST['password']) && $_POST['password'] != '') {
    $email = get_safe_value($_POST['LoginEmail']);
    $password = get_safe_value($_POST['password']);

    $res = ExecutedQuery("SELECT * FROM seller_account WHERE seller_email = '$email'");
    if ($res == 0) {
        $arr = array(
            'status' => 'error',
            'msg' => 'This email id doesn\'t Exist in our system',
            'field' => 'error'
        );
    }else{
        $row_data = $res[0];
        if (password_verify($password, $row_data["seller_password"])){
            if ($row_data['seller_verified'] == 0)
            {
                $arr = array(
                    'status' => 'error',
                    'msg' => 'Please Verify Your Account.',
                    'field' => 'error'
                );
            }
            else
            {
                $_SESSION["SELLER_ID"] = $row_data['id'];
                $arr = array(
                    'status' => 'success',
                    'msg' => 'Wait a minute....redirecting',
                );

            }

        }
        else
        {
            //return false;
            $arr = array(
                'status' => 'error',
                'msg' => 'Password is incorrect',
                'field' => 'error'
            );

        }
    }

    echo json_encode($arr);
}


// Forgot Password System Adding
elseif (isset($_POST['reset_email']) && $_POST['reset_email'] != '' && isset($_POST['RESETEMAIL_PASSWORD_LINK']))
{
    $reset_email = get_safe_value($_POST['reset_email']);
    $SELLERDetails = ExecutedQuery("SELECT * FROM seller_account WHERE seller_email = '$reset_email'");
    if (!empty($SELLERDetails))
    {
        $seller_ResetCode = $SELLERDetails[0]['seller_ResetCode'];
        $link = SELLER_FRONT_SITE . 'update_password?seller_ResetCode=' . $seller_ResetCode . '&seller_email=' . $reset_email;
        $html = '
        <!DOCTYPE html>
        <html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
        
          <head>
            <meta charset="utf-8">
            <meta name="x-apple-disable-message-reformatting">
            <meta http-equiv="x-ua-compatible" content="ie=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
            <!--[if mso]>
            <xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml>
            <style>
              td,th,div,p,a,h1,h2,h3,h4,h5,h6 {font-family: "Segoe UI", sans-serif; mso-line-height-rule: exactly;}
            </style>
          <![endif]-->
            <title>Reset your Password</title>
            <link href="https://fonts.googleapis.com/css?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700" rel="stylesheet" media="screen">
            <style>
              .hover-underline:hover {
                text-decoration: underline !important;
              }
        
              @keyframes spin {
                to {
                  transform: rotate(360deg);
                }
              }
        
              @keyframes ping {
        
                75%,
                100% {
                  transform: scale(2);
                  opacity: 0;
                }
              }
        
              @keyframes pulse {
                50% {
                  opacity: .5;
                }
              }
        
              @keyframes bounce {
        
                0%,
                100% {
                  transform: translateY(-25%);
                  animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
                }
        
                50% {
                  transform: none;
                  animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
                }
              }
        
              @media (max-width: 600px) {
                .sm-px-24 {
                  padding-left: 24px !important;
                  padding-right: 24px !important;
                }
        
                .sm-py-32 {
                  padding-top: 32px !important;
                  padding-bottom: 32px !important;
                }
        
                .sm-w-full {
                  width: 100% !important;
                }
              }
            </style>
          </head>
        
          <body style="margin: 0; padding: 0; width: 100%; word-break: break-word; -webkit-font-smoothing: antialiased; --bg-opacity: 1; background-color: #eceff1; background-color: rgba(236, 239, 241, var(--bg-opacity));">
            <div role="article" aria-roledescription="email" aria-label="Reset your Password" lang="en">
              <table style="font-family: Montserrat, -apple-system, \'Segoe UI\', sans-serif; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                  <td align="center" style="--bg-opacity: 1; background-color: #eceff1; background-color: rgba(236, 239, 241, var(--bg-opacity)); font-family: Montserrat, -apple-system, \'Segoe UI\', sans-serif;" bgcolor="rgba(236, 239, 241, var(--bg-opacity))">
                    <table class="sm-w-full" style="font-family: \'Montserrat\',Arial,sans-serif; width: 600px;" width="600" cellpadding="0" cellspacing="0" role="presentation">
                      <tr>
                        <td align="center" class="sm-px-24" style="font-family: \'Montserrat\',Arial,sans-serif;">
                          <table style="font-family: \'Montserrat\',Arial,sans-serif; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                              <td class="sm-px-24" style="--bg-opacity: 1; background-color: #ffffff; background-color: rgba(255, 255, 255, var(--bg-opacity)); border-radius: 4px; font-family: Montserrat, -apple-system, \'Segoe UI\', sans-serif; font-size: 14px; line-height: 24px; padding: 48px; text-align: left; --text-opacity: 1; color: #626262; color: rgba(98, 98, 98, var(--text-opacity));" bgcolor="rgba(255, 255, 255, var(--bg-opacity))" align="left">
                                <p style="font-weight: 600; font-size: 18px; margin-bottom: 0;">Hey Seller</p>
                                <p style="font-weight: 700; font-size: 20px; margin-top: 0; --text-opacity: 1; color: #ff5850; color: rgba(255, 88, 80, var(--text-opacity));">' . $SELLERDetails[0]['seller_fullname'] . '</p>
                                <p style="margin: 0 0 24px;">
                                  A request to reset password was received from your
                                  <span style="font-weight: 600;">' . SITE_NAME . '</span> Seller Account -
                                  <a href="mailto:' . $SELLERDetails[0]['seller_ResetCode'] . '" class="hover-underline" style="--text-opacity: 1; color: #7367f0; color: rgba(115, 103, 240, var(--text-opacity)); text-decoration: none;">' . $SELLERDetails[0]['seller_ResetCode'] . '</a>
                                </p>
                                <p style="margin: 0 0 24px;">Use this link to reset your password and login.</p>
                                <a href=' . $link . ' style="display: block; font-size: 14px; line-height: 100%; margin-bottom: 24px; --text-opacity: 1; color: #7367f0; color: rgba(115, 103, 240, var(--text-opacity)); text-decoration: none;">' . $link . '</a>
                                <table style="font-family: \'Montserrat\',Arial,sans-serif;" cellpadding="0" cellspacing="0" role="presentation">
                                  <tr>
                                    <td style="mso-padding-alt: 16px 24px; --bg-opacity: 1; background-color: #7367f0; background-color: rgba(115, 103, 240, var(--bg-opacity)); border-radius: 4px; font-family: Montserrat, -apple-system, \'Segoe UI\', sans-serif;" bgcolor="rgba(115, 103, 240, var(--bg-opacity))">
                                      <a href=' . $link . ' style="display: block; font-weight: 600; font-size: 14px; line-height: 100%; padding: 16px 24px; --text-opacity: 1; color: #ffffff; color: rgba(255, 255, 255, var(--text-opacity)); text-decoration: none;">Reset Password &rarr;</a>
                                    </td>
                                  </tr>
                                </table>
                                <p style="margin: 24px 0;">
                                  <span style="font-weight: 600;">Note:</span> This link is valid for one time use from the time it was
                                  sent to you and can be used to change your password only once.
                                </p>
                                <p style="margin: 0;">
                                  If you did not intend to deactivate your account or need our help keeping the account, please
                                  contact us at
                                  <a href="mailto:support@example.com" class="hover-underline" style="--text-opacity: 1; color: #7367f0; color: rgba(115, 103, 240, var(--text-opacity)); text-decoration: none;">support@example.com</a>
                                </p>
                                <table style="font-family: \'Montserrat\',Arial,sans-serif; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                  <tr>
                                    <td style="font-family: \'Montserrat\',Arial,sans-serif; padding-top: 32px; padding-bottom: 32px;">
                                      <div style="--bg-opacity: 1; background-color: #eceff1; background-color: rgba(236, 239, 241, var(--bg-opacity)); height: 1px; line-height: 1px;">&zwnj;</div>
                                    </td>
                                  </tr>
                                </table>
                                <p style="margin: 0 0 16px;">Thanks, <br>The ' . SITE_NAME . ' Team</p>
                              </td>
                            </tr>
                            <tr>
                              <td style="font-family: \'Montserrat\',Arial,sans-serif; height: 20px;" height="20"></td>
                               </tr>
                            <tr>
                              <td style="font-family: \'Montserrat\',Arial,sans-serif; height: 16px;" height="16"></td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </div>
          </body>
        
        </html>';
        $emailresp = send_email($reset_email, $html, 'Reset Your Paswword');
        if ($emailresp == 'Sended')
        {
            $arr = array(
                'status' => 'success',
                'message' => 'Link Sended to ' . $reset_email . ''
            );
        }

    }
    else
    {
        $arr = array(
            'status' => 'error',
            'message' => 'Please check and try again'
        );
    }
    echo json_encode($arr);
}

// Update Password
elseif (isset($_POST['seller_id_update_pass']) && $_POST['seller_id_update_pass'] > 0 && isset($_POST['new_password']) && $_POST['new_password'] != '' && isset($_POST['confirm_password']) && $_POST['confirm_password'] != '')
{
    $seller_id = get_safe_value($_POST['seller_id_update_pass']);
    $new_password = get_safe_value($_POST['new_password']);
    $confirm_password = get_safe_value($_POST['confirm_password']);

    if (strlen($new_password) < 8)
    {
        $arr = array(
            'status' => 'error',
            'message' => 'Password too short!'
        );
    }
    else if (!preg_match("#[0-9]+#", $new_password))
    {
        $arr = array(
            'status' => 'error',
            'message' => 'Password must include at least one number!'
        );
    }
    else if (!preg_match("#[A-Z]+#", $new_password))
    {
        $arr = array(
            'status' => 'error',
            'message' => 'Password must include at least one letter!'
        );
    }
    else if ($new_password != $confirm_password)
    {
        $arr = array(
            'status' => 'error',
            'message' => 'Please make sure your passwords match.'
        );
    }
    else
    {
        $new_password = password_hash($new_password, PASSWORD_BCRYPT);
        mysqli_query($con, "UPDATE seller_account set seller_password= '$new_password' WHERE id = '$seller_id'");
        $arr = array(
            "status" => 'success',
            'message' => 'Password Updated'
        );
    }
    echo json_encode($arr);
}

// Pick up address pincode updating to db 
elseif (isset($_POST['postal_code']) && $_POST['postal_code'] != '' && isset($_POST['address_line']) && $_POST['address_line']  != ''  && isset($_POST['city_for_db']) && $_POST['city_for_db']  != '' && isset($_POST['state_for_db']) && $_POST['state_for_db']  != '' && isset($_POST['delivery_boy_landmark']) && $_POST['delivery_boy_landmark']  != '' ) {
    $postal_code = get_safe_value($_POST['postal_code']);
    $address_line = get_safe_value($_POST['address_line']);
    $state_for_db = get_safe_value($_POST['state_for_db']);
    $city_for_db = get_safe_value($_POST['city_for_db']);
    $delivery_boy_landmark = get_safe_value($_POST['delivery_boy_landmark']);
    $seller_id = $_SESSION['SELLER_ID'];

    SqlQuery("UPDATE seller_account SET seller_pincode='$postal_code', shop_address='$address_line', shop_city='$city_for_db', shop_state='$state_for_db', shop_landmark='$delivery_boy_landmark' WHERE id = '$seller_id'");
    
}

// IFSC CODE CHECK 
elseif (isset($_POST['ifsc_code']) && isset($_POST['bank_holder_name'])  && isset($_POST['account_number']) && isset($_POST['retype_account_number']) ) {
    $ifsc_code = get_safe_value($_POST['ifsc_code']);
    $url = @file_get_contents('https://ifsc.razorpay.com/'.$ifsc_code);
    $res = json_decode($url,true);

    if(isset($res['STATE'])){
        $bank_holder_name = get_safe_value($_POST['bank_holder_name']);
        $account_number = get_safe_value($_POST['account_number']);
        $bank_cancelled_cheque = get_safe_value($_POST['from_js_get_data_image']);
        $bank_name = $res['BANK'];
        $bank_branch = $res['BRANCH'];
        $bank_city = $res['CITY'];
        $bank_state = $res['STATE'];
        $seller_id = $_SESSION['SELLER_ID'];
        SqlQuery("update seller_account set bank_name='$bank_name', bank_branch='$bank_branch', bank_city='$bank_city', bank_state='$bank_state', bank_account_hold_name='$bank_holder_name', bank_account_number='$account_number', bank_ifsc='$ifsc_code', bank_cancelled_cheque='$bank_cancelled_cheque' WHERE id = '$seller_id'");
    }else{
        echo 'invalid';
    }
}

elseif (isset($_POST['IFSC_CODE_FOR_GETTING_VERIFIED_BANK_DETAILS']) && $_POST['IFSC_CODE_FOR_GETTING_VERIFIED_BANK_DETAILS'] != '') {
    $ifsc_code = get_safe_value($_POST['IFSC_CODE_FOR_GETTING_VERIFIED_BANK_DETAILS']);
    $url = @file_get_contents('https://ifsc.razorpay.com/'.$ifsc_code);
    $res = json_decode($url,true);
    $html = '';
    if (isset($res['STATE'])) {
    $html .= '
    <dl class="row">
        <dt class="col-sm-4">Bank Name</dt>
        <dd class="col-sm-8">'.$res['BANK'].' </dd>
        <input type="hidden" name="bank_name" id="bank_name" value="'.$res['BANK'].'">
        <dt class="col-sm-4">Branch</dt>
        <dd class="col-sm-8">'.$res['BRANCH'].'</dd>
        <input type="hidden" name="bank_branch" id="bank_branch" value="'.$res['BRANCH'].'">
        <dt class="col-sm-4">City</dt>
        <dd class="col-sm-8">'.$res['CITY'].'</dd>
        <input type="hidden" name="bank_city" id="bank_city" value="'.$res['CITY'].'">
        <dt class="col-sm-4">State</dt>
        <dd class="col-sm-8">'.$res['STATE'].' </dd>
        <input type="hidden" name="bank_state" id="bank_state" value="'.$res['STATE'].'">
    </dl>
  
    ';
    }else{
        $html.= "Invalid";
    }
    
    echo $html;
}

// Store Details 
elseif (isset($_POST['seller_store_name']) && isset($_POST['seller_store_description']) && isset($_POST['WorkingonStoreDetails'])) {
    $seller_store_name = get_safe_value($_POST['seller_store_name']);
    $seller_store_description = get_safe_value($_POST['seller_store_description']);
    $seller_id = $_SESSION['SELLER_ID'];

    SqlQuery("UPDATE seller_account SET seller_store_name='$seller_store_name', seller_store_description='$seller_store_description' WHERE id= '$seller_id'");
}

// Business Address 
elseif (isset($_POST['seller_store_address']) && isset($_POST['postal_code']) && isset($_POST['city_for_db']) && isset($_POST['state_for_db']) && isset($_POST['business_landmark'])) {
    $seller_store_address = get_safe_value($_POST['seller_store_address']);
    $postal_code = get_safe_value($_POST['postal_code']);
    $city_for_db = get_safe_value($_POST['city_for_db']);
    $state_for_db = get_safe_value($_POST['state_for_db']);
    $business_landmark = get_safe_value($_POST['business_landmark']);
    $seller_id = $_SESSION['SELLER_ID'];

    SqlQuery("UPDATE seller_account SET business_address='$seller_store_address', business_pincode='$postal_code', business_city='$city_for_db', business_state='$state_for_db', business_landmark='$business_landmark' WHERE id= '$seller_id'");
}

// Signature Upload
elseif (isset($_POST['from_js_get_data_image']) && isset($_POST['signature_upload'])) {
    $signature_image = get_safe_value($_POST['from_js_get_data_image']);
    $seller_id = $_SESSION['SELLER_ID'];
    SqlQuery("UPDATE seller_account SET seller_signature='$signature_image' WHERE id= '$seller_id'");
}

// Add New Brand 
elseif (isset($_POST['brand_selection_for_add_new'])) {
    $brand_selected = get_safe_value($_POST['brand_selection_for_add_new']);
    $subcategory_selection = get_safe_value($_POST['subcategory_selection']);
    $brand_data = ExecutedQuery("SELECT * FROM brands WHERE brand_status = 1 && brand_name='$brand_selected'");

    $html = '';

    if ($brand_data == 0) {
        // Not Get On Db 
        // if not on db then diplay start selling button
        $html .= '<i class="fa fa-check-circle text-success"></i>
                <p class="mt-2">'.$brand_selected.' </p>
                <p class="mt-2">You can start selling under this brand.</p>
                ';
                $html .="<button class='mt-2 btn btn-default btn-primary' onclick=\"start_selling_under_this_brand('".$brand_selected."','".$brand_data['bid']."')\">Start Selling</button>";
    }else{
        $brand_data = $brand_data[0];
        // Got on Db
        $seller_request_approve_explode = explode(",", $brand_data['seller_request_approved']);
        $seller_request_in_process_explode = explode(",", $brand_data['seller_request_in_process']);
        $seller_request_rejected_explode = explode(",", $brand_data['seller_request_rejected']);
        $seller_id = $_SESSION['SELLER_ID'];

        if ($seller_id == $brand_data['sellerId_BrandOwner']) {
            // this seller is owner of this brand
            $html .= '<i class="fa fa-check-circle text-success"></i>   
                    <p class="mt-2">'.$brand_selected.'</p>
                    <p class="mt-2">You are the owner of this brand</p>
                    ';
                    $html .="<button class='mt-2 btn btn-default btn-primary' onclick=\"start_selling_under_this_brand('".$brand_selected."','".$brand_data['bid']."')\">Start Selling</button>";
        }else{
            // NOt a Owner of this Brand 
            // if seller account getted approved from brand owner then this message will show 
            if (in_array($seller_id, $seller_request_approve_explode)) {
                $html .= '<i class="fa fa-check-circle text-success"></i>   
                        <p class="mt-2">'.$brand_selected.'</p>
                        <p class="mt-2">Your Request has been approved by Brand Owner.</p>
                        <p class="mt-2">You can Start Selling Under this Brand.</p>
                        ';
                $html .="<button class='mt-2 btn btn-default btn-primary' onclick=\"start_selling_under_this_brand('".$brand_selected."','".$brand_data['bid']."')\">Start Selling</button>";
            }

            // if seller account is in process then this message will show
            else if (in_array($seller_id, $seller_request_in_process_explode)) {
                $html .= '<i class="fa fa-spinner text-warning"></i>   
                        <p class="mt-2">'.$brand_selected.'</p>
                        <p class="mt-2">Your Request is in Process.</p>
                        <p class="mt-2">You can wait or select another brand.</p>';
            }
            
            // in any how that brand owner reject the seller requested approval then this messsage will show
            else if (in_array($seller_id, $seller_request_rejected_explode)) {
                $html .= ' <i class="fa fa-ban text-danger"></i>   
                        <p class="mt-2">'.$brand_selected.'</p>
                        <p class="mt-2">Your Request is Rejected.</p>
                        <p class="mt-2">You can not sell under this brand.</p>
                        <p class="mt-2">If this is our fault then you can <a href="">contact us</a>.</p>';
            }

            else{
                // Show Approval Form to get approval from brand owner
                $html .= '<i class="fa fa-times-circle text-danger"></i>   
                        <p class="mt-2">'.$brand_selected.'</p>
                        <p class="mt-2">Please apply for an approval to sell under this brand.</p>
                        <a href="'.SELLER_FRONT_SITE.'ApplyforBrand?brandid='.$brand_data['bid'].'&brand='.$brand_selected.'" target="_blank"><button class="mt-2 btn btn-default btn-primary">Apply for Brand Approval</button></a>';
            }
        }
        
    }

    echo $html;
}

// Brand Request Updating By Brand Owner 
elseif (isset($_POST['approvalBrand_id']) && isset($_POST['brand_id']) && isset($_POST['sellerReqId']) && isset($_POST['approval_comment'])) {
  $approvalBrand_id = get_safe_value($_POST['approvalBrand_id']);
  $brand_id = get_safe_value($_POST['brand_id']);
  $sellerReqId = get_safe_value($_POST['sellerReqId']);
  $approval_comment = get_safe_value($_POST['approval_comment']);

  if (!isset($_POST['select_brand_status'])) {
    $arr = array("status" => "error");
  }else{
    SqlQuery("UPDATE brand_approval_doc SET notes_from_brand_owner = '$approval_comment' WHERE id = '$approvalBrand_id'");
    $brand_fromDb = ExecutedQuery("SELECT * FROM brands WHERE bid = '$brand_id'")[0];

    $seller_request_approved_explode = explode(",",$brand_fromDb['seller_request_approved']);
    $seller_request_in_process_explode = explode(",",$brand_fromDb['seller_request_in_process']);
    $seller_request_rejected_explode = explode(",",$brand_fromDb['seller_request_rejected']);

    // Remove Seller Id from array list 
    foreach (array_keys($seller_request_approved_explode, $sellerReqId) as $key) {
        unset($seller_request_approved_explode[$key]);
    }

    foreach (array_keys($seller_request_in_process_explode, $sellerReqId) as $key) {
        unset($seller_request_in_process_explode[$key]);
    }

    foreach (array_keys($seller_request_rejected_explode, $sellerReqId) as $key) {
        unset($seller_request_rejected_explode[$key]);
    }

    $select_brand_status = get_safe_value($_POST['select_brand_status']);
    $seller_request_in_process_string = implode(',',$seller_request_in_process_explode);
    $seller_request_approved_string = implode(',',$seller_request_approved_explode);
    $seller_request_rejected_string = implode(',',$seller_request_rejected_explode);

    if ($select_brand_status == 0) {
      if($brand_fromDb['seller_request_in_process'] != '') {
        $seller_request_in_process_string = $seller_request_in_process_string.','.$sellerReqId;
      }else{
        $seller_request_in_process_string = $sellerReqId;
      }  

      // We use this status in response for displaying into status column
      $approval_status = '<span class="text-warning">In Process</span>';
    }

    if ($select_brand_status == 1) {
      if($brand_fromDb['seller_request_approved'] != '') {
        $seller_request_approved_string = $seller_request_approved_string.','.$sellerReqId;
      }else{
        $seller_request_approved_string = $sellerReqId;
      }  

      $approval_status = '<span class="text-success">Approved</span>';
    }

    if ($select_brand_status == 2) {
      if($brand_fromDb['seller_request_rejected'] != '') {
        $seller_request_rejected_string = $seller_request_rejected_string.','.$sellerReqId;
      }else{
        $seller_request_rejected_string = $sellerReqId;
      }  
      $approval_status = '<span class="text-danger">Rejected</span>';
    }

    SqlQuery("UPDATE brands SET seller_request_approved = '$seller_request_approved_string',
              seller_request_in_process = '$seller_request_in_process_string',
              seller_request_rejected = '$seller_request_rejected_string' WHERE bid = '$brand_id'");

    $arr = array("status" => "success",'note'=>$approval_comment, 'approval_Brandid' => $approvalBrand_id, 'approval_status' => $approval_status);
  }

  echo json_encode($arr);
}











