<?php 
	if (isset($_SESSION["user"]["verified"]) && $_SESSION["user"]["verified"] == "yes"){
?>
		<div class="sidebar" id="sidebar">
			<ul class="sidebar_ul">
				<li id="sidebar_button_account">
					<i class="fa fa-check"></i>
				</li>
				<li id="sidebar_button_logout">
					<i class="fa fa-power-off"></i>
				</li>
				<li id="sidebar_button_twitter">
					<i class="fa fa-twitter"></i>
				</li>
				<li id="sidebar_button_youtube">
					<i class="fa fa-youtube-play"></i>
				</li>
				<li id="sidebar_button_tumblr">
					<i class="fa fa-tumblr" aria-hidden="true"></i>
				</li>
				<li id="sidebar_button_background">
					<i class="fa fa-picture-o"></i>
				</li>
				<li id="sidebar_button_header">
					<i class="fa fa-file-image-o" aria-hidden="true"></i>
				</li>
                <li id="sidebar_button_refresh">
                    <i class="fa fa-refresh" aria-hidden="true"></i>
                </li>
			</ul>
			<ul class="sidebar_arrow">
				<li id="sidebar_button_collapse">
					<i id="collapse" class="fa fa-angle-right"></i>
				</li>
			</ul>
		</div>
<?php 
	} else {
?>
		<div class="sidebar" id="sidebar">
			<ul class="sidebar_ul">
				<li id="sidebar_button_login">
					<i class="fa fa-sign-in"></i>
				</li>
				<li id="sidebar_button_register">
					<i class="fa fa-user-plus"></i>
				</li>
				<li id="sidebar_button_collapse">
					<i id="collapse" class="fa fa-angle-right"></i>
				</li>
			</ul>
		</div>
<?php 
	}
?>