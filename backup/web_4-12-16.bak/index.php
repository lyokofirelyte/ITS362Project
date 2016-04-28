<?php 
	session_start();
	require "../vendor/autoload.php";
	require "includes/dir_config.php";
	
	if (isset($_POST["logged_in"])){
		$_SESSION["user"]["logged_in"] = $_POST["logged_in"];
	}
?>
<html>
	<head>
		<link rel="stylesheet" href="css/module.css" />
		<link rel="stylesheet" href="css/global.css" />
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="js/module_main.js"></script>
		<script src="js/jsutils.js"></script>
	</head>
	<body>

		<?php
			include(fromIncludes("sidebar.php"));
		?>

			<div class="all_noscroll">
				<div class="all">
					<?php 
						include(fromIncludes("header.php"));
						if (isset($_POST["register"]) && $_POST["register"] == "yes"){
							echo("<p style='color: white'>Register Page Here</p>");
						} else if ($_SESSION["user"]["logged_in"] != "yes"){
							echo("<p style='color: white'>You need to be logged in to access the content!</p>");
						} else {
					?>
					<div class="the_grid">
						<?php 
							include(fromModule("module_twitter.php"));
						    include(fromModule("module_youtube.php"));
						    for ($i = 0; $i < 50; $i++){
						    	$rand = rand(0, 1);
						    	if ($rand == 0){
						    		addTwitterPost();
						    	} else {
						    		addYoutubePost();
						    	}
						    }
						    echo("<script type='text/javascript'>pageDone();</script>");
						?>
					</div>
					<?php 
						}
					?>
				</div>
			</div>
	</body>
</html>