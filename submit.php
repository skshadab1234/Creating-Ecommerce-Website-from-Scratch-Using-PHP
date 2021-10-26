<?php
require 'includes/session.php';
require('config.php');
include('smtp/PHPMailerAutoload.php');


if(isset($_POST['stripeToken'])){
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
		$total_payable = $actual_price * 10000;
    }else {
        $shipping_fee = 500;
        $actual_price = $actual_price + 500;
		$total_payable = ($actual_price + 500) * 10000;
    }
}   
      
	\Stripe\Stripe::setVerifySslCerts(false);

	$token=$_POST['stripeToken'];

	$data=\Stripe\Charge::create(array(
		"amount"=>$total_payable  / 100,
		"currency"=>"inr",
		"description"=>"Programming with Shadab Desc",
		"source"=>$token,
	));


	// Required Varable to insert data in database
	$order_id = 'ORD-'.rand(1111,9999);
	$product_id = CalculateTotalProductBuying($user['id'])['product_id'];
	$count_product = count(explode(',', $product_id));

	$product_varient = CalculateTotalProductBuying($user['id'])['product_varient'];
	$qtys = CalculateTotalProductBuying($user['id'])['qtys'];
	$delivery_address_id = $_SESSION['id_address_delivery'];
	$card_brand  = $data['source']['brand'];
	$payment_country = $data['source']['country'];
	$payment_id = $data['id'];
	$payment_status = $data['status'];
	$receipt_url = $data['receipt_url'];
	$amount_captured = $data['amount_captured'];
	$payment_method = $data['payment_method'];
	$fingerprint = $data['source']['fingerprint'];
	$currency = $data['currency'];
	$created = date("Y-m-d h:i:s", $data['created']);
    $added_on = date("Y-m-d", $data['created']);
	$card_id = $data['source']['id'];

    // Increaing Total Sold Value in Product Details 
    $product_ids = explode(",", $product_id);
    $qty = explode(",", $qtys);
    foreach($product_ids as $key => $val) {
        $Sql = "SELECT * FROM product_details WHERE id = '$val'"; // retrieving last stock from this query
        $resultant = mysqli_query($con, $Sql);
        $row = mysqli_fetch_assoc($resultant);
        
        $total_sold = $row['total_sold'] + $qty[$key];
        
        $UpdateSql = "UPDATE product_details set total_sold = '$total_sold' where id = ".$row['id']."";
        mysqli_query($con,$UpdateSql);
        
    }

	$sql = "INSERT into payment_details(
		Order_Id,
		payment_user_id,
		product_id,
		product_varient,
		product_qty,
        delivery_charge,
		delivery_address_id,
		card_brand,
		payment_country,
		payment_id,
		payment_status,
		receipt_url,
		amount_captured,
		payment_method,
		fingerprint,
		currency,
		created,
        added_on,
		card_id) 
	
	VALUES(
		'$order_id',
		'$uid',
		'$product_id', 
		'$product_varient', 
		'$qtys',
        '$shipping_fee',
		'$delivery_address_id',
		'$card_brand', 
		'$payment_country',
		'$payment_id',
		'$payment_status',
		'$receipt_url',
		'$actual_price',
		'$payment_method',
		'$fingerprint',
		'$currency', 
		'$created',
        '$added_on',
		'$card_id'
		)";

	mysqli_query($con, $sql);

	$html = '<!DOCTYPE HTML
				PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
				xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>

    <style type="text/css">
		a {
			color: #0000ee;
			text-decoration: underline;
		}

		@media (max-width: 480px) {
			#u_content_menu_1 .v-padding {
				padding: 5px 15px !important;
			}
		}

		@media only screen and (min-width: 660px) {
			.u-row {
				width: 640px !important;
			}

			.u-row .u-col {
				vertical-align: top;
			}

			.u-row .u-col-50 {
				width: 320px !important;
			}

			.u-row .u-col-100 {
				width: 640px !important;
			}

		}

		@media (max-width: 660px) {
			.u-row-container {
				max-width: 100% !important;
				padding-left: 0px !important;
				padding-right: 0px !important;
			}

			.u-row .u-col {
				min-width: 320px !important;
				max-width: 100% !important;
				display: block !important;
			}

			.u-row {
				width: calc(100% - 40px) !important;
			}

			.u-col {
				width: 100% !important;
			}

			.u-col>div {
				margin: 0 auto;
			}
		}

		body {
			margin: 0;
			padding: 0;
		}

		table,
		tr,
		td {
			vertical-align: top;
			border-collapse: collapse;
		}

		p {
			margin: 0;
		}

		.ie-container table,
		.mso-container table {
			table-layout: fixed;
		}

		* {
			line-height: inherit;
		}
    </style>
