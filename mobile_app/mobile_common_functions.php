<?php
class MobileCommonClass {

    function adduser($name, $email, $mobile,$password) {
        //Save data into users table
        global $conn;
        $created_at = date("Y-m-d h:i:s");
        $sqlIns = "INSERT INTO users (user_name,user_email,user_mobile,user_password,created_at) VALUES ('$name','$email','$mobile','$password','$created_at')";
        if ($conn->query($sqlIns) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    function checkAuthKey($auth_key) {
        global $conn;
        $getSel ="SELECT auth_key FROM mobile_app_auth WHERE auth_key = '$auth_key' ";
        $res = $conn->query($getSel);
        return $res->num_rows;
    }

    function checkIpExists($user_mobile) {
        global $conn;
        $getSel ="SELECT mobile_imei_address FROM users WHERE user_mobile = '$user_mobile' ";
        $res = $conn->query($getSel);
        return $res->num_rows;
    }

    function getRecentRecordsWithLimit($t_name,$status,$start_limit,$end_limit,$clause) {
        global $conn;
        $getSel ="SELECT * FROM `$t_name` WHERE status = '$status' ORDER BY '$clause' DESC LIMIT $start_limit,$end_limit ";
        $result = $conn->query($getSel);         
        return $result;
    }

    function getAllProductsData($t_name,$status) {
        global $conn;
        $getSel ="SELECT * FROM `$t_name` WHERE status = '$status' ORDER BY id DESC ";
        $result = $conn->query($getSel);         
        return $result;
    }

    function getMobileIndividualDetails($id,$table,$clause) {
        global $conn;
        $sql="select * from `$table` where `$clause` = '$id' ";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();        
        return $row;
    }

    function checkUserExists($email,$mobile,$status) {
        global $conn;
        if($status!='' && $status!=NULL) {
            $code_check = "SELECT * from users WHERE user_email = '$email' OR user_mobile = '$mobile' AND status='$status' ";
        } else {
            $code_check = "SELECT * from users WHERE user_email = '$email' OR user_mobile = '$mobile' ";
        }
        //echo $code_check; die;
        $result = $conn->query($code_check);
        return $result->num_rows;
    }

}

?>