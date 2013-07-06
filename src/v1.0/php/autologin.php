<?php
// autologin.php - used to auto-login an admin 
// set session name
session_name("jobappadmin");
// start session
session_start();
// if username and passwordhash are set in $_SESSION array
if (isset($_SESSION['username']) && isset($_SESSION['passwordhash'])) {
	// echo a success response to allow auto-login
	echo '{"status":true, "success":"Admin Login Success", "message":"You Have Been Logged into the Admin Panel Successfully."}';
} else {
	// else echo error response 
	echo '{"status": false}';
}
?> 