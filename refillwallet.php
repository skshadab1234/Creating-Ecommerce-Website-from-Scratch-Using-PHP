<?php
require 'includes/session.php';
require('config.php');

if(isset($_POST['stripeToken'])){
    $amount = get_safe_value($_POST['amountselecttopay']);
    \Stripe\Stripe::setVerifySslCerts(false);

	$token=$_POST['stripeToken'];

	$data=\Stripe\Charge::create(array(
		"amount"=>$amount,
		"currency"=>"inr",
		"description"=>"Programming with Shadab Desc",
		"source"=>$token,
	));
    ManageWallet("insert",$user['id'],$amount,'₹'.$amount." Added Succesfully to your Wallet.",date("Y-m-d H:i:s"),'in');
    redirect(FRONT_SITE_PATH.'wallet');
}