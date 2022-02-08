<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	if(!$user->check()){
		Redirect::to('login');
	}
	
	if($user->data()->slug === 'user') {
		Redirect::to('index');
	}

	$last_id = DB::getInstance()->query('SELECT id FROM articles ORDER BY id DESC LIMIT 1')->results();
	
	foreach($last_id as $l_id) {
		$last = $l_id->id;
	}
	
	if(isset($_POST['upload'])){
		$path = 'img';
	
	if( ! is_dir($path)) {
		mkdir($path, 0755);
	}
	
	$total = count($_FILES['file']['name']);
		for($i = 0; $i < $total; $i++) {
			$tmp_name  = $_FILES['file']['tmp_name'][$i];
			$file_name = $_FILES['file']['name'][$i];
			$error     = $_FILES['file']['error'][$i];
			$size      = $_FILES['file']['size'][$i];
	
	if($error == 0 && $size != 0) {
		$file_parts = pathinfo($file_name);
		$ext = $file_parts['extension'];
		
		$new_name = get_id() . '-' . $last . '.'.$ext;
		$dest = $path . '/' . $new_name;
		
		if(move_uploaded_file($tmp_name, $dest)) {
			Session::flash('success', 'Upload successfull!');
		} else {
			Session::flash('danger', 'Something went wrong!');
		}
	} else {
		
		Session::flash('danger', 'Upload failed!');
	}
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
						$deleted_users = DB::getInstance()->query('SELECT * FROM users')->results();
						
						foreach($deleted_users as $del){
							echo ($del->deleted != 0) ? '<li><a href="#">' . $del->name . ' ' . $del->surname . '</a></li>' : '';
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
			<h3 class="panel-title">Add article image</h3>
		</div>
			<div class="panel-body">
				<form method="post"  enctype="multipart/form-data">
					<div>
						<input name="file[]" type="file" multiple>
					</div>
					<div class="text-center">
						<button type="submit" name="upload" class="btn btn-default">Upload</button>
					</div>
				</form>
			</div>
	</div>

<?php Helper::getFooter();?>