<?php

require_once("Constants.php");

class FormManager
{
    public function getCodeForm($phone, $msg = null) {
        if($msg == null) {
            $msg =
            "<form id = 'resend-sms'>
                <p>Haven't received an sms?</p>
                <input type='hidden' name='phone-resend' id='phone-resend' value={$phone}>
                <input type='submit' name='' value='Resend SMS'>
            </form>
            ";
        }
        $formString =
        "
        <div>
            {$msg}
        </div>
        <form id='code-verify'>
            We've sent you a validation code via text
            <input type='text' name='code' id='code' pattern='^[0-9]{1,6}$' title = '6 digit code: eg 123456' required placeholder='000000'>
            <input type='hidden' name='phone' id='phone' value={$phone}>
            <input type='submit' name='' value='submit'>
        </form>
        ";
        return trim($formString);
    }

    public function getDefaultForm($msg) {
        $formString =
        "
        <div class='msg'>{$msg}</div>
        <form id='main-form'>
            <span>+254 </span> <input type='text' name='phone' pattern='^[7]{1}([0-3]{1}[0-9]{1})?[0-9]{3}?[0-9]{3}$' title='E.g 712345678' id='phone' required placeholder='712345678'>
            <input type='submit' name='' value='submit'>
        </form>
        ";

        return trim($formString);
    }
}



?>
