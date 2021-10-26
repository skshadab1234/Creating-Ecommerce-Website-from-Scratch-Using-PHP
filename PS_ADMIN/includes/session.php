<?php
require '../includes/constant.inc.php';
require '../includes/function.inc.php';
require '../includes/database.inc.php';

if (isset($_SESSION['ADMIN_ID'])) {
    $sql = "SELECT * FROM admins where id = '".$_SESSION['ADMIN_ID']."'";
	$res = mysqli_query($con,$sql);
	$adminData = mysqli_fetch_assoc($res);
    $date = date("Y-m-d");
    if ($adminData['admin_img'] == '') {
        $adminImg = 'https://png.pngitem.com/pimgs/s/35-350426_profile-icon-png-default-profile-picture-png-transparent.png';
    }
    else{
        $adminImg = ADMIN_PROFILE.$adminData['admin_img'];
    }
}



