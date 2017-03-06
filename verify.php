<?php

require_once("classes/PhoneManager.php");

require_once("classes/FormManager.php");

require_once("classes/MailMan.php");

require_once("classes/SessionManager.php");

$session = new SessionManager();

$phonePattern = "/^[7]{1}([0-3]{1}[0-9]{1})?[0-9]{3}?[0-9]{3}$/";

$codePattern = "/^[0-9]{1,6}$/";

if(isset($_POST["code"]) && isset($_POST["phone"])) {

    //might be a bot bruteforcing its way
    $code = $_POST["code"];
    $phone = $_POST["phone"];

    if (preg_match($codePattern, $code) && preg_match($phonePattern, $phone)) {

        $phoneManager = new PhoneManager();

        if ($session -> get("verifyCount") < 3) {

            if($phoneManager -> verifyNumber($code,$phone)) {
                    //number is verified and user is authentic
                echo '<h1>Thank you for <span class="special">Joining!</span></h1>';
                //at this point we're sending data to you
                $mailMan = new MailMan();
                $mailMan -> sendData($phone, $session -> get("clickId"));
            }

            else {

                if($session -> get("verifyCount") == null) {
                    $verifyCount = 0;
                    $session -> set("verifyCount",$verifyCount);
                }

                else {
                    $verifyCount = $session -> get("verifyCount");
                    $verifyCount += 1;
                    $session -> set("verifyCount",$verifyCount);
                }

                //the verification has failed for a reason known by error
                $error = $phoneManager -> getErrors("verify");
                if(isset($error) && $error != "" && $error != null) {
                    $formManager = new FormManager();
                    echo $formManager -> getCodeForm($phone, $error);
                }

                else {
                    $formManager = new FormManager();
                    echo $formManager -> getCodeForm($phone, SOMETHINGWENTWRONG);
                }
            }
        }

        else {
            echo "you have exceeded the maximum number of verify attempts";
        }
    }

    else {
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
