$(document).ready(function () {
	// click handler for the #register-submit button in client panel
	$('#register-submit').click(function () {
		// sends a POST request through ajax to register.php with the form data: fname, lname, email, zipcode, password, and passwordconfirm
		$.ajax({
			type: "POST",
			data: {
				register: true,
				fname: $('#register-fname').val(),
				lname: $('#register-lname').val(),
				email: $('#register-email').val(),
				zipcode: $('#register-zipcode').val(),
				password: $('#register-password').val(),
				passwordconfirm: $('#register-passwordconfirm').val()
			},
			dataType: "JSON",
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
			dataType: "JSON",
			url: "./php/client-login.php",
			success: function (json) {
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