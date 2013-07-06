// click handler for client register modal dialog
$('#modal-dismiss-button').click(function () {
	// remove modal dialog and background divs
	$('#modal-wrapper').remove();
	$('#modal-bg').remove();
	// reset all input field values
	$('#first_name').val('');
	$('#last_name').val('');
	$('#email').val('');
	$('#zip_code').val('');
	$('#password').val('');
	$('#password_confirm').val('');
});