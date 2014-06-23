<?php
	if( isset( $_SESSION['loggedin'] ) AND $_SESSION['loggedin'] == true )
	{
?>
		<p>Hello <?php echo $_SESSION['username'] ?> <a href="/modules/login.php?loginaction=logout" class="smalllink">(Logout)</a>
<?php
		include("modules/favspots.php");
	}else{
?>
<p>Waking Wind is an innovative Webservice for wind sportsmen. 
<a href="?site=register">Sign up now</a> for free to use all the cool features. </p>
<?php
	}
?>