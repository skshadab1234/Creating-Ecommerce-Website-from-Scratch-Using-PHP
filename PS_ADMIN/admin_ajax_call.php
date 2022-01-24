<?php
require 'includes/session.php';
include ('../smtp/PHPMailerAutoload.php');

$page_url =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

if (isset($_POST['admin_email']) && isset($_POST['admin_password']))
{
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
                if ($row['admin_verified'] == 0)
                {
                    $arr = array(
                        'status' => 'error',
                        'msg' => 'Please Verify Your Account.',
                        'field' => 'error'
                    );
                }
                else
                {
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

elseif (isset($_POST['SelectedDate']))
{
    $SelectedDate = get_safe_value($_POST['SelectedDate']);
    $convert_selectedDate = date("Y-m-d", strtotime($SelectedDate));

    // Working for Orders Section
    // Required Function Data
    $todayOrderTotal = COUNT(OrderSql("WHERE added_on = '$convert_selectedDate' && payment_status='succeeded'"));

    // Getting Total Product Sale Yesterday and Getting how much product sale today compare to yesterday
    $yesterDate = date('Y-m-d', strtotime("-1 days", strtotime($convert_selectedDate)));

    $YesterdayTotalOrder = COUNT(OrderSql("WHERE added_on = '$yesterDate' && payment_status='succeeded'"));

    if ($todayOrderTotal > $YesterdayTotalOrder)
    {
        $SaleMoreOrdersTotal = $todayOrderTotal - $YesterdayTotalOrder;
        $SaleMoreOrdersTotal_Color = 'text-success';
        $SaleMoreOrdersTotal_Arrow = 'ion-arrow-up-c';
    }
    else
    {
        $SaleMoreOrdersTotal = $todayOrderTotal - $YesterdayTotalOrder;
        $SaleMoreOrdersTotal_Color = 'text-danger';
        $SaleMoreOrdersTotal_Arrow = 'ion-arrow-down-c';
    }

    if ($convert_selectedDate == date('Y-m-d'))
    {
        $output_date = 'Today';
    }
    else
    {
        $output_date = date("d M, Y", strtotime($SelectedDate));
    }
    $orders_html = '<h3>' . numtostring($todayOrderTotal) . '<span style="font-size: 14px; font-weight:100" class="' . $SaleMoreOrdersTotal_Color . '"> ' . numtostring($SaleMoreOrdersTotal) . '<i class="' . $SaleMoreOrdersTotal_Arrow . '"></i></span> </h3>
        <p>' . $output_date . ' Orders</p>';

    // End of Order Section
    // Start of Product Section
    $TodayProducts = COUNT(ProductDetails("WHERE product_added_on='$convert_selectedDate'"));
    $TotalProducts = COUNT(ProductDetails("WHERE product_status='1'"));

    $product_html = '<h3>' . numtostring($TodayProducts) . '</h3>
                        <p>Total Products <span class="text-success">' . numtostring($TotalProducts) . '</span></p>';

    // End of Product Section
    // Start of Customer Details Section
    $UsersTotalTodayAdded = COUNT(UsersDetails("WHERE userAdded_On='$convert_selectedDate'"));
    $VerifiedUsersTotal = COUNT(UsersDetails("WHERE verify='1'"));
    $users_html = '<h3>' . numtostring($UsersTotalTodayAdded) . '</h3>
                       <p>Total Users <span class="text-success">' . numtostring($VerifiedUsersTotal) . '</span></p>';

    // End of Customer Section
    // Start of Revenue Section
    $TodayRevenue = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(amount_captured) as today_earned FROM payment_details WHERE added_on = '$convert_selectedDate'"));
    $YesterDayRevenue = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(amount_captured) as yester_earned FROM payment_details WHERE added_on = '$yesterDate'"));
    $Total_Revenue = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(amount_captured) as total_earned FROM payment_details"));

    if ($TodayRevenue['today_earned'] > $YesterDayRevenue['yester_earned'])
    {
        $YesterDayRevenueTotal = $TodayRevenue['today_earned'] - $YesterDayRevenue['yester_earned'];
        $YesterDayRevenueTotal_Color = 'text-success';
        $YesterDayRevenueTotal_Arrow = 'ion-arrow-up-c';
    }
    else
    {
        $YesterDayRevenueTotal = $TodayRevenue['today_earned'] - $YesterDayRevenue['yester_earned'];
        $YesterDayRevenueTotal_Color = 'text-danger';
        $YesterDayRevenueTotal_Arrow = 'ion-arrow-down-c';
    }

    $revenue_html = '<h3>' . numtostring((int)$TodayRevenue['today_earned']) . '
                            <span style="font-size: 14px; font-weight:100" class="' . $YesterDayRevenueTotal_Color . '"> 
                                ' . numtostring($YesterDayRevenueTotal) . '
                                <i class="' . $YesterDayRevenueTotal_Arrow . '"></i>
                            </span> 
                    </h3>
                        <p>Revenue <span class="text-success">' . numtostring((int)$Total_Revenue['total_earned']) . '</span></p>';

    $today_orders_total = '{
        "data": [';
    $payment_details_res = SqlQuery("Select * from payment_details WHERE added_on='$SelectedDate'");
    $x = 0;
    $length = mysqli_num_rows($payment_details_res);

    foreach ($payment_details_res as $key => $value) {
        $x++;

        if($x == $length){
            $addcomma = ''; 
        }else{
            $addcomma = ',';
        }

        if($value['payment_status'] == 'succeeded') {
            // Done 
            $text = 'Success';
            $color = 'green';
        }else{
            // Error 
            $text = 'Error';
            $color = 'red';
        }

        if ($value['payment_mode'] == 'wallet') {
            $payment_mode = 'Wallet';
        }elseif ($value['payment_mode'] == 'stripe') {
            $payment_mode = 'Stripe';
        }else{
            $payment_mode = "";
        }
    
        $today_orders_total .= '[
            '.json_encode("<a href=".ADMIN_FRONT_SITE.'orders?orderDetails='.$value['Order_Id'].">".$value['Order_Id']."</a>").',
            "₹ '.$value['amount_captured'].'",
            "By '.$payment_mode.'",
            '.json_encode("<span class='label label-pill bright' style='background-color:".$color." ; padding: 5px 10px'>".$text."</span>").',
            '.json_encode('<a style="color:#ddd" href='.FRONT_SITE_PATH.'Invoices?orderId='.$value['Order_Id'].'&redirect='.ADMIN_FRONT_SITE.'>Generate</a> / <a href='.FRONT_SITE_PATH.'download?filename='.$value['invoice_file'].'&filepath=UserInvoice/'.$value['invoice_file'].'&redirect='.ADMIN_FRONT_SITE.'" style="color:#ddd">Download</a> / <a href='.ADMIN_FRONT_SITE.'orders?orderDetails='.$value['Order_Id'].'&PrintData=print" style="color:#ddd">Print</a>').'
            ]'.$addcomma.'';

        }
    $today_orders_total .= ']
                            }';

   $f = fopen("json/data.json",'w');
   fwrite($f,'');
   fwrite($f,$today_orders_total);
   fclose($f);

    $arr = array(
        'order_html' => $orders_html,
        'product_html' => $product_html,
        'users_html' => $users_html,
        'revenue_html' => $revenue_html,
        'datatable_order_date' => $output_date
    );


    echo json_encode($arr);

}

// Forgot Password System Adding
elseif (isset($_POST['reset_email']) && $_POST['reset_email'] != '')
{
    $reset_email = get_safe_value($_POST['reset_email']);
    $AdminDetails = AdminDetails("WHERE admin_email = '$reset_email'");
    if (!empty($AdminDetails))
    {
        $adminLoginCode = $AdminDetails[0]['adminLoginCode'];
        $link = ADMIN_FRONT_SITE . 'update_password?adminLoginCode=' . $adminLoginCode . '&admin_email=' . $reset_email;
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
                                <p style="font-weight: 700; font-size: 20px; margin-top: 0; --text-opacity: 1; color: #ff5850; color: rgba(255, 88, 80, var(--text-opacity));">' . $AdminDetails[0]['admin_full_name'] . '</p>
                                <p style="margin: 0 0 24px;">
                                  A request to reset password was received from your
                                  <span style="font-weight: 600;">' . SITE_NAME . '</span> Account -
                                  <a href="mailto:' . $AdminDetails[0]['admin_email'] . '" class="hover-underline" style="--text-opacity: 1; color: #7367f0; color: rgba(115, 103, 240, var(--text-opacity)); text-decoration: none;">' . $AdminDetails[0]['admin_email'] . '</a>
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
elseif (isset($_POST['admin_id_update_pass']) && $_POST['admin_id_update_pass'] > 0 && isset($_POST['new_password']) && $_POST['new_password'] != '' && isset($_POST['confirm_password']) && $_POST['confirm_password'] != '')
{
    $admin_id = get_safe_value($_POST['admin_id_update_pass']);
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
        mysqli_query($con, "UPDATE admins set admin_password= '$new_password' WHERE id = '$admin_id'");
        $arr = array(
            "status" => 'success',
            'message' => 'Password Updated'
        );
    }
    echo json_encode($arr);
}

elseif (isset($_POST['product_name']) && isset($_POST['total_stock']) && isset($_POST['product_size']) && isset($_POST['short_description']) && isset($_POST['long_description']) && isset($_POST['product_price']))
{
    $product_name = get_safe_value($_POST['product_name']);
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
    $selling_by = get_safe_value($_POST['selling_by']);
    $sku_id = get_safe_value($_POST['sku_id']);
    $brand_data = get_safe_value($_POST['brand_data']);
    

    if(isset($_POST['brand_name'])) {
        $brand_name = get_safe_value($_POST['brand_name']);
    }

    $date = date('Y-m-d');
    $prodid = get_safe_value($_POST['prodid']);

    $category = get_safe_value($_POST['category']);
    $sub_category_data = get_safe_value($_POST['sub_category_data']);
    
    if (isset($_POST['sub_category_value'])) {
        $product_subCat_Values = get_safe_value($_POST['sub_category_value']);
    }else{
        $product_subCat_Values = '';
    }

  
    $listprd_skuId = ProductDetails("WHERE sku_id='$sku_id'");
    $count_products_sku = count($listprd_skuId);
    
    if($brand_data == '') {
        $brand_exist = ExecutedQuery("SELECT * FROM brands WHERE brand_name ='$brand_name'");
        if ($brand_exist != 0) {
            $brand_exist = $brand_exist[0];
            if(mysqli_query($con,"UPDATE brands SET brand_name = '$brand_name' WHERE bid = '".$brand_exist['bid']."'")){
                $brand_last_id = mysqli_insert_id($con);
                $brand_data = $brand_last_id;
            }
        }else{
            $date = date("Y-m-d");
            if(mysqli_query($con,"INSERT INTO brands (brand_name,brand_status,brand_added_on,sellerId_BrandOwner) VALUES('$brand_name', 1,'$date','".$_SESSION['SELLER_ID']."')")){
                $brand_last_id = mysqli_insert_id($con);
                $brand_data = $brand_last_id;
            }
        }
        
    }
    
    if (count(ProductDetails("WHERE product_name = '$product_name' && selling_by='$selling_by'")) > 0)
    {
        $ProductDetails = ProductDetails("WHERE product_name = '$product_name'")[0];
        $qc_status_forUpdate = $ProductDetails['qc_status'].',0';
        if ($product_opt == 'update')
        {
            $total_stock = $ProductDetails['total_stock'] + $total_stock;
            $_SESSION['product_name'] = $product_name;
            SqlQuery("UPDATE product_details set sku_id = '$sku_id',
                                            product_name = '$product_name', 
                                            product_brand = '$brand_data',
                                            total_stock = '$total_stock',
                                            product_size = '$product_size',
                                            product_weight = '$product_weight',
                                            product_desc_short = '$short_description',
                                            product_desc_long = '$long_description',
                                            product_categories = '$category',
                                            product_subCategories = '$sub_category_data',
                                            product_subCat_Values = '$product_subCat_Values',
                                            product_price = '$product_price',
                                            product_oldPrice = '$product_oldPrice',
                                            product_waist = '$product_waist',
                                            product_hips = '$product_hips',
                                            product_tags = '$product_tags',
                                            selling_by= '$selling_by',
                                            qc_status = '$qc_status_forUpdate' WHERE id = '$prodid'");

            if (isset($_POST['data_sheet_name']) && isset($_POST['data_sheet_desc']))
            {
                foreach ($_POST['data_sheet_name'] as $key => $val)
                {
                    $data_sheet_name = $val;
                    $data_sheet_desc = $_POST['data_sheet_desc'][$key];
                    $result = SqlQuery("Select * from product_data_sheet where data_sheet_name = '$val' && product_id = '$prodid'");
                    if (mysqli_num_rows($result) > 0)
                    {
                        $arr = array(
                            "status" => 'update_success',
                            'message' => 'Product Updated',
                            'product_name' => $product_name
                        );
                    }
                    else
                    {
                        SqlQuery("Insert into product_data_sheet(data_sheet_name, data_sheet_desc, product_id, status) VALUES('$data_sheet_name', '$data_sheet_desc', '$prodid', '1')");
                        $arr = array(
                            "status" => 'update_success',
                            'message' => 'Product Updated',
                            'product_name' => $product_name
                        );
                    }
                }
            }
            else
            {
                $arr = array(
                    "status" => 'update_success',
                    'message' => 'Product Updated',
                    'product_name' => $product_name
                );
            }
        }
        else
        {
            $arr = array(
                "status" => 'error',
                'message' => 'Product Already Exists!'
            );
        }

    }
    else
    {
        if($count_products_sku > 0) {
            $arr = array(
                "status" => 'error',
                'message' => 'SKU ID Already Exists',
                'product_name' => $product_name
            );
        }else{
            if ($product_opt == 'add')
            {
               
                $inserted = "INSERT into product_details(
                                        sku_id,
                                        product_name,
                                        product_brand,
                                        total_stock, 
                                        product_size,
                                        product_weight,
                                        product_desc_short,
                                        product_desc_long,
                                        product_price,
                                        product_categories,
                                        product_subCategories,
                                        product_subCat_Values,
                                        product_oldPrice,
                                        product_waist,
                                        product_hips, 
                                        product_tags,
                                        product_status,
                                        product_added_on,
                                        selling_by)
                                        
                                        VALUES('$sku_id', 
                                            '$product_name',
                                            '$brand_data', 
                                            '$total_stock', 
                                            '$product_size', 
                                            '$product_weight', 
                                            '$short_description', 
                                            '$long_description', 
                                            '$product_price', 
                                            '$category',
                                            '$sub_category_data',
                                            '$product_subCat_Values',
                                            '$product_oldPrice', 
                                            '$product_waist', 
                                            '$product_hips', 
                                            '$product_tags',
                                            '2',
                                            '$date',
                                            '$selling_by')";

                if (mysqli_query($con , $inserted))
                {
                    $last_id = mysqli_insert_id($con);
                    $ProductDetailss = ProductDetails("WHERE id = '$last_id'");
                    $product_name = $ProductDetailss[0]['product_name'];
                    $_SESSION['product_name'] = $product_name;

                    if (isset($_POST['data_sheet_name'])  && isset($_POST['data_sheet_desc'])) 
                    {
                        foreach ($_POST['data_sheet_name'] as $key => $val)
                        {
                            $data_sheet_name = $val;
                            $data_sheet_name = $val;
                            $data_sheet_desc = $_POST['data_sheet_desc'][$key];

                            if (isset($_POST['data_sheet_name']) && isset($_POST['data_sheet_desc']))
                            {
                                foreach ($_POST['data_sheet_name'] as $key => $val)
                                {
                                    $data_sheet_name = $val;
                                    $data_sheet_desc = $_POST['data_sheet_desc'][$key];
                                    $result = SqlQuery("Select * from product_data_sheet where data_sheet_name = '$val' && product_id = '$last_id'");
                                    if (mysqli_num_rows($result) > 0)
                                    {
                                        $arr = array(
                                            "status" => 'update_success',
                                            'message' => 'Product Saved as Draft',
                                            'product_name' => $product_name
                                        );
                                    }
                                    else
                                    {
                                        SqlQuery("Insert into product_data_sheet(data_sheet_name, data_sheet_desc, product_id, status) VALUES('$data_sheet_name', '$data_sheet_desc', '$last_id', '1')");
                                        $arr = array(
                                            "status" => 'update_success',
                                            'message' => 'Product Saved as Draft',
                                            'product_name' => $product_name
                                        );
                                    }
                                }
                            }
                            else
                            {
                                $arr = array(
                                    "status" => 'update_success',
                                    'message' => 'Product Saved as Draft',
                                    'product_name' => $product_name
                                );
                            }
                        }
                    }
                }

                $arr = array(
                        "status" => 'update_success',
                        'message' => 'Product Saved as Draft',
                        'product_name' => $product_name
                    );
            }
            else if ($product_opt == 'update')
            {
                $_SESSION['product_name'] = $product_name;
                $ProductDetails = ProductDetails("WHERE product_name = '$product_name'")[0];
                // if ($total_stock == $ProductDetails['total_stock']) {
                    // $total_stock = $ProductDetails['total_stock'];
                // }else{
                // }

                $total_stock = $ProductDetails['total_stock'] + $total_stock;

                SqlQuery("UPDATE product_details set 
                                                    sku_id = '$sku_id',
                                                    product_name = '$product_name', 
                                                    product_brand = '$brand_data',
                                                    total_stock = '$total_stock',
                                                    product_size = '$product_size',
                                                    product_weight = '$product_weight',
                                                    product_desc_short = '$short_description',
                                                    product_desc_long = '$long_description',
                                                    product_categories = '$category',
                                                    product_subCategories = '$sub_category_data',
                                                    product_subCat_Values = '$product_subCat_Values',
                                                    product_price = '$product_price',
                                                    product_oldPrice = '$product_oldPrice',
                                                    product_waist = '$product_waist',
                                                    product_hips = '$product_hips',
                                                    product_tags = '$product_tags',
                                                    selling_by = '$selling_by',
                                                    qc_status = '$qc_status_forUpdate' WHERE id = '$prodid'");

                if (isset($_POST['data_sheet_name']) && isset($_POST['data_sheet_desc']))
                {
                    foreach ($_POST['data_sheet_name'] as $key => $val)
                    {
                        $data_sheet_name = $val;
                        $data_sheet_desc = $_POST['data_sheet_desc'][$key];
                        $result = SqlQuery("Select * from product_data_sheet where data_sheet_name = '$val' && product_id = '$prodid'");
                        if (mysqli_num_rows($result) > 0)
                        {
                            $arr = array(
                                "status" => 'update_success',
                                'message' => 'Product Updated',
                                'product_name' => $product_name
                            );
                        }
                        else
                        {
                            SqlQuery("Insert into product_data_sheet(data_sheet_name, data_sheet_desc, product_id, status) VALUES('$data_sheet_name', '$data_sheet_desc', '$prodid', '1')");
                            $arr = array(
                                "status" => 'update_success',
                                'message' => 'Product Updated',
                                'product_name' => $product_name
                            );
                        }
                    }
                }
                else
                {
                    $arr = array(
                        "status" => 'update_success',
                        'message' => 'Product Updated',
                        'product_name' => $product_name
                    );
                }
            }
        }
        
    }
   

    echo json_encode($arr);

}

elseif (isset($_POST['product_publish_as_data']) && isset($_POST['product_publish_as_id']))
{
    $product_id = get_safe_value($_POST['product_publish_as_id']);
    $product_publish_as_data = get_safe_value($_POST['product_publish_as_data']);
    $ProductImageById = ProductImageById($product_id);
    array_unshift($ProductImageById, "");
    unset($ProductImageById[0]);

    if ($product_publish_as_data == 1)
    {
        if (empty($ProductImageById))
        {
            // No images Upload so you cannot upload it as Public
            $arr = array(
                "status" => 'error',
                "message" => "Upload Images First"
            );
        }
        else
        {
            SqlQuery("UPDATE product_details set product_status='$product_publish_as_data' WHERE id = '$product_id'");
            $arr = array(
                "status" => 'success',
                "message" => "Published as Public"
            );
        }
    }
    else if ($product_publish_as_data == 2)
    {
        SqlQuery("UPDATE product_details set product_status='$product_publish_as_data' WHERE id = '$product_id'");
        $arr = array(
            "status" => 'warning',
            "message" => "Published as Draft"
        );

    }
    else if ($product_publish_as_data == 0)
    {
        SqlQuery("UPDATE product_details set product_status='$product_publish_as_data' WHERE id = '$product_id'");
        $arr = array(
            "status" => 'warning',
            "message" => "Published as Private"
        );
    }

    echo json_encode($arr);
}

elseif (isset($_POST['ProductListingAjax']))
{
    $ProductDetails = ProductDetails('left join shop_category on product_details.product_categories =  shop_category.cat_id left join brands on product_details.product_brand = brands.bid');
    $x = 0;
    $length = count($ProductDetails);
    $product_listing_td = '{
        "data": [';

    foreach ($ProductDetails as $key => $val)
    {
        $x++;

        if($x == $length){
            $addcomma = ''; 
        }else{
            $addcomma = ',';
        }

        $ProductImageById = ProductImageById($val['id'], 'limit 1');
        array_unshift($ProductImageById, "");
        unset($ProductImageById[0]);
        if ($val['total_stock'] - $val['total_sold'] < 100)
        {
            $color = 'red';
        }
        else
        {
            $color = 'green';
        }

        if ($val['product_status'] == 0)
        {
            $text = 'Blocked';
            $bgColor = 'bg-danger';
        }
        else if ($val['product_status'] == 2)
        {
            $text = 'Draft';
            $bgColor = 'bg-warning';
        }
        else
        {
            $text = 'Active';
            $bgColor = 'bg-success';
        }

        if ($val['product_subCat_Values'] != '') {
            $product_subCat_Values = ' - '.urldecode($val['product_subCat_Values']);
        }else{
            $product_subCat_Values = '';
        }

        if ($val['total_stock'] -  $val['total_sold'] < 100) {
            $color = 'red';
            $total_stock_msg = "".($val['total_stock'] -  $val['total_sold']);
        }else{
            $color = 'green';
            $total_stock_msg = "".($val['total_stock'] -  $val['total_sold']);
        }

        $qc_status_explode = explode(",",$val['qc_status']);
        unset($qc_status_explode[0]);
        $end_qc_status = end($qc_status_explode);

        if ($end_qc_status == 0) {
            $qc_text = '<span class="text-warning">In Process</span>';
        }elseif($end_qc_status == 1) {
            $qc_text = '<span class="text-success">Approved</span>';
        }else{
            $qc_text = '<spanOrderTrackId class="text-danger">Rejected</span>';
        }
        $product_listing_td .= '[
                                '.json_encode("<input type=\"checkbox\" name=\"checked_product_update[]\" onclick=\"get_total_selected()\" id='".$val['id']."' value='".$val['id']."'>").',
                                '.json_encode("<img class=\"img-reponsive img-fluid\"  style=\"border-radius:20%;width:60px;height:80px\" src='".FRONT_SITE_IMAGE_PRODUCT . $ProductImageById['1']['product_img']."' alt=\"\">").',
                                '.json_encode("<a href='".ADMIN_FRONT_SITE.'products?operation=addProduct&id='.$val['id']."'>".$val['product_name']."</a><br>SKU Id: ".$val['sku_id']."").',
                                '.json_encode("".$val['product_price']."").',
                                '.json_encode("".$val['product_oldPrice']."").',
                                '.json_encode("".$val['brand_name']."").',
                                '.json_encode("<p style=\"color: ".$color."\">".$total_stock_msg."</p>").',
                                '.json_encode("".$val['product_size']."").',
                                '.json_encode("".$val['category_name'].' - '.urldecode($val['product_subCategories']).''.$product_subCat_Values ."").',
                                '.json_encode("<span class=\"btn ".$bgColor."\">".$text."</span>").',
                                '.json_encode("".$qc_text."").',
                                '.json_encode("<span title=".date("d-M-Y", strtotime($val['product_added_on'])).">".date("m/d/Y", strtotime($val['product_added_on']))."</span>").'
                            ]'.$addcomma.'';

    }

    $product_listing_td .= ']
                            }';

    $f = fopen("json/product.json",'w');
    fwrite($f,'');
    fwrite($f,$product_listing_td);
    fclose($f);     
}

else if (isset($_POST['checked_product_update'][0]))
{
    $product_status = get_safe_value($_POST['product_status']);
    $added_stock_now = get_safe_value($_POST['UpdateStockBulk']);
    
    foreach ($_POST['checked_product_update'] as $list)
    {
        $id = get_safe_value($list);
        $ProductDetails = ProductDetails("WHERE id = '$id'");
        $ProductDetails = $ProductDetails[0];

        $qc_status = get_safe_value($_POST['qc_status']);
        $qc_note = get_safe_value($_POST['qc_note']);
        $qc_status__db = $ProductDetails['qc_status'].','.$qc_status;
        $qc_notes__db = $ProductDetails['qc_message'].',PS_FASHION_STORE,'.$qc_note;
        
        $total_stock = $ProductDetails['total_stock'] + $added_stock_now;
        SqlQuery("UPDATE product_details SET product_status='$product_status', total_stock = '$total_stock',qc_status='$qc_status__db', qc_message= '$qc_notes__db'  where id='$id'");
    }
}

// Deleting Datasheet From Database by Id
elseif (isset($_POST['removeDataSheetFromDB']) && $_POST['removeDataSheetFromDB'] != '' && isset($_POST['id']) && $_POST['id'] > 0)
{
    $id = get_safe_value($_POST['id']);
    SqlQuery("delete from product_data_sheet where id='$id'");
}

else if (isset($_POST['checked_category_delete'][0]))
{
    foreach ($_POST['checked_category_delete'] as $list)
    {
        $id = get_safe_value($list);
        SqlQuery("delete from shop_category where cat_id='$id'");
    }
    
}

elseif (isset($_POST['category_name']) && $_POST['category_name'] != '' && isset($_POST['sub_category']) && $_POST['sub_category'] != '' && isset($_POST['category_type']) && $_POST['category_type'] != '' && isset($_POST['category_id'])) {
    $category_type = get_safe_value($_POST['category_type']);
    $category_name = get_safe_value($_POST['category_name']);
    $sub_category = get_safe_value($_POST['sub_category']);
    $category_status = get_safe_value($_POST['category_status']);

    if ($category_type == 'update') {
        $category_id = get_safe_value($_POST['category_id']);
        SqlQuery("update shop_category set category_name='$category_name', sub_category='$sub_category', status='$category_status' WHERE cat_id = '$category_id'");
        echo 'Updated';
    }

    elseif ($category_type == 'add') {
        SqlQuery("INSERT into shop_category (category_name, sub_category, status) VALUES('$category_name', '$sub_category', '$category_status')");
        echo 'insert';
    }
}


elseif (isset($_POST['change_category_load_sub_category']) && $_POST['change_category_load_sub_category'] != '' && isset($_POST['id']) && $_POST['id'] > 0 && isset($_POST['sub_cat_recive_from_Db'])){
    $id = get_safe_value($_POST['id']);
    $sub_cat_recive_from_Db = urlencode(get_safe_value($_POST['sub_cat_recive_from_Db']));

    $res = SqlQuery("Select * from shop_category WHERE cat_id ='$id'");
    $row =mysqli_fetch_assoc($res);
    $sub_category = explode(",", $row['sub_category']);
    $html = '';
    foreach($sub_category as $key => $list) {
        if ($sub_cat_recive_from_Db == '') {
            $selected = '';
        }else{
            if (urlencode($list) == $sub_cat_recive_from_Db) {
                $selected = 'selected';
            }else{
                $selected = '';
            }
        }
        $html.='<option value="'.urlencode($list).'" '.$selected.'>'.$list.'</option>';
    }

    echo $html;
}

elseif (isset($_POST['category_name']) && $_POST['category_name'] != '' && isset($_POST['sub_category_data']) && $_POST['sub_category_data'] != ''  && isset($_POST['subcat_value']) && $_POST['subcat_value'] != '' && isset($_POST['subcategory_type']) && $_POST['subcategory_type'] != '' && isset($_POST['subcategory_id'])) {
    $category_type = get_safe_value($_POST['subcategory_type']);
    
    $category_name = get_safe_value($_POST['category_name']);
    $sub_category = get_safe_value($_POST['sub_category_data']);
    $subcat_value = get_safe_value($_POST['subcat_value']);
    $category_status = get_safe_value($_POST['category_status']);
    

    if ($category_type == 'update') {
        $subcategory_id = get_safe_value($_POST['subcategory_id']);
        SqlQuery("update sub_category set category_id='$category_name', category_subcat_id='$sub_category', subcat_value= '$subcat_value', subcat_status='$category_status' WHERE subcat_id = '$subcategory_id'");
        echo 'Updated';
    }

    elseif ($category_type == 'add') {
        SqlQuery("INSERT into sub_category (category_id, category_subcat_id,subcat_value, subcat_status) VALUES('$category_name', '$sub_category', '$subcat_value' ,'$category_status')");
        echo 'insert';
    }
}

elseif (isset($_POST['change_subcategory_load_sub_category']) && $_POST['change_subcategory_load_sub_category'] != '' && isset($_POST['id']) && $_POST['id'] != '' && isset($_POST['sub_catValue_recive_from_Db'])){
    $id = get_safe_value($_POST['id']);
    $sub_catValue_recive_from_Db = get_safe_value($_POST['sub_catValue_recive_from_Db']);

    $res = SqlQuery("Select * from sub_category WHERE category_subcat_id ='$id'");
    $row =mysqli_fetch_assoc($res);
    $subcat_value = explode(",", $row['subcat_value']);
    $html = '';
    if ($subcat_value[0] != '') {
        foreach($subcat_value as $key => $list) {
            if ($sub_catValue_recive_from_Db == '') {
                $selected = '';
            }else{
                if ($list == $sub_catValue_recive_from_Db) {
                    $selected = 'selected';
                }else{
                    $selected = '';
                }
            }
            $html.='<option value="'.$list.'" '.$selected.'>'.$list.'</option>';
        }
    }else{
        $html .= '';
    }

    echo $html;
}

else if (isset($_POST['checked_subcategory_delete'][0]))
{
    foreach ($_POST['checked_subcategory_delete'] as $list)
    {
        $id = get_safe_value($list);
        SqlQuery("delete from sub_category where subcat_id='$id'");
    }
    
}

else if (isset($_POST['checked_brand_delete'][0]))
{
    foreach ($_POST['checked_brand_delete'] as $list)
    {
        $id = get_safe_value($list);
        $brand_status = get_safe_value($_POST['product_BRAND_status']);
        SqlQuery("UPDATE brands set brand_status = '$brand_status' where bid = '$id'");
    }
    
}

elseif (isset($_POST['brand_type']) && $_POST['brand_type'] != '' && isset($_POST['brand_name']) && $_POST['brand_name'] != '' && isset($_POST['brand_status']) && $_POST['brand_status'] != '' && isset($_POST['brand_id'])) {
    $brand_type = get_safe_value($_POST['brand_type']);
    
    $brand_name = get_safe_value($_POST['brand_name']);
    $brand_status = get_safe_value($_POST['brand_status']);
    $seller_account = get_safe_value($_POST['seller_account']);

    if ($brand_type == 'update') {
        $brand_id = get_safe_value($_POST['brand_id']);
        $_SESSION['BRAND_ID_SESSION']  = $brand_id;
        SqlQuery("update brands set brand_name='$brand_name', brand_status='$brand_status',sellerId_BrandOwner = '$seller_account' WHERE bid = '$brand_id'");
        echo 'Updated';
    }

    elseif ($brand_type == 'add') {
        $brand_added_on = date("Y-m-d");
        $res = SqlQuery("Select * from brands WHERE brand_name='$brand_name'");
        if (mysqli_num_rows($res) > 0) {
            echo 'exist';
        }else{
            $sql = "INSERT into brands (brand_name, brand_status,sellerId_BrandOwner,brand_added_on) VALUES('$brand_name', '$brand_status', '$seller_account','$brand_added_on')";
            if (mysqli_query($con, $sql)) {
                $last_id = mysqli_insert_id($con);
                $_SESSION['BRAND_ID_SESSION']  = $last_id;
            } 
            echo 'insert';
        }
        
    }
}


elseif (isset($_POST['social_title'])  && $_POST['social_title'] != '' 
        && isset($_POST['firstname'])  && $_POST['firstname'] != ''
        && isset($_POST['lastname'])  && $_POST['lastname'] != ''
        && isset($_POST['email'])  && $_POST['email'] != ''
        && isset($_POST['user_status'])  && $_POST['user_status'] != ''
        && isset($_POST['newsletter'])  && $_POST['newsletter'] != '') 
{
    $social_title = get_safe_value($_POST['social_title']);
    $firstname = get_safe_value($_POST['firstname']);
    $lastname = get_safe_value($_POST['lastname']);
    $user_status = get_safe_value($_POST['user_status']);
    $email = get_safe_value($_POST['email']);
    $newsletter = get_safe_value($_POST['newsletter']);
    $user_type = get_safe_value($_POST['user_type']);
    $user_id = get_safe_value($_POST['user_id']);

    $res = SqlQuery("SELECT * FROM users WHERE id = '$user_id'");
    $row = mysqli_fetch_assoc($res);
    
   
    if ($user_type == 'update') {
        if ($email != $row['email']) {
            // EMAIL ID CHANGED
            $email_changed = 'Please Confirm Your Mail';
            if (mysqli_num_rows(SqlQuery("SELECT * FROM users WHERE email = '$email'")) > 0) {
                $arr = array("status"=>'error', 'message' => 'Email id exist');
            }else{
                SqlQuery("Update users set social_title='$social_title', firstname='$firstname', lastname='$lastname', verify='$user_status', email ='$email', newsletter='$newsletter' WHERE id = '$user_id'");
                $html = "<a href=".FRONT_SITE_PATH.'verify?email='.$email.'&userLoginCode='.$row['userLoginCode'].'&redirect='.FRONT_SITE_PATH.">Click here to Verify</a>";
                $emailresp = send_email($email, $html, 'Email id Changed Confirmation');
                if ($emailresp == 'Sended')
                {
                    $arr = array(
                        'status' => 'email_change_success',
                        'message' => 'User Successfully Updated',
                        'text' => 'Link Sended to ' . $email
                    );
                }
            }
        }else{
            SqlQuery("Update users set social_title='$social_title', firstname='$firstname', lastname='$lastname', verify='$user_status', email ='$email', newsletter='$newsletter' WHERE id = '$user_id'");
            $arr = array("status"=>'success', 'message' => 'User Successfully Updated', 'text' => '');
        }
    
    }else{
        if (mysqli_num_rows(SqlQuery("SELECT * FROM users WHERE email = '$email'")) > 0) {
            $arr = array("status"=>'error', 'message' => 'Email id exist');
        }else{
            $date = date('Y-m-d');
            $userloginCode = rand(11111,99999);
            $password = str_replace(' ', '', $firstname.$lastname.rand(111,999));
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $html = "<a href=".FRONT_SITE_PATH.'verify?email='.$email.'&userLoginCode='.$userloginCode.'&redirect='.FRONT_SITE_PATH.">Click here to Verify</a>
                    <p>Password : ".$password."</p>
            ";
            SqlQuery("INSERT into users(social_title,firstname,lastname,password,email,newsletter,verify,userLoginCode,userAdded_On)
                      VALUES('$social_title', '$firstname', '$lastname', '$password_hash', '$email', '$newsletter', '$user_status', '$userloginCode', '$date')");

            $emailresp = send_email($email, $html, 'Email id Changed Confirmation');
            if ($emailresp == 'Sended')
            {
                $arr = array(
                    'status' => 'success',
                    'message' => 'Account Created Successfully',
                    'text' => 'Confirmation Mail Sended Successfully to ' . $email
                );
            }
        }
    }
    

    echo json_encode($arr);
}


elseif (isset($_POST['user_type']) && isset($_POST['delivery_boy_name']) && isset($_POST['delvery_boy_pincode']) && isset($_POST['delivery_boy_city']) && isset($_POST['delivery_boy_state']) && isset($_POST['delivery_boy_email']) && isset($_POST['delivery_boy_email']) && isset($_POST['delivery_boy_email'])) {
    $user_type = get_safe_value($_POST['user_type']);
    $user_id = get_safe_value($_POST['user_id']);
    $delivery_boy_name = get_safe_value($_POST['delivery_boy_name']);
    $delivery_boy_email = get_safe_value($_POST['delivery_boy_email']);
    $delivery_boy_phone = get_safe_value($_POST['delivery_boy_phone']);
    $delivery_boy_address = get_safe_value($_POST['delivery_boy_address']);
    $delvery_boy_pincode = get_safe_value($_POST['delvery_boy_pincode']);
    $delivery_boy_city = get_safe_value($_POST['delivery_boy_city']);
    $delivery_boy_state = get_safe_value($_POST['delivery_boy_state']);
    $delivery_boy_landmark = get_safe_value($_POST['delivery_boy_landmark']);
    $user_status = get_safe_value($_POST['user_status']);

    $res = SqlQuery("SELECT * FROM delivery_boy WHERE delivery_boy_id = '$user_id'");
    $row = mysqli_fetch_assoc($res);
    
   
    if ($user_type == 'update') {
        if ($delivery_boy_email != $row['delivery_boy_email']) {
            // EMAIL ID CHANGED
            $email_changed = 'Please Confirm Your Mail';
            if (mysqli_num_rows(SqlQuery("SELECT * FROM delivery_boy WHERE delivery_boy_email = '$delivery_boy_email'")) > 0) {
                $arr = array("status"=>'error', 'message' => 'Email id exist');
            }else{
                SqlQuery("Update delivery_boy set delivery_boy_name='$delivery_boy_name', delivery_boy_email='$delivery_boy_email', delivery_boy_phone='$delivery_boy_phone', delivery_boy_address='$delivery_boy_address', delvery_boy_pincode ='$delvery_boy_pincode', delivery_boy_city='$delivery_boy_city', delivery_boy_state='$delivery_boy_state',delivery_boy_landmark='$delivery_boy_landmark',delivery_boy_verifed='$user_status' WHERE delivery_boy_id = '$user_id'");
                $html = "<a href=".FRONT_SITE_PATH.'verify?email='.$delivery_boy_email.'&DeliveryLoginCode='.$row['deliveryLoginCode'].'&redirect='.DELIVERY_FRONT_SITE.">Click here to Verify</a>";
                $emailresp = send_email($delivery_boy_email, $html, 'Email id Changed Confirmation');
                if ($emailresp == 'Sended')
                {
                    $arr = array(
                        'status' => 'email_change_success',
                        'message' => 'User Successfully Updated',
                        'text' => 'Link Sended to ' . $delivery_boy_email
                    );
                }
            }
        }else{
            SqlQuery("Update delivery_boy set delivery_boy_name='$delivery_boy_name', delivery_boy_email='$delivery_boy_email', delivery_boy_phone='$delivery_boy_phone', delivery_boy_address='$delivery_boy_address', delvery_boy_pincode ='$delvery_boy_pincode', delivery_boy_city='$delivery_boy_city', delivery_boy_state='$delivery_boy_state',delivery_boy_landmark='$delivery_boy_landmark',delivery_boy_verifed='$user_status' WHERE delivery_boy_id   = '$user_id'");
            $arr = array("status"=>'success', 'message' => 'User Successfully Updated', 'text' => '');
        }
    
    }else{
        if (mysqli_num_rows(SqlQuery("SELECT * FROM delivery_boy WHERE delivery_boy_email = '$delivery_boy_email'")) > 0) {
            $arr = array("status"=>'error', 'message' => 'Email id exist');
        }else{
            $date = date('Y-m-d H:i:s');
            $userloginCode = rand(11111,99999);
            $password = rand(111111,999999);
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $html = "<a href=".FRONT_SITE_PATH.'verify?email='.$delivery_boy_email.'&userLoginCode='.$userloginCode.'&redirect='.FRONT_SITE_PATH.">Click here to Verify</a>
                    <p>Password : ".$password."</p>
            ";
            SqlQuery("INSERT into delivery_boy(delivery_boy_name,delivery_boy_email,delivery_boy_phone,delivery_boy_address,delvery_boy_pincode,delivery_boy_city,delivery_boy_landmark,delivery_boy_state,delivery_boy_added_on,delivery_boy_status,deliveryLoginCode, delivery_boy_password)
                      VALUES('$delivery_boy_name', '$delivery_boy_email', '$delivery_boy_phone', '$delivery_boy_address', '$delvery_boy_pincode', '$delivery_boy_city', '$delivery_boy_landmark', '$delivery_boy_state', '$date', '$user_status', '$userloginCode', '$password_hash')");

            $emailresp = send_email($delivery_boy_email, $html, 'Confirm Your Email');
            if ($emailresp == 'Sended')
            {
                $arr = array(
                    'status' => 'success',
                    'message' => 'Account Created Successfully',
                    'text' => 'Confirmation Mail Sended Successfully to ' . $delivery_boy_email
                );
            }
        }
    }
    

    echo json_encode($arr);

}


elseif (isset($_POST['OrderTrackId']) && $_POST['OrderTrackId'] != '') {
    $OrderTrackId = get_safe_value($_POST['OrderTrackId']);

    // Getting Order Delivery Pincode
    $row = mysqli_fetch_assoc(SqlQuery("SELECT * FROM ordertrackingdetails WHERE id = '$OrderTrackId'"));
    $delivery_pincode = $row['delivery_to_pincode'];

    // Getting Delivery Boy Pincode
    $delivery_res = SqlQuery("SELECT * FROM delivery_boy WHERE delvery_boy_pincode = '$delivery_pincode'");

    if (mysqli_num_rows($delivery_res) > 0) {
        $list = '';

        foreach ($delivery_res as $key => $value) {
            $DelveredOrder = GetAssignedDeliveryForDeliveryBoy($value['delivery_boy_id'])['Delivered'];
            $PendingOrders = GetAssignedDeliveryForDeliveryBoy($value['delivery_boy_id'])['Pending'];

            $DelveredOrders = explode(",",$DelveredOrder);
            $totalDelivery = ($DelveredOrders[0] == 0) ? 0 : count($DelveredOrders);

            $explodePendingOrder = explode(",",$PendingOrders);
            $totalPending = ($explodePendingOrder[0] == 0) ? 0 : count($explodePendingOrder);

            $list .= "<option value=".$value['delivery_boy_id'].">".$value['delivery_boy_name']."-".$value['delivery_boy_email']."-".$totalDelivery." Delivered - ".$totalPending." Pending</option>";
        }
        $arr = array("status"=>'success', 'list' => $list);
    }else{
        
        $arr = array("status"=>'error', 'message' => 'No Delivery Boy in this city');
    }

    echo json_encode($arr);

}

elseif (isset($_POST['SubmitAssignedDelivery_id']) && $_POST['SubmitAssignedDelivery_id'] != '' && isset($_POST['orderTrackId']) && $_POST['orderTrackId'] != '') {
    $SubmitAssignedDelivery_id = get_safe_value($_POST['SubmitAssignedDelivery_id']);
    $orderTrackId = get_safe_value($_POST['orderTrackId']);

    SqlQuery("UPDATE ordertrackingdetails set delivery_boy_id = '$SubmitAssignedDelivery_id' WHERE id = '$orderTrackId'");

    $res= SqlQuery("SELECT * FROM delivery_boy WHERE delivery_boy_id = '$SubmitAssignedDelivery_id'");
    $row = mysqli_fetch_assoc($res);

    $html = ' 
            <table class="table table-bordered">
                <thead>
                    <th>Detail</th>
                </thead>
                <tbody>
                    <td>'.$row['delivery_boy_name'].'<br>'.$row['delivery_boy_email'].'<br> <a href="javascript:void(0)" onclick="RemoveAssignedDeliveryBoy('.$orderTrackId.')">Remove</a></td>
                </tbody>
            </table>';

    echo $html;
}

elseif (isset($_POST['RemoveAssignedDeliveryBoy']) && $_POST['RemoveAssignedDeliveryBoy'] != '') {
    $orderTrackid = get_safe_value($_POST['RemoveAssignedDeliveryBoy']);
    
    SqlQuery("UPDATE ordertrackingdetails set delivery_boy_id = '' WHERE id = '$orderTrackid'");

    $html = ' <button type="button" class="btn btn-default" onclick="getDeliveryBoyForAssigning('.$orderTrackid.')" data-toggle="modal" data-target="#getDeliveryBoyForAssigning_'.$orderTrackid.'">
                    Assign Delivery to
                </button>
                <div class="modal fade" id="getDeliveryBoyForAssigning_'.$orderTrackid.'"  aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content ">
                            <div class="modal-header card_box">
                                <h4 class="modal-title">Assigning this item to </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                                <div class="modal-body text-left card_box" id="hideDiv_NoDeliveryBoy_'.$orderTrackid.'"> 
                                    <div class="form-group col-md-12">
                                        <select name="delivery_id" id="listofdeliveryBoy_'.$orderTrackid.'"
                                            class="form-control select2 select2-hidden-accessible" style="width: 100%;"
                                            required>
                                            
                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer card_box justify-content-between">
                                    <button type="button" data-dismiss="modal" onclick="SubmitAssignedDelivery('.$orderTrackid.')" class="btn btn-primary">Save changes</button>
                                </div>
                        
                        </div>
                        <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    ';
                    ?>
                    <script>
                         //Initialize Select2 Elements
                     $('.select2').select2()

                    //Initialize Select2 Elements
                    $('.select2bs4').select2({
                        theme: 'bootstrap4'
                    })
                    </script>
                    <?php
    echo $html;                    
}

// Send for QC PASS 
elseif (isset($_POST['product_qc_status_pid']) && isset($_POST['qc_status']) && isset($_POST['qc_note'])) {
    $pid = get_safe_value($_POST['product_qc_status_pid']);
    $qc_status = get_safe_value($_POST['qc_status']);
    $qc_note = get_safe_value($_POST['qc_note']);

    $row = ExecutedQuery("SELECT * FROM product_details WHERE id = '$pid'");
    $row = $row[0];
    $qc_status__db = $row['qc_status'].','.$qc_status;
    $qc_notes__db = $row['qc_message'].',PS_FASHION_STORE,'.$qc_note;
    
    SqlQuery("UPDATE product_details SET qc_status='$qc_status__db', qc_message='$qc_notes__db' WHERE id='$pid'");

    if($qc_status == 0){
        $qc_text = 'Send for Re-Edit';
        $alert_color = 'text-info';
    }elseif ($qc_status == 1) {
        $qc_text = 'Approved';
        $alert_color = 'text-success';
    }else if ($qc_status == 2){
        $qc_text = 'Rejected';
        $alert_color = 'text-danger';
    }

    $html = '<dl class="col-12 col-md-3 '.$alert_color.'">'.$qc_text.'</dl>
             <dl class="col-12 col-md-9 '.$alert_color.'">'.$qc_note.'</dl>';

    echo $html;
}




















