<?php
require 'includes/session.php';
require('config.php');
include('smtp/PHPMailerAutoload.php');


$uid = $user['id'];
$sql = "SELECT *, cart.id as cid FROM `cart` left join product_details on cart.product_id = product_details.id where cart.user_id = '$uid'";
$result = mysqli_query($con , $sql);
$actual_price = "";
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $price_totals = $actual_price.",";
        $price_totals .= $row['product_price'] * $row['qty'];
        $price_total_arr = explode(",", $price_totals);
        $actual_price = array_sum($price_total_arr);
    }

    if($actual_price > 500) {
        $shipping_fee = 'Free';
        $actual_price = $actual_price;
        $total_payable = $actual_price;
    }else {
        $shipping_fee = 500;
        $actual_price = $actual_price + 500;
        $total_payable = ($actual_price + 500);
    }
}


// Required Varable to insert data in database
$order_id = 'ORD-'.rand(1111,9999);
$product_id = CalculateTotalProductBuying($user['id'])['product_id'];
$count_product = count(explode(',', $product_id));

$product_varient = CalculateTotalProductBuying($user['id'])['product_varient'];
$qtys = CalculateTotalProductBuying($user['id'])['qtys'];
$tracking_id = CalculateTotalProductBuying($user['id'])['track_id'];
$payment_prod_price = CalculateTotalProductBuying($user['id'])['product_price'];
$estimate_delivery_date = CalculateTotalProductBuying($user['id'])['estimate_dd'];
$delivery_address_id = $_SESSION['id_address_delivery'];
$getAddressById = getAddressById($delivery_address_id);
$address_html = '<strong>'.$getAddressById['add_firstname'].' '.$getAddressById['add_lastname'].'</strong><br>
'.$getAddressById['company'].'<br>
'.$getAddressById['address'].', '.$getAddressById['addres_complement'].'<br>
'.$getAddressById['city'].', '.$getAddressById['state'].'-'.$getAddressById['postal_code'].'<br>
'.$getAddressById['country'].' <br>
'.$getAddressById['phone_number'];

$pincode = $getAddressById['postal_code'];
$created = date("Y-m-d H:i:s");
$added_on = date("Y-m-d");


$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Email Template for Order Confirmation Email</title>
        
        <!-- Start Common CSS -->
        <style type="text/css">
            #outlook a {padding:0;}
            body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0; font-family: Helvetica, arial, sans-serif;}
            .ExternalClass {width:100%;}
            .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
            .backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
            .main-temp table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; font-family: Helvetica, arial, sans-serif;}
            .main-temp table td {border-collapse: collapse;}
        </style>
        <!-- End Common CSS -->
    </head>
    <body>
        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="backgroundTable main-temp" style="background-color: #d5d5d5;">
            <tbody>
                <tr>
                    <td>
                        <table width="600" align="center" cellpadding="15" cellspacing="0" border="0" class="devicewidth" style="background-color: #ffffff;">
                            <tbody>
                                <!-- Start header Section -->
                                <tr>
                                    <td style="padding-top: 30px;">
                                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #eeeeee; text-align: center;">
                                            <tbody>
                                                <tr>
                                                    <td style="padding-bottom: 10px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666;">
                                                        3828 Mall Road
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666;">
                                                        Los Angeles, California, 90017
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666;">
                                                        Phone: 310-807-6672 | Email: info@example.com
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 25px;">
                                                        <strong>Order Number:</strong> '.$order_id.' | <strong>Order Date:</strong> '.date("d M,Y H:i").' | <strong>Payment Mode:</strong> '.$_POST['btnname'].'
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!-- End header Section -->
                                
                                <!-- Start address Section -->
                                <tr>
                                    <td style="padding-top: 0;">
                                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #bbbbbb;">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 55%; font-size: 16px; font-weight: bold; color: #666666; padding-bottom: 5px;">
                                                        Store Address
                                                    </td>
                                                    <td style="width: 45%; font-size: 16px; font-weight: bold; color: #666666; padding-bottom: 5px;">
                                                        Delivery Address
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666;">
                                                        James C Painter
                                                    </td>
                                                    <td style="width: 45%; font-size: 14px; line-height: 18px; color: #666666;">
                                                        '.$getAddressById['add_firstname'].' '.$getAddressById['add_lastname'].'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666;">
                                                        3939  Charles Street, Farmington Hills
                                                    </td>
                                                    <td style="width: 45%; font-size: 14px; line-height: 18px; color: #666666;">
                                                        '.$getAddressById['company'].'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">
                                                        Michigan, 48335
                                                    </td>
                                                    <td style="width: 45%; font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">
                                                        '.$getAddressById['address'].', '.$getAddressById['addres_complement'].'<br>
                                                        '.$getAddressById['city'].', '.$getAddressById['state'].'-'.$getAddressById['postal_code'].'<br>
                                                        '.$getAddressById['country'].' <br>
                                                        '.$getAddressById['phone_number'].'
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!-- End address Section -->
                                ';

                                $product_ids = explode(',', $product_id);
                                array_unshift($product_ids,"");
                                unset($product_ids[0]);
            
                                foreach ($product_ids as $key => $value) {
            
                                    $sql = "SELECT * from product_details where id = '$value'";
                                    $res = mysqli_query($con , $sql);
                                    while ($row = mysqli_fetch_assoc($res)) {
                                    $ProductImageById = ProductImageById($row['id'], 'limit 1');
                                    array_unshift($ProductImageById,"");
                                    unset($ProductImageById[0]);

                                    $product_varients = explode(',', $product_varient);
                                    array_unshift($product_varients,"");
                                    unset($product_varients[0]);
                                    
                                    $quantity = explode(',', $qtys);
                                    array_unshift($quantity,"");
                                    unset($quantity[0]);
            
                            $html .= '
                                <!-- Start product Section -->
                                <tr>
                                    <td style="padding-top: 0;">
                                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #eeeeee;">
                                            <tbody>
                                                <tr>
                                                    <td rowspan="4" style="padding-right: 10px; padding-bottom: 10px;">
                                                    </td>
                                                    <td colspan="2" style="font-size: 14px; font-weight: bold; color: #666666; padding-bottom: 5px;">
                                                        '.$row['product_name'].'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; width: 440px;">
                                                        Quantity: '.$quantity[$key].'
                                                    </td>
                                                    <td style="width: 130px;">₹ '.$row['product_price'].' Per Unit</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575;">
                                                        Size: '.$product_varients[$key].'
                                                    </td>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; text-align: right;">
                                                        <b style="color: #666666;">₹ '.$quantity[$key] * $row['product_price'].'</b> Total                                                             
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                ';

                                    }
                                }
                             
                            $html .= '
                                <!-- End product Section -->
                                
                                <!-- Start calculation Section -->
                                <tr>
                                    <td style="padding-top: 0;">
                                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #bbbbbb; margin-top: -5px;">
                                            <tbody>
                                                <tr>
                                                    <td rowspan="5" style="width: 55%;"></td>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px; border-bottom: 1px solid #eeeeee;">
                                                        Shipping Fee:
                                                    </td>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px; border-bottom: 1px solid #eeeeee; text-align: right;">
                                                        ₹ '.$shipping_fee.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; padding-top: 10px;">
                                                        Order Total
                                                    </td>
                                                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; padding-top: 10px; text-align: right;">
                                                       ₹ '.number_format($actual_price).'
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!-- End calculation Section -->
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>';

