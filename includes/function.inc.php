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
	$mail->Username="ks615044@gmail.com"; // Change My Email
	$mail->Password="@addPassword";
	$mail->setFrom("ks615044@gmail.com"); // Change My Email
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

		$track_id[] = rand(11111111,99999999);
		$track_ids = implode("," , $track_id);

		$product_price[] = $row['prod_price'];
		$product_prices = implode("," , $product_price);

		$estimate_dd[] = randomDate(date("Y-m-d", strtotime("+5 days")), date("Y-m-d",strtotime("+8 days")));
		$estimate_dds = implode(",",$estimate_dd);
	}

	$data_arr = array(
					"product_id" => $datas, 
					'product_varient' => $product_varient, 
					'qtys' => $qtys, 
					'track_id' => $track_ids,
					"product_price" => $product_prices,
					'estimate_dd' => $estimate_dds
					);
	
	return $data_arr;


}


function RemainingStock($id) {
	global $con;

	$ProductDetails = ProductDetails("Where id = '$id'");
	$ProductDetails = $ProductDetails[0];

	$remaining_stock = $ProductDetails['total_stock'] - $ProductDetails['total_sold'];
	
	if($remaining_stock < 1) {
		$remains = '<span style="color:red">Out of Stock</span>';
	}
	else if($remaining_stock < 10) {
		$remains = '<span style="color:red">Hurry up, Only '.$remaining_stock.' Remains in Stock</span>';
	}
	else if($remaining_stock < 100) {
		$remains = '<span style="color:red">Only '.$remaining_stock.' Remains , Order Fast</span>';
	}else{
		$remains = number_format($remaining_stock)." Items";
	}

	return $remains;
}


function WishlistData($uid) {
	global $con;
	$data = array();
	$Sql = "Select * from wishlist Where user_id = '$uid'";
	$res = mysqli_query($con, $Sql);

	if (mysqli_num_rows($res) > 0)  {
		while ($row = mysqli_fetch_assoc($res)) {
			$data[] = $row;
		}
	}

	return $data;
}

function numtostring($n)
{
    $n = (0+str_replace(",","",$n));

        // is this a number?
        if(!is_numeric($n)) return false;

        // now filter it;
        if($n>1000000000000) return round(($n/1000000000000),1).'t';
        else if($n>1000000000) return round(($n/1000000000),1).'b';
        else if($n>1000000) return round(($n/1000000),1).'m';
        else if($n>1000) return round(($n/1000),1).'k';

        return number_format($n);
}


function OrderSql($query = ''){
	global $con;
	$data = array();
	$res = mysqli_query($con, "SELECT * FROM payment_details ".$query);

	if (mysqli_num_rows($res) > 0)  {
		while ($row = mysqli_fetch_assoc($res)) {
			$data[] = $row;
		}
	}

	return $data;
}

function UsersDetails($query = ''){
	global $con;
	$data = array();
	$res = mysqli_query($con, "SELECT * FROM users ".$query);

	if (mysqli_num_rows($res) > 0)  {
		while ($row = mysqli_fetch_assoc($res)) {
			$data[] = $row;
		}
	}

	return $data;
}


function AdminDetails($query = ''){
	global $con;
	$data = array();
	$res = mysqli_query($con, "SELECT * FROM admins ".$query);

	if (mysqli_num_rows($res) > 0)  {
		while ($row = mysqli_fetch_assoc($res)) {
			$data[] = $row;
		}
	}

	return $data;
}

function DeliveryDetails($query = ''){
	global $con;
	$data = array();
	$res = mysqli_query($con, "SELECT * FROM delivery_boy ".$query);

	if (mysqli_num_rows($res) > 0)  {
		while ($row = mysqli_fetch_assoc($res)) {
			$data[] = $row;
		}
	}

	return $data;
}


function ExecutedQuery($query){
	global $con;
	$data = array();
	$res = mysqli_query($con, $query);

	if (mysqli_num_rows($res) > 0)  {
		while ($row = mysqli_fetch_assoc($res)) {
			$data[] = $row;
		}
	}

	return $data;
}


function SqlQuery($query) {
	global $con;
	$result = mysqli_query($con, $query);
	return $result;
}


function slugify($text)
{ 
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    return strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $text));
}

// Find a randomDate between $start_date and $end_date
function randomDate($start_date, $end_date)
{
    // Convert to timetamps
    $min = strtotime($start_date);
    $max = strtotime($end_date);

    // Generate random number using above bounds
    $val = rand($min, $max);

    // Convert back to desired date format
    return date('Y-m-d H:i:s', $val);
}


function star_rate($number) {
	$whole = floor($number);      // 1
	$fraction = $number - $whole; // .25
	$reamin_emp_star = 5 - ceil($number);

	if ($number <= 2.5) {
		$color = 'danger';
	}else{
		$color = 'warning';
	}
	$arr = array();
	$arr[] = str_repeat('<i class="fa fa-star  text-'.$color.'" aria-hidden="true"></i>', $whole);
	$arr[] = str_repeat('<i class="fa fa-star-half-o text-'.$color.'" aria-hidden="true"></i>', ceil($fraction));
	$arr[] = str_repeat('<i class="fa fa-star-o text-'.$color.'" aria-hidden="true"></i>', ceil($reamin_emp_star));

	
	return join($arr);
}

function GetAssignedDeliveryForDeliveryBoy($deliveryBoyId) {
	global $con;

	
	$delivered= '';
	$pending= '';	

	$res = SqlQuery("SELECT * FROM ordertrackingdetails WHERE delivery_boy_id = '$deliveryBoyId'");
	if (mysqli_num_rows($res) > 0) {
		$row = mysqli_fetch_assoc($res);
				
		foreach ($res as $key => $value) {
		$current_Status = explode(",", $value['Current_Status']);

		
			if (end($current_Status) == 'Delivered') {
				$delivered .= $value['track_product_id'].',';
			}

			if (end($current_Status) != 'Delivered') {
				$pending .= $value['track_product_id'].',';
			}
		}
		$delivered = substr($delivered, 0, -1);
		$pending = substr($pending, 0, -1);
		$arr = array('Delivered' => $delivered, 'Pending' => $pending);
	}else{
		$delivered = '0';
		$pending = '0';
		$arr = array('Delivered' => $delivered, 'Pending' => $pending);
	}

	
	
	return $arr;
}



















