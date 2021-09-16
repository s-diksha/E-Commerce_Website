<?php 
require_once 'init.php';
include('header.php');

if(isset($_GET['id']))
{
	$id = $_GET['id'];
}
else { $id='';}
$id=(int)$id;
$sql="SELECT * FROM products WHERE product_id = '$id' ";
$results = $db->query($sql);
$product = mysqli_fetch_assoc($results);

// $brand_id = $product['brand_id'];
// $sql = "SELECT brand_title FROM brand WHERE brand_id='$brand_id'";
// $brand_query = $db->query($sql);
 // $brand = mysqli_fetch_assoc($brand_query);
 // var_dump($brand);
 ?>
 
 <div class="clearfix"></div>
 <?php ob_start(); ?>
 <div class="container-fluid" id="details-page" style="height: 40%; background-color: #FDEDEC; margin: 10px">
 <div class="rows" style="margin: 6px; ">
 <span id="perrors" class="bg-danger"></span>
	<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
		<img id="zoom" class="img-responsive img-thumbnail" src="<?=$product['product_image'];?>" alt="<?=$product['product_title'];?>" data-zoom-image="images/large/trial.jpg" style="width:350px; height:500px; position:relative" >
	</div> 
	<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
		<h5><?=$product['product_title'];?></h5><br/><br>
		<h5>Price : <?=$product['product_price'];?></h5><br>
		
		<input type="hidden" name="product_id" value="<?=$id;?>">
		<input type="hidden" name="available" id="available" value="">
		<div class="form-group">
			<div class="col-xs-3">
				<!-- <label for="quantity"><h5> Available Quantity :=$product['prod_quantity'];?></h5></label> -->
				<h5>Quantity : <input type="text" class="form-control" name="quantity" value="1"></h5><br>
			</div>
		</div>
		</form>
		<h5>Description : <?=$product['product_desc'];?></h5><br>
		<div class="btn-group btn-group-justified">
    <a href="newcart.php?add_cart=<?=$product['product_id']?>" class="btn btn-success">Add To Cart</a> <?php cart();?>
    <a href="#" class="btn btn-success">Buy Now</a>
	</div>
	</div>
 </div>
</div>

<?php echo ob_get_clean(); 

	include('footer.php'); ?>