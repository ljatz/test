<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	if(!$user->check()){
		Redirect::to('login');
	} else if($user->data()->slug === 'user') {
		Redirect::to('index');
	}
	
	$id = get_id();
	
	$name = DB::getInstance()->query('SELECT title FROM products WHERE id=' . $id)->results();
	
	foreach($name as $nam){
		echo $x = $nam->title;
	}
	
	$ids = DB::getInstance()->query('SELECT id FROM articles WHERE product="' . $x . '"')->results();
	
	foreach($ids as $aid){
		
		DB::getInstance()->delete('articles', 'id', $aid->id);
		
	}
	
	Redirect::at('delete_product', $id);
	
?>