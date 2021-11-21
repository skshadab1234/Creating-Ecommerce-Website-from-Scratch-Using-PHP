<?php
    require 'includes/session.php';

    if (isset($_SESSION['DELIVERY_ID'])) {
		unset($_SESSION['DELIVERY_ID']);
		session_destroy($_SESSION['DELIVERY_ID']);
		header("location:".DELIVERY_FRONT_SITE.'login');		
	}