</head>
<body class="clean-body" style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #e7e7e7">
    <table
        style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #e7e7e7;width:100%"
        cellpadding="0" cellspacing="0">
        <tbody>
            <tr style="vertical-align: top">
                <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color: #e7e7e7;"><![endif]-->


                    <div class="u-row-container" style="padding: 0px;background-color: transparent">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 640px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px;"><tr style="background-color: #ffffff;"><![endif]-->

                                <!--[if (mso)|(IE)]><td align="center" width="640" style="width: 640px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
                                <div class="u-col u-col-100"
                                    style="max-width: 320px;min-width: 640px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                                            <!--<![endif]-->

                                            <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:30px 10px;font-family:arial,helvetica,sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #000000; line-height: 140%; text-align: left; word-wrap: break-word;">
                                                                <p
                                                                    style="font-size: 14px; line-height: 140%; text-align: center;">
                                                                    <span
                                                                        style="font-size: 26px; line-height: 36.4px;"><strong><span
                                                                                style="color: #545454; line-height: 36.4px; font-family: \'times new roman\', times; font-size: 26px;"><span
                                                                                    style="line-height: 36.4px; font-size: 26px;">Order
                                                                                    Confirmation</span></span></strong></span>
                                                                </p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td><![endif]-->
                                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <div class="u-row-container" style="padding: 0px;background-color: transparent">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 640px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px;"><tr style="background-color: #ffffff;"><![endif]-->

                                <!--[if (mso)|(IE)]><td align="center" width="640" style="width: 640px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
                                <div class="u-col u-col-100"
                                    style="max-width: 320px;min-width: 640px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                                            <!--<![endif]-->

                                            <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #000000; line-height: 160%; text-align: left; word-wrap: break-word;">
                                                                <p
                                                                    style="font-size: 14px; line-height: 160%; text-align: center;">
                                                                    <span
                                                                        style="font-size: 18px; line-height: 28.8px; color: #545454;"><strong>Hey
                                                                            '.$user['firstname'].'
                                                                            '.$user['lastname'].',</strong></span><br /><span
                                                                        style="font-size: 18px; line-height: 28.8px; color: #545454;"><strong>We\'ve
                                                                            got your order! Your world is about to look
                                                                            a whole lot
                                                                            better.</strong></span><br /><span
                                                                        style="font-size: 18px; line-height: 28.8px; color: #545454;"><strong>We\'ll
                                                                            drop you another email when your
                                                                            ships</strong></span>
                                                                </p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td><![endif]-->
                                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <div class="u-row-container" style="padding: 0px;background-color: transparent">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 640px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px;"><tr style="background-color: #ffffff;"><![endif]-->

                                <!--[if (mso)|(IE)]><td align="center" width="640" style="width: 640px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
                                <div class="u-col u-col-100"
                                    style="max-width: 320px;min-width: 640px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                                            <!--<![endif]-->

                                            <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:30px 10px;font-family:arial,helvetica,sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #000000; line-height: 140%; text-align: left; word-wrap: break-word;">
                                                                <p
                                                                    style="font-size: 14px; line-height: 140%; text-align: center;">
                                                                    <strong><span
                                                                            style="color: #545454; font-size: 20px; line-height: 28px;">ORDER
                                                                            ID :&nbsp;'.$order_id.'</span></strong>
                                                                </p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td><![endif]-->
                                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <div class="u-row-container" style="padding: 0px;background-color: transparent">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 640px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px;"><tr style="background-color: #ffffff;"><![endif]-->

                                <!--[if (mso)|(IE)]><td align="center" width="640" style="width: 640px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
                                <div class="u-col u-col-100"
                                    style="max-width: 320px;min-width: 640px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                                            <!--<![endif]-->

                                            <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:10px 10px 10px 20px;font-family:arial,helvetica,sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #000000; line-height: 140%; text-align: left; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 140%;"><span
                                                                        style="color: #c1c1c1; font-size: 14px; line-height: 19.6px;"><strong><span
                                                                                style="font-size: 18px; line-height: 25.2px;">ITEMS
                                                                                ORDERED</span></strong></span></p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td><![endif]-->
                                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <div class="u-row-container" style="padding: 0px;background-color: transparent">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 640px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px;"><tr style="background-color: #ffffff;"><![endif]-->

                                <!--[if (mso)|(IE)]><td align="center" width="640" style="width: 640px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
                                <div class="u-col u-col-100"
                                    style="max-width: 320px;min-width: 640px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                                            <!--<![endif]-->

                                            <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                                            align="left">

                                                            <table height="0px" align="center" border="0"
                                                                cellpadding="0" cellspacing="0" width="100%"
                                                                style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 2px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                <tbody>
                                                                    <tr style="vertical-align: top">
                                                                        <td
                                                                            style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                            <span>&#160;</span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td><![endif]-->
                                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
	';
	
		$product_ids = explode(',', $product_id);
		array_unshift($product_ids,"");
		unset($product_ids[0]);

		foreach ($product_ids as $key => $value) {

			$sql = "SELECT * from product_details where id = '$value'";
			$res = mysqli_query($con , $sql);
			while ($row = mysqli_fetch_assoc($res)) {
					
			
		

		$product_varients = explode(',', $product_varient);
		array_unshift($product_varients,"");
		unset($product_varients[0]);

		
		$quantity = explode(',', $qtys);
		array_unshift($quantity,"");
		unset($quantity[0]);


		$html .= '
		<div class="u-row-container ps_products"  style="padding: 0px;background-color: transparent">
                        <div class="u-row"
                            style="Margin: 0 auto;min-width: 320px;max-width: 640px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
                                <div class="u-col u-col-50"
                                    style="max-width: 320px;min-width: 320px;display: table-cell;vertical-align: top;">
                                    <div style="width: 100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div
                                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                                            <!--<![endif]-->

                                            <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:50px 20px;font-family:arial,helvetica,sans-serif;"
                                                            align="left">

                                                            <div
                                                                style="color: #000000; line-height: 140%; text-align: left; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 140%;"><span
                                                                        style="font-size: 16px; line-height: 22.4px;"><strong><span
                                                                                style="color: #545454; line-height: 22.4px; font-size: 16px;">'.$row['product_name'].'<br>
                                                                                x '.$quantity[$key].'
                                                                                <br>
                                                                                ₹ '.$quantity[$key] * $row['product_price'].'</span></strong></span>
                                                                </p>
                                                                <p style="font-size: 14px; line-height: 140%;"><span
                                                                        style="font-size: 16px; line-height: 22.4px;"><strong><span
                                                                                style="color: #c1c1c1; line-height: 22.4px; font-size: 16px;">Size : '.$product_varients[$key].'</span></strong></span>
                                                                </p>
                                                            </div>

                                                        </td>
                                                    </tr>

                        </td>
                        </tr>
                        </tbody>
                        </table>


                        <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                        </div>
                        </div>
                        <!--[if (mso)|(IE)]></td><![endif]-->
                        <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                        </div>
                        </div>
                    </div>
	';

}             
		}


