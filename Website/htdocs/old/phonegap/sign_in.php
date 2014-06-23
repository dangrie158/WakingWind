<?php
if(isset($_GET['regID'])){
	include '../connect/connect.php';
	$regID = $_GET['regID'];
	
	$sql = "SELECT id FROM gcm_users WHERE gcm_regid='".$regID."';";
	$result = mysql_query($sql);
	$row = @mysql_fetch_row($result);
	$user_id = $row[0];
	
	if(mysql_num_rows($result)==1){
		$sql = 'SELECT uname FROM users WHERE id='.$user_id;
		$result = mysql_query($sql);
		$row = @mysql_fetch_row($result);
		$user_name = $row[0];
		
			if(mysql_num_rows($result)==1){
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