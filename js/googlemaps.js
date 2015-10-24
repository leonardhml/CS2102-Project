
var map;
var directionsService;
var directionsDisplay;
var directionsRequest;

function initMaps() {

	//get location and destination in parallel, then call the two functions below when both complete
	async.parallel([
		getLocation,
		getDestination
		], function(err, results){
			if(err) console.error(err.message);
			else {
				getMap();
				getDirections();
			}
		}
	)

	function getMap() {
		map = new google.maps.Map($('#map')[0], {
			center: locationObj,
			zoom: 8
		});

		directionsService = new google.maps.DirectionsService();
		directionsDisplay = new google.maps.DirectionsRenderer();

		directionsDisplay.setMap(map);
		directionsDisplay.setPanel($('#dir-panel')[0]);
	}

	function getDirections(){
		console.log("origin: "+locStr);
		console.log("destination: "+destStr);

		directionsRequest = {
			origin: locStr,
			destination: destStr,
			travelMode: google.maps.TravelMode.TRANSIT,
			unitSystem: google.maps.UnitSystem.METRIC
		}

		directionsService.route(directionsRequest, function(res, status){
			if(status == google.maps.DirectionsStatus.OK)
				directionsDisplay.setDirections(res);
			else console.log(status);
		});
	}
}

