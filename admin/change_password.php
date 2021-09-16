<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Projectphp/init.php';
if(!is_logged_in())
{
 login_error_redirect();
}
include 'includes/head.php';
$hashed = $user_data['user_password'];
$old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
$old_password = trim($old_password);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$confirm = trim($confirm);
$new_hashed = password_hash($password, PASSWORD_DEFAULT);
$user_id = $user_data['user_id'];
$errors = array();

?>
<div class="container_login">
	<div id="login-form">
    <div>
<!-- FORM VALIDATOIN-->
<?php 
	if($_POST)
	{
		//if email and password not entered
		if(empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm']))
		{
			$errors[] = 'You must fill all the fields. ';
		}
		
		//password must be atleast 8 characters
		if(strlen($password) < 8)
		{
			$errors[] = ' Password must be atleast contain 8 characters. ';
		}
		// new password does not matches confirm
		if($password != $confirm)
		{
			$errors[] = ' New password and confirm password does not match';
		}
	if($old_password != $hashed)
	// if(!password_verify($old_password, $hashed))
	 {
		$errors[] = 'Old Password is incorrect. ';
	}
	
	// check errors aaray
	if(!empty($errors))
	{ echo display_errors($errors);
	} else 
	{
		//change the password
		$db->query("UPDATE users SET user_password='$new_hashed' WHERE user_id = '$user_id'");
		$_SESSION['success_flash'] = 'Password has been updated! ' ;
		header('Location: index.php');
	}
}

?>
  </div>
<!-- END FORM VALIDATION -->
<h2 class="text-center">Change Password</h2><hr>
<form action="change_password.php" method="post">
	<div class="form-group">
		<label for="old_password"> Old password : </label>
		<input type="password" name="old_password" id="old_password" class="form-control" value="<?=$old_password; ?>">
	</div>
      <div class="form-group">
		<label for="password"> New Password : </label>
		<input type="password" name="password" id="password" class="form-control" value="<?=$password; ?>">
	</div>	
	<div class="form-group">
		<label for="confirm"> Confirm New Password : </label>
		<input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm; ?>">
	</div>	
	<div class="form-group">
	<a href="index.php" class="btn btn-default">Cancel</a>
		<input type="submit" value="Login" class="btn btn-primary">
	</div>
</form>
<p class="text-right"><a href="/Projectphp/index.php">Visit site</a></p>
</div>
</div>
<?php include 'includes/footer.php' ;?>