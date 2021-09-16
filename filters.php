<?php
$cat_id = ((isset($_POST['cat']))?sanitize($_POST['cat']):'');
$price_sort = ((isset($_POST['price_sort']))?sanitize($_POST['price_sort']):'');
$min_price = ((isset($_POST['min_price']))?sanitize($_POST['min_price']):'');
$max_price = ((isset($_POST['max_price']))?sanitize($_POST['max_price']):'');
$b = ((isset($_POST['brand']))?sanitize($_POST['brand']):'');
$brandQ = $db->query("SELECT * FROM brand ORDER BY brand_title");
?>

<h3 class="text-center">Search BY : </h3>
<h4 class="text-center">Price</h4>
<form action="search.php" method="post">
<input type="hidden" name="cat" value="<?=$cat_id;?>">
<input type="hidden" name="price_sort" value="<?=$cat_id;?>">
<input type="checkbox" name="price_sort" value="low"<?=(($price_sort == 'low')?' checked':'');?>>Low to High<br>
<input type="checkbox" name="price_sort" value="high"<?=(($price_sort == 'high')?' checked':'');?>>High To Low<br>
<input type="text" name="min_price" class="price_range" placeholder="Min " value="<?=$min_price;?>"> To 
<input type="text" name="max_price" class="price_range" placeholder="Max " value="<?=$max_price;?>"><br><br>
<h4 class="text-center">Brand </h4>
<input type="checkbox" name="brand" value=""<?=(($b == '')?' checked':'');?>> All <br>
<?php while($brand = mysqli_fetch_assoc($brandQ)): ?>
<input type="checkbox" name="brand" value="<?=$brand['brand_id'];?>"<?=(($b == $brand['brand_id'])?' checked':'');?>> <?=$brand['brand_title'];?><br>
<?php endwhile; ?>
<input type="submit" value="search" class="btn btn-xs btn-primary">

</form>