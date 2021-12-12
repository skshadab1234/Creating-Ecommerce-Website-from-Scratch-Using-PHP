<?php
require '../includes/constant.inc.php';
require '../includes/function.inc.php';
require '../includes/database.inc.php';

if (isset($_SESSION['SELLER_ID'])) {
    $sql = "SELECT * FROM seller_account where id = '".$_SESSION['SELLER_ID']."'";
	$res = mysqli_query($con,$sql);
	$sell_row = mysqli_fetch_assoc($res);
    $date = date("Y-m-d");
}



