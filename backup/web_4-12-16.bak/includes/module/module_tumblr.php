<div class='tumblr_post' style='border: none'>
	<p>Test Header</p>
</div>
<br />
<?php
	for ($i = 0; $i < 5; $i++){
		echo(
			"<div class='tumblr_post'>" .
				"<p>Test Post " . $i . "</p>" .
			"</div>"
		);
	}
?>