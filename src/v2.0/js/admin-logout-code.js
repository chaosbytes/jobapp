// admin-logout-code.js
// click handler for the admin's logout button
$('#admin-logout').click(function() {
	// send ajax POST request to admin-logout.php to kill the current admin session
	$.ajax({
		type: "POST",
		data: {
			logout: true
		},
		url: "./php/admin-logout.php",
		success: function(data) {
			//data was coming back with invisible characters even after rewriting the php scripts so to overcome this issue I had to use JSON2 to stringify and parse the response into JSON then use jQuery to parse the JSON into a javascript object for use.
			var json = JSON.stringify(data);
			json = JSON.parse(json);
			json = $.parseJSON(json);
			
			if (json.status) {
			// if logout in php script was successful display modal saying so then redirect admin back to login screen
				displayModal(json.success, json.message, "./js/modal-dismiss-code.js");
				setTimeout(function(){window.location = "./admin";}, 1000);
			} else if (!json.status) {
			// else display a modal saying there was an error logging out
				displayModal(json.error, json.message, "./js/modal-dismiss-code.js");
			}
		}
	});
});