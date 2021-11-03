<?php

require 'includes/session.php';
include('smtp/PHPMailerAutoload.php');



if(isset($_POST['email']) && $_POST['email'] != '' && isset($_POST['password']) && $_POST['password'] != ''){
    $email = get_safe_value($_POST['email']);
    $password = get_safe_value($_POST['password']);

    $query = "SELECT * FROM users WHERE email = '$email'";
    $results = mysqli_query($con, $query);
    if (mysqli_num_rows($results) > 0)
    {
        while ($row = mysqli_fetch_assoc($results))
        {
            if (password_verify($password, $row["password"]))
            {
                if ($row['verify'] == 0) {
                    $arr = array(
                        'status' => 'error',
                        'msg' => 'Please Verify Your Account.',
                        'field' => 'error'
                    );
                }else {
                    $_SESSION["UID"] = $row['id'];
                    $user_id = $_SESSION['UID'];

                    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                        $date = date("Y-m-d");
                        foreach($_SESSION['cart'] as $key => $val){
                            $data = explode(",", $key);
                            $cartdataSql = "SELECT * FROM CART WHERE user_id = ".$_SESSION['UID']." && product_id = ".$data['0']." && size='".$data['1']."'";
                            $result = mysqli_query($con, $cartdataSql);
                            
                            if(mysqli_num_rows($result) > 0){
                                // Update 
                                mysqli_query($con, "update cart set qty = '".$val['prod_qty']."', prod_price = '".$val['prod_price']."' where product_id = ".$data['0']." && size='".$data['1']."' and user_id = '".$user_id."'");
                            }else{
                                // insert 
                                mysqli_query($con, "insert into cart(`user_id`,`product_id`, `qty`, `size`, `prod_price`, `cart_status`, `cart_added_on`) Values('$user_id',".$data['0'].", ".$val['prod_qty'].", '".$data['1']."', ".$val['prod_price'].", 1, '$date')");

                            }
                        }

                    }

                    
                    // Creating Wishlist Default For User When Logining First Time 
                    $WishlistSql = "Select * from wishlist where user_id = '$user_id' && default_id = '1'";
                    $WishlistRes = mysqli_query($con, $WishlistSql);

                    if (mysqli_num_rows($WishlistRes) > 0) {
                        // Wishlist Already Created 

                    }else{
                        $date_wishlist =  date("Y-m-d H:i:s");
                        mysqli_query($con, "INSERT into wishlist (user_id, wishlist_name, wishlist_prod_id, default_id, added_on) VALUES('$user_id', 'My Wishlist', '', '1', '".$date_wishlist."')");
                    }
                    

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

else if(isset($_POST['email_signup']) && $_POST['email_signup'] != '' && isset($_POST['password_signup']) && $_POST['password_signup'] != '' && isset($_POST['firstname']) && $_POST['firstname'] != '' && isset($_POST['lastname']) && $_POST['lastname'] != ''){
    // $id_gender = get_safe_value($_POST['id_gender']);    
    $email = get_safe_value($_POST['email_signup']);
    $password = get_safe_value($_POST['password_signup']);
    $firstname = get_safe_value($_POST['firstname']);
    $lastname = get_safe_value($_POST['lastname']);
    $page_url = get_safe_value($_POST['page_url']);
    $date = date("Y-m-d");
    

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0)
    {
        $arr = array(
            'status' => 'error',
            'msg' => 'Email id already registered',
            'field' => 'error'
        );
    }else{
        $new_password=password_hash($password,PASSWORD_BCRYPT);
        $rand_str = rand(00000,99999);
        
        
        if (isset($_POST['id_gender']) && $_POST['id_gender'] != '') {
            $social_title = get_safe_value($_POST['id_gender']);
        }else{
            $social_title = '';
        }

        if (isset($_POST['newsletter']) && $_POST['newsletter'] > 0) {
            $newsletter = get_safe_value($_POST['newsletter']);
        }else{
            $newsletter = '';
        }

        mysqli_query($con, "insert into users(social_title, firstname, lastname, password, email, newsletter, verify, userLoginCode, userAdded_On) VALUES('$social_title', '$firstname', '$lastname', '$new_password', '$email', '$newsletter', '0', '$rand_str','$date')");
        $html = "<a href=".FRONT_SITE_PATH.'verify?email='.$email.'&userLoginCode='.$rand_str.'&redirect='.$page_url.">Click here to Verify</a>";
        $responseMail = send_email($email, $html, 'Verify Your Account '.$firstname.' '.$lastname);

        if($responseMail == 'Sended') {
            $arr = array(
                'status' => 'success',
                'msg' => 'Mail has been Sended. Please Verify and Continue your Shopping',
                'field' => 'error'
            );
        }
    }

echo json_encode($arr);
}

elseif (isset($_POST['reset_email'])) {
    $reset_email = get_safe_value($_POST['reset_email']);

    // CHECKING MAIL EXIXT OR NOT IN OUR DB 
    $UsersDetails = UsersDetails("WHERE email = '$reset_email'");
    if (!empty($UsersDetails)) {
        $userLoginCode = $UsersDetails[0]['userLoginCode'];
        $link = FRONT_SITE_PATH.'update_password?userLoginCode='.$userLoginCode.'&email='.$reset_email;
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
                                <p style="font-weight: 600; font-size: 18px; margin-bottom: 0;">Hey</p>
                                <p style="font-weight: 700; font-size: 20px; margin-top: 0; --text-opacity: 1; color: #ff5850; color: rgba(255, 88, 80, var(--text-opacity));">'.$UsersDetails[0]['firstname'].' '.$UsersDetails[0]['lastname'].'</p>
                                <p style="margin: 0 0 24px;">
                                  A request to reset password was received from your
                                  <span style="font-weight: 600;">'.SITE_NAME.'</span> Account -
                                  <a href="mailto:'.$UsersDetails[0]['email'].'" class="hover-underline" style="--text-opacity: 1; color: #7367f0; color: rgba(115, 103, 240, var(--text-opacity)); text-decoration: none;">'.$UsersDetails[0]['email'].'</a>
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
                                  <span style="font-weight: 600;">Note:</span> This link is valid for 1 hour from the time it was
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
elseif (isset($_POST['user_id_update_pass']) && $_POST['user_id_update_pass'] > 0 && isset($_POST['new_password']) && $_POST['new_password'] != '' && isset($_POST['confirm_password']) && $_POST['confirm_password'] != '') {
    $user_id = get_safe_value($_POST['user_id_update_pass']);
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
        mysqli_query($con, "UPDATE users set password= '$new_password' WHERE id = '$user_id'");
        $arr = array("status" => 'success', 'message' => 'Password Updated');
    }
    echo json_encode($arr);
}

elseif (isset($_POST['prod_id']) && isset($_POST['prod_price'])) {
    $prod_id = get_safe_value($_POST['prod_id']);
    $user_id = get_safe_value($_POST['user_id']);
    
    $prod_qty = get_safe_value($_POST['qty']);
    $prod_price = get_safe_value($_POST['prod_price']) * $prod_qty;
    $date = date("Y-m-d");

    $CartTotal = getCartTotal();

    if(isset($_POST['check_size'])) {
        $prod_size = get_safe_value($_POST['check_size']);
    }else {
        $prod_size = get_safe_value($_POST['check_sizes']);
    }
    
    $ProductDetails = ProductDetails("Where id = '$prod_id'");
    $ProductDetails = $ProductDetails[0];

    $remaining_stock = $ProductDetails['total_stock'] - $ProductDetails['total_sold'];
    
    $html = '';
    

    if ($user_id == 'Guest') {
        // Not Login USer so we have to store items to session 
 
        // 1. Check if Qty value match with Stock Remaining Value 
        if ($prod_qty > $remaining_stock) {
            $html .= ' <div class="modal-body">
                            <div class="box-cart-modal text-danger">
                                Hey Bro, Only '.$remaining_stock.'  items is remaining in our stock. 
                            </div>

                        </div>';
        $arr = array("status" => 'notlogged',  'msg' => $html, 'modal_title' => 'Limited Stock', 'Cart_Total' => $CartTotal);  
        }else{
                // Setting Session for product id and size 
            $_SESSION['cart'][$prod_id.','.$prod_size]['prod_price'] = $prod_price;
            $_SESSION['cart'][$prod_id.','.$prod_size]['prod_qty'] = $prod_qty;

        
            $sql = "SELECT * FROM product_details WHERE id = '$prod_id'";
            $res = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($res);

            $ProductImageById = ProductImageById($row['id'],"limit 1");
            array_unshift($ProductImageById,"");
            unset($ProductImageById[0]);

            $html .= '
                <div class="modal-body">
                    <div class="box-cart-modal">
                        <div class=" col-sm-4 col-xs-12 divide-right">
                            <div class="row no-gutters align-items-center">
                                <div class="col-6 text-center">
                                        <img src="'.FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'].'"
                                            alt="'.$row['product_name'].'" title="'.$row['product_name'].'" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8 col-xs-12">
                            <div class="cart-info">
                                <div class="pb-1">
                                    <span class="product-name"><a href="">'.$row['product_name'].'</a></span>
                                </div>
                                <div class="product-attributes text-muted pb-1">
                                    <div class="product-line-info">
                                        <span class="label">Size :</span>
                                        <span class="value">'.$prod_size.'</span>
                                    </div>
                                </div>
                                <span class="text-muted">'.$prod_qty.' x</span> <span>₹ '.$row['product_price'].'</span>
                            </div>
                            <div class="cart-content pt-2">
                                    <strong>Total Price:</strong>&nbsp;₹ '.$prod_qty * $row['product_price'].'
                                </p>

                                <div class="cart-content-btn">
                                    <a href="'.FRONT_SITE_PATH.'cart"
                                        class="btn btn-primary btn-block btn-sm">Go to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>';
                $arr = array("status" => 'notlogged',  'msg' => $html,'Cart_Total' => $CartTotal);
        }
        
        

    }else{
        $sql = "Select * from cart Where product_id = '".$prod_id."' and size = '".$prod_size."' and user_id = '".$user_id."'";
        $res = mysqli_query($con, $sql);

        $ProductImageById = ProductImageById($prod_id,"limit 1");
        array_unshift($ProductImageById,"");
        unset($ProductImageById[0]);

        $ProductDetails =  ProductDetails('left join brands on product_details.product_brand = brands.bid where id = "'.$prod_id.'"');
        $ProductDetails = $ProductDetails[0];

        if ($prod_qty > $remaining_stock) {
            $html .= ' <div class="modal-body">
                            <div class="box-cart-modal text-danger">
                                Hey Bro, Only '.$remaining_stock.'  items is remaining in our stock. 
                            </div>
                        </div>';
            $arr = array("status" => 'logged',  'msg' => $html, 'modal_title' => 'Limited Stock', 'Cart_Total' => $CartTotal);                        
        }else{
            $html .= '
                <div class="modal-body">
                    <div class="box-cart-modal">
                        <div class=" col-sm-4 col-xs-12 divide-right">
                            <div class="row no-gutters align-items-center">
                                <div class="col-6 text-center">
                                        <img src="'.FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'].'"
                                            alt="'.$ProductDetails['product_name'].'" title="'.$ProductDetails['product_name'].'" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8 col-xs-12">
                            <div class="cart-info">
                                <div class="pb-1">
                                    <span class="product-name"><a href="">'.$ProductDetails['product_name'].'</a></span>
                                </div>
                                <div class="product-attributes text-muted pb-1">
                                    <div class="product-line-info">
                                        <span class="label">Size :</span>
                                        <span class="value">'.$prod_size.'</span>
                                    </div>
                                </div>
                                <span class="text-muted">'.$prod_qty.' x</span> <span>₹ '.$ProductDetails['product_price'].'</span>
                            </div>
                            <div class="cart-content pt-2">
                                    <strong>Total Price:</strong>&nbsp;₹ '.$prod_qty * $ProductDetails['product_price'].'
                                </p>

                                <div class="cart-content-btn">
                                    <a href="'.FRONT_SITE_PATH.'cart"
                                        class="btn btn-primary btn-block btn-sm">Go to Cart</a>

                                    <a href="'.FRONT_SITE_PATH.'checkout"
                                        class="btn btn-success btn-block btn-sm">Proceed to Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>';

            if (mysqli_num_rows($res) > 0) {
                // Update  Cart Quantity
                mysqli_query($con, "update cart set qty = '".$prod_qty."', prod_price = '".$prod_price."' where product_id = '".$prod_id."' and size = '".$prod_size."' and user_id = '".$user['id']."'");
                $arr = array("status" => 'logged', 'msg' => $html, 'modal_title' => 'Product Updated', 'Cart_Total' => $CartTotal);
                    
            }else {
                    // Add Product to Cart
                    $CartTotal= $CartTotal + 1;
                    
                    mysqli_query($con, "insert into cart(`user_id`,`product_id`, `qty`, `size`, `prod_price`, `cart_status`, `cart_added_on`) Values('$user_id','$prod_id', '$prod_qty', '$prod_size', '$prod_price', 1, '$date')");
                    $arr = array("status" => 'logged', 'msg' => $html, 'modal_title' => 'Product Added to Cart', 'Cart_Total' => $CartTotal);
                
            }
        }

       
    
    }
    
    echo json_encode($arr);
    
}

elseif (isset($_POST['id']) && $_POST['id'] != "" && isset($_POST['type'])) {
    $uid = get_safe_value($_POST['id']);    
    $CartTotal = getCartTotal();

    if ($uid == 'Guest') {
        $cart_product = '';
        $get_price = array();

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $sum = 0;
            foreach($_SESSION['cart'] as $key => $val) {
                $get_pid_size = explode(",", $key);
                
                $GetSql = "SELECT * FROM product_details where id = '".$get_pid_size['0']."'";
                $res = mysqli_query($con, $GetSql);
                $row = mysqli_fetch_assoc($res);
                
                $ProductImageById = ProductImageById($get_pid_size['0'], 'limit 1');
                array_unshift($ProductImageById,"");
                unset($ProductImageById[0]);
    
                $sum += $_SESSION['cart'][$key]['prod_price'];

                $cart_product .= '
                <li>
                    <div class="cart-product-line no-gutters align-items-center">
                        <span class="product-image media-middle">
                            <a href=""><img
                                    src="'.FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'].'"
                                    alt="'.$row['product_name'].'" class="img-fluid"></a>
                        </span>
                        <div class="product-info">
                            <a class="product-name" href="'.FRONT_SITE_PATH.'product-details?productname='.urlencode($row['product_name']).'">'.$row['product_name'].'</a>
                            <div class="product-attributes text-muted pb-1">
                                <div class="product-line-info">
                                    <span class="label">Size :</span>
                                    <span class="value">'.$get_pid_size['1'].'</span>
                                </div>
                            </div>
                            <div class="product-price-quantity">
                                <span class="text-muted">'.$val['prod_qty'].' x</span>
                                <span class="product-price">'.$val['prod_price'].'</span>
                            </div>
                        </div>
                        <div class="remove-cart">
                        <a>₹ '.$val['prod_price'].'</a>
                        </div>
                    </div>
                </li>';

            }
            
            $ttprice = $sum.",";
            $price_total = explode(",",$ttprice);

            
            if($price_total[0] > 500) {
                $shipping_price = '<span style="color:green">Free</span>';
                $total_payable = '₹ '.$price_total[0];
            }else {
                $shipping_price = '₹ 500';
                $total_payable = '₹ '.($price_total[0] + 500);
            }

                $cart_products_count = 'There are '.$CartTotal.' items in your cart.';
                
                $arr = array(
                    'status'=>'success', 
                    'cart_products_count' => $cart_products_count,  
                    'cart_product' => $cart_product, 
                    'cart_total' => $CartTotal, 
                    'shipping_price' => $shipping_price,
                    'price_total' => '₹ '.$price_total[0],
                    'total_payable' => $total_payable
                    );
        }else{
            $arr = array('status'=>'error', 'msg' => 'There are no more items in your cart');
        }

    }else {
        $sql = "SELECT *, cart.id as cid FROM `cart` left join product_details on cart.product_id = product_details.id where cart.user_id = '$uid'";
        $result = mysqli_query($con , $sql);
        
        $cart_product = '';
        $product_payment_section = '';
        $detaills_page_data = '';
        $price_total = "";
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $ProductImageById = ProductImageById($row['id'], 'limit 1');
                array_unshift($ProductImageById,"");
                unset($ProductImageById[0]);
                $price_total = $price_total.",";
                $price_total .= $row['product_price'] * $row['qty'];
                $price_total_arr = explode(",", $price_total);
                $price_total = array_sum($price_total_arr);

                $cart_product .= '<li>
                                    <div class="cart-product-line no-gutters align-items-center">
                                        <span class="product-image media-middle">
                                            <a href=""><img
                                                    src="'.FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'].'"
                                                    alt="'.$row['product_name'].'" class="img-fluid"></a>
                                        </span>
                                        <div class="product-info">
                                            <a class="product-name" href="'.FRONT_SITE_PATH.'product-details?productname='.urlencode($row['product_name']).'">'.$row['product_name'].'</a>
                                            <div class="product-attributes text-muted pb-1">
                                                <div class="product-line-info">
                                                    <span class="label">Size :</span>
                                                    <span class="value">'.$row['size'].'</span>
                                                </div>
                                            </div>
                                            <div class="product-price-quantity">
                                                <span class="text-muted">'.$row['qty'].' x</span>
                                                <span class="product-price">'.$row['product_price'].'</span>
                                            </div>
                                        </div>
                                        <div class="remove-cart">
                                        <a>₹ '.$row['prod_price'].'</a>
                                        </div>
                                    </div>
                                </li>';

                // For Checkout Page Payment Section Confirmation 
                $product_payment_section .= '
                <div class="order-line row">
                    <div class="col-sm-2 col-xs-3">
                        <span class="image">
                            <img
                                src="'.FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'].'">
                        </span>
                    </div>
                    <div class="col-sm-4 col-xs-9 details">
                        <a href="'.FRONT_SITE_PATH.'product-details?productname='.urlencode($row['product_name']).'"
                            target="_blank"> <span>'.$row['product_name'].' <br> (Size - '.$row['size'].')</span>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xs-12 qty">
                        <div class="row">
                            <div class="col-xs-4 text-sm-center text-xs-left">₹ '.$row['product_price'].'</div>
                            <div class="col-xs-4 text-sm-center">'.$row['qty'].'</div>
                            <div class="col-xs-4 text-sm-center text-xs-right bold">₹ '.$row['qty'] * $row['product_price'].'
                            </div>
                        </div>
                    </div>
                </div>
            ';

            $detaills_page_data .= '<li class="media">
                                                <div class="media-left">
                                                    <a href="'.FRONT_SITE_PATH.'product-details?productname='.urlencode($row['product_name']).'"
                                                        title="'.$row['product_name'].'">
                                                        <img class="media-object"
                                                            src="'.FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'].'"
                                                            alt="'.$row['product_name'].'">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <span class="product-name">'.$row['product_name'].'</span>
                                                    <span class="product-quantity">x'.$row['qty'].'</span>
                                                    <span class="product-price float-xs-right">₹ '.$row['product_price'] * $row['qty'].'</span>

                                                    <div class="product-line-info product-line-info-secondary text-muted" style="display:block">
                                                        <span class="label">Size:</span>
                                                        <span class="value">'.$row['size'].'</span>
                                                    </div>
                                                
                                                    <br />
                                                    
                                                </div>

                                            </li>';
            }

            $cart_products_count = 'There are '.$CartTotal.' items in your cart.';
            
            if($price_total > 500) {
                $shipping_price = '<span style="color:green">Free</span>';
                $total_payable = '₹ '.$price_total;
            }else {
                $shipping_price = '₹ 500';
                $total_payable = '₹ '.($price_total + 500);
            }


            

            $arr = array(
                        'status'=>'success', 
                        'cart_product' => $cart_product, 
                        'cart_products_count' => $cart_products_count, 
                        'cart_total' => $CartTotal, 
                        'price_total' => '₹ '.$price_total, 
                        'shipping_price' => $shipping_price,
                        'total_payable' => $total_payable,
                        'product_payment_section' => $product_payment_section,
                        'detaills_page_data' => $detaills_page_data
                    );
            
        }else {
            $arr = array('status'=>'error', 'msg' => 'There are no more items in your cart');
            
        }

    }   

    echo json_encode($arr);

} 

elseif (isset($_POST['id']) && $_POST['id'] != "" && isset($_POST['data'])) {
    $uid = get_safe_value($_POST['id']);
    $CartTotal = getCartTotal();
    $html  = '';

        if ($uid == 'Guest') {
            if(isset($_SESSION['cart']) && $_SESSION['cart'] >0){
                foreach($_SESSION['cart'] as $key => $val) {
                    $get_pid_size = explode(",", $key);
                    
                    $GetSql = "SELECT * FROM product_details where id = '".$get_pid_size['0']."'";
                    $res = mysqli_query($con, $GetSql);
                    $row = mysqli_fetch_assoc($res);
                    
                    $ProductImageById = ProductImageById($get_pid_size['0'], 'limit 1');
                    array_unshift($ProductImageById,"");
                    unset($ProductImageById[0]);
    
                    $size = $get_pid_size['1'];
                    $id = $user['id'];
                    $html .= " <li class=\"cart-item\">
    
                    <div class=\"product-line-grid\">
                        <!--  product line left content: image-->
                        <div
                            class=\"product-line-grid-left col-md-2 col-sm-3 col-xs-4 col-sp-12\">
                            <span class=\"product-image media-middle\">
                                <img src=".FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img']."
                                    alt=".$row['product_name'].">
                            </span>
                        </div>
    
                        <div class=\"col-md-10 col-sm-9 col-xs-8 col-sp-12\">
                            <div class=\"row\">
                                <!--  product line body: label, discounts, price, attributes, customizations -->
                                <div
                                    class=\"product-line-grid-body col-md-5 col-sm-5 col-xs-12\">
                                    <div class=\"product-line-info\">
                                        <a class=\"label\" href=\"".FRONT_SITE_PATH.'product-details?productname='.urlencode($row['product_name'])."\"
                                            data-id_customization=\"0\">".$row['product_name']."</a>
                                    </div>
    
                                    <div class=\"product-line-info product-price h5 \">
                                    <div class=\"product-attributes text-muted pb-1\">
                                        <div class=\"product-line-info\">
                                            <span class=\"label\">Size :</span>
                                            <span class=\"value\">".$get_pid_size['1']."</span>
                                        </div>
                                    </div>
                                        <div class=\"current-price\">
                                            <span class=\"price\">₹ ".$row['product_price']."</span>
                                        </div>
                                    </div>
    
                                    <br>
    
    
                                </div>
    
                                <!--  product line right content: actions (quantity, delete), price -->
                                <div
                                    class=\"product-line-grid-right product-line-actions col-md-7 col-sm-7 col-xs-12\">
                                    <div class=\"row\">
                                        <div class=\"col-md-10 col-sm-9 col-xs-10\">
                                            <div class=\"row\">
                                                <div class=\"col-md-6 col-xs-6 qty\">
                                                    <div
                                                        class=\"input-group bootstrap-touchspin\">
                                                        <span
                                                            class=\"input-group-addon bootstrap-touchspin-prefix\"
                                                            style=\"display: none;\"></span><input
                                                            type=\"number\" value=".$val['prod_qty']."
                                                            name=\"product-quantity-spin\" id = 'change".$get_pid_size['0']."_".$get_pid_size['1']."' min='1' onchange=\"onChangeFunctionNoLogin(this.value, ".$get_pid_size['0'].", '$size', ".$row['product_price'].")\" 
                                                            style=\"display: block;width:100px\">
                                                    </div>
                                                </div>
                                                <div class=\"col-md-6 col-xs-2 price\">
                                                    <span class=\"product-price\" id='product".$get_pid_size['0'].''.$size."'>
                                                        <strong>
                                                        ₹ ".$row['product_price'] * $val['prod_qty']."
    
                                                        </strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class=\"col-md-2 col-sm-3 col-xs-2 text-xs-right\">
                                            <div class=\"cart-line-product-actions\">
                                                <a class=\"remove-from-cart\"
                                                    rel=\"nofollow\" href=\"javascript:void(0)\" onclick=\"delete_product_from_cart('$id',".$row['id'].",'$size')\">
                                                    <i
                                                        class=\"fa fa-trash-o float-xs-left\"></i>
                                                </a>
    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class=\"clearfix\"></div>
                    </div>
                </li>";
                }    
            }
        }else{
            $sql = "SELECT *, cart.id as cid FROM `cart` left join product_details on cart.product_id = product_details.id where cart.user_id = '$uid'";
            $result = mysqli_query($con , $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $ProductImageById = ProductImageById($row['id'], 'limit 1');
                    array_unshift($ProductImageById,"");
                    unset($ProductImageById[0]);
                    $size = $row['size'];            
                    $html .= "
                    <li class=\"cart-item\">
    
                        <div class=\"product-line-grid\">
                            <!--  product line left content: image-->
                            <div
                                class=\"product-line-grid-left col-md-2 col-sm-3 col-xs-4 col-sp-12\">
                                <span class=\"product-image media-middle\">
                                    <img src=".FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img']."
                                        alt=".$row['product_name'].">
                                </span>
                            </div>
    
                            <div class=\"col-md-10 col-sm-9 col-xs-8 col-sp-12\">
                                <div class=\"row\">
                                    <!--  product line body: label, discounts, price, attributes, customizations -->
                                    <div
                                        class=\"product-line-grid-body col-md-5 col-sm-5 col-xs-12\">
                                        <div class=\"product-line-info\">
                                            <a class=\"label\" href=\"".FRONT_SITE_PATH.'product-details?productname='.urlencode($row['product_name'])."\"
                                                data-id_customization=\"0\">".$row['product_name']."</a>
                                        </div>
    
                                        <div class=\"product-line-info product-price h5 \">
                                        <div class=\"product-attributes text-muted pb-1\">
                                            <div class=\"product-line-info\">
                                                <span class=\"label\">Size :</span>
                                                <span class=\"value\">".$row['size']."</span>
                                            </div>
                                        </div>
                                            <div class=\"current-price\">
                                                <span class=\"price\">₹ ".$row['product_price']."</span>
                                            </div>
                                        </div>
    
                                        <br>
    
    
                                    </div>
    
                                    <!--  product line right content: actions (quantity, delete), price -->
                                    <div
                                        class=\"product-line-grid-right product-line-actions col-md-7 col-sm-7 col-xs-12\">
                                        <div class=\"row\">
                                            <div class=\"col-md-10 col-sm-9 col-xs-10\">
                                                <div class=\"row\">
                                                    <div class=\"col-md-6 col-xs-6 qty\">
                                                        <div
                                                            class=\"input-group bootstrap-touchspin\">
                                                            <span
                                                                class=\"input-group-addon bootstrap-touchspin-prefix\"
                                                                style=\"display: none;\"></span><input
                                                                type=\"number\" value=".$row['qty']."
                                                                name=\"product-quantity-spin\" min='1' onchange=\"onChangeFunction(this.value, ".$row['cid'].", ".$row['id'].")\"
                                                                style=\"display: block;width:100px\">
                                                        </div>
                                                    </div>
                                                    <div class=\"col-md-6 col-xs-2 price\">
                                                        <span class=\"product-price\" id='product".$row['cid']."'>
                                                            <strong>
                                                            ₹ ".$row['product_price'] * $row['qty']."
    
                                                            </strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class=\"col-md-2 col-sm-3 col-xs-2 text-xs-right\">
                                                <div class=\"cart-line-product-actions\">
                                                    <a class=\"remove-from-cart\"
                                                        rel=\"nofollow\" href=\"#\" onclick=\"delete_product_from_cart(".$user['id'].",".$row['id'].",'$size')\">
                                                        <i
                                                            class=\"fa fa-trash-o float-xs-left\"></i>
                                                    </a>
    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class=\"clearfix\"></div>
                        </div>
                    </li>";
                }
            }     
        }

        echo $html;

    ?>
<script>
function onChangeFunction(value, id, prod_id) {
    $.ajax({
        url: 'ajax_call.php',
        method: 'post',
        data: {
            value: value,
            id: id,
            prod_id:prod_id
        },
        success: (res) => {
            var json_arr = $.parseJSON(res);
            
            if(json_arr.status == 'success') {
                getCartDetails();
                $("#product" + id).html("₹ " + json_arr.message)
            }

            if(json_arr.status == 'error') {
                swal("No Data", json_arr.message, 'error');
            }
        }
    })
}

function onChangeFunctionNoLogin(value, id, size, curr_price) {
    $.ajax({
        url: 'ajax_call.php',
        method: 'post',
        data: {
            value: value,
            id: id,
            size: size,
            curr_price: curr_price
        },
        success: (res) => {
            getCartDetails();
            var json_arr = $.parseJSON(res);
            $("#product" + id + "" + size + " strong").html("₹ " + json_arr.updated_price);
        }
    })
}
</script>
<?php
}

