$(document).ready(function() {
	$.ajax({
		type: "POST",
		url: "./php/autologin.php",
		success: function(data) {
			var json = JSON.stringify(data);
			json = JSON.parse(json);
			json = $.parseJSON(json);
			if (json.status) {
				$.post("./admin-panel.html", function(html) {
					$("#container").html(html);
					$('#admin-panel').append(buildAdminPanel());
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
				displayModal(json.success, json.message, "./js/admin-autologin-modal-code.js");
			}
		}
	});

	$('#admin-login').click(function() {
		$.ajax({
			type: "POST",
			data: {
				login: true,
				username: $('#admin-username').val(),
				password: $('#admin-password').val()
			},
			url: "./php/admin-login.php",
			success: function(data) {
				var json = JSON.stringify(data);
				json = JSON.parse(json);
				json = $.parseJSON(json);
				if (json.status) {
					displayModal(json.success, json.message, "./js/admin-login-modal-code.js");
					$.post("./admin-panel.html", function(html) {
						$("#container").html(html);
						$('#admin-panel').append(buildAdminPanel());
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
					displayModal(json.error, json.message, "./js/admin-login-modal-code.js");
				}
			},
			error: function(jqXHR, status, responseText) {
				console.log(status);
			}
		});
	});



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

	function displayModal(header, message, scriptSrc) {
		$('#wrapper').append("<div id='modal-bg'></div><div id='modal-wrapper'><div id='modal-message'><div id='modal-message-header'>" + header + "</div><div id='modal-message-text'>" + message + "</div><button id='modal-dismiss-button'>Dismiss</button></div></div>");
		var script = document.createElement("script");
		script.type = "text/javascript";
		script.src = scriptSrc;
		$('#wrapper').append(script);
	}
});