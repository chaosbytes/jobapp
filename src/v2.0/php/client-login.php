<?php
// client-login.php - used to login a client to the client panel
// require MySQL connection function
require "connect.php";
// if login isset in $_POST array and is true
if (isset($_POST['login']) && $_POST['login']) {
	// open a link to MySQL
	$link = connect();
	// if $link has no valid connection
	if (!$link->ping()) {
		// echo error response
		echo json_encode(array("status" => false, "error" => $link->error));
	} else if ($link) {
			// else if there is a valid link 
			// assign $useraname and $passwordhash with real_escaped data from $_POST array (username and passwordhash respectively) and hash password with md5()
			$username = $link->real_escape_string(htmlentities($_POST['username'], ENT_QUOTES));
			$passwordhash = md5($link->real_escape_string(htmlentities($_POST['password'], ENT_QUOTES)));
			// setup SQL statement
			$sql = "SELECT * FROM clients WHERE username='".$username."' AND passwordhash='".$passwordhash."'";
			//if $result gets a valid mysql result from the query
			if ($result = $link->query($sql)) {
				// and if there is only 1 match
				if ($result->num_rows == 1) {
					// start a client session
					session_name("jobappclient");
					session_start();
					// and echo a success response, close the link and kill the script
					echo json_encode(array("status"=>true, "success"=>"Login Success", "message"=>"You Have Been Logged In Successfully."));
					$link->close();
					die;
				} else {
					// else echo an error response, close the link and kill the script
					echo json_encode(array("status" => false, "error"=> "Username or Password Incorrect", "message" => "The username or password you supplied was not valid. Please try again."));
					$link->close();
					die;
				}
			}
		}
}
?>