<?php
include 'connect.php';
include_once 'GCM.php';

	$sql_locations ="SELECT id, loc_name FROM locations WHERE 1";
	$result_locations = mysql_query($sql_locations);
	
	while ($row_locations = @mysql_fetch_row($result_locations)) {
		//get current wspeed
		$sql_realtime_data= "SELECT windspeed FROM average_data_loc_$row_locations[0] ORDER BY timestamp DESC LIMIT 1";
		$result_realtime_data = mysql_query($sql_realtime_data);
		$data = @mysql_fetch_row($result_realtime_data);
		$current_wspeed = $data[0];
		$loc_wspeed[$row_locations[0]] = $current_wspeed;
		$current_time = date('Y-m-d H:i:s');
		//alle locations durchiterieren
		$sql_fav_spots = "SELECT user_id FROM fav_spots WHERE loc_id=$row_locations[0] AND active=1 AND wspeed<=$current_wspeed AND alarm<='$current_time'";
		echo "<p>$sql_fav_spots</p>";
		$result_fav_spots = mysql_query($sql_fav_spots);
		
		while ($row_fav_spots = @mysql_fetch_row($result_fav_spots)) {
			echo "<p>loc_id=$row_locations[0] : user_id=$row_fav_spots[0]</p>";
			
			//get regIDs
			$sql_gcm_users ="SELECT gcm_regid FROM gcm_users WHERE id=$row_fav_spots[0]";
			$result_gcm_users = mysql_query($sql_gcm_users);
			
			while ($row_gcm_users = @mysql_fetch_row($result_gcm_users)) {
				$notify[$row_locations[0].'&'.$row_locations[1]][] = $row_gcm_users[0];
			}
		}
	}
    
	print_r($notify);
	echo '<hr />';
	//send notification per location
	$gcm = new GCM();
	
	foreach ($notify as $key0 => $value0){
		$regIDs = array();
		$loc_data = explode('&', $key0);
		$loc_id = $loc_data[0];
		$loc_name = $loc_data[1];
		$message = "Current windspeed: $loc_wspeed[$loc_id]";
		
		foreach ($value0 as $key1 => $value1){
			$regIDs[] = $value1;			
		}
		
		echo "<p>Location: $loc_name | $message | regIDs: </p>";
		print_r($regIDs);
		
		echo '<hr />';
		
		$data = array("message" => $message, "title" => $loc_name, "loc_id" => $loc_id, "msgcnt" => '1', "soundname" => 'bell.mp3');
 
		$result = $gcm->send_notification($regIDs, $data);
	 
		echo $result;
		
	}
?>