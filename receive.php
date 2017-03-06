<?php

// THIS IS DEMO CODE OF HOW TO HANDLE OUR RESPONSE

//YOU WLL RECEIVE TWO PARAMETERS "skey" and "phone" the skey is  the secrect key so that you know the post is from us.
//The phone is the verified phone number

if(isset($_POST["skey"]) && $_POST["phone"] && $_POST["click_id"]) {

    $clickId = $_POST["click_id"];

    $phone = $_POST["phone"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gomaLottoPromo";
    $receivedSkey = $_POST["skey"];
    $skey = "MbCjEfKCHg7DcpRDPHpQ7K5zsucby8hR7ENEPfF4j9";

    //if the skey received is the same as the one you have
    if($receivedSkey == $skey) {
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "INSERT INTO receive (phone,clickId) VALUES ('$phone','$clickId')";
        if ($conn->query($sql) === TRUE) {
            //please make sure to give us a response if you are able to upadte your db
            echo "true";
        } else {
            echo "false";
        }
        $conn->close();
    } else {
        //handle this
    }


}




?>
