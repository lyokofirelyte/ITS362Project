<div class="the_grid">
    <?php 
		if (isset($_SESSION["youtube_search"])){
			include(fromModule("module_youtube.php"));
		}
		
		$twitter = new Twitter();
		$twitter->__init($dbc);
		$tumblr = new Tumblrr();
		$twitter_post = 0;
        $tumblr_post = 0;
        
        $actually_show_posts = 0;
        
        // CHECK FOR INCOMING AUTHS. DON'T DO ANYTHING IF THERE IS ONE OR EVERYTHING EXPLODES
        // [ screaming intensifies ]
        
        if (isset($_SESSION["auths"])){ // hold on to your socks
        	if ($_SESSION["auths"] == "twitter"){ // returning from twitter
        		$_SESSION["auths"] = "none";
        		$twitter->confirmAuth();
        		$actually_show_posts = 1;
        	} else if ($_SESSION["auths"] == "tumblr"){
        		$_SESSION["auths"] = "none";
        		$tumblr->incoming();
        		$actually_show_posts = 1;
        	}
        	unset($_SESSION["auths"]);
        }
        
        if ($actually_show_posts == 0){
        	
        	// Check to see if they need to send a request or if they already have the access token
        	if (isset($_SESSION["show_tumblr"])){
		        if (isset($_SESSION["tumblr_oauth_token"])){
		        	$tumblr->finish();
		        } else {
		        	$tumblr->auth();
		        	$actually_show_posts = 1;
		        }
        	}
	        
        	if (isset($_SESSION["show_twitter"])){
		        if (isset($_SESSION["twitter"]["access_token"])){
		        	$twitter->connect($_SESSION["twitter"]["access_token"]["oauth_token"], $_SESSION["twitter"]["access_token"]["oauth_token_secret"]);
		        } else {
		        	if ($twitter->checkDatabase() == 1){
		        		$twitter->init();
		        		$actually_show_posts = 1;
		        	} else {
		        		$twitter->connect($_SESSION["twitter"]["access_token"]["oauth_token"], $_SESSION["twitter"]["access_token"]["oauth_token_secret"]);
		        	}
		        }
        	}
	        
	        if ($actually_show_posts == 0){
				for ($i = 0; $i < 50; $i++){
		        	$rand = rand(0, 2);
		        	if ($rand == 0){
		        		if (isset($_SESSION["show_twitter"])){
			        		$actual_post = $twitter->addTwitterPost($twitter_post);
			        		if ($actual_post != "fail"){
			        			$twitter_post++;
			        			echo($actual_post);
			        		}
		        		} else {
		        			$i--;
		        		}
		        	} else if($rand == 1){
		        		if (isset($_SESSION["youtube_search"])){
		        			addYoutubePost();
		        		} else {
		        			$i--;
		        		}
		        	} else {
						if (isset($_SESSION["show_tumblr"])){
							$tumblr->addTumblrPost($tumblr_post);
							$tumblr_post++;
						}
		        	}
		        }
		        
		        showPosts();
	        }
        }
    ?>
</div>