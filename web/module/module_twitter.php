<html>
	<?php 
		session_start();
		require "../../vendor/autoload.php";
		use Abraham\TwitterOAuth\TwitterOAuth;
		
		if (isset($_POST["logged"])){
			$_SESSION["logged"] = $_POST["logged"];
		}
		
		if (isset($_POST["twitter_username"])){
			$_SESSION["twitter_username"] = $_POST["twitter_username"];
		}
	?>
	<head>
		<link rel="stylesheet" href="../css/module.css" />
		<link rel="stylesheet" href="../css/global.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="../js/module_twitter.js"></script>
		<script src="../js/jsutils.js"></script>
	</head>
	<body>
		<div class="block">
			<ul class="module_bar">
				<li id="menu_twitter">Twitter <i class="fa fa-twitter"></i></li>
				<li>Reddit  <i class="fa fa-reddit-alien"></i></li>
				<li>Youtube  <i class="fa fa-youtube-play"></i></li>
			</ul>
			<ul class="user_bar">
				<?php 
					if ($_SESSION["logged"] == "yes"){
						echo "<li>Welcome, User! <i class=\"fa fa-check\"></i></li>";
						echo "<li>Account  <i class=\"fa fa-user\"></i></li>";
						echo "<li id='module_logout'>Logout  <i class=\"fa fa-power-off\"></i></li>";
					} else {
						echo "<li id='module_login'>Log In <i class=\"fa fa-sign-in\"></i>";
					}
				?>
			</ul>
			<h1 class="title">Omnideck Social Media Manager</h1>
		</div>
		
		<?php 
		
			if (isset($_SESSION["twitter_username"])){
				
				// later we can let users add their own - this is just for my account for testing purposes
				$access_token = "2240099846-df4Oh6JKYrDGnLM8AUq5lmEIRZ9DvhcxBfIjDb9";
				$access_token_secret = "kgXoq42Ekf6rGZu2aeYKlfjgPOPwoqeYG2qYQdtdmwu2U";
				$consumer_key = "ayYdLweDbNQpwOC2R4fOcKBU1";
				$consumer_secret = "8A4rYM6FvAKRyEMYcjk91MpUKA6Ta8nSJolvuhsr90AVEjUkD4";
				
				$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
				$content = $connection->get("account/verify_credentials");
				
				// profile
				$me = $connection->get("users/lookup", ["screen_name" => "lyokofirelyte"]);
				
				echo(
					"<div class='twitter_post' style='border: none'>" .
						"<img src='" . $me[0]->profile_image_url . "' />" .
						"<p class='twitter_self'>" . $me[0]->name . "'s Twitter Timeline</p>" .
						"<div class='desc'>" . $me[0]->description . "</div>" .
					"</div>" .		
					"<br />"
				);
				
				// THIS IS LIKE A CRAZY BIG MESS OF STUFF, RIP EYES
				$statuses = $connection->get("statuses/home_timeline", ["count" => 10, "exclude_replies" => true]);
				
				for ($i = 0; $i < 5; $i++){
					
					try {
						
						$media = "";
						$text = $statuses[$i]->text;
						$x = 0;
						
						if (!is_null($statuses[$i]->entities->urls[0]->expanded_url)){
							foreach ($statuses[$i]->entities->urls as $current_url){
								$full_url = $current_url->expanded_url;
								$orig_url = $current_url->url;
									
								if ($x == 0){
									$orig_url = str_replace($orig_url, "<a href='" . $full_url . "'>" . $orig_url . "</a>", $orig_url);
								}
									
								$text = str_replace($current_url->url, $orig_url, $statuses[$i]->text);
								$x = 0;
							}
						}
						
						if (!is_null($statuses[$i]->entities->media[0]->media_url)){
							foreach ($statuses[$i]->entities->media as $image){
								$media = "<img src='" . $image->media_url . "' />";
							}
						}

						echo(
							"<div class='twitter_post'>" .
								"<div class='float-right'><i class='fa fa-twitter'></i></div>" .
								"<div class='twitter_profile_header'>" .
									"<a href='" . str_replace("_normal", "", $statuses[$i]->user->profile_image_url). "'><img src='" . $statuses[$i]->user->profile_image_url . "' /></a>" .
									"<div class='twitter_user'> " . $statuses[$i]->user->name . "</div>" .
								"</div>" .
								"<p>" . $text . "</p>" .
								$media .
							"</div>"
						);
					} catch (Exception $e){}
				}
			}
		?>
		
	</body>
</html>