<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	if(!$user->check()){
		Redirect::to('login');
	} else if($user->data()->slug === 'user') {
		Redirect::to('index');
	}
	
	$id = get_id();
	
	$name = DB::getInstance()->query('SELECT title FROM product WHERE id=' . $id)->results();
	
	DB::getInstance()->delete('products', 'id', $id);
	DB::getInstance()->delete('articles', 'title', $name);
	
	Session::flash('success', 'Product and articles deleted!');
	Redirect::to('dashboard');
	
?>