elseif (isset($_POST['uid']) && $_POST['uid'] != '' && isset($_POST['pid']) && $_POST['pid'] > 0 && isset($_POST['size'])) {
    $uid = get_safe_value($_POST['uid']);
    $pid = get_safe_value($_POST['pid']);
    $size = get_safe_value($_POST['size']);
    $CartTotal = getCartTotal();
    $CartTotal= $CartTotal - 1;

    if ($uid == 'Guest') {
        unset($_SESSION['cart'][$pid.','.$size]);
    }else{
        $DeleteSql= "Delete from cart where user_id = '$uid' && product_id = '$pid' && size = '$size'";
        mysqli_query($con, $DeleteSql);
    }

    $arr = array('message' => 'Product Deleted Successfully', 'CartTotal' => $CartTotal);

    echo json_encode($arr);
}

elseif (isset($_POST['value']) && $_POST['value'] > 0 && isset($_POST['id']) && $_POST['id'] > 0 && isset($_POST['prod_id']) && $_POST['prod_id'] > 0) {

    $value = get_safe_value($_POST['value']);
    $id = get_safe_value($_POST['id']);
    $prod_id = get_safe_value($_POST['prod_id']);


    $ProductDetails = ProductDetails("Where id = '$prod_id'");
    $ProductDetails = $ProductDetails[0];

    $remaining_stock = $ProductDetails['total_stock'] - $ProductDetails['total_sold'];

    if (isset($_SESSION['UID'])) {
        $CartSql  = 'SELECT * FROM `cart` left JOIN product_details on cart.product_id = product_details.id  where cart.id = "'.$id.'"';
        $CartRes = mysqli_query($con, $CartSql);
        $Cartrow = mysqli_fetch_assoc($CartRes);

        // Gettng Product Price 

        $prod_price = $Cartrow['product_price'];
        $updated_price = $value * $prod_price;

        if ($value > $remaining_stock) {
            $arr =array('status' => 'error', 'message' => 'Only, '.$remaining_stock.' items remains');
        }else{
            $UpdateSql = "Update cart set prod_price = '$updated_price', qty = '$value' where id = '$id'";
            mysqli_query($con, $UpdateSql);
            $arr =array('status' => 'success', 'message' => $updated_price);
        }

   }else {
       $size = get_safe_value($_POST['size']);
       $curr_price = get_safe_value($_POST['curr_price']);
       $updated_price = $value * $curr_price;
       if ($value > $remaining_stock) {
            $arr =array('status' => 'error', 'message' => 'Only, '.$remaining_stock.' items remains');
        }else{
            $_SESSION['cart'][$id.','.$size]['prod_qty'] = $value;
            $_SESSION['cart'][$id.','.$size]['prod_price'] = $updated_price;
            $arr = array('status' => 'error', 'message' => $updated_price);
        }
   }

   echo json_encode($arr);

}

