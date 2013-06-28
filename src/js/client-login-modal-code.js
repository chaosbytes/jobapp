$('#modal-dismiss-button').click(function () {
	$('#modal-wrapper').remove();
	$('#modal-bg').remove();
	$('#login-username').val('');
	$('#login-password').val('');
});