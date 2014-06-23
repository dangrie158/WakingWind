<script>
var favSpots = 0;
function addSpot( id )
{
	
	$.ajax({
		url: "/modules/favspots_worker.php?action=insert&locid=" + id,
  	}).done(function ( data ) {
		entry = jQuery.parseJSON(data);
		insertSpot( entry );
	});
}

function insertSpot( entry )
{
	var ruler = '';
	if( favSpots++ != 0 )
	{
		ruler = '<hr />';
	}
	var alarmproperties;
	if( entry.alarm != '00:00' )
	{
		alarmproperties = entry.alarm.substring(0,5);
	}else
	{
		alarmproperties = '<em>not set</em>'	
	}
	$( '#spotscontainer' ).append( 
	'<div style="display:none" id="loccontainer' + entry.loc_id + '" >' +
		ruler +
		'<h3>' + entry.loc_name + ', ' + entry.loc_address + '</h3>' +
		'<p>Alarm: ' + alarmproperties + '</p>' +
		'<a class="smalllink" onclick="javascript:setAlarm(' + entry.loc_id + ')"><img src="images/alarm.png" alt="set Alarm" />set</a>' +
		'<a class="smalllink" onclick="javascript:removeSpot(' + entry.loc_id + ')"><img src="images/trash.png" alt="delete Spot" />remove</a>' +
	'</div>'
	);
	$( '#loccontainer' + entry.loc_id ).fadeIn( 1500 );	
}

function updateSpots()
{
	var spots;
	$.ajax({
		url: "/modules/favspots_worker.php?action=list",
  	}).done(function ( data ) {
		spots = jQuery.parseJSON(data);
		spots.forEach(
			function( entry )
			{
				insertSpot( entry );
			}
		);
	});
}

function removeSpot( id )
{
	$.ajax({
		url: "/modules/favspots_worker.php?action=delete&locid=" + id,
  	}).done(function ( data ) {
		$( '#loccontainer' + id ).fadeOut( 1500 );
	});
}

$( '#spotscontainer' ).hide();
updateSpots();
</script>

<h2>Favorite Spots</h2>
<div id="spotscontainer">
	
</div>