function geolocMap(locname, lati, longi){
	var position = new google.maps.LatLng(lati, longi);
	
	var mapOptions = {
          center: position,
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	//marker
	var marker = new google.maps.Marker({
		position: position,
		map: map,
		title: locname
	});
}