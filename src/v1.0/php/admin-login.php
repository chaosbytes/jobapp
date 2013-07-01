<?php
// admin-login.php handles requests for admins to log into their panel
// require script to connect to MySQL
require "connect.php";
//if login isset in POST array and is true
if (isset($_POST['login']) && $_POST['login']) {
	// open a link to MySQL db
	$link = connect();
	// if the link has no connection echo an error response
	if (!$link->ping()) {
		echo json_encode(array("status" => false, "error" => $link->error));
	} else if ($link) {
			// else if the link is valid
			// pull username and password from $_POST array and use real_escape_string to prevent sql injection attacks and also hash the password using md5()
			$username = $link->real_escape_string(htmlentities($_POST['username'], ENT_QUOTES));
			$passwordhash = md5($link->real_escape_string(htmlentities($_POST['password'], ENT_QUOTES)));
			//setup sql statement to check username and passwordhash
			$sql = "SELECT * FROM `admins` WHERE `username`='".$username."' AND `passwordhash`='".$passwordhash."'";
			// if $result get back a valid MySQL result from the query
			if ($result = $link->query($sql)) {
				// and if only 1 row was returned, meaning that there is a admin in the admins table with that username and passwordhash
				if ($result->num_rows == 1) {
					//set session name, set cookie params, start a session, and set username and passwordhash session variables to retain login privilieges
					session_name("jobappadmin");
					session_set_cookie_params(24*60*60);
					session_start();
					$_SESSION['username'] = $username;
					$_SESSION['passwordhash'] = $passwordhash;
					// then echo a success response and close the link and kill the script
					echo json_encode(array("status"=>true,"success"=>"Admin Login Success","message"=>"You Have Been Logged into the Admin Panel Successfully."));
					$link->close();
					die;
				} else {
					// else if no matching admins in table  echo an error response, close the link, and kill the script
					echo json_encode(array("status" => false, "error"=> "Admin Username or Password Incorrect", "message" => "The admin username or password you supplied was not valid. Please try again."));
					$link->close();
					die;
				}
			}
		}
}
?>