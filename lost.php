<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	if($user->check()){
		Redirect::to('dashboard');
	}
	
	$validation = new Validation();
	
	if(Input::exists()) {
		$validate = $validation->check(array(				
			'email'	=> array(
				'required' => true,
				'lost' => 1
			),
		));
			
			if($validate->passed()) {	
				$email = Input::get('email');
				$tp = random_bytes(4);
				$new = bin2hex($tp); 
				$message = 'This is your temporary password, ' . $new . ' after using please reset your password!';
				//$send = mail($email, 'Temporary password', $message);			
				
				$salt = Hash::salt(32); 
				$pass = Hash::make($new, $salt); 
				
				$gets = DB::getInstance()->query('SELECT * FROM users WHERE email="' .$email . '"')->results();
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
						$i = $get->id;
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
					'orders_id' => $o), $i);
					
					Session::flash('success', 'Check your email!');
				} else {
					Session::flash('danger', 'Something went wrong!');
				}
			}

	Helper::getHeader('Forgoten password', 'header', $user);
	
?>	
	<button type="button" class="btn btn-default"><a href="index.php">Back</a></button>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
		
		<?php include_once 'notifications.php'; ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Forgoten password</h3>
				</div>
				<div class="panel-body">
					<form method="post">
						<div class="form-group <?php echo ($validation->hasError('email')) ? 'has-error' : '' ?>">
							<label for="email" class="control-label">Email*</label>
							<input type="text" name="email" class="form-control" id="email" placeholder="Enter email" value="<?php echo Input::get('email'); ?>">
							<?php echo ($validation->hasError('email')) ? '<p class="text-danger">' . $validation->hasError('email') . '</p>' : '' ?>
							</div>
							
							<div class="form-group">
								<p><a href="register.php">Create account</a><br> <button type="submit" class="btn btn-default">Send</button></p>
							</div>
					</form>
				</div>
			</div>
		</div>
	</div>
    
<?php
	Helper::getFooter();
?>