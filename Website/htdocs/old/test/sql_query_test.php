<?php
include 'connect.php';

	$locid = $_GET['locid'];
	//built sql query
	$sql = 'SELECT wspeed, wdir FROM realtime_data_loc_'.$locid.' ORDER BY timestamp DESC LIMIT 1';
	echo '<p>sql:'.$sql.'</p>';
	
	
		echo "event: winddata\n";
	//read winddata from table
		$result = mysql_query($sql);
		echo '<p>result:'.$result.'</p>';
		$data = @mysql_fetch_assoc($result);
		echo '<p>data:'.$data.'</p>';
		$wspeed = $data['wspeed'];
		echo '<p>wspeed:'.$wspeed.'</p>';
	//generate timestamp	
		$curTime = date('H:i:s');
	//build json object	
		echo 'data: {"wspeed": "' . $wspeed . '", "server_time": "' . $curTime . '"}';
		echo "\n\n";	
?>