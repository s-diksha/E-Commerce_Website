<?php
function display_errors($errors)
{
	$display = '<ul class="bg-danger">';
foreach($errors as $error)
{
	$display .= '<li class="text-danger">'.$error.'</li>';
}
$display .= '</ul>';
return $display;
	}
function sanitize($dirty)
{
	return htmlentities($dirty,ENT_QUOTES,"UTF-8");
}

function money($number)
{
	return '₹'.number_format($number,2);
}

//getting IP address
function getIp() {
    $ip = $_SERVER['REMOTE_ADDR'];
 
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
 
    return $ip;
}

// creating the cart
function cart()
{
	if(isset($_GET['add_cart']))
	{
		global $db;
		$ip = getIp();
			$pro_id =$_GET['add_cart'];
			$check_pro = $db->query("SELECT * FROM cart1 WHERE ip_address='$ip' AND prod_id = '$pro_id'");
			$results = mysqli_fetch_assoc($check_pro);
			if(mysqli_num_rows($results) > 0) 
			{
					echo "";
				}
				
			else{
				$insert_pro = "INSERT INTO cart1 (prod_id, ip_address) VALUES ('$pro_id','$ip')";
				$results = $db->query($insert_pro);
				echo "<script>window.open('index.php','_self')</script>";
			}
	} 
}


//getting the total item
function total_items()
{
	if(isset($_GET['add_cart']))
	{
		 global $db;
		 $ip = getIp();
		 $get_items = "SELECT * FROM cart1 WHERE ip_address='$ip'";
		 $run_items = $db->query($get_items);
		 $count_items = mysqli_num_rows($run_items);
	}
	else {
		global $db;
		$ip = getIp();
		 $get_items = "SELECT * FROM cart1 WHERE ip_address='$ip'";
		 $run_items = $db->query($get_items);
		 $count_items = mysqli_num_rows($run_items);
	}
	echo $count_items;
}

//getting the total price 
function total_price()
{
	$total = 0;
	global $db;
	$ip = getIp();
	$sel_price = "SELECT * FROM cart1 WHERE ip_address = '$ip'";
	$results = $db->query($sel_price);
	while ($p_price = mysqli_fetch_array($results))
	{
		$pro_id = $p_price['prod_id'];
		$pro_price = "SELECT * FROM products WHERE product_id = '$pro_id'";
		$run_pro_price = $db->query($pro_price);
		while($pp_price = mysqli_fetch_array($run_pro_price))
		{
			$product_price = array($pp_price['product_price']);
			$values = array_sum($product_price);
			$total += $values;
		}
	}
	echo money($total);
}

//login admin function
function login($user_id)
{
	$_SESSION['Suser'] = $user_id;
 global $db;
$date = date("Y-m-d H:i:s");
$db->query("UPDATE users SET last_login = '$date' WHERE user_id='$user_id'"); //update the databse with lastlogin
$_SESSION['success_flash'] = 'Welcome Admin';
//echo "<script>window.open('admin/index.php','_self')</script>";
header('Location: admin/index.php');
	}
	//login cust function
	function login_cust($cust_id)
	{
		$_SESSION['$cust']=$cust_id;
		//echo "<script>window.open('checkout.php','_self')</script>";
$_SESSION['success_flash'] = 'Welcome to Snehaanjali Electronics';
		echo "<script>window.open('index.php','_self')</script>";
	}
	function is_logged_in()
	{
		if((isset($_SESSION['Suser']) && $_SESSION['Suser'] > 0) || (isset($_SESSION['Scust']) && $_SESSION['Scust'] > 0))
		{
			return true;
		}
		return false;
	}
	function login_error_redirect($url='http://localhost/Projectphp/login2.php')
	{
		$_SESSION['error_flash']= 'You must be logged in to access that page';
		header('Location: '.$url);
	}
	function permission_error_redirect($url='http://localhost/Projectphp/login2.php')
	{
		$_SESSION['error_flash']= 'You do not permission to access that page';
		header('Location: '.$url);
	}
	function has_permission($permission = 'admin')
	{ global $user_data;
		$permissions = explode(',',$user_data['permissions']);
		if(in_array($permission,$permissions,true))
		{
			return true;
		}
		return false;
	}
	function datab_date($date)
	{
		return date("M d, Y h:i A",strtotime($date));
	}