elseif (isset($_POST['setAddresDefaultId']) && $_POST['setAddresDefaultId'] > 0) {
    $id = get_safe_value($_POST['setAddresDefaultId']);
    $uid =  $user['id'];

    $SQL= "select * from user_address where user_id = '$uid'";
    mysqli_query($con, $SQL);

    $updatesql = "update user_address set default_address = 0 where user_id = '$uid'";
    mysqli_query($con, $updatesql);

    $setSql = "update user_address set default_address = 1 where id = '$id'";
    mysqli_query($con, $setSql);

    echo 'This is your default address';
}

elseif(isset($_POST['id_address_delivery']) && $_POST['id_address_delivery'] > 0) {
    $_SESSION['id_address_delivery'] = get_safe_value($_POST['id_address_delivery']);

    $getAddressById = getAddressById($_SESSION['id_address_delivery']);
    
    echo '<div class="col-md-6">
            <div class="card noshadow">
                <div class="card-block">
                    <h4 class="h5 black addresshead">Your Delivery Address</h4>
                    '.$getAddressById['add_firstname'].' '.$getAddressById['add_lastname'].', '.$getAddressById['company'].'<br>'.$getAddressById['address'].', '.$getAddressById['addres_complement'].'<br>'.$getAddressById['city'].' - '.$getAddressById['postal_code'].'<br>'.$getAddressById['state'].'<br>'.$getAddressById['country']
                    .'<br>'.$getAddressById['phone_number'].'
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card noshadow">
                <div class="card-block">
                    <h4 class="h5 black addresshead">Your Invoice Address</h4>
                    '.$getAddressById['add_firstname'].' '.$getAddressById['add_lastname'].', '.$getAddressById['company'].'<br>'.$getAddressById['address'].', '.$getAddressById['addres_complement'].'<br>'.$getAddressById['city'].' - '.$getAddressById['postal_code'].'<br>'.$getAddressById['state'].'<br>'.$getAddressById['country']
                    .'<br>'.$getAddressById['phone_number'].'
                </div>
            </div>
        </div>';
}

