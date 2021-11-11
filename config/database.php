<?php

return [

	'fetch' => PDO::FETCH_OBJ,  
	'driver' => 'mysql',
	
	'mysql'	=> [
		'host'	=> '127.0.0.1', // set host
		'user'	=> 'root', // set user
		'pass'  => '',	// set password
		'db'    => 'wst1', // set db
		'options'	=>	[
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
		]
	]
];

?>