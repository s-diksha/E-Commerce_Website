<?php
require_once 'init.php';
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$c=1;
	$ip = getIp();
// Delete product from cart
if(isset($_GET['delete']) && !empty($_GET['delete']))
{
	$delete_id = (int)$_GET['delete'];
	$delete_id = sanitize($delete_id);
	$sql = "DELETE FROM cart1 WHERE prod_id = '$delete_id' AND ip_address = '$ip'";
	$db->query($sql);
	header('Location: newncart.php');
}
	if(isset($_POST['update_cart']))
							{
								// $qty = $_POST['qty'];
								// $update_qty = "UPDATE cart1 SET quant='$qty'";
								// $run_query = $db->query($update_qty);
								// $_SESSION['qty'] = $qty;
								// $total = $total * $qty;
								if(isset($_POST['qty']))
								{
								$qty = $_POST['qty'];
								$ids = $_POST['id'];
								$array = array_combine($qty,$ids);
								foreach($array as $q => $i)
								{
									$update_qty = "UPDATE cart1 SET quant='$q' WHERE prod_id ='$i'";
									$run_query = $db->query($update_qty);
									header("Location: newncart.php");
								}
		}} 
						
include('header.php');
?>
<head>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="cart_style.css" media="all"/>
</head>

<div class="container_main_cart">
	<form action="" method="post" enctype="multipart/form-data">
<div class="col-md-12">
	<div class="row">
		<h2 class="text-center">My Shopping Cart</h2><hr>
<table id="cart" class="table table-hover table-condensed table-striped"> 
    							
<thead class="text-center">
			
<tr>
		<th style="width:5%" class="text-center">#</th><th style="width:45%" class="text-center">Item</th><th style="width:10%" class="text-center">Price</th><th style="width:8%" class="text-center">Quantity</th><th style="width:22%"  class="text-center">Sub Total</th><th style="width:10%" class="text-center">Remove</th>				
	</tr>
	</thead>
		<tbody>
			<?php
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
			$product_title = $pp_price['product_title'];
			$single_price = $pp_price['product_price'];
			$product_image = $pp_price['product_image'];
			$quant = $p_price['quant'];
			//$values = array_sum($product_price);
			$values = $single_price * $quant;
			$total += $values;
	?>	
		<tr class="text-center">
		<td ><?=$c++;?></td>
		<td>
		<!-- <div class="col-sm-2 hidden-xs"> -->
<?=$product_title;?><br>
	<img src="<?=$product_image;?>" class="img-responsive" style="width:60px; height:60px">
						</td>
		
		<td data-th="Price"><?=money($single_price);?></td>
		
		<td data-th="Quantity">	
		<input type="hidden" name="id[]" value="<?= $pro_id; ?>">
			<input type="number" size="3" name="qty[]" value="<?=$quant; ?>"></td>
<td data-th="Subtotal" class="text-center"><?= money($values); ?></td>
<td><a href="newncart.php?delete=<?=$p_price['prod_id']; ?>" class="btn btn-xs btn-default center"><span class="glyphicon glyphicon-remove-sign"></span></a></td></td>
						</tr>
						<?php }
	} ?>
					</tbody>
			
		<tfoot>
						
<tr class="visible-xs">
	<td class="text-center"><strong><?= money($total); ?></strong></td>
	
					</tr>
						<tr>
						
	<td><a href="index.php" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
							<td colspan="2" class="hidden-xs"></td>
		<td><button type="submit" name="update_cart" class="btn btn-info">Update Quantity <i class="fafa-angle-right"></i></button></td>
					<td class="hidden-xs text-center"><strong> Total Amount : <?= money($total); ?></strong></td>
					

<td><a href="checkout.php" class="btn btn-success btn-block">Checkout <i class="fafa-angle-right"></i></a></td>

						</tr>
					
</tfoot>
			
	</table>
</div></div></div>
<?php include('footer.php'); ?>