//highly recommended to use async.js to avoid callback hell
function initMaps(){
	var locStrName;

	var pickupinput = $('#pickup_place')[0];
	var destinput = $('#dropoff_place')[0];

	var pAutocomplete = new google.maps.places.Autocomplete(pickupinput);
	var dAutocomplete = new google.maps.places.Autocomplete(destinput);

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
			});
		}
	});

	function callback(){
		console.log(locStrName);
		$('#pickup_place').attr("value", locStrName);
	}

	getDestination(function(err){
		$('#dropoff_place').attr("value", userdest);
	});
}