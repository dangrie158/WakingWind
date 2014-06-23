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
		'<table style="width:100%">'+
			'<tr>'+
				'<td><button style="font-size:smaller" class="btnSet" onclick="javascript:setAlarm(' + entry.loc_id + ', \''+ entry.loc_name +'\', \''+ entry.alarm +'\', '+ entry.wspeed +')">set</button></td>' +
				'<td><button style="font-size:smaller; min-width:90px" class="btnActive'+ entry.loc_id +'" onclick="javascript:toggleActive(' + entry.loc_id + ')">activate</button></td>' +
				'<td><button style="font-size:smaller" class="btnRemove" onclick="javascript:removeSpot(' + entry.loc_id + ')">remove</button></td>' +
			'</tr>'+
		'</table>' +
	'</div>'
	);
	$('.btnSet').button({
      icons: {
        primary: "ui-icon-clock"
      }
    });
	$('.btnRemove').button({
      icons: {
        primary: "ui-icon-trash"
      }
    });

    if(entry.active == '0')
    {
    	$('.btnActive' + entry.loc_id).button({
	      icons: {
	        primary: 'ui-icon-check'
	      },
	      label: 'activate'
	    });
	}else
	{
		$('.btnActive' + entry.loc_id).button({
	      icons: {
	        primary: 'ui-icon-cancel'
	      },
	      label: 'deactivate'
	    });
	}

	$( '#loccontainer' + entry.loc_id ).fadeIn( 1500 );	
}

function toggleActive( id )
{
	if( isSpotActive(id) == '' )
	{
		activateSpot(id);
	    $('.btnActive' + id).button({
	      icons: {
	        primary: 'ui-icon-cancel'
	      },
	      label: 'deactivate'
	    });
	}else
	{
		deactivateSpot(id);
		$('.btnActive' + id).button({
	      icons: {
	        primary: 'ui-icon-check'
	      },
	      label: 'activate'
	    });
	}
}

function setAlarm( id, name, alarm, wspeed )
{
	var hours = alarm.split(":")[0];
	var minutes = alarm.split(":")[1];
	$( "#hour" ).val(Number(hours));
	$( "#minute" ).val(Number(minutes));
	$( "#windspeed" ).val(wspeed);
	$( "#locid" ).val(id);
	$( "#alarm-form" ).dialog( 'option', 'title', 'Set Alarm for: ' + name);
	$( "#alarm-form" ).dialog( 'open' );
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

function updateSpot(id)
{
	$.ajax({
		url: "/modules/favspots_worker.php?action=get&locid=" + id,
  	}).done(function ( data ) {
		entry = jQuery.parseJSON(data);
		var alarmproperties;
		if( entry.alarm != '00:00' )
		{
			alarmproperties = 'Alarm: ' + entry.alarm.substring(0,5);
		}else
		{
			alarmproperties = '<em>not set</em>'	
		}
		$( '#loccontainer' + entry.loc_id + ' p:first' ).html( alarmproperties );
		$('.btnActive' + entry.loc_id).button({
	      icons: {
	        primary: 'ui-icon-cancel'
	      },
	      label: 'deactivate'
	    });
		
	});
}

function removeSpot( id )
{
	$.ajax({
		url: "/modules/favspots_worker.php?action=delete&locid=" + id
  	}).done(function ( data ) {
		$( '#loccontainer' + id ).fadeOut( 1500, function(){$( this ).remove();} );
	});
}

function activateSpot( id )
{
	$.ajax({
		url: "/modules/favspots_worker.php?action=activate&locid=" + id
  	});
}

function deactivateSpot( id )
{
	$.ajax({
		url: "/modules/favspots_worker.php?action=deactivate&locid=" + id
  	});
}

function isSpotActive( id )
{
	var i = $.ajax({
		url: "/modules/favspots_worker.php?action=isActive&locid=" + id,
		async: false
  	});
  	return i.responseText;
}

$( '#spotscontainer' ).hide();
$( document ).ready(function(){
	$('#alarm-form').dialog({
      autoOpen: false,
      height: 150,
      width: 400,
      modal: true,
      resizable: false,
      buttons: {
        "Set Alarm": function() {
        	var minutes = $('#minute').val();
        	var hours = $('#hour').val();
        	var windspeed = $('#windspeed').val();
        	var id = $('#locid').val();
			$.ajax({
				url: "/modules/favspots_worker.php?action=setAlarm&locid="+ id +"&hour="+ hours +"&minute="+ minutes +"&windspeed="+ windspeed
		  	}).done(function(){
		  		updateSpot(id);
		  	});
			$( this ).dialog( "close" );
            
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      },
      close: function() {
		
      }
    });
});
updateSpots();
</script>

<h2>Favorite Spots</h2>
<div id="spotscontainer">
	
</div>

<div id="alarm-form">
  <form>
  	<input type="hidden" id="locid" name="locid" />
  	<label for="windspeed">Windspeed:</label>
    <select name="windspeed" id="windspeed" value="" class="text ui-widget-content ui-corner-all">
    	<option value="0">0 kn</option>
    	<option value="1">1 kn</option>
    	<option value="4">4 kn</option>
    	<option value="7">7 kn</option>
    	<option value="11">11 kn</option>
    	<option value="16">16 kn</option>
    	<option value="22">22 kn</option>
    	<option value="28">28 kn</option>
    </select>
    <label for="hour">Hour:</label>
    <select name="hour" id="hour" class="text ui-widget-content ui-corner-all">
    	<option value="0">00</option>
    	<option value="1">01</option>
    	<option value="2">02</option>
    	<option value="3">03</option>
    	<option value="4">04</option>
    	<option value="5">05</option>
    	<option value="6">06</option>
    	<option value="7">07</option>
    	<option value="8">08</option>
    	<option value="9">09</option>
    	<option value="10">10</option>
    	<option value="11">11</option>
    	<option value="12">12</option>
    	<option value="13">13</option>
    	<option value="14">14</option>
    	<option value="15">15</option>
    	<option value="16">16</option>
    	<option value="17">17</option>
    	<option value="18">18</option>
    	<option value="19">19</option>
    	<option value="20">20</option>
    	<option value="21">21</option>
    	<option value="22">22</option>
    	<option value="23">23</option>
    </select>
    <label for="minute">Minute</label>
    <select name="minute" id="minute" value="" class="text ui-widget-content ui-corner-all">
    	<option value="00">00</option>
    	<option value="15">15</option>
    	<option value="30">30</option>
    	<option value="45">45</option>
    </select>
  </form>
</div>