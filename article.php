<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	$validation = new Validation();
	
	$products = DB::getInstance()->query('SELECT title, info FROM products WHERE id=' . get_id())->results(); 
	$articles = DB::getInstance()->query('SELECT * FROM articles WHERE id= ' . get_id())->results();
	
	foreach($articles as $article){
		$id_article = $article->id;
		$title = $article->title;
		$info = $article->info;
		$price = $article->price;
	}
	
	$test = DB::getInstance()->find(get_id(),'articles')->results();
	
	if(empty($test)){
		Redirect::to('nf');
	} 
	
	if(Input::exists()){
		$insert = DB::getInstance()->insert('orders', array(
			'id_user' => $user->data()->id,
			'id_article' => $id_article,
			'quantity' => Input::get('quantity'),
			'price' => $price,
			'payway' => 0
		));
		
		//$session = Cookie::put($user->data()->name, $user->data()->id, true);
		
		Session::flash('success','You add article to your cart!');
		
	} 
	
	
	/* create insert section with unique session id for orders */
	
	Helper::getHeader('', 'header');

?>
	<div class="jumbotron">
		<div class="text-right">
			<div class="btn-group" role="group">
				<?php if(preg_match('/index/i', $_SERVER['REQUEST_URI'])) {
				echo ''; } else {
				echo '<button type="button" class="btn btn-default"><a href="index.php">Back</a></button>';
				}
				?>		
				<?php if(!$user->check()){ 
					echo '<button type="button" class="btn btn-default"><a href="register.php">Register</a></button>
				<button type="button" class="btn btn-default"><a href="login.php">Log in</a></button>'; } else {
					echo '<button type="button" class="btn btn-default"><a href="profil.php">My profil</a></button> <button type="button" class="btn btn-default"><a href="logout.php">Logout</a></button>';
				}
				?>
			</div>
			<?php echo ($user->check() && $user->data()->slug === 'master') ? '<br><br><button type="button" class="btn btn-default"><a href="edit_article.php?id=' . get_id() . '">Edit article</a></button> <button type="button" class="btn btn-default"><a href="delete_article.php?id=' . get_id() .'">Delete article</a></button>' : ''; ?> 
		</div>
		<?php 
			foreach($articles as $article){
				echo '<h1>' . $article->title . '</h1>
						<p>' . $article->info . '</p>';
			} 
		?>
	</div>
	<?php include_once 'notifications.php'; ?>
	<div class="row text-center">
			<div class="col-md-3"></div>
				<div class="col-md-6">
					<div class="thumbnail">
						<img src="" alt="" style="width:242px; height:200px;"><!-- images and alts -->
							<div class="captions">
								<h3><?php echo $title; ?></h3>
									<p><?php echo $info; ?></p>
									<p><?php echo $price; ?></p>
									<?php echo ($user->check()) ? '
									<p>Quantitiy:</p>
									<div class="row">
									<div class="col-md-4"></div>
									<div class="col-md-2">
									<form method="post">
										<div class="form-group">
										<select class="form-control" id="quantity" name="quantity">
											<option value="" selected></option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
										</div>
										<p><button class="btn btn-default" type="submit">Add to cart</button></p>
									</form>' : '<p style="font-size:10px;color:red;">Register for buy!</p>'; ?>
									
									</div>
									<div class="col-md-2"></div>
									</div>
									<br/>
							</div>
					</div>
				</div>
			
			<div class="col-md-3"></div>
	<div class="col-md-12">
<?php
	Helper::getFooter();	
?>