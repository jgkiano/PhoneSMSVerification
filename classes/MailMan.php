<?php

require_once("Master.php");

class MailMan extends Master
{
    private $conn;

	function __construct() {
		$this -> conn = $this -> getConnection();
	}

    public function sendData($phone, $clickId) {
        $data = array('phone' => $phone, 'click_id' => $clickId, 'skey' => SKEY);
        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ));
        $context  = stream_context_create($options);
        $result = file_get_contents(REMOTEURL, false, $context);
        if($result == "true" || "false") {
            $this -> storeSend($phone, $clickId);
        } else {
            $this -> storeSend($phone, $clickId);
        }
    }

    private function storeSend($phone, $clickId) {
        //we store all data sent for record purposes
        $query = "INSERT INTO sentphones (phone,clickId) VALUES (:phone,:clickId)";
        try {
			$stmt = $this -> conn -> prepare($query);
            $stmt -> execute([
                "phone" => $phone,
                "clickId" => $clickId
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
