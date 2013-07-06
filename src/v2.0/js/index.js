$(document).ready(function() {

	// click handler for the #register-submit button in client panel
	$('#register-submit').click(function() {
		// sends a POST request through ajax to register.php with the form data: fname, lname, email, zipcode, password, and passwordconfirm
		$.ajax({
			type: "POST",
			data: {
				register: true,
				first_name: $('#first_name').val(),
				last_name: $('#last_name').val(),
				email: $('#email').val(),
				zip_code: $('#zip_code').val(),
				password: $('#password').val(),
				password_confirm: $('#password_confirm').val()
			},
			dataType: 'JSON',
			url: "./php/register.php",
			success: function(json) {
				console.log(json.status);
				if (json.status) {
					// if registration is a success display success modal and clear form on modal dismissal
					displayModal(json.success, json.message, "./js/client-register-modal-code.js");
				} else if (!json.status) {
					// else display error modal and also clear the form on modal dismissal
					displayModal(json.error, json.message, "./js/client-register-modal-code.js");
				}
			},
			error: function(jqXHR, status, responseText) {
				console.log(responseText);
			}
		});
	});

	// click handler for #client_login_submit button in client panel
	$('#client_login_submit').click(function() {
		// send POST request to login.php to authenticate client credentials
		$.ajax({
			type: "POST",
			data: {
				client_login: true,
				email: $('#client_email').val(),
				password: $('#client_password').val()
			},
			dataType: 'JSON',
			url: "./php/login.php",
			success: function(json) {
				if (json.status) {
					// if login is successful display success modal and populate #container with the html from client-panel.html
					displayModal(json.success, json.message, "./js/client-login-modal-code.js");
					$.get("./client-panel.html", function(html) {
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