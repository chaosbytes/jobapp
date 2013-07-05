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
	}
	
	private function loginClientWithPost(){
		
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
