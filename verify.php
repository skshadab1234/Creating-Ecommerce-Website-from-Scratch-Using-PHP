<?php
require 'includes/session.php';

if (isset($_GET['userLoginCode']) && $_GET['userLoginCode'] > 0)  {
    $userLoginCode = get_safe_value($_GET['userLoginCode']);
    $email = get_safe_value($_GET['email']);
    $ReferByID = get_safe_value($_GET['ReferByID']);
    $Code = get_safe_value($_GET['Code']);
    $redirect = get_safe_value($_GET['redirect']);

    $query = "SELECT * FROM users WHERE userLoginCode = '$userLoginCode' && email = '$email' && verify=0";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) > 0){
        $id = $row['id'];
        mysqli_query($con, "update users set verify = 1 where id = '$id'");
        echo 'Your Account has Verified';

        $ValidateQuery = ExecutedQuery("SELECT * FROM users WHERE MyReferralCode='$Code' && id='$ReferByID'");
        if ($ValidateQuery > 0) {
            mysqli_query($con, "insert into ReferralUsers(UserReferCode,UserId_WhoReferCodeIs,UserId_ReferCodeUsedBy) VALUES('$Code','$ReferByID','$id')");
            if (SIGNUP_BONUS > 0) {
                ManageWallet("insert",$id,rand(1,SIGNUP_BONUS),'Signup Bonus',date("Y-m-d H:i:s"),'in');
            }
            if(GETSIGNEDUPBONUS > 0){
                ManageWallet("insert",$ReferByID,rand(1,GETSIGNEDUPBONUS),"₹ ".rand(1,GETSIGNEDUPBONUS).'Referral Amount Added to Wallet',date("Y-m-d H:i:s"),'in');
            }
        }
        
        redirect($redirect);
    }else {
        echo 'Login Code Doesn\'t Match';
    }
}

if (isset($_GET['DeliveryLoginCode']) && $_GET['DeliveryLoginCode'] > 0)  {
    $DeliveryLoginCode = get_safe_value($_GET['DeliveryLoginCode']);
    $email = get_safe_value($_GET['email']);
    $redirect = get_safe_value($_GET['redirect']);

    $query = "SELECT * FROM delivery_boy WHERE DeliveryLoginCode = '$DeliveryLoginCode' && delivery_boy_email = '$email'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) > 0){
        $id = $row['delivery_boy_id'];
        mysqli_query($con, "update delivery_boy set delivery_boy_verifed = 1 where delivery_boy_id = '$id'");
        echo 'Your Account has Verified';
        redirect($redirect);
    }else {
        echo 'Login Code Doesn\'t Match';
    }
}
