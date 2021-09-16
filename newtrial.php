<?php 
require_once 'init.php';
?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
 <?php 
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE-edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="jq/jquery-3.1.1.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
 
	<script src='jq/jquery.elevateZoom-3.0.8.min.js'></script>
	<title>Snehaanjali Electronics - The Most Trusted Electronics Planet</title>
 <link rel="stylesheet" type="text/css" href="http://localhost/Projectphp/style.css" media="all">	
<link rel="stylesheet" href="http://localhost/Projectphp/EasyZoom-master/css/easyzoom.css" />
<style>
.navbar {
    margin-bottom: 0;

	.form-control{width:20%}
	.add-on .input-group-btn > .btn {
  border-left-width:0;left:-2px;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}
/* stop the glowing blue shadow */
.add-on .form-control:focus {
 box-shadow:none;
 -webkit-box-shadow:none; 
 border-color:#cccccc; 
}

</style>
<script>
$(document).ready(function(){
    $("button").click(function(){
        $("a[target='_blank']").open();
    });
});
</script>
	</head>
	<body>
<div id="wrap">

    <div class="navbar navbar-default" >
        <div class="container" style="width:97%;height:18%">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".main-nav">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse main-nav">
                <ul class="nav navbar-nav">
                    <li><a class="navbar-brand" href="index.php"><img src="images/logo1.png" alt="Snehaanjali Electronics"style="margin-top:0px;margin-bottom:5px;padding-top:0px;width:214px;height:65px"></a></li>
					<li class="divider-vertical"></li>
                    <li style="margin-top:15px;margin-left:210px">
					<form action="results.php?" method="get" class="navbar-form" role="search" enctype="multipart/form-data">
    <div class="input-group add-on">
      <input class="form-control" placeholder="Search Your Product.." name="user_query" id="search" type="text">
      <div class="input-group-btn">
        <button class="btn btn-default" type="submit" name="search"><i class="glyphicon glyphicon-search"></i></button>
      </div>
    </div>
  </form></li>

                    <li class="divider-vertical"></li>
                    <li style="margin-top:15px;margin-left:250px"><a href="index.php"><span class="glyphicon glyphicon-home"> Home</span></a></li>
                    <li class="divider-vertical"></li>
                    <li style="margin-top:15px;">
<?php
if(!isset($_SESSION['$cust'])) //cust_email
	{
		echo "<a href='login2.php'><span class='glyphicon glyphicon-off'> Login</a></span>";
	}
	else
	{
		echo "<a href='logout.php'><span class='glyphicon glyphicon-off'>Logout</a></span>";
	}
?>
	</li>
                    <li class="divider-vertical"></li>
                    <li style="margin-top:15px;"><a href="signup.php"><span class="glyphicon glyphicon-user"> Register</span></a></li>
               </div>
                </ul>
          
       </div>
    </div>
	
	<div class="navbar navbar-inverse">
    <div class="container" style="margin-top:5px">
<?php 
$sql = "SELECT * FROM categories WHERE parent=0";
$pquery = $db->query($sql);
?>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-left">
			<?php 
	while($parent = mysqli_fetch_assoc($pquery)) : ?>
<?php 
	$parent_id = $parent['cat_id']; 
	$sql2 = "SELECT * FROM categories WHERE parent = '$parent_id' ";
	$cquery = $db->query($sql2);
	?><li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="details.php?id=<?=$product['product_id']?>"><?php echo $parent['cat_name']; ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
		  <li class="divider-vertical"></li>
<?php 
		  while($child = mysqli_fetch_assoc($cquery)) :
		  ?>
		  <li><a href="category.php?cat=<?=$child['cat_id'];?>"><?php echo $child['cat_name']; ?></a></li>
<?php endwhile; ?>
		  </ul>
        </li>
<?php endwhile; ?>

<li><a href="newncart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Total Items :&nbsp; <?php total_items();?> 
        </div><?php cart();?></a></li>
            
        </div>
    </div>
</div>
<div style="clear:both"></div>
<!-- -------------------- END HEAAADDEERRR-->
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

