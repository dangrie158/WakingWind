<?php
if(isset($_POST['regID'])){
	include '../connect/connect.php';
	$regID = $_POST['regID'];
	
	$sql = "DELETE FROM gcm_users WHERE gcm_regid='".$regID."';";
	$result = mysql_query($sql)OR die('error');
	$deleted_rows = mysql_affected_rows();
	
	if($deleted_rows != 1){
		echo 'error';
	}
	else{
		echo 'success';
	}
}
else{
	echo 'error';
}
?>