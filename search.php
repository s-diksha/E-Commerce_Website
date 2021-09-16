<?php 
require_once 'init.php';
include('header.php');


$cat_id = (($_POST['cat'] != '')?sanitize($_POST['cat']):'');
$price_sort = (($_POST['price_sort'] != '')?sanitize($_POST['price_sort']):'');
$min_price = (($_POST['min_price'] != '')?sanitize($_POST['min_price']):'');
$max_price = (($_POST['max_price'] != '')?sanitize($_POST['max_price']):'');
$brand = (($_POST['brand'] != '')?sanitize($_POST['brand']):'');

//$sql = "SELECT * FROM products";
if($cat_id == '') {
$sql = " SELECT * FROM products WHERE deleted = 0"; }
else {
	$sql = " SELECT * FROM products WHERE product_categ = '$cat_id' AND deleted = 0";
}

if($min_price != '')
{
	$sql = "SELECT * FROM products WHERE product_price >= '$min_price'";
}
if($max_price != ''){
	$sql = "SELECT * FROM products WHERE product_price <= '$min_price'";
}
if($brand != ''){
	$sql = "SELECT * FROM products WHERE product_brand = '$brand'";
}
if($price_sort == 'low')
{
	$sql = "SELECT * FROM products ORDER BY product_price";
}
if($price_sort == 'high')
{
	$sql = "SELECT * FROM products ORDER BY product_price DESC";
}
$productQ = $db->query($sql);
//$category = mysqli_fetch_assoc($productQ);

		 $sqlCat = "SELECT p.cat_id AS 'pid', p.cat_name AS 'parent', c.cat_id AS 'cid', c.cat_name AS 'child' FROM categories c INNER JOIN categories p ON c.parent = p.cat_id WHERE c.cat_id = '$cat_id' ";
		    $newquery = $db->query($sqlCat);
		    $category = mysqli_fetch_assoc($newquery);
			var_dump($category);
?>
<!-- <div class="container" style="width:98%; height:400px; background-color:white; margin-top: 10px;"> -->
<div class="container-fluid" style="background-color:white;">
<!-- left side bar -->
<?php include 'leftsidebar.php'; ?>

<!-- main -->
<div class="col-md-9 col-lg-9">
<div class="row">
<?php if($cat_id != ''): ?>
<h5 class="text-center"><?=$category['parent']. ' - ' . $category['child'];?> </h5> 
<?php else : ?>
<h5 class="text-center"> All Products</h5>
<?php endif; ?>
	<?php
			while($product = mysqli_fetch_assoc($productQ)) : ?> <!-- productQ-->
		<div class="col-md-4 col-lg-4 col-sm-8 col-xs-8"> 
			<div class="thumbnail">
		<img src="<?= $product ['product_image']; ?>" alt="<?= $product['product_title']; ?>" class="img-thumb">
				<div class="caption" style="text-align: center">
				<strong><?= $product['product_title']; ?> </strong>
		<p><h6><?= money($product['product_price']); ?></h6></p> 
		<button type="button" class="btn btn-default green"><a href="details.php?id=<?=$product['product_id']?>" id="details_btn" tarPOST="_blank">Details</a></button>
		<button type="button" class="btn btn-default"><a href="newncart.php?add_cart=<?=$product['product_id']?>"><span class="glyphicon glyphicon-shopping-cart green"> Add to Cart</span></a></button>
				</div>
				</div></div>
				<?php endwhile; ?>
</div></div>
<!-- End of main content -->


<?php include('footer.php'); ?>



