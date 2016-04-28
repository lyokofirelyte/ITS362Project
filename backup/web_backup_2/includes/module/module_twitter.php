<?php

	use Abraham\TwitterOAuth\TwitterOAuth;

	class Twitter {
		public $access_token = "2240099846-df4Oh6JKYrDGnLM8AUq5lmEIRZ9DvhcxBfIjDb9";
		public $access_token_secret = "kgXoq42Ekf6rGZu2aeYKlfjgPOPwoqeYG2qYQdtdmwu2U";
		public $consumer_key = "ayYdLweDbNQpwOC2R4fOcKBU1";
		public $consumer_secret = "8A4rYM6FvAKRyEMYcjk91MpUKA6Ta8nSJolvuhsr90AVEjUkD4";
		public $request_token = [];
		public $dbc;
		
		public function __init($dbc){
			$this->dbc = $dbc;
		}
		
		/**
		 * Returns the profile info for the logged in twitter user.
		 */
		public function getUserData($oauth_token, $oauth_token_secret){
			$connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $oauth_token, $oauth_token_secret);
			$me = $connection->get("account/verify_credentials");
			return(
				 "<div class='twitter_header' style='border: none'>" .
					 "<i class='fa fa-twitter'></i> " .
					 "<img src='" . $me->profile_image_url . "' />" .
					 "<span class='twitter_self'> " . $me->name . "</span>" .
					 "<span class='desc'> (" . $me->description . ")</span>" .
				 "</div>"
			 );
		}
		
		/**
		 *  They have already authorized thier account on twitter so we directly connect 
		 */
		public function connect($oauth_token, $oauth_token_secret){
			$connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $oauth_token, $oauth_token_secret);
			$content = $connection->get("account/verify_credentials");
			$c = $connection->get("statuses/home_timeline", ["count" => 100, "exclude_replies" => true]);
			$_SESSION["twitter_statuses"] = (array) $c;
			echo(
				"<script type='text/javascript'>" .
					"window.setTimeout(function(){" .
						"location.reload();" .
					"}, 300);" .
				"</script>"
			);
		}
		
		/**
		 * They're returning from hitting the "authorize" button on twitter.com
		 */
		public function confirmAuth(){
			$request_token['oauth_token'] = $_SESSION['oauth_token'];
			$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];
			
			$connection = new TwitterOAuth(
				$this->consumer_key,
				$this->consumer_secret,
				$request_token['oauth_token'],
				$request_token['oauth_token_secret']
			);
			
			$access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);
			$_SESSION["twitter"]["access_token"] = $access_token;
			$email = $_SESSION['email'];
			$sql2 = "insert into twitter (email, oauth_token, oauth_token_secret) values ('". $email . "', '" . $access_token['oauth_token'] ."', '" . $access_token["oauth_token_secret"] . "')";
			$r = mysqli_query($this->dbc, $sql2);
			unset($_REQUEST["oauth_verifier"]);
			$this->connect($access_token["oauth_token"], $access_token["oauth_token_secret"]);
		}
		
		/**
		 * They have not added twitter yet so we get some temp keys and send them where they need to go 
		 */
		public function init(){
			$connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $this->access_token, $this->access_token_secret);
			$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => function(){}));
			$_SESSION['oauth_token'] = $request_token['oauth_token'];
			$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
			$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
			echo("<script type='text/javascript'>location.assign('" . $url . "')</script>");
		}
		
		/**
		 * Determines which function to call when they load this page
		 */
		public function handleRequests(){
			if (isset($_REQUEST['oauth_verifier'])){
				$this->confirmAuth();
			} else if (isset($_SESSION["twitter"]["access_token"])){
				$this->connect($_SESSION["twitter"]["access_token"]["oauth_token"], $_SESSION["twitter"]["access_token"]["oauth_token_secret"]);
			} else {
				$email = $_SESSION["email"];
				$sql = "select oauth_token, oauth_token_secret from twitter where email = '" . $email . "';";
				$r = mysqli_query($this->dbc, $sql);
				if (!is_null($r)){
					$rows = mysqli_num_rows($r);
					if ($rows > 0){
						$row = $r->fetch_assoc();
						$_SESSION["twitter"]["access_token"]["oauth_token"] = $row["oauth_token"];
						$_SESSION["twitter"]["access_token"]["oauth_token_secret"]= $row["oauth_token_secret"];
						$this->connect($_SESSION["twitter"]["access_token"]["oauth_token"], $_SESSION["twitter"]["access_token"]["oauth_token_secret"]);
					} else {
						$this->init();
					}
				} else {
					$this->init();
				}
			}
		}
		
		public function addTwitterPost($i){
		
			try {
				$statuses = (array) $_SESSION["twitter_statuses"];
				$media = "";
				$text = "";
				if (isset($statuses[$i]->text)){
					$text = $statuses[$i]->text;
				}
				$x = 0;
					
				if (isset($statuses[$i]->entities->urls[0]->expanded_url)){
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
				
				try {
					if (isset($statuses[$i]->entities->media[0]->media_url)){
						foreach ($statuses[$i]->entities->media as $image){
							$media = "<img src='" . $image->media_url . "' />";
						}
					}
				} catch (Exception $this_page_is_the_death_of_me){}
	
				if (strlen($text) > 1){
					echo(
						"<div class='twitter_post'>" .
							"<div class='float-right'><i class='fa fa-twitter' id='icon_white'></i> <i class='fa fa-angle-up' id='arrows'></i></div>" .
							"<div class='generic_header'>" .
								"<img src='" . $statuses[$i]->user->profile_image_url . "' />" .
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
		}
	}
?>