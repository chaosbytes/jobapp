<?php
// register.php - used to register a new client

require_once "config/db_config.php";

require_once "config/password_reset_config.php";

require_once "classes/class.login.php";


$login = new Login($_POST);

if ($login->is_logged_in()) {
	$messages = "";
	foreach ($login->messages as $message) {
		$messages = $messages.$message."<br/>";
	}
	$user_type = "";
	if (isset($_SESSION['admin_logged_in'])) {
		$user_type="Admin";
	} else if (isset($_SESSION['client_logged_in'])) {
			$user_type="Client";
		}
	$json = '{"status": true, "success":"'.$user_type.' Login Successful", "message":"'.$messages.'"}';
	echo $json;
} else if ($login->is_logged_out()) {
		$messages = "";
	foreach ($login->messages as $message) {
		$messages = $messages.$message."<br/>";
	}
		$json = '{"status": true, "success":"Logout Successful", "message":"'.$messages.'"}';
		echo $json;
	} else if (!$login->is_logged_in()) {
		$errors = "";
		foreach ($login->errors as $error) {
			$errors = $errors.$error."<br/>";
		}
		$json = "{'status': false, 'error':'Login Error', 'message':".$errors."}";
		echo $json;
	}
?> 