<?php
// register.php - used to register a new client

require_once("config/db_config.php");

require_once("config/activation_config.php");

require_once("classes/class.registrar.php");

$registration = new Registrar($_POST);
if($registration->registered){
	$messages = "";
	foreach($registration->messages as $message){
		$messages = $messages.$message."<br/>";
	}
	echo json_encode(array("status"=> true, "success"=> "Registration Successful", "message"=>$messages));
} else if(!$registration->registered){
$errors
foreach($registration->errors as $error){
		$errors = $errors.$error."<br/>";
	}
	echo json_encode(array("status"=> false, "error"=> "An Error Occurred", "message"=>$errors));
}
?> 