<?php
if(isset($_SESSION['loggedin']) AND $_SESSION['loggedin'] == true)
{
	if(isset($_GET['loginaction']) AND $_GET['loginaction'] == 'logout')
	{
		session_destroy();
		header("Location: ?site=home");
	}else
	{
?>
		<p>Hello <?php echo $_SESSION['username'] ?> <a href="?site=login&loginaction=logout" class="smalllink">(Logout)</a>
<?php
		include("modules/favspots.php");
	}
}else{
	if(isset($_GET['loginaction']) AND $_GET['loginaction']=='login')
	{
		$loginok = true;
		if($loginok == true){
			$sql = "SELECT
							id,
							uname,
							pw,
							email
						FROM
							users
						WHERE
							email = '".mysql_real_escape_string($_POST['EMail'])."'
						LIMIT 1";
			$result = mysql_query($sql) OR die(mysql_error());
			if(mysql_num_rows($result)) {
				$row = mysql_fetch_assoc($result);
				if($row['email'] == $_POST['EMail'] AND $row['pw'] == md5($_POST['Password']))
				{
					$_SESSION['UID'] = $row['id'];
					$_SESSION['loggedin'] = true;
					$_SESSION['username'] = $row['uname'];
					header("Location: ?site=home");
				}else{
					$loginok = false;
				}
			}else{
			$loginok = false;
			}
		}
		echo $loginok;
		if(!$loginok) header("Location: ?loginfailed=true");
	
	}else
	{
		$cont_loginbox='<h2>Login</h2>
						%loginerrors%
						<div><form method="post" id="loginbox" action="?loginaction=login">
						<input type="text" name="EMail" placeholder="EMail" />
						<input type="password" name="Password" placeholder="Passwort" /> <br />
						<button class="Button" type="submit" name="submit">Login</button>
						</form>
						&bull; <a class="smalllink" href="?site=register">Registrieren</a>';
		if(isset($_GET['loginfailed']) AND $_GET['loginfailed'] == true)
		{
			$cont_loginbox = str_replace ( "%loginerrors%",'<p style="color:red">Login failed</p>' , $cont_loginbox );
		}else{
			$cont_loginbox = str_replace ( "%loginerrors%",'' , $cont_loginbox );
		}
		echo $cont_loginbox;
	}
}
?>