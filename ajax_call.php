<?php

require 'includes/session.php';
include('smtp/PHPMailerAutoload.php');



if(isset($_POST['email']) && $_POST['email'] != '' && isset($_POST['password']) && $_POST['password'] != ''){
    $email = get_safe_value($_POST['email']);
    $password = get_safe_value($_POST['password']);

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
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
                        'msg' => 'Email or Password is incorrect',
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

        mysqli_query($con, "insert into users(social_title, firstname, lastname, password, email, newsletter, verify, userLoginCode) VALUES('$social_title', '$firstname', '$lastname', '$new_password', '$email', '$newsletter', '0', '$rand_str')");
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
    
    $html = '';
    if ($user_id == 'Guest') {
        // Not Login USer so we have to store items to session 
 
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

    }else{
        $sql = "Select * from cart Where product_id = '".$prod_id."' and size = '".$prod_size."' and user_id = '".$user_id."'";
        $res = mysqli_query($con, $sql);

        $ProductImageById = ProductImageById($prod_id,"limit 1");
        array_unshift($ProductImageById,"");
        unset($ProductImageById[0]);

        $ProductDetails =  ProductDetails('left join brands on product_details.product_brand = brands.bid where id = "'.$prod_id.'"');
        $ProductDetails = $ProductDetails[0];

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
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $ProductImageById = ProductImageById($row['id'], 'limit 1');
                array_unshift($ProductImageById,"");
                unset($ProductImageById[0]);

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
                            target="_blank"> <span>'.$row['product_name'].'</span>
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
            $PriceTTSql= "SELECT SUM(prod_price) as TTPrice FROM `cart` WHERE user_id = '$uid'";
            $PriceRes = mysqli_query($con, $PriceTTSql);
            $priceRow = mysqli_fetch_assoc($PriceRes);
            $price_total  = '₹ '.$priceRow['TTPrice'];
            
            if($priceRow['TTPrice'] > 500) {
                $shipping_price = '<span style="color:green">Free</span>';
                $total_payable = '₹ '.$priceRow['TTPrice'];
            }else {
                $shipping_price = '₹ 500';
                $total_payable = '₹ '.($priceRow['TTPrice'] + 500);
            }


            

            $arr = array(
                        'status'=>'success', 
                        'cart_product' => $cart_product, 
                        'cart_products_count' => $cart_products_count, 
                        'cart_total' => $CartTotal, 
                        'price_total' => $price_total, 
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
                                        <a class=\"label\" href=\"\"
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
                                                    rel=\"nofollow\" href=\"#\" onclick=\"delete_product_from_cart('$id',".$row['id'].",'$size')\">
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
                                            <a class=\"label\" href=\"\"
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
                                                                name=\"product-quantity-spin\" min='1' onchange=\"onChangeFunction(this.value, ".$row['cid'].")\"
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
function onChangeFunction(value, id) {
    $.ajax({
        url: 'ajax_call.php',
        method: 'post',
        data: {
            value: value,
            id: id,
        },
        success: (res) => {
            var json_arr = $.parseJSON(res);
            getCartDetails();
            $("#product" + id).html("₹ " + json_arr.updated_price)
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
            $("#product"+id+""+size+" strong").html("₹ " + json_arr.updated_price);
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

elseif (isset($_POST['value']) && $_POST['value'] > 0 && isset($_POST['id']) && $_POST['id'] > 0) {

    $value = get_safe_value($_POST['value']);
    $id = get_safe_value($_POST['id']);

   if (isset($_SESSION['UID'])) {
        $CartSql  = 'SELECT * FROM `cart` left JOIN product_details on cart.product_id = product_details.id  where cart.id = "'.$id.'"';
        $CartRes = mysqli_query($con, $CartSql);
        $Cartrow = mysqli_fetch_assoc($CartRes);

        // Gettng Product Price 

        $prod_price = $Cartrow['product_price'];
        $updated_price = $value * $prod_price;

        $UpdateSql = "Update cart set prod_price = '$updated_price', qty = '$value' where id = '$id'";
        mysqli_query($con, $UpdateSql);

        

   }else {
       $size = get_safe_value($_POST['size']);
       $curr_price = get_safe_value($_POST['curr_price']);
       $updated_price = $value * $curr_price;
       $_SESSION['cart'][$id.','.$size]['prod_qty'] = $value;
       $_SESSION['cart'][$id.','.$size]['prod_price'] = $updated_price;
   }

   $arr = array('updated_price' => $updated_price);
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




