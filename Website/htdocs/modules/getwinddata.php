<?php
	header("Content-Type: text/event-stream\n\n");
	header('Cache-Control: no-cache');
	
	$locid = $_GET['locid'];
	$update_frequenz = 1;
	$prev = 500;
	
	//include database connection
	include '../connect/connect.php';
	
	//built sql query
	$sql = 'SELECT * FROM realtime_data WHERE loc_id='.$locid;
	
	//update every minute
	while(1){
	//read winddata from table
		$result = mysql_query($sql);
		$data = @mysql_fetch_assoc($result);
		$wspeed = $data['windspeed'];
		$wdir = $data['winddir'];
	//generate timestamp	
		$curTime = date('H:i:s');
		if($prev != $wspeed){
			$prev = $wspeed;
			echo "event: winddata\n";
	//build json object	
			echo 'data: {"wspeed": "' . $wspeed . '", "wdir": "' . $wdir . '"}';
			echo "\n\n";
		   
			ob_flush();
			flush();
		}
		sleep($update_frequenz);
	}		
?>