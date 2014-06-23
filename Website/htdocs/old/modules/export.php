	  <section id="content">
			<article>
<?php
//location id gesetzt?
if(isset($_GET['locid'])){
$locid = $_GET['locid'];
$sql = "SELECT loc_name, loc_address, meta_data FROM locations WHERE id='$locid'";
$result = mysql_query($sql);
$row = @mysql_fetch_row($result);
?>			
			  <h2>Export widget for location: <?php echo $row['0'].', '.$row['1']; ?></h2>
			  <p>
				Simply add this code to your website:
			  </p>
			  <textarea rows="4" cols="50"><iframe src="http://wwind.mi.hdm-stuttgart.de/modules/sse.php?locid=<?php echo $locid; ?>" scrolling="no" width="100%" height="250px" style="border: none;"></iframe></textarea> 
			  <p>	
				<a href="index.php">Search for more locations.</a>
			  </p>
<?php
}
else{
?>
			  <h2>[ERROR]: No location-id set!</h2>
			  <p>
				<a href="index.php">Search for available locations.</a>
			  </p>
<?php
}
?>
			</article>
		  </section>
		  <aside>
			<?php include "modules/loginbox.php" ?>
		  </aside>