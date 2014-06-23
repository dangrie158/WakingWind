<?php
if($_GET['locname'] && $_GET['lati'] && $_GET['longi']){
$locname = $_GET['locname'];
$lati = $_GET['lati'];
$longi = $_GET['longi'];
?>
		<!DOCTYPE html>
		<html lang="en">
		<head> 
		  <base target="_parent" />	
		  <meta charset="utf-8" />
		  <title>Waking Wind</title>
		  <meta name="viewport" content="width=device-width, initial-scale=1"> 
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
		
		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
		  <script type="text/javascript" src="./map_online.js"></script>	
		  <script>
			//show map
			function initialize(){
				geolocMap('<?php echo $locname; ?>', '<?php echo $lati; ?>', '<?php echo $longi; ?>');
			}
			google.maps.event.addDomListener(window, 'load', initialize);
		  </script>
		</head>
		<body>
			<div data-role="page" id="map">
				<div data-role="header" data-theme="d">
					<a href="#live_wind" data-role="button" data-icon="arrow-l" data-theme="b">Back</a>
					<h1 class="location"></h1>
				</div>
				<div data-role="content">
					<div id="map_canvas" style="width:100%; height:400px"></div>	
				</div><!-- /content -->
			</div><!-- /page -->
		</body>
		</html>
<?php
} else{
echo 'error';
}
?>