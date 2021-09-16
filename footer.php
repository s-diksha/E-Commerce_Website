<div class="clearfix" style="margin-bottom:20px;">  </div>
<!-- Start of FOOTER -->
<div class="footer">
<div class="col-lg-12">
 <div class="row">
     <div class="col-md-4">
	 <h3>FOLLOW US </h3>
	<p><a href="https://www.facebook.com/Snehanjali-Electronics-1180768401979917/"><img src="images/fb.png" class="img-rounded" alt="Facebook" width="10%" height="10%"> &nbsp;&nbsp; Facebook </a></p>
	</div>
	<div class="col-md-4">
	<h3>COMPANY</h3>
	<ul id="newul">
	<li><a href="#">About Us</a></li>
	<li><a href="#">Contact US</a></li>
	<li><a href="#">Customer Service</a></li>
	<li><a href="#">Privacy Policy</a></li>
	</ul>
	</div>
	<div class="col-md-4">
	<h3>My Account </h3>
		<ul id="newul">
	<li><a href="order_history.php">Order History</a></li>
	<li><a href="newncart.php">Cart</a></li>
	</ul>
	</div>
 </div>
</div>
</div>
<!-- End Of Footer -->
<script>
function update_cart(mode,edit_id){
	var data = {"node":mode, "edit_id": edit_id};
	jQuery.ajax({
	url : 'Projectphp/admin/parsers/update_caat.php',
method : 'post',
data: data,
	success : function(){},
	error:function(){alert("wrong");},
	});
}
</script>
<script>
 function add_to_cart()
 {
	jQuery('#perrors').html("");
	var quantity = jQuery('#quantity').val();
	var available = jQuery('#available').val();
	var error='';
	var data=jQuery('#add_product_form').serialize();
	if(quantity =='' || quantity ==0){
		error += '<p class="text-danger text-center">You must choose the quantity.</p>';
		jQuery('#perrors').html(error);
		return;
	}else if (quantity > available){
		error += '<p class="text-danger text-center">There are only '+available+' available.</p>';
		jQuery('#perrors').html(error);
		return'
	}else {
		jQuery.ajax({
			url : '/Projectphp/admin/add_cart.php';
			method:'post';
			data:data;
			success: function(){
				location.reload();
			},
			error:function(){alert("someting went wrong");}
			
		});
	}
 }
// function pdetails($id)
			// {
				// var data = {id:'$id'};
				// jQuery.ajax({			
					// url: '/Projectphp/details.php',
					// type :'POST',
					// method:'POST',
					// async: false,
					 // cache: false,
					// data: data,
					// success: function(data){
						// jQuery('body').append(data);						
					// },
					// error: function (request, status, error) {
    // alert('ERROR');
    // alert(request.responseText);
    // alert(status.toString());
    // alert(error.toString());
  // } 
					//error:function(){alert("error");}
					// });
			// }
			</script>
<script>			
    $('#zoom').elevateZoom({easing:true, tint:true,tintColour:'#F90', tintOpacity:0.5, scrollZoom : true, zoomWindowFadeIn: 500,
			zoomWindowFadeOut: 500,
			lensFadeIn: 500,
			lensFadeOut: 500}); 			
</script>
</body>
</html>
