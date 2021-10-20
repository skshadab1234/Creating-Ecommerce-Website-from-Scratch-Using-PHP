<?php
require 'constant.inc.php';
require 'function.inc.php';
require 'database.inc.php';


if(isset($_SESSION['UID'])){
	$sql = "SELECT * FROM users where id = '".$_SESSION['UID']."'";
	$res = mysqli_query($con,$sql);
	$user = mysqli_fetch_assoc($res);
}else {
	$user = array();
	$user['id'] = 'Guest';
}