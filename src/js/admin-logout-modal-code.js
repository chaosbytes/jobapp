$('#modal-dismiss-button').click(function () {
	$('#modal-wrapper').remove();
	$('#modal-bg').remove();
	setTimeout(function(){window.location = "./admin";}, 1000);
	
});