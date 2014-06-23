<?php
include '../connect/connect.php';
$sql = 'SELECT meta_data, id, loc_name, loc_address, loc_lat, loc_long FROM locations ORDER BY loc_name';
?>
	<?php
			$result = mysql_query($sql);
			while ($row = @mysql_fetch_row($result)) {
		?>		
			<li data-filtertext="<?php echo $row[0].' '.$row[2].' '.$row[3]; ?>"><button onclick="goToLocation(this)" value="<?php echo $row[1].'&'.$row[2].', '.$row[3].'&'.$row[4].'&'.$row[5]; ?>"><?php echo $row[2].', '.$row[3]; ?></button></li>
		<?php
			}
		?>