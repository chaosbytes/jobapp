<?php 
function connect() {
	$link = new mysqli('localhost', 'root', 'aecolomjerice1024!', "jobapp");
	if ($link->connect_errno) {
		return json_encode(array('status' => false, 'error' => $link->error));
	} else {
		return $link;
	}
}
?>
