<?php
include '../connect/connect.php';
$sql = 'SELECT meta_data, id, loc_name, loc_address FROM locations ORDER BY loc_name';
?>
	<?php
			$result = mysql_query($sql);
			while ($row = @mysql_fetch_row($result)) {
		?>		
			<li data-filtertext="<?php echo $row[0].' '.$row[2].' '.$row[3]; ?>"><a href="http://wwind.mi.hdm-stuttgart.de/modules/sse.php?locid=<?php echo $row[1]; ?>"><?php echo $row[2].', '.$row[3]; ?></a></li>
		<?php
			}
		?>