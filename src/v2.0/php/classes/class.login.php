<?php

/*
* Login class to handle all login/out functions
*/

class Login {
	
	private $link = null;
	private $id = null;
	private $email = "";
	private $password_hash = "";
	private $logged_in = false;
	private $password_reset_hash = "";
	private $post = null;
	
	public $messages = array();
	public $errors = array();
	
	public function __construct($_post){
		session_start();
		
		if($_post){
			$this->post = $_post;
		}
		if(isset($_GET['logout'])){
			$this->logoutUser();
		} else if(isset($_SESSION['email']) && ($_SESSION['client_logged_in'] == 1 || $_SESSION['admin_logged_in'] == 1)){
			$this->loginWithSession();
		} else if ($this->post['client_login']){
			$this->loginClientWithPost();
		} else if ($this->post['admin_login']){
			$this->loginAdminWithPost();
		} else if($this->post['reset_password']){
			$this->sendPasswordResetEmail();
		} else if(isset($_GET['email']) && isset($_GET['reset_code'])){
			$this->verifyResetCode();
		} else if($this->post['submit_new_password']){
			$this->setNewPassword();
		}
	}
	
	private function logoutUser(){
		$_SESSION = array();
		session_destroy();
		$this->loged_in = false;
		$this->messages[] = "You have been logged out.";
	}
	
	private function loginWithSession(){
		$this->logged_in = true;
		$this->messages[] = "You have been logged in.";
	}
	
	private function loginClientWithPost(){
		if(isset($this->post['email']) && isset($this->post['password'])){
			$this->link = new mysqli(HOSTNAME, DB_USER, DB_USER_PASS, DATABASE);
			if(!$this->link->connect_errno){
				$this->email = $this->link->real_escape_string($this->post['email']);
				$checkClient = $this->link->query("SELECT id, email, first_name, last_name, activated, password_salt, password_hash FROM clients WHERE email='".$this->email."';");
				if($checkClient->num_rows == 1){
					$client = $checkClient->fetch_object();
					if($client->password_hash == crypt($post->password, $client->password_salt)){
						if($client->activated == 1){
							$_SESSION['id'] = $client->id;
							$_SESSION['email'] = $client->email;
							$_SESSION['first_name'] = $client->first_name;
							$_SESSION['last_name'] = $client->last_name;
							$_SESSION['client_logged_in'] = 1;
							
							$this->id = $client->id;
							$this->logged_in = true;
							$this->messages[] = "You have been logged in.";
						} else {
							$this->errors[] = "Your account has yet to be activated. Please click the activation link in the email sent to you before logging in.";
						}
					} else {
						$this->errors[] = "Incorrect password. Please try again.";
					}
				} else {
					$this->errors[] = "That client email address does not exist in our system. Please try again.";
				}
			} else {
				$this->errors[] = "No Database Connection.";
			} 
		} else if(!isset($this->post['email'])){
			$this->errors[] = "Client email cannot be left blank.";
		} else if(!isset($this->post['password'])){
			$this->errors[] = "Client password cannot be left blank.";
		}
	}
	
	private function loginAdminWithPost(){
		
	}
	
	private function sendPasswordResetEmail(){
		
	}
	
	private function verifyResetCode(){
		
	}
	
	private function setNewPassword(){
		
	}
}
?>
