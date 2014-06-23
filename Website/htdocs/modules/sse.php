<?php

session_start();
include '../functions/onlinestatus.php';
include '../connect/connect.php';
//location id gesetzt?
if(isset($_GET['locid'])){
$locid = $_GET['locid'];
$loc_online = loc_online($locid);
	if($loc_online){
?>
		<!DOCTYPE html>
		<html lang="de">
		<head> 
		  <base target="_parent" />	
		  <meta charset="utf-8" />
		  <title>Waking Wind</title>
		  <link rel="stylesheet" href="../css/plugin_container.css" type="text/css" />
		  <link rel="stylesheet" href="../css/main.css" type="text/css" />
		  <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
          <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
		  <script type="text/javascript" src="../maps/map.js"></script>
		  <script>
		//initialize eventsource  
		var evtSource; 
		var threshold = 0;
		var notified = false;
		
function startup() {	
		if(typeof(EventSource)!=="undefined"){
				// Yes! Server-sent events support.
				var client_time = document.getElementById("client_time");
				var wspeed = document.getElementById("wspeed");
				var wdir = document.getElementById("wdir");
				
				evtSource = new EventSource("getwinddata.php?locid=<?php echo $locid; ?>");
				
				// Start listening on the event source
			  
				evtSource.addEventListener("winddata", function(e) {
					//get json object
					var obj = JSON.parse(e.data);
					//loc online?
					
					//windspeed
					wspeed.innerHTML = obj.wspeed;
					//wind direction
					wdir.innerHTML = '<img src=\"..\/images\/wdir\/' + obj.wdir + '.png\" style=\"height: 60px;\" \/>';
					//client time
					var date = new Date();
					var time = (date.getHours() < 10 ? '0' : '') + date.getHours() + ":" + (date.getMinutes() < 10 ? '0' : '') + date.getMinutes() + ":" + (date.getSeconds() < 10 ? '0' : '') + date.getSeconds();
					client_time.innerHTML = time;
				
					if(threshold != 0 && threshold <= obj.wspeed && !notified){
						notified = true;
						//user benachrichtigung
						playSound('bell', 'loop', 'true');
						
						function userAlert () { 
							if(navigator.vibrate) {
								navigator.vibrate(1000);
							}
															
								alert('Aktuelle Windgeschwindigkeit beträgt ' + obj.wspeed + ' Knoten!');
								stopSound();
								threshold = 0;
								document.getElementById('threshold').value = 0;
						}
						
						window.setTimeout(userAlert, 1000);
					}	
				}, false);
				
				//call check state function
				checkEventState();
			}else{
				// Sorry! No server-sent events support..
				//todo: ajax fallback
				//alert('ajax fallback');
				var client_time = document.getElementById("client_time");
				var wspeed = document.getElementById("wspeed");
				var wdir = document.getElementById("wdir");
				
				function ajax_fallback(){
					$.post(  
						'http://wwind.mi.hdm-stuttgart.de/modules/getwinddata_ajax.php',  
						{'loc_id': <?php echo $locid; ?>},  
						function(response, status, xhr){  
							if (status == "error") {
								alert('ajax error');
							}
							else {
								if(response == 'error'){
									alert('php script error');
								}
								else{
									//windspeed
									wspeed.innerHTML = response.wspeed;
									//wind direction
									wdir.innerHTML = '<img src=\"..\/images\/wdir\/' + response.wdir + '.png\" style=\"height: 60px;\" \/>';
									//client time
									var date = new Date();
									var time = (date.getHours() < 10 ? '0' : '') + date.getHours() + ":" + (date.getMinutes() < 10 ? '0' : '') + date.getMinutes() + ":" + (date.getSeconds() < 10 ? '0' : '') + date.getSeconds();
									client_time.innerHTML = time;
									var ready_state = document.getElementById("ready_state");
									ready_state.innerHTML = '<img src=\"..\/images\/open.png\" style=\"height: 30px;\" \/>';
									//todo: user alarm
									if(threshold != 0 && threshold <= response.wspeed && !notified){
										notified = true;
										//user benachrichtigung
										playSound('bell', 'loop', 'true');
										
										function userAlert () { 
											if(navigator.vibrate) {
												navigator.vibrate(1000);
											}
																			
												alert('Aktuelle Windgeschwindigkeit beträgt ' + response.wspeed + ' Knoten!');
												stopSound();
												threshold = 0;
												document.getElementById('threshold').value = 0;
										}
										
										window.setTimeout(userAlert, 1000);
									}
								}
							}
						},  
						"json"  
					);
				}
				int_ajax_fallback = self.setInterval(ajax_fallback, 5000);
				ajax_fallback();
			  } 
				
}
			
			function checkEventState(){
				var ready_state = document.getElementById("ready_state");
				switch (evtSource.readyState) {
					case EventSource.CONNECTING:
						ready_state.innerHTML = '<img src=\"..\/images\/connecting.gif\" style=\"height: 30px;\" \/>';
						//clearInterval(int_reconnect);
						break;
					case EventSource.OPEN:
						ready_state.innerHTML = '<img src=\"..\/images\/open.png\" style=\"height: 30px;\" \/>';
						break;
					case EventSource.CLOSED:
						ready_state.innerHTML = '<img src=\"..\/images\/closed.png\" style=\"height: 30px;\" \/>';
						//try to connect again
						reconnect();
						break;
					default:
						// this never happens
						break;
				}
			}
			var int_checkEventState = self.setInterval(checkEventState, 5000);
			
			function reconnect(){
				evtSource = new EventSource("getwinddata.php?locid=<?php echo $locid; ?>");
				startup();
			}
			//var int_reconnect = self.setInterval(reconnect, 10000);	
			
			//play sound
			function playSound(filename, loop1, loop2){   
						document.getElementById("sound").innerHTML='<audio ' + loop1 + ' autoplay="autoplay"><source src="../sounds/' + filename + '.mp3" type="audio/mpeg" /><source src="../sounds/' + filename + '.ogg" type="audio/ogg" /><embed hidden="true" autostart="true" loop="' + loop2 + '" src="../sounds/' + filename +'.mp3" /></audio>';
					}
			//stop sound
			function stopSound(){   
						document.getElementById("sound").innerHTML='';
					}
					
			//set threshold
			function setThreshold(){
				threshold = Number(document.getElementById('threshold').value);
				if(threshold != 0){
					notified = false;
					reconnect();
				}	
			}
			//stop
			function eventStop(){
				evtSource.close();
			}
		  </script>
		</head>
		<body onload="startup()">
		<?php
		include '../connect/connect.php';
		$sql = "SELECT loc_name, loc_address, meta_data, loc_lat, loc_long FROM locations WHERE id='$locid'";
		$result = mysql_query($sql);
		$row = @mysql_fetch_row($result);
		$locname = $row[0];
		$geoloc = array($row[3], $row[4]);
		?>
			<input class="extra_functions" type="button" value="Show on Map" onclick="geolocMap(this, <?php echo "'$locname', $geoloc[0], $geoloc[1]"; ?>)">
			<div id="plugin_container" style="position: relative;">
			<div class="plugin_container"  id="plugin_container_content" style="width:100%; height:310px; position: absolute;">
			<h2 id="location"><?php echo $row['0'].', '.$row['1']; ?></h2>
            <?php
				if( isset($_SESSION['UID']) )
				{
					$favstar = '';
					$sql = "SELECT * FROM fav_spots WHERE user_id='". $_SESSION['UID'] ."' AND loc_id='". $locid ."'";
					$result = mysql_query($sql);
					if(mysql_num_rows($result))
					{
						$favstar = '../images/star_active.png';
					}else{
						$favstar = '../images/star_inactive.png';
					}
			?>
            	<script>
				$( document ).ready(function(e) {
					$( '#favstar' ).click( function(){
						if( $( '#favstar' ).attr( 'src' ) == '../images/star_inactive.png' )
						{
							window.parent.addSpot( <?php echo $locid ?> );
							$( '#favstar' ).attr( 'src', '../images/star_active.png' );
						}else
						{
							window.parent.removeSpot( <?php echo $locid ?> );
							$( '#favstar' ).attr( 'src', '../images/star_inactive.png' );
						}
					});                   
                });
				</script>
            	<img id="favstar" src="<?php echo $favstar ?>" alt="set as Favorite Spot" />
            <?php
				}
			?>
            
			<p>Wind speed: <span id="wspeed"></span> kn</p>
			<p>Wind direction: <span id="wdir"></span></p>
			<p>
				<select id="threshold" onchange="setThreshold()">
					<option value="0">Set Alarm</option>
					<option value="1">1 kn</option>
					<option value="4">4 kn</option>
					<option value="7">7 kn</option>
					<option value="11">11 kn</option>
					<option value="16">16 kn</option>
					<option value="22">22 kn</option>
					<option value="28">28 kn</option>
				</select>	
			</p>
			<p id="state"><span id="ready_state"></span> last updatet at: <span id="client_time"></span></p>
			<p id="export"><a class="smalllink" href="http://wwind.mi.hdm-stuttgart.de/index.php?site=export&locid=<?php echo $locid; ?>">Export this widget</a></p>
            <p id="statistics"><a class="smalllink" href="http://wwind.mi.hdm-stuttgart.de?site=statistics&locid=<?php echo $locid; ?>">Show statistics for this location</a></p>
			</div>
			<div id="map_canvas" style="width:100%; height:310px; display: none; position: absolute;"></div>
			</div>
			
			<div id="sound"></div>
		</body>
		</html>
<?php
	}
	else{
		echo 'offline';
	}
}
else{
echo 'Error: No location-id set!';
}
?>