elseif (isset($_POST['CARTTOTALDAILY']) && $_POST['CARTTOTALDAILY'] != '') {
    $CartTotal = getCartTotal();

    echo $CartTotal;
}

elseif (isset($_POST['prod_id']) && $_POST['prod_id'] > 0 && isset($_POST['quickview'])) {
    $prod_id = get_safe_value($_POST['prod_id']);
    $ProductDetails =  ProductDetails('left join brands on product_details.product_brand = brands.bid where id = "'.$prod_id.'"');
    $ProductDetails = $ProductDetails[0];
    $DiscountPercentage = 100 - (($ProductDetails['product_price'] / $ProductDetails['product_oldPrice']) * 100) ;
    $DiscountPercentage = floor($DiscountPercentage);
    if($DiscountPercentage > 50) {
        $changeDiscountColor = 'green';
    }else{
        $changeDiscountColor = 'red';
    }
    ?>
<style>
.has-discount .discount {
    border: 2px solid <?=$changeDiscountColor ?>;
    color: <?=$changeDiscountColor ?>;
}

.has-discount .discount:before {
    border: 13px solid <?=$changeDiscountColor ?>;
    border-right-color: transparent;
}
</style>
<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 col-sp-12">

    <section class="page-content" id="content_quick_view">

        <div class="images-container">
            <div class="product-cover product-img-slick">
                <?php
                        $ProductImageById = ProductImageById($prod_id);
                        array_unshift($ProductImageById,"");
                        unset($ProductImageById[0]);
                        foreach ($ProductImageById as $key => $value) {
                            ?>

                <img class="images-zoom" data-zoom-image="<?= FRONT_SITE_IMAGE_PRODUCT.$value['product_img'] ?>"
                    data-src="<?= FRONT_SITE_IMAGE_PRODUCT.$value['product_img'] ?>"
                    data-zoom="<?= FRONT_SITE_IMAGE_PRODUCT.$value['product_img'] ?>"
                    src="<?= FRONT_SITE_IMAGE_PRODUCT.$value['product_img'] ?>" style="width:100%">
                <?php
                    }
                ?>
            </div>



            <div id="rb_gallery" class="product-img-slick">

                <?php
                        foreach ($ProductImageById as $key => $value) {
                            ?>
                <a class="thumb-container" href="javascript:void(0)"
                    data-image="<?= FRONT_SITE_IMAGE_PRODUCT.$value['product_img'] ?>"
                    data-zoom-image="<?= FRONT_SITE_IMAGE_PRODUCT.$value['product_img'] ?>">
                    <img class="img img-thumb" id="rb_img_1"
                        src="<?= FRONT_SITE_IMAGE_PRODUCT.$value['product_img'] ?>" />
                </a>
                <?php 
                        }
                        ?>

            </div>

        </div>
    </section>

</div>

<div class="col-md-6 col-sm-6">
    <h1 class="h1"><?= $ProductDetails['product_name'] ?></h1>

    <div class="product-prices">
        <div class="product-discount">

            <span class="regular-price">₹ <?= $ProductDetails['product_oldPrice'] ?></span>
        </div>

        <div class="product-price h5 has-discount" itemprop="offers" itemscope="" itemtype="https://schema.org/Offer">
            <link itemprop="availability" href="https://schema.org/InStock">
            <meta itemprop="priceCurrency" content="INR">

            <div class="current-price">
                <span itemprop="price" content="<?= $ProductDetails['product_price'] ?>">₹
                    <?= $ProductDetails['product_price'] ?></span>

                <span class="discount discount-percentage"><?= $DiscountPercentage.'%' ?></span>
            </div>

        </div>


        <div class="tax-shipping-delivery-label">
        </div>

        <div class="product-attributes-label">
            <div class="product-manufacturer">
                <label class="label">Brand:</label>

                <a href="<?= FRONT_SITE_PATH.'brand?brand_name='.$ProductDetails['brand_name'] ?>">
                    <img src="<?= FRONT_SITE_IMAGE_BRAND.$ProductDetails['brand_img'] ?>"
                        class="img img-thumbnail manufacturer-logo" alt="<?= $ProductDetails['brand_name'] ?>">
                </a>

            </div>

            <div class="product-quantities">
                <label class="label">In stock</label>
                <span data-stock="278" data-allow-oosp="0"><?= number_format($ProductDetails['total_stock']    ) ?>
                    Items</span>
            </div>

        </div>

        <div id="product-availability">
        </div>

    </div>


    <div id="product-description-short" itemprop="description">
        <p><?= $ProductDetails['product_desc_short'] ?></p>
    </div>


    <div class="product-actions">
        <!-- begin /var/www/html/demo/rb_evo_demo/modules/rbthemefunction/views/templates/rb-ajax-loading.tpl -->
        <div class="cssload-container rb-ajax-loading">
            <div class="cssload-double-torus"></div>
        </div>
        <!-- end /var/www/html/demo/rb_evo_demo/modules/rbthemefunction/views/templates/rb-ajax-loading.tpl -->
        <form action="" method="post" id="add-to-cart-product">
            <input type="hidden" name='prod_id' value="<?= $ProductDetails['id'] ?>">
            <input type="hidden" name='user_id' value="<?= $user['id'] ?>">
            <input type="hidden" name='prod_price' value="<?= $ProductDetails['product_price'] ?>">

            <div class="product-variants">
                <div class="clearfix product-variants-item">
                    <span class="control-label">Size</span>
                    <ul id="group_3">
                        <?php
                                $ProductSizes = $ProductDetails['product_size'];
                                
                                $sizeExtract = explode(', ', $ProductSizes);
                                foreach ($sizeExtract as $key => $value) {
                                    // Hitting Check at inital Size 
                                    if ($key == 0) {
                                        $checked = "checked='checked'";
                                    }else {
                                        $checked = '';
                                    }
                                        ?>
                        <li class="input-container float-xs-left instock">
                            <label>
                                <input class="input-radio" type="radio" name="check_sizes" value="<?= $value ?>"
                                    title="<?= $value ?>" required <?= $checked ?>>
                                <span class="radio-label"><?= $value ?></span>
                            </label>
                        </li>
                        <?php
                                            }
                                            ?>
                    </ul>
                </div>
            </div>
            <section class="product-discounts">
            </section>

            <div class="product-add-to-cart">

                <div class="product-quantity clearfix">
                    <div class="qty">
                        <span class="control-label hidden-xl-down">Quantity</span>
                        <div class="input-group bootstrap-touchspin">
                            <span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span>
                            <input type="text" name="qty" id="quantity_wanted" value="1"
                                class="input-group form-control" min="1" aria-label="Quantity" style="display: block;">
                            <span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span>
                            <span class="input-group-btn-vertical">
                                <button class="btn btn-touchspin js-touchspin bootstrap-touchspin-up" type="button">
                                    <i class="material-icons touchspin-up"></i>
                                </button>
                                <button class="btn btn-touchspin js-touchspin bootstrap-touchspin-down" type="button">
                                    <i class="material-icons touchspin-down"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="add">
                        <button class="btn btn-primary add-to-cart" type="submit">
                            <i class="rub-shopping-cart"></i>
                            Add to cart
                        </button>
                        <div class="page-loading-overlay add-to-cart-loading"></div>
                    </div>
                </div>
        </form>
        <div class="compare-wishlist-button">
            <div class="rb-wishlist">
                <div class="dropdown rb-wishlist-dropdown">
            
                <button class="rb-wishlist-button rb-btn-product show-list btn-product btn rb_added"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-id-wishlist="9"
                        data-id-product="4" data-id-product-attribute="16">
                        <span class="rb-wishlist-content">
                            <i class="icon-btn-product icon-wishlist icon-Icon_Wishlist"></i>
                            <span class="icon-title">Add to Wishlist</span>
                        </span>
                </button>
                <div class="dropdown-menu rb-list-wishlist rb-list-wishlist-4">
                <?php
                    $WishlistData = WishlistData($user['id']);
                    
                    foreach($WishlistData as $key => $val){
                        $ProductSizes = $ProductDetails['product_size'];
                        $sizes = explode(",", $ProductSizes);
                        
                        // Convert Product from string to array 
                        $productFromWishlist = explode(",", $val['wishlist_prod_id']);
                        
                        if (in_array($ProductDetails['id'], $productFromWishlist)) {
                            $icon = 'fa fa-check';
                            $css_wish_id = 'color:green;pointer-events:none';
                        }else{
                            $icon = 'icon-btn-product icon-wishlist icon-Icon_Wishlist';
                            $css_wish_id = '';
                        }
                    ?>
            
                    
                        <a href="javascript:void(0)"
                            onclick = "AddtoWishList('<?= $val['id'] ?>', '<?= $ProductDetails['id'] ?>', '<?= $sizes['0'] ?>')"
                            class="rb-wishlist-link dropdown-item list-group-item list-group-item-action wishlist-item rb_added<?= $val['id'].'_'.$ProductDetails['id'] ?> " 
                            title="Remove from Wishlist" style= "<?= $css_wish_id ?>"> 
                            <i class="<?= $icon ?>"></i>
                            <?= $val['wishlist_name'] ?>
                        </a>
                       <?php
                       }
                       ?>
                    </div>
                </div>
            </div>


        </div>




    </div>

    <script>
    $("#add-to-cart-product").submit((e) => {
        e.preventDefault();
        var data = $("#add-to-cart-product").serialize();

        $.ajax({
            url: 'ajax_call.php',
            type: 'post',
            data: data,
            success: (res) => {
                // caliing getCartDetails function to get details when we click add to cart button 
                getCartDetails();

                var json_arr = $.parseJSON(res);
                $("#quickview-modal-3-13").removeClass("quickview in");
                $("#quickview-modal-3-13").css({
                    "display": "none"
                });

                setTimeout(() => {

                    $("#blockcart-modal-wrap").show();
                    $("#blockcart-modal").show();

                    if (json_arr.status = 'logged') {
                        $("#blockcart-modal .modal-content .modal-header .modal-title")
                            .html(json_arr.modal_title);
                        $("#blockcart-modal .modal-content .modal-body").html(json_arr.msg);
                        $(".cart-products-count-btn").html(json_arr.Cart_Total);
                    } else {
                        $("#blockcart-modal .modal-content .modal-body").html(json_arr.msg);
                        $(".cart-products-count-btn").html(json_arr.Cart_Total);
                    }

                }, 1000);

            }
        });
    })

    var quantity = $("#quantity_wanted").val();
    $(".bootstrap-touchspin-up").click(() => {
        quantity++;
        if (quantity > 0) {
            $("#quantity_wanted").val(quantity)
        }
    });

    $(".bootstrap-touchspin-down").click(() => {
        quantity--;
        if (quantity > 0) {
            $("#quantity_wanted").val(quantity)
        }
    });
    </script>

</div>


</div>
<?php
}

