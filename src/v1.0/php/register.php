<?php
// register.php - used to register a new client
// require connect.php to connect to MySQL
require "connect.php";
// if register isset in $_POST array and is true
if (isset($_POST['register']) && $_POST["register"]) {
	// if the password and passwordconfirm are the same value
	if ($_POST["password"] == $_POST["passwordconfirm"]) {
		// setup variables for $_POST data
		$fname = $_POST["fname"];
		$lname = $_POST["lname"];
		$email = $_POST["email"];
		$zipcode = $_POST["zipcode"];
		// hash the password with md5()
		$passwordhash = md5($_POST["password"]);
		//create a username with this convention: firstname.lastname (in all lowercase)
		$username = strtolower($fname).".".strtolower($lname);
		// insert user into database
		insertNewUser($username, $fname, $lname, $email, $zipcode, $passwordhash);
	} else {
	 	// else if passwords don't match echo error response
		echo '{"status": false, "error": "Password Mismatch", "message": "Passwords Do Not Match, Please Try Again."}';
	}
}
// insertNewUser() inserts a user into the the clients table in the db
function insertNewUser($_username, $_fname, $_lname, $_email, $_zipcode, $_passwordhash) {
	// open a link
	$link = connect();
	// if link has no valid connection
	if ($link) {
			// else if link is valid
			
			// setup variables that are escaped to protect against sql injection
			$fname = $link->real_escape_string(htmlentities($_fname, ENT_QUOTES));
			$lname = $link->real_escape_string(htmlentities($_lname, ENT_QUOTES));
			$email = $link->real_escape_string(htmlentities($_email, ENT_QUOTES));
			$zipcode = $link->real_escape_string(htmlentities($_zipcode, ENT_QUOTES));
			// setup sql statement
			$sql = "INSERT INTO clients (username, fname, lname, email, zipcode, passwordhash) VALUES ('".$_username."', '".$fname."', '".$lname."', '".$email."', '".$zipcode."', '".$_passwordhash."');";
			// query mysql
			$link->query($sql);
			// if only 1 row was affected, user was inserted
			if ($link->affected_rows == 1) {
				// echo success response and kill script
				echo '{"status":true, "success":"Registration Successful", "message": "You have successfully registered with our system. You may now use the login form to login to the system.<br/>To log into our system your USERNAME will be:<br/><h3 class=modal>'.$_username.'</h3>"}';
			} else {
				//else if there is already that username in the table
				// setup sql statement to check email address duplicate
				$sql = "SELECT email FROM clients WHERE  fname='".$fname."' AND lname='".$lname."'";
				$results = $link->query($sql);
				// set a bool to false then iterate over the $results and if there is a matching email set bool to true
				$duplicateEmail = false;
				while ($row = $results->fetch_row()) {
					if ($row[0] === $_email) {
						$duplicateEmail = true;
					}
				}
				// if bool is true echo error response
				if ($duplicateEmail) {
					echo '{"status": false, "error":"Duplicate Entry", "message": "You have already registered with our system, please use the login form."}';
				} else {
					//else get count of matching emails and append that number to the username and try insertion again
					$count = $results->num_rows;
					$username = $_username.$count;
					insertNewUser($username, $_fname, $_lname, $_email, $_zipcode, $_passwordhash);
				}
			}
		}
	// close link
	$link->close();
}
?> 