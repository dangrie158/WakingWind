<?php
if(isset($_POST['loc_id'])){
	$loc_id = $_POST['loc_id'];
	
	//include database connection
	include '../connect/connect.php';
	
	//built sql query
	$sql = 'SELECT * FROM realtime_data WHERE loc_id='.$loc_id;

	//read winddata from table
		$result = mysql_query($sql);
		$data = @mysql_fetch_assoc($result);
		$wspeed = $data['windspeed'];
		$wdir = $data['winddir'];

		echo '{"wspeed": '.$wspeed.', "wdir": '.$wdir.'}';	
} else{
	echo 'error';
}		
?>