<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Projectphp/init.php';
include 'includes/head.php';


$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
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
		if(empty($_POST['email']) || empty($_POST['password']))
		{
			$errors[] = 'Email and password must be entered. ';
		}
		
		//Validate email
		if(!empty($email)) { 
	if(!filter_var($email,FILTER_VALIDATE_EMAIL))
	{
		$errors[] = 'Please enter a valid email id';
	}
		}
		//password must be atleast 8 characters
		if(strlen($password) < 8)
		{
			$errors[] = ' Password must be atleast contain 8 characters. ';
		}
		// If email already exists
		if(!empty($email)) { 
		$querySql ="SELECT * FROM users WHERE user_email = '$email' ";
		$results = $db->query($querySql);
		$user = mysqli_fetch_assoc($results);
		$userCount = mysqli_num_rows($results);
		echo $userCount;
		if($userCount < 1)
		{
			$errors[] = 'Email ID doesnt exists.';
		} }
	if($password != $user['user_password'])
	//if(!password_verify($password, $user['user_password']))
	{
		$errors[] = 'Password is incorrect. ';
	}
	
	// check errors aaray
	if(!empty($errors))
	{ echo display_errors($errors);
	} else 
	{
		//login the user
		$user_id = $user['user_id'];
		login($user_id);
	}
}

?>
  </div>
<!-- END FORM VALIDATION -->
<h2 class="text-center">Login</h2><hr>
<form action="login.php" method="post">
	<div class="form-group">
		<label for="email"> Email : </label>
		<input type="email" placeholder="Enter Email" name="email" id="email" class="form-control" value="<?=$email; ?>">
	</div>
      <div class="form-group">
		<label for="password"> Password : </label>
		<input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" value="<?=$password; ?>">
	</div>
<p class="text-left"><a href="/Projectphp/checkout.php">Forgot Password? </a> OR <a href="/Projectphp/signup.php">Register? </a></p>	

	<div class="form-group">
		<input type="submit" value="Login" class="btn btn-primary">
	</div>
</form>
<p class="text-right"><a href="/Projectphp/index.php">Visit site</a></p>
</div>
</div>
<?php include 'includes/footer.php' ;?>