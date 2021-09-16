<?php 
require_once 'init.php';
include('header.php');

 
 if(isset($_GET['search']))
 { 
$search_query = $_GET['user_query'];
$sql = "SELECT * FROM products WHERE keywords like '%$search_query%'";
$productQ = $db->query($sql);
 
?>
<div class="container-fluid" style="background-color:white;">
<!-- left side bar -->
<?php include 'leftsidebar.php'; ?>

<!-- main -->
<div class="col-md-9 col-lg-9">
<div class="row">

	<?php
			while($product = mysqli_fetch_assoc($productQ)) : 
			?> <!-- productQ-->
		<div class="col-md-4 col-lg-4 col-sm-8 col-xs-8">
			<div class="thumbnail">
		<img src="<?= $product ['product_image']; ?>" alt="<?= $product['product_title']; ?>" class="img-thumb">
				<div class="caption" style="text-align: center">
				<strong><?= $product['product_title']; ?> </strong>
		<p><?= money($product['product_price']); ?></p> 
		<button type="button" class="btn btn-default green"><a href="details.php?id=<?=$product['product_id']?>" id="details_btn" target="_blank">Details</a></button>
		<button type="button" class="btn btn-default"><a href="cart1.php?id=<?=$product['product_id']?>"><span class="glyphicon glyphicon-shopping-cart green"> Add to Cart</span></a></button>
				</div>
				</div></div>
				<?php endwhile; ?>
</div></div>
<!-- End of main content -->
 
 <?php } include('footer.php'); ?>