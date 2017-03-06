
<?php


require_once("classes/SessionManager.php");

$session = new SessionManager();

if(isset($_GET["click_id"])) {
    $clickId = $_GET["click_id"];
    if(empty($session -> get("clickId"))) {
        $session -> set("clickId",$clickId);
    }
    else {
        $clickId = $session -> get("clickId");
    }
} else {
    $clickId = CLICKFALLBACKVALUE;
    if(empty($session -> get("clickId"))) {
        $session -> set("clickId",$clickId);
    } else {
        $clickId = $session -> get("clickId");
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Goma Lotto Promo</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href = "./assets/css/external/bootstrap.css">
        <link rel="stylesheet" href = "./assets/css/external/animate.css">
        <link rel="stylesheet" href = "./assets/css/style.css">
    </head>
    <body>
        <div class="pre-loader">
            <div class="loader-container">
                <div class="spinner">
                    <div class="cube1"></div>
                    <div class="cube2"></div>
                </div>
                <p class="text-center">Awesome take a while to load...</p>
            </div>
        </div>

        <div class="header">
            <div class="container-fluid">
                <div class="logo">
                    <img src="assets/images/logo.png" class = "img-fluid" alt="">
                </div>
                <div class="age">
                    <h1 class="float-right">18+</h1>
                </div>
            </div>
        </div>

        <div class="hero">
            <div class="overlay"></div>
            <div class="left"></div>
            <div class="right">

                <div class="action-container">
                    <h1 class="hero-text">Win <span class="special">300x</span> your bet amount every <span class="special-blue">30 minutes</span></h1>
                    <div class="form-container">
                        <form id="default-form" class="container-fluid">
                            <div class="row">
                                <div class="lab">
                                    <span>Phone Number:</span>
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
                    </div>
                </div>
            </div>

            <footer class="text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-sm-12">
                            <a href="#">Terms & Conditions</a>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-sm-12">
                            <a href="#">BCLB 1105</a>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-sm-12">
                            <a href="http://smalldevelopers.co.ke" target="_blank">Web Design: Small Developers</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>


    </body>
    <script type="text/javascript" src="./assets/js/external/jquery.js"></script>
    <script type="text/javascript" src="./assets/js/external/tether.js"></script>
    <script type="text/javascript" src="./assets/js/external/bootstrap.js"></script>
    <script type="text/javascript" src="./assets/js/app.js"></script>
</html>


<!-- <div class="form-container">
    <form id="verify-form" class="container-fluid">
            <div class="row">
                <div class="lab">
                    <span><span class="sent-msg">We've sent a sms verification your way.</span>

                <span>Haven't received an sms?</span>
                <input type="hidden" name="phone-resend" id="phone-resend" value="700110590">
                <input type="submit" name="" class="resend-button" style="
                display: inline;
                background-color: transparent;
                font-size: 1rem;
                border: none;
                color: #fff;
                border-bottom: 1px solid white;
                cursor: pointer;
                " value="Resend SMS">
                <i class="fa fa-paper-plane" aria-hidden="true"></i>
            </span>
                </div>
            </div>
        </form>
            <div class="row">
                <div class="number-container">
                    <input type="text" autocomplete="off" class="form-control form-control-lg code-input" name="code" id="code" pattern="^[0-9]{1,6}$" title="6 digit code: eg 123456" required="" placeholder="000000">
                </div>
            </div>
            <div class="row">
                <div class="form-group submit-container">
                    <input type="submit" class="btn btn-primary" name="" value="Verify Code">
                </div>
            </div>
        </div> -->
