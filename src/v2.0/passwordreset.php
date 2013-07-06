<?php
session_name("jobapp");
session_start();
$response = json_decode($_SESSION["response"]);


?>

<html>
<head>
  <title>Password Reset</title>
  <link rel="stylesheet" href="./css/main.css" type="text/css">
  <script src="./js/jquery-2.0.2.js">
</script>
  <script src="./js/index.js">
</script>
 <script src="./js/display-modal.js">
</script>
</head>

<body>
  <div id="wrapper">
    <div class="spacer"></div>
		<h3 id="password-reset-header"><?php echo $response->success; ?></h3>	
    <div id="container">
    <div class="spacer"></div>
    
      <div id="password-reset-form">
      	<span id="login-text">Reset Your Password Below:</span>
      	<div class="spacer"></div>
      	<input type="hidden" id="email" value="<?php echo $_SESSION['email']; ?>">
      	<input type="hidden" id="password_reset_hash" value="<?php echo $_SESSION['passsword_reset_hash']; ?>"><br/>
      	<input type="password" id="new_password" placeholder="Password..." class="client-login-input" required><br/>
        <input type="password" id="new_password_confirm" placeholder="Password Confirm..." class="client-login-input" required><br/>
        <input type="submit" id="reset_password_submit" class="client-login-input" value="Reset Password"/>
      </div>
    </div>
  </div>
</body>
</html>
