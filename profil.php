<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	if(!$user->check()){
		Redirect::to('login');
	}
	
	if($user->data()->slug === 'master') {
		$id = get_id();
	} else {
		$id = $user->data()->id;
	}
	
	$counter = DB::getInstance()->query('SELECT * FROM cart WHERE id_user='. $user->data()->id)->count();
	
	$data = DB::getInstance()->query('SELECT * FROM users WHERE id='.$id)->results();
	
	foreach($data as $info) {
		$name = $info->name;
		$surname = $info->surname;
		$addr = $info->addr;
		$town = $info->town;
		$country = $info->country;
		$phone = $info->phone;
	}
	
	Helper::getHeader('WS', 'header', $user);
	
?>	
<nav class="navbar navbar-default">
	<div class="container-fluid">
    <div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="index.php">WS</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav">
			<?php echo ($user->data()->slug === 'master') ? '<li><a href="dashboard.php">Back</a></li>' : '<li><a href="index.php">Back</a></li>'; ?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Products <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<?php	
						$products = DB::getInstance()->query('SELECT * FROM products')->results();
						
						foreach($products as $product){
							echo '<li><a href="products.php?id=' . $product->id . '">' . $product->title . '</a></li>';
						}
					?>
				</ul>
			</li>
				<li><a href="contact.php">Contact</a></li>
		</ul>
      
      <ul class="nav navbar-nav navbar-right">
        <li><a href="cart.php?id=<?php echo $user->data()->id; ?>">Cart <?php echo $counter; ?></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
			<li><a href="history.php">My shop history</a></li>
            <li><a href="reset.php">Reset password</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php">Log out</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingOne">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">My info</a>
				</h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labeledby="headingOne">
				<div class="panel-body">
					<?php echo 
						'<p>Your name and surname is ' . $name . ' ' . $surname . '</p> 
						<p>Your delivery address is ' . $addr . ' in ' . $town . ', ' . $country . '</p>
						<p>When you are going to buy some of our products we will send you SMS message to arrange delivery date</p>';
					?>
						<div class="text-center">
							<?php echo ($user->data()->slug === 'user') ? '<button type="button" class="btn btn-default"><a href="edit_profil.php?id='. $id .'">Edit profil</a></button>' : '<button type="button" class="btn btn-default"><a href="edit_profil.php?id='. $id .'">Edit profil</a></button> <button type="button" class="btn btn-default"><a href="delete_profil.php?id='. $id . '">Delete profil</a></button>';
							?>
						</div>
				</div>
			</div>
		</div>
	<!-- section -->	
		<div class="panel panel-default">
		<?php include_once 'notifications.php'; ?>
			<div class="panel-heading" role="tab" id="headingTwo">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">My orders</a>
				</h4>
			</div>
			<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labeledby="headingTwo">
				<div class="panel-body">
					<?php 
						echo 'You have order';
					?>
				</div>
			</div>
		</div>
	</div>

<?php Helper::getFooter(); ?>

