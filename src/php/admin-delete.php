<?php
require "connect.php";

$link = connect();
if (!$link->ping()) {
	echo json_encode(array("status" => false, "error" => $link->error));
} else if ($link) {
		if (isset($_POST['username'])) {
			$username = $_POST['username'];
			$sql = "DELETE FROM clients WHERE username='".$username."'";
			if ($link->query($sql)) {
				if($link->affected_rows == 1){
					echo json_encode(array("status"=> true, "success"=>"User Deleted", "message"=>"The user ".$username." has been deleted from the system."));
				} else {
					echo json_encode(array("status"=> false, "error"=>"No User Deleted", "message"=>"The user you tried to delete was not in the system, or there was an error."));
				}
			}
		}
	}
$link->close();
?>