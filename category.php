<?php 
require_once 'init.php';
include('header.php');

 if(isset($_GET['cat']))
 { 
	 $cat_id = sanitize($_GET['cat']);
 }else {
	 $cat_id = '';
 }
$sql = "SELECT * FROM products WHERE product_categ = '$cat_id'";
$productQ = $db->query($sql);
//$category = mysqli_fetch_assoc($productQ);

		 $sqlCat = "SELECT p.cat_id AS 'pid', p.cat_name AS 'parent', c.cat_id AS 'cid', c.cat_name AS 'child' FROM categories c INNER JOIN categories p ON c.parent = p.cat_id WHERE c.cat_id = '$cat_id' ";
		    $newquery = $db->query($sqlCat);
		    $category = mysqli_fetch_assoc($newquery);
		 
?>
<!-- <div class="container" style="width:98%; height:400px; background-color:white; margin-top: 10px;"> -->
<div class="container-fluid" style="background-color:white;">
<!-- left side bar -->
<?php include 'leftsidebar.php'; ?>

<!-- main -->
<div class="col-md-9 col-lg-9">
<div class="row">
<h5 class="text-center"><?=$category['parent']. ' - ' . $category['child'];?> </h5> 
	<?php
			while($product = mysqli_fetch_assoc($productQ)) : ?> <!-- productQ-->
		<div class="col-md-4 col-lg-4 col-sm-8 col-xs-8"> 
			<div class="thumbnail">
		<img src="<?= $product ['product_image']; ?>" alt="<?= $product['product_title']; ?>" class="img-thumb">
				<div class="caption" style="text-align: center">
				<strong><?= $product['product_title']; ?> </strong>
		<p><h6><?= money($product['product_price']); ?></h6></p> 
		<button type="button" class="btn btn-default green"><a href="product_details.php?id=<?=$product['product_id']?>" id="details_btn" target="_blank">Details</a></button>
		<button type="button" class="btn btn-default"><a href="newncart.php?add_cart=<?=$product['product_id']?>"><span class="glyphicon glyphicon-shopping-cart green"> Add to Cart</span></a></button>
				</div>
				</div></div>
				<?php endwhile; ?>
</div></div>
<!-- End of main content -->


<?php include('footer.php'); ?>



