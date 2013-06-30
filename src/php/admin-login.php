<?php
require "connect.php";

if (isset($_POST['login']) && $_POST['login']) {
	$link = connect();
	if (!$link->ping()) {
		echo json_encode(array("status" => false, "error" => $link->error));
	} else if ($link) {
			$username = $link->real_escape_string(htmlentities($_POST['username'], ENT_QUOTES));
			$passwordhash = md5($link->real_escape_string(htmlentities($_POST['password'], ENT_QUOTES)));
			$sql = "SELECT * FROM `admins` WHERE `username`='".$username."' AND `passwordhash`='".$passwordhash."'";
			if ($result = $link->query($sql)) {
				if ($result->num_rows == 1) {
					session_name("jobappadmin");
					session_set_cookie_params(24*60*60);
					session_start();
					$_SESSION['username'] = $username;
					$_SESSION['passwordhash'] = $passwordhash;
					echo json_encode(array("status"=>true,"success"=>"Admin Login Success","message"=>"You Have Been Logged into the Admin Panel Successfully."));
					$link->close();
					die;
				} else {
					echo json_encode(array("status" => false, "error"=> "Admin Username or Password Incorrect", "message" => "The admin username or password you supplied was not valid. Please try again."));
					$link->close();
					die;
				}
			}
		}
}
?>