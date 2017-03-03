<?php

require_once("Master.php");

require_once("SmsManager.php");

class PhoneManager extends Master
{
    private $conn;

	function __construct() {
		$this -> conn = $this -> getConnection();
	}

    private $errors;

    public function register($phone) {
        //if phone number exists
        if($this -> phoneNumberExists($phone)) {
            $this -> errors["register"] = ERRORNUMBERREGISTERED;
            return false;
        } else {
            //generate sms verification code
            $code = $this -> generateRandomCode();
            //if inserting into our db is successful
            if($this -> insertNumber($phone, $code)) {
                //check if sms send is okay
                // $this -> prepareSMS($phone, $code)
                if($this -> prepareSMS($phone, $code)) {
                    //store the number in the session
                    return true;
                } else {
                    $this -> errors["register"] = ERRORSMSSEND;
                    return false;
                }
            } else {
                $this -> errors["register"] = ERRORDB;
                return false;
            }
        }
    }

    public function resendSMS($phone) {
        $query = "UPDATE phones SET phone_verification_code = :phone_verification_code WHERE phone_number = :phone_number AND phone_valid = :phone_valid";
        $verCode = $this -> generateRandomCode();
        try {
            $stmt = $this -> conn -> prepare($query);
            $stmt -> execute([
                "phone_verification_code" => $verCode,
                "phone_number" => $phone,
                "phone_valid" => 0
            ]);
            if($stmt -> rowCount() == 1) {
                return $this -> prepareSMS($phone, $verCode);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function verifyNumber($code,$phone) {
        if(!isset($phone) || !isset($code)) {
            $this -> errors["verify"] = ERRORFAILEDVERIFY;
            return false;
        } else if ($this -> codeMatch($phone,$code)) {
            $query = "UPDATE phones SET phone_valid = :phone_valid WHERE phone_number = :phone_number";
            try {
    			$stmt = $this -> conn -> prepare($query);
                $stmt -> execute([
                    "phone_valid" => 1,
                    "phone_number" => $phone
                ]);
    			if($stmt -> rowCount() == 1) {
                    return true;
                } else {
                    return false;
                }
    		} catch (PDOException $e) {
                return false;
    		}
        } else {
            $this -> errors["verify"] = ERRORFAILEDVERIFY;
            return false;
        }
    }

    public function codeMatch($phone,$code) {
        $query = "SELECT * FROM phones WHERE phone_number = :phone_number AND phone_verification_code = :phone_verification_code AND phone_valid = :phone_valid";
        try {
            $stmt = $this -> conn -> prepare($query);
            $stmt -> execute([
                "phone_number" => $phone,
                "phone_verification_code" => $code,
                "phone_valid" => 0
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

    public function insertNumber($phone,$code) {
        $query = "INSERT INTO phones (
            phone_id,
            phone_number,
            phone_verification_code,
            phone_code_timestamp
        ) VALUES (
            :phone_id,
            :phone_number,
            :phone_verification_code,
            :phone_code_timestamp
        )";
        try {
			$stmt = $this -> conn -> prepare($query);
            $stmt -> execute([
                "phone_id" => $this -> generatePhoneId($phone),
                "phone_number" => $phone,
                "phone_verification_code" => $code,
                "phone_code_timestamp" => date("Y-m-d H:i:s")
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

    private function prepareSMS($phone, $code) {
        $smsMan = new SmsManager();
        return $smsMan -> sendMessage($phone, MSGINTRO.$code);
    }

    private function phoneNumberExists($phone) {
        $query = "SELECT * FROM phones WHERE phone_number = :phone_number";
        try {
			$stmt = $this -> conn -> prepare($query);
            $stmt -> execute(["phone_number" => $phone]);
			if($stmt -> rowCount() == 1) {
                $row = $stmt->fetch();
                //this means user registered but didn't confirm so we just
                //delete the previous registration
                if($row["phone_valid"] == 0) {
                    if($this -> deleteNumber($row["phone_number"])) {
                        return false;
                    }
                }
                //number exists and is confirmed
                if($row["phone_valid"] == 1) {
                    return true;
                }
            } else {
                return false;
            }
		} catch (PDOException $e) {
            return true;
		}
    }

    private function deleteNumber($phone) {
        $query = "DELETE FROM phones WHERE phone_number = :phone_number";
        try {
            $stmt = $this -> conn -> prepare($query);
            $stmt -> execute(["phone_number" => $phone]);
			if($stmt -> rowCount() == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e;
			die();
		}
    }

    private function generatePhoneId($phone) {
        $longref =  md5(time() . $phone . time() .uniqid());
        $ref = strtoupper(substr(str_shuffle($longref),0,16));
        return $ref;
    }

    private function generateRandomCode() {
        return mt_rand(100000,999999);
    }

    public function getErrors($type) {
        return $this -> errors[$type];
    }
}



?>
