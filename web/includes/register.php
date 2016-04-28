<link rel="stylesheet" href="css/login.css" />
<?php
    if (isset($_POST['registerSubmited'])){
        $username = $_POST['register_username'];
        $email = $_POST['register_email'];
        $pass1 = $_POST['register_password1'];
        $pass2 = $_POST['register_password2'];
        $_SESSION["email"] = $email;

        if ($pass1 == $pass2){
            //after posting to itself make sure that the account is available
            $sql1 = "Select email from users where email = '$email'";
            //if available create it
            $r = mysqli_query($dbc, $sql1);
            $rows = mysqli_num_rows($r);
            if ($rows == 0){
                $sql2 = "insert into users (email, username, password) values ('$email', '$username', '" . get_password_hash($pass1) . "')";
                $r = mysqli_query($dbc, $sql2);
                //echo mysqli_affected_rows($dbc);
                if (mysqli_affected_rows($dbc) == 1){
                    ?>
                    	<script type='text/javascript'>
	                        post('index.php', {
	                            update_views: [
	                                "login"
	                            ],
                            	logged_in: 2
	                        }, function(data){
	                       	 	window.setTimeout(function(){
	                       	 		restorePage(data);
	                       	 	}, 500);
	                        });
                    	</script>
                    <?php 
                    exit();
                }
            } else {
                echo '<h3>Failed to create account. There is already an account linked to that email address.</h3><br />';
            }
        } else {
            echo "<h3>Passwords do not match, please try again.</h3> <br />";
        }
    }
?>
<div class="info_panel_register">
	<p>Register for Omnideck. We don't validate anything so feel free to spam us.</p>
</div>
<div class="register_form">
    <input type="text" name="username" id="register_username" placeholder="Username" />
    <br />
    <input type="text" name="email" id="register_email" placeholder="Email" />
    <br />
    <input type="password" name="password1" id="register_password1" placeholder="Password" />
    <br />
    <input type="password" name="password2" id="register_password2" placeholder="Confirm Password" />
    <br />
    <i class="fa fa-sign-in" aria-hidden="true" id="regSubmit"></i>
</div>