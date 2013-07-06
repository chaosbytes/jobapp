<?php

/*
* Login class to handle all login/out functions
*/

require_once "password.php";

class Login {

	private $link = null;
	private $id = null;
	private $email = "";
	private $password = "";
	private $password_hash = "";
	private $logged_in = false;
	private $logged_out = false;
	private $password_reset_hash = "";
	private $post = array();
	public $get = array();

	private $new_password = "";
	private $new_password_confirm = "";
	private $new_password_hash = "";

	public $messages = array();
	public $errors = array();

	private $password_reset_successful = false;
	private $reset_token_created = false;
	private $valid_reset_token = false;


	public function __construct($post, $get) {

		if ($post) {
			$this->post = $post;
		}
		if ($get) {
			$this->get = $get;
		}
		if (isset($this->post['logout'])) {
			$this->logoutUser();
		} else if (isset($_POST['autologin'])) {
				$this->autologin();
			} else if (isset($_SESSION['email']) && $_SESSION['admin_logged_in'] == 1) {
				$this->loginWithSession();
			} else if (isset($this->post['client_login'])) {
				$this->loginClientWithPost();
			} else if (isset($this->post['admin_login'])) {
				$this->loginAdminWithPost();
			} else if (isset($this->post['reset_password_request'])) {
				$this->requestPasswordReset();
			} else if (isset($this->get['email']) && isset($this->get['reset_code'])) {
				$this->verifyResetCode();
			} else if (isset($this->post['set_new_password'])) {
				$this->setNewPassword();
			}
	}

	private function autologin() {
		session_name("jobapp");
		session_start();
		// if username and passwordhash are set in $_SESSION array
		if (isset($_SESSION['admin_logged_in'])) {
			$this->loginWithSession();
		}
	}

	private function logoutUser() {
		session_name("jobapp");
		session_start();
		$_SESSION = array();
		session_destroy();
		$this->logged_in = false;
		$this->logged_out = true;
		$this->messages[] = "You have been logged out.";
	}

	private function loginWithSession() {
		session_name("jobapp");
		session_start();
		$_SESSION['admin_logged_in'] = 1;
		$this->logged_in = true;
		$this->messages[] = "You have been logged in.";
	}

