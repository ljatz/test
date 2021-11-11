<!DOCTYPE html>
<html lang="hr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="">
		<meta name="description" content="">
		<title>
			<?php 
				echo Config::get('app')['name'];
				echo (!empty($title)) ? ' - '.$title : '';
			?>
		</title>
		
		<link href="css/bootstrap.css" rel="stylesheet">
		
		<script src="js/jquery-3.3.1.slim.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
		