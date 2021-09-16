<?php 
require_once '../init.php';

if(!is_logged_in())
{
	login_error_redirect();
}
if(!has_permission('admin'))
{
	permission_error_redirect('index.php');
}
include 'includes/head.php';
include 'includes/navigation.php';

?>

<div class="container_main_order">
	<form action="" method="post" enctype="multipart/form-data">
<div class="col-md-12">
	<div class="row">
		<h2 class="text-center">Orders</h2><hr>

 <!-- <div class="bg-danger">
			<p class="text-center text-danger">
				Your shoppping cart is empty...
			</p>
			</div> -->

			<table class="table table-bordered table-condensed table-striped">
					<thead><th>#</th><th>Order ID</th><th>Product ID</th><th>Quantity</th><th>Amount</th><th>Shipping Detail</th></thead>
					<tbody>
					<?php
$i=1;

//select order id 
$sql = "SELECT * FROM orders WHERE order_status = 0";
$run_sql= $db->query($sql);
while($order_run = mysqli_fetch_assoc($run_sql))
{
$order_id = $order_run ['order_id'];

//order_product
$sql1 = "SELECT * FROM order_product WHERE order_id = '$order_id'";
$run_sql1= $db->query($sql1);
while($order_product_run = mysqli_fetch_assoc($run_sql1))
{
 $product_id = $order_product_run['product_id'];
 $product_quant = $order_product_run['prod_quantity'];

 $sql3 = "SELECT * FROM products WHERE product_id = '$product_id'";
 $run_sql3= $db->query($sql3);
 while($product_run = mysqli_fetch_assoc($run_sql3))
{
?>
					<tr>
					 <td><?=$i++;?></td>
					 <td><?=$order_id;?></td>
					 <td><?=$product_id;?></td>
					 <td><?=$product_quant;?></td>
					 <td><?=$order_product_run['total_amount'];?></td>
					 <td><a href="order_detail_cust.php?o_id=<?=$order_id;?>">View Detail</a></td>
					</tr>
<?php } } } ?>
					</tbody>
					</table>
					</div>
					</div>
					</div>