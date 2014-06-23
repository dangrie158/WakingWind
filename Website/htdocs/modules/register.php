<section id="content">
	<article>

<?php
if(isset($_SESSION['loggedin']) AND $_SESSION['loggedin'] == true){
	die('Zugriff Verweigert');
}
if(isset($_GET['regaction']) AND $_GET['regaction'] == 'register'){
	if(!isset($_POST['Username'])) {
		$_SESSION['regerror'] = 'Please fill out all forms'; 
		header("Location: /?site=register");
	}
	if(!isset($_POST['email'])) {
		$_SESSION['regerror'] = 'Please fill out all forms'; 
		header("Location: /?site=register");
	}
	if(!isset($_POST['Password'])) {
		$_SESSION['regerror'] = 'Please fill out all forms'; 
		header("Location: /?site=register");
	}
	if(!($_POST['Password'] == $_POST['rePassword'])) {
		$_SESSION['regerror'] = 'The Passwords don\'t match'; 
		header("Location: /?site=register");
	}
	if(!isset($_SESSION['regerror'])){
	$sql="SELECT email FROM users WHERE email='".mysql_real_escape_string($_POST['email'])."'";
	$result = mysql_query($sql) OR die(mysql_error());
	if(mysql_num_rows($result)) {
			$_SESSION['regerror'] = 'This EMail Adress already is registered'; 
			header("Location: /?site=register");
		}else{
			$sql = "INSERT INTO
				users ( 
				`id` , 
				`uname` , 
				`pw`, 
				`email`) 
			VALUES (
				'', 
				'" . mysql_real_escape_string($_POST['Username']) . "', 
				'" . md5(mysql_real_escape_string($_POST['Password'])) . "', 
				'" . mysql_real_escape_string($_POST['email']) . "')";
			mysql_query($sql) or die( mysql_error());
			$nachricht = "Hello ".$_POST['Username'].",\nto activate your registration on Waking Wind klick on this Link:\nhttp://wwind.mi.hdm-stuttgart.de/?site=register&regaction=activate&aid=".md5(mysql_real_escape_string($_POST['Password']))."\nThis EMail was created automatically";
			$nachricht = wordwrap($nachricht, 70);
			mail($_POST['email'], 'Your Registration on Waking Wind', $nachricht, "From: noreply@waking-wind.de");
?>
									<h2>Success</h2>
									<p>You've successfully registered to Waking Wind. Please login to continue.</p>
<?php
		}
	}
}else{
							$sitecontent = '<h2>Register</h2>
								<p style="color:red">%registererror%</p>
								<form method="post" id="registerform" action="?site=register&regaction=register">
									<table border="0" width="100%">
										<tr><td style="width:25%">Username:</td>
										<td><input type="text" name="Username" class="ui-state-default ui-corner-all ui-widget" /></td></tr>
										<tr><td style="width:25%">Password:</td>
										<td><input type="password" name="Password" class="ui-state-default ui-corner-all ui-widget" /></td></tr>
										<tr><td style="width:25%">Retype Password:</td>
										<td><input type="password" name="rePassword" class="ui-state-default ui-corner-all ui-widget" /></td></tr>
										<tr><td style="width:25%">EMail:</td>
										<td><input type="text" name="email" class="ui-state-default ui-corner-all ui-widget" /></td></tr>
										<tr><td></td>
										<td><button id="submit" class="Button" type="submit" name="submit">Register</td></tr>
									</table>
								</form>';

	if(isset($_SESSION['regerror']))
	{
		$sitecontent = str_replace ( "%registererror%" ,'<p class="error">'.$_SESSION['regerror'].'</p>' , $sitecontent );
		unset($_SESSION['regerror']);
	}else{
		$sitecontent = str_replace ( "%registererror%" ,'' , $sitecontent );
	}
	echo $sitecontent;
}
?>
		<script type="text/javascript">
			$( '#submit' ).button();
		</script>
	</article>
	<aside>
		<?php include "modules/sidebar.php" ?>
	</aside>
</section>