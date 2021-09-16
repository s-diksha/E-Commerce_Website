<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Projectphp/init.php';
if(!isset($_SESSION['$cust']))
{
	session_start();
}else
{
	session_destroy();
}
header('Location: login2.php');
//echo "<script>window.open('index.php','_self')</script>";

// unset($_SESSION['Scust']);
// header('Location: login2.php');
?>