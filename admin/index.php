<?php 
require_once '../init.php';

if(!is_logged_in())
{
	// login_error_redirect();
	header('Location: login.php');
}

include 'includes/head.php';
include 'includes/navigation.php';



?>
Administrator Home

