<?php
    require 'includes/session.php';

    if (isset($_SESSION['ADMIN_ID'])) {
		unset($_SESSION['ADMIN_ID']);
		session_destroy($_SESSION['ADMIN_ID']);
		header("location:".ADMIN_FRONT_SITE.'login');		
	}
