//highly recommended to use async.js to avoid callback hell

function initialize(){
	var input = $('#destinput')[0];

	var autocomplete = new google.maps.places.Autocomplete(input);
}