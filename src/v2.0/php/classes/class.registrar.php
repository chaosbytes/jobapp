<?php

/**
 * class Registrar
 * handles the client registration
 *
 */

require_once "scrypt.php";

class Registrar {

	private $link = null;
	private $first_name = "";
	private $last_name = "";
	private $email = "";
	private $zip_code = "";
	private $password = "";
	private $password_hash = "";
	private $password_salt = "";
	private $activation_hash = "";

	public $errors = array();
	public $messages = array();

	public $registered = false;

	private $post = array();

	public function __construct($_post) {
		if ($_post) {
			$this->post = $_post;
			if (isset($this->post["register"])) {
				$this->registerNewClient();
			}
		} else if (isset($_GET["email"]) && isset($_GET["activation_code"])) {
				$this->activateNewClient();
			}
	}

	private function registerNewClient() {
		if (empty($this->post['first_name'])) {
			$this->errors[] = "First Name Field Empty";
		} else if (empty($this->post['last_name'])) {
			$this->errors[] = "Last Name Field Empty";
		} else if (empty($this->post['email'])) {
			$this->errors[] = "Email Field Empty";
		} else if (strlen($this->post['email']) > 96) {
			$this->errors[] = "Email cannot be longer than 96 characters";
		} else if (!filter_var($this->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->errors[] = "Your email address is not in a valid email format";
		} else if (empty($this->post['zip_code'])) {
			$this->errors[] = "Zip Code Field Empty";
		} else if (!preg_match('/(\d{5}([\-]\d{4})?)/', $this->post['zip_code'])) {
			$this->errors[] = "Invalid Zip Code Format";
		} else if (empty($this->post['password']) || empty($this->post['password_confirm'])) {
			$this->errors[] = "Password Field Empty";
		} else if ($this->post['password'] !== $this->post['password_confirm']) {
			$this->errors[] = "Passwords Do Not Match";
		} else if (strlen($this->post['password']) < 6) {
			$this->errors[] = "Password must be a minimum length of 6 characters";
		} else if (!empty($this->post['first_name'])
			&& !empty($this->post['last_name'])
			&& !empty($this->post['email'])
			&& strlen($this->post['email']) <= 96
			&& filter_var($this->post['email'], FILTER_VALIDATE_EMAIL)
			&& !empty($this->post['zip_code'])
			&& preg_match('/(\d{5}([\-]\d{4})?)/', $this->post['zip_code'])
			&& !empty($this->post['password'])
			&& !empty($this->post['password_confirm'])
			&& ($this->post['password'] === $this->post['password_confirm'])) {

			$this->link = new mysqli(HOSTNAME, DB_USER, DB_USER_PASS, DATABASE);

			// if no connection errors (= working database connection)
			if (!$this->link->connect_errno) {
				//escape all user input
				$this->first_name =  $this->link->real_escape_string(htmlentities($this->post['first_name'], ENT_QUOTES));
				$this->last_name =  $this->link->real_escape_string(htmlentities($this->post['last_name'], ENT_QUOTES));
				$this->email =  $this->link->real_escape_string(htmlentities($this->post['email'], ENT_QUOTES));
				$this->zip_code =  $this->link->real_escape_string(htmlentities($this->post['zip_code'], ENT_QUOTES));
				$this->password =  $this->link->real_escape_string(htmlentities($this->post['password'], ENT_QUOTES));

				/* hash the password using CRYPT_SHA512, with a 16 character salt created using a base64 encoded value from mcrypt_create_iv and MCRYPT_DEV_URANDOM,
				instead of md5 as md5 is no longer a secure method for hashing passwords. for more info see: http://www.php.net/manual/en/faq.passwords.php#faq.passwords.fasthash

				uses 10,000 rounds of hashing to be more secure than the standard 5000 rounds
				*/

				$this->password_salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
				$this->password_hash = crypt($this->password, '$6$rounds=10000$'.$this->password_salt.'$');

				// create an activation hash for email verification
				$this->activation_hash = sha1(uniqid(mt_rand(), true));

				$query_email = $this->link->query("SELECT * FROM clients WHERE email='".$this->email."';");
				if ($query_email->num_rows == 1) {
					$this->errors[] = "There is already a user registered with those credentials, if you have already registered please use the login form.";
				} else {
					$this->insertNewClient($this->link, $this->email, $this->first_name, $this->last_name, $this->zip_code, $this->password_salt, $this->password_hash, $this->activation_hash);
				}
			} else {
				$this->errors[] = "Sorry, no database connection.";
			}
		} else {
			$this->errors[] = "An unknown error occurred.";
		}
	}

	private function insertNewClient($_link, $_email, $_first_name, $_last_name, $_zip_code, $_password_salt, $_password_hash, $_activation_hash) {
		$insert_query = $_link->query("INSERT INTO clients (email, first_name, last_name, zip_code, password_salt, password_hash, activation_hash) VALUES ('".$_email."', '".$_first_name."', '".$_last_name."', '".$_zip_code."', '".$_password_salt."', '".$_password_hash."', '".$_activation_hash."');");
		if ($_link->affected_rows == 1) {
			if ($this->sendActivationEmail()) {
				$this->messages[] = "Your client account has been created successfully. You have been sent an activation email, click the link within that email to activate your account and login.";
				$this->registered = true;
			} else {
				$this->link->query("DELETE FROM clients WHERE id='".$this->link->insert_id."';");
				$this->errors[] = "Activation email could not be sent, your client account has not been created.";
			}
		} else {
			$this->errors[] = "There was an error during registration, please try again.";
		}
	}

	private function sendActivationEmail() {
		$to      = $this->email;
		$subject = EMAIL_ACTIVATION_SUBJECT;
		$activation_link    = EMAIL_ACTIVATION_URL.'?email='.urlencode($this->email).'&activation_code='.urlencode($this->activation_hash);
		$body = EMAIL_ACTIVATION_CONTENT.'<a href="'.$activation_link.'">'.$activation_link.'</a>';

		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header .= 'From: '.EMAIL_ACTIVATION_FROM."\r\n";

		if (mail($to, $subject, $body, $header)) {

			$this->messages[] = "Verification Mail successfully sent!";
			return true;

		} else {

			$this->errors[] = "Verification Mail NOT successfully sent!";
			return false;

		}
	}

	private function activateNewClient() {
		$this->link = new mysqli(HOSTNAME, DB_USER, DB_USER_PASS, DATABASE);
		// if no connection errors (= working database connection)
		if (!$this->link->connect_errno) {
			$this->email = $this->link->real_escape_string($_GET['email']);
			$this->activation_hash = $this->link->real_escape_string($_GET['activation_code']);
			$this->link->query('UPDATE clients SET activation_hash = NULL, activated = 1 WHERE email= "'.$this->email.'" AND activation_hash= "'.$this->activation_hash.'";');
			if ($this->link->affected_rows > 0) {
				$this->registered = true;
				$this->messages[] = "Activation was successful! You can now log in!";
			} else {
				$this->errors[] = "Sorry, no such email/activation code combination here...";
			}
		} else {
			$this->errors[] = "Sorry, no database connection.";
		}
	}
}
?>