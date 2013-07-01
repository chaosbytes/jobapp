/*
	admin.js
	
	code relating to the admin panel
*/
$(document).ready(function() {
	// send ajax POST request to autologin.php to check if the admin has logged in in the past 24 hours
	$.ajax({
		type: "POST",
		url: "./php/autologin.php",
		success: function(data) {
			//data was coming back with invisible characters even after rewriting the php scripts so to overcome this issue I had to use JSON2 to stringify and parse the response into JSON then use jQuery to parse the JSON into a javascript object for use.
			var json = JSON.stringify(data);
			json = JSON.parse(json);
			json = $.parseJSON(json);
			if (json.status) {
				// if there has been an admin logged in in the past 24 hours (as set by the cookie) populate the panel with the client data table contained in admin-panel.html
				$.post("./admin-panel.html", function(html) {
					$("#container").html(html); // add skeleton template for admin-panel for client data table from $.post request to 'admin-panel.html'
					$('#admin-panel').append(buildAdminPanel()); // buildAdminPanel() detailed below
					/* append client-delete-button code to the #wrapper element, we do this because the table with clients data is added asyncronously requiring either a refresh to link the click handlers to each button (which is undesirable) or the script must be added after the content has been loaded so the click handlers can find the buttons */
					var script = document.createElement("script");
					script.type = "text/javascript";
					script.src = "./js/delete-button-code.js";
					$('#wrapper').append(script);
					// add in the admin-logout button and its associated script
					$('#admin-header').append("<input type='submit' id='admin-logout' value='Logout'/>");
					script = document.createElement("script");
					script.type = "text/javascript";
					script.src = "./js/admin-logout-code.js";
					$('#wrapper').append(script);
				});
				// display a message saying login was successful
				displayModal(json.success, json.message, "./js/modal-dismiss-code.js");
			}
			// if no admin has been logged in do nothing
		}
	});

	// admin-login-button click handler
	$('#admin-login').click(function() {
		// send ajax POST request to admin-login.php to authenticate admin credentials
		$.ajax({
			type: "POST",
			data: {
				login: true,
				username: $('#admin-username').val(),
				password: $('#admin-password').val()
			},
			url: "./php/admin-login.php",
			success: function(data) {
				//data was coming back with invisible characters even after rewriting the php scripts so to overcome this issue I had to use JSON2 to stringify and parse the response into JSON then use jQuery to parse the JSON into a javascript object for use.
				var json = JSON.stringify(data);
				json = JSON.parse(json);
				json = jQuery.parseJSON(json);
				if (json.status) {
					// if login was a success display success modal
					displayModal(json.success, json.message, "./js/modal-dismiss-code.js");
					//populate admin panel table with client data, delete buttons (with their code), and a logout button (again with its code)
					$.post("./admin-panel.html", function(html) {
						$("#container").html(html); // add skeleton template for admin-panel for client data table from $.post request to 'admin-panel.html'
						$('#admin-panel').append(buildAdminPanel()); // buildAdminPanel() detaild below
						var script = document.createElement("script");
						script.type = "text/javascript";
						script.src = "./js/delete-button-code.js";
						$('#wrapper').append(script);
						$('#admin-header').append("<input type='submit' id='admin-logout' value='Logout'/>");
						script = document.createElement("script");
						script.type = "text/javascript";
						script.src = "./js/admin-logout-code.js";
						$('#wrapper').append(script);
					});
				} else if (!json.status) {
					// if login failed display modal dialog explaining failure
					displayModal(json.error, json.message, "./js/modal-dismiss-code.js");
				}
			}
		});
	});

	/*
		buildAdminPanel(), sends an ajax request to admin-panel.php which queries the client database and builds the html table code and returns it to be appended to the #admin-panel div
	*/
	function buildAdminPanel() {
		var html = "";
		$.ajax({
			type: "POST",
			async: false,
			dataType: "text",
			url: "./php/admin-panel.php",
			success: function(data) {
				html = data;
			}
		});
		return html;
	}

	
});