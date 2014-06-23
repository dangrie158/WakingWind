<?php
function loc_online ($locid){
	//built sql query
	$sql = "SELECT timestamp FROM realtime_data WHERE timestamp > (DATE_SUB(NOW(), INTERVAL 5 MINUTE)) AND loc_id='".$locid."'";
	//$sql="SELECT timestamp FROM realtime_data";
	$result = mysql_query($sql) OR die( mysql_error() );
	if( mysql_num_rows( $result ) )
	{
		$row = mysql_fetch_assoc( $result );
		return $row['timestamp'];
	}
	else
	{
		return '';
	}
}	
?>		