elseif (isset($_POST['show_wishlist'])) {
    $uid = $_SESSION['UID'];

    $SQL = "SELECT * FROM wishlist WHERE user_id = '$uid'";
    $res = mysqli_query($con, $SQL);
    
    ?>
<div class="rb-list-wishlist">
    <table class="table table-striped">
        <thead class="wishlist-table-head">
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th class="wishlist-datecreate-head">Created</th>
                <th>View Link</th>
                <th>Default</th>
                <th>Delete</th>
            </tr>
        </thead>

        <tbody>

            <?php
                    if (mysqli_num_rows($res) > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $products = explode(",",  $row['wishlist_prod_id']);
                            if(empty($products['0'])){
                                $count = 0;
                            }else{
                                $count = count($products);
                            }

                            if($row['default_id'] == 1) {
                                $checked = 'checked="checked" disabled';
                                $message = 'Default Wishlist Cannot be deleted';
                            }else{
                                $checked = ' ';
                                $message = '<a class="delete-wishlist" href="javascript:void(0)" onclick="DeleteWishlist('.$row['id'].')" title="Delete"><i class="material-icons">&#xE872;</i></a>';
                            }
                    ?>

            <tr>
                <td>
                    <!-- begin /var/www/html/demo/rb_evo_demo/modules/rbthemefunction/views/templates/rb-ajax-loading.tpl -->
                    <div class="cssload-container rb-ajax-loading">
                        <div class="cssload-double-torus"></div>
                    </div>
                    <!-- end /var/www/html/demo/rb_evo_demo/modules/rbthemefunction/views/templates/rb-ajax-loading.tpl -->
                    <a href="javascript:void(0)" class="view-wishlist-product" data-name-wishlist="My wishlist"><i
                            class="material-icons">&#xE8EF;</i><?= $row['wishlist_name'] ?></a>
                </td>

                <td class="wishlist-numberproduct wishlist-numberproduct-5">
                    <?=  $count   ?>
                </td>

                <td class="wishlist-datecreate"><?= date("d M, Y h:i A", strtotime($row['added_on'])) ?></td>

                <td>
                    <a class="view-wishlist" target="_blank"
                        href="<?= FRONT_SITE_PATH."wishlist?viewList=".$row['id']."" ?>" title="View">View</a>
                </td>

                <td>
                    <label class="form-check-label">
                        <input class="default-wishlist form-check-input" <?= $checked ?>
                            onclick="DefaultWishlist('<?= $row['id'] ?>')" type="checkbox">
                    </label>

                </td>

                <td>
                    <?= $message ?>
                </td>
            </tr>



            <?php
            }
        }
                ?>

            <script>
            function DefaultWishlist(wish_id) {
                var setDefaultWishlist = 'setDefaultWishlist';
                $.ajax({
                    url: 'ajax_call.php',
                    type: "post",
                    data: {
                        setDefaultWishlist: setDefaultWishlist,
                        wish_id: wish_id
                    },
                })
            }

            // Delete Wishlist 
            function DeleteWishlist(wish_id) {
                var DeleteWishlist = 'DeleteWishlist';
                swal({
                    title: "Are you sure?",
                    icon: "warning",
                    buttons: [
                        'No, cancel it!',
                        'Yes, I am sure!'
                    ],
                    dangerMode: true,
                }).then(function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: 'ajax_call.php',
                            type: "post",
                            data: {
                                DeleteWishlist: DeleteWishlist,
                                wish_id: wish_id
                            },
                            success: (res) => {
                                swal("Deleted", "Your Wishlist Deleted Successfully", "success");

                            }
                        })
                    }
                });

            }
            </script>
        </tbody>
    </table>
