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
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="index.php">WS</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
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
        <li><a href="#">Cart 0</a></li><!--number of order -->
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
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<?php 
	$orders = DB::getInstance()->query('SELECT * FROM orders')->results();
	
	foreach($orders as $order){
		$id_user = $order->id_user;
		$id_article = $order->id_article;
		$quantity = $order->quantity;
		$payway = $order->payway;
	}

	$user_ids = DB::getInstance()->query('SELECT name, surname, addr, town, country FROM users WHERE id=' . $id_user)->results();
	
	foreach($user_ids as $user_id){
		$name = $user_id->name;
		$surname = $user_id->surname;
		$addr = $user_id->addr;
		$town = $user_id->town;
		$country = $user_id->country;
	
	
	$article_ids = DB::getInstance()->query('SELECT title FROM articles WHERE id=' . $id_article)->results();
	
	foreach($article_ids as $article){
		$title = $article->title;


	echo '<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">Order</h4>
		</div>
		<div class="panel-body">
			<p>' . $title . '</p>
		</div>
	</div>';
	}}}
		?>
		
		<!-- create bill with relevant info and section for pay ways at the end submit button -->
		<!-- print option -->

<?php
	Helper::getFooter();	
?>