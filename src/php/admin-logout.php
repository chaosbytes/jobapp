<?php
// admin-logout.php - used to logout an admin and kill thier session and all associated variables
// if logout isset in $_POST array and is true
if (isset($_POST['logout']) && $_POST['logout']) {
	//start the session
	session_start();
	// if there is and admin session cookie
	if (isset($_COOKIE[session_name("jobappadmin")])) {
		// unset session variables
		session_unset();
		// destroy the session
		session_destroy();
		// end current session
		session_write_close();
		//set a cookie with blank session name , no value, 0 value expiration and domain level access
		setcookie(session_name(), '', 0, '/');
		//replace current session	and delete old session file
    session_regenerate_id(true);
	}
	//echo success response
	echo json_encode(array("status"=> true, "success"=>"Admin Logged Out", "message"=>"You have been successfully logged out."));
}
?>