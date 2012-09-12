<?php 
	require("../../secret.php");
	require("../twitteroauth/twitteroauth-xml.php");
	session_start();
	include('variables/variables.php'); 
?>

	<div id="header">
		<h2>
			<?php if(!empty($_SESSION['username'])){  
				echo "Hello {$session_username}";
				} else {
					echo "<a href=../twitter_login.php>Sign in</a>";
					}
			?>
		</h2>
	</div>
	<!-- end #header -->