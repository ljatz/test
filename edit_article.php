<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	if(!$user->check()){
		Redirect::to('login');
	}
	
	if($user->data()->slug === 'user') {
		Redirect::to('index');
	}
	
	$products = DB::getInstance()->query('SELECT * FROM articles WHERE id=' . get_id())->results();
	
	foreach($products as $product){
		$name = $product->product;
		$title = $product->title;
		$info = $product->info;
		$price = $product->price;
		$page = $product->page;
	}
	
	$validation = new Validation();
	
	if(Input::exists()) {
		$validate = $validation->check(array(
			'title' => array(
				'required' => true,
				'min' => 2,
				'max' => 30
			),
			'info' => array(
				'required' => true,
				'min' => 2,
				'max' => 200
			),
			'price' => array(
				'required' => true,
				'min' => 2,
				'max' => 10
			)));
			
			if($validate->passed()) {
				$update = DB::getInstance()->update('articles', $values = array(
					'product' => $name,
					'title' => Input::get('title'),
					'info' => Input::get('info'),
					'price' => Input::get('price'),
					'page' => $page), get_id());
					
					Session::flash('success', 'Article edited!');
					Redirect::to('dashboard');
			}		
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
			<?php echo ($user->data()->slug === 'master') ? '<li><a href="dashboard.php">Back</a></li>' : ''; ?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Products <span class="caret"></span></a>
			</li>
				<li><a href="contact.php">Contact</a></li>
		</ul>
      
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Cart 0</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
			<li><a href="history.php">My shop history</a></li>
            <li><a href="lost.php">Forrgoten password</a></li>
            <li><a href="reset.php">Reset password</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php">Log out</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $title; ?> </h3>
		</div>
			<div class="panel-body">
				<form method="post">
					<div class="form-group <?php echo ($validation->hasError('title')) ? 'has-error' : '' ?>">
						<label for="title" class="control-label">Title*</label>
						<input type="text" name="title" class="form-control" id="title" placeholder="<?php echo $title; ?>" value="<?php echo Input::get('title'); ?>" autocomplete="off">
						<?php echo ($validation->hasError('title')) ? '<p class="text-danger">' . $validation->hasError('title') . '</p>' : '' ?>
					</div>
					<div class="form-group <?php echo ($validation->hasError('info')) ? 'has-error' : '' ?>">
						<label for="info" class="control-label">Info*</label>
						<input type="text" name="info" class="form-control" id="info" placeholder="<?php echo $info; ?>" value="<?php echo Input::get('info'); ?>" autocomplete="off">
						<?php echo ($validation->hasError('info')) ? '<p class="text-danger">' . $validation->hasError('info') . '</p>' : '' ?>
					</div>
					<div class="form-group <?php echo ($validation->hasError('price')) ? 'has-error' : '' ?>">
						<label for="price" class="control-label">Price*</label>
						<input type="text" name="price" class="form-control" id="price" placeholder="<?php echo $price; ?>" value="<?php echo Input::get('price'); ?>" autocomplete="off">
						<?php echo ($validation->hasError('price')) ? '<p class="text-danger">' . $validation->hasError('price') . '</p>' : '' ?>
					</div>
					<div class="text-center">
						
						<?php echo '<button type="button" class="btn btn-default"><a href="delete_article.php?id=' . get_id() . '">Delete product</a></button> <button type="submit" class="btn btn-default">Save changes</button>';
						?>
					</div>
				</form>
			</div>
	</div>

<?php Helper::getFooter(); ?>