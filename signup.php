<?php 
 
require_once $_SERVER['DOCUMENT_ROOT'].'/Projectphp/init.php';
include 'header.php';
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
	
$ip = getIp();
$name=((isset($_POST['name']))?sanitize($_POST['name']):'');
$email=((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$address=((isset($_POST['address']))?sanitize($_POST['address']):'');
$phnumber = ((isset($_POST['phnumber']))?sanitize($_POST['phnumber']):'');
$pin = ((isset($_POST['zip_code']))?sanitize($_POST['zip_code']):'');
$errors = array();
?>
<style>
.main_container2 {margin: 100px;
height:auto; 
 
}
	
</style>
<div class="main_container2">
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
			$querySql ="SELECT cust_email FROM customers WHERE cust_email = '$email' ";
			$results = $db->query($querySql);
			$cust = mysqli_fetch_assoc($results);
			$custCount = mysqli_num_rows($results);
			//echo $custCount;
			if($custCount ==1)
			{
				$errors[] = 'Email ID already exists.';
			}
		}
		if(!empty($errors))
	{ echo display_errors($errors);
	 } else 
	 {
		 //update the database
		 $queryUpdate = "INSERT INTO customers (cust_name,cust_password,cust_email,cust_phone,cust_ip,cust_address,zip_code) VALUES ('$name','$password','$email','$phnumber','$ip','$address','$pin')";
		 $results = $db->query($queryUpdate);
		//login the user
		// $cust_id = $cust['cust_id'];
		// login_cust($cust_id);
 // $_SESSION['success_flash'] = 'Welcome to Snehaanjali Electronics';
// header('Location: index.php');

$sel_cart = "SELECT * FROM cart1 WHERE ip_address='$ip'";
$results=$db->query($sel_cart);
$check_cart=mysqli_num_rows($results);
if($check_cart==0)
{
	$cust_id = $cust['cust_id'];
			login_cust($cust_id);
	echo "<script>alert('Account has been created succesfully')</script>";
	//echo "<script>window.open('customer/my_account.php','_self')</script>";
}
else
{
	$cust_id = $cust['cust_id'];
			login_cust($cust_id);
	echo "<script>alert('Account has been created succesfully')</script>";
	echo "<script>window.open('checkout.php','_self')</script>";
}
	}
	}
		?>
		
<div id="signupbox" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Sign Up</div>
                          
                        </div>  
                        <div class="panel-body" >
                            <form id="signupform" action="signup.php" class="form-horizontal" role="form" method="post">
                                    
                                <div class="form-group">
                                    <label for="firstname" class="col-md-3 control-label">Name</label>
                                    <div class="col-md-9">
                                        <input type="text" name="name" id="name" class="form-control" value="<?=$name; ?>"  required>
                                    </div>
                                </div>
								<div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="email" name="email" id="email" class="form-control" value="<?=$email; ?>"  required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-md-3 control-label">Password</label>
                                    <div class="col-md-9">
                                        <input type="password" name="password" id="password" class="form-control" value="<?=$password; ?>"  required>
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="address" class="col-md-3 control-label">Address</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" rows="5" name="address" id="address" value="<?=$address; ?>"  required></textarea>
                                    </div>
                                </div>
								<div class="form-group">
                                    <label for="zip_code" class="col-md-3 control-label">Zip/Postal Code</label>
                                    <div class="col-md-9">
                                        <input type="text" name="zip_code" id="zip_code" class="form-control" value="<?=$pin; ?>"  required>
                                    </div>
                                </div>
								<div class="form-group">
                                    <label for="phnumber" class="col-md-3 control-label">Phone Number</label>
                                    <div class="col-md-9">
                                        <input type="text" name="phnumber" id="phnumber" class="form-control" value="<?=$phnumber; ?>"  required>
                                    </div>
                                </div>
                                    <!-- Button -->           
                                    <div class="col-md-offset-3 col-md-9">
                                        <input type="submit" class="btn btn-info" value="Register">
                                    </div>
                                </div>
    
                            </form>
                         </div>
                    </div>

               
               
                
         </div> 
		 <?php include 'footer.php'; ?>