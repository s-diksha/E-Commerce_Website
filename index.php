<?php 
require_once 'init.php';
include('header.php');
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
 ?>
	
<!-- IMAGE SLIDER FOR BANNERS-->
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
    <li data-target="#carousel-example-generic" data-slide-to="3"></li>
	 <li data-target="#carousel-example-generic" data-slide-to="4"></li>
	 
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox" >
    <div class="item active">
      <img src="images/1.jpg" alt="1"  style="width:90%;height:400px;margin: 0 auto;">
      <div class="carousel-caption">
       
      </div>
    </div>
    <div class="item">
      <img src="images/2.jpg" alt="2" style="width:90%;height:400px;margin: 0 auto;">
      <div class="carousel-caption">
        
      </div>
    </div>
   <div class="item">
      <img src="images/3.jpg" alt="3" style="width:90%;height:400px;margin: 0 auto;">
      <div class="carousel-caption">
        
      </div>
    </div>
	<div class="item">
      <img src="images/4.jpg" alt="4" style="width:90%;height:400px;margin: 0 auto;">
      <div class="carousel-caption">
        
      </div>
    </div>
	<div class="item">
      <img src="images/5.jpg" alt="5" style="width:90%;height:400px;margin: 0 auto;">
      <div class="carousel-caption">
        
      </div>
    </div>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<!-- END OF IMAGE SLIDER -->
<div class="clearfix">  
</div>
<!-- Main content -->

<?php 
$sql = "SELECT * FROM products WHERE latest = 1";
$latest = $db->query($sql);
?>
<div class="container_index" style="width:100%; height:400px; background-color:white;">
<h5 class="text-center">Latest Products</h5>

<?php 
while($product = mysqli_fetch_assoc($latest)) : ?>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-6 col-xs-6">
			<div class="thumbnail">
		<img src="<?= $product['product_image']; ?>" alt="<?= $product['product_title']; ?>">
				<div class="caption" style="text-align: center">
				<h6><?= $product['product_title']; ?> </h6>
		<p id="cap_price"><?= $product['product_price']; ?></p> 
		<button type="button" class="btn btn-default green"><a href="product_details.php?id=<?=$product['product_id']?>" id="details_btn" target="_blank">Details</a></button>
		<button type="button" class="btn btn-default"><a href="newncart.php?add_cart=<?=$product['product_id']?>"><span class="glyphicon glyphicon-shopping-cart green"> Add to Cart</span></a></button><?php cart();?>
				</div>
			</div>
			
	</div>
	<?php endwhile; ?>
	<!-- Button trigger modal -->
</div>
<?php include('footer.php'); ?>


