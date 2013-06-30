<?php
session_name("jobappadmin");
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['passwordhash'])) {
	echo json_encode(array("status"=>true, "success"=>"Admin Login Success", "message"=>"You Have Been Logged into the Admin Panel Successfully."));
} else {
	echo json_encode(array("status" => false));
}
?> 