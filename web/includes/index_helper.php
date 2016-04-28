<?php 
	require "../vendor/autoload.php";

    $views = array();
    $go = 0;
    
    if (!isset($_SESSION["bg"])){
         $_SESSION["bg"] = "../img/bg.png";
    }
    
    if (isset($_POST["show_tumblr"])){
    	$_SESSION["show_tumblr"] = $_POST["show_tumblr"];
    }
    
    if (!isset($_SESSION["header"])){
    	$_SESSION["header"] = "../img/header_2.png";
    }
    
    if (isset($_POST["link_twitter"])){
    	$_SESSION["link_twitter"] = $_POST["link_twitter"];
    }
	
	if (isset($_POST["youtube_search"])){
		$_SESSION["youtube_search"] = $_POST["youtube_search"];
	}
	
	if (isset($_POST["twitter_linked"])){
		$_SESSION["twitter_linked"] = $_POST["twitter_linked"];
		if ($_POST["twitter_linked"] == 1){
			$_SESSION["show_twitter"] = "yes";
		} else {
			unset($_SESSION["twitter_statuses"]);
			unset($_SESSION["oauth_token"]);
			unset($_SESSION["oauth_token_secret"]);
			unset($_SESSION["twitter"]["access_token"]);
			unset($_SESSION["link_twitter"]);
			unset($_SESSION["show_twitter"]);
			$email = $_SESSION['email'];
			//remove twitter link from user table for that email and on twitter itself
			$sql = "update user set twitter=NULL where email='$email';";
			//run query
			$r = mysqli_query($dbc, $sql);
			//remove row from twitter table
			$sql = "delete from twitter where email='$email';";
			//run query
			$r = mysqli_query($dbc, $sql);
		}
	}

	if (isset($_POST["logged_in"])){
		$_SESSION["user"]["logged_in"] = $_POST["logged_in"];
        if ($_POST["logged_in"] == 1){
            session_unset();
            $_SESSION["bg"] = "../img/bg.png";
            $_SESSION["header"] = "../img/header_2.png";
            $go = 1;
        } else if ($_POST["logged_in"] == 0) {
        	$_SESSION["email"] = $_POST["login_email"];
        }
	}
        
    if (isset($_SESSION["email"])){
        $background_query = "select path from background where email = '" . $_SESSION["email"] . "'";
        $r = mysqli_query($dbc, $background_query);
        $rows = mysqli_num_rows($r);

        if ($rows != 0) {
            $result = $r->fetch_assoc();
            $_SESSION["bg"] = $result["path"];
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
	
	function showPosts(){
		?>
        	<script type='text/javascript'>
        		var x = 0;
        		$(".twitter_post, .youtube_post, .tumblr_post").each(function(i){
            		var dis = $(this);
            		try {
	        			window.setTimeout(function(){
	        				dis.animate({
	        					opacity: "1"
	        				}, 1000);
	            		}, x);
        				x += 100;
            		} catch (e){}
        		});
        	</script>
        <?php
	}
	
	function alert($text){
		echo("<script type='text/javascript'>alert('" . $text . "');</script>");
	}
?>