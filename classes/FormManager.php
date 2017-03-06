<?php

require_once("Constants.php");

class FormManager
{
    public function getCodeForm($phone, $msg = null) {
        if($msg == null) {
            $msg =
            "

            <form id ='resend-sms'>
                <span>We've sent a verification sms your way.</span><span> Haven't received an sms?</span>
                <input type='hidden' name='phone-resend' id='phone-resend' value={$phone}>
                <input type='submit' name='' class = 'resend-button' style = '
                display: inline;
                background-color: transparent;
                font-size: 1rem;
                border: none;
                color: #fff;
                border-bottom: 1px solid white;
                cursor: pointer;
                'value='Resend SMS'>
                <i class='fa fa-paper-plane' aria-hidden='true'></i>
            </form>

            ";
        }
        $formString =
        '
            <div class="row">
                <div class="lab container-fluid">
                    <span class="sent-msg">
                    '.$msg.'
                    </span>
                </div>
            </div>
            <form id="verify-form" class="container-fluid">
            <div class="row">
                <div class="number-container">
                    <input type="text" autocomplete ="off" class = "form-control form-control-lg code-input" name="code" id="code" pattern="^[0-9]{1,6}$" title = "6 digit code: eg 123456" required placeholder="000000">
                </div>
            </div>
            <input type="hidden" name="phone" id="phone" value='.$phone.'>
            <div class="row">
                <div class="form-group submit-container">
                    <input type="submit" class="btn btn-primary" name="" value="Verify Code">
                </div>
            </div>
        </form>
        ';
        return trim($formString);
    }

    public function getDefaultForm($msg) {
        $formString =
        '
        <form id="default-form" class="container-fluid">
            <div class="row">
                <div class="lab">
                    <span>'.$msg.'</span>
                </div>
            </div>
            <div class="row">
                <div class="number-container">
                    <div class="prefix-number">
                        <span>+254</span>
                    </div>
                    <input type="text" autocomplete ="off" class = "form-control form-control-lg" name="phone"  id="phone" pattern="^[7]{1}([0-3]{1}[0-9]{1})?[0-9]{3}?[0-9]{3}$" title="E.g 712345678" required placeholder="712345678" value="">
                </div>
            </div>
            <div class="row">
                <div class="form-group submit-container">
                    <input type="submit" class="btn btn-primary" name="" value="Join">
                </div>
            </div>
        </form>
        ';

        return trim($formString);
    }
}



?>
