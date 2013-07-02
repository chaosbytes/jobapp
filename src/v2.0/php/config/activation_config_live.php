<?php

/**
 * Configuration file for: verification email data
 */

/** absolute URL to register.php, necessary for email verification links */
define("EMAIL_VERIFICATION_URL", "http://jobapp.v2.foursquaregames.com/php/register.php");

define("EMAIL_VERIFICATION_FROM", "noreply@jobapp.foursquaregames.com");
define("EMAIL_VERIFICATION_SUBJECT", "Account Activation for Client Panel");
define("EMAIL_VERIFICATION_CONTENT", "Please click on this link to activate your account: ");
?>