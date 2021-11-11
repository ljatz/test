<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	if($user->check()){
		Redirect::to('dashboard');
	}
	
	$validation = new Validation();
	
	if(Input::exists()) {
		if(Token::check(Input::get('token'))){
			$validate = $validation->check(array(				
				'email'	=> array(
					'required' => true,
				),
				'password' => array(
					'required' => true,
				),
			));
			
			if($validate->passed()) {
			
				$user = $user->login(Input::get('email'), Input::get('password'));
				
				if($user === 'NOEMAIL'){
					Session::flash('danger', 'Wrong email! Try again!.');
					Redirect::to('login');
				} else if($user){
					Redirect::to('index');
				} else {
					Session::flash('danger', 'Something goes wrong! Try again!.');
					Redirect::to('login');
				}
					
			}		
		} else {
			Session::flash('danger', 'Wrong CSRF token!');
			Redirect::to(404);
		}
	}
	Helper::getHeader('Sign in', 'header', $user);
	
?>	
	<button type="button" class="btn btn-default"><a href="index.php">Back</a></button>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
		
		<?php include_once 'notifications.php'; ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Sign in</h3>
						<p>to continue to WS</p>
				</div>
				<div class="panel-body">
					<form method="post">
						<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
							<div class="form-group <?php echo ($validation->hasError('email')) ? 'has-error' : '' ?>">
								<label for="email" class="control-label">Email*</label>
								<input type="text" name="email" class="form-control" id="email" placeholder="Enter email" value="<?php echo Input::get('email'); ?>">
								<?php echo ($validation->hasError('email')) ? '<p class="text-danger">' . $validation->hasError('email') . '</p>' : '' ?>
							</div>
							<div class="form-group <?php echo ($validation->hasError('password')) ? 'has-error' : '' ?>">
								<label for="password" class="control-label">Password*</label>
								<input type="password" name="password" class="form-control" id="password" placeholder="Enter password" value="">
								<?php echo ($validation->hasError('password')) ? '<p class="text-danger">' . $validation->hasError('password') . '</p>' : '' ?>
							</div>
							<div class="form-group">
								<p><a href="lost.php">Forgot password?</a></p>
								<p><a href="register.php">Create account</a> <button type="submit" class="btn btn-default">Log in</button></p>
							</div>
					</form>
				</div>
			</div>
		</div>
	</div>
    
<?php
	Helper::getFooter();
?>