</div>

<?php

}

elseif (isset($_POST['setDefaultWishlist']) && isset($_POST['wish_id'])) {
    $wish_id = get_safe_value($_POST['wish_id']);
    $uid = $_SESSION['UID'];


    mysqli_query($con, "UPDATE wishlist set default_id = 0 WHERE user_id = '$uid'");
    mysqli_query($con, "UPDATE wishlist set default_id = 1 WHERE id = '$wish_id'");

    echo 'This is Your Default Wishlist';

}


// New Wihlist Adding For User 
elseif (isset($_POST['wishlist_name_new'])) {
    $wishlist_name_new = get_safe_value($_POST['wishlist_name_new']);
    $uid = $_SESSION['UID'];
    // check exist or not 

    $checkSql = "Select * from wishlist where  wishlist_name = '$wishlist_name_new' && user_id = '$uid'";
    $res = mysqli_query($con, $checkSql);
    
    // exist then return error message 
    if (mysqli_num_rows($res) > 0) {
        $arr = array(
            'status' => 'error',
            'message' => 'Wishlist Already Exist'
        );
    }
    else{
    // not exist then add data to database 
        $date = date("Y-m-d h:i:s");
        mysqli_query($con, "INSERT into wishlist(user_id, wishlist_name, wishlist_prod_id, wishlist_prod_size, default_id, added_on) VALUES('$uid', '".$wishlist_name_new."', '', '', '0', '".$date."')");
        $arr = array(
            'status' => 'success',
            'message' => 'New Wishlist '.$wishlist_name_new.' Added'
        );
    }

    echo json_encode($arr);

}

