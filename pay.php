<?php

	include_once 'core/init.php';
	
	$user = new User();
	
	if(!$user->check()){
		Redirect::to('login');
	}
	
	$id = get_id();
	
	$cart = DB::getInstance()->query('SELECT * FROM cart WHERE id_user=' . $id)->results();
	
	foreach($cart as $carts) {
		$id_user = $carts->id_user;
		$id_article = $carts->id_article;
		$id_order = $carts->id_order;
		$quantity = $carts->quantity;
		$price = $carts->price;
		$total = $carts->total;
		
		$insert = DB::getInstance()->insert('orders', array(
			'id_user' => $id_user,
			'id_article' => $id_article,
			'id_order' => $id_order,
			'quantity' => $quantity,
			'price' => $price,
			'total' => $total,
			'payway' => 1
			));
	}
	
	DB::getInstance()->delete('cart', 'id_user', $id);
	
	Session::flash('success', 'Your order is on a way!');
	Redirect::at('cart', $id);
	
?>