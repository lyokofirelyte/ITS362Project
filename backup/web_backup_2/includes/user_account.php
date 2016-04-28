<?php
<br />
<h3>User Accounts Management Page</h3>

<br />

<div id="account" >

	<div id="currentAccount">
		
		echo "Username:  " . $_SESSION["username"];
		echo["Email:  " . $_SESSION["email"];

	</div>

	<br />

	<div id="currentTwitter">

		if (isset($_SESSION["twitter_account"])){
			echo "Twitter Account:  " . $_SESSION["twitter_account"];
			echo '<br /><input type="button" name="unlink_twitter" id="unlink_twitter" value="Unlink Twitter Account" />';
		}
		else {
			echo '<input type="button" name="link_twitter" id="link_twitter" value="Link Twitter Account" />';
		}

	</div>

	<br />

	<div id="currentYoutube">

		if (isset($_SESSION["youtube_account"])){
			echo "Youtube Account:  " . $_SESSION["youtube_account"];
			echo '<br /><input type="button" name="unlink_youtube" id="unlink_youtube" value="Unlink Youtube Account" />';
		}
		else {
			echo '<input type="button" name="link_youtube" id="link_youtube
			" value="Link Youtube Account" />';
		}

	</div>



</div>