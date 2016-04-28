<?php

	// for testing purposes
	$_SESSION["youtube_amount"] = 0;
	$_POST['q'] = $_SESSION["youtube_search"];
	$_SESSION["youtube_array"] = array();
	
	if (isset($_POST['q'])){
		
		require_once fromRoot("../vendor/google/apiclient/src/Google/Client.php");
		require_once fromRoot("../vendor/google/apiclient/src/Google/Service/YouTube.php");
		
		$DEVELOPER_KEY = 'AIzaSyB_TAd7ED3eUNw2rxzGI7V9yg66zK0IG9g';
		$client = new Google_Client();
		$client->setDeveloperKey($DEVELOPER_KEY);
		
		$youtube = new Google_Service_YouTube($client);
		$searchResponse = "";
		
		try {
		
			$searchResponse = $youtube->search->listSearch('id,snippet', array(
				'q' => $_POST['q'],
				'maxResults' => 50
			));
			
			foreach ($searchResponse['items'] as $searchResult) {
				if ($searchResult['id']['kind'] === 'youtube#video'){
					array_push($_SESSION["youtube_array"],
						"<div class='youtube_post'>" .
							"<div class='float-right'><i class='fa fa-youtube-play' id='icon_white'></i> <i class='fa fa-angle-up' id='arrows'></i></div>" .
							"<div class='generic_header'>" .
								"<div class='generic_header'>" .
									"<img src='" . "https://i.ytimg.com/i/" . $searchResult['snippet']['channelId'] . "/1.jpg" . "' />" .
								"</div>" .
								"<div class='generic_username'>" . 
									$searchResult['snippet']['channelTitle'] .
								"</div>" .
								"<a href='https://www.youtube.com/watch?v=" . $searchResult['id']['videoId'] . "'><br />" . $searchResult['snippet']['title'] . "</a>" .
							"</div>" .
							"<img src='" . "http://img.youtube.com/vi/" . $searchResult['id']['videoId'] . "/0.jpg" . "' />" .
							"<p>"  . "</p>" .
						"</div>"
					);
				}
			}
			
			//print_r($searchResult);
			
		} catch (Exception $e){}
	}
	
	function addYoutubePost(){
		try {
			echo($_SESSION["youtube_array"][$_SESSION["youtube_amount"]]);
			$_SESSION["youtube_amount"]++;
		} catch (Exception $e){}
	}
?>