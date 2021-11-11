<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	Helper::getHeader('', 'header');	

?>
			<div class="jumbotron">
			<?php include_once 'notifications.php'; ?>
				<h1 class="text-center">404</h1>
				<h2 class="text-center">Page not found</h2>
				<div class="text-center">
					<div class="btn" role="group">
						<button type="button" class="btn btn-default"><a href="index.php">Back to homepage</a></button>		
					</div>
				</div>
			</div>
<?php
	Helper::getFooter();	
?>