<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Projectphp/init.php';

$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$errors = array();
 // FORM VALIDATOIN
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
		if(!empty($email)) 
		{ 
		$querySql ="SELECT * FROM users WHERE user_email = '$email' ";
		$results = $db->query($querySql);
		$user = mysqli_fetch_assoc($results);
		$userCount = mysqli_num_rows($results);
			
		$querySql2 = "SELECT * FROM customers WHERE cust_email = '$email'";
				$results2 = $db->query($querySql2);
				$cust = mysqli_fetch_assoc($results2);
				$custCount = mysqli_num_rows($results2);
			//trial
							
			 if(($userCount == 0) && ($custCount == 0))
				{
					$errors[] = 'Email ID doesnt exists.';
				}
			
			//end trial
			//main
		}
	if(($password != $user['user_password']) && ($password != $cust['cust_password']))
	//if(!password_verify($password, $user['user_password']))
	{
		$errors[] = 'Password is incorrect. ';
	}
	
	// check errors aaray
	if(!empty($errors))
	{ 
		echo display_errors($errors);
	} 
	else 
	{
		//log in the customer
		if($custCount == 1)
		{
			$cust_id = $cust['cust_id'];
			login_cust($cust_id);
		}
		else if($userCount == 1){
		//login the admin
		$user_id = $user['user_id'];
		login($user_id);
		}
	}
}
include 'header.php';
?>
<div class="container_login">    
        <div id="loginform" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">    <!--loginbox -->               
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Log In</div>
                        <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div>
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form id="loginform" class="form-horizontal" method="post" role="form" action="login2.php">
                                    
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="email" placeholder="Enter Email" name="email" id="email" class="form-control" value="<?=$email; ?>">                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" value="<?=$password; ?>">
                                    </div>
                                    

                       <!--         
                            <div class="input-group">
                                      <div class="checkbox">
                                        <label>
                                          <input id="login-remember" type="checkbox" name="remember" value="1"> Remember me
                                        </label>
                                      </div>
                                    </div>
-->

                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls">
                                      <input id="btn-login" type="submit" class="btn btn-success" value="Login">

                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-12 control">
                                        <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                            Don't have an account! 
                                        <a href="/Projectphp/signup.php">
                                            Sign Up Here
                                        </a>
                                        </div>
                                    </div>
                                </div>    
                            </form>     



                        </div>                     
                    </div>  
        </div>
		</div>
        <?php include 'footer.php'; ?>
    