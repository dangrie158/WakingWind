<?php
include 'connect/connect.php';

$i = 0;
$wspeed = array(1, 2, 3, 4, 5, 6, 7, 0);
$wdir = array(2, 4, 6, 8, 10, 12, 14, 0);

while($i <= 7){
	$sql = "UPDATE realtime_data SET timestamp=CURRENT_TIMESTAMP, windspeed=".$wspeed[$i].", winddir=".$wdir[$i++]." WHERE loc_id=5;";
	mysql_query($sql);
	echo $sql;
	echo '<br>';
	sleep(5);
}
?>