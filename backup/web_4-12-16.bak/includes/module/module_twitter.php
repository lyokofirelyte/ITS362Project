<?php 
		use Abraham\TwitterOAuth\TwitterOAuth;
		
		//if (isset($_SESSION["twitter_username"])){
			
			// later we can let users add their own - this is just for my account for testing purposes
			$access_token = "2240099846-df4Oh6JKYrDGnLM8AUq5lmEIRZ9DvhcxBfIjDb9";
			$access_token_secret = "kgXoq42Ekf6rGZu2aeYKlfjgPOPwoqeYG2qYQdtdmwu2U";
			$consumer_key = "ayYdLweDbNQpwOC2R4fOcKBU1";
			$consumer_secret = "8A4rYM6FvAKRyEMYcjk91MpUKA6Ta8nSJolvuhsr90AVEjUkD4";
			
			$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
			$content = $connection->get("account/verify_credentials");
			
			//$me = $connection->get("users/lookup", ["screen_name" => "lyokofirelyte"]);
			
			/*echo(
				"<div class='twitter_post' style='border: none'>" .
					"<img src='" . $me[0]->profile_image_url . "' />" .
					"<p class='twitter_self'>" . $me[0]->name . "'s Twitter Timeline</p>" .
					"<div class='desc'>" . $me[0]->description . "</div>" .
				"</div>" .		
				"<br />"
			);*/
			
			$_SESSION["twitter_statuses"] = $connection->get("statuses/home_timeline", ["count" => 100, "exclude_replies" => true]);
		//}
		
		$_SESSION["twitter_amount"] = 0;
		
		function addTwitterPost(){
			
			try {
				
				$statuses = $_SESSION["twitter_statuses"];
				$media = "";
				$text = $statuses[$i]->text;
				$x = 0;
				$i = $_SESSION["twitter_amount"];
					
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
				
				if (strlen($text) > 1){
					echo(
						"<div class='twitter_post'>" .
							"<div class='float-right'><i class='fa fa-twitter' id='icon_white'></i> <i class='fa fa-angle-up' id='arrows'></i></div>" .
							"<div class='generic_header'>" .
								//"<a class='generic_profile_image' href='" . str_replace("_normal", "", $statuses[$i]->user->profile_image_url). "'>" .
									"<img src='" . $statuses[$i]->user->profile_image_url . "' />" .
								//"</a>" .
								"<div class='generic_username'> " .
									"<a href='http://twitter.com/" . str_replace("@", "", $statuses[$i]->user->screen_name) . "'>" . $statuses[$i]->user->name . "</a>" .
								"</div>" .
							"</div>" .
							"<p>" . $text . "</p>" .
							$media .
						"</div>"
					);
				}
				
			} catch (Exception $e){}
			
			$_SESSION["twitter_amount"]++;
		}
?>