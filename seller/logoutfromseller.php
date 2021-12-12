<?php
    require 'includes/session.php';

    if (isset($_SESSION['SELLER_ID'])) {
		unset($_SESSION['SELLER_ID']);
		session_destroy($_SESSION['SELLER_ID']);
		header("location:".SELLER_FRONT_SITE);		
	}
	else{
		header("location:".SELLER_FRONT_SITE);		
	}