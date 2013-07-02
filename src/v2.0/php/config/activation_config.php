<?php

/**
 * Configuration file for: verification email data
 */

/** absolute URL to register.php, necessary for email verification links */
define("EMAIL_ACTIVATION_URL", "http://jobapp.v2.dev/php/register.php");

define("EMAIL_ACTIVATION_FROM", "noreply@jobapp.foursquaregames.com");
define("EMAIL_ACTIVATION_SUBJECT", "Account Activation for Client Panel Access");
define("EMAIL_ACTIVATION_CONTENT", "Please click on this link to activate your account: ");
?>