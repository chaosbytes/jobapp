$(document).ready(function () {
	$('#register-submit').click(function () {
		$.ajax({
			type: "POST",
			async: false,
			data: {
				register: true,
				fname: $('#register-fname').val(),
				lname: $('#register-lname').val(),
				email: $('#register-email').val(),
				zipcode: $('#register-zipcode').val(),
				password: $('#register-password').val(),
				passwordconfirm: $('#register-passwordconfirm').val()
			},
			url: "./php/register.php",
			success: function (data) {
				var json = JSON.stringify(data);
				json = JSON.parse(json);
				json = $.parseJSON(json);
				if (json.status) {
					displayModal(json.success, json.message, "./js/client-register-modal-code.js");
				} else if (!json.status) {
					displayModal(json.error, json.message, "./js/client-register-modal-code.js");
				}
			},
			error: function (jqXHR) {
				console.log(jqXHR);
			}
		});
	});

	$('#login-submit').click(function () {
		$.ajax({
			type: "POST",
			data: {
				login: true,
				username: $('#login-username').val(),
				password: $('#login-password').val()
			},
			async: false,
			url: "./php/client-login.php",
			success: function (data) {
				var json = JSON.stringify(data);
				json = JSON.parse(json);
				json = $.parseJSON(json);
				if (json.status) {
					displayModal(json.success, json.message, "./js/client-login-modal-code.js");
					$.get("./client-panel.html", function (html) {
						$("#container").html(html);
					});
				} else if (!json.status) {
					displayModal(json.error, json.message, "./js/client-login-modal-code.js");
				}
			},
			error: function (jqXHR, status, responseText) {
				console.log(status);
			}
		});
	});

	function displayModal(header, message, scriptSrc) {
		$('#wrapper').append("<div id='modal-bg'></div><div id='modal-wrapper'><div id='modal-message'><div id='modal-message-header'>" + header + "</div><div id='modal-message-text'>" + message + "</div><button id='modal-dismiss-button'>Dismiss</button></div></div>");
		var script = document.createElement("script");
		script.type = "text/javascript";
		script.src = scriptSrc;
		$('#wrapper').append(script);
	}
});