$('#modal-dismiss-button').click(function () {
	$('#modal-wrapper').remove();
	$('#modal-bg').remove();
	$('#register-fname').val('');
	$('#register-lname').val('');
	$('#register-email').val('');
	$('#register-zipcode').val('');
	$('#register-password').val('');
	$('#register-passwordconfirm').val('');
});