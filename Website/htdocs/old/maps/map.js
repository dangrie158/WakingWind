function geolocMap(ref, locname, lati, longi){
if(ref.value == 'Show on Map'){
	document.getElementById("map_canvas").style.display = 'block';
	var position = new google.maps.LatLng(lati, longi);
	
	var mapOptions = {
          center: position,
          zoom: 10,
          mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	//marker
	var marker = new google.maps.Marker({
		position: position,
		map: map,
		title: locname
	});
	//button umschreiben
	ref.value = 'Hide Map';
} else{
	ref.value = 'Show on Map';
	document.getElementById("map_canvas").style.display = 'none';
}	
}