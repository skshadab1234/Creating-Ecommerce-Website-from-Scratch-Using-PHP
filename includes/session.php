<?php
require 'constant.inc.php';
require 'function.inc.php';
require 'database.inc.php';


if(isset($_SESSION['UID'])){
	$sql = "SELECT * FROM users where id = '".$_SESSION['UID']."'";
	$res = mysqli_query($con,$sql);
	$user = mysqli_fetch_assoc($res);
	if ($user['user_img'] != '') {
		$user_img = USER_PROFILE.$user['user_img'];
	}else {
		$user_img = 'https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png';
	}
}else {
	$user = array();
	$user['id'] = 'Guest';
}