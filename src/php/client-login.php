<?php
require "connect.php";

if (isset($_POST['login']) && $_POST['login']) {
	$link = connect();
	if (!$link->ping()) {
		echo json_encode(array("status" => false, "error" => $link->error));
	} else if ($link) {
			$username = $link->real_escape_string(htmlentities($_POST['username'], ENT_QUOTES));
			$passwordhash = md5($link->real_escape_string(htmlentities($_POST['password'], ENT_QUOTES)));
			$sql = "SELECT * FROM clients WHERE username='".$username."' AND passwordhash='".$passwordhash."'";
			if ($result = $link->query($sql)) {
				if ($result->num_rows == 1) {
					session_name("jobappclient");
					session_start();
					echo json_encode(array("status"=>true, "success"=>"Login Success", "message"=>"You Have Been Logged In Successfully."));
					$link->close();
					die;
				} else {
					echo json_encode(array("status" => false, "error"=> "Username or Password Incorrect", "message" => "The username or password you supplied was not valid. Please try again."));
					$link->close();
					die;
				}
			}
		}
}
?>