	private function loginClientWithPost() {
		if (isset($this->post['email']) && isset($this->post['password'])) {
			$this->link = new mysqli(HOSTNAME, DB_USER, DB_USER_PASS, DATABASE);
			if (!$this->link->connect_errno) {
				$this->email = $this->link->real_escape_string($this->post['email']);
				$this->password = $this->link->real_escape_string($this->post['password']);
				$checkClient = $this->link->query("SELECT id, email, first_name, last_name, activated, password_hash FROM clients WHERE email='".$this->email."';");
				if ($checkClient->num_rows == 1) {
					$client = $checkClient->fetch_object();
					if (password_verify($this->password, $client->password_hash)) {
						if ($client->activated == 1) {
							session_name("jobapp");
							session_start();
							$_SESSION['client_id'] = $client->id;
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
		} else if (!isset($this->post['email'])) {
				$this->errors[] = "Client email cannot be left blank.";
			} else if (!isset($this->post['password'])) {
				$this->errors[] = "Client password cannot be left blank.";
			}
	}

	private function loginAdminWithPost() {
		if (isset($this->post['email']) && isset($this->post['password'])) {
			$this->link = new mysqli(HOSTNAME, DB_USER, DB_USER_PASS, DATABASE);
			if (!$this->link->connect_errno) {
				$this->email = $this->link->real_escape_string($this->post['email']);
				$this->password = $this->link->real_escape_string($this->post['password']);
				$checkAdmin = $this->link->query("SELECT id, email, password_hash FROM admins WHERE email='".$this->email."';");
				if ($checkAdmin->num_rows == 1) {
					$admin = $checkAdmin->fetch_object();
					if (password_verify($this->password, $admin->password_hash)) {
						session_name("jobapp");
						session_set_cookie_params(60*60*24);
						session_start();
						$_SESSION['admin_id'] = $admin->id;
						$_SESSION['email'] = $admin->email;
						$_SESSION['admin_logged_in'] = 1;

						$this->id = $admin->id;
						$this->logged_in = true;
						$this->messages[] = "You have been logged in.";
					} else {
						$this->errors[] = "Incorrect password. Please try again.";
					}
				} else {
					$this->errors[] = "That admin email address does not exist in our system. Please contact your systems administrator for access.";
				}
			} else {
				$this->errors[] = "No Database Connection.";
			}
		} else if (!isset($this->post['email'])) {
				$this->errors[] = "Admin email cannot be left blank.";
			} else if (!isset($this->post['password'])) {
				$this->errors[] = "Amdin password cannot be left blank.";
			}
	}

	public function requestPasswordReset() {
		if (isset($this->post['email'])) {
			$timestamp = time();

			// generate random hash for email password reset verification (40 char string)
			$this->password_reset_hash = sha1(uniqid(mt_rand(), true));

			$this->link = new mysqli(HOSTNAME, DB_USER, DB_USER_PASS, DATABASE);

			// if no connection errors (= working database connection)
			if (!$this->link->connect_errno) {

				$this->email = $this->link->real_escape_string(htmlentities($this->post['email'], ENT_QUOTES));
				$queryClientData = $this->link->query("SELECT * FROM clients WHERE email = '".$this->email."';");
				if ($queryClientData->num_rows == 1) {
					$client = $queryClientData->fetch_object();
					$this->link->query("UPDATE clients SET password_reset_hash = '".$this->password_reset_hash."', password_reset_timestamp = '".$timestamp."' WHERE email = '".$this->email."';");
					if ($this->link->affected_rows == 1) {
						$this->reset_token_created = true;
						$this->messages[] = "Reset token created successfully.";
						if ($this-> sendPasswordResetEmail()) {
							return true;
						} else {
							$this->link->query("UPDATE clients SET password_reset_hash = NULL, password_reset_timestamp = NULL WHERE email = '".$this->email."';");
							$this->errors[] = "There was an error. At this time we can not process your password reset request.";
							return false;
						}
					} else {
						$this->errors[] = "Could not write token to database.";
					}
				} else {
					$this->errors[] = "This user does not exist.";
				}
			} else {
				$this->errors[] = "Database connection problem.";
			}
		} else {
			$this->errors[] = "Email Address cannot be empty.";
		}
		return false;
	}

	private function sendPasswordResetEmail() {
		$to      = $this->email;
		$subject = EMAIL_PASSWORDRESET_SUBJECT;

		$link    = EMAIL_PASSWORDRESET_URL.'?email='.urlencode($this->email).'&reset_code='.urlencode($this->password_reset_hash);
		$body = EMAIL_PASSWORDRESET_CONTENT.' <a href="'.$link.'">'.$link.'</a>';

		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header .= 'From: '.EMAIL_PASSWORDRESET_FROM."\r\n";

		if (mail($to, $subject, $body, $header)) {

			$this->messages[] = "Password reset mail successfully sent!";
			return true;

		} else {

			$this->errors[] = "Password reset mail NOT successfully sent!";
			return false;

		}
	}

	public function verifyResetCode() {
		if (isset($this->get['email']) && isset($this->get['reset_code'])) {
			$this->link = new mysqli(HOSTNAME, DB_USER, DB_USER_PASS, DATABASE);

			if (!$this->link->connect_errno) {
				$this->email = $this->link->real_escape_string(htmlentities($this->get['email'], ENT_QUOTES));
				$this->password_reset_hash = $this->link->real_escape_string(htmlentities($this->get['reset_code'], ENT_QUOTES));

				$queryClientData = $this->link->query("SELECT password_reset_timestamp FROM clients WHERE email='".$this->email."' AND password_reset_hash='".$this->password_reset_hash."';");

				if ($queryClientData->num_rows == 1) {
					$client = $queryClientData->fetch_object();

					$timestamp_minus_one_hour = time() - 3600;
					
					if ($client->password_reset_timestamp > $timestamp_minus_one_hour) {
						$this->valid_reset_token = true;
						$this->messages[] = "Your reset code is valid, you may now reset your password.";
						session_name("jobapp");
						session_start();
						$_SESSION['email'] = $this->email;
						$_SESSION['password_reset_hash'] = $this->password_reset_hash;
						
					} else {
						$this->errors[] = "Reset link is no longer valid. You must use the link within one hour of your request. Please request another reset link.";
					}
				} else {
					$this->errors[] = "User email is invalid.";
				}
			} else {
				$this->errors[] = "No database connection.";
			}
		} else {
			$this->errors[] = "You are attempting to use and invalid reset link.";
		}
	}

	public function setNewPassword() {
		if (isset($this->post['email']) && isset($this->post['password_reset_hash']) && isset($this->post['new_password']) && isset($this->post['new_password_confirm'])) {
			$this->link = new mysqli(HOSTNAME, DB_USER, DB_USER_PASS, DATABASE);
			if (strlen($this->post['new_password']) >= 8) {
				if ($this->post['new_password'] == $this->post['new_password_confirm']) {
					if (!$this->link->connect_errno) {
						$this->email = $this->link->real_escape_string(htmlentities($this->post['email'], ENT_QUOTES));
						$this->new_password = $this->link->real_escape_string(htmlentities($this->post['new_password'], ENT_QUOTES));
						$this->new_password_confirm = $this->link->real_escape_string(htmlentities($this->post['new_password_confirm'], ENT_QUOTES));
						$this->new_password_hash = password_hash($this->new_password, PASSWORD_BCRYPT);

						$this->link->query("UPDATE clients SET password_hash='".$this->new_password_hash."', password_reset_hash = NULL, password_reset_timestamp = NULL WHERE email='".$this->email."' AND password_reset_hash='".$this->password_reset_hash."';");
						if ($this->link->affected_rows == 1) {
							$this->password_reset_successful = true;
							$this->messages[] = "Your password has been successfully changed.";
						} else {
							$this->errors[] = "An error occured trying to reset you password.";
						}
					} else {
						$this->errors[] = "No database connection.";
					}
				} else {
					$this->errors[] = "New passwords must match, try again.";
				}
			} else {
				$this->errors[] = "Your new password must be greater than or equal to 8 characters.";
			}
		} else {
			$this->errors[] = "All password reset form fields are required. please try again.";
		}
	}

	public function is_logged_in() {
		return $this->logged_in;
	}

	public function is_logged_out() {
		return $this->logged_out;
	}

	public function is_reset_token_created() {
		return $this->reset_token_created;
	}
	public function is_valid_reset_token() {
		return $this->valid_reset_token;
	}
}
?>
