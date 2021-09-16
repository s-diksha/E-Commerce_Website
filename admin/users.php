<?php 
require_once '../init.php';

if(!is_logged_in())
{
	login_error_redirect();
}
if(!has_permission('admin'))
{
	permission_error_redirect('index.php');
}
include 'includes/head.php';
include 'includes/navigation.php';

// Delete the user 
if (isset($_GET['delete']))
{
	$delete_id = sanitize($_GET['delete']);
	$db->query("DELETE FROM users WHERE user_id = '$delete_id'");
	$_SESSION['success_flash']='User has been deleted! ';
	header('Location: users.php');
}
// Add the user
if(isset($_GET['add']))
{ 
$name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$password = ((isset($_POST['passowrd']))?sanitize($_POST['passowrd']):'');
$confirm=((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');
$errors = array();
if($_POST)
{	
	$emailQuery =$db->query("SELECT * FROM users WHERE user_email='$email'");
	$emailCount = mysqli_num_rows($emailQuery);
	if($emailCount !=0)
	{ $errors[] = 'Email already exists.'; }
	
	$required=array('name','email','password','confirm','permissions');
	foreach($required as $f){
		if(empty($_POST[$f]))
		{
			$errors[]='You must fill all the fields.';
			break;
	}}
	if(strlen($password < 8 )){
		$errors[] = 'Password should be atleast 8 characters.';
	}
	if($password != $confirm)
	{
		$errors[] = 'Password does not match';
	}
	if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
			$errors[] = 'Email must be valid';
	}
	if(!empty($errors))
	{
		echo display_errors($errors);
	}
	else{
		// add user
		$hashed = password_hash($password,PASSWORD_DEFAULT);
		$db->query("INSERT INTO users (user_name,user_email,user_password,permission) VALUES ('$name','$email','$hashed','$permissions')");
		$_SESSION['success_flash']='User has been added';
		header('Location: users.php');
	}
}
?>
<h2 class="text-center">Add A new user</h2><hr>
<form action="users.php?add=1" method="post">
	<div class="form-group col-md-6">
		<label for="name">Full Name :</label>
		<input type="text" name="name" id="name" class="form-control" value="<?=$name;?>">
	</div>	
	<div class="form-group col-md-6">
		<label for="name">Email :</label>
		<input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
	</div>	
	<div class="form-group col-md-6">
		<label for="name">Password :</label>
		<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
	</div>	
	<div class="form-group col-md-6">
		<label for="name">Confirm Password:</label>
		<input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
	</div>
	<div class="form-group col-md-6">
		<label for="name">Permissions :</label>
		<select class="form-control" name="permissions">
		<option value=""<?=(($permissions == '')?'selected':'');?>></option>
		<option value="editor"<?=(($permissions == 'editor')?'selected':'');?>>Editor</option>
		<option value="admin,editor"<?=(($permissions == 'admin,editor')?'selected':'');?>>Admin</option>
	</div>	
	<div class="form-group col-md-6 text-right" style="margin-top:25px;">
	<a href="users.php" class="btn btn-default text-right">Cancel</a>
	<input type="submit" value="Add User" class="btn btn-primary">
	</div>
	</form>
<?php
}else {

$userQuery = $db->query("SELECT * FROM users ORDER BY user_name");

?>
<h2 class="text-center">Users</h2><hr>
<a href="users.php?add=1" class="btn btn-success" id="prod_btn">Add New User</a>
<hr>
<div class="container_users">
<table class="table table-bordered table-striped table-condesed">
<thead><th></th><th> Name </th> <th> Email</th><th> Phone Number</th><th>Join Date</th><th>Last Login</th><th>Permissions</th></thead>
<tbody>
	<?php while($user = mysqli_fetch_assoc($userQuery)): ?>
	<tr>
		<td>
		<?php if($user['user_id'] != $user_data['user_id']): ?>
		<a href="users.php?delete=<?=$user['user_id'];?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove-sign"></span></a>
		</td>
		<?php endif;?>
		<td><?=$user['user_name'];?></td>
		<td><?=$user['user_email'];?></td>
		<td><?=$user['user_phone'];?></td>
		<td><?=datab_date($user['join_date']);?></td>
		<td><?=(($user['last_login']=='0000-00-00 00:00:00')?'Never':datab_date($user['last_login']));?></td>
		<td><?=$user['permissions'];?></td>
	</tr>
	<?php endwhile; ?>
</tbody>
</div>


<?php }
// include 'includes/footer.php'; 
?>
