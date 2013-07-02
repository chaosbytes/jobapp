<?php
require "class.phpmailer.php";

function sendMail($toAddress, $toName, $subject, $body){
	$mail = new PHPMailer();
	
	$mail->IsSMTP();
	$mail->Host = "mail.jobapp.foursquaregames.com";
	$mail->SMTPAuth = true;
	$mail->Username = "noreply@jobapp.foursquaregames.com";
	$mail->Password = "aecolomjerice1024!";
	
	$mail->From = "noreply@jobapp.foursquaregames.com";
	$mail->FromName = "Job App";
	$mail->AddAddress($toAddress, $toName);
	
	$mail->WordWrap = 50;
	$mail->Subject = $subject;
	$mail->Body = $body;
	
	if(!$mail->Send()){
		echo json_encode(array("status"=>false, "error"=> $mail->ErrorInfo));
	} else {
		echo json_encode(array("status"=>true ));
	}
}


?>