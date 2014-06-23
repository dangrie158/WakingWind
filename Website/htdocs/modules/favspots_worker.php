<?php
session_start();
include "../connect/connect.php";
if( isset($_GET['action']) && $_GET['action'] == 'list' )
{
	$sql = "SELECT fav_spots.user_id, fav_spots.loc_id, DATE_FORMAT( fav_spots.alarm , '%H:%i' ) AS DEDate, fav_spots.wspeed, fav_spots.active, locations.loc_name, locations.loc_address FROM fav_spots, locations WHERE fav_spots.user_id='". $_SESSION['UID']."' AND fav_spots.loc_id = locations.id";
	$result = mysql_query( $sql ) OR die(mysql_error());
	$i = 0;
	echo '[';
	?>
	<?php
	while( $row = mysql_fetch_assoc( $result ) )
	{
		if( $i++ != 0 )
		{
			echo',';
		}
	?>
		{"loc_id":"<?php echo $row['loc_id'] ?>", "loc_name": "<?php echo $row['loc_name'] ?>", "loc_address": "<?php echo $row['loc_address'] ?>", "alarm": "<?php echo $row['DEDate'] ?>", "wspeed": "<?php echo $row['wspeed'] ?>", "active": "<?php echo $row['active'] ?>"}
	<?php
	}
	echo ']';
}
else if( isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['locid']) ) 
{
	$sql = "DELETE FROM fav_spots WHERE loc_id='". mysql_real_escape_string( $_GET['locid'] ) ."' AND user_id='". $_SESSION['UID'] ."' LIMIT 1";
	$result = mysql_query( $sql ) OR die(mysql_error());
}
else if( isset($_GET['action']) && $_GET['action'] == 'insert' && isset($_GET['locid']) ) 
{
	$sql = "INSERT INTO fav_spots (user_id, loc_id) VALUES ( '". $_SESSION['UID'] ."', '". mysql_real_escape_string( $_GET['locid'] ) ."' )";
	$result = mysql_query( $sql ) OR die(mysql_error());
	
	$sql = "SELECT fav_spots.user_id, fav_spots.loc_id, DATE_FORMAT( fav_spots.alarm , '%H:%i' ) AS DEDate, fav_spots.wspeed, fav_spots.active, locations.loc_name, locations.loc_address FROM fav_spots, locations WHERE fav_spots.user_id='". $_SESSION['UID']."' AND fav_spots.loc_id = locations.id AND fav_spots.loc_id = '". mysql_real_escape_string( $_GET['locid'] ) ."'";
	$result = mysql_query( $sql ) OR die(mysql_error());
	$row = mysql_fetch_assoc( $result )
?>
		{"loc_id":"<?php echo $row['loc_id'] ?>", "loc_name": "<?php echo $row['loc_name'] ?>", "loc_address": "<?php echo $row['loc_address'] ?>", "alarm": "<?php echo $row['DEDate'] ?>", "wspeed": "<?php echo $row['wspeed'] ?>", "active": "<?php echo $row['active'] ?>"}
<?php
}else if( isset($_GET['action']) && $_GET['action'] == 'get' && isset($_GET['locid']) ) 
{	
	$sql = "SELECT fav_spots.user_id, fav_spots.loc_id, DATE_FORMAT( fav_spots.alarm , '%H:%i' ) AS DEDate, fav_spots.wspeed, fav_spots.active, locations.loc_name, locations.loc_address FROM fav_spots, locations WHERE fav_spots.user_id='". $_SESSION['UID']."' AND fav_spots.loc_id = locations.id AND fav_spots.loc_id = '". mysql_real_escape_string( $_GET['locid'] ) ."'";
	$result = mysql_query( $sql ) OR die(mysql_error());
	$row = mysql_fetch_assoc( $result )
?>
		{"loc_id":"<?php echo $row['loc_id'] ?>", "loc_name": "<?php echo $row['loc_name'] ?>", "loc_address": "<?php echo $row['loc_address'] ?>", "alarm": "<?php echo $row['DEDate'] ?>", "wspeed": "<?php echo $row['wspeed'] ?>", "active": "<?php echo $row['active'] ?>"}
<?php
}else if( isset($_GET['action']) && $_GET['action'] == 'activate' && isset($_GET['locid']) ) 
{
	$sql = "UPDATE fav_spots SET  active =  '1' WHERE  loc_id = '". mysql_real_escape_string( $_GET['locid'] ) ."' AND  user_id = '". $_SESSION['UID'] ."';";
	$result = mysql_query( $sql ) OR die(mysql_error());
}else if( isset($_GET['action']) && $_GET['action'] == 'deactivate' && isset($_GET['locid']) ) 
{
	$sql = "UPDATE fav_spots SET  active =  '0' WHERE  loc_id = '". mysql_real_escape_string( $_GET['locid'] ) ."' AND  user_id = '". $_SESSION['UID'] ."';";
	$result = mysql_query( $sql ) OR die(mysql_error());
}else if( isset($_GET['action']) && $_GET['action'] == 'isActive' && isset($_GET['locid']) ) 
{
	$sql = "SELECT active FROM fav_spots WHERE  loc_id = '". mysql_real_escape_string( $_GET['locid'] ) ."' AND  user_id = '". $_SESSION['UID'] ."' AND active = '1';";
	$result = mysql_query( $sql ) OR die(mysql_error());
	if( mysql_num_rows( $result ) )
		echo true;
}else if( isset($_GET['action']) && $_GET['action'] == 'setAlarm' && isset($_GET['locid']) && isset($_GET['hour']) && isset($_GET['minute']) && isset($_GET['windspeed']) ) 
{
	$curdate = getdate();
	if( $_GET['hour'] < $curdate['hours'] OR ( $_GET['minute'] <= $curdate['minutes'] AND $_GET['hour'] == $curdate['hours'] ) )
		$date = mktime( $_GET['hour'], $_GET['minute'], $curdate['seconds'], $curdate['mon'], $curdate['mday']+1 );
	else
		$date = mktime( $_GET['hour'], $_GET['minute'] );
	$sql = "UPDATE fav_spots SET wspeed = '". mysql_real_escape_string( $_GET['windspeed'] ) ."', alarm = FROM_UNIXTIME( ". $date ." ), active = '1' WHERE  loc_id = '". mysql_real_escape_string( $_GET['locid'] ) ."' AND  user_id = '". $_SESSION['UID'] ."';";
	$result = mysql_query( $sql ) OR die(mysql_error());
}
?>