elseif (isset($_POST['DeleteWishlist']) && $_POST['DeleteWishlist'] != '' && isset($_POST['wish_id']) && $_POST['wish_id'] > 0) {
    $wish_id = get_safe_value($_POST['wish_id']);

    mysqli_query($con, "DELETE FROM wishlist WHERE id = '$wish_id'");

    echo "done";
}



elseif (isset($_POST['AddtoWishList']) && $_POST['AddtoWishList'] != '' &&  isset($_POST['wishlist_id']) && $_POST['wishlist_id'] > 0 && isset($_POST['prod_id']) && $_POST['prod_id'] > 0 && isset($_POST['sizes']) && $_POST['sizes'] != '') {
    $wish_id = get_safe_value($_POST['wishlist_id']);
    $prod_id = get_safe_value($_POST['prod_id']);
    // Select that wishlist id on which you hae to insert that item 
    $SelectSql = mysqli_query($con, "SELECT * FROM wishlist where id = '$wish_id'");
    $row = mysqli_fetch_assoc($SelectSql);

    if ($row['wishlist_prod_id'] == '') {
        mysqli_query($con, "UPDATE wishlist set wishlist_prod_id = '$prod_id' WHERE id = '$wish_id'");
        $arr = array(
                'status' => 'success',
                'message' => 'Product Added to '.$row['wishlist_name'].' Wishlist'
            ); 
    }else{
        $getProductIds =  $row['wishlist_prod_id'];
        
        $ExplodeProd = explode(",", $getProductIds);
        
        if (!in_array($prod_id, $ExplodeProd)) {
            $finalProduct = $getProductIds.','.$prod_id;
            mysqli_query($con, "UPDATE wishlist set wishlist_prod_id = '$finalProduct' WHERE id = '$wish_id'");   
            $arr = array(
                'status' => 'success',
                'message' => 'Product Added to '.$row['wishlist_name'].' Wishlist'
            ); 
        }else{
            
            $arr = array(
                'status' => 'error',
                'message' => 'This Item is Exist in '.$row['wishlist_name'].' Wishlist'
            ); 
        }

        
    }

    echo json_encode($arr);
}