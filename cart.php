<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	if(!$user->check()){
		Redirect::to('login');
	}
	
	if($user->data()->slug === 'user' && $user->data()->id !== get_id()) {
		Redirect::to('index');
	}
	
	Helper::getHeader('', 'header');	

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
        <li><a href="#">Cart 0</a></li>
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
<?php 
	$order = DB::getInstance()->query('SELECT * FROM orders WHERE id_user='. get_id())->results();
		foreach($order as $orders) {
			$id = $orders->id;
			$id_user = $orders->id_user;
			$id_article = $orders->id_article;
			$id_order = $orders->id_order;
			$quantity = $orders->quantity;
			$payway = $orders->payway;
			
			$a = date('d.m.Y.');
			
			if($a > $id_article){
				DB::getInstance()->delete('orders', 'payway', 0);
			} 
			
			$carts = DB::getInstance()->query('SELECT * FROM articles WHERE id='. $id_article)->results();
				foreach($carts as $cart){
					$id = $cart->id;
					$title = $cart->title;
					$price = $cart->price;
				}
			
			echo '<ul>
					<li>' . $id_order . '</li>
					<li>' . $id_user . '</li>
					<li>' . $title . '<li>
					<li>' . $quantity . '</li>
					<li>Total : <b>' . $quantity * $price . '</b></li>
				</ul>';
			
		}
		
		

	
?>
		
		<!-- create bill with relevant info and section for pay ways at the end submit button -->
		<!-- print option -->

<?php
	Helper::getFooter();	
?>