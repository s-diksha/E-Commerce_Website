
<nav class="navbar">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand white" href="index.php">Snehaanjali Electronics Admin</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="brands.php">Brands</a></li>
        <li><a href="categories.php">Categories</a></li>
		<li><a href="products.php">Products</a></li>
		<?php if(has_permission('admin')): ?>
		<li><a href="users.php">Users</a></li>
		<li><a href="orders.php">Orders</a></li>
		<?php endif; ?></ul>
		<ul class="nav navbar-nav pull-right">
		<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Hello <?=$user_data['first'];?>! <span class="caret"></span></a>
		<ul class="dropdown-menu" role="menu">
		<li><a href="change_password.php">Change Password</a></li>
		<li><a href="logout.php">Log Out</a></li>
		</ul>
		</li>
      </ul>
        </li>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>