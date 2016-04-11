<?php

	function getRootPath(){
		return $_SERVER['DOCUMENT_ROOT'];
	}
	
	function fromRoot($var){
		return getRootPath() . $var;
	}
	
	function fromIncludes($var){
		return getRootPath() . "includes/" . $var;
	}
	
	function fromModule($var){
		return getRootPath() . "includes/module/" . $var;
	}

?>