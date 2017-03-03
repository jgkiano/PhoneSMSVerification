<?php

require_once("Master.php");

class MailMan extends Master
{
    private $conn;

	function __construct() {
		$this -> conn = $this -> getConnection();
	}

    public function sendData($phone) {
        $data = array('phone' => $phone, 'skey' => SKEY);
        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ));
        $context  = stream_context_create($options);
        $result = file_get_contents(REMOTEURL, false, $context);
        var_dump($result);
        if($result == "true" || "false") {
            $this -> storeSend($phone);
        } else {
            $this -> storeSend($phone);
        }
    }

    private function storeSend($phone) {
        //we store all data sent for record purposes
        $query = "INSERT INTO sentphones (phone) VALUES (:phone)";
        try {
			$stmt = $this -> conn -> prepare($query);
            $stmt -> execute([
                "phone" => $phone
            ]);
			if($stmt -> rowCount() == 1) {
                return true;
            } else {
                return false;
            }
		} catch (PDOException $e) {
            return false;
		}
    }
}


?>
