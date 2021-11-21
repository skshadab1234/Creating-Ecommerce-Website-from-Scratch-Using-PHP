<?php
require 'includes/session.php';
require('vendor/autoload.php');

if (isset($_GET['orderId']) && $_GET['orderId'] != '') {
    
    $order_id = get_safe_value($_GET['orderId']);

    $Sql = "SELECT * FROM payment_details WHERE Order_Id = '$order_id'";
    $res = mysqli_query($con, $Sql);
    $row = mysqli_fetch_assoc($res);

    $product_id = $row['product_id'];

    if ($row['delivery_charge'] == 'Free') {
        $subtotal = '<span>'.$row['amount_captured'].'</span>';
    }else{
        // if delivery charge is free then don;t remove 500rs in subtotal 
        $subtotal = $row['amount_captured'] - 500;
    }

    if ($row['delivery_charge'] == 'Free') {
        $shipping_fee = '<span style="color:green">Free</span>';
    }else{
        $shipping_fee = "₹ 500";
    }

    if ($row['payment_status'] == 'succeeded') {
        $payment_status = 'Paid';
    }else{
        $payment_status = "Not paid";
    }

    
    $html = '
        <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="icon" type="image/vnd.microsoft.icon" href="'.FRONT_SITE_PATH.'logo.png">
                <link rel="shortcut icon" type="image/x-icon" href="'.FRONT_SITE_PATH.'logo.png">
                <title>Invoice-'.$row['id'].'</title>
                <style>
                    body{
                        background-color: #F6F6F6; 
                        margin: 0;
                        padding: 0;
                    }
                    h1,h2,h3,h4,h5,h6{
                        margin: 0;
                        padding: 0;
                    }
                    p{
                        margin: 0;
                        padding: 0;
                    }
                    .container{
                        width: 100%;
                        margin-right: auto;
                        margin-left: auto;
                    }
                    .logo{
                        width: 50%;
                    }

                    .row{
                        display: flex;
                        flex-wrap: wrap;
                    }
                    .col-6{
                        width: 50%;
                        flex: 0 0 auto;
                    }
                    .text-white{
                        color: #fff;
                    }
                    .company-details{
                        float: right;
                        text-align: right;
                    }
                    .body-section{
                        padding: 16px;
                        border: 1px solid gray;
                    }
                    .heading{
                        font-size: 20px;
                        margin-bottom: 08px;
                    }
                    .sub-heading{
                        color: #262626;
                        margin-bottom: 05px;
                    }
                    table{
                        background-color: #fff;
                        width: 100%;
                        border-collapse: collapse;
                    }
                    table thead tr{
                        border: 1px solid #111;
                        background-color: #f2f2f2;
                    }
                    table td {
                        vertical-align: middle !important;
                        text-align: center;
                    }
                    table th, table td {
                        padding-top: 08px;
                        padding-bottom: 08px;
                    }
                    .table-bordered{
                        box-shadow: 0px 0px 5px 0.5px gray;
                    }
                    .table-bordered td, .table-bordered th {
                        border: 1px solid #dee2e6;
                    }
                    .text-right{
                        text-align: end;
                    }
                    .w-20{
                        width: 20%;
                    }
                    .float-right{
                        float: right;
                    }
                </style>
            </head>
            <body>

                <div class="">
                    <div class="brand-section">
                    <table style="background:none;color:#fff">
                    <thead>
                        <tr style="border:none;background:none">
                            <th> </th>
                            <th> </th>
                            <th> </th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr >
                            <td width="10%">
                                <img src="'.FRONT_SITE_PATH.'logo.png'.'" width="50px">
                            </td>
                            <td width="80%"><h2 style="color:#212121"> '.SITE_NAME.'</h2></td>
                            <td></td>   
                            <td></td>   
                        </tr>
                    </tbody>
                    </table>
                    </div>

                    <div class="body-section">
                    <table>
                        <thead>
                            <tr style="border:none;background:none">
                                <th> </th>
                                <th> </th>
                                <th> </th>
                                <th> </th>
                            </tr>
                        </thead>
                    <tbody>
                        <tr>
                            <td  width="40%">
                            <h3 class="heading">Invoice No.: #'.$row['id'].'</h3>
                            <p class="sub-heading">Order Date: '.date("d M,Y", strtotime($row['created'])).' </p>
                            <p class="sub-heading">Email Address: '.COMPANY_EMAIL.' </p>
                            </td>
                            <td></td>
                            <td></td>  
                            <td  width="40%">
                                <address>
                                    '.$row['delivery_address_id'].'
                                </address>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                    </div>

                    <div class="body-section">
                        <h3 class="heading">Ordered Items</h3>
                        <br>
                        <table class="table-bordered">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th class="w-20">Price</th>
                                    <th class="w-20">Quantity</th>
                                    <th class="w-20">Grandtotal</th>
                                </tr>
                            </thead>
                            <tbody>';
                            
                            $product_ids = explode(',', $product_id);
                            array_unshift($product_ids,"");
                            unset($product_ids[0]);

                            foreach ($product_ids as $key => $value) {

                                $sql = "SELECT * from product_details where id = '$value'";
                                $res = mysqli_query($con , $sql);
                                while ($rows = mysqli_fetch_assoc($res)) {
                                    $ProductImageById = ProductImageById($rows['id'],"limit 1");
                                    array_unshift($ProductImageById,"");
                                    unset($ProductImageById[0]);

                                    $product_varients = explode(',', $row['product_varient']);
                                    array_unshift($product_varients,"");
                                    unset($product_varients[0]);

                                    
                                    $quantity = explode(',', $row['product_qty']);
                                    array_unshift($quantity,"");
                                    unset($quantity[0]);

                                    $payment_prod_price = explode(',', $row['payment_prod_price']);
                                    array_unshift($payment_prod_price,"");
                                    unset($payment_prod_price[0]);

                                $html .=  '<tr>
                                                <td> <img class="img-fluid" width="200px" height="200px"
                                                src="'.FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'].'" style="width: 80px;height: 80px;border-radius: 10px;" alt=""
                                                title="" itemprop="image"></td>
                                                <td>'.$rows['product_name'].' ('.$product_varients[$key].')</td>
                                                <td>₹ '.$rows['product_price'].'</td>
                                                <td>'.$quantity[$key].'</td>
                                                <td>₹ '.$quantity[$key] * $payment_prod_price[$key].'</td>
                                            </tr>
                                ';
                                    }
                                }
                            $html .= '
                            <tr>
                                <td colspan="4" class="text-right">Sub Total</td>
                                <td>₹ '.$subtotal.'</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">Shipping Fees</td>
                                <td> '.$shipping_fee.'</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">Grand Total</td>
                                <td>₹ '.$row['amount_captured'] .'</td>
                            </tr>
                        </tbody>
                        </table>
                        <br>
                        <h3 class="heading">Payment Status: '.$payment_status.'</h3>
                    </div>

                    <div class="body-section">
                    <table>
                    <tbody>
                        <tr>
                            <td>&copy; Copyright '.date('Y').' - '.SITE_NAME.'. All rights reserved. </td>
                            <td ><a href="'.FRONT_SITE_PATH.'" class="float-right">'.FRONT_SITE_PATH.'</a></td>
                        </tr>
                    </tbody>
                    </table>
                    </div>      
                </div>      

            </body>
        </html>
    ';

    // echo $html;
    $mpdf=new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    $file='UserInvoice/Invoice-'.$row['id'].'-PS.pdf';
    $file_store = 'Invoice-'.$row['id'].'-PS.pdf';
    $mpdf->output($file,'F');

    mysqli_query($con, "UPDATE payment_details set invoice_file='$file_store' WHERE Order_Id='$order_id'");
    //D
    //I
    //F
    //S
    
    if (isset($_GET['redirect']) && $_GET['redirect'] != '') {
        $redriect = get_safe_value($_GET['redirect']);
    }else{
        $redriect = FRONT_SITE_PATH.'order-confirmation?orderId='.$order_id;
    }

    redirect($redriect);
}

