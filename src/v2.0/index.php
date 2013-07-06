<!DOCTYPE html>

<html>
<head>
  <title></title>
  <link rel="stylesheet" href="./css/main.css" type="text/css">
  <script src="./js/jquery-2.0.2.js">
</script>
<script src="./js/json2.js">
</script>
  <script src="./js/index.js">
</script>
 <script src="./js/display-modal.js">
</script>
</head>

<body>
  <div id="wrapper">
    <div class="spacer"></div>
		<h3 id="client-system-header">Client System</h3>	
    <div id="container">
    <div class="spacer"></div>
    
      <div id="register-form">
      	<span id="registration-text">New Users Register Here:</span>
      	<div class="spacer"></div>
        <input type="text" placeholder="First Name..." id="first_name" class="client-register-input" pattern="[a-zA-Z0-9]{3,25}" required><br/>
        <input type="text" placeholder="Last Name..." id="last_name" class="client-register-input" pattern="[a-zA-Z0-9]{2,25}" required><br/>
        <input type="email" placeholder="Email..." id="email" class="client-register-input" pattern="^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+" required autocomplete="off"><br/>
        <input type="text" placeholder="Zip Code..." id="zip_code" class="client-register-input" pattern="(\d{5}([\-]\d{4})?)"required><br/>
        <input type="password" placeholder="Password..." id="password" class="client-register-input" pattern="[a-zA-Z0-9]{8,}" required><br/>
        <input type="password" placeholder="Confirm Password..." id="password_confirm" class="client-register-input" pattern="[a-zA-Z0-9]{8,}" required><br/>
        <input type="submit" id="register-submit" class="client-register-input" value="Submit"><br/>
      </div>

      <div id="login-form">
      	<span id="login-text">Returning Users Login Here:</span>
      	<div class="spacer"></div>
        <input type="text" id="client_email" placeholder="Username..." class="client-login-input" required><br/>
        <input type="password" id="client_password" placeholder="Password..." class="client-login-input" required><br/>
        <input type="submit" id="client_login_submit" class="client-login-input" value="Login"/>
      </div>
    </div>
  </div>
</body>
</html>
