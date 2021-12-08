<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	if(!$user->check()){
		Redirect::to('login');
	}
	
	if($user->data()->id != get_id()) {
		Redirect::to('index');
	}
	
	$validation = new Validation();
	
	if(Input::exists()) {
		$validate = $validation->check(array(				
			'password'	=> array(
				'required' => true,
				'min' => 8
				),
			'password_again' => array(
				'required' => true,
				'matches' => 'password'
				)
			));
			
			if($validate->passed()) {	
				
				$id = get_id();
			
				$new = Input::get('password');
				$salt = Hash::salt(32); 
				$pass = Hash::make($new, $salt);
				
				$gets = DB::getInstance()->query('SELECT * FROM users WHERE id="' .$id . '"')->results();
					foreach($gets as $get){
						$n = $get->name;
						$s = $get->surname;
						$slug = $get->slug;
						$e = $get->email;
						$a = $get->addr;
						$t = $get->town;
						$c = $get->country;
						$r = $get->registered_at;
						$d = $get->deleted;
						$o = $get->orders_id;
					}
				 
				$update = DB::getInstance()->update('users', $values = array( 
					'name' => $n,
					'surname' => $s,
					'slug' => $slug,
					'email' => $e,
					'password' => $pass,
					'salt' => $salt,
					'addr' => $a,
					'town' => $t,
					'country' => $c,
					'registered_at' => $r,
					'deleted' => $d,
					'orders_id' => $o), $id);
					
					Session::flash('success', 'Password changed!');
				} else {
					Session::flash('danger', 'Something went wrong!');
				}
			}

	Helper::getHeader('Reset password', 'header', $user);
	
?>	
	<button type="button" class="btn btn-default"><a href="index.php">Back</a></button>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
		
		<?php include_once 'notifications.php'; ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Reset password</h3>
				</div>
				<div class="panel-body">
					<form method="post">
						<div class="form-group <?php echo ($validation->hasError('password')) ? 'has-error' : '' ?>">
							<label for="password" class="control-label">Password*</label>
							<input type="password" name="password" class="form-control" id="password" placeholder="Enter new password" value="<?php echo Input::get('password'); ?>">
							<?php echo ($validation->hasError('password')) ? '<p class="text-danger">' . $validation->hasError('password') . '</p>' : '' ?>
						</div>
						<div class="form-group <?php echo ($validation->hasError('password_again')) ? 'has-error' : '' ?>">
							<label for="password_again" class="control-label">Confirm password*</label>
							<input type="password" name="password_again" class="form-control" id="password_again" placeholder="Enter your password again" value="<?php echo Input::get('password_again'); ?>">
							<?php echo ($validation->hasError('password_again')) ? '<p class="text-danger">' . $validation->hasError('password_again') . '</p>' : '' ?>
						</div>
							<div class="form-group">
								<button type="submit" class="btn btn-default">Change</button></p>
							</div>
					</form>
				</div>
			</div>
		</div>
	</div>
    
<?php
	Helper::getFooter();
?>