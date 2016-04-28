<?php
	$target_dir = "uploads/";
	$n = isset($_FILES["file"]) ? "file" : "header_file";
	$target_file = $target_dir . basename($_FILES[$n]["name"]);
	
	if (move_uploaded_file($_FILES[$n]["tmp_name"], $target_file)) {
		?>
       		<script type='text/javascript'>
	       		$(".header").animate({
	       			height: "100%"
	       		}, 400);
       			window.setTimeout(function(){
           			<?php if (isset($_POST["header_file_submit"])){ ?>
           				$(".header").css({
               				<?php 
               					echo("background: \"url('" . $target_file . "')\",");
               				?>
           					backgroundSize: "cover",
           					backgroundRepeat: "no-repeat",
           				 	backgroundPosition: "center center"
           				});	
               		<?php
               			$_SESSION["header"] = $target_file;
           				} else {
           			?>
	               			$("body").css({
	                   			<?php 
	                   				echo("background: \"url('" . $target_file . "')\",");
	                   			?>
	               				backgroundSize: "cover",
	               				backgroundRepeat: "no-repeat",
	               				 backgroundPosition: "center center"
	               			});
               		<?php 
                        $_SESSION["bg"] = $target_file; 
                        $sql1 = "select path from background where email = '" . $_SESSION["email"] . "'";
                        $r = mysqli_query($dbc, $sql1);
                        $rows = mysqli_num_rows($r);
		
            			if ($rows == 0) {
                            $sql2 = "insert into background (email, path) values ('" . $_SESSION["email"] . "', '" . $target_file . "');";
                        } else {
                            $sql2 = "update background set path = '" . $target_file . "' where email = '" . $_SESSION["email"] . "';";
                        }
            
                        $r = mysqli_query($dbc, $sql2);
                    } ?>
       				$(".header").animate({
       					height: "60px"
       				}, 400);
       				window.setTimeout(function(){
       					$(".sidebar").css({display:"block"});
       					$("#loading_icon").css({display:"none"});
       				}, 400);
       			}, 500);
       		</script>
       <?php
    } else {
        echo("<script type='text/javascript'>alert('Failed!');</script>");
    } 
?>