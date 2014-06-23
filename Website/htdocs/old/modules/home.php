	<script>
		function loadPluginContainer(locid){
			if(locid != 'default_option'){
				document.getElementById('plugin_container').innerHTML = '<iframe src=\"modules/sse.php?locid=' + locid + '\" scrolling=\"auto\" width=\"100%\" height=\"350px\" style=\"border: none;\"><\/iframe>';
			}
		}
	</script>

		  <section id="content">
			<article>
			  <h2 style="float: left;">Available locations:</h2>
			  <div id="search">
<?php
$sql = 'SELECT id, loc_name, loc_address FROM locations ORDER BY loc_name';
?>			  
				<select id="locations" onchange="loadPluginContainer(this.value)">
					<option value="default_option">Select location</option>
<?php
			
			include 'functions/onlinestatus.php';
			$result = mysql_query($sql);
			while ($row = @mysql_fetch_row($result)) {
				$loc_online = loc_online($row[0]);
				if($loc_online){
					$option_style='style="background-color:#CCFFCC"';
				}
				else{
					$option_style='style="background-color:#FFCCCC"';
				}
		?>		
					<option <?php echo $option_style; ?> value="<?php echo $row[0]; ?>"><?php echo $row[1].', '.$row[2]; ?></option>
		<?php
			}
		?>						
				</select>
			  </div>
			  <div id="plugin_container"></div>
			</article>
		  </section>
		  <aside>
			<?php include "modules/loginbox.php" ?>
		  </aside>