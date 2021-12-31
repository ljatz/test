<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	if(!$user->check()){
		Redirect::to('login');
	}
	
	$id = get_id();
	$ids = get_page();
	
	DB::getInstance()->delete('cart', 'id', $ids);
	
	Session::flash('success', 'Article removed!');
	Redirect::at('cart', $id);
	
?>