<?php 
require_once '../init.php';
if(!is_logged_in())
{
	login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';

$sql = "SELECT * FROM brand ORDER BY brand_title";
$results = $db->query($sql);
$errors = array();

//Edit brand
if(isset($_GET['edit']) && !empty($_GET['edit']))
{
		$edit_id = (int)$_GET['edit'];
	$edit_id = sanitize($edit_id);
	$sql3 = "SELECT * FROM brand WHERE brand_id = '$edit_id' ";
	$edit_result = $db->query($sql3);
	$eBrand = mysqli_fetch_assoc($edit_result);
}

// Delete brand
if(isset($_GET['delete']) && !empty($_GET['delete']))
{
	$delete_id = (int)$_GET['delete'];
	$delete_id = sanitize($delete_id);
	$sql = "DELETE FROM brand WHERE brand_id = '$delete_id' ";
	$db->query($sql);
	header('Location: brands.php');
}

// If form submitted
if(isset($_POST['add_submit']))
{
	$brand = sanitize($_POST['brand']);
	// if empty
	if($_POST['brand'] == '')
	{
		$errors[] .= 'You must enter a brand!' ;	    
	}
	// if already exist
	$sql1="SELECT * FROM brand WHERE brand_title= '$brand' ";
	if(isset($_GET['edit'])) {
	$sql = "SELECT *FROM brand WHERE brand_title = '$brand' AND id!='$edit_id' ";
	}
	$result = $db->query($sql1);
		$count = mysqli_num_rows($result);
		if($count > 0)
		{
			$errors[].= $brand.' already exists.. ';
		}
	// display errors
if(!empty($errors))
{
	echo display_errors($errors);
} else {
	// add brand to database
	$sql = "INSERT INTO brand (brand_title) VALUES ('$brand')";
	if(isset($_GET['edit']))
	{
		$sql = "UPDATE brand SET brand_title = '$brand' WHERE brand_id = '$edit_id' ";
	}
       $db->query($sql);
	   header('Location: brands.php');
	   }
	}

?>
<h3 class="text-center">Brands</h3><hr>
<!-- Brand -->
 <div class="text-center">
	<form class="form-inline" action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
	<div class="form-group">
	<?php 
	$brand_value = '';
	if(isset($_GET['edit']))
	{
		$brand_value = $eBrand['brand_title'];
	} else {
		if(isset($_POST['brand_title']))
		{ $brand_value = sanitize($_POST['brand_title']);}
	} ?>
	<label for="brand"><?=((isset($_GET['edit']))?'Edit':'Add A'); ?> Brand : </label>
	<input type="text" name="brand" id="brand" class="form-control" value="<?=$brand_value; ?>">
	<?php if(isset($_GET['edit'])): ?>
	<a href="brands.php" class="btn btn-default"> Cancel </a>
	<?php endif; ?>
	<input type="submit" name="add_submit" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> Brand" class="btn btn-lg btn-success">
   </div><hr>
   
<table class="table table-bordered table-striped table-auto table-condensed">
 <thead>
    <th class="text-center">Edit</th>
    <th class="text-center">Brand</th>
    <th class="text-center">Remove</th>
 </thead>
	<tbody>
<?php while($brand = mysqli_fetch_assoc($results)) : ?>
	<tr>
			<td><a href="brands.php?edit=<?=$brand['brand_id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
			<td><?=$brand['brand_title']; ?></td>
			<td><a href="brands.php?delete=<?=$brand['brand_id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
		</tr>
		<?php endwhile; ?>
	</tbody>
 </table>
<?php
include 'includes/footer.php'; 
?>