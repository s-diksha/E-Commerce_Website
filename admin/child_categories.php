<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Projectphp/init.php';
$parentID = (int)$_POST['parentID'];
//$selected = sanitize($_POST['selected']);
$childQuery = $db->query("SELECT * FROM categories WHERE parent= '$parentID' ORDER BY cat_name");
ob_start();

?>
<option value=""></option>
<?php while($child = mysqli_fetch_assoc($childQuery)) : ?>
<option value="<?=$child['cat_id'];?>"><?=$child['cat_name'];?></option>
<?php endwhile; ?>
<?php echo ob_get_clean(); ?>