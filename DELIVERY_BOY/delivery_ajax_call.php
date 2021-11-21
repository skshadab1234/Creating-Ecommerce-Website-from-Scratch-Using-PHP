<?php
require 'includes/session.php';
include ('../smtp/PHPMailerAutoload.php');

if (isset($_POST['delivery_email']) && isset($_POST['delivery_password']))
{
    $delivery_email = get_safe_value($_POST['delivery_email']);
    $delivery_password = get_safe_value($_POST['delivery_password']);

    $query = "SELECT * FROM delivery_boy WHERE delivery_boy_email = '$delivery_email'";
    $results = mysqli_query($con, $query);
    if (mysqli_num_rows($results) > 0)
    {
        while ($row = mysqli_fetch_assoc($results))
        {
            if (password_verify($delivery_password, $row["delivery_boy_password"]))
            {
                if ($row['delivery_boy_verifed'] == 0)
                {
                    $arr = array(
                        'status' => 'error',
                        'msg' => 'Please Verify Your Account.',
                        'field' => 'error'
                    );
                }
                else
                {
                    $_SESSION["DELIVERY_ID"] = $row['delivery_boy_id'];

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
    }
    else
    {
        $arr = array(
            'status' => 'error',
            'msg' => 'Email Id Not Found',
            'field' => 'error'
        );
    }

    echo json_encode($arr);
}

// Forgot Password System Adding
elseif (isset($_POST['reset_email']) && $_POST['reset_email'] != '')
{
    $reset_email = get_safe_value($_POST['reset_email']);
    $DeliveryDetails = DeliveryDetails("WHERE delivery_boy_email = '$reset_email'");
    if (!empty($DeliveryDetails))
    {
        $deliveryLoginCode = $DeliveryDetails[0]['deliveryLoginCode'];
        $link = DELIVERY_FRONT_SITE . 'update_password?deliveryLoginCode=' . $deliveryLoginCode . '&delivery_boy_email=' . $reset_email;
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
                                <p style="font-weight: 600; font-size: 18px; margin-bottom: 0;">Hey </p>
                                <p style="font-weight: 700; font-size: 20px; margin-top: 0; --text-opacity: 1; color: #ff5850; color: rgba(255, 88, 80, var(--text-opacity));">' . $DeliveryDetails[0]['delivery_boy_name'] . '</p>
                                <p style="margin: 0 0 24px;">
                                  A request to reset password was received from your
                                  <span style="font-weight: 600;">' . SITE_NAME . '</span> Account -
                                  <a href="mailto:' . $DeliveryDetails[0]['delivery_boy_email'] . '" class="hover-underline" style="--text-opacity: 1; color: #7367f0; color: rgba(115, 103, 240, var(--text-opacity)); text-decoration: none;">' . $DeliveryDetails[0]['delivery_boy_email'] . '</a>
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
elseif (isset($_POST['delivery_id_update_pass']) && $_POST['delivery_id_update_pass'] > 0 && isset($_POST['new_password']) && $_POST['new_password'] != '' && isset($_POST['confirm_password']) && $_POST['confirm_password'] != '')
{
    $delivery_boy_id = get_safe_value($_POST['delivery_id_update_pass']);
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
        mysqli_query($con, "UPDATE delivery_boy set delivery_boy_password= '$new_password' WHERE delivery_boy_id = '$delivery_boy_id'");
        $arr = array(
            "status" => 'success',
            'message' => 'Password Updated'
        );
    }
    echo json_encode($arr);
}

// Profile Photo
elseif(!empty($_FILES['identity_image_delivery_front_end_site']['name'])){
    
    //File uplaod configuration
    $result = 0;
    $uploadDir = SERVER_DELIVERY_PROFILE;
    $fileName = time().'_'.basename($_FILES['identity_image_delivery_front_end_site']['name']);
    $targetPath = $uploadDir. $fileName;
    $file_path = DELIVERY_PROFILE.$fileName;
    $DELIVERYDataId = $DELIVERYData['delivery_boy_id'];

    $res = SqlQuery("Select * from delivery_boy Where delivery_boy_id = '$DELIVERYDataId'");
    $row = mysqli_fetch_assoc($res);
    unlink($uploadDir.$row['delivery_boy_profile']);
    //Upload file to server
    if(@move_uploaded_file($_FILES['identity_image_delivery_front_end_site']['tmp_name'], $targetPath)){
        //Get current user ID from session
        
        //Update picture name in the database
        $update = mysqli_query($con,"UPDATE delivery_boy SET delivery_boy_profile = '".$fileName."' WHERE delivery_boy_id = '$DELIVERYDataId'");
        //Update status
        if($update){
            $result = 1;
            
        }
    }
    
    //Load JavaScript function to show the upload status
    echo '<script type="text/javascript">window.top.window.completeUpload(' . $result . ',\'' . $file_path . '\');</script>  ';
}

// Profile Delivery Boy update 
elseif (isset($_POST['boy_name']) && $_POST['boy_name'] != '' && isset($_POST['delivery_boy_phone']) && $_POST['delivery_boy_phone'] != ''
        && isset($_POST['delivery_boy_address']) && $_POST['delivery_boy_address'] != ''
        && isset($_POST['delvery_boy_pincode']) && $_POST['delvery_boy_pincode'] != ''
        && isset($_POST['city']) && $_POST['city'] != ''
        && isset($_POST['state']) && $_POST['state'] != ''
        && isset($_POST['delivery_boy_landmark']) && $_POST['delivery_boy_landmark'] != '') 
{
       $boy_name = get_safe_value($_POST['boy_name']);
       $delivery_boy_phone = get_safe_value($_POST['delivery_boy_phone']);
       $delivery_boy_address = get_safe_value($_POST['delivery_boy_address']);
       $delvery_boy_pincode = get_safe_value($_POST['delvery_boy_pincode']);
       $city = get_safe_value($_POST['city']);
       $state = get_safe_value($_POST['state']);
       $delivery_boy_landmark = get_safe_value($_POST['delivery_boy_landmark']);
       $change_password = get_safe_value($_POST['change_password']);
       $curr_password = get_safe_value($_POST['curr_password']);

    
       if (password_verify($curr_password, $DELIVERYData["delivery_boy_password"])) {
            // Password Correct
            if ($change_password != '') {
                $password = password_hash($change_password,PASSWORD_BCRYPT);
                $message = 'Password also Changed';
            } else{
                $password = password_hash($curr_password,PASSWORD_BCRYPT);
                $message = '';
            }
            SqlQuery("Update delivery_boy set delivery_boy_name='$boy_name', delivery_boy_phone='$delivery_boy_phone', delivery_boy_address	='$delivery_boy_address', delivery_boy_password = '$password', delvery_boy_pincode='$delvery_boy_pincode', delivery_boy_city='$city', delivery_boy_landmark='$delivery_boy_landmark',  delivery_boy_state='$state' WHERE delivery_boy_id = '".$DELIVERYData['delivery_boy_id']."'");
            $arr = array("status" => 'success', 'message' => 'Profile Updated Successfully', 'text' => $message, 'Name' => $boy_name);
       }else{
           // Current Password Wrong    
           $arr = array("status"=>'error','message'=>'Current Password is wrong');
       }

       echo json_encode($arr);
}