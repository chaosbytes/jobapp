<?php
// admin-delete is used to delete clients from the clients table in the db
//require php script to connect to MySQL
require "connect.php";
require "sendmail.php";
// open a link to MySQL
$link = connect();
// if the link has no connection echo an error response
if (!$link->ping()) {
	echo json_encode(array("status" => false, "error" => $link->error));
} else if ($link) {
	//else if the link is valid check if the username variable is in $_POST array
		if (isset($_POST['username'])) {
			$username = $_POST['username'];
			// sql statement
			$sql = "DELETE FROM clients WHERE username='".$username."'";
			// query the clients table in db with mysqli method
			if ($link->query($sql)) {
				// if there was 1 row affected by the query echo success response
				if($link->affected_rows == 1 && json_decode(sendMail("riceje7@gmail.com", "Joe Rice", "Account Deleted", "This email is to inform you that your client level account with username: ".$username.", has been deleted."))){
						echo json_encode(array("status"=> true, "success"=>"User Deleted", "message"=>"The user ".$username." has been deleted from the system."));
				} else {
					// else echo and error response
					echo json_encode(array("status"=> false, "error"=>"No User Deleted", "message"=>"The user you tried to delete was not in the system, or there was an error."));
				}
			}
		}
	}
// close the link
$link->close();
?>