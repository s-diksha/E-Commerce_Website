<?php 
require_once 'init.php';
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

if(!isset($_SESSION['$cust']))
{
	include("login2.php");
}
else
{
	include("shipping_details.php");
}
 ?>
	
<?php include('footer.php'); ?>


