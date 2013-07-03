$(document).ready(function () {
	// click handler for the #register-submit button in client panel
	$('#register-submit').click(function () {
		// sends a POST request through ajax to register.php with the form data: fname, lname, email, zipcode, password, and passwordconfirm
		$.ajax({
			type: "POST",
			data: {
				register: true,
				first_name: $('#register-fname').val(),
				last_name: $('#register-lname').val(),
				email: $('#register-email').val(),
				zip_code: $('#register-zipcode').val(),
				password: $('#register-password').val(),
				password_confirm: $('#register-passwordconfirm').val()
			},
			url: "./php/register.php",
			success: function (json) {
				if (json.status) {
					// if registration is a success display success modal and clear form on modal dismissal
					displayModal(json.success, json.message, "./js/client-register-modal-code.js");
				} else if (!json.status) {
					// else display error modal and also clear the form on modal dismissal
					displayModal(json.error, json.message, "./js/client-register-modal-code.js");
				}
			}
		});
	});

	// click handler for #login-submit button in client panel
	$('#login-submit').click(function () {
		// send POST request to client-login.php to authenticate user credentials
		$.ajax({
			type: "POST",
			data: {
				login: true,
				username: $('#login-username').val(),
				password: $('#login-password').val()
			},
			url: "./php/client-login.php",
			success: function (data) {
			//data was coming back with invisible characters even after rewriting the php scripts so to overcome this issue I had to use JSON2 to stringify and parse the response into JSON then use jQuery to parse the JSON into a javascript object for use.
				var json = JSON.stringify(data);
				json = JSON.parse(json);
				json = $.parseJSON(json);
				if (json.status) {
					// if login is successful display success modal and populate #container with the html from client-panel.html
					displayModal(json.success, json.message, "./js/client-login-modal-code.js");
					$.get("./client-panel.html", function (html) {
						$("#container").html(html);
					});
				} else if (!json.status) {
					// else display error modal
					displayModal(json.error, json.message, "./js/client-login-modal-code.js");
				}
			}
		});
	});
});