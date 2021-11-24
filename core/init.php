<?php

	session_start();
	session_regenerate_id(true);

	spl_autoload_register(function($class){
		include 'classes/' . $class . '.php'; 
	});

	$items = Config::get('app');
		if($items['debug'] === false){
			error_reporting(0);
			echo '<h1>Something went wrong!</h1>';
		}

	require_once 'functions/sanitize.php';
	require_once 'functions/debug.php';

	if(Cookie::exists('test') && !Session::exists('User')) { // set '' and 'User' 
		$hash = Cookie::get('test'); // set ''
		$hashChek = DB::getInstance()->get('user_id', 'sessions', array('hash', '=', $hash));
		
		if($hashChek->count()) {
			$user = new User($hashChek->first()->user_id);
			$user->login();
		}
	}

?>