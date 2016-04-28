<?php 
	$array = array(
		"Added a way to unlink your accounts. Neat, right?",
		"Changed the style to dark theme, the white was too bright.",
		"Added twitter auth! No longer hardcoded. You can use any twitter account now.",
		"Added a sidebar so that we can save screen space.",
		"Youtube videos won't play on the page anymore due to lagg.",
		"Added youtube search. Oauth might take too long right now.",
	);
	
	echo(
		"<div class='all_noscroll' style='top: 200px'>" .
			"<div class='all'>" . 
				"<div class='the_grid'>"
	);
	
	foreach ($array as $text){
		echo(
					"<div class='twitter_post'>" .
						"<div class='float-right'>" .
							"<i class='fa fa-code' aria-hidden='true'></i>" .
						"</div>" .
						"<div class='generic_header'>" .
							"<img style='width: 50px; height: 50px' src='https://avatars2.githubusercontent.com/u/4260126?v=3&s=460' />" .
							"<div class='generic_username'>" .
								"<a href='https://github.com/lyokofirelyte/its362project'>David T & Kyle M</a>" .
							"</div>" .
						"</div>" .
					"<p style='color: rgba(255, 255, 255, 0.8'>" . $text . "</p>" .
					"</div>"
		);
	}
	
	echo(
				"</div>" .
			"</div>" .
		"</div>"
	);
?>