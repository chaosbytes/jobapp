<?php
// register.php - used to register a new client

require_once "config/db_config.php";

require_once "config/activation_config.php";

require_once "classes/class.registrar.php";

$registration = new Registrar($_POST);
if ($registration->registered) {
	$messages = "";
	foreach ($registration->messages as $message) {
		$messages = $messages.$message."<br/>";
	}
	$json = '{"status": true, "success":"Registration Successful", "message":"'.$messages.'"}';
	echo $json;
} else if (!$registration->registered) {
		$errors = "";
		foreach ($registration->errors as $error) {
			$errors = $errors.$error."<br/>";
		}
		$json = "{'status': false, 'error':'An Error Occurred', 'message':".$errors."}";
		echo $json;
	}
?> 