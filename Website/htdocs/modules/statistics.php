<?php

include( "../connect/connect.php" );

if( !isset($_GET['locid']) || empty($_GET['locid']) )
{
	?>
		<script>
		function loadPluginContainer(locid){
			if(locid != 'default_option'){
				window.location= "?site=statistics&locid="+locid;
			}
		}
	</script>

		  <section id="content">
			<article style="border:none">
			  <h2 style="float: left;">Available locations:</h2>
<?php
$sql = 'SELECT id, loc_name, loc_address FROM locations ORDER BY loc_name';
?>			  
				<select id="locations" onchange="loadPluginContainer(this.value)">
					<option value="default_option">Select location</option>
		<?php
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
           </article>
		</section>
        <?php
}else 
{	
	$locationid = mysql_real_escape_string( $_GET['locid'] );

if( isset($_POST['from']) && !empty( $_POST['from'] ) )
{
	$timefrom = mysql_real_escape_string( $_POST['from'] );
}else{
	$timefrom = '2010-01-01';
}

if( isset($_POST['until']) && !empty($_POST['until']) )
{
	$timeuntil = mysql_real_escape_string( $_POST['until'] );
}else{
	$timeuntil = '2030-01-01';
}
if( !isset($_POST['groupby']) || $_POST['groupby'] == 'hours' )
{
	$grouppostfix = ', HOUR(timestamp)';
}else
{
	$grouppostfix = '';
}
  
 $sql = "SELECT DATE_FORMAT( timestamp , '%Y-%m-%d-%H' ) AS DEDate, ROUND( MIN(temperature), 2), ROUND( MAX(temperature), 2), ROUND( AVG(humidity), 2), ROUND(  AVG(rainfall), 2), ROUND( AVG(windspeed), 2), ROUND( MAX(windspeed), 2), ROUND( MIN(windspeed), 2) FROM average_data_loc_". $locationid ." WHERE timestamp BETWEEN '". $timefrom ."' AND '". $timeuntil ."' GROUP BY YEAR(timestamp), MONTH(timestamp), DAY(timestamp)". $grouppostfix ." ORDER BY timestamp ASC";

 $result = mysql_query( $sql );
 
 $timestamp = ""; 
 $timestamp_reformatted = "";
 $temperature_min = "";
 $temperature_max = "";
 $humidity = "";
 $rainfall = "";
 $windspeed_avg = "";
 $windspeed_max = "";
 $windspeed_min = "";
 
	while( $row = mysql_fetch_row( $result ) ) {
		$timestamp[]   = $row[0];
  		$temperature_min[] = $row[1];
		$temperature_max[] = $row[2];
		$humidity[] = $row[3];
		$rainfall[] = $row[4];
		$windspeed_avg[] = $row[5];
		$windspeed_max[] = $row[6];
		$windspeed_min[] = $row[7];
	}
	
	foreach( $timestamp as $time )
	{
		$parts = explode( '-', $time );	
		$timestamp_reformatted[] = 'Date.UTC( '.$parts[0].', '. ($parts[1]-1) .', '.$parts[2].', '.$parts[3].' )';
	}
		 
	$sqlwind = "SELECT CONCAT(10 * ROUND(windspeed / 10), '-', 10 * ROUND(windspeed / 10) + 10) AS `range`, COUNT(*) AS `number of users`, winddir FROM average_data_loc_". $locationid ." WHERE timestamp BETWEEN '". $timefrom ."' AND '". $timeuntil ."' GROUP BY 1, winddir ORDER BY winddir, windspeed;";

	$result = mysql_query( $sqlwind );
	$winddata = "";
	
	for($i = 0; $i <= 14; $i++)
	{
		for($j = 0; $j < 5; $j++)
		{
			$winddata[$i][$j] = '0';
		}
	}
	
	while( $row = mysql_fetch_row( $result ) ) {
		if($row[0]  == '0-10' )
			$winddata[$row[2]][0] += $row[1];
		else if($row[0]  == '10-20' )
			$winddata[$row[2]][1] += $row[1];
		else if($row[0]  == '20-30' )
			$winddata[$row[2]][2] += $row[1];
		else if($row[0]  == '30-40' )
			$winddata[$row[2]][3] += $row[1];
		else 
			$winddata[$row[2]][4] += $row[1];
	}
?>
      <section id="content">
		<article>
		<script type="text/javascript">
$(function () {
        $('#tempcontainer').highcharts({
            chart: {
                type: 'spline',
				backgroundColor:'rgba(221, 223, 225, 0.7)'
            },
            title: {
                text: 'Temperature'
            },
            subtitle: {
                text: 'MIN / MAX Temperatures'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                }
            },
            yAxis: { // Secondary yAxis
                title: {
                    text: 'Temperature',
                    style: {
                        color: '#000000'
                    }
                },
                labels: {
                    formatter: function() {
                        return this.value +'°C';
                    },
                    style: {
                        color: '#4572A7'
                    }
                }
    
            },
			tooltip: {
                shared: true
            },
            series: [{
                name: 'MIN',
				tooltip: {
                    valueSuffix: '°C'
                },
                data: [
				
				<?
					for( $i = 0; $i < count( $timestamp_reformatted ); $i++ )
					{
						if( $i != 0 )
						{
							echo ',';
						}
						
						echo '['. $timestamp_reformatted[$i] .', '. $temperature_min[$i] .']';
					}
				?>
                ],
				marker: {
                    enabled: false
                }
            }, {
                name: 'MAX',
				color: '#D97F30',
				tooltip: {
                    valueSuffix: '°C'
                },
                data: [
				<?php
				for( $i = 0; $i < count( $timestamp_reformatted ); $i++ )
					{
						if( $i != 0 )
						{
							echo ',';
						}
						
						echo '['. $timestamp_reformatted[$i] .', '. $temperature_max[$i] .']';
					}
				?>
                ],
				marker: {
                    enabled: false
                }
            }]
        });

    
	
	
	$('#raincontainer').highcharts({
            chart: {
                type: 'spline',
				backgroundColor:'rgba(221, 223, 225, 0.7)'
            },
            title: {
                text: 'Humidity & Rainfall'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                }
            },
            yAxis: [{ // Primary yAxis
                labels: {
                    formatter: function() {
                        return this.value +'°C';
                    },
                    style: {
                        color: '#89A54E'
                    }
                },
                title: {
                    text: 'Rainfall',
                    style: {
                        color: '#4572A7'
                    }
                },
				labels: {
                    formatter: function() {
                        return this.value +' mm/h';
                    },
                    style: {
                        color: '#4572A7'
                    }
                },
                opposite: true
    
            }, { // Secondary yAxis
                title: {
                    text: 'Humidity',
                    style: {
                        color: '#89A54E'
                    }
                },
                labels: {
                    formatter: function() {
                        return this.value +'%';
                    },
                    style: {
                        color: '#89A54E'
                    }
                }
    
            }],
			tooltip: {
                shared: true
            },
            series: [{
                name: 'Rainfall',
				yAxis: 0,
				color: '#4572A7',
				type: 'areaspline',
				tooltip: {
                    valueSuffix: ' mm/h'
                },
                data: [
				
				<?
					for( $i = 0; $i < count( $timestamp_reformatted ); $i++ )
					{
						if( $i != 0 )
						{
							echo ',';
						}
						
						echo '['. $timestamp_reformatted[$i] .', '. $rainfall[$i] .']';
					}
				?>
                ],
				marker: {
                    enabled: false
                }
            }, {
                name: 'Humidity',
				yAxis: 1,
				color: '#89A54E',
				tooltip: {
                    valueSuffix: '%'
                },
                data: [
				<?php
				for( $i = 0; $i < count( $timestamp_reformatted ); $i++ )
					{
						if( $i != 0 )
						{
							echo ',';
						}
						
						echo '['. $timestamp_reformatted[$i] .', '. $humidity[$i] .']';
					}
				?>
                ],
				marker: {
                    enabled: false
                }
            }]
        });

	
	
	        $('#winddircontainer').highcharts({
            chart: {
                type: 'spline',
				backgroundColor:'rgba(221, 223, 225, 0.7)'
            },
            title: {
                text: 'Windspeed'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                }
            },
            yAxis: { // Secondary yAxis
                title: {
                    text: 'Windspeed',
                    style: {
                        color: '#000000'
                    }
                },
				plotLines: [{
                    
                    color: '#FF0000',
                    dashStyle: 'ShortDash',
                    width: 2,
                    value: 44.82,
                    zIndex: 0,
                    label : {
                        text : 'Storm'
                    }
                }, {
                    color: '#008000',
                    dashStyle: 'ShortDash',
                    width: 2,
                    value: 4.86,
                    zIndex: 0,
                    label : {
                        text : 'Light Breeze'
                    }
                }, {
                    color: '#008000',
                    dashStyle: 'ShortDash',
                    width: 2,
                    value: 24.84,
                    zIndex: 0,
                    label : {
                        text : 'Fresh Breeze'
                    }
                }],
				min: 0,
                labels: {
                    formatter: function() {
                        return this.value +' knots';
                    },
                    style: {
                        color: '#4572A7'
                    }
                }
    
            },
			tooltip: {
                shared: true
            },
			legend: {
				enabled: false
			},
            series: [{
                name: 'Average',
				zIndex: 1,
				tooltip: {
                    valueSuffix: ' knots'
                },
                data: [
				
				<?
					for( $i = 0; $i < count( $timestamp_reformatted ); $i++ )
					{
						if( $i != 0 )
						{
							echo ',';
						}
						
						echo '['. $timestamp_reformatted[$i] .', '. $windspeed_avg[$i] .']';
					}
				?>
                ],
				marker: {
                    enabled: false
                }
            }, {
                name: 'Range',
				type: 'areasplinerange',
				color: '#4572A7',
				tooltip: {
                    valueSuffix: ' knots'
                },
				dashStyle: 'shortdot',
                data: [
				<?php
				for( $i = 0; $i < count( $timestamp_reformatted ); $i++ )
					{
						if( $i != 0 )
						{
							echo ',';
							
						}
						echo '['. $timestamp_reformatted[$i] .', '. $windspeed_min[$i] .','. $windspeed_max[$i] .']';
					}
				?>
                ],
				marker: {
                    enabled: false
                }
			}]
        });
			$('#windrosecontainer').highcharts({
        
	    chart: {
	        polar: true,
			backgroundColor:'rgba(221, 223, 225, 0.7)'
	    },
	    
	    title: {
	        text: 'Windrose'
	    },
	    
	    pane: {
	        startAngle: 0,
	        endAngle: 360
	    },
	
	    xAxis: {
			categories: ['N', 'NE', 'E', 'SE', 
	                'S', 'SW', 'W', 'NW'],
	        min: 0,
	        max: 8,
	        labels: {
	        	formatter: function () {
	        		return this.value;
	        	}
	        }
	    },
		legend: {
	        y: 100,
	        layout: 'horizontal'
	    },
	        
	    yAxis: {
	        min: 0
	    },
		
		tooltip: {
	    	shared: true,
	        pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.0f} samples</b><br/>',
			headerFormat: ''
	    },
	    
	    plotOptions: {
	        series: {
	            pointStart: -0.5,
	            pointInterval: 1,
				stacking: 'normal'
	        },
	        column: {
	            pointPadding: 0,
	            groupPadding: 0
	        }
	    },
	    series: [{
	        type: 'column',
	        name: '>41 knots',
	        data: [<?php 
			echo $winddata[0][4] .','.
								$winddata[2][4] .','.
								$winddata[4][4] .','.
								$winddata[6][4] .','.
								$winddata[8][4] .','.
								$winddata[10][4] .','.
								$winddata[12][4] .','.
								$winddata[14][4] .',' ?>],
	        pointPlacement: 'between'
	    },{
	        type: 'column',
	        name: '31-40 knots',
	        data: [<?php 
			echo $winddata[0][3] .','.
								$winddata[2][3] .','.
								$winddata[4][3] .','.
								$winddata[6][3] .','.
								$winddata[8][3] .','.
								$winddata[10][3] .','.
								$winddata[12][3] .','.
								$winddata[14][3] .',' ?>],
	        pointPlacement: 'between'
	    },{
	        type: 'column',
	        name: '21-30 knots',
	        data: [<?php 
			echo $winddata[0][2] .','.
								$winddata[2][2] .','.
								$winddata[4][2] .','.
								$winddata[6][2] .','.
								$winddata[8][2] .','.
								$winddata[10][2] .','.
								$winddata[12][2] .','.
								$winddata[14][2] .',' ?>],
	        pointPlacement: 'between'
	    },{
	        type: 'column',
	        name: '11-20 knots',
	        data: [<?php 
			echo $winddata[0][1] .','.
								$winddata[2][1] .','.
								$winddata[4][1] .','.
								$winddata[6][1] .','.
								$winddata[8][1] .','.
								$winddata[10][1] .','.
								$winddata[12][1] .','.
								$winddata[14][1] .',' ?>],
	        pointPlacement: 'between'
	    },{
	        type: 'column',
	        name: '0-10 knots',
	        data: [<?php 
			echo $winddata[0][0] .','.
								$winddata[2][0] .','.
								$winddata[4][0] .','.
								$winddata[6][0] .','.
								$winddata[8][0] .','.
								$winddata[10][0] .','.
								$winddata[12][0] .','.
								$winddata[14][0] .',' ?>],
	        pointPlacement: 'between'
	    }]
	});
	});
		</script>
		<script src="../js/highcharts.js"></script>
		<script src="../js/highcharts-more.js"></script>

		<div id="tempcontainer" style="min-width: 540px; width:100%; float:left; height: 400px; margin: 10px auto"></div>
		<div id="raincontainer" style="min-width: 540px; width:100%; float:left; height: 400px; margin: 10px auto"></div>
		<div id="winddircontainer" style="min-width: 540px; width:100%; float:left; height: 400px; margin: 10px auto"></div>
		<div id="windrosecontainer" style="min-width: 540px; width:100%; float:left; height: 400px; margin: 10px auto"></div>
	</article>

	<aside>
		<h2>Date-Range Select</h2>
		  <p>
	      	Show statistics
	      	from:
	      	<div id="fromdiv"></div>
	      	until:
	      	<div id="untildiv"></div>
		  	<form action="?site=statistics&locid=<?php echo $locationid ?>" method="post">
				<input name="from" type="hidden" id="from" value="<?php if(isset($_POST['from'])) echo $_POST['from']; ?>" />
	            <input name="until" type="hidden" id="until" value="<?php if(isset($_POST['until'])) echo $_POST['until']; ?>" />
	            <input type="radio" name="groupby" style="width:30px;" value="days" <?php if(isset($_POST['groupby']) && $_POST['groupby'] == 'days') echo 'checked' ?> />Daily
	            <input type="radio" name="groupby" style="width:30px;" value="hours"<?php if( !isset($_POST['groupby']) || $_POST['groupby'] == 'hours') echo 'checked' ?> />Hourly
	            <br />
	            <button type="submit" value="Update">Update</button>
	        </form>
	        <script>
				$(function() {
					$( "#fromdiv" ).datepicker({ 
						dateFormat: 'yy-mm-dd',
						onSelect: function( selectedDate ) {
        					$( '#untildiv' ).datepicker( 'option', 'minDate', selectedDate );
        					$( '#from' ).val( selectedDate );
      					}
					 });
					$( "#untildiv" ).datepicker({ 
						dateFormat: 'yy-mm-dd',
						onSelect: function( selectedDate ) {
							$( '#fromdiv' ).datepicker( 'option', 'maxDate', selectedDate );
							$( '#until' ).val( selectedDate );
						}
					});
				});
			</script>
		  </p>
	  </aside>
	</section>
<?php
}
?>