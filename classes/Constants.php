<?php

//database stuff
define("SERVER","localhost");

define("DB","gomaLottoPromo");

define("USER","root");

define("PASSWORD","");

//twilio creds

define("TWILIOACCOUNTSID","AC4094526ea3d55d1897716cf153d2a7d4");

define("TWILIOAUTHTOKEN","672dad78d406889ca194bb97b2b6a9cf");

define("TWILIOPHONENUMBER","+18036104040");

//Messages

define("MSGINTRO","Goma Lotto Promotion Verification Code\n");

define("ERRORNUMBERREGISTERED","This number has already been registered with Goma Lotto");

define("ERRORSMSSEND","We are having trouble sending an SMS verification, please contact the Goma Lotto or try again later\n");

define("ERRORDB","We are currently unable to complete this operation, please contact the Goma Lotto or try again later");

define("ERRORFAILEDVERIFY","Your phone number and code don't match, please try again");

define("ERRORWRONGPATTERN","Incorrect mobile number pattern. Please enter the correct mobile pattern e.g 712345678");

define("RESENDSUCCESS","We have sent a new confirmation code. If you don't receive it in 10 min please contact Goma Lotto");

define("RESENDFAIL","Something went wrong while sending a new confirmation code. Please contact Goma Lotto");

define("BASEURL","location:http://localhost/gomapromo/");

define("SKEY","MbCjEfKCHg7DcpRDPHpQ7K5zsucby8hR7ENEPfF4j9");

define("REMOTEURL","http://localhost/gomapromo/receive.php");

define("SOMETHINGWENTWRONG","Something went wrong. Please contact Goma Lotto");

//session configs

define('SESSION_USE_ONLY_COOKIES', 1);

define('SESSION_SECURE', false);

define('SESSION_HTTP_ONLY', true);

define('SESSION_REGENERATE_ID', true);

//

define("CLICKFALLBACKVALUE", 9);


?>
