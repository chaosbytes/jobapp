<?php 
// connect.php - houses connect function for connecting to MySQL through mysqli
function connect() {
	//create new mysqli link
	$link = new mysqli('localhost', 'root', 'aecolomjerice1024!', "jobapp_v2");
	// if there was an error
	if ($link->connect_errno) {
		//echo error response
		return json_encode(array('status' => false, 'error' => $link->error));
	} else {
		// else return the mysqli link
		return $link;
	}
}
?>
