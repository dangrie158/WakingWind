<?php
function loc_online ($locid){
	//include database connection
	include '../connect/connect.php';
	
	//built sql query
	$sql = 'SELECT timestamp FROM realtime_data WHERE loc_id='.$locid;

	$result = mysql_query($sql);
	$data = @mysql_fetch_row($result);
	$tmstmp = $data[0];
		
	$curTime = date('H:i:s');
	
	$timestamp = explode(' ', $tmstmp);
	$timestamp = explode(':', $timestamp[1]);
	
	$unixtmstmp = mktime($timestamp[0], $timestamp[1], $timestamp[2]);
	$unixcurTime = time();
	
	$dif = $unixcurTime - $unixtmstmp;
	
	if($dif < 5*60)
		return true;
	else
		return false;
}	
?>		