<?php

require_once("classes/PhoneManager.php");

require_once("classes/FormManager.php");

require_once("classes/SessionManager.php");

$session = new SessionManager();


if(isset($_POST["phone"])) {

    $phone = $_POST["phone"];

    $phonePattern = "/^[7]{1}([0-3]{1}[0-9]{1})?[0-9]{3}?[0-9]{3}$/";

    $phoneManager = new PhoneManager();

    $formManager = new FormManager();

    if (preg_match($phonePattern, $phone)) {
        if($phoneManager -> register($phone, $session -> get("clickId"))) {
            //send back this form if registration is successful
            echo $formManager -> getCodeForm($phone);
        } else {
            $error = $phoneManager -> getErrors("register");
            if(isset($error) && $error != "" && $error != null) {
                //if something went wrong with the registration display default form with the error
                echo $formManager -> getDefaultForm($error);
            } else {
                echo $formManager -> getDefaultForm(SOMETHINGWENTWRONG);
            }
        }
    } else {
        //wrong pattern
        echo $formManager -> getDefaultForm(ERRORWRONGPATTERN);
    }
} else {
    //when someone tries to access this page
    header(BASEURL);
}


?>
