<?php

class Redirect
{
	private function __construct(){}
	
	public static function to($location)
	{
		if(is_numeric($location)) {
			switch($location) {
				case 404:
					header('HTTP/1.0 404 Not Found');
					
					exit();
				break;
			}
		}
		
		header('Location:' . $location . '.php');
		exit();
	}
	 
	public static function at($location, $id)
	{
		if(is_numeric($location)) {
			switch($location) {
				case 404:
					header('HTTP/1.0 404 Not Found');
					
					exit();
				break;
			}
		}
		
		header('Location:' . $location . '.php?id=' . $id);
		exit();
	}
	
	public static function refresh($location)
	{	
		header('Refresh:0');
		exit();
	}
}

?>