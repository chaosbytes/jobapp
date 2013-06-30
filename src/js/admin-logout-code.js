$('#admin-logout').click(function() {
	$.ajax({
		type: "POST",
		data: {
			logout: true
		},
		url: "./php/admin-logout.php",
		success: function(data) {
			var json = JSON.stringify(data);
			json = JSON.parse(json);
			json = $.parseJSON(json);
			if (json.status) {
				displayModal(json.success, json.message, "./js/admin-logout-modal-code.js");
			} else if (!json.status) {
				displayModal(json.error, json.message, "./js/admin-logout-modal-code.js");
			}
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