<?php 
require_once 'init.php';
include('header.php');
global $db;
$ip = getIp();
$sql = "SELECT * FROM customers WHERE cust_ip = '$ip'";
$run = $db->query($sql);
$results = mysqli_fetch_assoc($run);
$cust_name = $results['cust_name'];
$address = $results['cust_address'];
$phone = $results['cust_phone'];
$email = $results['cust_email'];
$customer_id = $results['cust_id'];

?>
<head>
<link rel="stylesheet" href="shipping_style.css" media="all"/>
</head>
<body>
<div class="container_ship wrapper_ship">
            <div class="row cart-body">
                <form class="form-horizontal" method="post" action="shipping_details.php">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-push-6 col-sm-push-6">
                    <!--REVIEW ORDER-->
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Review Order <div class="pull-right"><small><a class="afix-1" href="newncart.php">Edit Cart</a></small></div>
                        </div>
						<?php 
global $db;
$total = 0;
	$ip = getIp();
	$review_cart = "SELECT * FROM cart1 WHERE ip_address = '$ip'";
	$results = $db->query($review_cart);
	while ($p_price = mysqli_fetch_array($results))
	{
		$pro_id = $p_price['prod_id'];
		$pro_price = "SELECT * FROM products WHERE product_id = '$pro_id'";
		$run_pro_price = $db->query($pro_price);
		while($pp_price = mysqli_fetch_array($run_pro_price))
		{
			$product_price = array($pp_price['product_price']);
			$product_title = $pp_price['product_title'];
			$single_price = $pp_price['product_price'];
			$product_image = $pp_price['product_image'];
			$quant = $p_price['quant'];
			$values = $single_price * $quant;
			$total += $values;
		?>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-3">
                                    <img class="img-responsive" src="<?=$product_image;?>" style="height:60px; width:60px;" />
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <div class="col-xs-12"><?=$product_title;?></div>
                                    <div class="col-xs-12"><small>Quantity:<span><?=$quant;?></span></small></div>
                                </div>
                                <div class="col-sm-3 col-xs-3 text-right">
                                    <h6><span><?=money($values);?></span></h6>
                                </div>
                            </div>
                            <div class="form-group"><hr /></div>
	
                            <!-- for shipping charge 
							<div class="form-group">
                                <div class="col-xs-12">
                                    <strong>Subtotal</strong>
                                    <div class="pull-right"><span>$</span><span>200.00</span></div>
                                </div>
                                <div class="col-xs-12">
                                    <small>Shipping</small>
                                    <div class="pull-right"><span>-</span></div>
                                </div>
                            </div> -->
							<?php } } ?>
            
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <strong>Order Total</strong>
                                    <div class="pull-right"><span><?=money($total);?></span></div>
                                </div>
                            </div>
                        </div> </div>
                    </div>
                    <!--REVIEW ORDER END-->
                
				 
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-pull-6 col-sm-pull-6">
                    <!--SHIPPING METHOD-->
					
                    <div class="panel panel-info">
                        <div class="panel-heading">Address</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <h4>Shipping Address</h4>
                                </div>
                            </div>
							<div class="form-group">
							<div class="col-md-12"> <strong>Deliver to : </strong></div>
							</div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <strong>Name: </strong> 
<div class="col-md-12">	<?=$cust_name;?> </div>								
                                </div>                              
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Address:</strong></div>
                                <div class="col-md-12">
                                    <?=$address;?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Phone Number:</strong></div>
                          <div class="col-md-12"> <?=$phone;?>  </div>   
								</div>
                           
                            <div class="form-group">
                                <div class="col-md-12"><strong>Email Address:</strong></div>
                                <div class="col-md-12"> <?=$email;?></div>
                            </div>
							<div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <a href="shipping_details_confirm.php" class="btn btn-primary btn-submit-fix">EDIT SHIPPING ADDRESS</a>
                                </div>
                            </div>
                        </div>
                    </div></div>
                    <!--SHIPPING METHOD END-->
                
                <div class="form-group pull-right">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <button type="submit" name="confirm" class="btn btn-primary btn-submit-fix" style="padding-right:15px;">Confirm Order</button>
                                </div>
							<?php	if(isset($_POST['confirm']))
								{
	
	//insert into ORDER table
	 $sql1 = "INSERT INTO orders (cust_id, date,cust_ip) VALUES ('$customer_id','yyyy-mm-dd','$ip')";
	 $run_sql1 = $db->query($sql1);
	
//	fetch order id
	$sql3 = "SELECT * FROM orders WHERE cust_ip = '$ip' AND order_status=0";
	$run_sql3 = $db->query($sql3);
	$result_sql3 = mysqli_fetch_assoc($run_sql3);
	$order_id = $result_sql3['order_id'];
	
	//fetch from cart
	$sql4 = "SELECT * FROM cart1 WHERE ip_address = '$ip'";
	$run_sql4 = $db->query($sql4);
	$result_sql4 = mysqli_fetch_assoc($run_sql4);
	$product_id = $result_sql4['prod_id'];
	$quantity = $result_sql4['quant'];
	
	//insert into order_product table
	$sql2 = "INSERT INTO order_product (order_id, product_id, prod_quantity,total_amount) VALUES ('$order_id','$product_id','$quantity',$total')";
	$run_sql2 = $db->query($sql2);

	
	//delete from cart
	// $sql_del = "DELETE FROM cart1 WHERE cust_ip = '$ip'";
	// $run_sql_del = $db->query($sql_del);
	echo "<script>window.open('order_placed.php','_self')</script>";
} ?>
                            </div>
                </form>
            
    </div>

</body>
<?php 
include('footer.php');
?>