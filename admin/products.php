<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Projectphp/init.php';
if(!is_logged_in())
{
	login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';

//Delete Product
if(isset($_GET['delete']))
{
	$id = sanitize($_GET['delete']);
	$db->query("UPDATE products SET deleted=1 WHERE product_id='$id'");
	header('Location: prodcuts.php');
}

if(isset($_GET['add']) || isset($_GET['edit'])) {
	$brandQuery = $db->query("SELECT * FROM brand ORDER BY brand_title");
	$parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY cat_name");
	$title = ((isset($_POST['product_title']) && $_POST['product_title']!='')?sanitize($_POST['product_title']):'');
	$brand=((isset($_POST['product_brand']) && !empty($_POST['product_brand']))?sanitize($_POST['product_brand']):'');
	$parent=((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):'');
	$category=((isset($_POST['child']) && !empty($_POST['child']))?sanitize($_POST['child']):'');
	$price = ((isset($_POST['product_price']) && $_POST['product_price']!='')?sanitize($_POST['product_price']):'');
	$description = ((isset($_POST['product_desc']) && $_POST['product_desc']!='')?sanitize($_POST['product_desc']):'');
	$saved_image = '';
	$dbpath='';
	
	if(isset($_GET['edit'])) { 
	$edit_id = (int)$_GET['edit'];
	$productResults = $db->query("SELECT * FROM products WHERE product_id='$edit_id' ");
	$product = mysqli_fetch_assoc($productResults);
	
	// delete the image
	if(isset($_GET['delete_image']))
	{
		$image_url = $_SERVER['DOCUMENT_ROOT'].$product['product_image'];echo $image_url;
		unlink($image_url);
		$db->query("UPDATE products SET product_image = '' WHERE product_id = '$edit_id' ");
		header('Location: products.php?edit='.$edit_id);
	}
	$category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['product_categ']);
	$title=((isset($_POST['product_title']) && !empty($_POST['product_title']))?sanitize($_POST['product_title']):$product['product_title']);
	$brand=((isset($_POST['product_brand']) && !empty($_POST['product_brand']))?sanitize($_POST['product_brand']):$product['product_brand']);
	$productQ = $db->query("SELECT * FROM categories WHERE cat_id='$category' ");
	$parentResults = mysqli_fetch_assoc($productQ);
	$parent=((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):$parentResults['parent']);
	$price=((isset($_POST['product_price']) && !empty($_POST['product_price']))?sanitize($_POST['product_price']):$product['product_price']);
	$description=((isset($_POST['product_desc']) && !empty($_POST['product_desc']))?sanitize($_POST['product_desc']):$product['product_desc']);
	$saved_image = (($product['product_image'] != '')?$product['product_image']:'');
	$dbpath='$saved_image';
	}
if($_POST)
{	
	$categories=sanitize($_POST['child']);
	$price = sanitize($_POST['price']);
	$description = sanitize($_POST['description']);
	$errors = array();
	$required= array('title','brand','price','parent','child');
	foreach($required as $field){
		if($_POST[$field]=='') {
			$errors[] = 'All Fields with an Astrisk * is required.';
			break;
		}
	}
	if(!empty($_FILES))
	{
		$photo = $_FILES['photo'];
$name = $photo['name'];
$nameArray = explode('.',$name);
$fileName = $nameArray[0];
$fileExt = $nameArray[1];
$mime = explode('/',$photo['type']);
$mimeType = $mime[0];
$mimeExt = $mime[1];
$tmpLoc = $photo['tmp_name'];
$fileSize = $photo['size'];
$allowed = array('png','jpg','jpeg','gif');
$uploadName = md5(microtime()).'.'.$fileExt;
$uploadPath = BASEURL.'images/products/'.$uploadName;
$dbpath = '/Projectphp/images/products/';
if($mimeType != 'image')
	{
		$errors[] = 'The file must be an image ';
	}
	if(!in_array($fileExt,$allowed)) 
	{
		$errors[] = 'The photo extension must be a png, jpg, jpeg or gif.';
	}
	if($fileSize > 1500000)
	{
		$errors[] = 'the file must be under 15MB.';
	}
	if($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg'))
		{
			$errors[] = 'File extension does not match the file.'; 
		}
	}
	if(!empty($errors)) {
	echo display_errors($errors);
	}else {
		//upload file and insert into database
		if(!empty($_FILES)){
		move_uploaded_file($tmpLoc,$uploadPath); 
		///update databse
		$insertSql = "INSERT INTO products (product_title, product_price, product_categ, product_brand, product_desc, product_image) VALUES ('$title','$price','$category','$brand','$description','$dbpath')";
		$db->query($insertSql);
		header('Location: products.php');
		}
		if(isset($_GET['edit']))
		{
			$insertSql = "UPDATE products SET product_title = '$title', product_price ='$price', product_categ = '$category', product_brand='$brand',product_desc = '$description',product_image = '$dbpath' WHERE product_id = '$edit_id' ";
		
		$db->query($insertSql);
		header('Location: products.php');
			}
}}

	?>
	
	<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit A ':'Add A New ');?>Product</h3><hr>
		<form action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="POST" enctype="multipart/form-data">
			<div class="form-group col-md-3">
				<label for="title">Title * :</label>
				<input type="text" class="form-control" name="title" id="title" value="<?=$title;?>">
			</div>
			<div class="form-group col-md-3">
				<label for="brand">Brand * : </label>
				<select class="form-control" id="brand" name="brand">
					<option value=""<?=(($brand=='')?' selected':'');?>></option>
					<?php while($b = mysqli_fetch_assoc($brandQuery)) :	?>				
					<option value="<?=$b['brand_id'];?>"<?=(($brand == $b['brand_id'])?' selected':'');?>><?=$b['brand_title'];?></option>
					
					<?php endwhile; ?>
				</select>
			</div>
			<div class="form-group col-md-3">
				<label for="parent">Parent Category * : </label>
				<select class="form-control" name="parent" id="parent">
					<option value=""<?=(($parent=='')?'selected':'');?>></option>
						<?php while($p = mysqli_fetch_assoc($parentQuery)): ?>
							<option value="<?=$p['cat_id'];?>"<?=(($parent==$p['cat_id'])?'selected':'');?>><?=$p['cat_name'];?></option>
						
						<?php endwhile; ?>
				</select>
			</div>
				<div class="form-group col-md-3">
					<label for="child">Child Category * : </label>
					<select id="child" name="child" class="form-control"></select>
				</div>
				<div class="form-group col-md-3">
					<label for="price">Price * : </label>
					<input type="text" id="price" name="price" class="form-control" value="<?=$price;?>">
				</div>
				<div class="form-group col-md-3">
				<?php if($saved_image != ''): ?>
				<div class="saved-image">
					<img src="<?=$saved_image;?>" alt="saved image"/><br>
					<a href="products.php?delete_image=1&edit=<?=$edit_id;?>" class="text-danger">Delete Image</a>
				</div>
				<?php else: ?> 
					<label for="price">Product Photo: </label>
					<input type="file" name="photo" id="photo" class="form-control">
					<?php endif; ?>
				</div>
				<div class="form-group col-md-6">
					<label for="price">Description * : </label>
					<textarea name="description" id="description" class="form-control" rows="6"><?=$description;?></textarea>
				</div>
				<div class="form-group pull-right">
				<a href="products.php" class="btn btn-default">Cancel</a>
				<input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ');?> Product" class="btn btn-success">
				</div>
		</form>
<?php }
else {
$sql = "SELECT * FROM products WHERE deleted =0";
$presults = $db->query($sql);
if (isset($_GET['latest'])) {
	$id = (int)$_GET['product_id'];
	$featured = (int)$_GET['latest'];
	$fsql = "UPDATE products SET latest = '$featured' WHERE product_id = '$id' ";
	$db->query($fsql);
	header('Location: products.php');
	}	
?>
<h3 class="text-center">Products</h3><hr>
<a href="products.php?add=1" class="btn btn-success pull-right" id="prod_btn">Add product</a>
<div class="clearfix"></div><br>
<table class="table table-bordered table-condensed table-striped">
	<thead>
		<th></th><th>Product</th><th>Price</th><th>Category</th><th>Featured</th><th>Sold</th>
	</thead>
		<tbody>
			<?php while($product = mysqli_fetch_assoc($presults)): 
				$childID = $product['product_categ'];
				$catsql = "SELECT * FROM categories WHERE cat_id = '$childID'";
				$result = $db->query($catsql);
				$child = mysqli_fetch_assoc($result);
				$parentID = $child['parent'];
				$pSql = "SELECT * FROM categories WHERE cat_id = '$parentID'";
				$presult = $db->query($pSql);
				$parent = mysqli_fetch_assoc($presult);
				$category = $parent['cat_name'].'-'.$child['cat_name'];
			?>
			<tr>
				<td>
					<a href="products.php?edit=<?=$product['product_id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
					<a href="products.php?delete=<?=$product['product_id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
				</td>
				<td><?=$product['product_title'];?></td>
				<td><?=money($product['product_price']);?></td>
				<td><?=$category;?></td>
				<td><a href="products.php?featured=<?=(($product['latest']==0)?'1':'0');?>&id=<?=$product['product_id'];?>" class="btn btn-default btn-xs">
				<span class="glyphicon glyphicon-<?=(($product['latest']==1)?'minus' : 'plus');?>"></span> 
				</a>&nbsp <?=(($product['latest'] == 1)?'Latest Product':'');?></td>
				<td>0</td>
			</tr>
			<?php endwhile; ?>
		</tbody>
</table>

<?php }  ?>

<?php include 'includes/footer.php' ?>





