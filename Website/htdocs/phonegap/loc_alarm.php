<?php
if(isset($_POST['loc_id']) && isset($_POST['user_id']) && isset($_POST['alarm']) && isset($_POST['wspeed'])){
	include '../connect/connect.php';
	$loc_id = $_POST['loc_id'];
	$user_id = $_POST['user_id'];
	$alarm = $_POST['alarm'];
	$wspeed = $_POST['wspeed'];
	$active = $_POST['active'];
	
	
	if (time() >= strtotime($alarm)){
		$date = date('Y-m-d', strtotime(' + 1 days'));
	} else{
		$date = date('Y-m-d');
	}
	$timestamp = $date.' '.$alarm;
	
	$sql = "INSERT INTO fav_spots VALUES($loc_id, $user_id, '$timestamp', $wspeed, 1)ON DUPLICATE KEY UPDATE alarm='$timestamp', wspeed=$wspeed, active=1;";
	mysql_query($sql) OR die('error');
		
	echo 'insert success';
		
}
elseif(isset($_POST['loc_id']) && isset($_POST['user_id']) && $_POST['inactive']){
	//set alarm inactive
	include '../connect/connect.php';
	$loc_id = $_POST['loc_id'];
	$user_id = $_POST['user_id'];
	
	$sql = "UPDATE fav_spots SET active=0 WHERE user_id=$user_id AND loc_id=$loc_id;";
	mysql_query($sql) OR die('error');
	
	echo 'inactive';
} 
else{
	echo 'error';
}
?>