<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	if(!$user->check()){
		Redirect::to('login');
	}
	
	if($user->data()->slug === 'user') {
		Redirect::to('index');
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
			<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Users <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<?php 
						$users = DB::getInstance()->query('SELECT * FROM users WHERE deleted = 0')->results();
						
						foreach($users as $use){
							$id = $use->id;
							echo '<li><a href="profil.php?id=' . $use->id . '">'. $use->name . ' ' . $use->surname . '</a></li>';
						}
					?>
				</ul>
			</li>
			<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Deleted users <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<?php	
						$deleted_users = DB::getInstance()->query('SELECT * FROM users WHERE deleted != 0')->results();
						
						foreach($deleted_users as $del){
							echo '<li><a href="#">' . $del->name . ' ' . $del->surname . '</a></li>';
						}
					?>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Products <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<?php	
						$products = DB::getInstance()->query('SELECT * FROM products')->results();
						
						foreach($products as $product){
							echo '<li><a href="products.php?id=' . $product->id . '">' . $product->title . '</a></li>';
						}
					?>
					<li role="separator" class="divider"></li>
					<li><a href="add_products.php">Add products</a></li>
				</ul>
			</li>
			<li><a href="contact.php">Contact</a></li>
			<li><a href="#">Stats</a></li>
		</ul>
      
      <ul class="nav navbar-nav navbar-right">
        <li><a href="cart.php?id=1">Cart 0</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
			<li><a href="profil.php">My profil</a></li>
			<li><a href="history.php">My shop history</a></li>
            <li><a href="reset.php?id=<?php echo $user->data()->id; ?>">Reset password</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php">Log out</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php include_once 'notifications.php'; ?>
<?php Helper::getFooter(); ?>