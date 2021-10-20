<?php
    require 'includes/session.php';

    if (isset($_SESSION['UID'])) {
		unset($_SESSION['UID']);
		session_destroy($_SESSION['UID']);
		header("location:".FRONT_SITE_PATH);		
	}
