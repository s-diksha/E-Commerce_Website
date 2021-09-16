<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Projectphp/init.php';
unset($_SESSION['Suser']);
header('Location: ../login2.php');
?>