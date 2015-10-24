function initMaps(){
	var input = $('#pickup_place')[0];

	var autocomplete = new google.maps.places.Autocomplete(input);
	
	var geocoder = new google.maps.Geocoder;

	getLocation(function(err){
		if(err) 
			console.warn('ERROR(' + err.code + '): ' + err.message);
		else{
			console.log(locationObj);
			geocoder.geocode({'location': {
				lat: parseFloat(locationObj.lat), 
				lng: parseFloat(locationObj.lng)}}, 
				function(res, status) {
					if (status === google.maps.GeocoderStatus.OK) {
						locStrName = res[0].formatted_address;
						callback();
					} else {
		        		window.alert('Geocoder failed: ' + status);
		        		locStrName = getStr(locationObj);
		        		callback();
		        	}
				}
			);
		}
	});

	function callback(){
		console.log(locStrName);
		$('#pickup_place').attr("value", locStrName);
	}
}