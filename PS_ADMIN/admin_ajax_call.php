<?php
require 'includes/session.php';
include('../smtp/PHPMailerAutoload.php');

if (isset($_POST['admin_email']) && isset($_POST['admin_password'])) {
    $admin_email = get_safe_value($_POST['admin_email']);
    $admin_password = get_safe_value($_POST['admin_password']);

    $query = "SELECT * FROM admins WHERE admin_email = '$admin_email'";
    $results = mysqli_query($con, $query);
    if (mysqli_num_rows($results) > 0)
    {
        while ($row = mysqli_fetch_assoc($results))
        {
            if (password_verify($admin_password, $row["admin_password"]))
            {
                if ($row['admin_verified'] == 0) {
                    $arr = array(
                        'status' => 'error',
                        'msg' => 'Please Verify Your Account.',
                        'field' => 'error'
                    );
                }else {
                    $_SESSION["ADMIN_ID"] = $row['id'];

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
    }else{
        $arr = array(
            'status' => 'error',
            'msg' => 'Email Id Not Found',
            'field' => 'error'
        );
    }

echo json_encode($arr);
}

elseif (isset($_POST['SelectedDate'])) {
    $SelectedDate = get_safe_value($_POST['SelectedDate']);
    $convert_selectedDate = date("Y-m-d", strtotime($SelectedDate));
        
    // Working for Orders Section 
        // Required Function Data 
        $todayOrderTotal = COUNT(OrderSql("WHERE added_on = '$convert_selectedDate' && payment_status='succeeded'"));

        // Getting Total Product Sale Yesterday and Getting how much product sale today compare to yesterday 
        $yesterDate= date('Y-m-d',strtotime("-1 days", strtotime($convert_selectedDate)));

        $YesterdayTotalOrder = COUNT(OrderSql("WHERE added_on = '$yesterDate' && payment_status='succeeded'"));

       if ($todayOrderTotal > $YesterdayTotalOrder) {
            $SaleMoreOrdersTotal = $todayOrderTotal - $YesterdayTotalOrder;
            $SaleMoreOrdersTotal_Color = 'text-success';
            $SaleMoreOrdersTotal_Arrow = 'ion-arrow-up-c';
        }else{
            $SaleMoreOrdersTotal = $todayOrderTotal - $YesterdayTotalOrder;
            $SaleMoreOrdersTotal_Color = 'text-danger';
            $SaleMoreOrdersTotal_Arrow = 'ion-arrow-down-c';
        }

        if ($convert_selectedDate == date('Y-m-d')) {
            $output_date = 'Today';
        }else{
            $output_date = date("d M, Y", strtotime($SelectedDate));
        }
        $orders_html = '<h3>'.numtostring($todayOrderTotal).'<span style="font-size: 14px; font-weight:100" class="'.$SaleMoreOrdersTotal_Color.'"> '.numtostring($SaleMoreOrdersTotal).'<i class="'.$SaleMoreOrdersTotal_Arrow.'"></i></span> </h3>
        <p>'.$output_date.' Orders</p>';

    // End of Order Section 

    // Start of Product Section 
        $TodayProducts = COUNT(ProductDetails("WHERE product_added_on='$convert_selectedDate'"));
        $TotalProducts = COUNT(ProductDetails("WHERE product_status='1'"));

        $product_html = '<h3>'.numtostring($TodayProducts).'</h3>
                        <p>Total Products <span class="text-success">'.numtostring($TotalProducts).'</span></p>';


    // End of Product Section     
    
    // Start of Customer Details Section 
        $UsersTotalTodayAdded = COUNT(UsersDetails("WHERE userAdded_On='$convert_selectedDate'"));
        $VerifiedUsersTotal = COUNT(UsersDetails("WHERE verify='1'"));
        $users_html = '<h3>'.numtostring($UsersTotalTodayAdded).'</h3>
                       <p>Total Users <span class="text-success">'.numtostring($VerifiedUsersTotal).'</span></p>';

    // End of Customer Section 

    // Start of Revenue Section 
        $TodayRevenue = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(amount_captured) as today_earned FROM payment_details WHERE added_on = '$convert_selectedDate'"));
        $YesterDayRevenue = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(amount_captured) as yester_earned FROM payment_details WHERE added_on = '$yesterDate'"));
        $Total_Revenue = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(amount_captured) as total_earned FROM payment_details"));

        if ($TodayRevenue['today_earned'] > $YesterDayRevenue['yester_earned']) {
            $YesterDayRevenueTotal = $TodayRevenue['today_earned'] - $YesterDayRevenue['yester_earned'];
            $YesterDayRevenueTotal_Color = 'text-success';
            $YesterDayRevenueTotal_Arrow = 'ion-arrow-up-c';
        }else{
            $YesterDayRevenueTotal = $TodayRevenue['today_earned'] - $YesterDayRevenue['yester_earned'];
            $YesterDayRevenueTotal_Color = 'text-danger';
            $YesterDayRevenueTotal_Arrow = 'ion-arrow-down-c';
        }

        $revenue_html = '<h3>'.numtostring((int)$TodayRevenue['today_earned']).'
                            <span style="font-size: 14px; font-weight:100" class="'.$YesterDayRevenueTotal_Color.'"> 
                                '.numtostring($YesterDayRevenueTotal).'
                                <i class="'.$YesterDayRevenueTotal_Arrow.'"></i>
                            </span> 
                        </h3>
                        <p>Revenue <span class="text-success">'.numtostring((int)$Total_Revenue['total_earned']).'</span></p>';
    
                        $arr = array(
            'order_html' => $orders_html, 
            'product_html' => $product_html,
            'users_html' => $users_html,
            'revenue_html' => $revenue_html
        );
        echo json_encode($arr);

}

// Forgot Password System Adding 
elseif (isset($_POST['reset_email']) && $_POST['reset_email'] != '') {
    $reset_email = get_safe_value($_POST['reset_email']);
    $AdminDetails = AdminDetails("WHERE admin_email = '$reset_email'");
    if (!empty($AdminDetails)) {
        $adminLoginCode = $AdminDetails[0]['adminLoginCode'];
        $link = ADMIN_FRONT_SITE.'update_password?adminLoginCode='.$adminLoginCode.'&admin_email='.$reset_email;
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
                                <p style="font-weight: 600; font-size: 18px; margin-bottom: 0;">Hey Admin</p>
                                <p style="font-weight: 700; font-size: 20px; margin-top: 0; --text-opacity: 1; color: #ff5850; color: rgba(255, 88, 80, var(--text-opacity));">'.$AdminDetails[0]['admin_full_name'].'</p>
                                <p style="margin: 0 0 24px;">
                                  A request to reset password was received from your
                                  <span style="font-weight: 600;">'.SITE_NAME.'</span> Account -
                                  <a href="mailto:'.$AdminDetails[0]['admin_email'].'" class="hover-underline" style="--text-opacity: 1; color: #7367f0; color: rgba(115, 103, 240, var(--text-opacity)); text-decoration: none;">'.$AdminDetails[0]['admin_email'].'</a>
                                </p>
                                <p style="margin: 0 0 24px;">Use this link to reset your password and login.</p>
                                <a href='.$link.' style="display: block; font-size: 14px; line-height: 100%; margin-bottom: 24px; --text-opacity: 1; color: #7367f0; color: rgba(115, 103, 240, var(--text-opacity)); text-decoration: none;">'.$link.'</a>
                                <table style="font-family: \'Montserrat\',Arial,sans-serif;" cellpadding="0" cellspacing="0" role="presentation">
                                  <tr>
                                    <td style="mso-padding-alt: 16px 24px; --bg-opacity: 1; background-color: #7367f0; background-color: rgba(115, 103, 240, var(--bg-opacity)); border-radius: 4px; font-family: Montserrat, -apple-system, \'Segoe UI\', sans-serif;" bgcolor="rgba(115, 103, 240, var(--bg-opacity))">
                                      <a href='.$link.' style="display: block; font-weight: 600; font-size: 14px; line-height: 100%; padding: 16px 24px; --text-opacity: 1; color: #ffffff; color: rgba(255, 255, 255, var(--text-opacity)); text-decoration: none;">Reset Password &rarr;</a>
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
                                <p style="margin: 0 0 16px;">Thanks, <br>The '.SITE_NAME.' Team</p>
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
        if ($emailresp == 'Sended') {
            $arr = array(
                'status' => 'success',
                'message' => 'Link Sended to '.$reset_email.''
            );
        }
        
    }else{
        $arr = array(
            'status' => 'error',
            'message' => 'Please check and try again'
        );
    }
    echo json_encode($arr);
}

// Update Password 
elseif (isset($_POST['admin_id_update_pass']) && $_POST['admin_id_update_pass'] > 0 && isset($_POST['new_password']) && $_POST['new_password'] != '' && isset($_POST['confirm_password']) && $_POST['confirm_password'] != '') {
  $admin_id = get_safe_value($_POST['admin_id_update_pass']);
  $new_password = get_safe_value($_POST['new_password']);
  $confirm_password = get_safe_value($_POST['confirm_password']);

  if (strlen($new_password) < 8) {
      $arr= array('status' => 'error', 'message' => 'Password too short!');
  }
  else if (!preg_match("#[0-9]+#", $new_password)) {
      $arr= array('status' => 'error', 'message' => 'Password must include at least one number!');
  }
  else  if (!preg_match("#[A-Z]+#", $new_password)) {
      $arr= array('status' => 'error', 'message' => 'Password must include at least one letter!');
  }
  else if ($new_password  != $confirm_password) {
      $arr= array('status' => 'error', 'message' => 'Please make sure your passwords match.');
  } 
  else{
      $new_password=password_hash($new_password,PASSWORD_BCRYPT);
      mysqli_query($con, "UPDATE admins set admin_password= '$new_password' WHERE id = '$admin_id'");
      $arr = array("status" => 'success', 'message' => 'Password Updated');
  }
  echo json_encode($arr);
}

elseif (isset($_POST['product_name']) && isset($_POST['total_stock']) && isset($_POST['product_size']) && isset($_POST['short_description']) && isset($_POST['long_description']) && isset($_POST['product_price'])) {
  $product_name = get_safe_value($_POST['product_name']);
  $brand_data = get_safe_value($_POST['brand_data']);
  $total_stock = get_safe_value($_POST['total_stock']);
  $product_size = get_safe_value($_POST['product_size']);
  $product_weight = get_safe_value($_POST['product_weight']);
  $short_description = get_safe_value($_POST['short_description']);
  $long_description = get_safe_value($_POST['long_description']);
  $product_price = get_safe_value($_POST['product_price']);
  $product_oldPrice = get_safe_value($_POST['product_oldPrice']);
  $product_waist = get_safe_value($_POST['product_waist']);
  $product_hips = get_safe_value($_POST['product_hips']);
  $product_tags = get_safe_value($_POST['product_tags']);
  $product_opt = get_safe_value($_POST['product_opt']);
  $date = date('Y-m-d');
  $prodid = get_safe_value($_POST['prodid']);
  
  $category = $_POST['category'];
  $category = implode(" / ", $category);
  
  $_SESSION['product_name'] = $product_name;

  if(count(ProductDetails("WHERE product_name = '$product_name'")) > 0){
    if ($product_opt == 'update') {
      SqlQuery("UPDATE product_details set product_name = '$product_name', 
                                          product_brand = '$brand_data',
                                          total_stock = '$total_stock',
                                          product_size = '$product_size',
                                          product_weight = '$product_weight',
                                          product_desc_short = '$short_description',
                                          product_desc_long = '$long_description',
                                          product_categories = '$category',
                                          product_price = '$product_price',
                                          product_oldPrice = '$product_oldPrice',
                                          product_waist = '$product_waist',
                                          product_hips = '$product_hips',
                                          product_tags = '$product_tags' WHERE id = '$prodid'");
      $arr = array("status" => 'update_success', 'message' => 'Product Updated', 'product_name'=>$product_name);  
    }
    else{
      $arr = array("status" => 'error', 'message' => 'Product Already Exists!');
    }
    
  }else{
      if ($product_opt == 'add') {
        SqlQuery("INSERT into product_details(
          product_name,
          product_brand,
          total_stock, 
          product_size,
          product_weight,
          product_desc_short,
          product_desc_long,
          product_price,
          product_categories,
          product_oldPrice,
          product_waist,
          product_hips, 
          product_tags,
          product_status,
          product_added_on)
          
          VALUES('$product_name', 
              '$brand_data', 
              '$total_stock', 
              '$product_size', 
              '$product_weight', 
              '$short_description', 
              '$long_description', 
              '$product_price', 
              '$category',
              '$product_oldPrice', 
              '$product_waist', 
              '$product_hips', 
              '$product_tags',
              '2',
              '$date')");  
              
        $arr = array("status" => 'success', 'message' => 'Product Saved as Draft', 'product_name'=>$product_name);            
      }
      else if ($product_opt == 'update') {
        SqlQuery("UPDATE product_details set product_name = '$product_name', 
                                          product_brand = '$brand_data',
                                          total_stock = '$total_stock',
                                          product_size = '$product_size',
                                          product_weight = '$product_weight',
                                          product_desc_short = '$short_description',
                                          product_desc_long = '$long_description',
                                          product_categories = '$category',
                                          product_price = '$product_price',
                                          product_oldPrice = '$product_oldPrice',
                                          product_waist = '$product_waist',
                                          product_hips = '$product_hips',
                                          product_tags = '$product_tags' WHERE id = '$prodid'");
        $arr = array("status" => 'update_success', 'message' => 'Product Updated');  
      }
  }

  echo json_encode($arr);

}

elseif (isset($_POST['product_publish_as_data']) && isset($_POST['product_publish_as_id'])) {
  $product_id= get_safe_value($_POST['product_publish_as_id']);
  $product_publish_as_data= get_safe_value($_POST['product_publish_as_data']);
  $ProductImageById = ProductImageById($product_id);
  array_unshift($ProductImageById,"");
  unset($ProductImageById[0]);

  if ($product_publish_as_data == 1) {
    if (empty($ProductImageById)) {
      // No images Upload so you cannot upload it as Public 
      $arr = array("status" => 'error', "message"=>"Upload Images First");
    }else{
      SqlQuery("UPDATE product_details set product_status='$product_publish_as_data' WHERE id = '$product_id'");    
      $arr = array("status" => 'success', "message"=>"Published as Public");
    }
  }else if ($product_publish_as_data == 2) {
    SqlQuery("UPDATE product_details set product_status='$product_publish_as_data' WHERE id = '$product_id'");    
    $arr = array("status" => 'warning', "message"=>"Published as Draft");
    
  }else if ($product_publish_as_data == 0) {
    SqlQuery("UPDATE product_details set product_status='$product_publish_as_data' WHERE id = '$product_id'");    
    $arr = array("status" => 'warning', "message"=>"Published as Private");
  }

  echo json_encode($arr);
}

elseif (isset($_POST['ProductListingAjax'])) {
        $ProductDetails = ProductDetails('left join brands on product_details.product_brand = brands.bid');
       
        foreach($ProductDetails as $key => $val) {
            $ProductImageById = ProductImageById($val['id'], 'limit 1');
            array_unshift($ProductImageById,"");
            unset($ProductImageById[0]);
            if ($val['total_stock'] -  $val['total_sold'] < 100) {
                $color = 'red';
            }else{
                $color = 'green';
            }

            if ($val['product_status'] == 0) {
                $text = 'Blocked';
                $bgColor = 'bg-danger';
            }else if ($val['product_status'] == 2) {
                $text = 'Draft';
                $bgColor = 'bg-warning';
            }else{
                $text = 'Active';
                $bgColor = 'bg-success';
            }
        ?>
        <tr class="odd">
            <td><input type="checkbox" name="checked_product_delete[]" onclick="get_total_selected()" id="<?= $val['id']?>"
                    value="<?= $val['id'] ?>"></td>
            <td style=""><img class="img-reponsive img-fluid" width="60px" height="80px" style="border-radius:50%"
                    src="<?= FRONT_SITE_IMAGE_PRODUCT.$ProductImageById['1']['product_img'] ?>" alt=""></td>
            <td style=""><a
                    href="<?= ADMIN_FRONT_SITE.'products?operation=addProduct&id='.$val['id'].'' ?>"><?= $val['product_name'] ?></a>
            </td>
            <td>
                <h6 class="text-muted">
                    <strike>₹<?= $val['product_oldPrice'] ?></strike>
                </h6>
                <h5>₹ <?= $val['product_price'] ?></h5>
            </td>
            <td><?= $val['brand_name'] ?></td>
            <td style="color: <?= $color ?>">
                <?= $val['total_stock'] - $val['total_sold'] ?></td>
            <td><?= $val['product_size'] ?></td>
            <td><?= $val['product_categories'] ?></td>
            <td><span class="btn <?= $bgColor ?>"><?= $text ?></span>
            </td>
            <td><?= date("d M,Y", strtotime($val['product_added_on'])) ?>
            </td>
        </tr>

    <?php
        }
        ?>
          
        <?php
}

else if(isset($_POST['checked_product_delete'][0])){
	foreach($_POST['checked_product_delete'] as $list){
    $id=get_safe_value($list);
		SqlQuery("delete from product_details where id='$id'");
    
	}
  $ProductDetailsCount = Count(ProductDetails());
  echo "Showing ".$ProductDetailsCount." entries";
}
