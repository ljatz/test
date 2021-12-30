<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	if(!$user->check()){
		Redirect::to('login');
	}
	
	$id = get_id();
	
	DB::getInstance()->delete('cart', 'id_user', $id);
	
	Session::flash('success', 'Cart empty!');
	Redirect::at('cart', $id);
	
?>