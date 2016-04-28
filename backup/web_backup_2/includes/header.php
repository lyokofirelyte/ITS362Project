<div class="header">
	<h3 style="float: left">Omnideck</h3>
	<h3 style="float: right; padding-right: 15px">v1.0</h3>
	<!-- <img id="loading_icon" src="http://i.imgur.com/jfEmGpf.gif" />  -->
	<?php 
		include(fromModule("module_twitter.php"));
        if (isset($_SESSION["twitter_statuses"])){
        	$twitter = new Twitter();
        	$twitter->__init($dbc);
        	$profile = $twitter->getUserData($_SESSION["twitter"]["access_token"]["oauth_token"], $_SESSION["twitter"]["access_token"]["oauth_token_secret"]);
        	echo($profile);
        }
	?>
</div>