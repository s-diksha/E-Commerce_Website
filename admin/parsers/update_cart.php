<?php 
	 require_once $_SERVER['DOCUMENT_ROOT'].'/Projectphp/init.php';
	 $mode = sanitize($_POST['mode']);
	 $edit_id = sanitize($_POST['edit_id']);
	 $cartQ = $db->query("SELECT * FROM cart WHERE cart_id = '{$cart_id}'");
	 $result = mysqli_fetch_assoc($cartQ);
	 $items = json_decode($result['item'],true);
	 $updated_items = array();
	 $domain = (($_SERVER['HTTP_HOST']!='localhost')?'.'.$_SERVER['HTTP_HOST']:false);
	 if($mode=='removeone')
	 {	
			if($item['cart_id']==$edit_id) {
			foreach($items as $item)
		  {
				$item['prod_quantity'] = $item['prod_quanity'] - 1;
		  }
		  if($item['prod_quantity']>0)
		  {
			  $updated_items[]=$item;
		  }
			}
	 }
	 if($mode=='addone')
	 {
		  if($item['cart_id']==$edit_id) {
			foreach($items as $item)
		  {
				$item['prod_quantity'] = $item['prod_quanity'] + 1;
		  }
		  
			  $updated_items[]=$item;
		 }
		}
	 if(!empty($updated_items))
	 {
		 $json_updated = json_encode($updated_items);
		 $db->query("UPDATE cart SET items = '{$json_updated}' WHERE cart_id = '{$cart_id'}'");
		 $_SESSION['success_flash']='Your shopping cart has been updated';
	 }
	 if(empty($updated_items)
	 {
		 $db->query("DELETE FROM cart WHERE cart_id = '{$cart_id}'");
		 setcookie(CART_COOKIE,'',1,"/",$domain,false);
	 }
?>