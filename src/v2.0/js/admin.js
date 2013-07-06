$(document).ready(function() {

	$.ajax({
		type: "POST",
		data: {
			autologin: true
		},
		dataType: "JSON",
		url: "./php/login.php",
		success: function(json) {
			loginAdmin(json);
		}
	});
	
	// click handler for #admin_login_submit button in admin panel
	$('#admin_login_submit').click(function() {
		// send POST request to login.php to authenticate admin credentials
		$.ajax({
			type: "POST",
			data: {
				admin_login: true,
				email: $('#admin_email').val(),
				password: $('#admin_password').val()
			},
			dataType: 'JSON',
			url: "./php/login.php",
			success: function(json) {
				if (json.status) {
					loginAdmin(json);
				} else if (!json.status) {
					// if login failed display modal dialog explaining failure
					displayModal(json.error, json.message, "./js/modal-dismiss-code.js");
				}
			}
		});
	});

	function loginAdmin(json) {
		// if login was a success display success modal
		displayModal(json.success, json.message, "./js/modal-dismiss-code.js");
		//populate admin panel table with client data, delete buttons (with their code), and a logout button (again with its code)
		$.post("./admin-panel.html", function(html) {
			$("#container").html(html); // add skeleton template for admin-panel for client data table from $.post request to 'admin-panel.html'
			$('#admin-panel').append(buildAdminPanel()); // buildAdminPanel() detailed below
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
	}
	/*
	 *  buildAdminPanel(), sends an ajax request to admin-panel.php which queries the client database and builds the html table code and returns it to be appended to the #admin-panel div
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