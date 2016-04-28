<?php

	function getRootPath(){
		return $_SERVER['DOCUMENT_ROOT'];
	}
	
	function fromRoot($var){
		return getRootPath() . "/" . $var;
	}
	
	function fromIncludes($var){
		return getRootPath() . "/includes/" . $var;
	}
	
	function fromModule($var){
		return getRootPath() . "/includes/module/" . $var;
	}
	DEFINE('DB_USER', 'root');
	DEFINE('DB_PASSWORD', 'toor');
	DEFINE('DB_HOST', 'localhost');
	DEFINE('DB_NAME', 'Project');
	function get_password_hash($password){
		return hash_hmac('sha256', $password, 'c#haR1881');
	}
  	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); //make the connection 
?>