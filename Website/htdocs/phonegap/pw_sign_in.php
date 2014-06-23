<?php
if(isset($_POST['email']) && isset($_POST['pwd']) && isset($_POST['regID'])){
	include '../connect/connect.php';
	$email = $_POST['email'];
	$pwd_form = $_POST['pwd'];
	$regID = $_POST['regID'];
	
	$sql = "SELECT id, uname, pw FROM users WHERE email='".$email."';";
	$result = mysql_query($sql);
	$row = @mysql_fetch_row($result);
	$user_id = $row[0];
	$user_name = $row[1];
	$pwd_db = $row[2];
	$is_active = $row[3];
	
	if(mysql_num_rows($result)==1){
		if(md5($pwd_form)==$pwd_db){
			$sql = "INSERT INTO gcm_users VALUES ($user_id, '".$regID."');";
			mysql_query($sql);
			echo $user_id.'.'.$user_name;
		}
		else{
			echo 'error';
		}
	}
	else{
		echo 'error';
	}
}
else{
	echo 'error';
}
?>