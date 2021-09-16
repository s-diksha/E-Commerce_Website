<?php 
require_once 'init.php';
include('header.php');

if(isset($_GET['id']))
{
	$id = $_GET['id'];
}
else { $id='';}
$id=(int)$id;
$sql="SELECT * FROM products WHERE product_id ='$id'";
$results = $db->query($sql);
$product = mysqli_fetch_assoc($results);
?>
<head>
 <link rel="stylesheet" href="details_style.css" media="all" />
<script src="jq/details.js"></script>
</head>
<div class="container-fluid" style="background-color:white;">
<!-- left side bar -->
<?php include 'leftsidebar.php'; ?>

<!-- main -->
<div class="col-md-9 col-lg-9 cont_detail">
<!-- <div class="container"> -->
	<div class="row">
   <div class="col-xs-4 item-photo">
                    <img id="zoom" class="img-responsive img-thumbnail" style="max-width:100%;" src="<?=$product['product_image'];?>" alt="<?=$product['product_title'];?>" data-zoom-image="images/large/trial.jpg"/> <!-- images/large/trial.jpg -->
                </div>
                <div class="col-xs-5" style="border:0px solid gray">
                    <!-- Datos del vendedor y titulo del producto -->
                    <h3><?=$product['product_title'];?></h3>    
                    <h5 style="color:#337ab7">Brand : <a href="#">Samsung</a> · <small style="color:#337ab7">(sold :)</small></h5>

                    <!-- Price -->
                    <h6 class="title-price"><small>PRICE</small></h6>
                    <h3 style="margin-top:0px;"><?=money($product['product_price']);?></h3>

                    <!-- Detail Specification of product -->
                    <div class="section">
                        <h6 class="title-attr" style="margin-top:15px;" ><small>COLOR</small></h6>                    
                        <div>
                            <div class="attr" style="width:25px;background:#5a5a5a;"></div>
                            <div class="attr" style="width:25px;background:white;"></div>
                        </div>
                    </div>
                   <!-- <div class="section" style="padding-bottom:5px;">
                        <h6 class="title-attr"><small>CAPACIDAD</small></h6>                    
                        <div>
                            <div class="attr2">16 GB</div>
                            <div class="attr2">32 GB</div>
                        </div>
                    </div>   -->
                    <div class="section" style="padding-bottom:20px;">
					
                        <h6 class="title-attr"><small>Quantity</small></h6>                    
                        <div>
						<input type="hidden" name="id[]" value="<?= $pro_id; ?>">
						<input type="number" size="3" name="qty[]" value="<?=$quant; ?>"></td>
                            <!--<div class="btn-minus"><span class="glyphicon glyphicon-minus"></span></div>
                            <input value="1" />
                            <div class="btn-plus"><span class="glyphicon glyphicon-plus"></span></div> -->
                        </div>
                    </div>                

                    <!-- Botones de compra -->
                    <div class="section" style="padding-bottom:20px;">
                        <a href="newncart.php?add_cart=<?=$product['product_id']?>"><button class="btn btn-success"><span style="margin-right:20px" class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Add To Cart</button></a>
                        <h6><span class="glyphicon glyphicon-heart-empty" style="cursor:pointer;"></span> Add To WishList</h6>
                    </div>                                        
                </div>                              

                <div class="col-xs-9">
                    <ul class="menu-items" style="font-size:15px">
                        <li class="active">Details</li>
                        <li>Warranty</li>
                    </ul>
                    <div style="width:100%;border-top:1px solid silver">
                        <p style="padding:15px;">
                            <small>
                            <?=$product['product_desc'];?>
                            </small>
                        </p>
                        <small>
                        <ul>
                            <li>Super AMOLED capacitive touchscreen display with 16M colors</li>
                            <li>Available on GSM, AT&T, T-Mobile and other carriers</li>
                            <li>Compatible with GSM 850 / 900 / 1800; HSDPA 850 / 1900 / 2100 LTE; 700 MHz Class 17 / 1700 / 2100 networks</li>
                            <li>MicroUSB and USB connectivity</li>
                            <li>Interfaces with Wi-Fi 802.11 a/b/g/n/ac, dual band and Bluetooth</li>
                            <li>Wi-Fi hotspot to keep other devices online when a connection is not available</li>
                            <li>SMS, MMS, email, Push Mail, IM and RSS messaging</li>
                            <li>Front-facing camera features autofocus, an LED flash, dual video call capability and a sharp 4128 x 3096 pixel picture</li>
                            <li>Features 16 GB memory and 2 GB RAM</li>
                            <li>Upgradeable Jelly Bean v4.2.2 to Jelly Bean v4.3 Android OS</li>
                            <li>17 hours of talk time, 350 hours standby time on one charge</li>
                            <li>Available in white or black</li>
                            <li>Model I337</li>
                            <li>Package includes phone, charger, battery and user manual</li>
                            <li>Phone is 5.38 inches high x 2.75 inches wide x 0.13 inches deep and weighs a mere 4.59 oz </li>
                        </ul>  
                        </small>
                    </div>
                </div>		
	</div>
</div></div>

<?php include 'footer.php'; ?>