<link rel="stylesheet" href="css/login.css" />
<?php

	if (!isset($_SESSION["user"]["verified"])){
		if (isset($_POST['login_email'])){
			$email = $_POST['login_email'];
			$pass = $_POST['login_password'];
				
			//after posting to itself make sure that the account is available
			$sql1 = "Select email from users where email = '$email'";
			$r = mysqli_query($dbc, $sql1);
			$rows = mysqli_num_rows($r);
		
			if ($rows != 0) {
				//if there is check password
				$sql2 = "Select email from users where email = '$email' AND password = '" . get_password_hash($pass) . "';";
				$r2 = mysqli_query($dbc, $sql2);
				$rows2 = mysqli_num_rows($r2);
				//echo "Entered pass= " . get_password_hash($pass) . " ||||||| db_pass= $db_pass";
				if ($rows2 != 0){
					$_SESSION["email"] = $_POST['login_email'];
					$_SESSION["user"]["verified"] = "yes";
					include("content.php");
					return;
				}
			}
		
			echo("<h1 class='main_title'>Something's not quite right. Try again, please!</h1>");
			displayLogin();
		
		} else {
			if (isset($_POST["logged_in"]) && $_POST["logged_in"] == 2){
				displayLogin();
			} else {
				echo("<h1 class='main_title'>Omnideck Social Media Viewer</h1><h2 class='main_subtitle'>It works! Unless you're not seeing this message, in which case it didn't work.</h2><h5 class='main_subtitle'>Basically just install Chrome.</h5>");
				include(fromIncludes("news.php"));
			}
		}
	} else {
		array_push($views, "content");
	}
     
     function displayLogin(){
     	echo(
     		"<div class='info_panel'>" .
     			"<p>Log in to Omnideck - you know you want to.</p>" .
     		"</div>" .
     		"<div class='login_form'>" .
     			"<input type='text'id='login_email' placeholder='Email' />" .
     			"<br />" .
     			"<input type='password' id='login_password' placeholder='Password' />" .
     			"<br />" .
     			"<i class='fa fa-sign-in' aria-hidden='true' id='loginSubmit'></i>" .
     		"</div>"
     	);
     }
?>