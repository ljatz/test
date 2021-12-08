<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	$user_check = DB::getInstance()->get('*', 'users')->count();
	
	$slug = ($user_check === 0) ? 'master' : 'user';
	
	$reg = '0';
	
	$validation = new Validation();
	
	if(Input::exists()) {
		if(Token::check(Input::get('token'))){
			$validate = $validation->check(array(
				'name'	=> array(
					'required' => true,
					'min' => 2,
					'max' => 50
				),
				'surname'	=> array(
					'required' => true,
					'min' => 2,
					'max' => 50
				),
				'email'	=> array(
					'required' => true,
					'unique' => 'users',
					'must_have'	=> false
				),
				'password' => array(
					'required' => true,
					'min' => 8
				),
				'password_again' => array(
					'required' => true,
					'matches' => 'password'
				),
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
				
				$salt = Hash::salt(32);
				
				try {
					
					$user->create(array(
						'name' 		=> Input::get('name'),
						'surname'	=> Input::get('surname'),
						'email'		=> Input::get('email'),
						'password'	=> Hash::make(Input::get('password'), $salt),
						'salt'		=> $salt,
						'slug'		=> $slug,
						'addr'		=> Input::get('addr'),
						'town'		=> Input::get('town'),
						'country'	=> Input::get('country'),
						'phone'		=> Input::get('phone'),
						'deleted'	=> $reg
					));
					
				} catch(Exception $e) {
					
					Session::flash('danger', $e->getMessage());
					Redirect::to('register');
					exit();
				}
				
				Session::flash('success', 'You account is created!');
				Redirect::to('login');	
			}		
		} else {
			Session::flash('danger', 'Wrong CSRF token!');
			Redirect::to('nf');
		}
	}
	Helper::getHeader('Register', 'header', $user);
	
?>	
    <button type="button" class="btn btn-default"><a href="index.php">Back</a></button>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
		<?php include_once 'notifications.php'; ?>	
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Register</h3>
						<p>to create your account</p>
				</div>
				<div class="panel-body">
					<form method="post">
						<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
					<div class="form-group <?php echo ($validation->hasError('name')) ? 'has-error' : '' ?>">
						<label for="name" class="control-label">Name*</label>
						<input type="text" name="name" class="form-control" id="name" placeholder="Enter your name" value="<?php echo Input::get('name'); ?>" autocomplete="off">
						<?php echo ($validation->hasError('name')) ? '<p class="text-danger">' . $validation->hasError('name') . '</p>' : '' ?>
					</div>
					<div class="form-group <?php echo ($validation->hasError('surname')) ? 'has-error' : '' ?>">
						<label for="surname" class="control-label">Surname*</label>
						<input type="text" name="surname" class="form-control" id="surname" placeholder="Enter your surname" value="<?php echo Input::get('surname'); ?>" autocomplete="off">
						<?php echo ($validation->hasError('surname')) ? '<p class="text-danger">' . $validation->hasError('surname') . '</p>' : '' ?>
					</div>
					<div class="form-group <?php echo ($validation->hasError('email')) ? 'has-error' : '' ?>">
						<label for="email" class="control-label">Email*</label>
						<input type="text" name="email" class="form-control" id="email" placeholder="Enter your email" value="<?php echo Input::get('email'); ?>"><?php echo ($validation->hasError('email')) ? '<p class="text-danger">' . $validation->hasError('email') . '</p>' : '' ?>
					</div>
					<div class="form-group <?php echo ($validation->hasError('password')) ? 'has-error' : '' ?>">
						<label for="password" class="control-label">Password*</label>
						<input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" value="">
						<?php echo ($validation->hasError('password')) ? '<p class="text-danger">' . $validation->hasError('password') . '</p>' : '' ?>
					</div>
					<div class="form-group <?php echo ($validation->hasError('password_again')) ? 'has-error' : '' ?>">
						<label for="password_again" class="control-label">Confirm password*</label>
						<input type="password" name="password_again" class="form-control" id="password_again" placeholder="Enter your password again" value="">
						<?php echo ($validation->hasError('password_again')) ? '<p class="text-danger">' . $validation->hasError('password_again') . '</p>' : '' ?>
					</div>
					<div class="form-group <?php echo ($validation->hasError('addr')) ? 'has-error' : '' ?>">
						<label for="addr" class="control-label">Address*</label>
						<input type="text" name="addr" class="form-control" id="addr" placeholder="Enter your address" value="<?php echo Input::get('addr'); ?>" autocomplete="off">
						<?php echo ($validation->hasError('addr')) ? '<p class="text-danger">' . $validation->hasError('addr') . '</p>' : '' ?>
					</div>
					<div class="form-group <?php echo ($validation->hasError('town')) ? 'has-error' : '' ?>">
						<label for="town" class="control-label">City*</label>
						<input type="text" name="town" class="form-control" id="town" placeholder="Enter your city" value="<?php echo Input::get('town'); ?>" autocomplete="off">
						<?php echo ($validation->hasError('town')) ? '<p class="text-danger">' . $validation->hasError('town') . '</p>' : '' ?>
					</div>
					<div class="form-group <?php echo ($validation->hasError('country')) ? 'has-error' : '' ?>">
						<label for="country" class="control-label">Country*</label>
						<input type="text" name="country" class="form-control" id="country" placeholder="Enter your country" value="<?php echo Input::get('country'); ?>" autocomplete="off">
						<?php echo ($validation->hasError('country')) ? '<p class="text-danger">' . $validation->hasError('country') . '</p>' : '' ?>
					</div>
					<div class="form-group <?php echo ($validation->hasError('phone')) ? 'has-error' : '' ?>">
						<label for="phone" class="control-label">Phone*</label>
						<input type="text" name="phone" class="form-control" id="phone" placeholder="Enter your phone number" value="<?php echo Input::get('phone'); ?>" autocomplete="off">
						<?php echo ($validation->hasError('phone')) ? '<p class="text-danger">' . $validation->hasError('phone') . '</p>' : '' ?>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-default btn-lg btn-block">Register</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>	
	
<?php
	Helper::getFooter();
?>