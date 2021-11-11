<?php

	include_once 'core/init.php';
	
	$user = new User();
	
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
					echo '<button type="button" class="btn btn-default"><a href="logout.php">Logout</a></button>';
				}
				?>
			</div>
		</div>
		<h1>WS</h1>
			<p>address</p>
	</div>
<?php
	Helper::getFooter();	
?>