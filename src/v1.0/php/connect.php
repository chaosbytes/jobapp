<?php 
// connect.php - houses connect function for connecting to MySQL through mysqli
function connect() {
	//create new mysqli link
	$link = new mysqli('mysql.jobapp.foursquaregames.com', 'riceje7', 'aecolomjerice1024!', "jobapp_v1");
	// if there was an error
	if ($link->connect_errno) {
		//echo error response
		return "{'status': false, 'error': ".$link->error."}";
	} else {
		// else return the mysqli link
		return $link;
	}
}
?>
