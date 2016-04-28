<html>
	<head>
		<link rel="stylesheet" href="css/global.css" />
		<link rel="stylesheet" href="css/error.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="js/jsutils.js"></script>
		<script src="js/error.js"></script>
		<title>Server Error Log</title>
	</head>
			<h1>Server Error Log</h1>
			<h3>Latest on top (auto-updates every second)</h3>
	<body>
		<?php
			$myfile = fopen("/var/log/apache2/error.log", "r") or die("Unable to open file! Did you chmod 777 /var/log/apache2/error.log?");
			$contents = fread($myfile,filesize("/var/log/apache2/error.log"));
			fclose($myfile);
			
			$contents = str_replace("[:error]", "", $contents);
			//$contents = str_replace("]", "]<br />", $contents);
			$contents = str_replace("[", "<br />[", $contents);
			$newContents = $contents . "";
			
			foreach(explode("<br />", $contents) as $line){
				if (strpos($line, "pid") !== FALSE){
					$newContents = str_replace($line, "", $newContents);
				}
			}
			
			$newArray = array();
			$newString = "";
			
			foreach(explode("<br />", $newContents) as $check){
				if (strpos($check, " 2016]") !== FALSE){
					$newString .= "</div>";
					$newString = str_replace("[", "", $newString);
					$newString = str_replace("]", "", $newString);
					$check = explode(".", $check)[0];
					if (strlen($newString) > 0){
						array_push($newArray, $newString . "");
						array_push($newArray, "<br />");
					}
					$newString = "<div class='all'><div class='date'>" . $check . "</div>";
				} else {
					$newString .= "<div class='content'>" . $check . "</div>";
				}
			}
			
			foreach(array_reverse($newArray) as $element){
				echo($element);
			}
		?>
	</body>
</html>