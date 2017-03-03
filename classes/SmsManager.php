<?php


require_once("Constants.php");

require_once ("vendor/autoload.php");

class SmsManager
{
    var $client;

    function __construct()
    {
        $this -> client = new Services_Twilio(TWILIOACCOUNTSID, TWILIOAUTHTOKEN);
    }

    public function sendMessage($phone, $body) {
        $response =  $this -> client-> account-> messages-> create(array(
            "From" => TWILIOPHONENUMBER,
            "To" => "+254700110590",
            "Body" => $body));
            if($response -> error_code == null) {
                return true;
            } else {
                return false;
            }
    }
}



?>
