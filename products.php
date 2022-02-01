<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	$test = DB::getInstance()->find(get_id(),'products')->results();

	if(empty($test)){
		Redirect::to('nf');
	} 
	
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
					echo '<button type="button" class="btn btn-default"><a href="profil.php?id=1">My profil</a></button> <button type="button" class="btn btn-default"><a href="logout.php">Logout</a></button>';
				}
				?>
			</div>
			<?php echo ($user->check() && $user->data()->slug === 'master') ? '<br><br><button type="button" class="btn btn-default"><a href="edit_product.php?id=' . get_id() . '">Edit product</a></button> <button type="button" class="btn btn-default"><a href="add_article.php?id=' . get_id() . '">Add article</a></button> <button type="button" class="btn btn-default"><a href="delete_product.php?id=' . get_id() .'">Delete all this products</a></button>' : ''; ?> 
		</div>
		<?php 
			$products = DB::getInstance()->query('SELECT * FROM products WHERE id=' . get_id())->results(); 
			
			foreach($products as $product){
				echo '<h1>' . $product->title . '</h1>
						<p>' . $product->info . '</p>';
			} 
		?>
		</div> 
		<div class="row text-center">
		<?php 
			
			$articles = DB::getInstance()->query('SELECT * FROM articles WHERE page = ' . get_page() . ' AND product ="' . $product->title . '"')->results();
				foreach($articles as $article){
						
					echo '<div class="col-sm-6 col-md-4">
							<div class="thumbnail">
								<img src="" alt="" style="width:242px; height:200px;"><!-- images and alts -->
									<div class="captions">
										<h3>' . $article->title . '</h3><!-- product title -->
											<p>' . $article->info . '</p>
											<p>' . bill($article->price) . ' kn</p>
											<p><a href="article.php?id=' . $article->id . '" class="btn btn-default" role="button">More ...</a></p>
									</div>
								</div>
							</div>';
				}
			
		?>
	</div>
	<nav class="text-center" aria-label="Page navigation">
		<ul class="pagination">
			<li>
				<?php
					
					switch(get_page()){
						case get_page() === 0 :
						echo '<a href="products.php?id=' . get_id() . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>';
						break;
						case get_page() > 1 :
						echo '<a href="products.php?id=' . get_id() . '-' . $x = get_page() - 1 . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>';
						break;
					}
					
				?>
			</li>
			<li class="active"><a href="#"><?php echo get_page();?></a></li>
			<li>
				<?php
					$b = get_page() + 1;
					$a = DB::getInstance()->query('SELECT page FROM articles WHERE product="' . $product->title . '" AND page=' . $b)->count();
				
						echo ($a !== 0) ? '<a href="products.php?id=' . get_id() . '-' . $a = get_page() + 1 . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>' : '';
				?>
			</li>
		</ul>
	</nav>

<?php
	Helper::getFooter();	
?>