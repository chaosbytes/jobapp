// click handler for client register modal dialog
$('#modal-dismiss-button').click(function () {
	// remove modal dialog and background divs
	$('#modal-wrapper').remove();
	$('#modal-bg').remove();
	// reset all input field values
	$('#register-fname').val('');
	$('#register-lname').val('');
	$('#register-email').val('');
	$('#register-zipcode').val('');
	$('#register-password').val('');
	$('#register-passwordconfirm').val('');
});