<?php
	header("Content-Type: text/event-stream\n\n");
	header('Cache-Control: no-cache');
	
	$locid = $_GET['locid'];
	
	//include database connection
	include 'connect/connect.php';
	//built sql query
	$sql = 'SELECT wspeed, wdir FROM realtime_data_loc_'.$locid.' ORDER BY timestamp DESC LIMIT 1';
	
	//update every minute
	while(1){
		echo "event: winddata\n";
	//read winddata from table
		$result = mysql_query($sql);
		$data = @mysql_fetch_assoc($result);
		$wspeed = $data['wspeed'];
	//generate timestamp	
		$curTime = date('H:i:s');
	//build json object	
		echo 'data: {"wspeed": "' . $wspeed . '", "server_time": "' . $curTime . '"}';
		echo "\n\n";
	   
		ob_flush();
		flush();
	
		sleep(60);
	}		
?>