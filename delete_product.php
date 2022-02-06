<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	if(!$user->check()){
		Redirect::to('login');
	} else if($user->data()->slug === 'user') {
		Redirect::to('index');
	}
	
	$id = get_id();
	
	DB::getInstance()->delete('products', 'id', $id);
	
	Session::flash('success', 'Product and articles deleted!');
	Redirect::to('dashboard');
	
?>