<?php
// register.php - used to register a new client

require_once "config/db_config.php";

require_once "config/password_reset_config.php";

require_once "classes/class.login.php";

$login = new Login($_POST, $_GET);
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
	echo '{"status": true, "success":"'.$user_type.' Login Successful", "message":"'.$messages.'"}';
} else if ($login->is_reset_token_created()) {
		$messages = "";
		foreach ($login->messages as $message) {
			$messages = $messages.$message."<br/>";
		}
		echo '{"status": true, "success":"Reset Request Successful", "message":"'.$messages.'"}';
	} else if ($login->is_valid_reset_token()) {
		$messages = "";
		foreach ($login->messages as $message) {
			$messages = $messages.$message."<br/>";
		}
		session_name("jobapp");
		session_start();
		$_SESSION["response"] = '{"status": true, "success":"Reset Token Validated", "message":"'.$messages.'"}';
		header('Location: http://jobapp.v2.foursquaregames.com/passwordreset') ;
	} else if ($_POST["reset_password_request"] && !$login->is_reset_token_created()) {
		$errors = "";
		foreach ($login->errors as $error) {
			$errors = $errors.$error."<br/>";
		}
		echo "{'status': false, 'error':'Password Reset Request Failed', 'message':".$errors."}";
	} else if ($login->is_logged_out()) {
		$messages = "";
		foreach ($login->messages as $message) {
			$messages = $messages.$message."<br/>";
		}
		echo '{"status": true, "success":"Logout Successful", "message":"'.$messages.'"}';
	} else if (($_POST['client_login'] || $_POST['admin_login']) &&!$login->is_logged_in()) {
		$errors = "";
		foreach ($login->errors as $error) {
			$errors = $errors.$error."<br/>";
		}
		echo "{'status': false, 'error':'Login Error', 'message':".$errors."}";
	}
?> 