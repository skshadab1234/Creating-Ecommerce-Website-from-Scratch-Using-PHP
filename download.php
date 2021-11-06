<?php
require 'includes/session.php';
if(!empty($_GET['filename']) && isset($_GET['redirect']) && $_GET['redirect'] != '')
{
	$filename = basename($_GET['filename']);
    $redirect = get_safe_value($_GET['redirect']);
	$filepath = "UserInvoice/".$filename;
	if(!empty($filename) && file_exists($filepath)){

    //Define Headers
		header("Cache-Control: public");
		header("Content-Description: FIle Transfer");
		header("Content-Disposition: attachment; filename=$filename");
		header("Content-Type: application/zip");
		header("Content-Transfer-Emcoding: binary");

		readfile($filepath);
		redirect($redirect);
        exit;
        
	}
	else{
		echo "This File Does not exist.";
	}
}
