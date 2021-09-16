
<?php 
require_once 'init.php';
include('header.php');
$ip = getIp();
$address=((isset($_POST['address']))?sanitize($_POST['address']):'');
$pin = ((isset($_POST['zip_code']))?sanitize($_POST['zip_code']):'');

if($_POST)
{
	$sql_insert="UPDATE customers SET cust_address = '$address', zip_code = '$pin' WHERE cust_ip = '$ip'"; 
	$result = $db->query($sql_insert);
	echo "<script>window.open('shipping_details.php','_self')</script>";
}

?>
<head>
<link rel="stylesheet" href="shipping_style.css" media="all"/>
</head>
<body>
<div class="container_ship wrapper_ship">
            <div class="row cart-body">
                <form class="form-horizontal" method="post" action="">
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
                    <!--SHIPPING METHOD
					 <div class="row address-body"> -->
                    <div class="panel panel-info">
                        <div class="panel-heading">Address</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4>Shipping Address</h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Address:</strong></div>
                                <div class="col-md-12">
                                    <input type="text" name="address" class="form-control" value="<?=$address;?>" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Zip / Postal Code:</strong></div>
                                <div class="col-md-12">
                                    <input type="text" name="zip_code" class="form-control" value="<?=$pin;?>" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--SHIPPING METHOD END-->
                </div>
				<div class="clearfix"></div>
                <div class="form-group pull-right">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <button type="submit" name="confirm" class="btn btn-primary btn-submit-fix">Confirm Details</button>
                                </div>
                            </div>
                </form>
            
    </div>

</body>
<?php 
include('footer.php');
?>