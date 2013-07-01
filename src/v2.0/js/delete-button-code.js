// click handler for the admin delete buttons to delete clients from db
$('.admin-delete-button').click(function() {
	// assign this element to 'that' variable for later reference
	var that = $(this);
	// make ajax POST request to admin-delete.php to delete user from db
	$.ajax({
		type: "POST",
		data: {
			username: that.attr('id')
		},
		url: "./php/admin-delete.php",
		success: function(data) {
			//data was coming back with invisible characters even after rewriting the php scripts so to overcome this issue I had to use JSON2 to stringify and parse the response into JSON then use jQuery to parse the JSON into a javascript object for use.
			var json = JSON.stringify(data);
			json = JSON.parse(json);
			json = $.parseJSON(json);
			if (json.status) {
				// if deletion from db was successful remove the row from table by accessing the grandparent node of 'that' (assigned above) and getting the table row index
				var i=that[0].parentNode.parentNode.rowIndex;
				// then actually delete it
				document.getElementById('admin-table').deleteRow(i);
				
				//display modal confirming deletion, commented out because it seemed too redundant from an end user perspective, as the row is removed from the table above
				//displayModal(json.success, json.message, "./js/modal-dismiss-code.js");
			} else if (!json.status) {
				displayModal(json.error, json.message, "./js/modal-dismiss-code.js");
			}
		}
	});
});
