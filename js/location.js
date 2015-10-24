//highly recommended to use async.js to avoid callback hell

var locationObj = {
	lat: 1.296720, 
	lng: 103.786674
};
var locStr;

var destinationObj = {
	//vivocity
	lat: 1.264271, 
	lng: 103.822289
};
var destStr;

function getLocation(callback) {
	//this is an async operation, so it must accept a callback(err, res) function as a parameter

	//pull geolocation data using browser built-in function
	if(navigator.geolocation){
		navigator.geolocation.getCurrentPosition(success, error);
	} else {
		console.log("Geolocation not supported by this browser");
	}

	function success(pos) {
		console.log('success');
		locationObj.lat = pos.coords.latitude;
		locationObj.lng = pos.coords.longitude;
		locStr = getStr(locationObj);

		callback(null);
	}

	function error(err) {
		console.warn('ERROR(' + err.code + '): ' + err.message);
		//default: London Heathrow Airport
		console.log('Reverting to default');
		locStr = getStr(locationObj);

		callback(err);
	};
}

function getDestination(callback) {
	if(loggedin){
		destinationObj = user.destination;
		destStr = getStr(destinationObj);

		callback(null);
	} else {
		window.location.replace("/login");
	}
}

function getStr(Obj) {
	if(Obj.lat){
		return Obj.lat + ',' + Obj.lng;
	} else {
		return Obj;
	}
}