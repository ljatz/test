<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	if(!$user->check()){
		Redirect::to('login');
	}
	
	if($user->data()->slug === 'master') {
		$id = get_id();
	} else {
		$id = $user->data()->id;
	}
	
	$data = DB::getInstance()->query('SELECT * FROM users WHERE id='.$id)->results();
	
	foreach($data as $info) {
		$name = $info->name;
		$surname = $info->surname;
		$addr = $info->addr;
		$town = $info->town;
		$country = $info->country;
		$phone = $info->phone;	
	}
	
	$validation = new Validation();
	
	if(Input::exists()) {
		$validate = $validation->check(array(
			'addr' => array(
				'required' => true,
				'min' => 2,
				'max' => 100
			),
			'town' => array(
				'required' => true,
				'min' => 2,
				'max' => 50,
			),
			'country' => array(
				'required' => true,
				'min' => 2,
				'max' => 50
			),
			'phone' => array(
				'required' => true,
				'number' => true
			)
			
			));
			if($validate->passed()) {
				$update = DB::getInstance()->update('users', $values = array(
					'addr' => Input::get('addr'),
					'town' => Input::get('town'),
					'country' => Input::get('country'),
					'phone' => Input::get('phone')), $id);
					
					Session::flash('success', 'Profil changed!');
					Redirect::to('profil');
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
			<h3 class="panel-title">Hello <?php echo $name.' '.$surname; ?> </h3>
		</div>
			<div class="panel-body">
				<form method="post">
					<div class="form-group <?php echo ($validation->hasError('addr')) ? 'has-error' : '' ?>">
						<label for="addr" class="control-label">Address*</label>
						<input type="text" name="addr" class="form-control" id="addr" placeholder="<?php echo $addr; ?>" value="<?php echo Input::get('addr'); ?>" autocomplete="off">
						<?php echo ($validation->hasError('addr')) ? '<p class="text-danger">' . $validation->hasError('addr') . '</p>' : '' ?>
					</div>
					<div class="form-group <?php echo ($validation->hasError('town')) ? 'has-error' : '' ?>">
						<label for="town" class="control-label">City*</label>
						<input type="text" name="town" class="form-control" id="town" placeholder="<?php echo $town; ?>" value="<?php echo Input::get('town'); ?>" autocomplete="off">
						<?php echo ($validation->hasError('town')) ? '<p class="text-danger">' . $validation->hasError('town') . '</p>' : '' ?>
					</div>
					<div class="form-group <?php echo ($validation->hasError('country')) ? 'has-error' : '' ?>">
						<label for="country" class="control-label">Country*</label>
						<input type="text" name="country" class="form-control" id="country" placeholder="<?php echo $country; ?>" value="<?php echo Input::get('country'); ?>" autocomplete="off">
						<?php echo ($validation->hasError('country')) ? '<p class="text-danger">' . $validation->hasError('country') . '</p>' : '' ?>
					</div>
					<div class="form-group <?php echo ($validation->hasError('phone')) ? 'has-error' : '' ?>">
						<label for="phone" class="control-label">Phone*</label>
						<input type="text" name="phone" class="form-control" id="phone" placeholder="<?php echo $phone; ?>" value="<?php echo Input::get('phone'); ?>" autocomplete="off">
						<?php echo ($validation->hasError('phone')) ? '<p class="text-danger">' . $validation->hasError('phone') . '</p>' : '' ?>
					</div>
					<div class="text-center">
						
						<?php echo ($user->data()->slug === 'master') ? '<button type="button" class="btn btn-default"><a href="delete_profil.php">Delete profil</a></button> <button type="submit" class="btn btn-default">Save</button>' : '<button type="button" class="btn btn-default"><a href="profil.php">My profil</a></button> <button type="submit" class="btn btn-default">Save</button>';
						?>
					</div>
			</div>
	</div>

<?php Helper::getFooter(); ?>