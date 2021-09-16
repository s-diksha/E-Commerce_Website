
<div class="clearfix"></div>
<div class="footer">
 <div class="row">
     <div class="col-md-4">
	 <h3>FOLLOW US </h3>
	<p><a href="https://www.facebook.com/Snehanjali-Electronics-1180768401979917/"><img src="http://localhost/Projectphp/images/fb.png" class="img-rounded" alt="Facebook" width="10%" height="10%"> &nbsp;&nbsp; Facebook </a></p>
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
	<h3>YOUR ORDERS </h3>
		<p></p>
	</div>
 </div>
</div>
<!-- End Of Footer -->
<!-- AJAXXXXXXXXXXXXXXXXXXXXXXXXX -->
<script>
function get_child_options(){ //selected
	// if(typeof selected == 'undefined')
		// {
			// var selected=''; 
			// }
	var parentID = jQuery('#parent').val();
	jQuery.ajax({
		url: 'http://localhost/Projectphp/admin/child_categories.php',
		type: 'POST',
		data: {parentID : parentID, //selected:selected
		},
		success: function(data) {
			jQuery('#child').html(data);
		},
		error: function(){
			alert("something wrong with child option")},
	});
}
jQuery('select[name="parent"]').change(
	get_child_options);

</script>

</body>
</html>