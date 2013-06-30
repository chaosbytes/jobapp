$('.admin-delete-button').click(function() {
	var that = $(this);
	$.ajax({
		type: "POST",
		data: {
			username: that.attr('id')
		},
		url: "./php/admin-delete.php",
		success: function(data) {
			var json = JSON.stringify(data);
			json = JSON.parse(json);
			json = $.parseJSON(json);
			if (json.status) {
				console.log(that);
				var i=that[0].parentNode.parentNode.rowIndex;
				document.getElementById('admin-table').deleteRow(i);
				//displayModal(json.success, json.message, "./js/delete-user-modal-code.js");
			} else if (!json.status) {
				displayModal(json.error, json.message, "./js/delete-user-modal-code.js");
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