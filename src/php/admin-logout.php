<?php
if (isset($_POST['logout']) && $_POST['logout']) {
	session_start();
	//remove PHPSESSID from browser
	if (isset($_COOKIE[session_name("jobappadmin")])) {
		session_unset();
		session_destroy();
		session_write_close();
		setcookie(session_name(), '', 0, '/');
	}
	echo json_encode(array("status"=> true, "success"=>"Admin Logged Out", "message"=>"You have been successfully logged out."));
}
?>