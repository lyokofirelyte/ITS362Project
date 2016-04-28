<?php

	class Tumblrr {
		
		public $consumer_key = "ck8XhiLzEdxpY7GaXVA21u56RcmdHyeATyFXxsX6tDF3lrnoYa";
		public $consumer_secret = "2K0gXUQyLOSx4fNPjNc7aJuUQdQX2ZfXuI7OR5qtC8FLvSTWdV";
		public $auth_url = 'http://www.tumblr.com/oauth/authorize';
		public $client = null;
		public $posts = array();
		
		public function auth(){
			$_SESSION["auths"] = "tumblr";
			$client = new Tumblr\API\Client($this->consumer_key, $this->consumer_secret);
			$client->getRequestHandler()->setBaseUrl('http://www.tumblr.com/');
			
			$req = $client->getRequestHandler()->request('POST', 'oauth/request_token', [
					'oauth_callback' => function(){},
			]);
			
			$out = $result = $req->body;
			$data = array();
			parse_str($out, $data);
			$_SESSION['tumblr_request_token'] = $data["oauth_token"];
			$_SESSION['tumblr_request_token_secret'] = $data["oauth_token_secret"];
			
			$result = $req->body->__toString();
			$result = str_replace("oauth_token=", "", $result);
			$result = str_replace("oauth_token_secret=", "", $result);
			$result = explode("&", $result);
			$access_url = $this->auth_url . "?oauth_token=" . $result[0];
		   	echo("<script type='text/javascript'>location.assign('" . $access_url . "');</script>");
		  // echo("<a href='" . $access_url . "'>Please click here</a>");
		}
		
		public function incoming(){
			if (isset($_REQUEST["oauth_verifier"])){
				$client = new Tumblr\API\Client($this->consumer_key, $this->consumer_secret);
				$client->getRequestHandler()->setBaseUrl('http://www.tumblr.com/');
				$client->setToken($_SESSION['tumblr_request_token'], $_SESSION['tumblr_request_token_secret']);
				$resp = $client->getRequestHandler()->request('POST', 'oauth/access_token', array('oauth_verifier' => $_REQUEST["oauth_verifier"]));
				$out = $result = $resp->body;
				$data = array();
				parse_str($out, $data);
				$_SESSION["tumblr_oauth_token"] = $data["oauth_token"];
				$_SESSION["tumblr_oauth_token_secret"] = $data["oauth_token_secret"];
				echo("Tumblr is now linked. Refresh to see changes.");
			}
		}
		
		public function finish(){
			$this->client = new Tumblr\API\Client($this->consumer_key, $this->consumer_secret, $_SESSION["tumblr_oauth_token"], $_SESSION["tumblr_oauth_token_secret"]);
			$info = $this->client->getUserInfo();
			$this->posts = $this->client->getDashboardPosts($options = null);
		}
		
		public function addTumblrPost($i){
			
			try {
				$post = $this->posts->posts[$i];
				$media = "";
				
				if (isset($post->photos)){
					foreach ($post->photos as $photo){
						$image = $photo->original_size->url;
						$media .= "<img src='" . $image . "' /><br /><br />";
					}
				}
				
				echo(
					"<div class='tumblr_post'>" .
						"<div class='float-right'><i class='fa fa-tumblr' id='icon_white'></i> <i class='fa fa-angle-up' id='arrows'></i></div>" .
						"<div class='generic_header'>" .
							"<img src='" . $this->client->getBlogAvatar($post->blog_name) . "' />" .
							"<div class='generic_username'> " .
								"<a href='" . $post->post_url . "'>" . $post->blog_name ."</a>" .
							"</div>" .
						"</div>" .
						"<p>" . (!is_null($post->summary) ? $post->summary : "") . "</p>" .
						$media .
					"</div>"
				);
			} catch (Exception $e){}
		}
	}
?>