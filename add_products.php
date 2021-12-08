<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	if(!$user->check()){
		Redirect::to('login');
	}
	
	if($user->data()->slug === 'user') {
		Redirect::to('index');
	}
	
	$id = DB::getInstance()->query('SELECT page FROM products')->count();
	
	if($id == 0){
		$id = 1;
	}
	
	$validation = new Validation();
	
	if(Input::exists()) {
		$validate = $validation->check(array(
			'title' => array(
				'required' => true
			),
			'info'	=> array(
				'required' => true
			)
		));
	
		if($validate->passed()) {
			$insert = DB::getInstance()->insert('products', array(
				'title' => Input::get('title'),
				'info'	=> Input::get('info')
			));
		
				Session::flash('success', 'Product added!');
				Redirect::to('dashboard');
		}
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
			<li><a href="dashboard.php">Back</a></li>
			<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Users <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<?php 
						$users = DB::getInstance()->query('SELECT * FROM users')->results();
						
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
						$deleted_users = DB::getInstance()->query('SELECT * FROM deleted_users')->results();
						
						foreach($deleted_users as $del){
							echo '<li><a href="#">' . $del->name . ' ' . $del->surname . '</a></li>';
						}
					?>
				</ul>
			</li>
			<li class="active">
				<a href="#">Products</a>
			</li>
			<li><a href="contact.php">Contact</a></li>
			<li><a href="#">Stats</a></li>
		</ul>
      
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Cart 0</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
			<li><a href="profil.php">My profil</a></li>
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

<?php include_once 'notifications.php'; ?>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Add product</h3>
		</div>
			<div class="panel-body">
				<form method="post">
					<div class="form-group <?php echo ($validation->hasError('title')) ? 'has-error' : '' ?>">
						<label for="title" class="control-label">Title*</label>
						<input type="text" name="title" class="form-control" id="title" placeholder="Enter name of product" value="<?php echo Input::get('title'); ?>" autocomplete="off">
						<?php echo ($validation->hasError('title')) ? '<p class="text-danger">' . $validation->hasError('title') . '</p>' : '' ?>
					</div>
					<div class="form-group <?php echo ($validation->hasError('info')) ? 'has-error' : '' ?>">
						<label for="info" class="control-label">Info*</label>
						<input type="text" name="info" class="form-control" id="info" placeholder="Enter some info about product" value="<?php echo Input::get('info'); ?>" autocomplete="off">
						<?php echo ($validation->hasError('info')) ? '<p class="text-danger">' . $validation->hasError('info') . '</p>' : '' ?>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-default">Add new product</button>
					</div>
					
				</form>
			</div>
	</div>
					
<?php Helper::getFooter(); ?>