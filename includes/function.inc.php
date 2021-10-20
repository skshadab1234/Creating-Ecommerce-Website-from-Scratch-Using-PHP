<?php

function prx($value)
{
	echo "<pre>";
	print_r($value);
	echo "</pre>";
	die();
}

function pr($value)
{
	echo "<pre>";
	print_r($value);
	echo "</pre>";
}

function get_safe_value($str){
    global $con;
    $str=mysqli_real_escape_string($con,$str);
    return $str;

}


function redirect($link){
	?>
	<script>
		window.location.href='<?php echo $link?>';
	</script>
	<?php
	die();
}



function send_email($email,$html,$subject){
	$mail=new PHPMailer(true);
	$mail->isSMTP();
	$mail->Host="smtp.gmail.com";
	$mail->Port=587;
	$mail->SMTPSecure="tls";
	$mail->SMTPAuth=true;
	$mail->Username="ks615044@gmail.com";
	$mail->Password="Shadabloveparveen1!";
	$mail->setFrom("ks615044@gmail.com");
	$mail->addAddress($email);
	$mail->IsHTML(true);
	$mail->Subject=$subject;
	$mail->Body=$html;
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if($mail->send()){
		return 'Sended';
	}else{
		return 'Error_Occur';
	}
}



function ProductDetails($query = '') {
	global $con;
	$data=array();
	$sql = 'Select * from product_details '.$query;
	$result = mysqli_query($con, $sql);
	
	while($row=mysqli_fetch_assoc($result)){
		$data[]=$row;
	}
	return $data;	
}

function ProductImageById($pid, $limit = ''){
	global $con;
	$data=array();
	$sql = 'Select * from products_image where product_id = "'.$pid.'" and status = 1 '.$limit.'';
	$result = mysqli_query($con, $sql);
	
	while($row=mysqli_fetch_assoc($result)){
		$data[]=$row;
	}
	return $data;
}


function ProductDataSheetById($pid){
	global $con;
	$data=array();
	$sql = 'Select * from product_data_sheet where product_id = "'.$pid.'" and status = 1';
	$result = mysqli_query($con, $sql);
	
	while($row=mysqli_fetch_assoc($result)){
		$data[]=$row;
	}
	return $data;
}



function getCartTotal() {
    global $con;
	if (isset($_SESSION['UID'])) {
		$uid = $_SESSION['UID'];
		$sql = 'Select COUNT(*) as cart_total from cart where user_id = "'.$uid.'" and cart_status = 1';
		$result = mysqli_query($con, $sql);
		$row = mysqli_fetch_assoc($result);
		return $row['cart_total'];	
	}else {
		// Set Cart item to Session 
		if (isset($_SESSION['cart'])) {
			$total = count($_SESSION['cart']);
			return $total;
		}else {
			return 0;
		}
	}
	
}


function FetchUserAddresssDetails($uid){
	global $con;
	$data=array();
	$sql = 'Select * from user_address where user_id = "'.$uid.'"';
	$result = mysqli_query($con, $sql);
	
	while($row=mysqli_fetch_assoc($result)){
		$data[]=$row;
	}
	return $data;
}

function getAddressById($id) {
	global $con;
	$sql = 'Select * from user_address where id = "'.$id.'"';
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_assoc($result);
	return $row;
}


function CalculateTotalProductBuying($uid){
	global $con;
	$data=array();
	$size=array();
	$qty=array();
	$sql = 'Select * from cart where user_id = "'.$uid.'"';
	$result = mysqli_query($con, $sql);
	while($row=mysqli_fetch_assoc($result)){
		$data[] = $row['product_id'];
		$datas = implode("," , $data);

		$size[] = $row['size'];
		$product_varient = implode("," , $size);

		$qty[] = $row['qty'];
		$qtys = implode("," , $qty);
	}

	$data_arr = array("product_id" => $datas, 'product_varient' => $product_varient, 'qtys' => $qtys);
	
	return $data_arr;


}








