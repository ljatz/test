<?php

function vd($var){
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
	die();
}

function get_id() {
	$id = $_SERVER['REQUEST_URI'];
	$last = strstr($id, '=');
	$last = substr($last, 1);
	
	
	if(!preg_match("/-/i", $last)) {
		return $last;
	} else {
		$last = strstr($last, '-', true);
		return $last;
	}
}	

function get_page() {
	$id = $_SERVER['REQUEST_URI'];
	$start = strstr($id, '=');
	$start = substr($start, 1);
	
	if(preg_match("/-/i", $start)){
		$last = strstr($start, '-');
		$last = substr($last, 1);
		
		return $last;
	} else {
		return "1";
	}
}

function location() {
	$id = $_SERVER['REQUEST_URI'];
	$location = strrchr($id, '/');
	
	return $location;
}

function bill($price) {

	$price = str_replace('.', ',', $price);

	$a = strlen(strstr($price, ','));
	
	if(!preg_match('/,/', $price) ){
		return $price . ',00';
	} elseif($a < 3) {
		return $price . '0';
	} else {
		return $price;
	}
}
	
?>