elseif (isset($_POST['ProductOrderId']) && $_POST['ProductOrderId'] != '' && isset($_POST['pid']) && $_POST['pid'] != '') {
    $order_id = get_safe_value($_POST['ProductOrderId']);
    $product_id = get_safe_value($_POST['pid']);
    $product_qty = get_Safe_value($_POST['qty_key']);
    $size = get_Safe_value($_POST['prd_varint_key']);
    $price = get_Safe_value($_POST['payment_prod_price']);
    $redirect = get_safe_value($_POST['redirect']);

    $filename = basename($_POST['filename']);
    $filepath = "UserInvoice/Per_Product_Invoice/".$filename;
	if(!empty($filename) && file_exists($filepath)){
        $urltosend = FRONT_SITE_PATH."download?filename=".$filename."&filepath=UserInvoice/Per_Product_Invoice/".$filename.'&redirect='.$redirect;
        $arr = array('sendto' => $urltosend);
	}
	else{
		$Sql = "SELECT * FROM payment_details WHERE Order_Id = '$order_id'";
        $res = mysqli_query($con, $Sql);
        $row = mysqli_fetch_assoc($res);

        if ($row['delivery_charge'] == 'Free') {
            $shipping_fee = '<span style="color:green">Free</span>';
        }else{
            $shipping_fee = "-";
        }

        if ($row['payment_status'] == 'succeeded') {
            $payment_status = 'Paid';
        }else{
            $payment_status = "Not paid";
        }

        $html = '
            <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="icon" type="image/vnd.microsoft.icon" href="'.FRONT_SITE_PATH.'logo.png">
                    <link rel="shortcut icon" type="image/x-icon" href="'.FRONT_SITE_PATH.'logo.png">
                    <title>Invoice-P'.$product_id.''.$size.''.$product_qty.'-PS</title>
                    <style>
                        body{
                            background-color: #F6F6F6; 
                            margin: 0;
                            padding: 0;
                        }
                        h1,h2,h3,h4,h5,h6{
                            margin: 0;
                            padding: 0;
                        }
                        p{
                            margin: 0;
                            padding: 0;
                        }
                        .container{
                            width: 100%;
                            margin-right: auto;
                            margin-left: auto;
                        }
                        .logo{
                            width: 50%;
                        }

                        .row{
                            display: flex;
                            flex-wrap: wrap;
                        }
                        .col-6{
                            width: 50%;
                            flex: 0 0 auto;
                        }
                        .text-white{
                            color: #fff;
                        }
                        .company-details{
                            float: right;
                            text-align: right;
                        }
                        .body-section{
                            padding: 16px;
                            border: 1px solid gray;
                        }
                        .heading{
                            font-size: 20px;
                            margin-bottom: 08px;
                        }
                        .sub-heading{
                            color: #262626;
                            margin-bottom: 05px;
                        }
                        table{
                            background-color: #fff;
                            width: 100%;
                            border-collapse: collapse;
                        }
                        table thead tr{
                            border: 1px solid #111;
                            background-color: #f2f2f2;
                        }
                        table td {
                            vertical-align: middle !important;
                            text-align: center;
                        }
                        table th, table td {
                            padding-top: 08px;
                            padding-bottom: 08px;
                        }
                        .table-bordered{
                            box-shadow: 0px 0px 5px 0.5px gray;
                        }
                        .table-bordered td, .table-bordered th {
                            border: 1px solid #dee2e6;
                        }
                        .text-right{
                            text-align: end;
                        }
                        .w-20{
                            width: 20%;
                        }
                        .float-right{
                            float: right;
                        }
                    </style>
                </head>
                <body>

                    <div class="">
                        <div class="brand-section">
                        <table style="background:none;color:#fff">
                        <thead>
                            <tr style="border:none;background:none">
                                <th> </th>
                                <th> </th>
                                <th> </th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr >
                                <td width="10%">
                                    <img src="'.FRONT_SITE_PATH.'logo.png'.'" width="50px">
                                </td>
                                <td width="80%"><h2 style="color:#212121"> '.SITE_NAME.'</h2></td>
                                <td></td>   
                                <td></td>   
                            </tr>
                        </tbody>
                        </table>
                        </div>

                        <div class="body-section">
                        <table>
                            <thead>
                                <tr style="border:none;background:none">
                                    <th> </th>
                                    <th> </th>
                                    <th> </th>
                                    <th> </th>
                                </tr>
                            </thead>
                        <tbody>
                            <tr>
                                <td  width="40%">
                                <h3 class="heading">Invoice No.: #P'.$product_id.''.$size.''.$product_qty.'-PS</h3>
                                <p class="sub-heading">Order Date: '.date("d M,Y", strtotime($row['created'])).' </p>
                                <p class="sub-heading">Email Address: '.COMPANY_EMAIL.' </p>
                                </td>
                                <td></td>
                                <td></td>  
                                <td  width="40%">
                                    <address>
                                        '.$row['delivery_address_id'].'
                                    </address>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                        </div>

                        <div class="body-section">
                            <h3 class="heading">Ordered Items</h3>
                            <br>
                            <table class="table-bordered">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product</th>
                                        <th class="w-20">Price</th>
                                        <th class="w-20">Quantity</th>
                                        <th class="w-20">Grandtotal</th>
                                        </tr>
                                </thead>
                                <tbody>';
                                

                                    $sql = "SELECT * from product_details where id = '$product_id'";
                                    $res = mysqli_query($con , $sql);
                                    $rows = mysqli_fetch_assoc($res);
                                
                                    $ProductImageById = ProductImageById($rows['id'],"limit 1");
                                    array_unshift($ProductImageById,"");
                                    unset($ProductImageById[0]);

                                $html .= '
                                        <tr>
                                            <td> <img class="img-fluid" width="200px" height="200px"
                                            src="'.FRONT_SITE_IMAGE_PRODUCT.$ProductImageById[1]['product_img'].'" style="width: 80px;height: 80px;border-radius: 10px;" alt=""
                                            title="" itemprop="image"></td>
                                            <td>'.$rows['product_name'].' ('.$size.')</td>
                                            <td>₹ '.$price.'</td>
                                            <td>'.$product_qty.'</td>
                                            <td>₹ '.$product_qty * $price.'</td>
                                        </tr>
                                <tr>
                                    <td colspan="4" class="text-right">Shipping Fees</td>
                                    <td> '.$shipping_fee.'</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right">Grand Total</td>
                                    <td>₹ '.$product_qty * $price .'</td>
                                </tr>
                            </tbody>
                            </table>
                            <br>
                            <h3 class="heading">Payment Status: '.$payment_status.'</h3>
                        </div>

                        <div class="body-section">
                        <table>
                        <tbody>
                            <tr>
                                <td>&copy; Copyright '.date('Y').' - '.SITE_NAME.'. All rights reserved. </td>
                                <td ><a href="'.FRONT_SITE_PATH.'" class="float-right">'.FRONT_SITE_PATH.'</a></td>
                            </tr>
                        </tbody>
                        </table>
                        </div>      
                    </div>      

                </body>
            </html>
        ';

        // echo $html;
        $mpdf=new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $file='UserInvoice/Per_Product_Invoice/Invoice-P'.$product_id.''.$size.''.$product_qty.'-PS.pdf';
        $file_store = 'Invoice-P'.$product_id.''.$size.''.$product_qty.'-PS.pdf';
        $mpdf->output($file,'F');
        
        $per_product_invoice  = explode(",",$row['per_product_invoice']);
        $p_KEY = explode(",",$row['product_id']);
        $p_key_search = array_search($product_id,$p_KEY);
        
        $per_product_invoice[$p_key_search] = $file_store.',';
        
        $per_product_invoice_string = implode(",", $per_product_invoice);
        // $per_product_invoice_string_substr = substr($per_product_invoice_string,0,-1);
        mysqli_query($con, "UPDATE payment_details set per_product_invoice='$per_product_invoice_string' WHERE Order_Id='$order_id'");
        
        $urltosend = FRONT_SITE_PATH.'download?filename='.$file_store.'&filepath='.$file.'&redirect='.$redirect;
        $arr = array('sendto' => $urltosend);
	}
    echo json_encode($arr);
    
}
