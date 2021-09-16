<?php
$db = mysqli_connect('127.0.0.1','root','','snehaanjali');
if(mysqli_connect_errno()) {
	echo 'Database connection failed with following errors: ' . mysqli_connect_error();
	die();
}

session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/Projectphp/config.php';
require_once BASEURL.'helpers/helpers.php';

$cart_id ='';
if(isset($_COOKIE[CART_COOKIE]))
{
	$cart_id=sanitize($_COOKIE[CART_COOKIE]);
}

if(isset($_SESSION['Suser']))
{
	$user_id = $_SESSION['Suser'];
	$query = $db->query("SELECT * FROM users WHERE user_id = '$user_id'");
	$user_data = mysqli_fetch_assoc($query);
	$fn = explode(' ',$user_data['user_name']);
	$user_data['first']=$fn[0];
	$user_data['last'] = $fn[1];
}

if(isset($_SESSION['success_flash']))
{
	echo '<div class="bg-success"><p class="text-success text-center">'.$_SESSION['success_flash'].'</p></div>';
	unset($_SESSION['success_flash']);
	}
	
	if(isset($_SESSION['error_flash']))
{
	echo '<div class="bg-danger"><p class="text-danger text-center">'.$_SESSION['error_flash'].'</p></div>';
	unset($_SESSION['error_flash']);
	}
?>