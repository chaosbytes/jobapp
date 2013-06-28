<?php
require "connect.php";

if (isset($_POST['register']) && $_POST["register"] == true) {
	$link = connect();
	if (!$link->ping()) {
		echo json_encode(array("status"=>false, "error"=>json_decode($link)->error));
	} else if ($link) {
			if ($_POST["password"] == $_POST["passwordconfirm"]) {
				$fname = $_POST["fname"];
				$lname = $_POST["lname"];
				$email = $_POST["email"];
				$zipcode = $_POST["zipcode"];
				$passwordhash = md5($_POST["password"]);
				
				$fname = $link->real_escape_string(htmlentities($fname, ENT_QUOTES));
				$lname = $link->real_escape_string(htmlentities($lname, ENT_QUOTES));
				$email = $link->real_escape_string(htmlentities($email, ENT_QUOTES));
				$zipcode = $link->real_escape_string(htmlentities($zipcode, ENT_QUOTES));
				$username = strtolower($fname).".".strtolower($lname);
				
				$sql = "INSERT INTO clients (username, fname, lname, email, zipcode, passwordhash) VALUES ('".$username."', '".$fname."', '".$lname."', '".$email."', '".$zipcode."', '".$passwordhash."');";
				$result = $link->query($sql);
				if($link->affected_rows == 1){
					echo json_encode(array("status"=>true, "success"=>"Registration Successful", "message"=> "You have successfully registered with our system. You may now use the login form to login to the system.<br/>To log into our system your USERNAME will be:<br/><h3 class='modal'>".$username."</h3>"));
				} else {
					echo json_encode(array("status"=> false, "error"=>"Duplicate Entry", "message"=> "You have already registered with our system, please use the login form."));
				}
			} else {
				echo json_encode(array("status"=> false, "error"=> "Password Mismatch", "message"=> "Passwords Do Not Match, Please Try Again."));
			}
		}
		$link->close();
}
?> 