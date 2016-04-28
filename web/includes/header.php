<?php 
	echo(
		"<div class=\"header\" style=\"" . 
			"background: url('" . (isset($_SESSION["header"]) ? $_SESSION["header"] : "../img/header_2.png") . "');" .
    		" background-opacity: 0.2;" .
			" background-size:     cover;" .
		    " background-repeat:   no-repeat;" .
		    " background-position: center center; " .
			" position: fixed;" .
			" width: 100%;" .
			" color: white;" .
			" text-align: center;" .
			" z-index: 1000;" .
			" left: 0;" .
			" top: 0;" .
		"\">"
	);
?>
<h3 style="float: left">Omnideck</h3>
<h3 style="float: right; padding-right: 15px">v1.0</h3>
<?php 
	include(fromModule("module_twitter.php"));
	if (isset($_SESSION["twitter_statuses"])){
		$twitter = new Twitter();
        $twitter->__init($dbc);
        $profile = $twitter->getUserData($_SESSION["twitter"]["access_token"]["oauth_token"], $_SESSION["twitter"]["access_token"]["oauth_token_secret"]);
        echo($profile);
    }
    echo("</div>");
?>