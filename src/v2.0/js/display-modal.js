// displayModal() displays a modal dialog with a header, body text and dismiss button
// the header and message variables are returned from php scripts upon their completion
// scriptSrc is the relative path to custom code for dismissing the modal and then performing other actions
// It appends the #modal-bg and #modal-wrapper divs and the custom script to the #wrapper div
function displayModal(header, message, scriptSrc) {
	$('#wrapper').append("<div id='modal-bg'></div><div id='modal-wrapper'><div id='modal-message'><div id='modal-message-header'>" + header + "</div><div id='modal-message-text'>" + message + "</div><button id='modal-dismiss-button'>Dismiss</button></div></div>");
	var script = document.createElement("script");
	script.type = "text/javascript";
	script.src = scriptSrc;
	$('#wrapper').append(script);
}