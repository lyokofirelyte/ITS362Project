<div class="the_grid">
    <?php 
        include(fromModule("module_youtube.php"));
        $twitter = new Twitter();
        $twitter->__init($dbc);
        $twitter_post = 0;
        $youtube_post = 0;
		        
        if (isset($_SESSION["twitter_statuses"])){
        	for ($i = 0; $i < 50; $i++){
        		$rand = rand(0, 1);
        		if ($rand == 0){
        			$twitter->addTwitterPost($twitter_post);
        			$twitter_post++;
        		} else {
        			addYoutubePost();
        		}
        	}
        }
        
        if (!isset($_SESSION["twitter_statuses"]) && isset($_SESSION["link_twitter"])){
        	if ($_SESSION["link_twitter"] == "link"){
        		$twitter->handleRequests();
        	}
        }
    ?>
</div>