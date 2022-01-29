<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	if(!$user->check()){
		Redirect::to('login');
	} else if($user->data()->slug === 'user') {
		Redirect::to('index');
	}
	
	$id = get_id();
	
	$delete = DB::getInstance()->query('SELECT * FROM users WHERE id = "'.$id.'"')->results();
	
	foreach($delete as $del) {
		$id = $del->id;	
	
		$deleted_users = DB::getInstance()->update('users', array(
			'name' 		=> $name = $del->name,
			'surname'	=> $surname = $del->surname,
			'email'		=> '0'. $email = $del->email,
			'password'	=> $password = $del->password,
			'salt'		=> $salt = $del->salt,
			'slug'		=> $slug = $del->slug,
			'addr'		=> $addr = $del->addr,
			'town'		=> $town = $del->town,
			'country'	=> $country = $del->country,
			'phone'		=> $phone = $del->phone,
			'deleted'	=> date('d.m.Y. H:i:s'),
			'orders_id'	=> $orders_id = $del->orders_id
		), get_id());
	}
	
	Session::flash('success', 'Profil deleted!');
	Redirect::to('dashboard');
	
?>