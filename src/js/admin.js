$(document).ready(function(){
	$('#admin-login').click(function () {
		$.ajax({
			type: "POST",
			data: {
				login: true,
				username: $('#admin-username').val(),
				password: $('#admin-password').val()
			},
			async: false,
			url: "./php/admin-login.php",
			success: function (data) {
				var json = JSON.stringify(data);
				json = JSON.parse(json);
				json = $.parseJSON(json);
				if (json.status) {
					displayModal(json.success, json.message, "./js/login-modal-code.js");
					$.get("./admin-panel.html", function (html) {
						$("#container").html(html);
					});
				} else if (!json.status) {
					displayModal(json.error, json.message, "./js/login-modal-code.js");
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