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
		<h2 class="text-center">Shipping Detail</h2><hr>

			<table class="table table-bordered table-condensed table-striped">
					<thead><th>#</th><th>Order ID</th><th>Customer ID</th><th>Customer Name</th><th>Customer Phone</th><th>Shipping Address</th><th>Postal Code</th></thead>
					<tbody>
					<?php 
					$i=1;
if(isset($_GET['o_id']))
{
	$order_id = $_GET['o_id'];
}
//select order id and cust id
$sql = "SELECT * FROM orders WHERE order_id = '$order_id'";
$run_sql= $db->query($sql);
while($order_run = mysqli_fetch_assoc($run_sql))
{
$cust_id = $order_run ['cust_id'];

//cust details
$sql1 = "SELECT * FROM customers WHERE cust_id = '$cust_id'";
$run_sql1= $db->query($sql1);
while($run_cust = mysqli_fetch_assoc($run_sql1))
{
					?>
					<tr>
					<td><?=$i++;?></td>
					<td><?=$order_id;?></td>
					<td><?=$cust_id;?></td>
					<td><?=$run_cust['cust_name'];?></td>
					<td><?=$run_cust['cust_phone'];?></td>
					<td><?=$run_cust['cust_address'];?></td>
					<td><?=$run_cust['zip_code'];?></td>
					</tr>
<?php } } ?>
					</tbody>
					</table>
					</div>
					</div>
					</div>
