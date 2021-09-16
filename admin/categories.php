<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/Projectphp/init.php';
if(!is_logged_in())
{
	login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';

$sql = "SELECT * FROM categories WHERE parent = 0";
$result = $db->query($sql);
$errors = array();
$category = '';
$post_parent = '';

//Edit category
if(isset($_GET['edit']) && !empty($_GET['edit']))
{
	$edit_id = (int)$_GET['edit'];
	$edit_id = sanitize($edit_id);
$edit_sql = "SELECT * FROM categories WHERE cat_id = '$edit_id'";
$edit_result = $db->query($edit_sql);
$edit_category = mysqli_fetch_assoc($edit_result);
	}
//Delete category
if(isset($_GET['delete']) && !empty($_GET['delete']))
{
	$delete_id = (int)$_GET['delete'];
	$delete_id = sanitize($delete_id);
	$sql = "SELECT * FROM categories WHERE cat_id = '$delete_id'";
	$result = $db->query($sql);
	$category=mysqli_fetch_assoc($result);
		if($category['parent'] == 0) {
		$sql = "DELETE FROM categories WHERE parent = '$delete_id'";
		$db->query($sql);
		}
	$dsql = "DELETE FROM categories WHERE cat_id = '$delete_id'";
	$db->query($dsql);
	header('Location: categories.php');
}

// Form functioning
if(isset($_POST) && !empty($_POST)) {
$post_parent = sanitize($_POST['parent']);
$category = sanitize($_POST['category']);
$sqlform = "SELECT * FROM categories WHERE cat_name = '$category' AND parent = '$post_parent' ";
	if(isset($_GET['edit']))
		{
			$id = $edit_category['cat_id'];
			$sqlform = "SELECT * FROM categories WHERE cat_name = '$category' AND parent = '$post_parent' AND cat_id != '$id'";
			}
$formresult = $db->query($sqlform);
$count = mysqli_num_rows($formresult);
//if category is blank
if($category == '')
{
	$errors[] .= 'Category is blank.. ';
}

//if already exist
if($count>0) {
	$errors[] .= $category. ' already exists'; 
}

//Display errors or update databse
if(!empty($errors)) { 
//display error
$display = display_errors($errors); ?>
<script>
 jQuery('document').ready(function() {
	 jQuery('#errors').html('<?=$display; ?>');
 }); 
</script>
<?php }
else { 
//update database
$updatesql = "INSERT INTO categories (cat_name, parent) VALUES ('$category','$post_parent')";
	if(isset($_GET['edit'])) {
		$updatesql = "UPDATE categories SET cat_name = '$category', parent='$post_parent' WHERE cat_id = '$edit_id'";
	}
$db->query($updatesql);
header('Location: categories.php');
}
}
$category_value = '';
$parent_value = 0;
if(isset($_GET['edit'])) {
$category_value = $edit_category['cat_name'];
$parent_value = $edit_category['parent'];

} else {
	if(isset($_POST)) { 
		$category_value = $category;
		$parent_value= $post_parent;
	}
 }
?>
<h3 class="text-center">Categories</h3><hr>
<div class="row">
	<!-- form -->
	<div class="col-md-6">
		<form class="form" action="categories.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
		<legend><?=((isset($_GET['edit']))?'Edit' : 'Add A');?> Category</legend>
		<div id="errors"></div>
			<div class="form-group">
				<label for="parent"> Parent </label>
					<select class="form-control" name="parent" id="parent">
						<option value="0"<?=(($parent_value == 0)?' selected="selected"':'');?>> Parent </option>
						<?php while($parent = mysqli_fetch_assoc($result)): ?>
						<option value="<?=$parent['cat_id'];?>"<?=(($parent_value == $parent['cat_id'])?' selected="selected"':'');?>><?=$parent['cat_name'];?></option>
						<?php endwhile; ?>
					</select>
				</div>
					<div class="form-group">
							<label for="category">Category</label>
							<input type="text" class="form-control" id="category" name="category" value="<?=$category_value;?>">
					</div>
					<div class="form-group">
					<input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> category" class="btn btn-success"></div>
		</form>
	</div>
	<!-- table -->
	<div class="col-md-6">
		<table class="table table-bordered">
			<thead>
				<th>Category</th>
				<th>Parent</th>
				<th>Edit</th>
				<th>Remove</th>
			</thead>
			<tbody>
				<?php 
				$sql = "SELECT * FROM categories WHERE parent = 0";
$result = $db->query($sql);
				while($parent = mysqli_fetch_assoc($result)): 
					$parent_id = (int)$parent['cat_id'];
					$sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
					$cresult = $db->query($sql2);
				?>
				<tr class="bg-primary">
					<td><?=$parent['cat_name'];?></td>
					<td>Parent</td>
					<td>
						<a href="categories.php?edit=<?=$parent['cat_id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
						<td>
						<a href="categories.php?delete=<?=$parent['cat_id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
					</td>
				</tr>
			
					<?php while($child = mysqli_fetch_assoc($cresult)): ?>
					<tr class="bg-info">
					<td><?=$child['cat_name'];?></td>
					<td><?=$parent['cat_name']; ?></td>
					<td>
						<a href="categories.php?edit=<?=$child['cat_id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
						<td>
						<a href="categories.php?delete=<?=$child['cat_id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
					</td>
				</tr>
					
					<?php endwhile; ?>
					<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</div>

<?php include 'includes/footer.php';