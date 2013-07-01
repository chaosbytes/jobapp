//click handler for modal-dismiss-button, removes #modal-bg and #modal-wrapper from the document

$('#modal-dismiss-button').click(function () {
	$('#modal-wrapper').remove();
	$('#modal-bg').remove();
});