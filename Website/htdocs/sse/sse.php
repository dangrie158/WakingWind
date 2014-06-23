<?php
//location id gesetzt?
if(isset($_GET['locid'])){
$locid = $_GET['locid'];
?>
<!DOCTYPE html>
<html lang="de">
<head> 
  <meta charset="utf-8" />
  <title>Server-sent events example</title>
  <link rel="stylesheet" href="css/plugin_container.css" type="text/css" />
  <script>
//initialize eventsource  
var evtSource = new EventSource("getwinddata.php?locid=<?php echo $locid; ?>"); 
  
    function startup() {
		var client_time = document.getElementById("client_time");
        var server_time = document.getElementById("server_time");
		var wspeed = document.getElementById("wspeed");
        
        // Start listening on the event source
      
		evtSource.addEventListener("winddata", function(e) {
			//get json object
			 var obj = JSON.parse(e.data);
			//windspeed
			wspeed.innerHTML = obj.wspeed;
            //client time
			var date = new Date();
			var time = (date.getHours() < 10 ? '0' : '') + date.getHours() + ":" + (date.getMinutes() < 10 ? '0' : '') + date.getMinutes() + ":" + (date.getSeconds() < 10 ? '0' : '') + date.getSeconds();
	   		client_time.innerHTML = time;
			//server time
            server_time.innerHTML = obj.server_time;
			//nur zu testzwecken
			document.title = obj.server_time;
			//user benachrichtigung
			playSound('bell', '', 'false');
			function userAlert () { 
				if(navigator.vibrate) {
					navigator.vibrate(1000);
				}
				alert(obj.server_time);
			}
			window.setTimeout(userAlert, 500);
        }, false);
		
		//call check state function
		checkEventState();
	}
	
	function checkEventState(){
		var ready_state = document.getElementById("ready_state");
		switch (evtSource.readyState) {
			case EventSource.CONNECTING:
				ready_state.innerHTML = 'connecting';
				//clearInterval(int_reconnect);
				break;
			case EventSource.OPEN:
				ready_state.innerHTML = 'open';
				break;
			case EventSource.CLOSED:
				ready_state.innerHTML = 'closed';
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
                document.getElementById("sound").innerHTML='<audio ' + loop1 + ' autoplay="autoplay"><source src="sounds/' + filename + '.mp3" type="audio/mpeg" /><source src="sounds/' + filename + '.ogg" type="audio/ogg" /><embed hidden="true" autostart="true" loop="' + loop2 + '" src="sounds/' + filename +'.mp3" /></audio>';
			}
  </script>
</head>
<body onload="startup()">
	<div class="plugin_container">
	<p>Windgeschwindigkeit: <span id="wspeed"></span></p>
	<p>Last updated at [Client time: <span id="client_time"></span>] // [Server time: <span id="server_time"></span>]</p>
	<p>Ready state: <span id="ready_state"></span></p>
	</div>
	
	<div id="sound"></div>
</body>
</html>
<?php
}
else{
echo 'Error: No location-id set!';
}
?>