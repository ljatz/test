<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	/* nf
	$d = dir('../v0.04');
	
	while (false !== ($entry = $d->read())){
		$a = $entry . ' ';
		
		$b = strstr($_SERVER['REQUEST_URI'], 'v0.04'); //path
		$b = strstr($b, '/');
		$b = substr($b, 1) . ' ';
		

		
	}
	$d->close();
	*/

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
						<button type="button" class="btn btn-default"><a href="login.php">Log in</a></button>'; } elseif($user->data()->slug === 'master'){ echo '<button type="button" class="btn btn-default"><a href="dashboard.php">Dashboard</a></button> <button type="button" class="btn btn-default"><a href="logout.php">Logout</a></button>'; } else {
							echo '<button type="button" class="btn btn-default"><a href="profil.php">My profil</a></button> <button type="button" class="btn btn-default"><a href="logout.php">Logout</a></button>';
						}
						?>
					</div>
			</div>
		
				<h1>WS</h1>
					<p>My first web shop</p>
					<p>We are ... and this is our products. For any question feel free to <a href="contact.php">contact</a> us. </p>
			</div>
			<div class="row text-center">
			<?php 
				$products = DB::getInstance()->query('SELECT * FROM products')->results();
				
				foreach($products as $product){
					echo '<div class="col-sm-6 col-md-4">
							<div class="thumbnail">
								<img src="" alt="" style="width:242px; height:200px;"><!-- images and alts -->
									<div class="captions">
										<h3>' . $product->title . '</h3><!-- product title -->
											<p>' . $product->info . '</p>
											<p><a href="products.php?id=' . $product->id . '" class="btn btn-default" role="button">See more...</a></p>
									</div>
							</div>
						</div>';
				}
			?>
			</div>	
<?php
	Helper::getFooter();	
?>