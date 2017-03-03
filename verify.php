<?php

require_once("classes/PhoneManager.php");

require_once("classes/FormManager.php");

require_once("classes/MailMan.php");

$phonePattern = "/^[7]{1}([0-3]{1}[0-9]{1})?[0-9]{3}?[0-9]{3}$/";

$codePattern = "/^[0-9]{1,6}$/";

if(isset($_POST["code"]) && isset($_POST["phone"])) {
    $code = $_POST["code"];
    $phone = $_POST["phone"];
    if (preg_match($codePattern, $code) && preg_match($phonePattern, $phone)) {
        $phoneManager = new PhoneManager();
        if($phoneManager -> verifyNumber($code,$phone)) {
            //number is verified and user is authentic
            echo "woohoo";
            //at this point we're sending data to you
            $mailMan = new MailMan();
            $mailMan -> sendData($phone);
        } else {
            //the verification has failed for a reason known by error
            $error = $phoneManager -> getErrors("verify");
            if(isset($error) && $error != "" && $error != null) {
                $formManager = new FormManager();
                echo $formManager -> getCodeForm($phone, $error);
            } else {
                $formManager = new FormManager();
                echo $formManager -> getCodeForm($phone, SOMETHINGWENTWRONG);
            }
        }
    } else {
        //you cannot post request a wrong pattern something fishy is going on
        header(BASEURL);
    }
}

if(isset($_POST["phone-resend"])) {
    $phone = $_POST["phone-resend"];
    if (preg_match($phonePattern, $phone)) {
        $phoneManager = new PhoneManager();
        if ($phoneManager -> resendSMS($phone)) {
            $formManager = new FormManager();
            echo $formManager -> getCodeForm($phone, RESENDSUCCESS);
        }
    }
}


?>