$html .= '<div class="u-row-container" style="padding: 0px;background-color: transparent">
			<div class="u-row"
				style="Margin: 0 auto;min-width: 320px;max-width: 640px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
				<div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
					<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px;"><tr style="background-color: #ffffff;"><![endif]-->

					<!--[if (mso)|(IE)]><td align="center" width="640" style="width: 640px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
					<div class="u-col u-col-100"
						style="max-width: 320px;min-width: 640px;display: table-cell;vertical-align: top;">
						<div style="width: 100% !important;">
							<!--[if (!mso)&(!IE)]><!-->
							<div
								style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
								<!--<![endif]-->

								<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0"
									cellspacing="0" width="100%" border="0">
									<tbody>
										<tr>
											<td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
												align="left">

												<table height="0px" align="center" border="0" cellpadding="0"
													cellspacing="0" width="100%"
													style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
													<tbody>
														<tr style="vertical-align: top">
															<td
																style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
																<span>&#160;</span>
															</td>
														</tr>
													</tbody>
												</table>

											</td>
										</tr>
									</tbody>
								</table>

								<!--[if (!mso)&(!IE)]><!-->
							</div>
							<!--<![endif]-->
						</div>
					</div>
					<!--[if (mso)|(IE)]></td><![endif]-->
					<!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
				</div>
			</div>
    	</div>



    <div class="u-row-container" style="padding: 0px;background-color: transparent">
        <div class="u-row"
            style="Margin: 0 auto;min-width: 320px;max-width: 640px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px;"><tr style="background-color: #ffffff;"><![endif]-->

                <!--[if (mso)|(IE)]><td align="center" width="640" style="width: 640px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
                <div class="u-col u-col-100"
                    style="max-width: 320px;min-width: 640px;display: table-cell;vertical-align: top;">
                    <div style="width: 100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div
                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                            <!--<![endif]-->

                            <table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0"
                                cellspacing="0" width="100%" border="0">
                                <tbody>
                                    <tr>
                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:10px 45px 10px 10px;font-family:arial,helvetica,sans-serif;"
                                            align="left">

                                            <div
                                                style="color: #000000; line-height: 140%; text-align: left; word-wrap: break-word;">
                                                <p style="font-size: 14px; line-height: 140%; text-align: right;"><span
                                                        style="font-size: 16px; line-height: 22.4px;">Shipping Fee &nbsp;
                                                        &nbsp; &nbsp; &nbsp;&nbsp;<span style="color:green">'.$shipping_fee.'</span></span></p>
                                            </div>
                                            <div
                                                style="color: #000000; line-height: 140%; text-align: left; word-wrap: break-word;">
                                                <p style="font-size: 14px; line-height: 140%; text-align: right;"><span
                                                        style="font-size: 16px; line-height: 22.4px;">Total &nbsp;
                                                        &nbsp; &nbsp; &nbsp;&nbsp;₹ '.$actual_price.'</span></p>
                                            </div>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td><![endif]-->
                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
            </div>
        </div>
    </div>



    <div class="u-row-container" style="padding: 0px;background-color: transparent">
        <div class="u-row"
            style="Margin: 0 auto;min-width: 320px;max-width: 640px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px;"><tr style="background-color: #ffffff;"><![endif]-->

                <!--[if (mso)|(IE)]><td align="center" width="640" style="width: 640px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
                <div class="u-col u-col-100"
                    style="max-width: 320px;min-width: 640px;display: table-cell;vertical-align: top;">
                    <div style="width: 100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div
                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                            <!--<![endif]-->

                            <table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0"
                                cellspacing="0" width="100%" border="0">
                                <tbody>
                                    <tr>
                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:10px 10px 20px;font-family:arial,helvetica,sans-serif;"
                                            align="left">

                                            <table height="0px" align="center" border="0" cellpadding="0"
                                                cellspacing="0" width="100%"
                                                style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                <tbody>
                                                    <tr style="vertical-align: top">
                                                        <td
                                                            style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                            <span>&#160;</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td><![endif]-->
                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
            </div>
        </div>
    </div>



    <div class="u-row-container" style="padding: 0px;background-color: transparent">
        <div class="u-row"
            style="Margin: 0 auto;min-width: 320px;max-width: 640px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px;"><tr style="background-color: #ffffff;"><![endif]-->

                <!--[if (mso)|(IE)]><td align="center" width="640" style="width: 640px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
                <div class="u-col u-col-100"
                    style="max-width: 320px;min-width: 640px;display: table-cell;vertical-align: top;">
                    <div style="width: 100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div
                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                            <!--<![endif]-->

                            <table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0"
                                cellspacing="0" width="100%" border="0">
                                <tbody>
                                    <tr>
                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:20px 10px;font-family:arial,helvetica,sans-serif;"
                                            align="left">

                                            <div
                                                style="color: #000000; line-height: 160%; text-align: left; word-wrap: break-word;">
                                                <p style="font-size: 14px; line-height: 160%; text-align: center;"><span
                                                        style="color: #6c6c6c; font-size: 14px; line-height: 22.4px;"><strong><span
                                                                style="font-size: 16px; line-height: 25.6px;">If you
                                                                need help with anything please don\'t hesitate to drop
                                                                us an</span></strong></span><br />
													<span style="color: #6c6c6c; font-size: 14px; line-height: 22.4px;"><strong><span
                                                                style="font-size: 16px; line-height: 25.6px;">ks615044@gmail.com</span></strong></span></p>
                                            </div>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td><![endif]-->
                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
            </div>
        </div>
    </div>



    <div class="u-row-container" style="padding: 0px;background-color: transparent">
        <div class="u-row"
            style="Margin: 0 auto;min-width: 320px;max-width: 640px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px;"><tr style="background-color: #ffffff;"><![endif]-->

                <!--[if (mso)|(IE)]><td align="center" width="640" style="width: 640px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
                <div class="u-col u-col-100"
                    style="max-width: 320px;min-width: 640px;display: table-cell;vertical-align: top;">
                    <div style="width: 100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div
                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                            <!--<![endif]-->

                            <table id="u_content_menu_1" style="font-family:arial,helvetica,sans-serif;"
                                role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                                <tbody>
                                    <tr>
                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:20px 10px 10px;font-family:arial,helvetica,sans-serif;"
                                            align="left">

                                            <div class="menu" style="text-align:center">
                                                <!--[if (mso)|(IE)]><table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center"><tr><![endif]-->

                                                <!--[if (mso)|(IE)]><td style="padding:5px 50px"><![endif]-->

                                                <a href="#" target="_self"
                                                    style="padding:5px 50px;display:inline;color:#6c6c6c;font-family:arial black,avant garde,arial;font-size:16px;text-decoration:none"
                                                    class="v-padding">
                                                    SHOP
                                                </a>

                                                <!--[if (mso)|(IE)]></td><![endif]-->


                                                <!--[if (mso)|(IE)]><td style="padding:5px 50px"><![endif]-->

                                                <a href="#" target="_self"
                                                    style="padding:5px 50px;display:inline;color:#6c6c6c;font-family:arial black,avant garde,arial;font-size:16px;text-decoration:none"
                                                    class="v-padding">
                                                    ABOUT
                                                </a>

                                                <!--[if (mso)|(IE)]></td><![endif]-->


                                                <!--[if (mso)|(IE)]><td style="padding:5px 50px"><![endif]-->

                                                <a href="#" target="_self"
                                                    style="padding:5px 50px;display:inline;color:#6c6c6c;font-family:arial black,avant garde,arial;font-size:16px;text-decoration:none"
                                                    class="v-padding">
                                                    CONTACT
                                                </a>

                                                <!--[if (mso)|(IE)]></td><![endif]-->


                                                <!--[if (mso)|(IE)]></tr></table><![endif]-->
                                            </div>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td><![endif]-->
                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
            </div>
        </div>
    </div>



    <div class="u-row-container" style="padding: 0px;background-color: transparent">
        <div class="u-row"
            style="Margin: 0 auto;min-width: 320px;max-width: 640px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px;"><tr style="background-color: #ffffff;"><![endif]-->

                <!--[if (mso)|(IE)]><td align="center" width="640" style="width: 640px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
                <div class="u-col u-col-100"
                    style="max-width: 320px;min-width: 640px;display: table-cell;vertical-align: top;">
                    <div style="width: 100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div
                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                            <!--<![endif]-->

                            <table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0"
                                cellspacing="0" width="100%" border="0">
                                <tbody>
                                    <tr>
                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                            align="left">

                                            <table height="0px" align="center" border="0" cellpadding="0"
                                                cellspacing="0" width="100%"
                                                style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                <tbody>
                                                    <tr style="vertical-align: top">
                                                        <td
                                                            style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                            <span>&#160;</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td><![endif]-->
                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
            </div>
        </div>
    </div>



    <div class="u-row-container" style="padding: 0px;background-color: transparent">
        <div class="u-row"
            style="Margin: 0 auto;min-width: 320px;max-width: 640px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px;"><tr style="background-color: #ffffff;"><![endif]-->

                <!--[if (mso)|(IE)]><td align="center" width="640" style="width: 640px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
                <div class="u-col u-col-100"
                    style="max-width: 320px;min-width: 640px;display: table-cell;vertical-align: top;">
                    <div style="width: 100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div
                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                            <!--<![endif]-->

                            <table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0"
                                cellspacing="0" width="100%" border="0">
                                <tbody>
                                    <tr>
                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:10px 10px 30px;font-family:arial,helvetica,sans-serif;"
                                            align="left">

                                            <div align="center">
                                                <div style="display: table; max-width:167px;">
                                                    <!--[if (mso)|(IE)]><table width="167" cellpadding="0" cellspacing="0" border="0"><tr><td style="border-collapse:collapse;" align="center"><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace: 0pt;mso-table-rspace: 0pt; width:167px;"><tr><![endif]-->


                                                    <!--[if (mso)|(IE)]><td width="32" style="width:32px; padding-right: 10px;" valign="top"><![endif]-->
                                                    <table align="left" border="0" cellspacing="0" cellpadding="0"
                                                        width="32" height="32"
                                                        style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;margin-right: 10px">
                                                        <tbody>
                                                            <tr style="vertical-align: top">
                                                                <td align="left" valign="middle"
                                                                    style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                                                                    <a href="https://facebook.com/" title="Facebook"
                                                                        target="_blank">
                                                                        <img src="https://cdn.tools.unlayer.com/social/icons/circle/facebook.png"
                                                                            alt="Facebook" title="Facebook" width="32"
                                                                            style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important">
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!--[if (mso)|(IE)]></td><![endif]-->

                                                    <!--[if (mso)|(IE)]><td width="32" style="width:32px; padding-right: 10px;" valign="top"><![endif]-->
                                                    <table align="left" border="0" cellspacing="0" cellpadding="0"
                                                        width="32" height="32"
                                                        style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;margin-right: 10px">
                                                        <tbody>
                                                            <tr style="vertical-align: top">
                                                                <td align="left" valign="middle"
                                                                    style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                                                                    <a href="https://twitter.com/" title="Twitter"
                                                                        target="_blank">
                                                                        <img src="https://cdn.tools.unlayer.com/social/icons/circle/twitter.png"
                                                                            alt="Twitter" title="Twitter" width="32"
                                                                            style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important">
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!--[if (mso)|(IE)]></td><![endif]-->

                                                    <!--[if (mso)|(IE)]><td width="32" style="width:32px; padding-right: 10px;" valign="top"><![endif]-->
                                                    <table align="left" border="0" cellspacing="0" cellpadding="0"
                                                        width="32" height="32"
                                                        style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;margin-right: 10px">
                                                        <tbody>
                                                            <tr style="vertical-align: top">
                                                                <td align="left" valign="middle"
                                                                    style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                                                                    <a href="https://instagram.com/" title="Instagram"
                                                                        target="_blank">
                                                                        <img src="https://cdn.tools.unlayer.com/social/icons/circle/instagram.png"
                                                                            alt="Instagram" title="Instagram" width="32"
                                                                            style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important">
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!--[if (mso)|(IE)]></td><![endif]-->

                                                    <!--[if (mso)|(IE)]><td width="32" style="width:32px; padding-right: 0px;" valign="top"><![endif]-->
                                                    <table align="left" border="0" cellspacing="0" cellpadding="0"
                                                        width="32" height="32"
                                                        style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;margin-right: 0px">
                                                        <tbody>
                                                            <tr style="vertical-align: top">
                                                                <td align="left" valign="middle"
                                                                    style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                                                                    <a href="https://pinterest.com/" title="Pinterest"
                                                                        target="_blank">
                                                                        <img src="https://cdn.tools.unlayer.com/social/icons/circle/pinterest.png"
                                                                            alt="Pinterest" title="Pinterest" width="32"
                                                                            style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important">
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>


                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td><![endif]-->
                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
            </div>
        </div>
    </div>


    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
    </td>
    </tr>
    </tbody>
    </table>
    <!--[if mso]></div><![endif]-->
    <!--[if IE]></div><![endif]-->
</body>

</html>';
	    // send_email($user['email'], $html, 'Order Confirmation');
		$DeleteCart = "DELETE FROM cart where user_id = '".$user['id']."'";
		mysqli_query($con, $DeleteCart);
		unset($_SESSION['id_address_delivery']);

        

		redirect(FRONT_SITE_PATH.'order-confirmation?orderId='.$order_id);
}else{
	redirect(FRONT_SITE_PATH);
}
?>