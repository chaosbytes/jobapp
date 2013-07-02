<?php

/**
 * Configuration file for: password reset email data
 */

/** absolute URL to register.php, necessary for email password reset links */
define("EMAIL_PASSWORDRESET_URL", "http://jobapp.v2.dev/php/password_reset.php");

define("EMAIL_PASSWORDRESET_FROM", "noreply@jobapp.foursquaregames.com");
define("EMAIL_PASSWORDRESET_SUBJECT", "Password reset for Client Panel");
define("EMAIL_PASSWORDRESET_CONTENT", "Please click on this link to reset your password: ");
?>