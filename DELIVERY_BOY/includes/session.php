<?php
require '../includes/constant.inc.php';
require '../includes/function.inc.php';
require '../includes/database.inc.php';

if (isset($_SESSION['DELIVERY_ID'])) {
    $sql = "SELECT * FROM delivery_boy where delivery_boy_id = '".$_SESSION['DELIVERY_ID']."'";
	$res = mysqli_query($con,$sql);
	$DELIVERYData = mysqli_fetch_assoc($res);
    $date = date("Y-m-d");
    if ($DELIVERYData['delivery_boy_profile'] == '') {
        $adminImg = 'https://png.pngitem.com/pimgs/s/35-350426_profile-icon-png-default-profile-picture-png-transparent.png';
    }
    else{
        $adminImg = DELIVERY_PROFILE.$DELIVERYData['delivery_boy_profile'];
    }
}



