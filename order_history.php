<?php 
require_once 'init.php';
include('header.php');
?>

<h2 class= "text-center">Order History</h2>
<div class="container_main_cart">
	<form action="" method="post" enctype="multipart/form-data">
<div class="col-md-12">
	<div class="row">
			<table class="table table-bordered table-condensed table-striped">
					<thead><th>#</th><th>Item</th><th>Price</th><th>Quantity</th><th>Sub Total</th><th>Remove</th></thead>
					<tbody>
		
	<?php
	$total = 0;
	global $db;
$ip = getIp();
$sql = "SELECT * FROM cart1 WHERE ip_address = '$ip'";
$results = $db->query($sql);
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
<tr>
						<td><?=$c++;?></td>
						<td><?=$product_title;?><br>
						<img src="<?=$product_image;?>" width="60" height="60">
						</td>
						<td><?=money($single_price);?></td>
						<!-- here was the previous update code -->
							 
							<!--<td><input type="number" size="4" name="qty" value="=$_SESSION['qty'];?>"> </td>-->
							<!-- Hidden column for update quant-->
						
							<td><?=$quant; ?></td>
						 <td><?= $values; ?></td>
						<td><a href="newncart.php?delete=<?=$p_price['prod_id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
						</tr>
						<?php }
	} ?>
					</tbody>
					
					</table>
  
<h2 class="pull-right"> Total : <?php echo money($total); ?></h2>
					
	</form>
</div>
<?php include 'footer.php'; ?>