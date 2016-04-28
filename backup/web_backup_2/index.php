<?php 
	session_start();
	require "../vendor/autoload.php";
	require "includes/dir_config.php";

    $views = array();
    $go = 0;
    
    if (isset($_POST["link_twitter"])){
    	$_SESSION["link_twitter"] = $_POST["link_twitter"];
    }
	
	if (isset($_POST["twitter_linked"])){
		if ($_POST["twitter_linked"] == 1){
			echo '<script type="text/javascript">twitter_linked = 1</script>';
			$_SESSION["displayTwitter"] = "yes";
		} else {
			echo '<script type="text/javascript">twitter_linked = 0</script>';
			//unset($_SESSION["twitter_statuses"]);
			unset($_SESSION["oauth_token"]);
			unset($_SESSION["oauth_token_secret"]);
			unset($_SESSION["twitter"]["access_token"]);
			unset($_SESSION["link_twitter"]);
			$email = $_SESSION['email'];
			//remove twitter link from user table for that email and on twitter itself
			$sql = "update user set twitter=NULL where email='$email';";
			//run query
			$r = mysqli_query($dbc, $sql);
			//remove row from twitter table
			$sql = "delete from twitter where email='$email';";
			//run query
			$r = mysqli_query($dbc, $sql);
			$_SESSION["displayTwitter"] = "no";
		}
	}

	if (isset($_POST["logged_in"])){
		$_SESSION["user"]["logged_in"] = $_POST["logged_in"];
        if ($_POST["logged_in"] == 1){
            $_SESSION = array();
            session_destroy();
            $go = 1;
        } else if ($_POST["logged_in"] == 0) {
        	$_SESSION["email"] = $_POST["login_email"];
        }
	}
	
	if ($go == 0){
	    if (isset($_POST["update_views"])){
	        foreach ($_POST["update_views"] as $update_key){
	            array_push($views, $update_key);
	        }
	    }
	
	    if (!isset($_SESSION["user"]["logged_in"]) || $_SESSION["user"]["logged_in"] >= 1){
	        if (sizeof($views) == 0){
	            array_push($views, "login");
	        }
	    }
	
	    if (isset($_SESSION["user"]["verified"]) && $_SESSION["user"]["verified"] == "yes"){
	        array_push($views, "content");
	    }
	} else {
		array_push($views, "login");
	}
?>
<html>
	<head>
		<link rel="stylesheet" href="css/module.css" />
		<link rel="stylesheet" href="css/global.css" />
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script type="text/javascript">
		<?php if(!isset($_POST["twitter_linked"])){ $_SESSION["displayTwitter"] = "no";?> var twitter_linked = 0; <?php  } ?>
		</script>
		<script src="js/module_main.js"></script>
		<script src="js/jsutils.js"></script>
	</head>
	<body>
		<?php
			include(fromIncludes("header.php"));
		?>
        <div class="all_noscroll">
            <div class="all">
                <?php 
                    foreach ($views as $view){
                        include(fromIncludes($view . ".php"));
                    }
                    echo("<script type='text/javascript'>pageDone();</script>");
                ?>
            </div>
        </div>
        <?php 
      	  include(fromIncludes("sidebar.php"));
        ?>
	</body>
</html>