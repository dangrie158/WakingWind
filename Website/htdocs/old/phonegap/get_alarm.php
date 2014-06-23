<?php
if(isset($_POST['loc_id']) && isset($_POST['user_id'])){
	include '../connect/connect.php';
	$loc_id = $_POST['loc_id'];
	$user_id = $_POST['user_id'];
	
	$sql = "SELECT alarm, wspeed FROM fav_spots WHERE loc_id=$loc_id AND user_id=$user_id AND active=1";
	$result = mysql_query($sql);
	
	if(mysql_num_rows($result)==1){
		$row = @mysql_fetch_row($result);
		$datetime = explode(' ', $row[0]);
		$time = $datetime[1];
		$time = explode(':', $time);
		$wspeed = $row[1];
		
		echo "$wspeed&$time[0]&$time[1]";
	}
	else{
		echo 'inactive';
	}
}
else{
	echo 'error';
}
?>