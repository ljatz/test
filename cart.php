<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	if(!$user->check()){
		Redirect::to('login');
	}
	
	if($user->data()->slug === 'user' && $user->data()->id !== get_id()) {
		Redirect::to('index');
	}
	
	$counter = DB::getInstance()->query('SELECT * FROM cart WHERE id_user='. get_id())->count();
	
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
        <li class="active"><a href="#">Cart <?php echo $counter; ?></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="reset.php?id=<?php echo $user->data()->id; ?>">Reset password</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php">Log out</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php

	include_once 'notifications.php';

	$order = DB::getInstance()->query('SELECT * FROM cart WHERE id_user='. get_id())->results();
	
		foreach($order as $key => $orders) {
			$ids = $orders->id;
			$id_user = $orders->id_user;
			$id_article = $orders->id_article;
			$id_order = $orders->id_order;
			$quantity = $orders->quantity;
			$price = $orders->price;
			$total = $orders->total;
			
			echo (empty($order)) ? '' : '<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">' . $id_order . '</h3>
				</div> 
				<div class="panel-body"><b>'
					. $id_article . ' - ' . $quantity . ' kom. - ' . bill($price) . ' kn, ukupno = ' . bill($total) . ' kn</b> <button type="button" class="btn btn-default btn-xs"><a href="can_one.php?id='.get_id().'-'.$ids.'">X</a></button>
				</div></div>';
		}	
		
?>	

	<div class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title">Sveukupno: <?php $summary = DB::getInstance()->query('SELECT SUM(total) AS sum FROM cart WHERE id_user=' . get_id())->results(); foreach($summary as $sum) { echo ($sum->sum > 0) ? bill($sum->sum) . ' kn' : ' '; } ?></h3></div>
		<div class="panel-body center">
				<button class="btn btn-default" type="button"><a href="pay.php?id=<?php echo get_id(); ?>">Pay</a></button> <button class="btn btn-default"type="button"><a href="cancel.php?id=<?php echo get_id(); ?>">Cancel</button>
					
		</div>
	</div>

<?php

	Helper::getFooter();
	
?>