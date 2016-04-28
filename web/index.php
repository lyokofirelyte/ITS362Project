<html>
	<head>
		<?php 
			session_start();
			require "includes/dir_config.php";
			include(fromIncludes("lib.php"));
			include(fromIncludes("index_helper.php"));
			include(fromModule("module_tumblr.php"));
		?>
		<script type="text/javascript">
			var twitter_linked = <?php if (isset($_SESSION["twitter_linked"])){ echo $_SESSION["twitter_linked"];} else {echo 0;}  ?>;
		</script>
		<script src="js/module_main.js"></script>
		<script src="js/jsutils.js"></script>
	</head>
	<?php 
		echo("<body style=\"background: url('" . $_SESSION["bg"] . "'); background-size: cover; background-repeat: no-repeat; background-position: center center;\">");
		include(fromIncludes("header.php"));
	?>
        <div class="all_noscroll">
            <div class="all">
                <?php 
                    foreach ($views as $view){
                        include(fromIncludes($view . ".php"));
                    }
                ?>
            </div>
        </div>
        <?php 
	      	  include(fromIncludes("sidebar.php"));
	      	  if (isset($_POST["file_bg"]) || isset($_POST["header_file_submit"])){
				  include(fromIncludes("files.php"));
	      	  }
	      	  echo("<script type='text/javascript'>pageDone();</script>");
        ?>
	</body>
</html>