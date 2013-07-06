<?php
require_once "config/db_config.php";

// admin-delete is used to delete clients from the clients table in the db

$link = new mysqli(HOSTNAME, DB_USER, DB_USER_PASS, DATABASE);
if (!$link->connect_errno) {
	if (isset($_POST['email'])) {
		$email = $_POST['email'];
		if ($link->query("DELETE FROM clients WHERE email='".$email."'")) {
			// if there was 1 row affected by the query echo success response
			if ($link->affected_rows == 1) {
				echo '{"status": true, "success":"User Deleted", "message":"The user '.$email.' has been deleted from the system."}';
			} else {
				// else echo and error response
				echo '{"status": false, "error":"No User Deleted", "message":"The user you tried to delete was not in the system, or there was an error."}';
			}
		}
	}
}
// close the link
$link->close();
?>