if (isset($_POST['btnname']) && $_POST['btnname'] == 'stripe') {
    \Stripe\Stripe::setVerifySslCerts(false);
    
    $token=$_POST['stripeToken'];

    $data=\Stripe\Charge::create(array(
        "amount"=>$total_payable * 100,
        "currency"=>"inr",
        "description"=>"Programming with Shadab Desc",
        "source"=>$token,
    ));

        
    $card_brand  = $data['source']['brand'];
    $payment_country = $data['source']['country'];
    $payment_id = $data['id'];
    $payment_status = $data['status'];
    $receipt_url = $data['receipt_url'];
    $amount_captured = $data['amount_captured'];
    $payment_method = $data['payment_method'];
    $fingerprint = $data['source']['fingerprint'];
    $currency = $data['currency'];
    $created = date("Y-m-d H:i:s", $data['created']);
    $added_on = date("Y-m-d", $data['created']);
    $card_id = $data['source']['id'];


    if(isset($_POST['stripeToken'])){
        $response_mail = send_email($user['email'], $html, 'Order Confirmation');
        if ($response_mail == 'Sended') {
            // Increasing Total Sold Value in Product Details 
            $product_ids = explode(",", $product_id);
            $qty = explode(",", $qtys);
            $per_product_invoice = '';
            foreach($product_ids as $key => $val) {
                $Sql = "SELECT * FROM product_details WHERE id = '$val'"; // retrieving last stock from this query
                $resultant = mysqli_query($con, $Sql);
                $row = mysqli_fetch_assoc($resultant);
                
                $total_sold = $row['total_sold'] + $qty[$key];
                
                $UpdateSql = "UPDATE product_details set total_sold = '$total_sold' where id = ".$row['id']."";
                mysqli_query($con,$UpdateSql);

                // Adding By Default Comma to explode the invoice and add on index nvoice 
                $per_product_invoice .= ',';
            }

            $per_product_invoice_string_substr = substr($per_product_invoice,0,-1);

            $tracking_ids = explode(",", $tracking_id);
            foreach ($tracking_ids as $key => $value) {
                $track_user_id = $user['id'];
                $date= date("Y-m-d h:i:s");
                SqlQuery("INSERT into ordertrackingdetails(track_Order_id, track_id, track_product_id, delivery_to_pincode, track_type, product_user_id, Tracking_Name, Tracking_Details, Tracking_time, Current_Status) 
                            VALUES('$order_id','$value', '$product_ids[$key]','$pincode', 'Delivery','$track_user_id', 'Ordered,Shipped,Out for Delivery,Delivered', ',PS_FASHION_STORE,,PS_FASHION_STORE,,PS_FASHION_STORE,','$date,,,', 'Ordered,,,')");
            }
        
            $sql = "INSERT into payment_details(
                Order_Id,
                payment_user_id,
                product_id,
                product_varient,
                product_qty,
                payment_prod_price,
                estimate_delivery_date,
                delivery_charge,
                delivery_address_id,
                card_brand,
                payment_country,
                payment_id,
                payment_status,
                payment_mode,
                receipt_url,
                amount_captured,
                payment_method,
                fingerprint,
                currency,
                created,
                added_on,
                card_id,
                tracking_id,
                per_product_invoice) 
            
            VALUES(
                '$order_id',
                '$uid',
                '$product_id', 
                '$product_varient', 
                '$qtys',
                '$payment_prod_price',
                '$estimate_delivery_date',
                '$shipping_fee',
                '$address_html',
                '$card_brand', 
                '$payment_country',
                '$payment_id',
                '$payment_status',
                'stripe',
                '$receipt_url',
                '$actual_price',
                '$payment_method',
                '$fingerprint',
                '$currency', 
                '$created',
                '$added_on',
                '$card_id',
                '$tracking_id',
                '$per_product_invoice_string_substr'
                )";
        
            
            mysqli_query($con, $sql);

            $DeleteCart = "DELETE FROM cart where user_id = '".$user['id']."'";
            mysqli_query($con, $DeleteCart);
            unset($_SESSION['id_address_delivery']);
            redirect(FRONT_SITE_PATH.'Invoices?orderId='.$order_id);
        }
    }
}
elseif (isset($_POST['btnname']) && $_POST['btnname'] == 'wallet') {
    $response_mail = 'Sended';
    if ($response_mail == 'Sended') {
        // Increasing Total Sold Value in Product Details 
        $product_ids = explode(",", $product_id);
        $qty = explode(",", $qtys);
        $per_product_invoice = '';
        foreach($product_ids as $key => $val) {
            $Sql = "SELECT * FROM product_details WHERE id = '$val'"; // retrieving last stock from this query
            $resultant = mysqli_query($con, $Sql);
            $row = mysqli_fetch_assoc($resultant);
            
            $total_sold = $row['total_sold'] + $qty[$key];
            
            $UpdateSql = "UPDATE product_details set total_sold = '$total_sold' where id = ".$row['id']."";
            mysqli_query($con,$UpdateSql);

            // Adding By Default Comma to explode the invoice and add on index nvoice 
            $per_product_invoice .= ',';
        }

        $per_product_invoice_string_substr = substr($per_product_invoice,0,-1);

        $tracking_ids = explode(",", $tracking_id);
        foreach ($tracking_ids as $key => $value) {
            $track_user_id = $user['id'];
            $date= date("Y-m-d h:i:s");
            SqlQuery("INSERT into ordertrackingdetails(track_Order_id, track_id, track_product_id, delivery_to_pincode, track_type, product_user_id, Tracking_Name, Tracking_Details, Tracking_time, Current_Status) 
                        VALUES('$order_id','$value', '$product_ids[$key]','$pincode', 'Delivery','$track_user_id', 'Ordered,Shipped,Out for Delivery,Delivered', ',PS_FASHION_STORE,,PS_FASHION_STORE,,PS_FASHION_STORE,','$date,,,', 'Ordered,,,')");
        }
    
        $sql = "INSERT into payment_details(
            Order_Id,
            payment_user_id,
            product_id,
            product_varient,
            product_qty,
            payment_prod_price,
            estimate_delivery_date,
            delivery_charge,
            delivery_address_id,
            payment_status,
            payment_mode,
            amount_captured,
            currency,
            created,
            added_on,
            tracking_id,
            per_product_invoice) 
        
        VALUES(
            '$order_id',
            '$uid',
            '$product_id', 
            '$product_varient', 
            '$qtys',
            '$payment_prod_price',
            '$estimate_delivery_date',
            '$shipping_fee',
            '$address_html',
            'succeeded',
            'wallet',
            '$actual_price',
            'inr', 
            '$created',
            '$added_on',
            '$tracking_id',
            '$per_product_invoice_string_substr'
            )";
    
        
        mysqli_query($con, $sql);
        ManageWallet("insert",$user['id'],"-".$actual_price,'₹'.$actual_price." Debited From Your Wallet for Shopping..",date("Y-m-d H:i:s"),'out');
        $DeleteCart = "DELETE FROM cart where user_id = '".$user['id']."'";
        mysqli_query($con, $DeleteCart);
        unset($_SESSION['id_address_delivery']);
        redirect(FRONT_SITE_PATH.'Invoices?orderId='.$order_id);
    }
}


?>