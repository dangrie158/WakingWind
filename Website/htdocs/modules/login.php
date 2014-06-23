<?php
session_start();
include '../connect/connect.php';
if(isset($_SESSION['loggedin']) AND $_SESSION['loggedin'] == true)
{
	if(isset($_GET['loginaction']) AND $_GET['loginaction'] == 'logout')
	{
		session_destroy();
		header("Location: /");
	}
?>
<?php
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
					header("Location: /");
				}else{
					$loginok = false;
				}
			}else{
			$loginok = false;
			}
		}
		header("Location: /");
	}
}
header("Location: /")
?>